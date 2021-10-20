<?php namespace Controllers;

use Models\Brokers\NotificationBroker;
use Models\Brokers\StudentBroker;
use Models\Brokers\StudentItemBroker;
use Models\Services\PersonService;
use Zephyrus\Application\Flash;

class ProfileController extends Controller
{

    public function initializeRoutes()
    {
        $this->get('/profile', 'profile');
        $this->get('/edit_profile', 'editProfile');
        $this->post('/update_profile', 'updateProfile');
        $this->get('/profile/notifications', 'notifications');
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

    public function notifications()
    {
        $notifications = (new NotificationBroker())->getStudentAllNotifications($this->getUser()['id']);
        return $this->render('profile/notifications', [
            'notifications' => $notifications,
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
}