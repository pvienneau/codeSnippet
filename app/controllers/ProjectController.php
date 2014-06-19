<?php

class ProjectController extends Controller
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
		echo $this->render('project/index', array(
			'projects' => Project::findAll(),
			'company' => Settings::company()
		));
	}
	
	public function dashboard()
	{
		$this->setLayout('todo');
		$this->display('project/dashboard');
	}
	
	public function overview($id=false)
	{
		if ($project = Project::findById($id)) {
			
			$this->setLayout('project');
			$this->assignToLayout('project', $project);
			
			$this->display('project/overview', array(
				'project' => $project
			));
		}
	}
	
	public function show($id, $month=false)
	{
		//$this->setLayout('default');
		$this->display('project/show', array(
			'project' => Project::findById($id),
			'month' => !$month ? date('Y-m'): $month
		));
	}
	
	function add()
	{
		if (!empty($_POST)) {
			return $this->_add();
		}
		
		echo $this->render('project/edit', array('project' => new Project));
	}
	
	function _add()
	{
		$data = $_POST;
		$project = new Project($data);
		$project->save();
		
		//echo 'done!';
		//redirect(get_url('client'));
	}
	
	function from_estimate()
	{
		if ($estimate = Estimate::findById($_POST['estimate_id']))
		{
			$project = new Project();
			$project->client_id = $estimate->client_id;
			$project->name = trim($_POST['name']);
			$project->save();

			// create task with all lines
			$lines = EstimateLine::of($estimate->id);

			$budgeted = 0;
			foreach ($lines as $line) {
				if ($line->kind == 'hour') {
					$budgeted += $line->qty;
					
					$task = new Task();
					$task->project_id = $project->id;
					$task->description = $line->description;
					$task->budgeted = $line->qty;
					$task->position = $line->position;
					$task->save();
				}
			}
			
			$project->budgeted = $budgeted;
			$project->save();
		}
	}
	
	function edit($id)
	{
		if (!empty($_POST)) {
			return $this->_edit($id);
		}
		
		echo $this->render('project/edit', array('project' => Project::findById($id)));
	}
	
	function _edit($id)
	{
		if (!$project = Project::findById($id)) {
			Flash::set('error', 'Project not found!');
			redirect(get_url('project'));
		}
		
		$data = $_POST;
		$project->setFromData($data);
		
		if ($project->save()) {
			Flash::set('success', 'Project <strong>'.$project->description.'</strong> has been updated with success!');
		} else {
			Flash::set('error', 'Project <strong>'.$project->description.'</strong> has NOT been updated!');
		}
		redirect(get_url('project'));
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
	
	
	public function archive($id)
	{
		$project = Project::get($id);
		$project->is_active = 0;
		if ($project->save())
		{
			Flash::set('success', 'Project <strong>'.$project->name.'</strong> has been archived!');
		}
		else Flash::set('error', 'Project <strong>'.$project->name.'</strong> has been NOT been archived!');

		redirect(get_url('project/show/'.$project->id));
	}

	public function activate($id)
	{
		$project = Project::findById($id);
		$project->is_active = 1;
		if ($project->save())
		{
			Flash::set('success', 'Project <strong>'.$project->name.'</strong> has been reactivated!');
		}
		else Flash::set('error', 'Project <strong>'.$project->name.'</strong> has been NOT been reactivated!');

		redirect(get_url('project/show/'.$project->id));
	}
	
	public function matching()
	{
		$value = strip_tags(trim(($_POST['value'])));
		
		$projects = Record::findAllFrom('Project', "name LIKE '%$value%'");
		
		$data = array();
		foreach($projects as $project) {
			$data[] = array('value' => $project->name);
		}
		
		if (empty($data))
			$data[] = array('value' => $value, 'display' => "<b>$value</b> will be created");
		
		echo $this->renderJSON($data);
	}
	
	function delete($id)
	{
		
	}
}