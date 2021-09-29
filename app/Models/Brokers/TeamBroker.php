<?php

namespace Models\Brokers;

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
}