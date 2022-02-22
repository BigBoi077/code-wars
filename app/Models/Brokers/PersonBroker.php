<?php namespace Models\Brokers;

use stdClass;

class PersonBroker extends Broker
{
    public function findByDa($da): ?stdClass
    {
        $sql = "SELECT * FROM codewars.person WHERE da = ?";
        return $this->selectSingle($sql, [$da]);
    }

    public function insert($da, $username, $firstname, $lastname, $email = null)
    {
        $sql = "INSERT INTO codewars.person (da, username, firstname, lastname, email) VALUES (?, ?, ?, ?, ?)";
        $this->query($sql, [
            $da,
            $username,
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

    public function update($da, $username, $firstname, $lastname, $email = null)
    {
        $sql = "UPDATE codewars.person SET username = ?, firstname = ?, lastname = ?, email = ? WHERE da = ?";
        $this->query($sql, [
            $username,
            $firstname,
            $lastname,
            $email != null ? $email : $this->getPersonEmail($da),
            $da
        ]);
    }

    public function findByUsername($da, $username)
    {
        $sql = "select * from codewars.person p where p.username = ? and p.da != ?";
        return $this->selectSingle($sql, [$username, $da]);
    }

    public function getPersonEmail($da): ?string
    {
        $sql = "SELECT email FROM codewars.person WHERE da = ?";
        $email = $this->selectSingle($sql, [$da]);
        return $email->email;
    }
}

