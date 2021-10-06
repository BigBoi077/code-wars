<?php

namespace Models;

use Models\Brokers\StudentBroker;
use Models\Services\ItemService;
use Models\Services\StudentItemService;
use Models\Services\StudentService;
use stdClass;

class Transaction
{
    private $success = false;
    private $errorMessages;

    public function __construct($item_id, $da)
    {
        $this->errorMessages = array();
        $this->processTransaction($item_id, $da);
    }

    public function getErrorMessages(): array
    {
        return $this->errorMessages;
    }

    public function hasSucceeded(): bool
    {
        return $this->success;
    }

    private function itemValidation($id): bool
    {
        if (!ItemService::exists($id)) {
            array_push($this->errorMessages, 'Article invalide.');
            return false;
        }
        return true;
    }

    private function studentValidation($da): bool
    {
        if (!StudentService::exists($da)) {
            array_push($this->errorMessages, 'Une erreur est survenue.');
            return false;
        }
        return true;
    }

    private function processTransaction($item_id, $da)
    {
        if (!$this->itemValidation($item_id) || !$this->studentValidation($da)) {
            return;
        }
        $item = ItemService::get($item_id);
        $student = StudentService::get($da);
        if ($student->cash < $item->price) {
            array_push($this->errorMessages, 'Pas assez d\'argent.');
            return;
        }
        if (StudentItemService::exists($item_id, $da)) {
            array_push($this->errorMessages, 'Article déjà acheté.');
            return;
        }
        StudentItemService::create($item_id, $da);
        (new StudentBroker())->update($student->da, $student->team_id, $student->cash - $item->price); //TODO mettre dans le service ?
        $this->success = true;
    }
}