<?php

namespace Models\Brokers;

class StudentBroker extends Broker
{

    public function getAll()
    {
        $sql = "SELECT s.da, s.team_id, s.cash, p.firstname, p.lastname from codewars.student s 
                join codewars.user u on s.da = u.da
                join codewars.person p on u.da = p.da";
        return $this->select($sql);
    }
}