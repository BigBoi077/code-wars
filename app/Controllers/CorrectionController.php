<?php namespace Controllers;

use DateTime;
use Models\Brokers\ExerciseBroker;
use Models\Brokers\StudentBroker;
use Models\Brokers\StudentExerciseBroker;
use Models\Brokers\UserBroker;
use Models\Services\ExerciseService;
use Models\Services\PersonService;
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
        $this->get('/management/correction/download/{submitId}', 'downloadExercise');
        $this->get('/management/correction/detail/{id}/{submitId}', 'exerciseSubmitDetail');

        $this->post('/management/correction/correct/{userId}/{submitId}', 'correctExercise');

        $this->overrideCorrection();
        $this->overrideStudentExercise();
    }

    public function correctionList()
    {
        $exercises = (new ExerciseBroker())->getCorrection();
        $exercisesByStudent = [];
        foreach ($exercises as $exercise) {
            $nowDate = new DateTime();
            $exerciseDate = new DateTime($exercise->submit_date);
            $diff = $exerciseDate->diff($nowDate);
            if ($diff->d < 1) {
                if ($diff->h <= 0) {
                    $exercise->diff = "Remis il y a " . $diff->format("%i minutes");
                } else {
                    $exercise->diff = "Remis il y a " . $diff->format("%h heures et %i minutes");
                }
            } else {
                $exercise->diff = "Remis le " . format('date', $exercise->submit_date);
            }
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
        $ok = $form->getValue("ok");
        $userId = (new UserBroker())->findByDa($da)->id;
        if (is_string($ok)) {
            (new ExerciseBroker())->correctExercise($userId, (new StudentBroker())->findByDa($da), $id, $form->getValue('comment'));
            $e = (new ExerciseBroker())->getCorrectionPath($id);
            unlink($e->path);
            Flash::success("Mission marqué complétée avec succès. L'élève à bien reçu son argent et ses points.");
        } else {
            Flash::warning("Commentaire envoyé à l'élève l'informant que sa solution ne convient pas.");
            (new ExerciseBroker())->incorrectExercise($userId, (new StudentBroker())->findByDa($da), $id, $form->getValue('comment'));
        }
        return $this->redirect('/management/correction');
    }

    public function downloadExercise($id)
    {
        $e = (new ExerciseBroker())->getCorrectionPath($id);

        if ($e == null) {
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
            exit();
        } else {
            Flash::error("Impossible de télécharcher le fichier");
            exit("Error: File not found.");
        }
    }

    public function exerciseSubmitDetail($id, $submitId): Response
    {
        $studentExerciseBroker = new StudentExerciseBroker();
        $studentExercise = $studentExerciseBroker->findById($submitId);

        if (is_null($studentExercise)) {
            Flash::error("Une erreur est survenue lors du traitement. La mission remise par l'étudiant à été retirée.");
            return $this->redirect($this->request->getReferer());
        }

        $fileContent = null;
        if (file_exists($studentExercise->dir_path)) {
            $file = fopen($studentExercise->dir_path, "r");
            if (!$file) {
                Flash::error("Impossible d'ouvrir le fichier.");
            }
            if (filesize($studentExercise->dir_path) == 0) {
                Flash::error("Impossible d'ouvrir le fichier.");
            }

            $fileContent = fread($file, filesize($studentExercise->dir_path));
            $fileExtention = pathinfo($studentExercise->dir_path, PATHINFO_EXTENSION);

            if ($fileExtention == "zip") {
                $fileContent = "Fichier ZIP. Appuyer sur Télécharger pour le consulter.";
            } elseif ($fileExtention != "java") {
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

    private function overrideStudentExercise()
    {
        $this->overrideArgument('submitId', function ($value) {
            if (is_numeric($value)) {
                $exercise = (new StudentExerciseBroker)->findById($value);
                if (is_null($exercise)) {
                    return $this->redirect('/management/correction');
                }
                return $exercise->se_id;
            } else {
                return $this->redirect('/management/correction');
            }
        });
    }
}
