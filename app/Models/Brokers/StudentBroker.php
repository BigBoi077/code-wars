<?php namespace Models\Brokers;

use stdClass;

class StudentBroker extends Broker
{

    public function findByDa($da) : ?stdClass
    {
        $sql = "SELECT s.da, s.team_id, t.name team_name, s.cash, p.firstname, p.lastname, p.email from codewars.student s 
                join codewars.user u on s.da = u.da
                join codewars.person p on u.da = p.da
                join codewars.team t on t.id = s.team_id
                WHERE s.da = ?";
        $student = $this->selectSingle($sql, [$da]);
        if ($student != null) {
            $student->points = $this->getPoints($da);
        }
        return $student;
    }

    public function getPoints($da): int
    {
        $sql = "select sum(e.point_reward) points from codewars.student s join codewars.studentexercise se on s.da = se.student_da join codewars.exercise e on e.id = se.exercise_id where s.da = ? and se.completed = true";
        $points = $this->selectSingle($sql, [$da])->points;
        return $points == null ? 0 : $points;
    }

    public function getProgression($da): array
    {
        $sql = "select count(e.id) done from codewars.student s join codewars.studentexercise se on s.da = se.student_da join codewars.exercise e on e.id = se.exercise_id join codewars.week w on e.week_id = w.id where s.da = ? and se.completed = true";
        $done = $this->selectSingle($sql, [$da])->done;
        $nbExercises = Count((new ExerciseBroker())->getAll());
        $totalDone = ($done / $nbExercises) * 100;
        return ["totalDone" => $totalDone, "nbExercicesTotal" => $nbExercises, "nbExercisesDone" => $done];
    }

    public function getProgressionByWeek($da): array
    {
        $sql = "select w.id, w.number, w.start_date, count(e.id) done from codewars.student s join codewars.studentexercise se on s.da = se.student_da join codewars.exercise e on e.id = se.exercise_id join codewars.week w on e.week_id = w.id where s.da = ? and se.completed = true group by w.id";
        $weeks = $this->select($sql, [$da]);
        $broker = new ExerciseBroker();
        foreach ($weeks as $week) {
            $week->progress = number_format(($week->done / Count($broker->getAllByWeek($week->id))) * 100, 0);
        }
        return $weeks;
    }

    public function getExerciseDone($da): int
    {
        $sql = "select count(e.id) done from codewars.student s join codewars.studentexercise se on s.da = se.student_da join codewars.exercise e on e.id = se.exercise_id where s.da = ? and se.completed = true";
        return $this->selectSingle($sql, [$da])->done;
    }

    public function getAll()
    {
        $sql = "SELECT s.da, s.team_id, s.cash, p.firstname, p.lastname, t.name as team_name, p.email  from codewars.student s 
                join codewars.user u on s.da = u.da
                join codewars.person p on u.da = p.da
				join codewars.team t on s.team_id = t.id
                ORDER BY s.da";
        return $this->select($sql);
    }

    public function insert($da, $team_id, $cash)
    {
        $sql = "INSERT INTO codewars.student (da, team_id, cash) VALUES (?, ?, ?)";
        $this->query($sql, [
            $da,
            $team_id,
            $cash
        ]);
    }

    public function delete($da)
    {
        $sql = "DELETE FROM codewars.student WHERE da = ?;";
        return $this->query($sql, [$da]);
    }

    public function update($da, $team_id, $cash)
    {
        $sql = "UPDATE codewars.student SET team_id = ?, cash = ? WHERE da = ?";
        $this->query($sql, [$team_id, $cash, $da]);
    }

    public function hasItem($da): bool
    {
        $sql = "SELECT s.da, s.team_id from codewars.student s 
                join codewars.user u on s.da = u.da
                join codewars.studentitem si on s.da = si.student_da
                WHERE s.da = ?";
        return $this->selectSingle($sql, [$da]) != null;
    }

    public function sameTeamStudent($teamId): array
    {
        $sql = "SELECT s.da, s.team_id, s.cash, p.firstname, p.lastname, t.name as team_name from codewars.student s  join codewars.user u on s.da = u.da join codewars.person p on u.da = p.da join codewars.team t on s.team_id = t.id where t.id = ? order by s.cash desc";
        $teamMembers =  $this->select($sql, [$teamId]);
        foreach ($teamMembers as $member) {
            $member->points = $this->getPoints($member->da);
        }
        $points= array_column($teamMembers, 'points');
        array_multisort($points, SORT_DESC, $teamMembers);
        return $teamMembers;
    }
}