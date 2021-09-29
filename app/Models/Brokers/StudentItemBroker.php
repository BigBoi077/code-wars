<?php

namespace Models\Brokers;

class StudentItemBroker extends Broker
{
    public function deleteWithItemId($itemId)
    {
        $sql = "DELETE FROM codewars.studentitem WHERE item_id = ?";
        $this->query($sql, [$itemId]);
    }
}