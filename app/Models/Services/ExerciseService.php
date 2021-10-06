<?php

namespace Models\Services;

use Models\Brokers\ExerciseBroker;
use Models\Brokers\TipBroker;
use Models\Brokers\WeekBroker;
use Zephyrus\Application\Form;
use Zephyrus\Application\Rule;

class ExerciseService
{
    private $succes = false;
    private Form $form;
    private $errorMessages;

    public static function create(Form $form): ExerciseService
    {
        $instance = new self();
        $instance->form = $form;
        if ($instance->areFieldsValid()){
            $instance->insertToDatabase();
        }
        return $instance;
    }


    public static function update($id, Form $form): ExerciseService
    {
        $instance = new self();
        $instance->form = $form;
        if ($instance->areFieldsValid()) {
            $instance->updateToDatabase($id);
        }
        return $instance;
    }

    public static function delete($id)
    {
        /* TODO: Pop-up confirmation suppression d'exercise + mot de passe enseignant */
        (new WeekBroker())->delete($id);
        (new TipBroker())->delete($id);
        (new ExerciseBroker())->delete($id);

    }

    public static function exists($id): bool
    {
        return (new ExerciseBroker())->findByID($id) != null;
    }

    public function getErrorMessages()
    {
        return $this->errorMessages;
    }

    public function hasSucceeded(): bool
    {
        return $this->succes;
    }

    private function areFieldsValid(): bool
    {
        if (!$this->applyRules()) {
            return false;
        }
        return true;
    }

    private function applyRules(): bool
    {
        $this->form->validate('exercisename', Rule::notEmpty('Le nom est requis.'));
        $this->form->validate('description', Rule::notEmpty('La description est requise.'));
        $this->form->validate('exemple', Rule::notEmpty('L\'exemple d\'execution est requis.'));
        $this->form->validate('date', Rule::notEmpty('La date est requise.'));

        if ($this->form->getValue('cash') != "") {
            $this->form->validate('cash', Rule::integer('L\'argent doit etre un chiffre'));
        }
        if ($this->form->getValue('point') != "") {
            $this->form->validate('point', Rule::integer('Les points doivent etre un chiffre'));
        }
        if ($this->form->getValue('difficulty') != "") {
            $this->form->validate('difficulty', Rule::integer('La difficulté doit etre un chiffre'));
        }
        $this->form->isRegistered('activate');
        if (!$this->form->verify()) {
            $this->errorMessages = $this->form->getErrorMessages();
            return false;
        }
        return true;
    }

    private function insertToDatabase()
    {
        $exercisename = $this->form->getValue('exercisename');
        $difficulty = $this->form->getValue('difficulty');
        $description = $this->form->getValue('description');
        $exemple = $this->form->getValue('exemple');
        $date = $this->form->getValue('date');
        $tips = ($this->form->getValue('tips') != "") ? $this->form->getValue('tips') : "Aucun Conseil";
        $point = ($this->form->getValue('point') != "") ? $this->form->getValue('point') : 0;
        $cash = ($this->form->getValue('cash') != "") ? $this->form->getValue('cash') : 0;
        if($this->form->isRegistered('activate'))
        {
            $isActive = "true";
        } else {
            $isActive = "false";
        }
        $id = (new ExerciseBroker())->insert($exercisename,$difficulty,$description,$exemple,$cash,$point);
        (new TipBroker())->insert($id, $tips);
        (new WeekBroker())->insert($id, $date,$isActive);
        $this->succes = true;
    }

    //TODO: A faire
    private function updateToDatabase($id)
    {
        /*
        $firstname = $this->form->getValue('firstname');
        $lastname = $this->form->getValue('lastname');
        $team_id = $this->form->getValue('team_id');
        $cash = ($this->form->getValue('cash') != "") ? $this->form->getValue('cash') : 0;
        (new PersonBroker())->update($da, $firstname, $lastname);
        (new StudentBroker())->update($da, $team_id, $cash);
        */



        $this->succes = true;
    }
}

