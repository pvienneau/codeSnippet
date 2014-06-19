<?php

class Milestone extends Record
{
	const TABLE_NAME = 'milestone';
	
	public	$id = false,
			$title = '',
			$due_on = '',
	 		$project_id = '',
			$assigned_to = 0,
			$is_completed = 0,
			$completed_on = '0000-00-00',
			$created_by = 0,
			$created_on = '';
	
	public function beforeInsert()
	{
		$this->created_by = AuthUser::getId();
		$this->created_on = date('Y-m-d H:i:s');
		return true;
	}
	
	public static function findById($id)
	{
		$sql = 'SELECT * FROM milestone WHERE id = ?';
		
		$stmt = self::$__CONN__->prepare($sql);
		$stmt->execute(array($id));
		
		return $stmt->fetchObject('Milestone');
	}
	
	public static function findAll()
	{
		$sql = 'SELECT milestone.*, user.name AS assigned_name, project.name AS project_name FROM milestone 
				LEFT JOIN project ON milestone.project_id = project.id
				LEFT JOIN user ON milestone.assigned_to = user.id
				ORDER BY title';
		return self::runSQL($sql);
	}
	public static function fromProject($id)
	{
		$sql = 'SELECT milestone.*, user.name AS assigned_name FROM milestone
				LEFT JOIN user ON milestone.assigned_to = user.id
				WHERE project_id = '.$id.'
				ORDER BY title';
		return self::runSQL($sql);
	}
	public static function late()
	{
		$sql = 'SELECT milestone.*, user.name AS assigned_name FROM milestone
				LEFT JOIN user ON assigned_to = user.id
				WHERE due_on < CURDATE() ORDER BY due_on';
		return self::runSQL($sql);
	}
	public static function upcoming()
	{
		$sql = 'SELECT milestone.*, user.name AS assigned_name FROM milestone
				LEFT JOIN user ON assigned_to = user.id
				WHERE due_on >= CURDATE() ORDER BY due_on';
		return self::runSQL($sql);
	}
	
	public static function lateInProject($id)
	{
		$sql = 'SELECT milestone.*, user.name AS assigned_name FROM milestone 
				LEFT JOIN user ON assigned_to = user.id
				WHERE project_id = '.$id.' AND due_on < CURDATE() ORDER BY due_on';
		return self::runSQL($sql);
	}
	public static function upcomingInProject($id)
	{
		$sql = 'SELECT milestone.*, user.name AS assigned_name FROM milestone 
				LEFT JOIN user ON assigned_to = user.id
				WHERE project_id = '.$id.' AND due_on >= CURDATE() ORDER BY due_on';
		return self::runSQL($sql);
	}
	
	private static function runSql($sql)
	{
		$stmt = self::$__CONN__->prepare($sql);
		$stmt->execute();
		
		$items = array();
		while (($item = $stmt->fetchObject('Milestone')) !== false)
			$items[] = $item;
		
		return $items;
	}

} // end Milestone class