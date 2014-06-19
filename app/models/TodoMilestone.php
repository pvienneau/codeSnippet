<?php

class TodoMilestone extends Record
{
	public static function add($todo, $milestone)
	{
		$sql = 'INSERT INTO todo_milestone (todo_id, milestone_id) VALUES ('.$todo.', '.$milestone.')';
		self::$__CONN__->exec($sql);
	}
	
	public static function remove($todo, $milestone)
	{
		$sql = 'DELETE FROM todo_milestone WHERE todo_id = '.$todo.' AND milestone_id = '.$milestone;
		self::$__CONN__->exec($sql);
	}
	
	public static function removeTodo($todo)
	{
		$sql = 'DELETE FROM todo_milestone WHERE todo_id = '.$todo;
		self::$__CONN__->exec($sql);
	}
	
	public static function fromTodo($todo)
	{
		$sql = 'SELECT milestone_id FROM todo_milestone WHERE todo_id = '.$todo;
		
		$stmt = self::$__CONN__->prepare($sql);
		$stmt->execute();
		
		return (int) $stmt->fetchColumn();
	}
}