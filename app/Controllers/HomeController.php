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
        $student = $broker->findByDa($user['da']);
        $teamMembers = $broker->sameTeamStudent($student->team_id);
        $notifications = (new NotificationBroker())->getStudentNotifications($user['id']);
        return $this->render('home', ['user' => $user, 'student' => $student, 'teamPoints' => $this->getTeamsPoints(), 'teamMembers' => $teamMembers, 'notifications' => $notifications]);
    }

    private function getTeamsPoints(): array
    {
        $broker = new StudentBroker();
        $students = $broker->getAll();
        $teamPoints = ['Sith'=> 0, 'Rebel' => 0];
        foreach ($students as $student) {
            $teamPoints[$student->team_name] += $broker->getPoints($student->da);
        }
        $maxPoints = Floor(max($teamPoints) / 100) == 0 ? 100 : Floor(max($teamPoints) / 100) * 100;
        $teamPoints['sithWidth'] = $teamPoints['Sith'] / $maxPoints * 100;
        $teamPoints['rebelWidth'] = $teamPoints['Rebel'] / $maxPoints * 100;
        return $teamPoints;
    }
}