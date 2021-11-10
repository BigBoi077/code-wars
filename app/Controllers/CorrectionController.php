<?php namespace Controllers;

use Models\Brokers\ExerciseBroker;
use Models\Brokers\StudentBroker;
use Models\Brokers\StudentExerciseBroker;
use Models\Brokers\UserBroker;
use Models\Services\ExerciseService;
use Zephyrus\Application\Flash;
use Zephyrus\Network\Response;

class CorrectionController extends Controller
{
    public function before(): ?Response
    {
        if (!$this->isUserTeacher()) {
            return $this->redirect("/");
        }
        return parent::before();
    }

    public function initializeRoutes()
    {
        $this->get('/management/correction', 'correctionList');
        $this->get('/management/correction/correct/{userId}/{id}', 'correctExercise');
        $this->get('/management/correction/download/{id}', 'downloadExercise');
        $this->get('/exercises/submit/detail/{studentName}/{id}/{submitId}', 'exerciseSubmitDetail');
    }

    public function correctionList()
    {
        $exercises = (new ExerciseBroker())->getCorrection();
        $exercisesByStudent = [];
        foreach ($exercises as $exercise) {
            $exercisesByStudent[$exercise->firstname . " " . $exercise->lastname][$exercise->exercise_id] = $exercise;
        }
        return $this->render('/management/correction/correction_listing', [
            'corrections' => $exercisesByStudent
        ]);
    }

    public function correctExercise($da, $id)
    {
        (new ExerciseBroker())->correctExercise((new UserBroker())->findByDa($da)->id, (new StudentBroker())->findByDa($da), $id);
        $e = (new ExerciseBroker())->getCorrectionPath($id);
        unlink($e->path);
        Flash::success("Exercice marqué corrigé avec succès. L'élève à bien reçu son argent et ses points.");
        return $this->redirect('/management/correction');
    }

    public function downloadExercise($id)
    {
        $e = (new ExerciseBroker())->getCorrectionPath($id);

        if (file_exists($e->path)) {
            header($_SERVER["SERVER_PROTOCOL"] . " 200 OK");
            header("Cache-Control: public");
            header("Content-Type: application/octet-stream");
            header("Content-Transfer-Encoding: Binary");
            header("Content-Length:".filesize($e->path));
            header("Content-Disposition: attachment; filename=" . substr($e->path, 40));
            readfile($e->path);
            die();
        } else {
            die("Error: File not found.");
        }
    }

    public function exerciseSubmitDetail($studentName, $id, $submitId): Response
    {
        $studentArrayName = explode(" ", rawurldecode($studentName));

        $studentExerciseBroker = new StudentExerciseBroker();
        $studentExercise = $studentExerciseBroker->findById($submitId);

        if (file_exists($studentExercise->dir_path)) {
            $file = fopen($studentExercise->dir_path, "r");
            if (!$file) {
                Flash::error("Impossible d'ouvrir le fichier");
                return $this->redirect('/management/correction');
            }
            if (filesize($studentExercise->dir_path) == 0) {
                Flash::error("Impossible d'ouvrir le fichier");
                return $this->redirect('/management/correction');
            }

            $fileContent = fread($file, filesize($studentExercise->dir_path));
            $fileExtention = pathinfo($studentExercise->dir_path, PATHINFO_EXTENSION);

            if ($fileExtention != "java") {
                $fileContent = null;
            }

            fclose($file);

            return $this->render('management/correction/correction_submit_detail', [
                'exercise' => ExerciseService::get($id),
                'action' => "/submit/exercise/" . $id,
                'studentExercise' => $studentExercise,
                'fileContent' => $fileContent,
                'studentFirstname' => $studentArrayName[0],
                'studentLastname' => $studentArrayName[1]
            ]);
        } else {
            Flash::error("Impossible d'ouvrir le fichier");
            return $this->redirect('/management/correction');
        }
    }
}