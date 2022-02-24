<?php namespace Models\Services;

use Models\Brokers\TipBroker;
use Zephyrus\Application\Form;
use Zephyrus\Application\Rule;

class TipService
{
    private $success = false;
    private Form $form;
    private $errorMessages;

    public static function create($exerciseId, Form $form)
    {
        $instance = new self();
        $instance->form = $form;
        if ($instance->applyRules()) {
            $instance->insertToDatabase($exerciseId);
        }
        return $instance;
    }

    public static function get($id)
    {
        return (new TipBroker())->GetById($id);
    }

    public static function update($id, Form $form)
    {
        $instance = new self();
        $instance->form = $form;
        if ($instance->applyRules()) {
            $instance->updateToDatabase($id);
        }
        return $instance;
    }

    public static function delete($id)
    {
        (new TipBroker())->delete($id);
    }

    public static function exists($id)
    {
        return (new TipBroker())->GetById($id) != null;
    }

    public function hasSucceeded()
    {
        return $this->success;
    }

    public function getErrorMessages()
    {
        return $this->errorMessages;
    }

    private function applyRules(): bool
    {
        $this->form->validate('tip', Rule::notEmpty("L'indice est requis."));
        $this->form->validate('price', Rule::integer('Le prix est requis.'));
        if (!$this->form->verify()) {
            $this->errorMessages = $this->form->getErrorMessages();
            return false;
        }
        return true;
    }

    private function insertToDatabase($exerciseId)
    {
        $tip = $this->form->getValue('tip');
        $price = $this->form->getValue('price');
        (new TipBroker())->insert($exerciseId, $tip, $price);
        $this->success = true;
    }

    private function updateToDatabase($id)
    {
        $tip = $this->form->getValue('tip');
        $price = $this->form->getValue('price');
        (new TipBroker())->update($id, $tip, $price);
        $this->success = true;
    }
}
