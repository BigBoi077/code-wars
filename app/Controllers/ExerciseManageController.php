<?php namespace Controllers;

use Models\Brokers\ExerciseBroker;
use Models\Brokers\WeekBroker;
use Models\Services\ExerciseService;
use Zephyrus\Application\Flash;
use Zephyrus\Network\Response;

class ExerciseManageController extends TeacherController
{

    public function initializeRoutes()
    {
        $this->get('/management/exercises', 'listExercises');
        $this->get('/management/exercises/create', 'createExercise');
        $this->get('/management/exercises/{id}/edit', 'editExercise');
        $this->get('/management/exercises/{id}/delete', 'deleteExercise');
        $this->post('/management/exercises/store', 'storeExercise');
        $this->post('/management/exercises/{id}/update', 'updateExercise');
    }

    public function listExercises(): Response
    {
        $exercises = (new ExerciseBroker())->getAll();
        return $this->render('management/exercises/exercises_listing', [
            'exercises' => $exercises,
            'student' => null,
            'difficulties' => [1 => "Très Facile", 2 => "Facile", 3 => "Moyen", 4 => "Difficile", 5 => "Très Difficile"]
        ]);
    }

    public function createExercise()
    {
        return $this->render('management/exercises/exercises_form', [
            'title' => 'Créer un exercice',
            'action' => '/management/exercises/store',
            'exercise' => null,
            'weeks' => ((new WeekBroker())->getAll()),
            'difficulties' => [1 => "Très Facile", 2 => "Facile", 3 => "Moyen", 4 => "Difficile", 5 => "Très Difficile"]
        ]);
    }

    public function editExercise($id)
    {
        return $this->render('management/exercises/exercises_form', [
            'title' => 'Modifier un exercice',
            'action' => '/management/exercises/' . $id . '/update',
            'exercise' => (new ExerciseBroker())->findByID($id),
            'weeks' => (new WeekBroker())->getAll(),
            'difficulties' => [1 => "Très Facile", 2 => "Facile", 3 => "Moyen", 4 => "Difficile", 5 => "Très Difficile"]
        ]);
    }

    public function updateExercise($id)
    {
        $exercise = ExerciseService::update($id, $this->buildForm());
        if ($exercise->hasSucceeded()) {
            Flash::success('Exercice mis à jour avec succès!');
            return $this->redirect('/management/exercises');
        }
        Flash::error($exercise->getErrorMessages());
        return $this->redirect('/management/exercises/' . $id . '/update');

    }

    public function storeExercise()
    {
        $exercise = ExerciseService::create($this->buildForm());
        if ($exercise->hasSucceeded()) {
            Flash::success('Exercice créé avec succès!');
            return $this->redirect('/management/exercises');
        }
        Flash::error($exercise->getErrorMessages());
        return $this->redirect('/management/exercises/create');
    }

    public function deleteExercise($id)
    {
        if (ExerciseService::exists($id)) {
            ExerciseService::delete($id);
            Flash::success('Exercice supprimé avec succès!');
        } else {
            Flash::error('Une erreur est survenue.');
        }
        return $this->redirect('/management/exercises');
    }

}
