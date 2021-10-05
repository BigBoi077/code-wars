<?php namespace Models\Brokers;

class TeamBroker extends Broker
{

    public function getAll()
    {
        $sql = "SELECT * FROM codewars.team";
        return $this->select($sql);
    }

    public function findById($id)
    {
        $sql = "SELECT * FROM codewars.team WHERE id = ?";
        return $this->selectSingle($sql, [$id]);
    }

    public function getIdByName($name): int
    {
        $sql = "SELECT id FROM codewars.team WHERE name = ?";
        return $this->selectSingle($sql, [$name])->id;
    }

    public function findAllStudentByTeam($id): array
    {
        $sql = "select * from codewars.team join codewars.student s on team.id = s.team_id join codewars.person p on p.da = s.da where s.team_id = ?";
        $students = $this->select($sql, [$id]);
        $broker = new StudentBroker();
        foreach ($students as $student) {
            $student->points = $broker->getPoints($student->da);
        }
        $points= array_column($students, 'points');
        array_multisort($points, SORT_DESC, $students);
        return $students;
    }
}