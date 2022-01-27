<?php namespace Controllers;

use Models\Brokers\NotificationBroker;
use Models\Brokers\PersonBroker;
use Models\Brokers\StudentBroker;
use Models\Brokers\StudentExerciseBroker;
use Models\Brokers\StudentItemBroker;
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
}
