<?php namespace Controllers;



use Models\Brokers\NotificationBroker;
use Models\Brokers\StudentBroker;
use Models\Brokers\TeamBroker;

class HomeController extends Controller
{

    public function initializeRoutes()
    {
        $this->get('/', 'index');
        $this->get('/home', 'home');
    }

    public function index()
    {

        return ($this->isLogged()) ? $this->redirect('/home') : $this->redirect('/login');
    }

    public function home()
    {
        $user = ($this->getUser());
        $broker = new StudentBroker();
        $teamMembers = [];
        if ($this->isUserTeacher()) {
            $student = $broker->findByDa($user['da']);
            $teamMembers = $broker->sameTeamStudent($student->team_id);
        }
        $notifications = (new NotificationBroker())->getStudentNotifications($user['id']);
        return $this->render('home', [
            'user' => $user,
            'student' => $student,
            'teamPoints' => TeamController::getTeamsPoints(),
            'teamMembers' => $teamMembers,
            'notifications' => $notifications]);
    }


}