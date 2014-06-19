<?php

class Project extends Record
{
	const TABLE_NAME = 'project';
	
	public 	$id = false,
			$client_id = 0,
			$name = '',
			$description = '',
			$budgeted = 0,
			$is_active = 1,
			$due_on = '',
			$created_on = 'draft';
	
	public function beforeInsert()
	{
		$this->created_on = date('Y-m-d');
		return true;
	}
	
	public function loggedHours()
	{
		if (!isset($this->logged)) {
			$sql = "SELECT SUM(duration) FROM entry WHERE is_billable=1 AND project_id = {$this->id}";
			//self::logQuery($sql);

			$stmt = self::$__CONN__->prepare($sql);
			$stmt->execute();

			$hours = (float) $stmt->fetchColumn();

			$this->logged = $hours;
		}
		
		return $this->logged;
	}
	
	public function remainingHours()
	{
		return !empty($this->budgeted) ? $this->budgeted - $this->loggedHours(): 0;
	}
	
	public function unbillableHours()
	{
		if (!isset($this->unbillable)) {
			$sql = "SELECT SUM(duration) FROM entry WHERE is_billable=0 AND project_id = {$this->id}";
			//self::logQuery($sql);

			$stmt = self::$__CONN__->prepare($sql);
			$stmt->execute();

			$hours = (float) $stmt->fetchColumn();

			$this->unbillable = $hours;
		}
		
		return $this->unbillable;
	}
	
	public function timer()
	{
		$sql = 'SELECT * FROM timer WHERE project_id = '.$this->id;
		
		$stmt = self::$__CONN__->prepare($sql);
		$stmt->execute();
		
		return $stmt->fetchObject('Timer');
	}
	
	public function timeInTimer()
	{
		$sql = "SELECT duration FROM timer WHERE project_id = {$this->id}";
		
		$stmt = self::$__CONN__->prepare($sql);
		$stmt->execute();

		return (float) $stmt->fetchColumn();
	}
	
	public static function findByName($name)
	{
		$sql = "SELECT * FROM project WHERE name='$name'";
		//self::logQuery($sql);
		
		$stmt = self::$__CONN__->prepare($sql);
		$stmt->execute();
		
		return $stmt->fetchObject('Project');
	}
	
	public static function findById($id)
	{
		$sql = 'SELECT * FROM project WHERE id = ?';
		
		$stmt = self::$__CONN__->prepare($sql);
		$stmt->execute(array($id));
		
		return $stmt->fetchObject('Project');
	}
	
	public static function findAll($status='')
	{
		if ($status)
			$status = " AND status = '{$status}'";
		
		$sql = "SELECT project.*, client.company AS client FROM project, client WHERE client.id = client_id$status ORDER BY created_on DESC, description";
		
		$stmt = self::$__CONN__->prepare($sql);
		$stmt->execute();
		
		$items = array();
		while (($item = $stmt->fetchObject('Project')) !== false)
			$items[] = $item;
		
		return $items;
	}
	
	public static function fromClient($id)
	{
		$sql = 'SELECT * FROM project WHERE client_id = ?';
		
		$stmt = self::$__CONN__->prepare($sql);
		$stmt->execute(array($id));
		
		$items = array();
		while (($item = $stmt->fetchObject('Project')) !== false)
			$items[] = $item;
		
		return $items;
	}
	
	public function activities($month=false)
	{
		if (!$month)
			$month = date('Y-m');
		
		if (strlen($month) == 4) {
			$data = "date_format(created_on, '%c')";
			$month = "AND DATE_FORMAT(created_on, '%Y')='$month'";
		} else if (strlen($month) == 7) {
			$data = "date_format(created_on, '%e')";
			$month = "AND DATE_FORMAT(created_on, '%Y-%m')='$month'";
		}
		$sql = "SELECT $data AS data, sum(duration) AS hours FROM entry WHERE project_id='{$this->id}' $month GROUP BY data";
		
		$stmt = self::$__CONN__->prepare($sql);
		$stmt->execute();
		
		$items = array();
		while (($item = $stmt->fetch(PDO::FETCH_ASSOC)) !== false)
			$items[$item['data']] = $item['hours'];
		
		return $items;
	}
	
	public static function active($active=1)
	{
		$active = (int) $active;
		$sql = "SELECT * FROM project WHERE is_active=$active ORDER BY name";
		
		//self::logQuery($sql);
		
		$stmt = self::$__CONN__->prepare($sql);
		$stmt->execute(array($id));
		
		$items = array();
		while (($item = $stmt->fetchObject('Project')) !== false)
			$items[] = $item;
		
		return $items;
	}
	public static function inactive() { return self::active(0); }
	
	public static function activeIn($month)
	{
		$sql = "SELECT project.* FROM project, entry WHERE entry.project_id = project.id AND DATE_FORMAT(entry.created_on, '%Y-%m')='$month' GROUP BY project.id ORDER BY project.name";
		
		//self::logQuery($sql);
		
		$stmt = self::$__CONN__->prepare($sql);
		$stmt->execute(array($id));
		
		$items = array();
		while (($item = $stmt->fetchObject('Project')) !== false)
			$items[$item->id] = $item;
		
		return $items;
	}
} // end Project class
