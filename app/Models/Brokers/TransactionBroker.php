<?php namespace Models\Brokers;

class TransactionBroker extends Broker
{
    public function insert($userId, $description, $cash, $points, $isCashPositive, $isPointsPositive)
    {
        $sql = "insert into codewars.transaction(user_id, date, description, cash, points, is_cash_positive, is_points_positive) values(?, now(), ?, ?, ?, ?, ?)";
        $this->query($sql, [$userId, $description, $cash, $points, $isCashPositive, $isPointsPositive]);
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
        return "Vous avez été " . $cash . "$ et " . $points . " points";
    }

    public static function getActionBought($cash): string
    {
        return "Vous avez  été déduit " . $cash . "$";
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

    public function deleteAllFor($user_id)
    {
        $sql = "delete from codewars.transaction where user_id = ?";
        $this->query($sql, [$user_id]);
    }
}
