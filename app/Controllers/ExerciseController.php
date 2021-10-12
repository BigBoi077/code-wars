<?php

namespace Controllers;

use Models\Services\ExerciseService;
use Zephyrus\Network\Response;

class ExerciseController extends Controller
{

    public function initializeRoutes()
    {
        $this->get('/exercises', 'exercises');
        $this->get('/exercises/{id}', 'exerciseDetail');
    }

    public function exercises()
    {
        return $this->render('exercises/exercises_listing', [
            'exercises' => ExerciseService::getAll()
        ]);
    }

    public function exerciseDetail($id): Response
    {
        return $this->render('exercises/exercise_details', [
            'exercise' => ExerciseService::get($id)
        ]);
    }
}