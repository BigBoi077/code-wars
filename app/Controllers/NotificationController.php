<?php namespace Controllers;

use Models\Brokers\NotificationBroker;
use Models\Brokers\UserBroker;
use Zephyrus\Network\Response;

class NotificationController extends Controller
{
    public function initializeRoutes()
    {
        $this->get('/notification/connect/{da}', 'index');
    }

    public function index($da): Response
    {
        $user = (new UserBroker())->findByDa($da);
        return parent::ssePolling($this->json((new NotificationBroker())->getStudentNotifications($user->id)), 'stream', 3000);
    }
}
