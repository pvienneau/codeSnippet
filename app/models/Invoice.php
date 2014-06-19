<?php

class Invoice extends Record
{
	const TABLE_NAME = 'invoice';
	
	public	$id = false,
			$status = 'draft', // draft, sent, paid, due, broke (fauché)
			$date = '',
			$due_date = '',
			$invoice_id = '',
			$po = '',
			$due = 30,
			$currency_symbol = '',
			$notes = '',
			$client_id = 0,
			$project_name = '',
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
			$paid = 0,
			$balance_due = 0,
			$language = 'fr',
			$display_country = 0,
			$created_by = 0,
			$deleted = 0;
	//public $rate = DEFAULT_RATE;
	
	public function beforeInsert()
	{
		$this->created_by = AuthUser::getId();
		$this->date = date('Y-m-d H:i:s');
		
		$permalink = Invoice::generatePermalink();
		while (Invoice::findByPermalink($permalink)) {
			$permalink = Invoice::generatePermalink();
		}
		
		$this->permalink = $permalink;
		return true;
	}
	
	public function beforeSave()
	{
		$this->balance_due = number_format($this->total - $this->paid, 2, '.', '');
		return true;
	}
	
	
	public function afterInsert()
	{
		$this->addHistory('Invoice created.');
		return true;
	}
	
	public function addHistory($event, $date=false, $description='')
	{
		
		$history = new InvoiceHistory(array(
			'invoice_id' => $this->id,
			'event' => $event
		));
		
		if ($date)
			$history->date = $date;
		if($description != '')
			$history->description = $description;
		
		$history->save();
	}
	
	public static function findById($id)
	{
		$sql = 'SELECT * FROM invoice WHERE id=?';
		
		$stmt = self::$__CONN__->prepare($sql);
		$stmt->execute(array($id));
		
		return $stmt->fetchObject('Invoice');
	}

	public static function findByPermalink($id)
	{
		$sql = 'SELECT * FROM invoice WHERE permalink=?';
		
		$stmt = self::$__CONN__->prepare($sql);
		$stmt->execute(array($id));
		
		return $stmt->fetchObject('Invoice');
	}
	
	public static function findAll()
	{
		$period = '';
		if (isset($_POST['period'])) {
			switch ($_POST['period']) {
				case 'today':
					$period = " AND date_format(invoice.date, '%Y-%m-%d') = '".date('Y-m-d')."'"; break;
				case 'yesterday':
					$period = " AND date_format(invoice.date, '%Y-%m-%d') = '".date('Y-m-d', strtotime('-1 day'))."'"; break;
				case 'this_month':
					$period = " AND date_format(invoice.date, '%Y-%m') = '".date('Y-m')."'"; break;
				case 'last_month':
					$period = " AND date_format(invoice.date, '%Y-%m') = '".date('Y-m', strtotime('-1 month'))."'"; break;
				case 'this_year':
					$period = " AND date_format(invoice.date, '%Y') = '".date('Y')."'"; break;
				case 'last_year':
					$period = " AND date_format(invoice.date, '%Y') = '".(date('Y')-1)."'"; break;
			}
		}
		$client = isset($_POST['client']) && $_POST['client'] != 'all' ? " AND invoice.client_id = {$_POST['client']}": '';
		$status = isset($_POST['status']) && $_POST['status'] != 'all' ? " AND invoice.status = '{$_POST['status']}'": '';
		$deleted = isset($_POST['status']) && $_POST['status'] == 'deleted' ? ' AND invoice.deleted = 1' : ' AND invoice.deleted = 0';
		
		$sql = "SELECT invoice.*, client.company AS client FROM invoice, client WHERE client.id = invoice.client_id $period $client $status $deleted ORDER BY invoice_id DESC";
		
		$stmt = self::$__CONN__->prepare($sql);
		$stmt->execute();
		
		return $stmt->fetchAll(self::FETCH_OBJ);
	}
	
	public static function getNextNumber()
	{
		$sql = 'SELECT invoice_id FROM invoice ORDER BY invoice_id DESC LIMIT 0,1';
		
		$stmt = self::$__CONN__->prepare($sql);
		$stmt->execute();
		
		$no = (int) $stmt->fetchColumn();
		
		return sprintf('%07d', ++$no);
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

	public static function checkDue()
	{
		$sql ="UPDATE invoice SET status='due' WHERE (status='sent' OR status='draft') AND due_date < NOW()";

				
		$stmt = self::$__CONN__->prepare($sql);
		return $stmt->execute();
		
		
	}
} // end Invoice class
