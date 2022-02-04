<?php namespace Controllers;


class ErrorController extends Controller
{

    public function initializeRoutes()
    {
        $this->get("/error/404", "index");
        $this->get("/error/413", "liftFatBoy");
    }

    public function index()
    {
        return $this->render("errors/404");
    }

    public function liftFatBoy()
    {
        return $this->render("errors/413");
    }
}