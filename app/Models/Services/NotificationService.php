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
        (new NotificationBroker())->sendNotificationToTeachers("Un élève a acheté | " . $item->name . " | Acheté par : " . $student->firstname . " " . $student->lastname, "Nouvel achat");
    }

    public static function exerciseCorrected($userId, $cash, $points)
    {
        (new NotificationBroker())->sendNotificationToSpecificStudent($userId, "Un de vos exercices vient d'être corrigé. Vous avez reçu " . number_format($cash, 0, '.', ' ') . "$ et " . number_format($points, 0, '.', ' ') . " pts.", "Exercice corrige!");
    }

    public static function newExerciseAvailable($exerciseName, $cash, $points, $id)
    {
        (new NotificationBroker())->sendNotificationToStudents("Une nouvelle mission est disponible : " . $exerciseName . ". Vous recevrez " . number_format($cash, 0, '.', ' ') . "$ et " . number_format($points, 0, '.', ' ') . " pts en la complétant.","Nouvelle mission disponible");
    }

    public static function newBalance($userId, $add, $newBalance)
    {
        if ($add > 0) {
            $add = "+" . number_format($add, 0, '.', ' ');
        }
        (new NotificationBroker())->sendNotificationToSpecificStudent($userId, "Votre balance à été mise à jour. " . $add . "$. Nouvelle balance : " . $newBalance . "$", "Nouvelle balance");
    }

    public static function newPoints($userId, $add, $newAmount) {
        if ($add > 0) {
            $add = "+" . number_format($add, 0, '.', ' ');
        }
        (new NotificationBroker())->sendNotificationToSpecificStudent($userId, "Vos points ont été mise à jour. " . $add . " Points. Nouvelle balance : " . $newAmount . " Points", "Nouvelle balance de points");
    }

    public static function incorrectSolution($userId, $exerciseName)
    {
        (new NotificationBroker())->sendNotificationToSpecificStudent($userId, "<p>Votre solution pour " . $exerciseName . " ne convient pas. Consulter les <a href='/profile#exerciseSection'>commentaires</a> pour vous orienter</p>", "Solution incorrect");
    }

    public static function newCommentOnCorrection($userId)
    {
        (new NotificationBroker())->sendNotificationToSpecificStudent($userId, "Un commentaire a été déposé sur une de vos remise(s)", "Nouveau commentaire");
    }
}
