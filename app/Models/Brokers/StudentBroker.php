<?php namespace Models\Brokers;

use stdClass;

class StudentBroker extends Broker
{

    public function findByDa($da) : ?stdClass
    {
        $sql = "SELECT s.da, s.team_id, s.cash, p.firstname, p.lastname from codewars.student s 
                join codewars.user u on s.da = u.da
                join codewars.person p on u.da = p.da
                WHERE s.da = ?";
        return $this->selectSingle($sql, [$da]);
    }

    public function getAll()
    {
        $sql = "SELECT s.da, s.team_id, s.cash, p.firstname, p.lastname, t.name as team_name from codewars.student s 
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
        $sql = "SELECT s.da, s.team_id, s.cash, p.firstname, p.lastname from codewars.student s 
                join codewars.user u on s.da = u.da
                join codewars.studentitem si on s.da = si.da
                WHERE s.da = ?";
        return $this->selectSingle($sql, [$da]) != null;
    }
}