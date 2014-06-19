<?php

class MilestoneController extends Controller
{
	function __construct()
	{
		AuthUser::load();
		if ( ! AuthUser::isLoggedIn()) {
			redirect(get_url('login'));
		}
	}
	
	function index()
	{
		$this->setLayout('todo');
		$this->display('milestone/index');
	}
	
	function project($id)
	{
		if (!$project = Project::findById($id)) {
			Flash::set('error', 'Project not found!');
			redirect(get_url('milestone'));
		}
		
		$this->setLayout('project');
		$this->assignToLayout('project', $project);
		
		$this->display('project/milestone/index', array(
			'project' => $project,
			'late' => Milestone::lateInProject($project->id),
			'upcoming' => Milestone::upcomingInProject($project->id)
		));
	}
	
	function show($id)
	{
		$this->setLayout('todo');
		$this->display('milestone/index', array(
			'milestone' => Milestone::findById($id)
		));
	}
	
	function add($project_id)
	{
		if (!$project = Project::findById($project_id)) {
			Flash::set('error', 'Project not found!');
			redirect(get_url('milestone'));
		}

		if (!empty($_POST['milestone'])) {
			$item = new Milestone($_POST['milestone']);
			$item->project_id = $project->id;
			$item->save();

			Activity::add(
				$project->id,
				'milestone',
				'Assigned to',
				$item->assigned_to,
				'<a href="project/'.$project->id.'/milestone">'.$item->title.'</a> <i class="date"> Due '.my_date_format($item->due_on).'</i>'
			);
			
			redirect(get_url('project/'.$project->id.'/milestone'));
		}
		
		$this->setLayout('project');
		$this->assignToLayout('project', $project);
		
		$this->display('project/milestone/edit', array(
			'project' => $project,
			'milestone' => new Milestone()
		));
	}
	
	function edit($id, $project_id=false)
	{
		if (!$item = Milestone::findById($id)) {
			Flash::set('error', 'Milestone not found!');
			redirect(get_url('milestone'));
		}
		
		if (!$project = Project::findById($item->project_id)) {
			Flash::set('error', 'Project not found!');
			redirect(get_url('milestone'));
		}
		
		if (!empty($_POST['milestone'])) {

			$item->setFromData($_POST['milestone']);

			if ($item->save()) {
				Flash::set('success', 'Milestone <strong>'.$item->title.'</strong> has been updated with success!');
			} else {
				Flash::set('error', 'Milestone <strong>'.$item->title.'</strong> has NOT been updated!');
			}
			redirect(get_url('project/'.$project->id.'/milestone'));
		}
		
		$this->setLayout('project');
		$this->assignToLayout('project', $project);
		
		$this->display('project/milestone/edit', array(
			'project' => $project,
			'milestone' => $item
		));
	}
	
	function delete($id)
	{
		if (!$item = Milestone::findById($id)) {
			Flash::set('error', 'Milestone not found!');
			redirect(get_url('milestone'));
		}
		
		//$item->delete();
	}

}