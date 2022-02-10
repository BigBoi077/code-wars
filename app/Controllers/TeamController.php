<?php namespace Controllers;

use Models\Brokers\ExerciseBroker;
use Models\Brokers\StudentBroker;
use Models\Brokers\TeamBroker;
use Models\Services\StudentService;
use Zephyrus\Network\Response;

class TeamController extends Controller
{
    public function initializeRoutes()
    {
        $this->get('/teams', 'teams');
        $this->get('/leaderboard', 'leaderboard');
    }

    public function teams(): Response
    {
        $user = ($this->getUser());
        $broker = new StudentBroker();
        $student = null;
        if (!$user['isTeacher']) {
            $student = $broker->findByDa($user['da']);
        }
        $broker = new TeamBroker();
        $teams['siths'] = $broker->findAllStudentByTeam($broker->getIdByName('Sith'));
        $teams['rebels'] = $broker->findAllStudentByTeam($broker->getIdByName('Rebel'));
        return $this->render("teams/teams", [
            'user' => $user,
            'student' => $student,
            'teamProgress' => $this->getTeamProgression(count($teams['siths']), count($teams['rebels'])),
            'teams' => $teams
        ]);
    }

    public function leaderboard()
    {
        $students = StudentService::getAll();
        $current = null;
        if (!$this->getUser()['isTeacher']) {
            $index = 0;
            $current = StudentService::get($this->getUser()['da']);
            foreach ($students as $student) {
                if ($current->id === $student->id) {
                    $current->position = $index + 1;
                }
                $index++;
            }
        }

        return $this->render('teams/leaderboard', [
            'students' => $students,
            'current' => $current
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
        $nbExercise = count((new ExerciseBroker())->getAll());

        $teamProgress['Sith'] = ($nbSith == 0) ? 0 : round($teamProgress['Sith'] / ($nbSith * $nbExercise) * 100, 2);
        $teamProgress['Rebel'] = ($nbRebel == 0) ? 0 : round($teamProgress['Rebel'] / ($nbRebel * $nbExercise) * 100, 2);

        return $teamProgress;
    }

    public static function getTeamPoints(): array
    {
        $broker = new StudentBroker();
        $students = $broker->getAll();
        $teamPoints = ['Sith'=> 0, 'Rebel' => 0];
        foreach ($students as $student) {
            $teamPoints[$student->team_name] += $student->points;
        }
        $maxPoints = floor(max($teamPoints) / 100) == 0 ? 100 : (floor((max($teamPoints) / 100)) * 100) + 100;
        $teamPoints['sithWidth'] = $teamPoints['Sith'] / $maxPoints * 100;
        $teamPoints['rebelWidth'] = $teamPoints['Rebel'] / $maxPoints * 100;
        return $teamPoints;
    }
}