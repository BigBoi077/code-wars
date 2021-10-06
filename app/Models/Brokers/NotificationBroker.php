<?php namespace Models\Brokers;

class NotificationBroker extends Broker
{
    public function getStudentNotifications($userId): array
    {
        $sql = "select * from codewars.notification n where n.user_id = ? and n.is_seen = false";
        return $this->select($sql, [$userId]);
    }
}