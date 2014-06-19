<?php

class TaskController extends Controller
{
	function __construct()
	{
		AuthUser::load();
		if ( ! AuthUser::isLoggedIn()) {
			redirect(get_url('login'));
		}
		$this->setLayout('default');
	}
	
	function index()
	{
		echo $this->render('task/index', array(
			'clients' => Client::findActive()
		));
	}
		
	function timer()
	{
		$this->setLayout(false);
		echo $this->render('project/timer');
	}
	
	function add_time()
	{
		list($hours, $minutes, $secondes) = explode(':', $_POST['time']);
		
		if ($project = Project::findById($_POST['project'])) {
			$project->hours += (int) $hours;
			
			$minutes = (int) $minutes;
			
			if ($minutes <= 15)
				$project->hours += .25;
			else if ($minutes <= 30)
				$project->hours += .5;
			else if ($minutes <= 45)
				$project->hours += .75;
			else
				$project->hours += 1;
			
			$project->save();
		}
	}
}