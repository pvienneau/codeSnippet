<?php

class Recurring extends Record
{
	const TABLE_NAME = 'recurring';
	
	public	$id = false,
			$name = '',
			$permalink = '',
			$status = 'draft',
			$date = '',
			$schedule = '',
			$schedule_other = 0,
			$send = 0,
			$send_attach = 0,
			$send_copy = 0,
			$send_subject = '',
			$send_message = '',
			$due = 30,
			$currency_symbol = '',
			$currency_code = '',
			$notes = '',
			$client_id = 0,
			$subtotal = 0,
			$tax = 0,
			$tax2 = 0,
			$tax_name = 'TPS',
			$tax2_name = 'TVQ',
			$tax2_cumulative = 1,
			$discount = 0,
			$shipping = 0,
			$management = 0,
			$discount_fee = 0,
			$management_fee = 0,
			$total = 0,
			$language = 'fr',
			$display_country = 0,
			$created_by = 0,
			$last_generation = '0000-00-00',
			$is_active = 1,
			$deleted = 0;
			
	//public $rate = DEFAULT_RATE;
	
	public function beforeInsert()
	{
		$this->created_by = AuthUser::getId();
		$this->date = date('Y-m-d H:i:s');
		
		$permalink = Recurring::generatePermalink();
		while (Recurring::findByPermalink($permalink)) {
			$permalink = Recurring::generatePermalink();
		}
		
		$this->permalink = $permalink;
		return true;
	}
	
	public function nextOccurence($notice=false){
		$lastOccurence = RecurringHistory::lastOccurence($this->id);
		
		if($lastOccurence){
			$lastDate = $lastOccurence->timestamp;
		}else{
			$lastDate = $this->date;
		}
		
		switch($this->schedule){
			case 'yearly':
				$next = " + 1 year";
				if($notice) $next .= " - 1 month";
				break;
			case 'quarterly':
				$next = " + 3 month";
				if($notice) $next .= " - 2 weeks";
				break;
			case 'monthly':
				$next = " + 1 month";
				if($notice) $next .= " - 1 week";
				break;
			case 'weekly':
				$next = " + 1 week";
				if($notice) $next .= " - 2 days";
				break;
			case 'daily':
				$next = " + 1 day";
				break;
			case 'other':
				$next = " + ".$this->schedule_other . " day";
		};	
		return date("Y-m-d", strtotime(date("Y-m-d", strtotime($lastDate)) . $next));
	}
	
	public function createInvoice(){
		$data = get_object_vars($this);
		unset(	$data['id'], $data['date'], $data['name'], $data['schedule'], $data['schedule_other'], 
				$data['send'], $data['send_attach'], $data['send_copy'], $data['send_subject'], 
				$data['send_message'], $data['last_generation'], $data['is_active']  );

		$invoice = new Invoice($data);
		$invoice->due_date =date("Y-m-d", strtotime(date("Y-m-d") . '+'.$invoice->due.' days')); 
		$invoice->invoice_id = Invoice::getNextNumber();
		//$invoice->created_by = (AuthUser::getId()) ? AuthUser::getId() : 2;
		$invoice->project_name = $this->name;
		$invoice->status = 'recurring';
		
		if ($invoice->save()) {
			$pos = 0;
			$invoice->total = 0;
			
			$lines = RecurringLine::of($this->id);
			// add lines
			foreach ($lines as $newline) {
				$data = get_object_vars($newline);
				unset($data['recurring_id']);
				$line = new InvoiceLine($data);
				$line->invoice_id = $invoice->id;
				$line->position = $pos++;
				
				$line->save();
				$invoice->total += $line->total;
			}
			
			$this->_calculate($invoice);
			$invoice->save();
			$history = new RecurringHistory();
			$history->recurring_id = $this->id;
			$history->invoice_id = $invoice->id;
			$history->save();
		}else{
			$invoice->invoice_id = "FAIL";	
		}
		return $invoice;
			
	}
	private function _calculate($invoice)
	{
		$invoice->management_fee = 0;
		if ($invoice->management) {
			$invoice->management_fee = $invoice->total * ($invoice->management/100);
			$invoice->total += $invoice->management_fee;
		}
		
		// let this here cause we need the project management included in subtotal
		$invoice->subtotal = $invoice->total;
		
		$invoice->discount_fee = 0;
		if ($invoice->discount) {
			$invoice->discount_fee = $invoice->total * ($invoice->discount/100);
			$invoice->total -= $invoice->discount_fee;
		}
		
		$invoice->tax_fee = 0;
		if ($invoice->tax) {
			$invoice->tax_fee = $invoice->total * ($invoice->tax/100);
		}
		
		if ($invoice->tax2) {
			if ($invoice->tax2_cumulative) {
				$invoice->tax2_fee = ($invoice->total + $invoice->tax_fee) * ($invoice->tax2/100);
			} else {
				$invoice->tax2_fee = $invoice->total * ($invoice->tax2/100);
			}
			$invoice->total += $invoice->tax2_fee;
		}
		$invoice->total += $invoice->tax_fee;
		
		if ($invoice->shipping) {
			$invoice->total += $invoice->shipping;
		}
	}
	
	public static function findById($id)
	{
		$sql = 'SELECT * FROM recurring WHERE id=?';
		
		$stmt = self::$__CONN__->prepare($sql);
		$stmt->execute(array($id));
		
		return $stmt->fetchObject('Recurring');
	}

	public static function findByPermalink($id)
	{
		$sql = 'SELECT * FROM recurring WHERE permalink=?';
		
		$stmt = self::$__CONN__->prepare($sql);
		$stmt->execute(array($id));
		
		return $stmt->fetchObject('Recurring');
	}
	
	public static function findAll($is_active = false, $returnObj = false)
	{
		$deleted = isset($_POST['status']) && $_POST['status'] == 'deleted' ? ' AND recurring.deleted = 1' : ' AND recurring.deleted = 0';
		$active = ($is_active) ? "AND recurring.is_active = 1":"";
		$sql = "SELECT recurring.*, client.company AS client FROM recurring, client WHERE client.id = recurring.client_id $deleted $active ORDER BY recurring.id DESC";
		
		$stmt = self::$__CONN__->prepare($sql);
		$stmt->execute();
		
		if($returnObj){
			$items = array();
			while (($item = $stmt->fetchObject('Recurring')) !== false)
				$items[] = $item;
			
			return $items;
		}else{
			return $stmt->fetchAll(self::FETCH_CLASS);
		}
	}
	
	
	
	public static function generatePermalink()
	{
		$characters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
		
		$id = '';
		for ($i=0; $i < 10; $i++) {
			$id .= $characters[rand(0, 61)];
		}
		
		return $id;
	}

	
} // end Recurring class
