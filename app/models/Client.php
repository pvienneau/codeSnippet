<?php

class Client extends Record
{
	const TABLE_NAME = 'client';
	
	public	$id = false,
			$name = '',
	 		$email = '',
	 		$company = '',
	 		$address_line_1 = '',
	 		$address_line_2 = '',
	 		$city = '',
	 		$zip_code = '',
	 		$state = '',
	 		$country = '',
	 		$tax_id = '',
			$tax = 0,
			$tax2 = 0,
			$tax_name = 'TPS',
			$tax2_name = 'TVQ',
			$tax2_cumulative = 1,
	//public $rate = DEFAULT_RATE;
	//public $note = '';
	//public $is_active = 1;
	 		$created_on = '',
			$deleted = 0;
	//public $created_by = '';
	
	public function beforeInsert()
	{
		//$this->created_by = AuthUser::getId();
		$this->created_on = date('Y-m-d H:i:s');
		return true;
	}
	
	public static function findById($id)
	{
		$sql = 'SELECT client.* FROM client WHERE client.id = ?';
		
		$stmt = self::$__CONN__->prepare($sql);
		$stmt->execute(array($id));
		
		return $stmt->fetchObject('Client');
	}
	
	public static function findAll()
	{
		$sql = 'SELECT * FROM client WHERE id != 1 AND deleted = 0 ORDER BY company';
		
		$stmt = self::$__CONN__->prepare($sql);
		$stmt->execute();
		
		return $stmt->fetchAll(self::FETCH_OBJ);
	}
	
	public static function findActive()
	{
		$sql = 'SELECT client.* FROM task, client WHERE task.client_id = client.id AND task.done = 0 GROUP BY client.id ORDER BY company';
		
		$stmt = self::$__CONN__->prepare($sql);
		$stmt->execute();
		
		$items = array();
		while (($item = $stmt->fetchObject('Client')) !== false)
			$items[] = $item;
		
		return $items;
	}

} // end Client class
