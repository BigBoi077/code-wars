<?php namespace Models\Services;

use Models\Brokers\ImageExampleBroker;
use Models\ImageExample;
use Zephyrus\Application\Form;
use Zephyrus\Security\Cryptography;

class ImageExampleService
{
    private const MAX_IMAGE_FILE_SIZE = 20971520;
    private const TARGET_UPLOAD_DIR = "/assets/examples";

    private $succes = false;
    private Form $form;
    private $errorMessages;
    private $images;

    public static function getAllById($exerciseId)
    {
        return (new ImageExampleBroker())->getAllById($exerciseId);
    }

    public static function create(Form $form, $exerciseId): ImageExampleService
    {
        $instance = new self();
        $instance->form = $form;

        if ($instance->areFieldsValid()) {
            $instance->uploadFiles($exerciseId);
        }
        return $instance;
    }

    public static function update($id, Form $form): ImageExampleService
    {
        $instance = new self();
        $instance->form = $form;
        if ($instance->areFieldsValid()) {
            $instance->updateToDatabase($id);
        }
        return $instance;
    }

    public static function delete($exerciseId)
    {
    }

    public function getErrorMessages()
    {
        return $this->errorMessages;
    }

    public function hasSucceeded(): bool
    {
        return $this->succes;
    }

    private function areFieldsValid(): bool
    {
        if (!$this->applyRules()) {
            return false;
        }
        return true;
    }

    private function applyRules(): bool
    {
        $images = $this->form->field('imageExamples')->getValue();

        $names = $images['name'];
        $types = $images['type'];
        $tmp_names = $images['tmp_name'];
        $errors = $images['error'];
        $sizes = $images['size'];

        if (!$this->validateName($names) || !$this->validateType($types)
            || !$this->validatTmpNames($tmp_names) || !$this->validateError($errors)
            || !$this->validateSize($sizes)) {
            $this->errorMessages = $this->form->getErrorMessages();
            return false;
        }

        $this->succes = true;
        return true;
    }

    private function insertToDatabase(ImageExample $imageExample)
    {
        (new ImageExampleBroker())->insert($imageExample);
    }

    private function updateToDatabase($id)
    {
        // TODO : update tser
    }

    private function uploadFiles($exerciseId)
    {
        $images = $this->form->field('imageExamples')->getValue();
        $names = $images['name'];
        $tmp_names = $images['tmp_name'];
        $fileTypes = $images['type'];
        $targetDir = getcwd() . self::TARGET_UPLOAD_DIR;

        for ($i = 0; $i < count($tmp_names); $i++) {
            $salt = Cryptography::randomString(16);
            $hashedFileName = Cryptography::hash($names[$i] . $salt . $tmp_names[$i]);
            $fileExtension = explode("/", $fileTypes[$i])[1];
            move_uploaded_file($tmp_names[$i], "$targetDir/$hashedFileName.$fileExtension");

            $imageExample = new ImageExample($exerciseId, self::TARGET_UPLOAD_DIR, $hashedFileName, $fileExtension);
            self::insertToDatabase($imageExample);
        }
    }

    private function validateName($names): bool
    {
        foreach ($names as $name) {
            if ($name == "" || empty($name)) {
                return false;
            }
        }
        return true;
    }

    private function validateType($types): bool
    {
        foreach ($types as $type) {
            if (!in_array($type, ['image/gif', 'image/jpeg', 'image/png', 'image/webp'])) {
                return false;
            }
        }
        return true;
    }

    private function validatTmpNames($tmp_names): bool
    {
        foreach ($tmp_names as $tmp_name) {
            if (!file_exists($tmp_name)) {
                return false;
            }
        }
        return true;
    }

    private function validateError($errors): bool
    {
        foreach ($errors as $error) {
            if ($error == 1) {
                return false;
            }
        }
        return true;
    }

    private function validateSize($sizes): bool
    {
        foreach ($sizes as $size) {
            if ($size > self::MAX_IMAGE_FILE_SIZE) {
                return false;
            }
        }
        return true;
    }
}
