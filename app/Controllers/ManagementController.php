<?php


namespace Controllers;


use Models\Brokers\StudentBroker;
use Models\Brokers\TeamBroker;
use Models\Entities\Student;
use Zephyrus\Application\Flash;
use Zephyrus\Network\Response;

class ManagementController extends Controller
{
	public function initializeRoutes()
	{
		$this->get('/management/students', 'listStudents');
        $this->get('/management/students/create', 'createStudent');
        $this->get('/management/students/{id}/edit', 'editStudent');
        $this->get('/management/students/{id}/delete', 'deleteStudent');
        $this->post('/management/students/store', 'storeStudent');
        $this->post('/management/students/{id}/update', 'updateStudent');

        $this->get('/management/exercises', 'listExercises');
        $this->get('/management/exercises/create', 'createExercise');
        $this->get('/management/exercises/{id}/edit', 'editExercise');
        $this->get('/management/exercises/{id}/delete', 'deleteExercise');
        $this->post('/management/exercises/store', 'storeExercise');
        $this->post('/management/exercises/{id}/update', 'updateExercise');
	}

	public function listStudents(): Response
	{
		return $this->render('management/students/temp_student_listing', [
            'students' => (new StudentBroker())->getAll()
        ]);
	}

    public function createStudent()
    {
        return $this->render('management/students/temp_student_create', [
            'teams' => (new TeamBroker())->getAll(),
        ]);
    }

    public function editStudent()
    {
        return $this->html('edit student');
    }

    public function storeStudent()
    {
        $student = new Student($this->buildForm());
        if ($student->areFieldsValid()) {
            $student->insert();
            return $this->redirect('/management/students');
        }
        Flash::error($student->getErrorMessages());
        return $this->redirect('/management/students/create');
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