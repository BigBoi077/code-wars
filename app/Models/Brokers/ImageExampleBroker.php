<?php namespace Models\Brokers;

use Models\ImageExample;

class ImageExampleBroker extends Broker
{

    public function getAllById($exerciseId): array
    {
        $sql = "SELECT *
                FROM codewars.imageexamples as ie
                WHERE ie.exercise_id = ?";
        $result = $this->select($sql, [$exerciseId]);
        return $result;
    }

    public function insert(ImageExample $imageExample)
    {
        $sql = "INSERT INTO codewars.imageexamples (exercise_id, path, name_hash, file_extension) VALUES (?, ?, ?, ?)";
        $this->query($sql, [
            $imageExample->exercise_id,
            $imageExample->path,
            $imageExample->name_hash,
            $imageExample->file_extension
        ]);
    }

    public function delete($id)
    {
        $sql = "delete from codewars.imageexamples i where i.image_example_id = ?";
        $this->query($sql, [$id]);
    }

    public function deleteAllOf($exerciseId)
    {
        $examples = $this->getAllById($exerciseId);
        foreach ($examples as $example) {
            $this->delete($example->image_example_id);
        }
    }
}
