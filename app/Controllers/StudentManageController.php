<?php namespace Controllers;

use Models\Brokers\StudentBroker;
use Models\Brokers\StudentExerciseBroker;
use Models\Brokers\StudentItemBroker;
use Models\Brokers\TeamBroker;
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

        $this->post('/management/students/store', 'storeStudent');
        $this->post('/management/students/{da}/update', 'updateStudent');

        $this->overrideStudent();
    }

    public function listStudents(): Response
    {
        return $this->render('management/students/student_listing', [
            'students' => StudentService::getAll(),
        ]);
    }

    public function createStudent()
    {
        return $this->render('management/students/student_form', [
            'title' => 'Créer un étudiant',
            'action' => '/management/students/store',
            'editStudent' => null,
            'teams' => (new TeamBroker())->getAll(),
        ]);
    }

    public function viewStudent($da)
    {
        $student = StudentService::get($da);
        $imageUrl= "/assets/images/profil_pic_default.png";
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
            Flash::error('L\'étudiant n\'existe pas.');
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
}
