<?php


namespace Models\Brokers;


use stdClass;

class PersonBroker extends Broker
{

    public function findByDa($da) : ?stdClass
    {
        $sql = "SELECT * FROM codewars.person WHERE da = ?";
        return $this->selectSingle($sql, [$da]);
    }
}