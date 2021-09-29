<?php

namespace Models\Brokers;

use stdClass;

class WeekBroker extends Broker
{

    public function findByID($id) : ?stdClass
    {
        $sql = "SELECT w.id, w.start_date, w.is_active
                FROM codewars.week w
                WHERE w.id = ?";

        return $this->selectSingle($sql, [$id]);
    }

    public function getAll()
    {
        $sql = "SELECT w.id, w.start_date, w.is_active 
                FROM codewars.week w
                ORDER BY w.id";
        return $this->select($sql);
    }

    // TODO: Change Insert
    public function insert($id,$date,$activate)
    {
        $sql = "INSERT INTO codewars.week (number,start_date,is_active) VALUES (?,?,?)";

        return $this->query($sql, [
            $id,
            $date,
            $activate
        ]);
    }

    //TODO: Change Update
    public function update($id,$date,$activate)
    {
        $sql = "UPDATE codewars.week SET start_date = ?, is_active = ?  WHERE id = ?";
        $this->query($sql, [$id,$date,$activate]);
    }
}