<?php namespace Models\Brokers;

class TransactionBroker extends Broker
{
    public function insert($userId, $action, $description = 'Aucune')
    {
        $sql = "insert into codewars.transaction(action, date, description, user_id) values(?, now(), ?, ?)";
        $this->query($sql, [$action, $description, $userId]);
    }

    public function getAllByUser($userId): array
    {
        $sql = "select * from codewars.transaction t where t.user_id = ? order by t.date desc limit 20";
        return $this->select($sql, [$userId]);
    }

    public static function getActionForRapidAction($cash, $points): string
    {
        $cash = TransactionBroker::addSub($cash);
        $points = TransactionBroker::addSub($points);
        return "Il vous a été " . $cash . "$ et " . $points . " points";
    }

    public static function getActionBought($cash): string
    {
        return "Il vous a été déduit " . $cash . "$";
    }

    private static function addSub($value): string
    {
        if ($value >= 0) {
            $value = "ajouté " . number_format($value, 0, '.', ' ');
        } else {
            $value = "déduit " . ($value * -1);
        }
        return $value;
    }
}