<?php

namespace Models\Brokers;

class ItemBroker extends Broker
{
    public function getAll(): array
    {
        $sql = "SELECT * FROM codewars.item ORDER BY price, name";
        return $this->select($sql);
    }

    public function findById($id): \stdClass
    {
        $sql = "SELECT * FROM codewars.item WHERE id = ?";
        return $this->selectSingle($sql, [$id]);
    }

    public function findByName($name): \stdClass
    {
        $sql = "SELECT * FROM codewars.item WHERE name = ?";
        return $this->selectSingle($sql, [$name]);
    }

    public function insert($name, $price, $description)
    {
        $sql = "INSERT INTO codewars.item (name, price, description) VALUES(?, ?, ?)";
        $this->query($sql, [ucfirst($name), $price, $description]);
    }

    public function update($id, $name, $price, $description)
    {
        $sql = "UPDATE codewars.item SET name = ?, price = ?, description = ? WHERE id = ?";
        $this->query($sql, [ucfirst($name), $price, $description, $id]);
    }

    public function delete($id)
    {
        $sql = "DELETE FROM codewars.item WHERE id = ?";
        $this->query($sql, [$id]);
    }
}
