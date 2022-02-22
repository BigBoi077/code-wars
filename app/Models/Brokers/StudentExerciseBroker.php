<?php namespace Models\Brokers;

class StudentExerciseBroker extends Broker
{
	public function getAllWithDa($da)
	{
		$sql = "SELECT e.id as exercise_id, *
                FROM codewars.studentexercise se
                JOIN codewars.exercise e on e.id = se.exercise_id join codewars.week w on e.week_id = w.id
                WHERE student_da = ? and w.is_active = true
                order by se.submit_date desc";
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
