<?php

namespace Models\Brokers;

use Models\Services\NotificationService;
use stdClass;

class ExerciseBroker extends Broker
{

    public function findByID($id) : ?stdClass
    {
        $sql = "SELECT e.id, week_id, name, description, cash_reward, difficulty, execution_exemple, point_reward
                FROM codewars.exercise e join codewars.week w on w.id = e.week_id
                WHERE e.id = ?";
        return $this->selectSingle($sql, [$id]);
    }

    public function getAll(): array
    {
        $sql = "SELECT e.id, e.difficulty, e.name, e.description, e.cash_reward, e.point_reward, e.execution_exemple, w.id as week_id, w.number, w.is_active, w.start_date
                FROM codewars.exercise e join codewars.week w on w.id = e.week_id
                ORDER BY e.id";
        return $this->select($sql);
    }

    public function getAllByWeek($weekId): array
    {
        $sql = "SELECT e.id, e.difficulty, e.name, e.description, e.cash_reward, e.point_reward, e.execution_exemple 
                FROM codewars.exercise e join codewars.week w on w.id = e.week_id where e.week_id = ?";
        return $this->select($sql, [$weekId]);
    }

    public function insert($name,$difficulty,$description,$exemple, $cash, $point, $weekId): int
    {
        $sql = "INSERT INTO codewars.exercise (id, name, difficulty, description, execution_exemple, cash_reward, point_reward, week_id) VALUES (default, ?, ?, ?,?,?,?, ?) RETURNING id";

        $result = $this->selectSingle($sql, [
            ucfirst($name),
            $difficulty,
            $description,
            $exemple,
            $cash,
            $point,
            $weekId
        ]);
        return $result->id;
    }

    public function submitExercise($student, $exerciseId, $path, $fileName)
    {
        $sql = "insert into codewars.studentexercise(id, student_da, exercise_id, completed, corrected, comments, dir_path, submit_date) values (default, ?, ?, true, false, null, ?, now())";
        $this->query($sql, [$student->da, $exerciseId, $path]);
        NotificationService::newCorrectionAvailable($student, $fileName);
    }

    public function updateSubmit($student, $exerciseId, $path)
    {
        $sql = "update codewars.studentexercise se set dir_path = ? where se.exercise_id = ? and se.student_da = ? and se.completed = true";
        $this->query($sql, [$path, $student->da, $exerciseId]);
        NotificationService::newCorrectionAvailable($student, $this->findByID($exerciseId)->name);
    }

    public function correctExercise($userId, $student, $id)
    {
        $sql = "update codewars.studentexercise se set corrected = true where se.id = ? and se.student_da = ? and se.completed = true";
        $this->query($sql, [$id, $student->da]);
        $sql = "select cash_reward, point_reward from codewars.exercise e join codewars.studentexercise s on e.id = s.exercise_id where s.id = ?";
        $reward = $this->selectSingle($sql, [$id]);
        $broker = new StudentBroker();
        $broker->addCash($student->da, $reward->cash_reward);
        $broker->addPoints($student->da, $reward->point_reward);
        NotificationService::exerciseCorrected($userId, $reward->cash_reward, $reward->point_reward);
    }

    public function delete($id)
    {
        $sql = "DELETE FROM codewars.exercise WHERE id = ?;";
        return $this->query($sql, [$id]);
    }

    public function update($id,$name,$difficulty,$description,$exemple,$cash,$point, $weekId)
    {
        $sql = "UPDATE codewars.exercise SET name = ?, difficulty = ?, description = ?, execution_exemple = ?, cash_reward = ?, point_reward = ?, week_id = ? WHERE id = ?";
        $this->query($sql, [$name,$difficulty,$description,$exemple,$cash,$point, $weekId, $id]);
    }

    public function isSubmitted($id, $da): bool
    {
        $sql = "select * from codewars.studentexercise se where se.exercise_id = ? and se.student_da = ? and se.completed = true";
        return $this->selectSingle($sql, [$id, $da]) != null;
    }

    public function isCorrected($id, $da): bool
    {
        $sql = "select * from codewars.studentexercise se where se.exercise_id = ? and se.student_da = ? and se.completed = true and se.corrected = true";
        return $this->selectSingle($sql, [$id, $da]) != null;
    }

    public function getCorrection(): array
    {
        $sql = "select se.id, se.dir_path, se.submit_date, e.id as exercise_id, e.name, s.da as student_da, p.firstname, p.lastname from codewars.studentexercise se join codewars.exercise e on e.id = se.exercise_id join codewars.student s on s.da = se.student_da join codewars.user u on u.da = s.da join codewars.person p on p.da = u.da where se.completed = true and se.corrected = false";
        return $this->select($sql);
    }

    public function getCorrectionPath($id): stdClass
    {
        $sql = "select dir_path as path, e.name as name from codewars.studentexercise se join codewars.exercise e on e.id = se.exercise_id where se.id = ?";
        return $this->selectSingle($sql, [$id]);
    }


}


