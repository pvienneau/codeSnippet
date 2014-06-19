<?php

class TimeEntry extends Record
{
	const TABLE_NAME = 'time_entry';
	
	public	$id = false,
			$user_id = 0,
			$project_id = 0,
			$task_id = 0,
			$duration = 0,
			$description = '',
			$created_on = 0,
			$is_billable = 1;
	
	public function beforeInsert()
	{
		$this->user_id = AuthUser::getId();
		$this->created_on = date('Y-m-d');

		return true;
	}
	
	public static function fromUser($id)
	{
		
		$sql = "SELECT * FROM time_entry WHERE user_id=? ORDER BY created_on";
		
		$stmt = self::$__CONN__->prepare($sql);
		$stmt->execute(array($id));
		
		$items = array();
		while (($item = $stmt->fetchObject('TimeEntry')) !== false)
			$items[] = $item;
		
		return $items;
	}
}