<?php namespace Models\Services;

use Models\Brokers\StudentItemBroker;

class StudentItemService
{
    public static function getAllByDa($da)
    {
        return (new StudentItemBroker())->getAllWithDa($da);
    }

    public static function exists($item_id, $da): bool
    {
        return (new StudentItemBroker())->getWithIdAndDa($item_id, $da) != null;
    }

    public static function create($item_id, $da)
    {
        (new StudentItemBroker())->insert($item_id, $da);
    }
}