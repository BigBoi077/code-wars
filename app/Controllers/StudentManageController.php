<?php namespace Controllers;

use Models\Brokers\StudentBroker;
use Models\Brokers\StudentExerciseBroker;
use Models\Brokers\StudentItemBroker;
use Models\Brokers\TeamBroker;
use Models\Brokers\TransactionBroker;
use Models\Services\ItemService;
use Models\Services\StudentService;
use Zephyrus\Application\Flash;
use Zephyrus\Network\Response;
use Zephyrus\Utilities\Gravatar;

class StudentManageController extends TeacherController
{
    public function initializeRoutes()
    {
        $this->get('/management/students', 'listStudents');
        $this->get('/management/students/create', 'createStudent');
        $this->get('/management/students/{da}/edit', 'editStudent');
        $this->get('/management/students/{da}/delete', 'deleteStudent');
        $this->get('/management/students/{da}/profile', 'viewStudent');
        $this->get("/management/students/rapidAdd", "rapidAdd");

        $this->post('/management/students/store', 'storeStudent');
        $this->post('/management/students/{da}/update', 'updateStudent');
        $this->post("/management/students/rapidAdd", 'rapidAddUpdate');

        $this->overrideStudent();
    }

    public function listStudents(): Response
    {
        return $this->render('management/students/student_listing', [
            'students' => (new StudentBroker())->getAllAlphabetic(),
        ]);
    }

    public function createStudent()
    {
        return $this->render('management/students/student_form', [
            'title' => 'Créer un étudiant',
            'action' => '/management/students/store',
            'editStudent' => null,
            'teams' => (new TeamBroker())->getAll()
        ]);
    }

    public function viewStudent($da)
    {
        $student = StudentService::get($da);
        $imageUrl = "/assets/images/profil_pic_default.png";
        if ($student != null && ($student->email != '' || $student->email != null)) {
            $gravatar = new Gravatar($student->email);
            $imageUrl = $gravatar->getUrl();
        }
        $weeklyProgress = (new StudentBroker())->getProgressionByWeek($da);
        $indProgress = (new StudentBroker())->getProgression($da);
        $items = (new StudentItemBroker())->getAllWithDa($da);
        $studentExercises = (new StudentExerciseBroker())->getAllWithDa($student->da);
        return $this->render('profile/profile', [
            'isTeacher' => $this->isUserTeacher(),
            'studentProfile' => $student,
            'weeklyProgress' => $weeklyProgress,
            'individualProgress' => $indProgress,
            'items' => $items,
            'exercises' => $studentExercises,
            'gravatarUrl' => $imageUrl
        ]);
    }

    public function editStudent($da)
    {
        if (!StudentService::exists($da)) {
            Flash::error('L\'étudiant sélectionné n\'existe pas.');
            return $this->redirect('/management/students');
        }
        $student = StudentService::get($da);
        return $this->render('management/students/student_form', [
            'title' => 'Modification de ' . $student->firstname . ' ' . $student->lastname,
            'action' => '/management/students/' . $student->da . '/update',
            'editStudent' => $student,
            'teams' => (new TeamBroker())->getAll()
        ]);
    }

    public function deleteStudent($da)
    {
        $student = StudentService::get($da);

        if (StudentService::exists($da)) {
            if (StudentService::hasItem($da)) {
                ItemService::deleteAllStudentItem($da);
            }
            StudentService::delete($da);
            Flash::success('Étudiant, ' . $student->firstname . ' ' . $student->lastname . ', supprimé avec succès!');
        } else {
            Flash::error('Une erreur est survenue.');
        }
        return $this->redirect('/management/students');
    }

    public function storeStudent()
    {
        $student = StudentService::create($this->buildForm());
        if ($student->hasSucceeded()) {
            Flash::success('Étudiant créé avec succès!');
            return $this->redirect('/management/students');
        }
        Flash::error($student->getErrorMessages());
        return $this->redirect('/management/students/create');
    }

    public function updateStudent($da)
    {
        if (StudentService::exists($da)) {
            $student = StudentService::update($da, $this->buildForm());
            if ($student->hasSucceeded()) {
                Flash::success('Étudiant modifié avec succès!');
                return $this->redirect('/management/students');
            }
            Flash::error($student->getErrorMessages());
        }
        Flash::error('Une erreur est survenue.');
        return $this->redirect('/management/students/' . $da . '/edit');
    }

    private function overrideStudent()
    {
        $this->overrideArgument('da', function ($value) {
            if (is_numeric($value)) {
                $student = StudentService::get($value);
                if (is_null($student)) {
                    return $this->redirect('/management/students');
                }
                return $student->da;
            } else {
                return $this->redirect('/management/students');
            }
        });
    }

    public function rapidAdd()
    {
        return $this->render("/management/students/add_points_cash", [
            'teams' => (new TeamBroker())->getAll(),
            'students' => (new StudentBroker())->getAllAlphabetic()
        ]);
    }

    public function rapidAddUpdate()
    {
        $form = $this->buildForm();
        $forValue = $form->getValue("for");
        $reason = $form->getValue("reason");
        $cash = $form->getValue('cash', 0);
        $points = $form->getValue('points', 0);
        if ($forValue == "team") {
            if ($form->getValue('team_id') == null) {
                Flash::error("Vous devez sélectionner une équipe.");
                return $this->redirect("/management/students/rapidAdd");
            }
            $broker = new TeamBroker();
            $broker->addToTeam($form->getValue('team_id'), (int)($points), (int)($cash), $reason);
            $form->getValue('team_id') == 1 ? Flash::success("Ajout rapide, à l'équipe des Sith, effectué avec succès!") : Flash::success("L'ajout rapide, à l'équipe des Rebels, effectué avec succès!");
        } elseif ($forValue == "student") {
            if ($form->getValue('student_da') == null) {
                Flash::error("Vous devez sélectionner un élève.");
                return $this->redirect("/management/students/rapidAdd");
            }
            $transactionBroker = new TransactionBroker();
            $studentBroker = new StudentBroker();
            $student = $studentBroker->findByDa($form->getValue('student_da'));
            $studentBroker->addPoints($form->getValue('student_da'), (int)($points));
            $studentBroker->addCash($form->getValue('student_da'), (int)($cash));
            $isPointsPositive = $points >= 0;
            $isCashPositive = $cash >= 0;
            if ($reason == "") {
                $reason = "Mettre un raison icite";
            }
            $transactionBroker->insert($student->id, $reason, $cash, $points, $isCashPositive, $isPointsPositive);
            Flash::success("Ajout rapide, à " . $student->firstname . ' ' . $student->lastname . ", effectué avec succès!");
        }
        return $this->redirect("/management/students");
    }
}
