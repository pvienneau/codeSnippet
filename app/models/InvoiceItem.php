<?php

class InvoiceItem extends Record
{
	const TABLE_NAME = 'invoice_item';
	
	public	$id = false,
	 		$description = '',
	 		$qty = 0,
	 		$kind = '',
	 		$price = 0,
	 		$total = 0;
	
	public function beforeSave()
	{
		$this->qty   = number_format(sanatize_number($this->qty), 2, '.', '');
		$this->price = number_format(sanatize_number($this->price), 2, '.', '');
		$this->total = number_format(sanatize_number($this->qty * $this->price), 2, '.', '');
		
		return true;
	}
	
	public static function findById($id)
	{
		$sql = 'SELECT * FROM invoice_item WHERE id = ?';
		
		$stmt = self::$__CONN__->prepare($sql);
		$stmt->execute(array($id));
		
		return $stmt->fetchObject('InvoiceItem');
	}
	
	public static function findAll()
	{
		$sql = 'SELECT * FROM invoice_item ORDER BY description';
		
		$stmt = self::$__CONN__->prepare($sql);
		$stmt->execute();
		
		return $stmt->fetchAll(self::FETCH_OBJ);
	}
	
} // end InvoiceItem class
