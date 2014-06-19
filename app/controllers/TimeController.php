<?php 

/*
   Class: TimeController
      Enter description here...

   Generated on Mon, 31 Aug 2009 20:00:28 -0400 by Framework.php

   Author:
      Philippe Archambault <philippe.archambault@gmail.com>
*/

class TimeController extends Controller
{
	public function __construct()
	{
		AuthUser::load();
		if ( ! AuthUser::isLoggedIn())
			redirect(get_url('login'));
		
	}

	public function index()
	{	
		$this->setLayout('default');
		$this->display('time/dashboard');
	}

	public function add()
	{
		if (get_request_method() == 'POST')
			return $this->_add();
	}
	
	private function _add()
	{
		$data = $_POST['entry'];

		// validation has to be done here ...
		$project_name = strip_tags(trim($_POST['project']));
		
		// check if we need to create a new project
		if (!empty($project_name)) {
			if (!$project = Project::findByName($project_name)) {
				$project = new Project(array('name' => $project_name));
				$project->save();
			}
			
			$data['project_id'] = $project->id;
		}
		
		$entry = new Entry($data);
		
		if (!$entry->save()) {
			Flash::set('post_data', $data);
			Flash::set('error', 'Entry has NOT been added!');
			
			redirect(get_url('time'));
		}
		else Flash::set('success', 'Entry added!');

		redirect(get_url('time'));
	}
	
	public function edit($id)
	{
		if (!$entry = Entry::get($id)) {
			//echo '{"error":"Entry not found!"}';
			//exit;
		}

		// check for a form submited
		if (get_request_method() == 'POST')
			return $this->_edit($entry);
	}
	
	private function _edit($entry)
	{
		$data = $_POST['entry'];
		
		$project_name = strip_tags(trim($_POST['project']));
		
		// check if we need to create a new project
		if (!empty($project_name)) {
			if (!$project = Project::findByName($project_name)) {
				$project = new Project(array('name' => $project_name));
				$project->save();
			}
			
			$data['project_id'] = $project->id;
		}
		
		$entry->setFromData($data);
		
		if (!$entry->save()) {
			//echo '{"error":"Entry not saved!"}';
		}
		//else echo '{"success":"Entry saved!"}';
		
		//exit;
		redirect($_SERVER['HTTP_REFERER']);
	}
	
	public function delete($id)
	{
		if (AuthUser::isAdmin() || $entry->user_id == AuthUser::getId())
		{
			if ($entry = Entry::get($id)) {
				if (!$entry->delete())
					Flash::set('error', 'Entry not deleted!');
				else
					Flash::set('success', 'One less entry!');
			}
		}

		redirect($_SERVER['HTTP_REFERER']);
	}
	
	public function get($id)
	{
		$entry = Entry::get($id);
		$entry->tags = $entry->tags();
		$entry->project = Project::get($entry->project_id)->name;
		
		echo $this->renderJSON($entry);
	}
	
	public function pulse($month=false)
	{
		if (!$month)
			$month = date('Y-m');
		
		$where = "date_format(entry.created_on, '%Y-%m') = '$month'";
		
		$this->setLayout('default');
		$this->display('time/pulse', array(
			'range_date' => display_date($month.'-01', false).
							' - '.
							display_date($month.'-'.date('t', strtotime($month.'-01')), false),
			'month'   => $month
		));
	}
	
	public function timer()
	{	
		$this->display('time/timer');
	}
	
	public function timer_play($id)
	{
		if ($project = Project::findById($id)) {
			if (!$timer = Timer::fromProject($project->id)) {
				$timer = new Timer(array('project_id' => $project->id));
			}
			$timer->start();
		}
	}
	
	public function timer_pause($id)
	{
		if ($project = Project::findById($id)) {
			if ($timer = Timer::fromProject($project->id)) {
				echo $timer->pause();
			}
		}
	}
	
	public function timer_log()
	{
		if (!isset($_POST['project_id'])) {
			Flash::set('error', 'Not Logged!');
		}
		else {
			$id = (int) $_POST['project_id'];

			if ($project = Project::findById($id)) {
				if ($timer = Timer::fromProject($project->id)) {

					$entry = new Entry();
					$entry->user_id = $timer->user_id;
					$entry->project_id = $timer->project_id;
			 		$entry->duration = $_POST['duration'];
			 		$entry->description = $_POST['description'];
			 		$entry->created_on = $timer->created_on;

					if ($entry->save()) {
						$timer->delete();
						Flash::set('success', 'Entry Logged!');
					}
				}
			}
		}
		
		redirect(get_url('time/timer'));
	}
	
} // end TimeController class
