<?php

namespace Models\Services;

use Models\Brokers\ExerciseBroker;
use Models\Brokers\TipBroker;
use Models\Brokers\WeekBroker;
use Zephyrus\Application\Form;
use Zephyrus\Application\Rule;
use function PHPUnit\Framework\isEmpty;

class ExerciseService
{
    private $succes = false;
    private Form $form;
    private $errorMessages;

    public static function getAll()
    {
        return (new ExerciseBroker())->getAll();
    }

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
        (new TipBroker())->delete($id);
        (new ExerciseBroker())->delete($id);

    }

    public static function exists($id): bool
    {
        return (new ExerciseBroker())->findByID($id) != null;
    }

    public static function get($id)
    {
        $broker = new ExerciseBroker();
        return $broker->findByID($id);
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
        $this->form->validate('description', Rule::notEmpty('La description est requise'));
        $this->form->validate('cash', Rule::integer('L\'argent doit etre un chiffre'));
        $this->form->validate('point', Rule::integer('Les points doivent etre un chiffre'));
        $this->form->validate('difficulty', Rule::integer('La difficulté doit spécifié'));
        if (!$this->form->verify()) {
            $this->errorMessages = $this->form->getErrorMessages();
            return false;
        }
        return true;
    }

    private function insertToDatabase()
    {
        $exerciseName = $this->form->getValue('exercisename');
        $difficulty = $this->form->getValue('difficulty');
        $description = $this->form->getValue('description');
        $exemple = $this->form->getValue('exemple');
        $tips = (isEmpty($this->form->getValue('tips'))) ? $this->form->getValue('tips') : null;
        $point = ($this->form->getValue('point') != "") ? $this->form->getValue('point') : 0;
        $cash = ($this->form->getValue('cash') != "") ? $this->form->getValue('cash') : 0;
        $weekId = $this->form->getValue("week");
        $exerciseId = (new ExerciseBroker())->insert($exerciseName,$difficulty,$description,$exemple, $cash, $point, $weekId);
        if ($tips != null) {
            (new TipBroker())->insert($exerciseId, $tips);
        }
        NotificationService::newExerciseAvailable($exerciseName);
        $this->succes = true;
    }

    //TODO: A faire
    private function updateToDatabase($id)
    {
        $exerciseName = $this->form->getValue('exercisename');
        $difficulty = $this->form->getValue('difficulty');
        $description = $this->form->getValue('description');
        $exemple = $this->form->getValue('exemple');
        $point = ($this->form->getValue('point') != "") ? $this->form->getValue('point') : 0;
        $cash = ($this->form->getValue('cash') != "") ? $this->form->getValue('cash') : 0;
        $weekId = $this->form->getValue("week");
        (new ExerciseBroker())->update($id, $exerciseName, $difficulty, $description, $exemple, $cash, $point, $weekId);


        $this->succes = true;
    }
}

