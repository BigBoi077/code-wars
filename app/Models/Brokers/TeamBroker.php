<?php

namespace Models\Brokers;

class TeamBroker extends Broker
{

    public function getAll()
    {
        $sql = "SELECT * FROM codewars.team";
        return $this->select($sql);
    }
}