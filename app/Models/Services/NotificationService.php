<?php namespace Models\Services;

use Models\Brokers\NotificationBroker;

class NotificationService
{
    public static function newCorrectionAvailable($student, $exerciseName)
    {
        (new NotificationBroker())->sendNotificationToTeachers("<p>" . $student->firstname . " " . $student->lastname . " a remis : <a href='/management/correction'>" . $exerciseName . "</a></p>", "Nouvelle correction");
    }

    public static function studentBoughtItem($student, $item)
    {
        (new NotificationBroker())->sendNotificationToTeachers("Un élève a acheté | " . $item->name . " | Acheté par : " . $student->firstname . " " . $student->lastname, "Nouvel achat");
    }

    public static function exerciseCorrected($userId, $cash, $points)
    {
        (new NotificationBroker())->sendNotificationToSpecificStudent($userId, "Un de vos exercices vient d'être corrigé. Vous avez reçu " . number_format($cash, 0, '.', ' ') . "$ et " . number_format($points, 0, '.', ' ') . " pts.", "Mission complétée");
    }

    public static function newExerciseAvailable($exerciseName, $cash, $points, $id)
    {
        (new NotificationBroker())->sendNotificationToStudents("<p>Une nouvelle mission est disponible : <a href='/exercises/" . $id . "'>" . $exerciseName . "</a> . Vous recevrez " . number_format($cash, 0, '.', ' ') . "$ et " . number_format($points, 0, '.', ' ') . " pts en la complétant.</p>","Nouvelle mission disponible");
    }

    public static function newBalance($userId, $add, $newBalance)
    {
        if ($add > 0) {
            $add = "+" . number_format($add, 0, '.', ' ');
        }
        (new NotificationBroker())->sendNotificationToSpecificStudent($userId, "Votre balance a été mise à jour. " . $add . "$. Nouvelle balance : " . $newBalance . "$", "Nouvelle balance");
    }

    public static function newPoints($userId, $add, $newAmount)
    {
        if ($add > 0) {
            $add = "+" . number_format($add, 0, '.', ' ');
        }
        (new NotificationBroker())->sendNotificationToSpecificStudent($userId, "Vos points ont été mise à jour. " . $add . " Points. Nouvelle balance : " . $newAmount . " Points", "Nouvelle balance de points");
    }

    public static function incorrectSolution($userId, $exerciseName, $id)
    {
        (new NotificationBroker())->sendNotificationToSpecificStudent($userId, "<p>Votre solution pour " . $exerciseName . " ne convient pas. Consulter le <a href='/profile#exerciseSection'>commentaire</a> de l'enseignant pour vous orienter. Cliquer <a href='/exercise/' " . $id . ">ici</a> pour annuler votre remise.</p>", "Solution incorrect");
    }

    public static function newCommentOnCorrection($userId, $name)
    {
        (new NotificationBroker())->sendNotificationToSpecificStudent($userId, "<p>Un commentaire a été déposé sur la mission : <a href='/profile#exerciseSection'>" . $name . "</a>.</p>", "Nouveau commentaire");
    }
}
