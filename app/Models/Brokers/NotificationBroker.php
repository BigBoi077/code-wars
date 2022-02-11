<?php namespace Models\Brokers;

class NotificationBroker extends Broker
{
    public function getStudentNotifications($userId): array
    {
        $sql = "select * from codewars.notification n where n.user_id = ? and n.is_seen = false order by n.date desc";
        return $this->select($sql, [$userId]);
    }

    public function getStudentAllNotifications($userId): array
    {
        $sql = "select * from codewars.notification n where n.user_id = ? and n.is_seen = false";
        return $this->select($sql, [$userId]);
    }

    public function seenNotification($notificationId, $userId)
    {
        $sql = "update codewars.notification set is_seen = true where id = ? and user_id = ?";
        $this->query($sql, [$notificationId, $userId]);
    }

    public function seeAllNotification($userId)
    {
        $sql = "update codewars.notification n set is_seen = true where n.user_id = ? and n.is_seen = false";
        $this->query($sql, [$userId]);
    }

    public function cleanseNotifications()
    {
        $sql = "delete from codewars.notification n where n.date < CURRENT_DATE - 30 and n.is_seen = true";
    }

    public function sendNotificationToSpecificStudent($userId, $msg, $name)
    {
        $sql = "insert into codewars.notification(id, user_id, name, is_seen, description, date) values(default, ?, ?, false, ?, now())";
        $this->query($sql, [$userId, $name, $msg]);
    }

    public function sendNotificationToStudents($msg, $name)
    {
        $userBroker = new UserBroker();
        $students = (new StudentBroker())->getAll();
        $sql = "insert into codewars.notification(id, user_id, name, is_seen, description, date) values(default, ?, ?, false, ?, now())";
        foreach ($students as $student) {
            $this->query($sql, [($userBroker->findByDa($student->da))->id, $name, $msg]);
        }
    }

    public function sendNotificationToTeachers($msg, $name)
    {
        $userBroker = new UserBroker();
        $users = $userBroker->findAll();
        $sql = "insert into codewars.notification(id, user_id, name, is_seen, description, date) values(default, ?, ?, false, ?, now())";
        foreach ($users as $user) {
            if ($userBroker->isTeacher($user->da)) {
                $this->query($sql, [$user->id, $name, $msg]);
            }
        }
    }
}