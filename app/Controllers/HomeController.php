<?php namespace Controllers;

use Models\Brokers\NotificationBroker;
use Models\Brokers\StudentExerciseBroker;
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
        return ($this->isLogged()) ? ((!$this->getUser()['isTeacher']) ? $this->redirect('/home') : $this->redirect('/management/correction')) : $this->redirect('/login');
    }

    public function home()
    {
        $studentExercises = (new StudentExerciseBroker())->getAllWithDa($this->getUser()['da']);
        //$quote = (new HttpRequester("get", "http://swquotesapi.digitaljedi.dk/api/SWQuote/RandomStarWarsQuote"))->execute();
        return $this->render('home', [
            'isTeacher' => $this->isUserTeacher(),
            'quote' => null,
            'exercises' => $studentExercises
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
