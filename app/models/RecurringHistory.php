<?php

class RecurringHistory extends Record
{
	const TABLE_NAME = 'recurring_history';
	
	public	$recurring_id = false,
			$invoice_id = false,
			$timestamp = '';
	
	public function beforeInsert()
	{
		if (!$this->timestamp)
			$this->timestamp = date('Y-m-d H:i:s');
		return true;
	}
	public static function lastOccurence($id){
		$sql = "SELECT * FROM recurring_history WHERE recurring_id=? order by timestamp desc LIMIT 1";
		$stmt = self::$__CONN__->prepare($sql);
		$stmt->execute(array($id));
		return $stmt->fetchObject('RecurringHistory');
	}
	public static function ofRecurring($id)
	{
		$sql = "SELECT invoice.*, recurring_history.timestamp as recurringDate FROM invoice, recurring_history WHERE recurring_history.recurring_id=? and recurring_history.invoice_id = invoice.id  AND invoice.deleted = 0 ORDER BY invoice.invoice_id DESC";
		
		$stmt = self::$__CONN__->prepare($sql);
		$stmt->execute(array($id));
		
		return $stmt->fetchAll(self::FETCH_OBJ);
	}
	public static function ofInvoice($id)
	{
		$sql = 'SELECT * FROM recurring_history WHERE invoice_id=?';
		
		$stmt = self::$__CONN__->prepare($sql);
		$stmt->execute(array($id));
		
		return $stmt->fetchObject('RecurringHistory');
	}	
} // end Recurring class