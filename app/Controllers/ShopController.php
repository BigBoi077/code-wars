<?php


namespace Controllers;


use Models\Services\ItemService;

class ShopController extends Controller
{
	public function initializeRoutes()
	{
		$this->get('/market', 'market');
	}

	public function market() {
		return $this->render('temp_market', [
			'user' => $this->getUser(),
			'items' => ItemService::getAll()
		]);
	}
}