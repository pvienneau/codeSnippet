<?php

class RecurringController extends Controller
{
	function __construct()
	{
		AuthUser::load();
		if ( ! AuthUser::isLoggedIn()) {
			redirect(get_url('login'));
		}
	}
	
	function index()
	{
		if ( ! (AuthUser::accessLevel("recurrings") > 0)) {
			// this is the best way to let the user think that there is nothing here !!
			page_not_found();
		}
		
		$this->setLayout('default');
		echo $this->render('recurring/index', array(
			'recurrings' => Recurring::findAll(),
			'items' => InvoiceItem::findAll()
		));
	}
	
	function add()
	{
		if ( ! (AuthUser::accessLevel("recurrings") > 1)) {
			// this is the best way to let the user think that there is nothing here !!
			page_not_found();
		}
		$createInvoice = isset($_POST['create_invoice']) ? true:false;
		unset($_POST['create_invoice']);
		
		list($data, $lines) = $this->_preparePost();
		
		$recurring = new Recurring($data);
				
		if ($recurring->save()) {
			$pos = 0;
			$recurring->total = 0;
			// add lines
			foreach ($lines as $data) {
				$line = new RecurringLine($data);
				$line->recurring_id = $recurring->id;
				$line->position = $pos++;
				
				$line->save();
				$recurring->total += $line->total;
			}
			
			$this->_calculate($recurring);
			$recurring->save();
			
			if($createInvoice) $recurring->createInvoice();
		}
		
		redirect(get_url('recurring/view/'.$recurring->id));
	}
	public function view($id)
	{
		if ( ! (AuthUser::accessLevel("recurrings") > 0)) {
			// this is the best way to let the user think that there is nothing here !!
			page_not_found();
		}
		$recurring = Recurring::findById($id);
		$lines = RecurringLine::of($recurring->id);
		
		//$recurring->createInvoice();
		
		$client = Client::findById($recurring->client_id);
		$invoices = RecurringHistory::ofRecurring($id);
		
		$this->setLayout('default');
		echo $this->render('recurring/view', array(
			'recurring' => $recurring,
			'lines' => $lines,
			'client' => $client,
			'recurringInvoices' => $invoices
		));
	}
	public function edit($id)
	{
		if ( ! (AuthUser::accessLevel("recurrings") > 1)) {
			// this is the best way to let the user think that there is nothing here !!
			page_not_found();
		}
		if (!empty($_POST)) {
			return $this->_edit($id);
		}
		
		$recurring = Recurring::findById($id);
		$lines = RecurringLine::of($recurring->id);
		
		$this->setLayout('default');
		echo $this->render('recurring/edit', array(
			'recurring' => $recurring,
			'lines' => $lines,
			'items' => InvoiceItem::findAll()
		));
	}
	
	public function _edit($id)
	{
		list($data, $lines) = $this->_preparePost();
		
		$recurring = Recurring::findById($id);
		$recurring->setFromData($data);
		
		$current_lines = RecurringLine::of($recurring->id);
		
		if ($recurring->save()) {
			$i = 0;
			$pos = 0;
			$recurring->total = 0;
			
			foreach ($lines as $data) {
				if (isset($current_lines[$i])) {
					$line = $current_lines[$i];
					$line->setFromData($data);
				} else {
					$line = new RecurringLine($data);
				}
				
				$line->recurring_id = $recurring->id;
				$line->position = $pos++;
				
				$line->save();
				
				$recurring->total += $line->total;
				$i++;
			}
			
			$this->_calculate($recurring);
			$recurring->save();
			
			// remove all other that have not been saved
			for ($i = $i; $i < count($current_lines); $i++) {
				$current_lines[$i]->delete();
			}
		} else {
			echo 'save does not work';
		}
		
		redirect(get_url('recurring'));
	}
	
	public function activate($id)
	{
		if ( ! (AuthUser::accessLevel("recurrings") > 1)) {
			// this is the best way to let the user think that there is nothing here !!
			page_not_found();
		}
		if ($recurring = Recurring::findById($id)) {
			$recurring->is_active = 1;
			$recurring->save();
		}
		redirect(get_url('recurring'));
	}
	
	public function desactivate($id)
	{
		if ( ! (AuthUser::accessLevel("recurrings") > 1)) {
			// this is the best way to let the user think that there is nothing here !!
			page_not_found();
		}
		if ($recurring = Recurring::findById($id)) {
			$recurring->is_active = 0;
			$recurring->save();
		}
		redirect(get_url('recurring'));
	}
	
	public function remove($id)
	{
		if ( ! (AuthUser::accessLevel("recurrings") > 1)) {
			// this is the best way to let the user think that there is nothing here !!
			page_not_found();
		}
		if ($recurring = Recurring::findById($id)) {
			$recurring->deleted = 1;
			$recurring->is_active = 0;
			$recurring->save();
		}
		redirect(get_url('recurring'));
	}
	
	private function _preparePost()
	{
		$this->_prepareDate();
		
		if ($_POST['other'] != 0)
			$_POST['due'] == $_POST['other'];
		
		$lines = $_POST['line'];
		
		if (!isset($_POST['management_status']))
			$_POST['management'] = 0;
		
		if (!isset($_POST['discount_status']))
			$_POST['discount'] = 0;
		
		if (!isset($_POST['tax_status']))
			$_POST['tax'] = 0;
		
		if (!isset($_POST['tax2_status']))
			$_POST['tax2'] = 0;
		
		if (!isset($_POST['shipping_status']))
			$_POST['shipping'] = 0;
		
		$_POST['display_country'] = isset($_POST['display_country']) ? 1: 0;
		$_POST['tax2_cumulative'] = isset($_POST['tax2_cumulative']) ? 1: 0;
		
		$_POST['send'] = isset($_POST['send']) ? 1: 0;
		$_POST['send_attach'] = isset($_POST['send_attach']) ? 1: 0;
		$_POST['send_copy'] = isset($_POST['send_copy']) ? 1: 0;
		
		unset($_POST['other'], $_POST['line'], 
			$_POST['management_status'], $_POST['discount_status'], $_POST['tax_status'], $_POST['tax2_status'], $_POST['shipping_status']);
		
		return array($_POST, $lines);
	}
	
	private function _prepareDate()
	{
		$_POST['date'] = $_POST['year'].'-'.$_POST['month'].'-'.$_POST['day'];
		unset($_POST['year'], $_POST['month'], $_POST['day']);
	}
	
	private function _calculate($recurring)
	{
		$recurring->management_fee = 0;
		if ($recurring->management) {
			$recurring->management_fee = $recurring->total * ($recurring->management/100);
			$recurring->total += $recurring->management_fee;
		}
		
		// let this here cause we need the project management included in subtotal
		$recurring->subtotal = $recurring->total;
		
		$recurring->discount_fee = 0;
		if ($recurring->discount) {
			$recurring->discount_fee = $recurring->total * ($recurring->discount/100);
			$recurring->total -= $recurring->discount_fee;
		}
		
		$recurring->tax_fee = 0;
		if ($recurring->tax) {
			$recurring->tax_fee = $recurring->total * ($recurring->tax/100);
		}
		
		if ($recurring->tax2) {
			if ($recurring->tax2_cumulative) {
				$recurring->tax2_fee = ($recurring->total + $recurring->tax_fee) * ($recurring->tax2/100);
			} else {
				$recurring->tax2_fee = $recurring->total * ($recurring->tax2/100);
			}
			$recurring->total += $recurring->tax2_fee;
		}
		$recurring->total += $recurring->tax_fee;
		
		if ($recurring->shipping) {
			$recurring->total += $recurring->shipping;
		}
	}
}