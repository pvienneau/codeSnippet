<?php

class CommentController extends Controller
{
	function __construct()
	{
		AuthUser::load();
		if ( ! AuthUser::isLoggedIn()) {
			redirect(get_url('login'));
		}
	}
	
	function add()
	{
		$comment = new Comment($_POST['comment']);
		if ($comment->save()) {
			
			Activity::add(
				$_POST['project_id'],
				'comment',
				'Posted by',
				AuthUser::getId(),
				'<a href="comment/show/'.$_POST['comment']['object'].'/'.$_POST['comment']['object_id'].'">Re: '.substr(strip_tags($_POST['comment']['message']), 0, 40).'...</a>'
			);
			
			echo 'ok';
		} else {
			echo 'fail';
		}
	}
	
	function view($object, $id)
	{
		$item = Record::findByIdFrom(Inflector::camelize($object), $id);
		switch ($object) {
			case 'todo_item':
				$todo = Todo::findById($item->todo_id);
				$project = Project::findById($todo->project_id);
				break;
			default:
				$project = Project::findById($item->project_id);
		}
		
		//$comments = Comment::find($object, $id);
		
		$this->setLayout('project');
		$this->assignToLayout('project', $project);
		
		$this->display('comment/view', array(
			'project' => $project,
			'object' => $object,
			'object_id' => $id,
			$object => $item
		));
	}
	
	function show($object, $id)
	{
		return $this->view($object, $id);
	}
	
	function delete($id)
	{
		if ($comment = Comment::findById($id) && $comment->delete()) {
			echo 'ok';
		} else {
			echo 'fail';
		}
	}
}

