<?php namespace Models\Brokers;

class StudentExerciseBroker extends Broker
{
    public function getAllWithDa($da) {
        $sql = "SELECT e.id AS exercise_id, *
                FROM codewars.studentexercise se
                JOIN codewars.exercise e ON e.id = se.exercise_id 
                JOIN codewars.week w ON e.week_id = w.id
                WHERE student_da = ? AND w.is_active = true
                ORDER BY se.submit_date DESC";
        return $this->select($sql, [$da]);
    }

    public function findById($id): ?\stdClass
    {
        $sql = "SELECT ex.id as se_id, *
                FROM codewars.studentexercise ex join codewars.student s on s.da = ex.student_da join codewars.user u on u.da = s.da join codewars.person p on p.da = u.da join codewars.exercise e on ex.exercise_id = e.id
                WHERE ex.id = ?";
        return $this->selectSingle($sql, [$id]);
    }
}
