<?php namespace Controllers;

use Models\Brokers\NotificationBroker;
use Models\Brokers\PersonBroker;
use Models\Brokers\StudentBroker;
use Models\Brokers\StudentExerciseBroker;
use Models\Brokers\StudentItemBroker;
use Models\Brokers\TeamBroker;
use Models\Services\ExerciseService;
use Models\Services\PersonService;
use Zephyrus\Application\Flash;

class ProfileController extends Controller
{

    public function initializeRoutes()
    {
        $this->get('/profile', 'profile');
        $this->get('/profile/edit', 'editProfile');
        $this->post('/profile/update', 'updateProfile');
        $this->get('/profile/notifications', 'notifications');

        $this->get("/management/students/rapidAdd", "rapidAdd");
        $this->post("/management/students/rapidAdd", 'rapidAddUpdate');
    }

    public function profile()
    {
        $student = $this->getActiveStudent();
        $weeklyProgress = (new StudentBroker())->getProgressionByWeek($student->da);
        $indProgress = (new StudentBroker())->getProgression($student->da);
        $items = (new StudentItemBroker())->getAllWithDa($student->da);
        $studentExercises = (new StudentExerciseBroker())->getAllWithDa($student->da);
        $teacher = (new PersonBroker())->findByDa(0);
        return $this->render('profile/profile', [
            'isTeacher' => false,
            'studentProfile' => $student,
            'weeklyProgress' => $weeklyProgress,
            'individualProgress' => $indProgress,
            'items' => $items,
            'exercises' => $studentExercises,
            'teacher' => $teacher
        ]);
    }

    public function notifications()
    {
        $notifications = (new NotificationBroker())->getStudentAllNotifications($this->getUser()['id']);
        return $this->render('profile/notifications', [
            'notifications' => $notifications,
            'teamPoints' => TeamController::getTeamPoints()
        ]);
    }

    public function editProfile()
    {
        return $this->render('profile/edit_profile', [
            'action' => '/profile/update'
        ]);
    }

    public function updateProfile()
    {
        $profile = PersonService::update($this->getActiveStudent()->da, $this->buildForm());
        if ($profile->hasSucceeded()) {
            Flash::success('Profil edité avec succèss.');
            return $this->redirect('/profile');
        }
        Flash::error($profile->getErrorMessages());
        return $this->redirect('/profile/edit');
    }

    public function rapidAdd()
    {
        return $this->render("/management/students/add_points_cash", [
            'teams' => (new TeamBroker())->getAll(),
            'students' => (new StudentBroker())->getAll()
        ]);
    }

    public function rapidAddUpdate()
    {
        $form = $this->buildForm();
        $forValue = $form->getValue("for");
        if ($forValue == "team") {
            if ($form->getValue('team_id') == null) {
                Flash::error("Aucune équipe sélectionnée...");
                return $this->redirect("/management/students/rapidAdd");
            }
            $broker = new TeamBroker();
            $broker->addToTeam($form->getValue('team_id'), $form->getValue('points'), $form->getValue('cash'));
        } else if ($forValue == "student") {
            if ($form->getValue('student_da') == null) {
                Flash::error("Aucun élève sélectionné...");
                return $this->redirect("/management/students/rapidAdd");
            }
            $studentBroker = new StudentBroker();
            $studentBroker->addPoints($form->getValue('student_da'), (int)($form->getValue('points')));
            $studentBroker->addCash($form->getValue('student_da'), (int)($form->getValue('cash')));
        }
        Flash::success("Action effectué avec succès");
        return $this->redirect("/management/students");
    }
}