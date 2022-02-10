<?php namespace Controllers;

class AboutController extends Controller
{
    public function initializeRoutes()
    {
        $this->get('/about', 'index');
    }

    public function index()
    {
        return $this->render("about");
    }
}
