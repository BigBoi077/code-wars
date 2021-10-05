<?php namespace Controllers;

use Models\Brokers\StudentBroker;
use Models\Brokers\TeamBroker;
use Zephyrus\Network\Response;

class TeamController extends Controller
{

    public function initializeRoutes()
    {
        $this->get('/teams', 'teams');
    }

    public function teams(): Response
    {
        $user = ($this->getUser());
        $broker = new StudentBroker();
        $student= null;
        if (!$user['isTeacher']) {
            $student = $broker->findByDa($user['da']);
        }
        $broker = new TeamBroker();
        $teams['siths'] = $broker->findAllStudentByTeam($broker->getIdByName('Sith'));
        $teams['rebels'] = $broker->findAllStudentByTeam($broker->getIdByName('Rebel'));
        return $this->render("teams", ['user' => $user, 'student' => $student, 'teamPoints' => $this->getTeamsPoints(), 'teams' => $teams]);
    }

    public static function getTeamsPoints(): array
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