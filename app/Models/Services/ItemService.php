<?php

namespace Models\Services;


use Models\Brokers\ItemBroker;
use stdClass;
use Zephyrus\Application\Form;
use Zephyrus\Application\Rule;

class ItemService
{

    private $success = false;
    private Form $form;
    private $errorMessages;

    public static function create(Form $form)
    {
        $instance = new self();
        $instance->form = $form;
        if ($instance->applyRules() && $instance->isNameAvailable()) {
            $instance->insertToDatabase();
        }
        return $instance;
    }

    public static function getAll()
    {
        return (new ItemBroker())->getAll();
    }

    public static function exists($id)
    {
        return (new ItemBroker())->findById($id) != null;
    }

    public static function get($id): stdClass
    {
        return (new ItemBroker())->findById($id);
    }

    private function applyRules(): bool
    {
        $this->form->validate('name', Rule::notEmpty('Le nom est requis.'));
        $this->form->validate('name', Rule::name('Le nom ne doit pas contenir de chiffres.'));
        $this->form->validate('price', Rule::notEmpty('Le prix est requis.'));
        $this->form->validate('price', Rule::integer('Le prix doit être un nombre.'));
        $this->form->validate('description', Rule::notEmpty('La description est requise.'));
        if (!$this->form->verify()) {
            $this->errorMessages = $this->form->getErrorMessages();
            return false;
        }
        return true;
    }

    private function isNameAvailable(): bool
    {
        if ((new ItemBroker())->findByName($this->form->getValue('name')) != null) {
            $this->errorMessages = 'Le nom d\'article est deja utilisé.';
            return false;
        }
        return true;
    }

    private function insertToDatabase()
    {
        $name = $this->form->getValue('name');
        $price = $this->form->getValue('price');
        $description = $this->form->getValue('description');
        (new ItemBroker())->insert($name, $price, $description);
        $this->success = true;
    }

    public function hasSucceeded()
    {
        return $this->success;
    }


}