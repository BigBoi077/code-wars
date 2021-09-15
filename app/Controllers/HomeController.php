<?php


namespace Controllers;


class HomeController extends Controller
{

    public function initializeRoutes()
    {
        $this->get('/', 'index');
    }

    public function index()
    {
        return ($this->isLogged()) ? $this->redirect('home') : $this->redirect('login');
    }
}