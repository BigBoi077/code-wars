<?php

namespace Controllers;

use Models\Services\ExerciseService;

class ExerciseController extends Controller
{

    public function initializeRoutes()
    {
        $this->get('/exercises', 'exercises');
        $this->get('/exercises/id', 'exerciseDetail');
    }

    public function exercises()
    {
        return $this->render('exercises', [
            'exercises' => ExerciseService::getAll(),
        ]);
    }

    public function exerciseDetail()
    {
        return $this->render('singleExercise', []);
    }
}