<?php

class TodoItem extends Record
{
	const TABLE_NAME = 'todo_item';
	
	public	$id = false,
			$todo_id = 0,
	 		$description = '',
	 		$assigned_to = 0,
			$due_on = '0000-00-00',
			$is_done = 0,
			$done_on = '0000-00-00',
			$position = 0;
	
	public function beforeSave()
	{
		if ($this->due_on == '')
			$this->due_on = '0000-00-00';
		
		return true;
	}
	
	public static function findById($id)
	{
		$sql = 'SELECT * FROM todo_item WHERE id = ?';
		
		$stmt = self::$__CONN__->prepare($sql);
		$stmt->execute(array($id));
		
		return $stmt->fetchObject('TodoItem');
	}
	
	public static function openFromTodo($id)
	{
		$sql = 'SELECT todo_item.*, user.name AS assigned_name FROM todo_item
				LEFT JOIN user ON assigned_to = user.id
				WHERE is_done=0 AND todo_id='.((int)$id).' ORDER BY position';
		
		$stmt = self::$__CONN__->prepare($sql);
		$stmt->execute();
		
		$items = array();
		while (($item = $stmt->fetchObject('TodoItem')) !== false)
			$items[] = $item;
		
		return $items;
	}
	
	public static function doneFromTodo($id)
	{
		$sql = 'SELECT todo_item.*, user.name AS assigned_name FROM todo_item
				LEFT JOIN user ON assigned_to = user.id
				WHERE is_done=1 AND todo_id='.((int)$id).' ORDER BY position';
		
		$stmt = self::$__CONN__->prepare($sql);
		$stmt->execute();
		
		$items = array();
		while (($item = $stmt->fetchObject('TodoItem')) !== false)
			$items[] = $item;
		
		return $items;
	}
	
	public static function fromProject($id)
	{
		$sql = 'SELECT todo_item.*, todo.name AS todo_name, user.name AS assigned_name FROM todo_item
				LEFT JOIN todo ON todo_id = todo.id
				LEFT JOIN user ON assigned_to = user.id
				WHERE project_id='.((int)$id).' ORDER BY todo_item.position';
		
		$stmt = self::$__CONN__->prepare($sql);
		$stmt->execute();
		
		$items = array();
		while (($item = $stmt->fetchObject('TodoItem')) !== false)
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