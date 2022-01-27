<?php namespace Models\Services;

use Models\Brokers\NotificationBroker;

class NotificationService
{
    public static function newCorrectionAvailable($student, $exerciseName)
    {
        (new NotificationBroker())->sendNotificationToTeachers($student->firstname . " " . $student->lastname . " a remis " . $exerciseName, "Nouvelle correction");
    }

    public static function studentBoughtItem($student, $item)
    {
        (new NotificationBroker())->sendNotificationToTeachers("Un élève a acheté | " . $item->name . " | Acheté par : " . $student->firstname, "Nouvel achat");
    }

    public static function exerciseCorrected($userId, $cash, $points)
    {
        (new NotificationBroker())->sendNotificationToSpecificStudent($userId, "Un de vos exercices vient d'être corrigé. Vous avez reçu " . $cash . "$ et " . $points . " pts.", "Exercice corrige!");
    }

    public static function newExerciseAvailable($exerciseName, $cash, $points, $id)
    {
        (new NotificationBroker())->sendNotificationToStudents("Une nouvelle mission est disponible : " . $exerciseName . ". Vous recevrez " . $cash . "$ et " . $points . " pts en la complétant.", "Nouvelle mission disponible");
    }

    public static function newBalance($userId, $add, $newBalance)
    {
        (new NotificationBroker())->sendNotificationToSpecificStudent($userId, "Votre balance à été mise à jour. Ajout de " . $add . "$. Nouvelle balance : " . $newBalance . "$", "Nouvelle balance");
    }

    public static function newCommentOnCorrection($userId)
    {
        (new NotificationBroker())->sendNotificationToSpecificStudent($userId, "Un commentaire a été déposé sur une de vos remise(s)", "Nouveau commentaire");
    }
}
