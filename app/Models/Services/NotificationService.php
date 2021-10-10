<?php namespace Models\Services;

use Models\Brokers\NotificationBroker;

class NotificationService
{
    public static function newCorrectionAvailable($student)
    {
        (new NotificationBroker())->sendNotificationToTeachers("Un élève a remis un exercise. Remis par : " . $student->firstname, "Nouvelle correction");
    }

    public static function studentBoughtItem($student, $item)
    {
        (new NotificationBroker())->sendNotificationToTeachers("Un élève a acheté | " . $item->name . " | Acheté par : " . $student->firstname, "Nouvel achat");
    }

    public static function exerciseCorrected($userId)
    {
        (new NotificationBroker())->sendNotificationToSpecificStudent($userId, "Un de vos exercise vient d'être corrigé", "Exercise corrigé!");
    }

    public static function newExerciseAvailable($exerciseName)
    {
        (new NotificationBroker())->sendNotificationToStudents("Une nouvelle mission est disponible : " . $exerciseName,"Nouvelle mission disponible");
    }
}