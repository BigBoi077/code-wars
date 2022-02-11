<?php namespace Controllers;

use Zephyrus\Network\Response;

abstract class TeacherController extends Controller
{
    public function before(): ?Response
    {
        if (!$this->isUserTeacher()) {
            return $this->redirect("/error/404");
        }
        return parent::before();
    }
}
