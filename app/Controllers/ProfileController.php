<?php namespace Controllers;

use Models\Brokers\NotificationBroker;
use Models\Brokers\PersonBroker;
use Models\Brokers\StudentBroker;
use Models\Brokers\StudentExerciseBroker;
use Models\Brokers\StudentItemBroker;
use Models\Brokers\UserBroker;
use Models\Services\PersonService;
use Zephyrus\Application\Flash;
use Zephyrus\Application\Rule;

class ProfileController extends Controller
{
    public function initializeRoutes()
    {
        $this->get('/profile', 'profile');
        $this->get('/profile/edit', 'editProfile');
        $this->get("/profile/editMdp", 'editMdp');
        $this->get('/profile/notifications', 'notifications');
        $this->post('/profile/update', 'updateProfile');
        $this->post('/profile/update/mdp', 'updateMdp');
    }

    public function profile()
    {
        if ($this->getUser()['isTeacher']) {
            return $this->redirect('/home');
        }

        $student = $this->getActiveStudent();
        $weeklyProgress = (new StudentBroker())->getProgressionByWeek($student->da);
        $indProgress = (new StudentBroker())->getProgression($student->da);
        $items = (new StudentItemBroker())->getAllWithDa($student->da);
        $studentExercises = (new StudentExerciseBroker())->getAllWithDa($student->da);
        $teacher = (new PersonBroker())->findByDa(0);
        return $this->render('profile/profile', [
            'isTeacher' => false,
            'studentProfile' => $student,
            'weeklyProgress' => $weeklyProgress,
            'individualProgress' => $indProgress,
            'items' => $items,
            'exercises' => $studentExercises,
            'teacher' => $teacher
        ]);
    }

    public function notifications()
    {
        $notifications = (new NotificationBroker())->getStudentAllNotifications($this->getUser()['id']);
        return $this->render('profile/notifications', [
            'notifications' => $notifications,
            'teamPoints' => TeamController::getTeamPoints()
        ]);
    }

    public function editProfile()
    {
        return $this->render('profile/edit_profile');
    }

    public function editMdp()
    {
        return $this->render('profile/edit_mdp');
    }

    public function updateProfile()
    {
        $profile = PersonService::update($this->getActiveStudent()->da, $this->buildForm());
        if ($profile->hasSucceeded()) {
            Flash::success('Profil modifié avec succès!');
            return $this->redirect('/profile');
        }
        Flash::error($profile->getErrorMessages());
        return $this->redirect('/profile/edit');
    }

    public function updateMdp()
    {
        $form = $this->buildForm();
        $userPassword = (new UserBroker())->getHashedPassword($this->getUser()['da']);
        if (!password_verify($form->getValue("currentPassword") . PASSWORD_PEPPER, $userPassword)) {
            Flash::error("Ancien mot de passe invalide, veuillez saisir votre mot de passe.");
            return $this->redirect($this->request->getReferer());
        }
        $form->validate('password', Rule::passwordCompliant('Le mot de passe doit contenir une minuscule, une majuscule, un chiffre et avoir une longueur minimum de 8 caractères.'));
        if ($form->getValue('confirmPassword') != '') {
            $form->validate('confirmPassword', Rule::sameAs('password', 'La confirmation de mot de passe doit être identique au mot de passe.'));
        } else {
            $form->validate('confirmPassword', Rule::notEmpty('La confirmation de mot de passe est requise.'));
        }
        if (!$form->verify()) {
            Flash::error($form->getErrorMessages());
            return $this->redirect($this->request->getReferer());
        }
        (new UserBroker())->update($this->getUser()['da'], password_hash($form->getValue("password") . PASSWORD_PEPPER, PASSWORD_DEFAULT));

        Flash::success("Votre mot de passe a été modifié avec succès!");
        return $this->redirect('/profile');
    }
}
