<?php namespace Controllers;

use Models\Brokers\WeekBroker;
use Zephyrus\Application\Flash;
use Zephyrus\Application\Rule;
use Zephyrus\Network\Response;

class WeekManageController extends TeacherController
{
    public function initializeRoutes()
    {
        $this->get('/management/weeks', "weeksListing");
        $this->get('/management/weeks/{id}/activate', 'activateWeek');
        $this->get('/management/weeks/create', 'createWeek');
        $this->get('/management/weeks/{id}/delete', 'deleteWeek');

        $this->post('/management/weeks/store', 'storeWeek');

        $this->overrideWeek();
    }

    public function weeksListing(): Response
    {
        return $this->render('management/exercises/week_listing', [
            'weeks' => (new WeekBroker())->getAll(),
            'student' => null
        ]);
    }

    public function activateWeek($id)
    {
        (new WeekBroker())->activate($id);
        Flash::success("La visibilité a été changé avec succès!");
        return $this->redirect('/management/weeks');
    }

    public function deleteWeek($id)
    {
        if ((new WeekBroker())->delete($id)) {
            Flash::success("Semaine supprimée avec succès!");
        } else {
            Flash::error("Cette semaine ne peut pas être supprimée, car des missions lui sont rattachées.");
        }
        return $this->redirect('/management/weeks');
    }

    public function createWeek()
    {
        return $this->render('management/exercises/week_add', [
            'title' => 'Créer une semaine',
            'action' => '/management/weeks/store'
        ]);
    }

    public function storeWeek()
    {
        $form = $this->buildForm();
        $form->validate("number", Rule::notEmpty("Le numéro est requis."));
        $form->validateWhenFieldHasNoError("number", Rule::integer("Le numéro doit être un chiffre."));
        $form->validate("startDate", Rule::date("La date doit être valide."));
        if (!$form->verify()) {
            Flash::error($form->getErrorMessages());
            return $this->redirect('/management/weeks/create');
        }
        if ((new WeekBroker())->findByNumber($form->getValue("number"))) {
            Flash::error("Le numéro de la semaine est déjà utilisé.");
            return $this->redirect('/management/weeks/create');
        }
        (new WeekBroker())->insert($form->getValue("startDate"), $form->getValue("number"));
        Flash::success("La semaine a été ajoutée avec succès!");
        return $this->redirect('/management/weeks');
    }

    private function overrideWeek()
    {
        $this->overrideArgument('id', function ($value) {
            if (is_numeric($value)) {
                $week = (new WeekBroker())->findByID($value);
                if (is_null($week)) {
                    return $this->redirect('/management/weeks');
                }
                return $week->id;
            } else {
                return $this->redirect('/management/weeks');
            }
        });
    }
}
