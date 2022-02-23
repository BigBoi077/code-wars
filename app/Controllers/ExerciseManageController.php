<?php namespace Controllers;

use Models\Brokers\ExerciseBroker;
use Models\Brokers\WeekBroker;
use Models\Helpers\ImageUploader;
use Models\Services\ExerciseService;
use Models\Services\ImageExampleService;
use phpDocumentor\Reflection\DocBlock\Tags\Formatter;
use phpDocumentor\Reflection\Types\Iterable_;
use phpDocumentor\Reflection\Types\This;
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

        $this->overrideExercise();
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
        $weeks = ((new WeekBroker())->getAll());

        if (count($weeks) == 0) {
            Flash::error("Vous devez d'abord créer une semaine avant de créer une exercice");
            return $this->redirect("/management/exercises");
        }

        return $this->render('management/exercises/exercises_form', [
            'title' => 'Créer un exercice',
            'action' => '/management/exercises/store',
            'exercise' => null,
            'weeks' => $weeks,
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
            Flash::success('Mission mise à jour avec succès!');
            return $this->redirect('/management/exercises');
        }
        Flash::error($exercise->getErrorMessages());
        return $this->redirect('/management/exercises/' . $id . '/edit');
    }

    public function storeExercise()
    {
        $form = $this->buildForm();

        $exercise = ExerciseService::create($form);

        if ($exercise->hasSucceeded()) {
            if ($this->hasImageUpload($form)) {
                $exerciseId = $exercise->getInsertId();
                $images = ImageExampleService::create($form, $exerciseId);

                if (!$images->hasSucceeded()) {
                    Flash::error($images->getErrorMessages());
                    return $this->redirect('/management/exercises');
                }
            }

            Flash::success('Mission créée avec succès!');
            return $this->redirect('/management/exercises');
        }

        Flash::error($exercise->getErrorMessages());
        return $this->redirect('/management/exercises/create');
    }

    private function hasImageUpload($form)
    {
        return $form->getValue('imageExamples')['name'][0] != '';
    }

    public function deleteExercise($id)
    {
        if (ExerciseService::exists($id)) {
            ExerciseService::delete($id);
            Flash::success('Mission supprimée avec succès!');
        } else {
            Flash::error('Une erreur est survenue.');
        }
        return $this->redirect('/management/exercises');
    }

    private function overrideExercise()
    {
        $this->overrideArgument('id', function ($value) {
            if (is_numeric($value)) {
                $exercise = ExerciseService::get($value);
                if (is_null($exercise)) {
                    return $this->redirect('/management/exercises');
                }
                return $exercise->id;
            } else {
                return $this->redirect('/management/exercises');
            }
        });
    }
}
