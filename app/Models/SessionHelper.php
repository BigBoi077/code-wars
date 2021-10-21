<?php namespace Models;


use Controllers\Controller;
use Models\Brokers\UserBroker;
use Zephyrus\Application\Session;

class SessionHelper
{
    public static function setIsLogged()
    {
        Session::getInstance()->set(Controller::SESSION_IS_LOGGED, true);
    }

    public static function setUser($userId, $person)
    {
        Session::getInstance()->set('user', [
            'id' => $userId,
            'da' => $person->da,
            'username' => $person->username,
            'firstname' => $person->firstname,
            'lastname' => $person->lastname,
            'isTeacher' => (new UserBroker())->isTeacher($person->da)
        ]);
    }
}