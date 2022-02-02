<?php namespace Controllers;

use Models\Brokers\ExerciseBroker;
use Models\Brokers\StudentBroker;
use Models\Brokers\TipBroker;
use Models\Services\ExerciseService;
use stdClass;
use Zephyrus\Application\Flash;
use Zephyrus\Security\Cryptography;

class ExerciseController extends Controller
{
    public function initializeRoutes()
    {
        $this->get('/exercises', 'exercises');
        $this->get('/exercises/{id}', 'exerciseDetail');
        $this->get('/exercises/submit/{id}', 'exerciseSubmit');
        $this->get('/exercises/cancel/{id}', 'exerciseCancel');
        $this->post('/submit/exercise/{id}', 'exerciseUpload');
        $this->overrideExercice();
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
        $findProgress = null;
        if (!$this->isUserTeacher()) {
            $weeklyProgress = (new StudentBroker())->getProgressionByWeek($this->getActiveStudent()->da);
            $findProgress = (new StudentBroker())->getProgression($this->getActiveStudent()->da);
        }

        return $this->render('exercises/exercises_listing', [
            'exercisesByWeek' => $exercisesByWeek,
            'weeklyProgress' => $weeklyProgress,
            'individualProgress' => $findProgress,
        ]);
    }

    public function exerciseSubmit(stdClass $exercise)
    {
        $broker = new ExerciseBroker();

        if ($broker->isCorrected($exercise->id, $this->getActiveStudent()->da)) {
            Flash::error("Vous ne pouvez pas remettre un exercice de cette façon");
            return $this->redirect('/exercises');
        }

        return $this->render('exercises/exercise_submit', [
            'exercise' => $exercise,
            'action' => "/submit/exercise/" . $exercise->id
        ]);
    }

    public function exerciseCancel(stdClass $exercise)
    {
        $broker = new ExerciseBroker();
        $student = $this->getUser();
        $exerciseToDelete = $broker->getExerciseByStudentDA($student['da'], $exercise->id);

        unlink($exerciseToDelete->dir_path);
        $broker->deleteExercise($student['da'], $exercise->id);

        Flash::success("L'exercice à été effacé avec succès");
        return $this->redirect($this->request->getReferer());
    }

    public function exerciseDetail(stdClass $exercise)
    {
        $state = "unsubmitted";
        $corrected = !$this->isUserTeacher() ? (new ExerciseBroker())->isCorrected($exercise->id, $this->getActiveStudent()->da) : false;
        $submitted = !$this->isUserTeacher() ? (new ExerciseBroker())->isSubmitted($exercise->id, $this->getActiveStudent()->da) : false;

        if ($corrected && $submitted) {
            $state = "finished";
        } else if (!$corrected && $submitted) {
            $state = "uncorrected";
        }

        return $this->render('exercises/exercise_details', [
            'exercise' => $exercise,
            'action' => "/submit/exercise/" . $exercise->id,
            'tips' => $this->gibberishTip($exercise->id),
            'completion' => $this->calculateCompletion($exercise),
            'state' => $state,
            'corrected' => $corrected,
            'submitted' => $submitted
        ]);
    }

    public function exerciseUpload($exercise)
    {
        $maxsize = 20971520;

        if ($this->isUserTeacher()) {
            Flash::error("L'enseignant ne peut pas remettre des exercices.");
            return $this->redirect('/exercises/' . $exercise->id);
        }

        $form = $this->buildForm();

        if ((new ExerciseBroker())->isCorrected($exercise->id, $this->getActiveStudent()->da)) {
            Flash::error("L'exercice à déjà été remis et corrigé. Vous ne pouvez pas le remettre une seconde fois!");
            return $this->redirect('/exercises/' . $exercise->id);
        }

        $targetDir = getcwd() . "/../Uploads/" . str_replace([' ', '_'], '', $form->getValue("exerciseName")) . "_user" . $this->getUser()['id'] . "_";
        $targetFile = $targetDir . basename($this->request->getFile("exercise")["name"]);

        if ($this->request->getFile("exercise")["name"] == '') {
            Flash::error("Aucun fichier selectionné!");
            return $this->redirect('/exercises/' . $exercise->id);
        }

        if ($this->request->getFile("exercise")["size"] > $maxsize) {
            Flash::error("La taille des fichiers ne doivent pas dépasser 20 Mo.");
            return $this->redirect('/exercises/' . $exercise->id);
        }

        if ($this->request->getFile("exercise")["size"] == 0) {
            Flash::error("La taille des fichiers ne peut pas être de 0 octet.");
        }

        $fileType = strtolower(pathinfo($targetFile,PATHINFO_EXTENSION));

        if($fileType != "zip" && $fileType != "rar" && $fileType != "7zip" && $fileType != "java" ) {
            Flash::warning("Le type de fichier n'est pas autorisé. Les types acceptés sont : .zip, .rar, .7zip, .java.");
            return $this->redirect('/exercises/' . $exercise->id);
        }

        if (move_uploaded_file($this->request->getFile("exercise")["tmp_name"], $targetFile)) {
            Flash::success("La mission à bel et bien été remise.");
            if ((new ExerciseBroker())->isSubmitted($exercise->id, $this->getActiveStudent()->da)) {
                (new ExerciseBroker())->updateSubmit($this->getActiveStudent(), $exercise->id, $targetFile);
            } else {
                (new ExerciseBroker())->submitExercise($this->getActiveStudent(), $exercise->id, $targetFile, $form->getValue("exerciseName"));
            }
            return $this->redirect('/exercises/' . $exercise->id);
        }

        Flash::error("Une erreur est survenue. Votre fichier n'a pas été remis.");
        return $this->redirect('/exercises/' . $exercise->id);
    }

    private function gibberishTip($exerciseId): array
    {
        $broker = new TipBroker();
        $tips = [];
        $allTips = $broker->GetAllById($exerciseId);
        $boughtTips = $broker->GetAllUnlocked($exerciseId, $this->getUser()["da"]);
        foreach ($allTips as $tip) {
            $tip->bought = false;
            $unHashedTip = $tip->tip;
            $tip->tip = "Lucas ipsum dolor sit amet jinn darth jinn mustafar han darth jinn leia moff tatooine. Gonk jango lando amidala c-3po skywalker padmé. Jade darth calamari ackbar jango anakin. Moff fett maul mothma kenobi. Skywalker kessel jabba moff fett darth.";
            foreach ($boughtTips as $boughtTip) {
                if ($tip->id === $boughtTip->id) {
                    $tip->bought = true;
                    $tip->tip = $unHashedTip;
                }
            }
            array_push($tips, $tip);
        }
        return $tips;
    }

    private function calculateCompletion($exercise): float
    {
        $allStudent = (new StudentBroker())->getAll();
        $nbHasCompleted = 0;
        $broker = new ExerciseBroker();
        foreach ($allStudent as $student) {
            if ($broker->isCorrected($exercise->id, $student->da)) {
                $nbHasCompleted++;
            }
        }
        return $nbHasCompleted / Count($allStudent) * 100;
    }

    private function overrideExercice()
    {
        $this->overrideArgument('id', function ($value) {
            if (is_numeric($value)) {
                $exercice = ExerciseService::get($value);
                if (is_null($exercice)) {
                    return $this->redirect('/exercises');
                }
                return $exercice;
            } else {
                return $this->redirect('/exercises');
            }
        });
    }
}
