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
use Zephyrus\Application\Flash;
use Zephyrus\Application\Rule;
use Zephyrus\Network\Response;
use Zephyrus\Utilities\Gravatar;

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
        $this->get('/management/students/{da}/profile', 'viewStudent');
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

        $this->get('/management/weeks', "weeksListing");
        $this->get('/management/weeks/{id}/activate', 'activateWeek');
        $this->get('/management/weeks/create', 'createWeek');
        $this->get('/management/weeks/{id}/delete', 'deleteWeek');
        $this->post('/management/weeks/store', 'storeWeek');
	}

	public function management(): Response
    {
        return $this->render('management/exercises');
    }

	public function listStudents(): Response
	{
		return $this->render('management/students/student_listing', [
            'students' => StudentService::getAll(),
        ]);
	}

    public function createStudent()
    {
        return $this->render('management/students/student_form', [
            'title' => 'Créer un étudiant',
            'action' => '/management/students/store',
            'editStudent' => null,
            'teams' => (new TeamBroker())->getAll(),
        ]);
    }

    public function viewStudent($da)
    {
        $student = StudentService::get($da);
        $imageUrl= "/assets/images/profil_pic_default.png";
        if ($student != null && ($student->email != '' || $student->email != null)) {
            $gravatar = new Gravatar($student->email);
            $imageUrl = $gravatar->getUrl();
        }
        $weeklyProgress = (new StudentBroker())->getProgressionByWeek($da);
        $indProgress = (new StudentBroker())->getProgression($da);
        $items = (new StudentItemBroker())->getAllWithDa($da);
        $studentExercises = (new StudentExerciseBroker())->getAllWithDa($student->da);
        return $this->render('profile/profile', [
            'isTeacher' => $this->isUserTeacher(),
            'studentProfile' => $student,
            'weeklyProgress' => $weeklyProgress,
            'individualProgress' => $indProgress,
            'items' => $items,
            'exercises' => $studentExercises,
            'gravatarUrl' => $imageUrl
        ]);
    }

    public function editStudent($da)
    {
        if (!StudentService::exists($da)) {
            Flash::error('L\'étudiant n\'existe pas.');
            return $this->redirect('/management/students');
        }
        $student = StudentService::get($da);
        return $this->render('management/students/student_form', [
            'title' => 'Modification de ' . $student->firstname . ' ' . $student->lastname,
            'action' => '/management/students/' . $student->da . '/update',
            'editStudent' => $student,
            'teams' => (new TeamBroker())->getAll()
        ]);
    }

    public function deleteStudent($da)
    {
        if (StudentService::exists($da)) {
            if (StudentService::hasItem($da)) {
                ItemService::deleteAllStudentItem($da);
            }
            StudentService::delete($da);
            Flash::success('Étudiant supprimé avec succès!');
        } else {
            Flash::error('Une erreur est survenue.');
        }
        return $this->redirect('/management/students');
    }

    public function storeStudent()
    {
        $student = StudentService::create($this->buildForm());
        if ($student->hasSucceeded()) {
            Flash::success('Étudiant créé avec succès!');
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
                Flash::success('Étudiant modifié avec succès!');
                return $this->redirect('/management/students');
            }
            Flash::error($student->getErrorMessages());
        }
        Flash::error('Une erreur est survenue.');
        return $this->redirect('/management/students/' . $da . '/edit');
    }

    public function listExercises(): Response
    {
        $exercises = (new ExerciseBroker())->getAll();
        return $this->render('management/exercises/exercises_listing', [
            'exercises' => $exercises,
            'student' => null
        ]);
    }

    public function createExercise()
    {
        return $this->render('management/exercises/exercises_form', [
            'title' => 'Créer un exercice',
            'action' => '/management/exercises/store',
            'exercise' => null,
            'weeks' => ((new WeekBroker())->getAll())
        ]);
    }

    public function editExercise($id)
    {
        return $this->render('management/exercises/exercises_form', [
            'title' => 'Modifier un exercice',
            'action' => '/management/exercises/' . $id . '/update',
            'exercise' => (new ExerciseBroker())->findByID($id),
            'weeks' => (new WeekBroker())->getAll()
        ]);
    }

    public function updateExercise($id)
    {
        $exercise = ExerciseService::update($id, $this->buildForm());
        if ($exercise->hasSucceeded()) {
            Flash::success('Exercice mis à jour avec succès!');
            return $this->redirect('/management/exercises');
        }
        Flash::error($exercise->getErrorMessages());
        return $this->redirect('/management/exercises/' . $id . '/update');

    }

    public function storeExercise()
    {
        $exercise = ExerciseService::create($this->buildForm());
        if ($exercise->hasSucceeded()) {
            Flash::success('Exercice créé avec succès!');
            return $this->redirect('/management/exercises');
        }
        Flash::error($exercise->getErrorMessages());
        return $this->redirect('/management/exercises/create');
    }

    public function deleteExercise($id)
    {
        if (ExerciseService::exists($id)) {
            ExerciseService::delete($id);
            Flash::success('Exercice supprimé avec succès!');
        } else {
            Flash::error('Une erreur est survenue.');
        }
        return $this->redirect('/management/exercises');
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
        return $this->redirect('/management/weeks');
    }

    public function deleteWeek($id)
    {
        if ((new WeekBroker())->delete($id)) {
            Flash::success("Semaine supprimée avec succès!");
        } else {
            Flash::error("Cette semaine ne peut pas être supprimée, car elle appartient à des exercises.");
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
        (new WeekBroker())->insert($form->getValue("startDate"), $form->getValue("number"));
        Flash::success("Semaine ajoutée avec succès!");
        return $this->redirect('/management/weeks');
    }

}