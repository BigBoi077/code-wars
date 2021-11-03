<?php namespace Controllers;

use Models\Brokers\NotificationBroker;
use Models\Brokers\PersonBroker;
use Models\Brokers\StudentBroker;
use Models\Brokers\StudentExerciseBroker;
use Models\Brokers\StudentItemBroker;
use Models\Brokers\UserBroker;
use Models\Services\PersonService;
use Models\Services\ApiService;
use Models\Services\StudentService;
use Zephyrus\Application\Flash;
use Zephyrus\Network\HttpRequester;

class HomeController extends Controller
{
    public function initializeRoutes()
    {
        $this->get('/', 'index');
        $this->get('/home', 'home');
        $this->get('/notification/seen/{id}', 'seenNotification');
        $this->get('/notification/seenAll', 'seenAllNotification');
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
        //$quote = (new HttpRequester("get", "http://swquotesapi.digitaljedi.dk/api/SWQuote/RandomStarWarsQuote"))->execute();
        return $this->render('home', [
            'isTeacher' => $this->isUserTeacher(),
            'teamMembers' => $teamMembers,
            'teamPoints' => TeamController::getTeamPoints(),
            'notifications' => $notifications,
            'quote' => null
        ]);
    }

    public function seenNotification($id)
    {
        (new NotificationBroker())->seenNotification($id, $this->getUser()['id']);
        return $this->redirect('/');
    }

    public function seenAllNotification()
    {
        (new NotificationBroker())->seenAllNotification($this->getUser()['id']);
        return $this->redirect('/');
    }
}