<?php


namespace Controllers;


use Models\Brokers\StudentBroker;
use Models\Brokers\TeamBroker;
use Models\Entities\StudentService;
use Zephyrus\Application\Flash;
use Zephyrus\Network\Response;

class ManagementController extends Controller
{
	public function initializeRoutes()
	{
		$this->get('/management/students', 'listStudents');
        $this->get('/management/students/create', 'createStudent');
        $this->get('/management/students/{da}/edit', 'editStudent');
        $this->get('/management/students/{da}/delete', 'deleteStudent');
        $this->post('/management/students/store', 'storeStudent');
        $this->post('/management/students/{da}/update', 'updateStudent');

        $this->get('/management/exercises', 'listExercises');
        $this->get('/management/exercises/create', 'createExercise');
        $this->get('/management/exercises/{da}/edit', 'editExercise');
        $this->get('/management/exercises/{da}/delete', 'deleteExercise');
        $this->post('/management/exercises/store', 'storeExercise');
        $this->post('/management/exercises/{da}/update', 'updateExercise');
	}

	public function listStudents(): Response
	{
		return $this->render('management/students/temp_student_listing', [
            'students' => StudentService::getAll()
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
            'title' => 'Éditer ' . $student->firstname . ' ' . $student->lastname,
            'action' => '/management/students/' . $student->da . '/update',
            'student' => $student,
            'teams' => (new TeamBroker())->getAll(),
        ]);
    }

    public function deleteStudent($da)
    {
        if (StudentService::exists($da)) {
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

    public function listExercises()
    {
        return $this->html('exercises listing');
    }

    public function createExercise()
    {
        return $this->html('create exercise');
    }

    public function editExercise()
    {
        return $this->html('edit exercise');
    }

    public function storeExercise()
    {
        return $this->html('store exercise');
    }

}