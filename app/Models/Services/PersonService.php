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

    public static function update($da, Form $form): PersonService
    {
        $instance = new self();
        $instance->form = $form;
        if ($instance->applyRules($da)) {
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

    private function applyRules($da): bool
    {
        $this->form->validate('username', Rule::regex("[-@.\/#&+\w]*", 'Le nom d\'utilisateur doit être des lettres, chiffres ou charactères spéciaux.'));
        $this->form->validate('username', Rule::maxLength(20, 'Le nom d\'utilisateur doit être de maximum 20 caractères.'));
        if ($this->form->getValue('email') != '') {
            $this->form->validate('email', Rule::email('Le format du courriel est invalide.'));
        } else {
            $this->form->validate('email', Rule::notEmpty('Le courriel est requis.'));
        }
        if ((new PersonBroker())->findByUsername($da, $this->form->getValue('username')) != null) {
            $this->errorMessages = "Ce nom d'utilisateur est déjà pris par un autre élève.";
            return false;
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
