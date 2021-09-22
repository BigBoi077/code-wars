<?php


namespace Controllers;


class StudentPanelController extends Controller
{
	public function initializeRoutes()
	{
		$this->get('/student-panel', 'studentPanel');
	}

	public function studentPanel() {
		if (!$this->isLogged()) {
			return $this->redirect('/login');
		}
		return $this->render('teacher_panels/temp_student_panel');
	}

}