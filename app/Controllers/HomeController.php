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
            'teamPoints' => TeamController::getTeamsPoints(),
            'teamMembers' => $teamMembers,
            'notifications' => $notifications]);
    }

    public function profile()
    {
        $notifications = (new NotificationBroker())->getStudentNotifications($this->getUser()['id']);
        return $this->render('profile', [
            'notifications' => $notifications]
        );
    }
}