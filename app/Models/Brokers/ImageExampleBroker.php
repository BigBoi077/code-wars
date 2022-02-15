<?php namespace Models\Brokers;

use Models\ImageExample;

class ImageExampleBroker extends Broker
{

    public function getAllById($exerciseId): array
    {
        $sql = "SELECT *
                FROM codewars.imageExamples as ie
                WHERE ie.exercise_id = ?";
        $result = $this->select($sql, [$exerciseId]);
        return $result;
    }

    public function insert(ImageExample $imageExample)
    {
        $sql = "INSERT INTO codewars.imageExamples (exercise_id, path, name_hash, file_extension) VALUES (?, ?, ?, ?)";
        $this->query($sql, [
            $imageExample->exercise_id,
            $imageExample->path,
            $imageExample->name_hash,
            $imageExample->file_extension
        ]);
    }
}
