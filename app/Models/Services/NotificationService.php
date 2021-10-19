<?php namespace Models\Services;

use Models\Brokers\NotificationBroker;

class NotificationService
{
    public static function newCorrectionAvailable($student)
    {
        (new NotificationBroker())->sendNotificationToTeachers("Un élève a remis un exercice. Remis par : " . $student->firstname, "Nouvelle correction");
    }

    public static function studentBoughtItem($student, $item)
    {
        (new NotificationBroker())->sendNotificationToTeachers("Un élève a acheté | " . $item->name . " | Acheté par : " . $student->firstname, "Nouvel achat");
    }

    public static function exerciseCorrected($userId)
    {
        (new NotificationBroker())->sendNotificationToSpecificStudent($userId, "Un de vos exercice vient d'être corrigé", "Exercice corrige!");
    }

    public static function newExerciseAvailable($exerciseName)
    {
        (new NotificationBroker())->sendNotificationToStudents("Une nouvelle mission est disponible : " . $exerciseName,"Nouvelle mission disponible");
    }

    public static function newCommentOnCorrection($userId)
    {
        (new NotificationBroker())->sendNotificationToSpecificStudent($userId, "Un commentaire à été déposé sur une de vos remise(s)", "nouveau commentaire");
    }
}