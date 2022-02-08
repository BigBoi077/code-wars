<?php namespace Controllers;

use Models\Brokers\NotificationBroker;
use Models\Brokers\UserBroker;
use Zephyrus\Network\Responses\StreamResponses;

class NotificationController extends Controller
{

    use StreamResponses;

    public function initializeRoutes()
    {
        $this->get('/notification/connect/{da}', 'index');
        $this->overrideArgument('da', function ($value) {
            $user = (new UserBroker())->findByDa($value);
            $notifications = (new NotificationBroker())->getStudentNotifications($user);
            return $notifications;
        });
    }

    public function index($notifications)
    {
        $this->initializeStreaming();
        $this->ssePolling("$notifications");
    }
}
