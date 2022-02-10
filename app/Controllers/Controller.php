<?php namespace Controllers;

use Models\Brokers\NotificationBroker;
use Models\Logger;
use Models\Services\StudentService;
use Zephyrus\Application\Session;
use Zephyrus\Network\Response;
use Zephyrus\Utilities\Gravatar;

abstract class Controller extends SecurityController
{
    private const LOGIN_ROUTE = '/login';
    private const DEFAULT_PROFILE_PIC = '/assets/images/kakashi.jpeg';
    public const SESSION_IS_LOGGED = 'is_logged';

    /**
     * Override example of the render method to automatically include arguments to be sent to any views for any
     * Controller class extending this middleware. Useful for global data used in layout files.
     *
     * @param string $page
     * @param array $args
     * @return Response
     */
    public function render($page, $args = []): Response
    {
        $student = $this->getActiveStudent();
        $user = $this->getUser();
        $imageUrl = self::DEFAULT_PROFILE_PIC;
        $hasNotifications = false;

        if ($student != null && ($student->email != '' || $student->email != null)) {
            $gravatar = new Gravatar($student->email);
            $imageUrl = $gravatar->getUrl();
        }

        if ($user != null && ($user['email'] != '' || $user['email'] != null)) {
            $gravatar = new Gravatar($user['email']);
            if ($gravatar->isAvailable()) {
                $imageUrl = $gravatar->getUrl();
            }

            $hasNotifications = count((new NotificationBroker())->getStudentAllNotifications($user['id'])) > 0;
        }

        return parent::render($page, array_merge($args, [
            'system_date' => date(FORMAT_DATE_TIME),
            'user' => $user,
            'profileImageUrl' => $imageUrl,
            'student' => $student,
            'hasNotifications' => $hasNotifications,
            'teamPoints' => TeamController::getTeamPoints()
        ]));
    }

    /**
     * This method is called immediately before processing any route in your controller. To break the chain of
     * middleware, you can remove the call to parent::before() method, but it is highly discouraged. Instead, you should
     * always keep the parent call, but place it accordingly to your situation (should the parent's middleware
     * processing be done before or after mine?).
     *
     * If this method returns a Response, the whole execution chain is broken and the Response is directly returned. It
     * is useful for some security validations before any route processing. Should be removed if not used.
     *
     * @return Response | null
     */
    public function before(): ?Response
    {
        if (!$this->isLogged()) {
            if (isset($_COOKIE[REMEMBER_ME])) {
                $logger = new Logger();
                if ($logger->automaticLogin()) {
                    return $this->redirect("/home");
                }
            }
            if ($this->request->getRoute() != self::LOGIN_ROUTE) {
                return $this->redirect(self::LOGIN_ROUTE);
            }
        }
        return parent::before();
    }

    /**
     * This method is called after processing any route in your controller. It receives the processed response as
     * argument which you can modify and then return too to another middleware or the client response. Should be removed
     * if not used.
     *
     * @param Response $response
     * @return Response | null
     */
    public function after(?Response $response): ?Response
    {
        return parent::after($response);
    }

    public function isLogged()
    {
        return Session::getInstance()->has(self::SESSION_IS_LOGGED);
    }

    public function getUser()
    {
        return Session::getInstance()->read('user');
    }

    public function getActiveStudent(): ?\stdClass
    {
        if ($this->getUser() != null && !$this->getUser()['isTeacher']) {
            return StudentService::get($this->getUser()['da']);
        }
        return null;
    }

    public function isUserTeacher(): bool
    {
        return $this->getUser() != null ? $this->getUser()['isTeacher'] : false;
    }
}
