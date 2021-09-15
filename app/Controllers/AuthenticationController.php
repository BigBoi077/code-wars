<?php namespace Controllers;

class AuthenticationController extends Controller
{
    public function initializeRoutes()
    {
        $this->get("/login", "login");
    }

    public function login()
    {
        return $this->html("This is the login");
    }
}
