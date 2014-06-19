<?php

class InvoiceHistory extends Record
{
	const TABLE_NAME = 'invoice_history';
	
	public	$id = false,
	 		$invoice_id = '',
	 		$date = '',
	 		$event = '',
			$description='';
	
	public function beforeInsert()
	{
		if (!$this->date)
			$this->date = date('Y-m-d H:i:s');
		
		$this->user_id = AuthUser::getId();
		
		return true;
	}
	
	public static function findById($id)
	{
		$sql = 'SELECT * FROM invoice_history WHERE id = ?';
		
		$stmt = self::$__CONN__->prepare($sql);
		$stmt->execute(array($id));
		
		return $stmt->fetchObject('InvoiceHistory');
	}
	
	public static function of($invoice_id)
	{
		$sql = 'SELECT * FROM invoice_history WHERE invoice_id=? ORDER BY `date` DESC';
		
		$stmt = self::$__CONN__->prepare($sql);
		$stmt->execute(array($invoice_id));
		
		return $stmt->fetchAll(self::FETCH_OBJ);
	}

} // end InvoiceHistory class
