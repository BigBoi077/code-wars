<?php namespace Models\Brokers;


class StudentExerciseBroker extends Broker
{
	public function getAllWithDa($da)
	{
		$sql = "SELECT * 
                FROM codewars.studentexercise 
                JOIN codewars.exercise e on e.id = studentexercise.exercise_id 
                WHERE student_da = ?";
		return $this->select($sql, [$da]);
	}

    public function findById($id)
    {
        $sql = "SELECT ex.id as se_id, *
                FROM codewars.studentexercise ex join codewars.student s on s.da = ex.student_da join codewars.user u on u.da = s.da join codewars.person p on p.da = u.da
                WHERE ex.id = ?";
        return $this->selectSingle($sql, [$id]);
    }
}