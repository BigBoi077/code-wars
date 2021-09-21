<?php namespace Controllers;

use Models\Logger;
use Zephyrus\Application\Flash;

class AuthenticationController extends Controller
{


    public function initializeRoutes()
    {
        $this->get('/login', 'showLogin');
        $this->post('/login', 'processLogin');

        $this->post('/logout', 'logout');
    }

    public function showLogin()
    {
        if ($this->isLogged()) {
            return $this->redirect('/');
        }
        return $this->render('temp_login');
    }

    public function processLogin()
    {
        $logger = new Logger($this->buildForm());
        if ($logger->hasSucceeded()) {
            $logger->logUser();
            return $this->redirect('/');
        }
        Flash::error($logger->getErrorMessage());
        return $this->redirect('/login');
    }

    public function logout()
    {
        session_destroy();
        return $this->redirect('/');
    }
}
