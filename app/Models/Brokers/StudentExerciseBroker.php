<?php namespace Models\Brokers;

class StudentExerciseBroker extends Broker
{
	public function getAllWithDa($da)
	{
		$sql = "SELECT * 
                FROM codewars.studentexercise se
                JOIN codewars.exercise e on e.id = se.exercise_id 
                WHERE student_da = ?
                order by se.submit_date desc";
		return $this->select($sql, [$da]);
	}

    public function findById($id)
    {
        $sql = "SELECT ex.id as se_id, *
                FROM codewars.studentexercise ex join codewars.student s on s.da = ex.student_da join codewars.user u on u.da = s.da join codewars.person p on p.da = u.da join codewars.exercise e on ex.exercise_id = e.id
                WHERE ex.id = ?";
        return $this->selectSingle($sql, [$id]);
    }
}
