<?php

namespace Models\Brokers;

class ItemBroker extends Broker
{


    public function getAll()
    {
        $sql = "SELECT * FROM codewars.item ORDER BY name";
        return $this->select($sql);
    }

    public function findById($id)
    {
        $sql = "SELECT * FROM codewars.item WHERE id = ?";
        return $this->selectSingle($sql, [$id]);
    }

    public function findByName($name)
    {
        $sql = "SELECT * FROM codewars.item WHERE name = ?";
        return $this->selectSingle($sql, [$name]);
    }

    public function insert($name, $price, $description)
    {
        $sql = "INSERT INTO codewars.item (name, price, description) VALUES(?, ?, ?)";
        $this->query($sql, [$name, $price, $description]);
    }
}