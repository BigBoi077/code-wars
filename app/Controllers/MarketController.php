<?php


namespace Controllers;


use Models\Brokers\StudentBroker;
use Models\Services\ItemService;
use Models\Services\StudentItemService;
use Models\Services\StudentService;
use Models\Transaction;
use Zephyrus\Application\Flash;

class MarketController extends Controller
{
	public function initializeRoutes()
	{
		$this->get('/market', 'market');

        $this->get('/market/buy/{id}', 'buy');
	}

	public function market() {
	    $student = null;
        $studentItems = null;
	    if (!$this->isUserTeacher()) {
            $student = StudentService::get($this->getUser()['da']);
            $studentItems = StudentItemService::getAllByDa($student->da);
        }
		return $this->render('market', [
			'items' => ItemService::getAll(),
            'student' => $student,
            'studentItems' => $studentItems
		]);
	}

    public function buy($id)
    {
        $transaction = new Transaction($id, $this->getUser()['da']);
        if (!$transaction->hasSucceeded()) {
            Flash::error($transaction->getErrorMessages());
        } else {
            Flash::success('Achat effectué avec succès.');
        }
        return $this->redirect('/market');
    }


}