<?php

class Activity extends Record
{
	const TABLE_NAME = 'activity';
	
	public	$id = false,
			$user_id = 0,
			$project_id = 0,
			$what = '',
			$item = '',
			$action = '',
			$date = '';
	
	public static function add($project, $what, $action, $user, $item)
	{
		$activity = new Activity;
		$activity->project_id = $project;
		$activity->what = $what;
		$activity->item = $item;
		$activity->action = $action;
		$activity->user_id = $user;
		$activity->date = date('Y-m-d');
		$activity->save();
	}

	public static function all()
	{
		$sql = 'SELECT activity.*, user.name AS user_name FROM activity
				LEFT JOIN user ON user_id = user.id
				ORDER BY date DESC, id DESC';

		$stmt = self::$__CONN__->prepare($sql);
		$stmt->execute();

		$items = array();
		while (($item = $stmt->fetchObject('Activity')) !== false)
			$items[] = $item;

		return $items;
	}

} // end Activity class
