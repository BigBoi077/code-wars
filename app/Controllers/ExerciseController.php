<?php

namespace Controllers;

use Models\Services\StudentService;

class ExerciseController extends Controller
{

    public function initializeRoutes()
    {
        $this->get('/exercises', 'exercises');
    }

    public function exercises()
    {
        return $this->render('exercises', [
        ]);
    }
}