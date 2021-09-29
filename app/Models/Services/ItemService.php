<?php

namespace Models\Services;


use Models\Brokers\ItemBroker;

class ItemService
{

    public static function getAll()
    {
        return (new ItemBroker())->getAll();
    }
}