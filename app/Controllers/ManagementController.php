<?php namespace Controllers;

use Models\Brokers\TeamBroker;
use Models\Brokers\ExerciseBroker;
use Models\Brokers\TipBroker;
use Models\Brokers\WeekBroker;
use Models\Services\ExerciseService;
use Models\Services\ItemService;
use Models\Services\StudentService;
use Zephyrus\Application\Flash;
use Zephyrus\Network\Response;

class ManagementController extends Controller
{
    public function before(): ?Response
    {
        if (!$this->isUserTeacher()) {
            return $this->redirect("/");
        }
        return parent::before();
    }

    public function initializeRoutes()
	{
	    $this->get('/management', 'management');

		$this->get('/management/students', 'listStudents');
        $this->get('/management/students/create', 'createStudent');
        $this->get('/management/students/{da}/edit', 'editStudent');
        $this->get('/management/students/{da}/delete', 'deleteStudent');
        $this->post('/management/students/store', 'storeStudent');
        $this->post('/management/students/{da}/update', 'updateStudent');

        $this->get('/management/exercises', 'listExercises');
        $this->get('/management/exercises/create', 'createExercise');
        $this->get('/management/exercises/{id}/edit', 'editExercise');
        $this->get('/management/exercises/{id}/delete', 'deleteExercise');
        $this->post('/management/exercises/store', 'storeExercise');
        $this->post('/management/exercises/{id}/update', 'updateExercise');

        $this->get('/management/items', 'listItems');
        $this->get('/management/items/create', 'createItem');
        $this->get('/management/items/{id}/edit', 'editItem');
        $this->get('/management/items/{id}/delete', 'deleteItem');
        $this->post('/management/items/store', 'storeItem');
        $this->post('/management/items/{id}/update', 'updateItem');

	}

	public function management(): Response
    {
        return $this->render('management/base');
    }

	public function listStudents(): Response
	{
		return $this->render('management/students/temp_student_listing', [
            'students' => StudentService::getAll(),
        ]);
	}

    public function createStudent()
    {
        return $this->render('management/students/temp_student_form', [
            'title' => 'Créer un étudiant',
            'action' => '/management/students/store',
            'student' => null,
            'teams' => (new TeamBroker())->getAll(),
        ]);
    }

    public function editStudent($da)
    {
        if (!StudentService::exists($da)) {
            Flash::error('L\'étudiant n\'existe pas');
            return $this->redirect('/management/students');
        }
        $student = StudentService::get($da);
        return $this->render('management/students/temp_student_form', [
            'title' => 'Modification de ' . $student->firstname . ' ' . $student->lastname,
            'action' => '/management/students/' . $student->da . '/update',
            'student' => $student,
            'teams' => (new TeamBroker())->getAll(),
        ]);
    }

    public function deleteStudent($da)
    {
        if (StudentService::exists($da)) {
            if (StudentService::hasItem($da)) {
                ItemService::deleteAllStudentItem($da);
            }
            StudentService::delete($da);
            Flash::success('Étudiant supprimé avec succès.');
        } else {
            Flash::error('Une erreur est survenue.');
        }
        return $this->redirect('/management/students');
    }

    public function storeStudent()
    {
        $student = StudentService::create($this->buildForm());
        if ($student->hasSucceeded()) {
            Flash::success('Étudiant créé avec succès.');
            return $this->redirect('/management/students');
        }
        Flash::error($student->getErrorMessages());
        return $this->redirect('/management/students/create');
    }

    public function updateStudent($da)
    {
        if (StudentService::exists($da)) {
            $student = StudentService::update($da, $this->buildForm());
            if ($student->hasSucceeded()) {
                Flash::success('Étudiant edité avec succèss.');
                return $this->redirect('/management/students');
            }
            Flash::error($student->getErrorMessages());
        }
        Flash::error('Une erreur est survenue.');
        return $this->redirect('/management/students/' . $da . '/edit');
    }

    public function listExercises(): Response
    {
        return $this->render('management/exercises/temp_exercise_listing', [
            'exercises' => (new ExerciseBroker())->getAll(),
            'student' => null
        ]);
    }

    public function createExercise()
    {
        return $this->render('management/exercises/temp_exercise_form', [
            'title' => 'Créer un exercise',
            'action' => '/management/exercises/store',
            'exercise' => null,
            'weeks' => ((new WeekBroker())->getAll())
        ]);
    }

    public function editExercise($id)
    {
        return $this->render('management/exercises/temp_exercise_form', [
            'title' => 'Créer un exercise',
            'action' => '/management/exercises/' . $id . '/update',
            'exercise' => (new ExerciseBroker())->findByID($id),
            'weeks' => (new WeekBroker())->getAll()
        ]);
    }

    public function updateExercise($id)
    {
        $exercise = ExerciseService::update($id, $this->buildForm());
        if ($exercise->hasSucceeded()) {
            Flash::success('Exercicse mis à jour avec succès.');
            return $this->redirect('/management/exercises');
        }
        Flash::error($exercise->getErrorMessages());
        return $this->redirect('/management/exercises/' . $id . '/update');

    }

    public function detailExercise($id){

        $exerciseBroker = new ExerciseBroker();
        $tipBroker = new TipBroker();
        $weekBroker = new WeekBroker();

        $exercise = $exerciseBroker->findByID($id);
        $week = $weekBroker->findByID($id);
        $tip = $tipBroker->findByID($id);


        if(is_null($exercise)){
            return $this->redirect("/management/exercises/");
        }
        return $this->render("management/exercises/temp_exercise_detail",
        [
            'exercise' => $exercise,
            'tip' => $tip,
            'week' => $week
        ]);

    }

    public function storeExercise()
    {
        $exercise = ExerciseService::create($this->buildForm());
        if ($exercise->hasSucceeded()) {
            Flash::success('Exercicse créé avec succès.');
            return $this->redirect('/management/exercises');
        }
        Flash::error($exercise->getErrorMessages());
        return $this->redirect('/management/exercises/create');
    }

    public function deleteExercise($id)
    {
        if (ExerciseService::exists($id)) {
            ExerciseService::delete($id);
            Flash::success('ExerciseService supprimé avec succès.');
        } else {
            Flash::error('Une erreur est survenue.');
        }
        return $this->redirect('/management/exercises');
    }

    public function listItems()
    {
        return $this->render('management/items/temp_item_listing', [
            'items' => ItemService::getAll()
        ]);
    }

    public function createItem()
    {
        return $this->render('management/items/temp_item_form', [
            'title' => 'Créer un article',
            'action' => '/management/items/store',
            'item' => null,
        ]);
    }

    public function editItem($id)
    {
        if (!ItemService::exists($id)) {
            Flash::error('L\'item n\'existe pas');
            return $this->redirect('/management/items');
        }
        $item = ItemService::get($id);
        return $this->render('management/items/temp_item_form', [
            'title' => 'Éditer ' . $item->name,
            'action' => '/management/items/' . $item->id . '/update',
            'item' => $item,
        ]);
    }

    public function deleteItem($id)
    {
        if (ItemService::exists($id)) {
            ItemService::delete($id);
            Flash::success('Article supprimé avec succès.');
        } else {
            Flash::error('Une erreur est survenue.');
        }
        return $this->redirect('/management/items');
    }

    public function storeItem()
    {
        $item = ItemService::create($this->buildForm());
        if ($item->hasSucceeded()) {
            Flash::success('Article créé avec succès.');
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
                Flash::success('Article edité avec succèss.');
                return $this->redirect('/management/items');
            }
            Flash::error($item->getErrorMessages());
        }
        Flash::error('Une erreur est survenue.');
        return $this->redirect('/management/items/' . $id . '/edit');
    }

}