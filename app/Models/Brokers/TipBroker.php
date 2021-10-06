<?php

namespace Models\Brokers;

use stdClass;

class TipBroker extends Broker
{

    public function findByID($id) : ?stdClass
    {
        $sql = "SELECT t.id, t.tip, t.exercise_id
                FROM codewars.tips t
                WHERE t.id = ?";

        return $this->selectSingle($sql, [$id]);
    }

    public function getAll()
    {
        $sql = "SELECT t.id, t.tip, t.exercise_id 
                FROM codewars.tips t
                ORDER BY t.id";
        return $this->select($sql);
    }


    public function insert($id,$tip)
    {
        $sql = "INSERT INTO codewars.tips (exercise_id,tip) VALUES (?,?)";

        return $this->query($sql, [
            $id,
            $tip
        ]);
    }

    public function update($id,$tip)
    {
        $sql = "UPDATE codewars.tips SET tip = ?  WHERE id = ?";
        $this->query($sql, [$id,$tip]);
    }


    public function delete($id)
    {
        $sql = "DELETE FROM codewars.tips WHERE exercise_id = ?;";
        return $this->query($sql, [$id]);
    }

}