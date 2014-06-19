<?php

class TodoController extends Controller
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
		$this->display('todo/index', array(
			'todos' => Todo::findAll()
		));
	}
	
	function project($id)
	{
		if (!$project = Project::findById($id)) {
			Flash::set('error', 'Project not found!');
			redirect(get_url('todo'));
		}
		
		$this->setLayout('project');
		$this->assignToLayout('project', $project);
		
		$this->display('project/todo/index', array(
			'project' => $project,
			'todos' => Todo::fromProject($id)
		));
	}
	
	function show($id, $project_id)
	{
		if (!$project = Project::findById($project_id)) {
			Flash::set('error', 'Project not found!');
			redirect(get_url('todo'));
		}
			
		$this->setLayout('project');
		$this->assignToLayout('project', $project);
		
		$this->display('project/todo/show', array(
			'project' => $project,
			'todo' => Todo::findById($id)
		));
	}
	
	function add($project_id)
	{
		if (!$project = Project::findById($project_id)) {
			Flash::set('error', 'Project not found!');
			redirect(get_url('todo'));
		}
		
		if (!empty($_POST['todo'])) {
			$item = new Todo($_POST['todo']);
			$item->project_id = $project->id;
			$item->save();

			// todo milestone assosiation
			if (!empty($_POST['todo_milestone']['milestone_id']))
				TodoMilestone::add($item->id, (int) $_POST['todo_milestone']['milestone_id']);

			redirect(get_url('todo/show/'.$item->id));
		}
		
		$this->setLayout('project');
		$this->assignToLayout('project', $project);
		
		$this->display('project/todo/edit', array(
			'project' => $project,
			'todo' => new Todo()
		));
	}
	
	function edit($id, $project_id=false)
	{
		if (!$item = Todo::findById($id)) {
			Flash::set('error', 'Todo list not found!');
			redirect(get_url('todo'));
		}
		
		if (!$project = Project::findById($item->project_id)) {
			Flash::set('error', 'Project not found!');
			redirect(get_url('todo'));
		}
		
		if (!empty($_POST['todo'])) {
		
			$item->setFromData($_POST['todo']);

			if ($item->save()) {
				
				// todo milestone assosiation
				if (!empty($_POST['todo_milestone']['milestone_id']))
					TodoMilestone::add($item->id, (int) $_POST['todo_milestone']['milestone_id']);
				else
					TodoMilestone::removeTodo($item->id);
				
				Flash::set('success', 'Todo list <strong>'.$item->name.'</strong> has been updated with success!');
			} else {
				Flash::set('error', 'Todo list <strong>'.$item->name.'</strong> has NOT been updated!');
			}
			redirect(get_url('project/'.$project->id.'/todo/show/'.$item->id));
		}
		
		$this->setLayout('project');
		$this->assignToLayout('project', $project);
		
		$this->display('project/todo/edit', array(
			'project' => $project,
			'todo' => $item
		));
	}
	
	function delete($id)
	{
		if (!$item = Todo::findById($id)) {
			Flash::set('error', 'Todo list not found!');
			redirect(get_url('todo'));
		}
		
		if ($item->delete()) {
			Flash::set('success', 'Todo list <strong>'.$item->name.'</strong> has been deleted with success!');
		} else {
			Flash::set('error', 'Todo list <strong>'.$item->name.'</strong> has NOT been deleted!');
		}
		redirect(get_url('todo'));
	}

	//
	//    T O D O   I T E M
	//
	
	function add_item($todo_id)
	{
		if (!$todo = Todo::findById($todo_id)) {
			return Flash::set('error', 'Todo list not found!');
		}
		
		if (!empty($_POST['item'])) {
			$item = new TodoItem($_POST['item']);
			$item->todo_id = $todo->id;
			$item->save();
			
			Activity::add(
				$todo->project_id,
				'to-do',
				'Assigned to',
				$item->assigned_to,
				$item->description.' <a href="project/'.$todo->project_id.'/todo/'.$todo->id.'">'.$todo->name.'</a>'
			);
			
			echo '<li><input type="checkbox" name="task[]" value="'.$item->id.'"> '.($item->assigned_to ? '<b>'.User::findBy('id', $item->assigned_to)->name.'</b> ': '').$item->description.'</li>';
		}
	}
	function delete_item($id)
	{
		if ($item = TodoItem::findById($id)) {
			$item->delete();
		}
	}
	
	function item_done($id)
	{
		if (!$item = TodoItem::findById($id)) {
			return Flash::set('error', 'Todo item not found!');
		}
		
		$todo = Todo::findById($item->todo_id);
		
		$item->is_done = 1;
		$item->done_on = date('Y-m-d');
		$item->save();
		
		Activity::add(
			$todo->project_id,
			'to-do',
			'Completed by',
			AuthUser::getId(),
			'<del>'.$item->description.'</del> <a href="project/'.$todo->project_id.'/todo/show/'.$todo->id.'">'.$todo->name.'</a>'
		);
		
		// check if we have done them all
		if (!$todo->hasOpenItem()) {
			$todo->is_completed = 1;
			$todo->completed_on = date('Y-m-d');
			$todo->save();
		}
	}
	
	function item_open($id)
	{
		if (!$item = TodoItem::findById($id)) {
			return Flash::set('error', 'Todo item not found!');
		}
		
		$item->is_done = 0;
		$item->done_on = '0000-00-00';
		$item->save();
		
		$todo = Todo::findById($item->todo_id);
		
		if ($todo->is_completed) {
			$todo->is_completed = 0;
			$todo->completed_on = '0000-00-00';
			$todo->save();
		}
	}
}