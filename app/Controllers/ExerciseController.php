<?php

namespace Controllers;

use Models\Brokers\ExerciseBroker;
use Models\Services\ExerciseService;
use Zephyrus\Application\Flash;
use function PHPUnit\Framework\isEmpty;

class ExerciseController extends Controller
{
    public function initializeRoutes()
    {
        $this->get('/exercises', 'exercises');
        $this->get('/exercises/{id}', 'exerciseDetail');
        $this->post('/submit/exercise/{id}', 'exerciseUpload');
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

    public function exerciseDetail($id)
    {
        return $this->render('exercises/exercise_details', [
            'exercise' => ExerciseService::get($id),
            'action' => "/submit/exercise/" . $id,
            'submitted' => (new ExerciseBroker())->isSubmitted($id, $this->getActiveStudent()->da)
        ]);
    }

    public function exerciseUpload($id)
    {
        $form = $this->buildForm();

        $targetDir = getcwd().DIRECTORY_SEPARATOR . "uploads/" . str_replace([' ', '_'], '', $form->getValue("exerciseName")) . "_user" . $this->getUser()['id'] . "_";
        $targetFile = $targetDir . basename($this->request->getFile("exercise")["name"]);

        if (file_exists($targetFile) || (new ExerciseBroker())->isSubmitted($id, $this->getActiveStudent()->da)) { //todo on veut pouvoir envoyer le fichier plus dune fois ?
            Flash::error("Vous avez déja remis cette mission");
            return $this->redirect('/exercises/' . $id);
        }

        if ($this->request->getFile("exercise")["name"] == '') {
            Flash::error("Aucun fichier selectionné!");
            return $this->redirect('/exercises/' . $id);
        }

        $fileType = strtolower(pathinfo($targetFile,PATHINFO_EXTENSION));
        if($fileType != "zip" && $fileType != "rar" && $fileType != "7zip" && $fileType != "java" ) {
            Flash::warning("Type de fichier non accepté");
            return $this->redirect('/exercises/' . $id);
        }

        if (move_uploaded_file($this->request->getFile("exercise")["tmp_name"], $targetFile)) {
            Flash::success("La mission à bel et bien été remis");
            (new ExerciseBroker())->submitExercise($this->getActiveStudent(), $id, $targetFile);
            return $this->redirect('/exercises/' . $id);
        }

        Flash::error("Une erreur s'est passé. Votre fichier n'a pas été remis");
        return $this->redirect('/exercises/' . $id);
    }
}
