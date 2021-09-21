<?php


namespace Controllers;



class HomeController extends Controller
{

    public function initializeRoutes()
    {
        $this->get('/', 'index');
        $this->get('/home', 'home');
    }

    public function index()
    {
        return ($this->isLogged()) ? $this->redirect('/home') : $this->redirect('/login');
    }

    public function home()
    {
        if (!$this->isLogged()) {
            return $this->redirect('/');
        }
        return $this->render('temp_home', ['user' => $this->getUser()]);
    }
}