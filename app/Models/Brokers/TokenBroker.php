<?php namespace Models\Brokers;

use stdClass;

class TokenBroker extends Broker
{

    public function insert($user_id, $token)
    {
        $this->query("INSERT INTO codewars.token(user_id, token) VALUES (?, ?)", [
            $user_id,
            $token
        ]);
    }

    public function delete($token)
    {
        $this->query("DELETE FROM codewars.token WHERE token = ?;", [
            $token
        ]);
    }

    public function findUserIdByToken($token): ?int
    {
        $sql = "SELECT * FROM codewars.token WHERE token = ?";
        $row = $this->selectSingle($sql, [$token]);
        return $row->user_id;
    }
}