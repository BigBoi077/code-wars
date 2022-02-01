<?php

namespace Models\Brokers;

use stdClass;

class TipBroker extends Broker
{
    public function GetById($tipId): stdClass
    {
        $sql = "SELECT t.id, t.tip, t.price
                FROM codewars.tips t
                WHERE t.id = ?";
        return $this->selectSingle($sql, [$tipId]);
    }

    public function GetAllById($id) : array
    {
        $sql = "SELECT t.id, t.tip, t.price
                FROM codewars.tips t join codewars.exercise e on t.exercise_id = e.id
                WHERE e.id = ?
                ORDER BY price";

        return $this->select($sql, [$id]);
    }

    public function GetAllUnlocked($id, $da) : array
    {
        $sql = "SELECT *
                FROM codewars.studenttip st join codewars.tips t on t.id = st.tip_id
                WHERE st.student_da = ? and t.exercise_id = ?
                order by price";

        return $this->select($sql, [$da, $id]);
    }

    public function getAll()
    {
        $sql = "SELECT t.id, t.tip, t.exercise_id 
                FROM codewars.tips t
                ORDER BY t.id";
        return $this->select($sql);
    }

    public function buy($tipId, $da)
    {
        $sql = "insert into codewars.studenttip(id, tip_id, student_da) values(default, ?, ?)";
        $this->query($sql, [$tipId, $da]);
    }

    public function insert($exerciseId, $tip, $price)
    {
        $sql = "INSERT INTO codewars.tips (id, exercise_id, tip, price) VALUES (default, ?, ?, ?)";

        return $this->query($sql, [
            $exerciseId,
            $tip,
            $price
        ]);
    }

    public function update($id, $tip, $price)
    {
        $sql = "UPDATE codewars.tips SET tip = ?, price = ?  WHERE id = ?";
        $this->query($sql, [$tip, $price, $id]);
    }


    public function delete($id)
    {
        $sql = "DELETE FROM codewars.tips WHERE id = ?;";
        return $this->query($sql, [$id]);
    }

    public function Has($tipId, $da): bool
    {
        $sql = "select * from codewars.studenttip t where t.student_da = ? and t.tip_id = ?";
        return $this->selectSingle($sql, [$da, $tipId]) != null;
    }

    public function deleteAllFor($da)
    {
        $sql = "delete from codewars.studenttip st where st.student_da = ?";
        $this->query($sql, [$da]);
    }

    public function deleteAllOf($id)
    {
        $tips = $this->select("select * from codewars.tips t where t.exercise_id = ?", [$id]);
        $sql = "delete from codewars.studenttip t where t.tip_id = ?";
        foreach ($tips as $tip) {
            $this->query($sql, [$tip->id]);
            $this->delete($tip->id);
        }
    }

}