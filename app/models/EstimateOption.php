<?php

class EstimateOption extends Record
{
	const TABLE_NAME = 'estimate_option';
	
	public 	$id = false,
			$estimate_id = 0,
			$description = '',
			$qty = 0,
			$kind = '',
			$price = 0,
			$total = 0,
			$accepted = 0,
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
		$sql = 'SELECT * FROM estimate_option WHERE id = ?';
		
		$stmt = self::$__CONN__->prepare($sql);
		$stmt->execute(array($id));
		
		return $stmt->fetchObject('EstimateLine');
	}
	
	public static function findAll()
	{
		$sql = 'SELECT * FROM estimate_option ORDER BY position, description';
		
		$stmt = self::$__CONN__->prepare($sql);
		$stmt->execute();
		
		return $stmt->fetchAll(self::FETCH_OBJ);
	}
	
	public static function of($estimate_id)
	{
		$sql = 'SELECT * FROM estimate_option WHERE estimate_id=? ORDER BY position, id';
		
		$stmt = self::$__CONN__->prepare($sql);
		$stmt->execute(array($estimate_id));
		
		$items = array();
		while (($item = $stmt->fetchObject('EstimateOption')) !== false)
			$items[] = $item;
		
		return $items;
	}
	
} // end InvoiceLine class
