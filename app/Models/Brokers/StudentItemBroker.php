<?php

namespace Models\Brokers;


use stdClass;

class StudentItemBroker extends Broker
{
    public function deleteWithItemId($itemId)
    {
        $sql = "DELETE FROM codewars.studentitem WHERE item_id = ?";
        $this->query($sql, [$itemId]);
    }

    public function deleteAllStudentItem($da)
    {
        $sql = "DELETE FROM codewars.studentitem WHERE student_da = ?";
        $this->query($sql, [ $da ]);
    }

    public function getAllWithDa($da)
    {
        $sql = "SELECT * FROM codewars.studentitem join codewars.item i on i.id = studentitem.item_id WHERE student_da = ?";
        return $this->select($sql, [$da]);
    }

    public function getWithIdAndDa($item_id, $da)
    {
        $sql = "SELECT * FROM codewars.studentitem AS s WHERE (s.item_id = ? AND s.student_da = ?)";
        return $this->selectSingle($sql, [$item_id, $da]);
    }

    public function insert($item_id, $da)
    {
        $sql = "INSERT INTO codewars.studentitem (item_id, student_da, bought_date) VALUES(?, ?, now())";
        $this->query($sql, [$item_id, $da]);
    }
}