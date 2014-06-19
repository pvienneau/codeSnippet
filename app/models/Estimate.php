<?php

class Estimate extends Record
{
	const TABLE_NAME = 'estimate';
	
	public	$id = false,
			$status = 'draft',
			$date = '',
			$estimate_id = '',
			$po = '',
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
			$language = 'fr',
			$display_country = 0,
			$created_by = 0,
			$deleted = 0;
	//public $rate = DEFAULT_RATE;
	
	public function beforeInsert()
	{
		$this->created_by = AuthUser::getId();
		$this->date = date('Y-m-d H:i:s');
		
		$permalink = self::generatePermalink();
		while (self::findByPermalink($permalink)) {
			$permalink = self::generatePermalink();
		}
		
		$this->permalink = $permalink;
		return true;
	}
	
	public function afterInsert()
	{
		$this->addHistory('Estimate created.');
		return true;
	}
	
	public function addHistory($event, $date=false)
	{
		
		$history = new EstimateHistory(array(
			'estimate_id' => $this->id,
			'event' => $event
		));
		
		if ($date)
			$history->date = $date;
		
		$history->save();
	}
	
	public static function findById($id)
	{
		$sql = 'SELECT * FROM estimate WHERE id=?';
		
		$stmt = self::$__CONN__->prepare($sql);
		$stmt->execute(array($id));
		
		return $stmt->fetchObject('Estimate');
	}

	public static function findByPermalink($id)
	{
		$sql = 'SELECT * FROM estimate WHERE permalink=?';
		
		$stmt = self::$__CONN__->prepare($sql);
		$stmt->execute(array($id));
		
		return $stmt->fetchObject('Estimate');
	}
	
	public static function findAll()
	{
		$period = '';
		if (isset($_POST['period'])) {
			switch ($_POST['period']) {
				case 'today':
					$period = " AND date_format(estimate.date, '%Y-%m-%d') = '".date('Y-m-d')."'"; break;
				case 'yesterday':
					$period = " AND date_format(estimate.date, '%Y-%m-%d') = '".date('Y-m-d', strtotime('-1 day'))."'"; break;
				case 'this_month':
					$period = " AND date_format(estimate.date, '%Y-%m') = '".date('Y-m')."'"; break;
				case 'last_month':
					$period = " AND date_format(estimate.date, '%Y-%m') = '".date('Y-m', strtotime('-1 month'))."'"; break;
				case 'this_year':
					$period = " AND date_format(estimate.date, '%Y') = '".date('Y')."'"; break;
				case 'last_year':
					$period = " AND date_format(estimate.date, '%Y') = '".(date('Y')-1)."'"; break;
			}
		}
		$client = isset($_POST['client']) && $_POST['client'] != 'all' ? " AND client.id = {$_POST['client']}": '';
		$status = isset($_POST['status']) && $_POST['status'] != 'all' ? " AND estimate.status = '{$_POST['status']}'": '';
		$invoiced = isset($_POST['status']) && $_POST['status'] == 'invoiced' ? '' : ' AND invoiced = 0';
		$deleted = isset($_POST['status']) && $_POST['status'] == 'deleted' ? ' AND estimate.deleted = 1' : ' AND estimate.deleted = 0';
		
		$sql = "SELECT estimate.*, client.company AS client FROM estimate, client WHERE client.id = client_id $period $client $status $invoiced $deleted ORDER BY estimate_id DESC";
		
		$stmt = self::$__CONN__->prepare($sql);
		$stmt->execute();
		
		return $stmt->fetchAll(self::FETCH_OBJ);
	}
	
	public static function getNextNumber()
	{
		$sql = 'SELECT estimate_id FROM estimate ORDER BY estimate_id DESC LIMIT 0,1';
		
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

	
} // end Estimate class
