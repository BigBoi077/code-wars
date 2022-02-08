<?php namespace Controllers;

use Models\Brokers\NotificationBroker;
use Models\Brokers\StudentBroker;
use Models\Services\ApiService;
use Models\Services\StudentService;
use Zephyrus\Application\Flash;

class HomeController extends Controller
{
    public function initializeRoutes()
    {
        $this->get('/', 'index');
        $this->get('/home', 'home');
        $this->get('/notification/seeAll', 'seeAllNotifications');
        $this->get('/notification/seen/{id}', 'seeNotification');
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
            'notifications' => $notifications,
            'quote' => null
        ]);
    }

    public function seeNotification($id)
    {
        (new NotificationBroker())->seenNotification($id, $this->getUser()['id']);
        Flash::success("La notification a été cochée comme vue.");
        return $this->redirect('/profile/notifications');
    }

    public function seeAllNotifications()
    {
        (new NotificationBroker())->seeAllNotification($this->getUser()['id']);
        Flash::success("Les notifications ont été cochées comme vues.");
        return $this->redirect('/profile/notifications');
    }
}