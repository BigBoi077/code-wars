<?php


namespace Controllers;


use Zephyrus\Network\Response;

class StudentPanelController extends Controller
{
	public function initializeRoutes()
	{
		$this->get('/student-panel', 'studentPanel');
	}

	public function studentPanel(): Response
	{
		if (!$this->isLogged()) {
			return $this->redirect('/login');
		}
		return $this->render('teacher_panels/temp_student_panel');
	}

}