<?php


namespace Controllers;


use Models\Brokers\ExerciseBroker;
use Models\Brokers\StudentBroker;
use Models\Brokers\TipBroker;
use Models\Services\StudentService;
use Models\Services\TipService;
use Zephyrus\Application\Flash;
use Zephyrus\Network\Response;

class TipsManageController extends TeacherController
{

    public function initializeRoutes()
    {
        $this->get('/management/exercises/{id}/tips', 'exercisesTips');
        $this->get("/management/exercises/{id}/tips/create", 'createTip');
        $this->get("/management/exercises/{exerciseId}/tips/{tipId}/edit", 'editTip');

        $this->post("/management/exercises/{exerciseId}/tips/store", 'storeTip');
        $this->post("/management/exercises/{exerciseId}/tips/{id}/update", 'updateTip');
        $this->get("/management/exercises/{exerciseId}/tips/{id}/delete", 'deleteTip');
    }

    public function exercisesTips($exerciseId)
    {
        return $this->render("/management/exercises/tips_list", [
            'exercise' => (new ExerciseBroker())->findByID($exerciseId),
            'tips' => (new TipBroker())->GetAllById($exerciseId)
        ]);
    }

    public function createTip($exerciseId)
    {
        return $this->render("/management/exercises/tips_form", [
            'title' => "Ajouter un indice",
            'action' => "/management/exercises/" . $exerciseId . "/tips/store",
            'tip' => null
        ]);
    }

    public function storeTip($exerciseId)
    {
        $tip = TipService::create($exerciseId, $this->buildForm());
        if ($tip->hasSucceeded()) {
            Flash::success('Indice ajouté avec succès!');
            return $this->redirect("/management/exercises/" . $exerciseId . "/tips");
        }
        Flash::error($tip->getErrorMessages());

        return $this->redirect("/management/exercises/" . $exerciseId . "/tips");
    }

    public function editTip($exerciseId, $tipId)
    {
        return $this->render("/management/exercises/tips_form", [
            'title' => "Modifier l'indice",
            'action' => "/management/exercises/" . $exerciseId . "/tips/" . $tipId ."/update",
            'tip' => (new TipBroker())->GetById($tipId)
        ]);
    }

    public function updateTip($exerciseId, $tipId)
    {
        if (TipService::exists($tipId)) {
            $tip = TipService::update($tipId, $this->buildForm());
            if ($tip->hasSucceeded()) {
                Flash::success('Indice modifié avec succès!');
                return $this->redirect("/management/exercises/" . $exerciseId . "/tips");
            }
            Flash::error($tip->getErrorMessages());
        }
        Flash::error('Une erreur est survenue.');
        return $this->redirect("/management/exercises/" . $exerciseId . "/tips");
    }

    public function deleteTip($exerciseId, $tipId)
    {
        if (TipService::exists($tipId)) {
            TipService::delete($tipId);
            Flash::success('Indice supprimé avec succès!');
        } else {
            Flash::error('Une erreur est survenue.');
        }
        return $this->redirect("/management/exercises/" . $exerciseId . "/tips");
    }
}