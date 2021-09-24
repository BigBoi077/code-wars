<?php


namespace Models\Brokers;


use stdClass;

class UserBroker extends Broker
{

    public function findByDa($da) : ?stdClass
    {
        $sql = "SELECT * FROM codewars.user WHERE da = ?";
        return $this->selectSingle($sql, [$da]);
    }

    public function findByID($id) : ?stdClass
    {
        $sql = "SELECT * FROM codewars.user WHERE id = ?";
        return $this->selectSingle($sql, [$id]);
    }

    public function isTeacher($da): bool
    {
        $sql = "SELECT t.da from codewars.user u join codewars.teacher t on u.da = t.da WHERE u.da = ?";
        return $this->selectSingle($sql, [$da]) != null;
    }
}