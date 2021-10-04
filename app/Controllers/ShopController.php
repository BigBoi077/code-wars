<?php


namespace Controllers;


use Models\Brokers\StudentBroker;
use Models\Services\ItemService;

class ShopController extends Controller
{
	public function initializeRoutes()
	{
		$this->get('/market', 'market');
	}

	public function market() {
	    $user = $this->getUser();
	    $student = (new StudentBroker())->findByDa($user['da']);
		return $this->render('temp_market', [
			'user' => $user,
			'items' => ItemService::getAll(),
            'student' => $student
		]);
	}
}