<?php namespace Models\Brokers;


use stdClass;

class PersonBroker extends Broker
{

    public function findByDa($da) : ?stdClass
    {
        $sql = "SELECT * FROM codewars.person WHERE da = ?";
        return $this->selectSingle($sql, [$da]);
    }

    public function insert($da, $firstname, $lastname)
    {
        $sql = "INSERT INTO codewars.person (da, firstname, lastname) VALUES (?, ?, ?)";
        $this->query($sql, [
            $da,
            $firstname,
            $lastname,
        ]);
    }

    public function delete($da)
    {
        $sql = "DELETE FROM codewars.person WHERE da = ?";
        return $this->query($sql, [$da]);
    }

    public function update($da, $firstname, $lastname)
    {
        $sql = "UPDATE codewars.person SET firstname = ?, lastname = ? WHERE da = ?";
        $this->query($sql, [$firstname, $lastname, $da]);
    }
}

