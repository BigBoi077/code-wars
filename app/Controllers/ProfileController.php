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
use Zephyrus\Application\Rule;

class ProfileController extends Controller
{

    public function initializeRoutes()
    {
        $this->get('/profile', 'profile');
        $this->get('/profile/edit', 'editProfile');
        $this->get("/profile/editMdp", 'editMdp');
        $this->post('/profile/update', 'updateProfile');
        $this->post('/profile/update/mdp', 'updateMdp');
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
        return $this->render('profile/edit_profile');
    }

    public function editMdp()
    {
        return $this->render('profile/edit_mdp');
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

    public function updateMdp()
    {
        $form = $this->buildForm();
        $form->validate('password', Rule::passwordCompliant('Le mot de passe doit contenir une minuscule, une majuscule, un chiffre et avoir une longueur minimum de 8 caractères.'));
        if ($form->getValue('confirmPassword') != '') {
            $form->validate('confirmPassword', Rule::sameAs('password', 'La confirmation de mot de passe doit être identique au mot de passe.'));
        } else {
            $form->validate('confirmPassword', Rule::notEmpty('La confirmation de mot de passe est requise.'));
        }
        if (!$form->verify()) {
            Flash::error($form->getErrorMessages());
            return $this->redirect($this->request->getReferer());
        }


        Flash::success("Mot de passe changé avec succès");
        return $this->redirect('/profile');
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