<?php namespace Models\Services;

use Models\Brokers\ItemBroker;
use Models\Brokers\StudentItemBroker;
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
        if ($instance->applyRules()) {
            $instance->insertToDatabase();
        }
        return $instance;
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

    public static function delete($id)
    {
        (new StudentItemBroker())->deleteWithItemId($id);
        (new ItemBroker())->delete($id);
    }

    public static function deleteAllStudentItem($da)
    {
        (new StudentItemBroker())->deleteAllStudentItem($da);
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
        $this->form->validate('name', Rule::notEmpty('Le nom est requis.'));
        $this->form->validate('price', Rule::notEmpty('Le prix est requis.'));
        $this->form->validateWhenFieldHasNoError('price', Rule::integer('Le prix doit être un nombre.'));
        $this->form->validate('description', Rule::notEmpty('La description est requise.'));
        if (!$this->form->verify()) {
            $this->errorMessages = $this->form->getErrorMessages();
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

    private function updateToDatabase($id)
    {
        $name = $this->form->getValue('name');
        $price = $this->form->getValue('price');
        $description = $this->form->getValue('description');
        (new ItemBroker())->update($id, $name, $price, $description);
        $this->success = true;
    }
}
