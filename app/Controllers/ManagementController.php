<?php


namespace Controllers;


use Models\Brokers\ExerciseBroker;
use Models\Brokers\StudentBroker;
use Models\Brokers\TeamBroker;
use Models\Entities\Exercise;
use Models\Entities\Student;
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
        $this->get('/management/exercises/{id}/delete', 'deleteExercise');
        $this->post('/management/exercises/store', 'storeExercise');
        $this->post('/management/exercises/{da}/update', 'updateExercise');
	}

	public function listStudents(): Response
	{
		return $this->render('management/students/temp_student_listing', [
            'students' => (new StudentBroker())->getAll()
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
        $student = (new StudentBroker())->findByDa($da);
        return $this->render('management/students/temp_student_form', [
            'title' => 'Éditer ' . $student->firstname . ' ' . $student->lastname,
            'action' => '/management/students/' . $student->da . '/update',
            'student' => $student,
            'teams' => (new TeamBroker())->getAll(),
        ]);
    }

    public function deleteStudent($da)
    {
        if (Student::exists($da)) {
            Student::delete($da);
            Flash::success('Étudiant supprimé avec succès.');
        } else {
            Flash::error('Une erreur est survenue.');
        }
        return $this->redirect('/management/students');
    }

    public function storeStudent()
    {
        $student = Student::create($this->buildForm());
        if ($student->hasSucceeded()) {
            Flash::success('Étudiant créé avec succès.');
            return $this->redirect('/management/students');
        }
        Flash::error($student->getErrorMessages());
        return $this->redirect('/management/students/create');
    }

    public function updateStudent($da)
    {
        if (Student::exists($da)) {
            $student = Student::update($da, $this->buildForm());
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
            'exercises' => (new ExerciseBroker())->getAll()
        ]);
    }

    public function createExercise()
    {
        return $this->render('management/exercises/temp_exercise_form', [
            'title' => 'Créer un exercise',
            'action' => '/management/exercises/store',
            'exercise' => null,
        ]);
    }

    public function editExercise()
    {
        return $this->html('edit exercise');
    }

    public function storeExercise()
    {
        $exercise = Exercise::create($this->buildForm());
        if ($exercise->hasSucceeded()) {
            Flash::success('Exercicse créé avec succès.');
            return $this->redirect('/management/exercises');
        }
        Flash::error($exercise->getErrorMessages());
        return $this->redirect('/management/exercises/create');
    }

    public function deleteExercise($id)
    {
        if (Exercise::exists($id)) {
            Exercise::delete($id);
            Flash::success('Exercise supprimé avec succès.');
        } else {
            Flash::error('Une erreur est survenue.');
        }
        return $this->redirect('/management/exercises');
    }

}