<?php

class EstimateHistory extends Record
{
	const TABLE_NAME = 'estimate_history';
	
	public	$id = false,
	 		$estimate_id = 0,
	 		$user_id = 1,
	 		$date = '',
	 		$event = '';
	
	public function beforeInsert()
	{
		if (!$this->date)
			$this->date = date('Y-m-d H:i:s');
		
		$this->user_id = AuthUser::getId();
		
		return true;
	}
	
	public static function findById($id)
	{
		$sql = 'SELECT * FROM estimate_history WHERE id = ?';
		
		$stmt = self::$__CONN__->prepare($sql);
		$stmt->execute(array($id));
		
		return $stmt->fetchObject('EstimateHistory');
	}
	
	public static function of($estimate_id)
	{
		$sql = 'SELECT * FROM estimate_history WHERE estimate_id=? ORDER BY `date` DESC';
		
		$stmt = self::$__CONN__->prepare($sql);
		$stmt->execute(array($estimate_id));
		
		return $stmt->fetchAll(self::FETCH_OBJ);
	}

} // end InvoiceHistory class
