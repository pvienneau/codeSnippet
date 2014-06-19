<?php

class RecurringLine extends Record
{
	const TABLE_NAME = 'recurring_line';
	
	public 	$id = false,
			$recurring_id = 0,
			$description = '',
			$qty = 0,
			$kind = '',
			$price = 0,
			$total = 0,
			$position = 0;
			
	
	public function beforeSave()
	{
		$this->qty   = number_format(sanatize_number($this->qty), 2, '.', '');
		$this->price = number_format(sanatize_number($this->price), 2, '.', '');
		$this->total = number_format(sanatize_number($this->qty * $this->price), 2, '.', '');
		
		return true;
	}
	
	public static function findById($id)
	{
		$sql = 'SELECT * FROM recurring_line WHERE id = ?';
		
		$stmt = self::$__CONN__->prepare($sql);
		$stmt->execute(array($id));
		
		return $stmt->fetchObject('RecurringLine');
	}
	
	public static function findAll()
	{
		$sql = 'SELECT * FROM recurring_line ORDER BY position, description';
		
		$stmt = self::$__CONN__->prepare($sql);
		$stmt->execute();
		
		return $stmt->fetchAll(self::FETCH_OBJ);
	}
	
	public static function of($recurring_id)
	{
		$sql = 'SELECT * FROM recurring_line WHERE recurring_id=? ORDER BY position, id';
		
		$stmt = self::$__CONN__->prepare($sql);
		$stmt->execute(array($recurring_id));
		
		$items = array();
		while (($item = $stmt->fetchObject('RecurringLine')) !== false)
			$items[] = $item;
		
		return $items;
	}
	
} // end RecurringLine class
