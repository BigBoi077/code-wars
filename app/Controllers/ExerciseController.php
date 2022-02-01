<?php namespace Controllers;

use Models\Brokers\ExerciseBroker;
use Models\Brokers\FileBroker;
use Models\Brokers\StudentBroker;
use Models\Brokers\TipBroker;
use Models\Services\ExerciseService;
use Zephyrus\Application\Flash;
use Zephyrus\Security\Cryptography;
use function Composer\Autoload\includeFile;
use function PHPUnit\Framework\isEmpty;

class ExerciseController extends Controller
{
    public function initializeRoutes()
    {
        $this->get('/exercises', 'exercises');
        $this->get('/exercises/{id}', 'exerciseDetail');
        $this->get('/exercises/submit/{id}', 'exerciseSubmit');
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
        $weeklyProgress = null;
        $indProgress = null;
        if (!$this->isUserTeacher()) {
            $weeklyProgress = (new StudentBroker())->getProgressionByWeek($this->getActiveStudent()->da);
            $indProgress = (new StudentBroker())->getProgression($this->getActiveStudent()->da);
        }

        return $this->render('exercises/exercises_listing', [
            'exercisesByWeek' => $exercisesByWeek,
            'teamPoints' => TeamController::getTeamPoints(),
            'weeklyProgress' => $weeklyProgress,
            'individualProgress' => $indProgress,
        ]);
    }

    public function exerciseSubmit($id)
    {
        $exercise = ExerciseService::get($id);
        $broker = new ExerciseBroker();

        if ($broker->isCorrected($id, $this->getActiveStudent()->da)) {
            Flash::error("Vous ne pouvez pas remettre un exercice de cette façon");
            return $this->redirect('/exercises');
        }

        return $this->render('exercises/exercise_submit', [
            'exercise' => $exercise,
            'action' => "/submit/exercise/" . $id
        ]);
    }

    public function exerciseDetail($id)
    {
        return $this->render('exercises/exercise_details', [
            'exercise' => ExerciseService::get($id),
            'action' => "/submit/exercise/" . $id,
            'tips' => $this->gibberishTip($id),
            'corrected' => !$this->isUserTeacher() ? (new ExerciseBroker())->isCorrected($id, $this->getActiveStudent()->da) : false,
            'submitted' => !$this->isUserTeacher() ? (new ExerciseBroker())->isSubmitted($id, $this->getActiveStudent()->da) : false
        ]);
    }

    public function exerciseUpload($id)
    {
        $maxsize = 20971520;

        if ($this->isUserTeacher()) {
            Flash::error("L'enseignant ne peut pas remettre des exercices.");
            return $this->redirect('/exercises/' . $id);
        }

        $form = $this->buildForm();

        if ((new ExerciseBroker())->isCorrected($id, $this->getActiveStudent()->da)) {
            Flash::error("L'exercice à déjà été remis et corrigé. Vous ne pouvez pas le remettre une seconde fois!");
            return $this->redirect('/exercises/' . $id);
        }

        $targetDir = "../Uploads/" . str_replace([' ', '_'], '', $form->getValue("exerciseName")) . "_user" . $this->getUser()['id'] . "_";
        $targetFile = $targetDir . basename($this->request->getFile("exercise")["name"]);

        if ($this->request->getFile("exercise")["name"] == '') {
            Flash::error("Aucun fichier selectionné!");
            return $this->redirect('/exercises/' . $id);
        }

        if ($this->request->getFile("exercise")["size"] > $maxsize) {
            Flash::error("La taille des fichiers ne doivent pas dépasser 20 Mo.");
            return $this->redirect('/exercises/' . $id);
        }

        if ($this->request->getFile("exercise")["size"] == 0) {
            Flash::error("La taille des fichiers ne peut pas être de 0 octet.");
        }

        $fileType = strtolower(pathinfo($targetFile,PATHINFO_EXTENSION));

        if($fileType != "zip" && $fileType != "rar" && $fileType != "7zip" && $fileType != "java" ) {
            Flash::warning("Le type de fichier n'est pas autorisé. Les types acceptés sont : .zip, .rar, .7zip, .java.");
            return $this->redirect('/exercises/' . $id);
        }

        if (move_uploaded_file($this->request->getFile("exercise")["tmp_name"], $targetFile)) {
            Flash::success("La mission à bel et bien été remise.");
            if ((new ExerciseBroker())->isSubmitted($id, $this->getActiveStudent()->da)) {
                (new ExerciseBroker())->updateSubmit($this->getActiveStudent(), $id, $targetFile);
            } else {
                (new ExerciseBroker())->submitExercise($this->getActiveStudent(), $id, $targetFile, $form->getValue("exerciseName"));
            }
            return $this->redirect('/exercises/' . $id);
        }

        Flash::error("Une erreur est survenue. Votre fichier n'a pas été remis.");
        return $this->redirect('/exercises/' . $id);
    }

    private function gibberishTip($exerciseId): array
    {
        $broker = new TipBroker();
        $tips = [];
        $allTips = $broker->GetAllById($exerciseId);
        $boughtTips = $broker->GetAllUnlocked($exerciseId, 2222222);
        $index = 0;
        foreach ($allTips as $tip) {
            $tip->bought = false;
            if ($tip->id === $boughtTips[$index]->id) {
                $tip->bought = true;
                array_push($tips, $tip);
            } else {
                $tip->tip = Cryptography::randomString(strlen($tip->tip));
                array_push($tips, $tip);
            }
            $index++;
        }
        return $tips;
    }
}
