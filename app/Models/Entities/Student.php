<?php

namespace Models\Entities;

use Exception;
use Models\Brokers\PersonBroker;
use Models\Brokers\StudentBroker;
use Models\Brokers\TeamBroker;
use Models\Brokers\UserBroker;
use Zephyrus\Application\Form;
use Zephyrus\Application\Rule;

class Student
{
    private $succes = false;
    private Form $form;
    private $errorMessages;

    public static function create(Form $form): Student
    {
        $instance = new self();
        $instance->form = $form;
        if ($instance->areFieldsValid() && $instance->isDaAvailable()) {
            $instance->insertToDatabase();
        }
        return $instance;
    }


    public static function update($da, Form $form): Student
    {
        $instance = new self();
        $instance->form = $form;
        if ($instance->areFieldsValid()) {
            $instance->updateToDatabase($da);
        }
        return $instance;
    }

    public static function delete($da)
    {
        (new StudentBroker())->delete($da);
        (new UserBroker())->delete($da);
        (new PersonBroker())->delete($da);
    }

    public static function exists($da): bool
    {
        return (new StudentBroker())->findByDa($da) != null;
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
        if (!$this->isTeamValid()) {
            return false;
        }
        return true;
    }

    private function applyRules(): bool
    {
        if ($this->form->isRegistered('da')) {
            $this->form->validate('da', Rule::integer('Le DA doit etre un nombre.'));
            $this->form->validate('da', Rule::maxLength(7, 'Le DA doit contenir 7 chiffres'));
            $this->form->validate('da', Rule::minLength(7, 'Le DA doit contenir 7 chiffres'));
        }
        $this->form->validate('firstname', Rule::notEmpty('Le prenom est requis.'));
        $this->form->validate('lastname', Rule::notEmpty('Le nom est requis.'));
        $this->form->validate('team_id', Rule::integer('Equipe non valide'));
        if ($this->form->getValue('cash') != "") {
            $this->form->validate('cash', Rule::integer('L\'argent doit etre un chiffre'));
        }
        if (!$this->form->verify()) {
            $this->errorMessages = $this->form->getErrorMessages();
            return false;
        }
        return true;
    }

    private function isDaAvailable(): bool
    {
        if ((new UserBroker())->findByDa($this->form->getValue('da')) != null) {
            $this->errorMessages = 'Le DA est deja utilise.';
            return false;
        }
        return true;
    }

    private function isTeamValid()
    {
        if (!(new TeamBroker())->findById($this->form->getValue('team_id'))) {
            $this->errorMessages = 'Équipe invalide.';
            return false;
        }
        return true;
    }

    private function insertToDatabase()
    {
        $da = $this->form->getValue('da');
        $firstname = $this->form->getValue('firstname');
        $lastname = $this->form->getValue('lastname');
        $password = password_hash($this->form->getValue('da') . 'Cegep' . PASSWORD_PEPPER, PASSWORD_DEFAULT);
        $team_id = $this->form->getValue('team_id');
        $cash = ($this->form->getValue('cash') != "") ? $this->form->getValue('cash') : 0;
        (new PersonBroker())->insert($da, $firstname, $lastname);
        (new UserBroker())->insert($da, $password);
        (new StudentBroker())->insert($da, $team_id, $cash);
        $this->succes = true;
    }

    private function updateToDatabase($da)
    {
        $firstname = $this->form->getValue('firstname');
        $lastname = $this->form->getValue('lastname');
        $team_id = $this->form->getValue('team_id');
        $cash = ($this->form->getValue('cash') != "") ? $this->form->getValue('cash') : 0;
        (new PersonBroker())->update($da, $firstname, $lastname);
        (new StudentBroker())->update($da, $team_id, $cash);
        $this->succes = true;
    }


}