<?php namespace Models\Brokers;


use stdClass;

class PersonBroker extends Broker
{

    public function findByDa($da) : ?stdClass
    {
        $sql = "SELECT * FROM codewars.person WHERE da = ?";
        return $this->selectSingle($sql, [$da]);
    }

    public function insert($da, $firstname, $lastname, $email = null)
    {
        $sql = "INSERT INTO codewars.person (da, firstname, lastname, email) VALUES (?, ?, ?, ?)";
        $this->query($sql, [
            $da,
            $firstname,
            $lastname,
            $email
        ]);
    }

    public function delete($da)
    {
        $sql = "DELETE FROM codewars.person WHERE da = ?";
        return $this->query($sql, [$da]);
    }

    public function update($da, $firstname, $lastname, $email = null)
    {
        $sql = "UPDATE codewars.person SET firstname = ?, lastname = ?, email = ? WHERE da = ?";
        $this->query($sql, [$firstname, $lastname, $email, $da]);
    }
}

