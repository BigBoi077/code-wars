<?php

namespace Models\Entities;

use Models\Brokers\PersonBroker;
use Models\Brokers\StudentBroker;
use Models\Brokers\UserBroker;
use Zephyrus\Application\Form;
use Zephyrus\Application\Rule;

class Student
{
    private bool $success = false;
    private Form $form;
    private $errorMessages;

    public static function create(Form $form): Student
    {
        $instance = new self();
        $instance->form = $form;
        if ($instance->areFieldsValid()) {
            $instance->insert();
        }
        return $instance;
    }

    public function getErrorMessages()
    {
        return $this->errorMessages;
    }

    public function hasSucceeded(): bool
    {
        return $this->success;
    }

    private function areFieldsValid(): bool
    {
        $this->form->validate('da', Rule::integer('Le DA doit etre un nombre.'));
        $this->form->validate('da', Rule::maxLength(6, 'Le DA doit contenir 6 chiffres'));
        $this->form->validate('da', Rule::minLength(6, 'Le DA doit contenir 6 chiffres'));
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
        if ((new UserBroker())->findByDa($this->form->getValue('da')) != null) {
            $this->errorMessages = 'Le DA est deja utilise.';
            return false;
        }
        $this->success = true;
        return true;
    }

    private function insert()
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
    }

}