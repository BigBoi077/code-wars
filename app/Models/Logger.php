<?php


namespace Models;

use Controllers\Controller;
use Models\Brokers\PersonBroker;
use Models\Brokers\UserBroker;
use Zephyrus\Application\Form;
use Zephyrus\Application\Rule;
use Zephyrus\Application\Session;


class Logger
{
    const INPUT_NAME_DA = 'da';
    const INPUT_NAME_PASSWORD = 'password';

    private $user;
    private $person;
    private $success = false;
    private $errorMessages;

    public function __construct(Form $form)
    {
        $form->validate(self::INPUT_NAME_DA, Rule::integer('Le DA doit etre un chiffre'));
        $form->validate(self::INPUT_NAME_PASSWORD, Rule::notEmpty('Le mot de passe est requis'));
        if ($form->verify()) {
            $this->process($form->getValue(self::INPUT_NAME_DA), $form->getValue(self::INPUT_NAME_PASSWORD));
        } else {
            $this->errorMessages = $form->getErrorMessages();
        }
    }

    private function process($da, $password)
    {
        $userBroker = new UserBroker();
        $personBroker = new PersonBroker();
        $this->user = $userBroker->findByDa($da);
        if ($this->user != null) {
            $this->success = password_verify($password . PASSWORD_PEPPER, $this->user->password);
            $this->person = $personBroker->findByDa($da);
        }
    }

    public function hasSucceeded() : bool
    {
        return $this->success;
    }

    public function logUser()
    {
        Session::getInstance()->set(Controller::SESSION_IS_LOGGED, true); //TODO IS_LOGGED dans un Constants.php ?
        Session::getInstance()->set('user', [
            'da' => $this->person->da,
            'firstname' => $this->person->firstname,
            'lastname' => $this->person->lastname,
        ]);
    }

    public function getErrorMessage(): array
    {
        return $this->errorMessages;
    }


}