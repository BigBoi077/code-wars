<?php namespace Models\Brokers;

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

    public function deleteWithUserId($user_id)
    {
        $this->query("DELETE FROM codewars.token WHERE user_id = ?;", [
            $user_id
        ]);
    }

    public function findUserIdByToken($token): ?int
    {
        $sql = "SELECT * FROM codewars.token WHERE token = ?";
        $row = $this->selectSingle($sql, [$token]);
        return $row->user_id;
    }

    public function verifyUserActiveToken($user_id): bool
    {
        $sql = "SELECT * FROM codewars.token WHERE user_id = ?";
        $row = $this->selectSingle($sql, [$user_id]);
        return $row != null;
    }
}
