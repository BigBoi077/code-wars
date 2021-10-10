<?php namespace Controllers;

use Models\Brokers\NotificationBroker;
use Models\Brokers\StudentBroker;
use Models\Services\StudentService;

class HomeController extends Controller
{

    public function initializeRoutes()
    {
        $this->get('/', 'index');
        $this->get('/home', 'home');
        $this->get('/profile', 'profile');
        $this->get('/notification/seen/{id}', 'seenNotification');
    }

    public function index()
    {
        return ($this->isLogged()) ? $this->redirect('/home') : $this->redirect('/login');
    }

    public function home()
    {
        $teamMembers = [];
        if (!$this->isUserTeacher()) {
            $student = StudentService::get($this->getUser()['da']);
            $teamMembers = (new StudentBroker())->sameTeamStudent($student->team_id);
        }
        $notifications = (new NotificationBroker())->getStudentNotifications($this->getUser()['id']);
        return $this->render('home', [
            'isTeacher' => $this->isUserTeacher(),
            'teamPoints' => TeamController::getTeamPoints(),
            'teamMembers' => $teamMembers,
            'notifications' => $notifications
        ]);
    }

    public function profile()
    {
        $notifications = (new NotificationBroker())->getStudentNotifications($this->getUser()['id']);
        $weeklyProgress = (new StudentBroker())->getProgressionByWeek($this->getActiveStudent()->da);
        $indProgress = (new StudentBroker())->getProgression($this->getActiveStudent()->da);
        return $this->render('profile/profile', [
            'notifications' => $notifications,
            'weeklyProgress' => $weeklyProgress,
            'individualProgress' => $indProgress
        ]);
    }

    public function seenNotification($id)
    {
        (new NotificationBroker())->seenNotification($id, $this->getUser()['id']);
        return $this->redirect('/home');
    }
}