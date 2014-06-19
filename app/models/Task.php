<?php

class Task extends Record
{
	const TABLE_NAME = 'task';
	
	public	$id = false,
			$project_id = 0,
			$user_id = 0,
			$description = '',
			$budgeted = 0,
			$logged = 0,
			$position = 0;

	public function addTime($hours)
	{
		$time = new TimeEntry(array(
			'project_id' => $this->project_id,
			'task_id' => $this->id,
			'duration' => $hours
		));
		
		$time->save();
		
		$this->logged += $hours;
		$this->save();
	}
	
	public static function findById($id)
	{
		$sql = 'SELECT * FROM task WHERE id=?';
		
		$stmt = self::$__CONN__->prepare($sql);
		$stmt->execute(array($id));
		
		return $stmt->fetchObject('Task');
	}

	public static function fromProject($id)
	{
		
		$sql = "SELECT * FROM task WHERE project_id=? ORDER BY position";
		
		$stmt = self::$__CONN__->prepare($sql);
		$stmt->execute(array($id));
		
		$items = array();
		while (($item = $stmt->fetchObject('Task')) !== false)
			$items[] = $item;
		
		return $items;
	}
	
	public static function fromUser($id)
	{
		
		$sql = "SELECT * FROM task WHERE user_id=? ORDER BY position";
		
		$stmt = self::$__CONN__->prepare($sql);
		$stmt->execute(array($id));
		
		$items = array();
		while (($item = $stmt->fetchObject('Task')) !== false)
			$items[] = $item;
		
		return $items;
	}
	
	public static function fromEstimate($id)
	{
		
		$sql = "SELECT * FROM task WHERE estimate_id=? ORDER BY position";
		
		$stmt = self::$__CONN__->prepare($sql);
		$stmt->execute(array($id));
		
		$items = array();
		while (($item = $stmt->fetchObject('Task')) !== false)
			$items[] = $item;
		
		return $items;
	}
		
} // end Task class
