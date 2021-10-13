<?php

namespace Models\Brokers;

use Models\Services\NotificationService;
use stdClass;

class ExerciseBroker extends Broker
{

    public function findByID($id) : ?stdClass
    {
        $sql = "SELECT *
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
            $name,
            $difficulty,
            $description,
            $exemple,
            $cash,
            $point,
            $weekId
        ]);
        return $result->id;
    }

    public function submitExercise($student, $exerciseId, $path)
    {
        $sql = "insert into codewars.studentexercise(id, student_da, exercise_id, completed, corrected, comments, dir_path) values (default, ?, ?, true, false, null, ?)";
        $this->query($sql, [$student->da, $exerciseId, $path]);
        NotificationService::newCorrectionAvailable($student);
    }

    public function correctExercise($userId, $student, $id)
    {
        $sql = "update codewars.studentexercise se set corrected = true where se.exercise_id = ? and se.student_da = ? and se.completed = true";
        $this->query($sql, [$id, $student->da]);
        (new StudentBroker())->addCash($student->da, $this->findByID($id)->cash_reward);
        NotificationService::exerciseCorrected($userId);
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
}


