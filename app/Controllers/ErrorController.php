<?php namespace Controllers;


class ErrorController extends Controller
{

    public function initializeRoutes()
    {
        $this->get("/error/404", "index");
    }

    public function index()
    {
        return $this->render("errors/404");
    }

    public function chooseAName()
    {
        return $this->render("errors/413");
    }
}