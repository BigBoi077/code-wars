<?php


namespace Models\Brokers;


class StudentExerciseBroker extends Broker
{
	public function getAllWithDa($da)
	{
		$sql = "SELECT * FROM codewars.studentexercise JOIN codewars.exercise e on e.id = studentexercise.exercise_id WHERE student_da = ?";
		return $this->select($sql, [$da]);
	}
}