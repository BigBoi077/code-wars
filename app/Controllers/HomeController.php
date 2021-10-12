<?php namespace Controllers;

use Models\Brokers\NotificationBroker;
use Models\Brokers\StudentBroker;
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
        $this->get('/profile', 'profile');
        $this->get('/edit_profile', 'editProfile');
        $this->get('/notification/seen/{id}', 'seenNotification');

        $this->post('/update_profile', 'updateProfile');
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
            'teamPoints' => TeamController::getTeamPoints(),
            'teamMembers' => $teamMembers,
            'notifications' => $notifications,
            'quote' => null
        ]);
    }

    public function profile()
    {
        $da = $this->getActiveStudent()->da;
        $notifications = (new NotificationBroker())->getStudentNotifications($this->getUser()['id']);
        $weeklyProgress = (new StudentBroker())->getProgressionByWeek($da);
        $indProgress = (new StudentBroker())->getProgression($da);
        $items = (new StudentItemBroker())->getAllWithDa($da);
        return $this->render('profile/profile', [
            'notifications' => $notifications,
            'weeklyProgress' => $weeklyProgress,
            'individualProgress' => $indProgress,
            'myItems' => $items
        ]);
    }

    public function editProfile()
    {
        return $this->render('profile/edit_profile', [
            'action' => '/update_profile'
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
        return $this->redirect('/edit_profile');
    }

    public function seenNotification($id)
    {
        (new NotificationBroker())->seenNotification($id, $this->getUser()['id']);
        return $this->redirect('/home');
    }
}