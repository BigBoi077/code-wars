<?php namespace Models\Services;

use Models\Brokers\ExerciseBroker;
use Models\Brokers\ItemBroker;
use Models\Brokers\NotificationBroker;
use Models\Brokers\PersonBroker;
use Models\Brokers\StudentBroker;
use Models\Brokers\TeamBroker;
use Models\Brokers\TipBroker;
use Models\Brokers\TransactionBroker;
use Models\Brokers\UserBroker;
use stdClass;
use Zephyrus\Application\Form;
use Zephyrus\Application\Rule;

class StudentService
{
    private $success = false;
    private Form $form;
    private $errorMessages;

    public static function create(Form $form): StudentService
    {
        $instance = new self();
        $instance->form = $form;
        if ($instance->areFieldsValid() && $instance->isDaAvailable()) {
            $instance->insertToDatabase();
        }
        return $instance;
    }

    public static function update($da, Form $form): StudentService
    {
        $instance = new self();
        $instance->form = $form;
        if ($instance->areFieldsValid()) {
            $instance->updateToDatabase($da);
        }
        return $instance;
    }

    public static function get($da): ?stdClass
    {
        return (new StudentBroker())->findByDa($da);
    }

    public static function getAll()
    {
        return (new StudentBroker())->getAll();
    }

    public static function delete($da)
    {
        $studentBroker = new StudentBroker();
        (new ItemBroker())->deleteAllFor($da);
        (new TransactionBroker())->deleteAllFor($studentBroker->findByDa($da)->id);
        (new NotificationBroker())->deleteAllFor($studentBroker->findByDa($da)->id);
        (new TipBroker())->deleteAllFor($da);
        (new ExerciseBroker())->deleteAllFor($da);
        $studentBroker->delete($da);
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
        return $this->success;
    }

    public static function hasItem($da): bool
    {
        return (new StudentBroker())->hasItem($da);
    }

    private function areFieldsValid(): bool
    {
        return $this->applyRules() && $this->isTeamValid();
    }

    private function applyRules(): bool
    {
        if ($this->form->isRegistered('da')) {
            $this->form->validate('da', Rule::integer('Le DA doit être un nombre.'));
            $this->form->validate('da', Rule::maxLength(7, 'Le DA doit contenir 7 chiffres.'));
            $this->form->validate('da', Rule::minLength(7, 'Le DA doit contenir 7 chiffres.'));
        }
        $this->form->validate('firstname', Rule::notEmpty('Le prénom est requis.'));
        $this->form->validate('lastname', Rule::notEmpty('Le nom est requis.'));
        $this->form->validate('team_id', Rule::integer('L\'équipe n\'est pas valide.'));
        if ($this->form->getValue('cash') != "") {
            $this->form->validate('cash', Rule::integer('L\'argent doit être un chiffre valide.'));
        }
        if ($this->form->getValue('points') != "") {
            $this->form->validate('points', Rule::integer('Les points doit être un chiffre valide.'));
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
            $this->errorMessages = 'Le DA est déjà utilisé.';
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
        $username = $firstname . ' ' . $lastname;
        $password = password_hash($this->form->getValue('da') . PASSWORD_PEPPER, PASSWORD_DEFAULT);
        $team_id = $this->form->getValue('team_id');
        $cash = ($this->form->getValue('cash') != "") ? $this->form->getValue('cash') : 0;
        $points = ($this->form->getValue('points') != "") ? $this->form->getValue('points') : 0;
        (new PersonBroker())->insert($da, $username, $firstname, $lastname);
        (new UserBroker())->insert($da, $password);
        (new StudentBroker())->insert($da, $team_id, $cash, $points);
        $this->success = true;
    }

    private function updateToDatabase($da)
    {
        $username = StudentService::get($da)->username;
        $firstname = $this->form->getValue('firstname');
        $lastname = $this->form->getValue('lastname');
        $team_id = $this->form->getValue('team_id');
        $cash = ($this->form->getValue('cash') != "") ? $this->form->getValue('cash') : 0;
        $points = ($this->form->getValue('points') != "") ? $this->form->getValue('points') : 0;
        (new PersonBroker())->update($da, $username, $firstname, $lastname);
        (new StudentBroker())->update($da, $team_id, $cash, $points);
        $this->success = true;
    }
}
