<?php namespace Controllers;

use Models\Brokers\ExerciseBroker;
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
        return $this->render("teams/teams", [
            'user' => $user,
            'student' => $student,
            'teamPoints' => $this->getTeamPoints(),
            'teamProgress' => $this->getTeamProgression(Count($teams['siths']), Count($teams['rebels'])),
            'teams' => $teams
        ]);
    }

    public static function getTeamProgression($nbSith, $nbRebel): array
    {
        $broker = new StudentBroker();
        $students = $broker->getAll();
        $teamProgress = ['Sith' => 0, 'Rebel' => 0];
        foreach ($students as $student) {
            $teamProgress[$student->team_name] += $broker->getExerciseDone($student->da);
        }
        $nbExercise = Count((new ExerciseBroker())->getAll());
        $teamProgress['Sith'] = Floor(($teamProgress['Sith'] / ($nbSith * $nbExercise)) * 100);
        $teamProgress['Rebel'] = Floor(($teamProgress['Rebel'] / ($nbRebel * $nbExercise)) * 100);
        return $teamProgress;
    }

    public static function getTeamPoints(): array
    {
        $broker = new StudentBroker();
        $students = $broker->getAll();
        $teamPoints = ['Sith'=> 0, 'Rebel' => 0];
        foreach ($students as $student) {
            $teamPoints[$student->team_name] += $broker->getPoints($student->da);
        }
        $maxPoints = Floor(max($teamPoints) / 100) == 0 ? 100 : (Floor((max($teamPoints) / 100)) * 100) + min($teamPoints);
        $teamPoints['sithWidth'] = $teamPoints['Sith'] / $maxPoints * 100;
        $teamPoints['rebelWidth'] = $teamPoints['Rebel'] / $maxPoints * 100;
        return $teamPoints;
    }
}