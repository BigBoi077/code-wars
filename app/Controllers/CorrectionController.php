<?php namespace Controllers;

use Models\Brokers\ExerciseBroker;
use Models\Brokers\StudentBroker;
use Models\Brokers\UserBroker;
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
        Flash::success("Exercise marqué corigé avec succès. L'élève a bien reçu son argents et ses points");
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
}