<?php namespace Controllers;

use Models\Services\ItemService;
use Zephyrus\Application\Flash;

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

        $this->overrideItem();
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

    private function overrideItem()
    {
        $this->overrideArgument('id', function ($value) {
            if (is_numeric($value)) {
                $item = ItemService::get($value);
                if (is_null($item)) {
                    return $this->redirect('/management/items');
                }
                return $item;
            } else {
                return $this->redirect('/management/items');
            }
        });
    }
}