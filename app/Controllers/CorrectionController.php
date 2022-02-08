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
            return $this->redirect("/error/404");
        }
        return parent::before();
    }

    public function initializeRoutes()
    {
        $this->get('/management/correction', 'correctionList');
        $this->get('/management/correction/download/{id}', 'downloadExercise');
        $this->get('/management/correction/detail/{id}/{submitId}', 'exerciseSubmitDetail');

        $this->post('/management/correction/correct/{userId}/{id}', 'correctExercise');

        $this->overrideCorrection();
    }

    public function correctionList()
    {
        $exercises = (new ExerciseBroker())->getCorrection();
        $exercisesByStudent = [];
        foreach ($exercises as $exercise) {
            $exercisesByStudent[$exercise->firstname . " " . $exercise->lastname][$exercise->exercise_id] = $exercise;
        }
        return $this->render('/management/correction/correction_listing', [
            'corrections' => $exercisesByStudent,
            'count' => count($exercises)
        ]);
    }

    public function correctExercise($da, $id)
    {
        $form = $this->buildForm();
        (new ExerciseBroker())->correctExercise((new UserBroker())->findByDa($da)->id, (new StudentBroker())->findByDa($da), $id, $form->getValue('comment'));
        $e = (new ExerciseBroker())->getCorrectionPath($id);
        unlink($e->path);
        Flash::success("Exercice marqué corrigé avec succès. L'élève à bien reçu son argent et ses points.");
        return $this->redirect('/management/correction');
    }

    public function downloadExercise($id)
    {
        $e = (new ExerciseBroker())->getCorrectionPath($id);

        if ($e == null) {
            Flash::error("Impossible de télécharcher le fichier");
            return $this->redirect("/error/404");
        }

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

    public function exerciseSubmitDetail($id, $submitId): Response
    {
        $studentExerciseBroker = new StudentExerciseBroker();
        $studentExercise = $studentExerciseBroker->findById($submitId);

        $fileContent = null;
        if (file_exists($studentExercise->dir_path)) {
            $file = fopen($studentExercise->dir_path, "r");
            if (!$file) {
                Flash::error("Impossible d'ouvrir le fichier");
            }
            if (filesize($studentExercise->dir_path) == 0) {
                Flash::error("Impossible d'ouvrir le fichier");
            }

            $fileContent = fread($file, filesize($studentExercise->dir_path));
            $fileExtention = pathinfo($studentExercise->dir_path, PATHINFO_EXTENSION);

            if ($fileExtention != "java") {
                $fileContent = null;
            }

            fclose($file);
        }

        return $this->render('management/correction/correction_submit_detail', [
            'exercise' => ExerciseService::get($id),
            'studentExercise' => $studentExercise,
            'fileContent' => $fileContent,
            'studentName' => $studentExercise->firstname . " " . $studentExercise->lastname
        ]);
    }

    private function overrideCorrection()
    {
        $this->overrideArgument('id', function ($value) {
            if (is_numeric($value)) {
                $exercise = ExerciseService::get($value);
                if (is_null($exercise)) {
                    return $this->redirect('/management/correction');
                }
                return $exercise->id;
            } else {
                return $this->redirect('/management/correction');
            }
        });
    }
}
