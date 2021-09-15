<?php namespace Controllers;

class ExampleController extends Controller
{
    public function initializeRoutes()
    {
        $this->get("/", "index");
    }

    public function index()
    {
        return $this->html("Test2");
    }
}
