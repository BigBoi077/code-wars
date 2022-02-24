<?php namespace Controllers;

use Models\Brokers\ExerciseBroker;
use Models\Brokers\ImageExampleBroker;
use Models\Brokers\StudentBroker;
use Models\Brokers\TipBroker;
use Models\Brokers\WeekBroker;
use Models\Services\ExerciseService;
use stdClass;
use Zephyrus\Application\Flash;
use Zephyrus\Application\Rule;

class ExerciseController extends Controller
{
    public function initializeRoutes()
    {
        $this->get('/exercises', 'exercises');
        $this->get('/exercises/{id}', 'exerciseDetail');

        $this->get('/exercises/submit/{id}', 'exerciseSubmit');
        $this->post('/exercises/cancel/{id}', 'exerciseCancel');
        $this->post('/submit/exercise/{id}', 'exerciseUpload');
        $this->post("/exercises/tips/{tipId}/buy", 'buyTip');

        $this->overrideExercise();
    }

    public function exercises()
    {
        $exerciseBroker = new ExerciseBroker();
        $da = $this->getUser()['da'];
        $weeks = (new WeekBroker())->getAllActive();
        foreach ($weeks as $week) {
            $week->exercises = $exerciseBroker->getAllByWeek($week->week_id);
            foreach ($week->exercises as $exercise) {
                $exercise->corrected = $exerciseBroker->isCorrected($exercise->id, $da);
                $exercise->completed = $exerciseBroker->isSubmitted($exercise->id, $da);
                $exercise->is_good = $exerciseBroker->isGood($exercise->id, $da);
            }
        }
        $weeklyProgress = null;
        $findProgress = null;
        if (!$this->isUserTeacher()) {
            $weeklyProgress = (new StudentBroker())->getProgressionByWeek($da);
            $findProgress = (new StudentBroker())->getProgression($da);
        }

        return $this->render('exercises/exercises_listing', [
            'exercisesByWeek' => $weeks,
            'weeklyProgress' => $weeklyProgress,
            'individualProgress' => $findProgress,
        ]);
    }

    public function exerciseSubmit(stdClass $exercise)
    {
        if ($this->isUserTeacher()) {
            Flash::error('Un enseignant ne peut pas participer aux missions.');
            return $this->redirect($this->request->getReferer());
        }

        $broker = new ExerciseBroker();

        if ($broker->isCorrected($exercise->id, $this->getActiveStudent()->da)) {
            Flash::error("Vous ne pouvez pas remettre une mission de cette façon.");
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

        if ($broker->isCorrected($exercise->id, $this->getActiveStudent()->da)) {
            Flash::error("Vous ne pouvez pas annuler une mission déjà complétée.");
            return $this->redirect('/exercises');
        }

        $student = $this->getUser();
        $exerciseToDelete = $broker->getExerciseByStudentDA($student['da'], $exercise->id);

        unlink($exerciseToDelete->dir_path);
        $broker->deleteExercise($student['da'], $exercise->id);

        Flash::success("La mission à été annulée avec succès!");
        return $this->redirect($this->request->getReferer());
    }

    public function exerciseDetail(stdClass $exercise)
    {
        if (!$this->getUser()['isTeacher'] && !$exercise->is_active) {
            return $this->redirect("/error/404");
        }
        $state = "unsubmitted";
        $corrected = !$this->isUserTeacher() ? (new ExerciseBroker())->isCorrected($exercise->id, $this->getActiveStudent()->da) : false;
        $submitted = !$this->isUserTeacher() ? (new ExerciseBroker())->isSubmitted($exercise->id, $this->getActiveStudent()->da) : false;
        $isGood = !$this->isUserTeacher() ? !(new ExerciseBroker())->isGood($exercise->id, $this->getActiveStudent()->da) : true;

        if ($corrected && $submitted) {
            $state = "finished";
        } elseif (!$corrected && $submitted) {
            $state = "uncorrected";
        }

        $examples = (new ImageExampleBroker())->getAllById($exercise->id);

        return $this->render('exercises/exercise_details', [
            'exercise' => $exercise,
            'action' => "/submit/exercise/" . $exercise->id,
            'tips' => $this->gibberishTip($exercise->id, $this->getUser()['isTeacher']),
            'completion' => $this->calculateCompletion($exercise),
            'state' => $state,
            'isTeacher' => $this->isUserTeacher(),
            'corrected' => $corrected,
            'submitted' => $submitted,
            'is_good' => $isGood,
            'imageExamples' => $examples
        ]);
    }

    public function exerciseUpload($exercise)
    {
        $maxsize = 20971520;

        if ($this->isUserTeacher()) {
            Flash::error("L'enseignant ne peut pas participer aux missions.");
            return $this->redirect('/exercises/' . $exercise->id);
        }

        $form = $this->buildForm();
        $form->field('exercise')
            ->validate(Rule::fileUpload("Pas d'upload"))
            ->validate(Rule::fileSize("La taille du fichier est trop lourde.", 100));
        if (!$form->verify()) {
            Flash::error($form->getErrorMessages());
            return $this->redirect('/exercises/' . $exercise->id);
        }

        if ((new ExerciseBroker())->isCorrected($exercise->id, $this->getActiveStudent()->da)) {
            Flash::error("La mission à déjà été remise et corrigée. Vous ne pouvez pas la remettre une seconde fois!");
            return $this->redirect('/exercises/' . $exercise->id);
        }

        $targetDir = getcwd() . "/../uploads/" . str_replace([' ', '_'], '', $form->getValue("exerciseName")) . "_user" . $this->getUser()['id'] . "_";
        $targetFile = $targetDir . basename($this->request->getFile("exercise")["name"]);

        if ($this->request->getFile("exercise")["name"] == '') {
            Flash::error("Aucun fichier selectionné!");
            return $this->redirect('/exercises/submit/' . $exercise->id);
        }

        if ($this->request->getFile("exercise")["size"] > $maxsize) {
            Flash::error("La taille totale des fichiers ne doit pas dépasser 20 Mo.");
            return $this->redirect('/exercises/submit/' . $exercise->id);
        }

        if ($this->request->getFile("exercise")["size"] == 0) {
            Flash::error("La taille totale des fichiers ne peut pas être de 0 octet.");
        }

        $fileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

        if ($fileType != "zip" && $fileType != "java") {
            Flash::warning("Ce type de fichier n'est pas autorisé. Les types acceptés sont : .zip et .java.");
            return $this->redirect('/exercises/submit/' . $exercise->id);
        }

        if (strlen($form->getValue('comment')) > 2000) {
            Flash::warning("Votre commentaire est trop long. Veuillez en entrer un plus court.");
            return $this->redirect('/exercises/submit/' . $exercise->id);
        }

        if (move_uploaded_file($this->request->getFile("exercise")["tmp_name"], $targetFile)) {
            Flash::success("La mission a bel et bien été remise.");
            if ((new ExerciseBroker())->isSubmitted($exercise->id, $this->getActiveStudent()->da)) {
                (new ExerciseBroker())->updateSubmit($this->getActiveStudent(), $exercise->id, $targetFile);
            } else {
                (new ExerciseBroker())->submitExercise($this->getActiveStudent(), $exercise->id, $targetFile, $form->getValue("exerciseName"), $form->getValue("comment"));
            }
            return $this->redirect('/exercises/' . $exercise->id);
        }

        Flash::error("Une erreur est survenue. Votre fichier n'a pas été remis.");
        return $this->redirect('/exercises/submit/' . $exercise->id);
    }

    public function buyTip($tipId)
    {
        $user = $this->getUser();
        $student = (new StudentBroker())->findByDa($user['da']);
        $broker = new TipBroker();
        $tip = $broker->GetById($tipId);
        if ($student->cash < $tip->price) {
            Flash::error("Vous n'avez pas assez d'argent pour cet indice.");
            return $this->redirect($this->request->getReferer());
        } elseif ($broker->Has($tipId, $student->da)) {
            Flash::error("Vous possédez déjà cet indice, pourquoi payer deux fois?");
            return $this->redirect($this->request->getReferer());
        }
        $broker->buy($tipId, $student->da);
        (new StudentBroker())->addCash($student->da, -($tip->price));
        Flash::success("Vous avez acheté l'indice avec succès!");
        return $this->redirect($this->request->getReferer());
    }

    private function gibberishTip($exerciseId, $isTeacher): array
    {
        $broker = new TipBroker();
        $tips = [];
        $allTips = $broker->GetAllById($exerciseId);
        $boughtTips = $broker->GetAllUnlocked($exerciseId, $this->getUser()["da"]);
        foreach ($allTips as $tip) {
            if ($isTeacher) {
                $tip->bought = true;
                array_push($tips, $tip);
                continue;
            }
            $tip->bought = false;
            $unHashedTip = $tip->tip;
            $tip->tip = "Lucas ipsum dolor sit amet jinn darth jinn mustafar han darth jinn leia moff tatooine. Gonk jango lando amidala c-3po skywalker padmé.";
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
        return round($nbHasCompleted / count($allStudent) * 100, 2);
    }

    private function overrideExercise()
    {
        $this->overrideArgument('id', function ($value) {
            if (is_numeric($value)) {
                $exercise = ExerciseService::get($value);
                if (is_null($exercise)) {
                    return $this->redirect('/exercises');
                }
                return $exercise;
            } else {
                return $this->redirect('/exercises');
            }
        });
    }
}
