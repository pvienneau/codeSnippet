<?php

class Todo extends Record
{
	const TABLE_NAME = 'todo';
	
	public	$id = false,
			$name = '',
	 		$description = '',
	 		$project_id = 0,
			$is_completed = 0,
			$created_by = 0,
			$created_on = '',
			$position = 0;
	
	public function beforeInsert()
	{
		$this->created_by = AuthUser::getId();
		$this->created_on = date('Y-m-d H:i:s');
		return true;
	}
	
	public function hasOpenItem()
	{
		$sql = 'SELECT COUNT(id) FROM todo_item WHERE todo_id = ? AND is_done = 0';
		
		$stmt = self::$__CONN__->prepare($sql);
		$stmt->execute(array($this->id));
		
		return (bool) $stmt->fetchColumn();
	}
	
	public static function findById($id)
	{
		$sql = 'SELECT * FROM todo WHERE id = ?';
		
		$stmt = self::$__CONN__->prepare($sql);
		$stmt->execute(array($id));
		
		return $stmt->fetchObject('Todo');
	}
	
	public static function findAll()
	{
		$sql = 'SELECT * FROM todo';
		
		$stmt = self::$__CONN__->prepare($sql);
		$stmt->execute();
		
		$items = array();
		while (($item = $stmt->fetchObject('Todo')) !== false)
			$items[] = $item;
		
		return $items;
	}
	
	public static function fromProject($id)
	{
		$id = (int) $id;
		$sql = 'SELECT * FROM todo WHERE project_id = '.$id;
		
		$stmt = self::$__CONN__->prepare($sql);
		$stmt->execute();
		
		$items = array();
		while (($item = $stmt->fetchObject('Todo')) !== false)
			$items[] = $item;
		
		return $items;
	}
	
	public static function inMilestone($id)
	{
		$id = (int) $id;
		$sql = 'SELECT todo.* FROM todo, todo_milestone WHERE todo_id = todo.id AND milestone_id = '.$id;
		
		$stmt = self::$__CONN__->prepare($sql);
		$stmt->execute();
		
		$items = array();
		while (($item = $stmt->fetchObject('Todo')) !== false)
			$items[] = $item;
		
		return $items;
	}
	
	/*public static function findActive()
	{
		$sql = 'SELECT todo.* FROM task, todo WHERE task.client_id = client.id AND task.done = 0 GROUP BY client.id ORDER BY company';
		
		$stmt = self::$__CONN__->prepare($sql);
		$stmt->execute();
		
		$items = array();
		while (($item = $stmt->fetchObject('Client')) !== false)
			$items[] = $item;
		
		return $items;
	}*/

} // end Todo class