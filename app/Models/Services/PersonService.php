<?php namespace Models\Services;

use Models\Brokers\PersonBroker;
use Models\Brokers\UserBroker;
use Models\SessionHelper;
use Zephyrus\Application\Form;
use Zephyrus\Application\Rule;

class PersonService
{
    private $success = false;
    private Form $form;
    private $errorMessages;

    public static function update($da,Form $form): PersonService
    {
        $instance = new self();
        $instance->form = $form;
        if ($instance->applyRules()) {
            $instance->updateToDatabase($da);
        }
        return $instance;
    }

    public static function get($da): \stdClass
    {
        return (new PersonBroker())->findByDa($da);
    }

    public function getErrorMessages()
    {
        return $this->errorMessages;
    }

    public function hasSucceeded(): bool
    {
        return $this->success;
    }

    private function applyRules(): bool
    {
        $this->form->validate('username', Rule::notEmpty('Le nom d\'utilisateur est requis.'));
        if ($this->form->getValue('email') != '') {
            $this->form->validate('email', Rule::email('Le format du e-mail est invalide.'));
        } else {
            $this->form->validate('email', Rule::notEmpty('Le e-mail est requis.'));
        }
        if ($this->form->getValue('password') != '') {
            $this->form->validate('password', Rule::passwordCompliant('Le mot de passe doit contenir une minuscule, une majuscule, un chiffre et avoir une longueur minimum de 8 caractères.'));
            if ($this->form->getValue('confirmPassword') != '') {
                $this->form->validate('confirmPassword', Rule::sameAs('password', 'La confirmation de mot de passe doit être identique au mot de passe.'));
            } else {
                $this->form->validate('confirmPassword', Rule::notEmpty('La confirmation de mot de passe est requise.'));
            }
        }

        if (!$this->form->verify()) {
            $this->errorMessages = $this->form->getErrorMessages();
            return false;
        }
        return true;
    }

    private function updateToDatabase($da)
    {
        $username = $this->form->getValue('username');
        $person = self::get($da);
        $email = $this->form->getValue('email');
        (new PersonBroker())->update($da, $username, $person->firstname, $person->lastname, $email);
        SessionHelper::setUser((new UserBroker())->findByDa($da)->id, (new PersonBroker())->findByDa($da));
        $this->success = true;
    }
}