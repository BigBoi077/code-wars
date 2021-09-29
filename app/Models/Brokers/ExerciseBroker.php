<?php

namespace Models\Brokers;

use stdClass;

class ExerciseBroker extends Broker
{

    public function findByID($id) : ?stdClass
    {
        $sql = "SELECT e.id, e.difficulty, e.name, e.description, e.cash_reward, e.point_reward, e.execution_exemple 
                FROM codewars.exercise e 
                WHERE e.id = ?";

        return $this->selectSingle($sql, [$id]);
    }

    public function getAll()
    {
        $sql = "SELECT e.id, e.difficulty, e.name, e.description, e.cash_reward, e.point_reward, e.execution_exemple 
                FROM codewars.exercise e
                ORDER BY e.id";
        return $this->select($sql);
    }

    // TODO: Change Insert
    public function insert($name,$difficulty,$description,$exemple,$cash,$point): int
    {
        $sql = "INSERT INTO codewars.exercise (name, difficulty, description, execution_exemple, cash_reward, point_reward) VALUES (?, ?, ?,?,?,?) RETURNING id";

        return $this->selectSingle($sql, [
            $name,
            $difficulty,
            $description,
            $exemple,
            $cash,
            $point
        ])->id;
    }

    public function delete($id)
    {
        $sql = "DELETE FROM codewars.exercise WHERE id = ?;";
        return $this->query($sql, [$id]);
    }

    //TODO: Change Update
    public function update($id,$name,$difficulty,$description,$exemple,$cash,$point)
    {
        $sql = "UPDATE codewars.exercise SET name = ?, difficulty = ?, description = ?, execution_exemple = ?, cash_reward = ?, point_reward = ? WHERE id = ?";
        $this->query($sql, [$id,$name,$difficulty,$description,$exemple,$cash,$point]);
    }
}


