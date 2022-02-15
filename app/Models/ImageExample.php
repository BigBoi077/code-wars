<?php namespace Models;

class ImageExample
{
    public $exercise_id;
    public $path;
    public $name_hash;
    public $file_extension;

    public function __construct($exercise_id, $path, $name_hash, $file_extension)
    {
        $this->exercise_id = $exercise_id;
        $this->path = $path;
        $this->name_hash = $name_hash;
        $this->file_extension = $file_extension;
    }
}
