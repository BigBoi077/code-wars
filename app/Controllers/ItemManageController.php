<?php namespace Controllers;

use Models\Brokers\NotificationBroker;
use Models\Brokers\StudentBroker;
use Models\Brokers\StudentExerciseBroker;
use Models\Brokers\StudentItemBroker;
use Models\Brokers\TeamBroker;
use Models\Brokers\ExerciseBroker;
use Models\Brokers\TipBroker;
use Models\Brokers\WeekBroker;
use Models\Services\ExerciseService;
use Models\Services\ItemService;
use Models\Services\StudentService;
use phpDocumentor\Reflection\Types\False_;
use Zephyrus\Application\Flash;
use Zephyrus\Application\Rule;
use Zephyrus\Network\Response;
use Zephyrus\Utilities\Gravatar;

class ItemManageController extends TeacherController
{

    public function initializeRoutes()
	{
        $this->get('/management/items', 'listItems');
        $this->get('/management/items/create', 'createItem');
        $this->get('/management/items/{id}/edit', 'editItem');
        $this->get('/management/items/{id}/delete', 'deleteItem');
        $this->post('/management/items/store', 'storeItem');
        $this->post('/management/items/{id}/update', 'updateItem');
	}

    public function listItems()
    {
        return $this->render('management/items/items_listing', [
            'items' => ItemService::getAll()
        ]);
    }

    public function createItem()
    {
        return $this->render('management/items/items_form', [
            'title' => 'Créer un article',
            'action' => '/management/items/store',
            'item' => null,
        ]);
    }

    public function editItem($id)
    {
        if (!ItemService::exists($id)) {
            Flash::error('L\'article n\'existe pas.');
            return $this->redirect('/management/items');
        }
        $item = ItemService::get($id);
        return $this->render('management/items/items_form', [
            'title' => 'Modifier ' . $item->name,
            'action' => '/management/items/' . $item->id . '/update',
            'item' => $item,
        ]);
    }

    public function deleteItem($id)
    {
        if (ItemService::exists($id)) {
            ItemService::delete($id);
            Flash::success('Article supprimé avec succès!');
        } else {
            Flash::error('Une erreur est survenue.');
        }
        return $this->redirect('/management/items');
    }

    public function storeItem()
    {
        $item = ItemService::create($this->buildForm());
        if ($item->hasSucceeded()) {
            Flash::success('Article créé avec succès!');
            return $this->redirect('/management/items');
        }
        Flash::error($item->getErrorMessages());
        return $this->redirect('/management/items/create');
    }

    public function updateItem($id)
    {
        if (ItemService::exists($id)) {
            $item = ItemService::update($id, $this->buildForm());
            if ($item->hasSucceeded()) {
                Flash::success('Article modifié avec succèss!');
                return $this->redirect('/management/items');
            }
            Flash::error($item->getErrorMessages());
        }
        Flash::error('Une erreur est survenue.');
        return $this->redirect('/management/items/' . $id . '/edit');
    }

}