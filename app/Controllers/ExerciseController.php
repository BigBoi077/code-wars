<?php

namespace Controllers;

use Models\Services\ExerciseService;

class ExerciseController extends Controller
{
    public function initializeRoutes()
    {
        $this->get('/exercises', 'exercises');
        $this->get('/exercises/{id}', 'exerciseDetail');
        $this->post('/submit/exercise', 'exerciseUpload');
    }

    public function exercises()
    {
        return $this->render('exercises/exercises_listing', [
            'exercises' => ExerciseService::getAll()
        ]);
    }

    public function exerciseDetail($id)
    {
        return $this->render('exercises/exercise_details', [
            'exercise' => ExerciseService::get($id)
        ]);
    }

    public function exerciseUpload()
    {
        echo "yo";
        $form = $this->buildForm();
        echo "yo";
        var_dump($this->request->getFile("exercise"));
        var_dump($form->buildObject());
        die();
    }
}
