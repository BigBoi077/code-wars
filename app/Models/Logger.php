<?php namespace Models;

use Models\Brokers\PersonBroker;
use Models\Brokers\TokenBroker;
use Models\Brokers\UserBroker;
use Zephyrus\Application\Form;
use Zephyrus\Application\Rule;
use Zephyrus\Network\Cookie;
use Zephyrus\Security\Cryptography;

class Logger
{
    const INPUT_NAME_DA = 'da';
    const INPUT_NAME_PASSWORD = 'password';

    private $user;
    private $success = false;
    private $errorMessages;

    public function loginWithForm(Form $form)
    {
        $form->validate(self::INPUT_NAME_DA, Rule::integer('Le DA doit etre un chiffre.'));
        $form->validate(self::INPUT_NAME_PASSWORD, Rule::notEmpty('Le mot de passe est requis.'));
        if ($form->verify()) {
            $this->success = $this->tryCredentials($form);
        } else {
            $this->errorMessages = $form->getErrorMessages();
        }
    }

    private function tryCredentials($form): bool
    {
        $userBroker = new UserBroker();
        $this->user = $userBroker->findByDa($form->getValue(self::INPUT_NAME_DA));
        if ($this->user != null) {
            if (password_verify($form->getValue(self::INPUT_NAME_PASSWORD) . PASSWORD_PEPPER, $this->user->password)) {
                if ($form->isRegistered('remember_me')) {
                    $this->rememberUser();
                }
                return true;
            }
        }
        $this->errorMessages = 'Identifiants incorrects';
        return false;
    }

    public function hasSucceeded(): bool
    {
        return $this->success;
    }

    public function logUser()
    {
        $person = (new PersonBroker())->findByDa($this->user->da);
        SessionHelper::setIsLogged();
        SessionHelper::setUser($this->user->id, $person);
    }

    public function getErrorMessage()
    {
        return $this->errorMessages;
    }

    private function rememberUser()
    {
        $tokenBroker = new TokenBroker();
        if ($tokenBroker->verifyUserActiveToken($this->user->id)) {
            $tokenBroker->deleteWithUserId($this->user->id);
        }
        $tokenValue = Cryptography::randomString(32);
        $cookie = new Cookie(REMEMBER_ME);
        $cookie->setValue($tokenValue);
        $cookie->setLifetime(Cookie::DURATION_MONTH);
        $cookie->send();
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
