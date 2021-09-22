<?php


namespace Models;

use Controllers\Controller;
use Models\Brokers\Broker;
use Models\Brokers\PersonBroker;
use Models\Brokers\TokenBroker;
use Models\Brokers\UserBroker;
use Zephyrus\Application\Form;
use Zephyrus\Application\Rule;
use Zephyrus\Application\Session;
use Zephyrus\Network\Cookie;
use Zephyrus\Security\Cryptography;


class Logger
{
    const INPUT_NAME_DA = 'da';
    const INPUT_NAME_PASSWORD = 'password';

    private $user;
    private $person;
    private $success = false;
    private $errorMessages;


    public function loginWithForm(Form $form)
    {
        $form->validate(self::INPUT_NAME_DA, Rule::integer('Le DA doit etre un chiffre'));
        $form->validate(self::INPUT_NAME_PASSWORD, Rule::notEmpty('Le mot de passe est requis'));
        if ($form->verify()) {
            $this->tryCredentials($form);
        } else {
            $this->errorMessages = $form->getErrorMessages();
        }
    }

    private function tryCredentials($form)
    {
        $userBroker = new UserBroker();
        $personBroker = new PersonBroker();
        $this->user = $userBroker->findByDa($form->getValue(self::INPUT_NAME_DA));
        if ($this->user != null) {
            $this->success = password_verify($form->getValue(self::INPUT_NAME_PASSWORD) . PASSWORD_PEPPER, $this->user->password);
            $this->person = $personBroker->findByDa($form->getValue(self::INPUT_NAME_DA));
            if ($form->isRegistered('remember_me') && $this->success) {
                $this->rememberUser();
            }
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
            'id' => $this->user->id,
            'da' => $this->person->da,
            'firstname' => $this->person->firstname,
            'lastname' => $this->person->lastname,
        ]);
    }

    public function getErrorMessage(): ?array
    {
        return $this->errorMessages;
    }

    private function rememberUser()
    {
        $tokenValue = Cryptography::randomString(32);
        $cookie = new Cookie(REMEMBER_ME);
        $cookie->setValue($tokenValue);
        $cookie->setLifetime(Cookie::DURATION_MONTH);
        $cookie->send();
        $tokenBroker = new TokenBroker();
        $tokenBroker->insert($this->user->id, $tokenValue);
    }


    public function automaticLogin(): bool
    {
        $tokenBroker = new TokenBroker();
        $userBroker = new UserBroker();
        $personBroker = new PersonBroker();

        $user_id = $tokenBroker->findUserIdByToken($_COOKIE[REMEMBER_ME]);
        if ($user_id == null) {
            $this->destroyRememberMeToken();
            return false;
        }
        $this->user = $userBroker->findByID($user_id);
        $this->person = $personBroker->findByDa($this->user->da);
        $this->logUser();
        return true;
    }

    public function destroyRememberMeToken()
    {
        setcookie(REMEMBER_ME, '', 1, '/');
        unset($_COOKIE[REMEMBER_ME]);
    }

}