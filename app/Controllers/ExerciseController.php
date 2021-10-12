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
        $exercises = ExerciseService::getAll();
        $exercisesByWeek = [];
        foreach ($exercises as $exercise) {
            if ($exercise->is_active) {
                $exercisesByWeek[$exercise->week_id]['number'] = $exercise->number;
                $exercisesByWeek[$exercise->week_id]['startDate'] = $exercise->start_date;
                $exercisesByWeek[$exercise->week_id][$exercise->id] = $exercise;
            }
        }
        return $this->render('exercises/exercises_listing', [
            'exercisesByWeek' => $exercisesByWeek
        ]);
    }

    public function exerciseDetail($id): Response
    {
        return $this->render('exercises/exercise_details', [
            'exercise' => ExerciseService::get($id)
        ]);
    }
}