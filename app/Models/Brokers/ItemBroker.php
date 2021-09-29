<?php

namespace Models\Brokers;

class ItemBroker extends Broker
{


    public function getAll()
    {
        $sql = "SELECT * FROM codewars.item ORDER BY name";
        return $this->select($sql);
    }
}