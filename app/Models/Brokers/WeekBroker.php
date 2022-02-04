<?php namespace Models\Brokers;

use stdClass;

class WeekBroker extends Broker
{
    public function findByID($id) : ?stdClass
    {
        $sql = "SELECT w.id, w.start_date, w.is_active
                FROM codewars.week w
                WHERE w.id = ?";

        return $this->selectSingle($sql, [$id]);
    }

    public function getAll()
    {
        $sql = "SELECT w.id, w.start_date, w.is_active, w.number
                FROM codewars.week w order by w.number asc";
        return $this->select($sql);
    }

    public function insert($date, $number)
    {
        $sql = "INSERT INTO codewars.week(id, number, start_date, is_active) VALUES (default, ?, ?, false)";
        return $this->query($sql, [$number, $date]);
    }

    public function delete($id): bool
    {
        if ((new ExerciseBroker())->getAllByWeek($id) != null) {
            return false;
        }
        $sql = "DELETE FROM codewars.week WHERE id = ?;";
        $this->query($sql, [$id]);
        return true;
    }

    public function activate($id)
    {
        $week = $this->findByID($id);
        $sql = "update codewars.week set is_active = ? where id = ?";
        $this->query($sql, [!$week->is_active, $id]);
    }
}