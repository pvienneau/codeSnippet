<?php

class EstimateController extends Controller
{
	public function __construct()
	{
		AuthUser::load();
		if ( ! AuthUser::isLoggedIn()) {
			redirect(get_url('login'));
		}
	}
	
	public function index()
	{
		if ( ! (AuthUser::accessLevel("estimates") > 0)) {
			// this is the best way to let the user think that there is nothing here !!
			page_not_found();
		}

		$this->setLayout('default');
		echo $this->render('estimate/index', array(
			'estimates' => Estimate::findAll(),
			'items' => InvoiceItem::findAll()
		));
	}
	
	public function view($id)
	{
		if ( ! (AuthUser::accessLevel("estimates") > 0)) {
			// this is the best way to let the user think that there is nothing here !!
			page_not_found();
		}
		$estimate = Estimate::findById($id);
		$lines = EstimateLine::of($estimate->id);
		$options = EstimateOption::of($estimate->id);
		$client = Client::findById($estimate->client_id);
		$histories = EstimateHistory::of($estimate->id);
		
		$this->setLayout('default');
		echo $this->render('estimate/view', array(
			'estimate' => $estimate,
			'lines' => $lines,
			'options' => $options,
			'client' => $client,
			'user' => User::findBy('id', $estimate->created_by),
			'histories' => $histories,
			'company' => Settings::company()
		));
	}
	
	public function add()
	{
		if ( ! (AuthUser::accessLevel("estimates") > 1)) {
			// this is the best way to let the user think that there is nothing here !!
			page_not_found();
		}
		list($data, $lines, $options) = $this->_preparePost();
		
		$estimate = new Estimate($data);
		
		if ($estimate->save()) {
			$pos = 0;
			$estimate->total = 0;
			// add lines
			foreach ($lines as $data) {
				
				$line = new EstimateLine($data);
				
				if (trim($line->description) == '')
					continue;
				
				$line->estimate_id = $estimate->id;
				$line->position = $pos++;
				
				$line->save();
				$estimate->total += $line->total;
			}
			
			$this->_calculate($estimate);
			$estimate->save();
			
			$pos = 0;
			// add options
			foreach ($options as $data) {
				$opt = new EstimateOption($data);
				
				if (trim($opt->description) == '')
					continue;
				
				$opt->estimate_id = $estimate->id;
				$opt->position = $pos++;
				
				$opt->save();
			}
		}
		
		redirect(get_url('estimate/view/'.$estimate->id));
	}

	public function edit($id)
	{
		if ( ! (AuthUser::accessLevel("estimates") > 1)) {
			// this is the best way to let the user think that there is nothing here !!
			page_not_found();
		}
		if (!empty($_POST)) {
			return $this->_edit($id);
		}
		
		$estimate = Estimate::findById($id);
		$lines = EstimateLine::of($estimate->id);
		$options = EstimateOption::of($estimate->id);
		
		$this->setLayout('default');
		echo $this->render('estimate/edit', array(
			'estimate' => $estimate,
			'lines' => $lines,
			'options' => $options,
			'items' => InvoiceItem::findAll()
		));
	}
	
	public function remove($id)
	{
		if ( ! (AuthUser::accessLevel("estimates") > 1)) {
			// this is the best way to let the user think that there is nothing here !!
			page_not_found();
		}
		if ($estimate = Estimate::findById($id)) {
			$estimate->deleted = 1;
			$estimate->save();
			Flash::set('success', 'Estimate #'.$estimate->estimate_id.' has been deleted!');
		}
		redirect(get_url('estimate'));
	}
	
	public function to_invoice($id)
	{
		$estimate = Estimate::findById($id);
		$lines = EstimateLine::of($estimate->id);
		$options = EstimateOption::of($estimate->id);
		
		$invoice = new Invoice();
		$invoice->invoice_id = Invoice::getNextNumber();
		
		$invoice->date = date('Y-m-d');
		$invoice->due_date = date('Y-m-d', strtotime('+30 days', strtotime($invoice->date)));
		$invoice->due = 30;
		
		//$invoice->permalink = $estimate->permalink;
		$invoice->currency_symbol = $estimate->currency_symbol;
		$invoice->currency_code = $estimate->currency_code;
		$invoice->notes = $estimate->notes;
		$invoice->client_id = $estimate->client_id;
		$invoice->project_name = $estimate->project_name;
		$invoice->subtotal = $estimate->subtotal;
		$invoice->tax = $estimate->tax;
		$invoice->tax2 = $estimate->tax2;
		$invoice->tax_name = $estimate->tax_name;
		$invoice->tax2_name = $estimate->tax2_name;
		$invoice->tax2_cumulative = $estimate->tax2_cumulative;
		$invoice->discount = $estimate->discount;
		$invoice->shipping = $estimate->shipping;
		$invoice->management = $estimate->management;
		$invoice->management_fee = $estimate->management_fee;
		$invoice->total = $estimate->total;
		$invoice->language = $estimate->language;
		$invoice->display_country = $estimate->display_country;
		$invoice->created_by = $estimate->created_by;
		
		if ($invoice->save()) {
			$invoice->total = 0;
			// add lines
			foreach ($lines as $qline) {
				$iline = new InvoiceLine();
				$iline->invoice_id = $invoice->id;
				$iline->description = $qline->description;
				$iline->qty = $qline->qty;
				$iline->kind = $qline->kind;
				$iline->price = $qline->price;
				$iline->total = $qline->total;
				$iline->position = $qline->position;
				
				$iline->save();
				$invoice->total += $iline->total;
			}
			
			$this->_calculate($invoice);
			$invoice->save();
			
			$estimate->status = 'invoiced';
			$estimate->invoiced = $invoice->id;
			$estimate->save();
		}
		
		redirect(get_url('invoice/view/'.$invoice->id));
	}
	
	public function download($id)
	{
		error_reporting(0);
	
		use_helper('dompdf/dompdf_config.inc');
		
		$estimate = Estimate::findById($id);
		$lines = EstimateLine::of($estimate->id);
		$options = EstimateOption::of($estimate->id);
		$client = Client::findById($estimate->client_id);
		
		I18n::setLocale($estimate->language);
		setlocale(LC_TIME, $estimate->language == 'fr' ? 'fr_CA.utf8': 'en_US.utf8');
		//setlocale(LC_ALL, $estimate->language == 'fr' ? 'fr_CA.UTF-8': 'en_US.UTF-8');
		
		$html = $this->render('estimate/pdf', array(
			'estimate' => $estimate,
			'lines' => $lines,
			'options' => $options,
			'client' => $client,
			'company' => Settings::company(),
			'user' => User::findBy('id', $estimate->created_by)
		));
		//exit;
		//$old_limit = ini_set("memory_limit", "16M");
		
		$dompdf = new DOMPDF();
		$dompdf->load_html(stripslashes(iconv("UTF-8", "ISO-8859-1//TRANSLIT", $html)));
		$dompdf->set_paper('letter', 'portrait');
		$dompdf->render();

		$dompdf->stream("{$estimate->estimate_id}.pdf");
	}
	
	public function send($id)
	{
		use_helper('Email', 'dompdf/dompdf_config.inc');
		
		$estimate = Estimate::findById($id);
		$lines = EstimateLine::of($estimate->id);
		$options = EstimateOption::of($estimate->id);
		$client = Client::findById($estimate->client_id);
		$company = Settings::company();
		
		$html = $this->render('estimate/pdf', array(
			'estimate' => $estimate,
			'lines' => $lines,
			'options' => $options,
			'client' => $client,
			'company' => $company
		));
		
		//$old_limit = ini_set("memory_limit", "16M");
		
		$dompdf = new DOMPDF();
		$dompdf->load_html(stripslashes(iconv("UTF-8", "ISO-8859-1//TRANSLIT", $html)));
		$dompdf->set_paper('letter', 'portrait');
		$dompdf->render();

		$content = $dompdf->output();
		
		file_put_contents("/tmp/{$estimate->estimate_id}.pdf", $content);
		
		//email($from, $from_name, $to, $to_name, $subject, $message, $attachments=false)
		email($company->email, $company->name, $client->email, $client->name, $_POST['subject'], $_POST['message'], "/tmp/{$estimate->estimate_id}.pdf");
		
		$estimate->status = 'sent';
		$estimate->save();
		
		$estimate->addHistory('Estimate sent.');
		
		if (isset($_POST['copy']))
			email($company->email, $company->name, $company->email, $company->name, $_POST['subject'], $_POST['message'], "/tmp/{$estimate->estimate_id}.pdf");
	}
	
	public function accepted($id)
	{
		$estimate = Estimate::findById($id);
		
		$estimate->status = 'accepted';
		$estimate->addHistory('Estimate accepted.');
	
		$estimate->save();
		
		// create task with all lines
		//$lines = EstimateLine::of($estimate->id);
		
		/*foreach ($lines as $line) {
			if ($line->kind == 'hour') {
				$task = new Task();
				$task->project_id = $estimate->project_id;
				$task->description = $line->description;
				$task->budgeted = $line->qty;
				$task->position = $line->position;
				$task->save();
			}
		}*/
		
		redirect(get_url('estimate/view/'.$estimate->id));
	}

	public function refused($id)
	{
		$estimate = Estimate::findById($id);
		
		$estimate->status = 'refused';
		$estimate->addHistory('Estimate refused.');
	
		$estimate->save();
		redirect(get_url('estimate/view/'.$estimate->id));
	}
	
	public function _edit($id)
	{
		list($data, $lines, $options) = $this->_preparePost();
		
		$estimate = Estimate::findById($id);
		$estimate->setFromData($data);
		
		$current_lines = EstimateLine::of($estimate->id);
		$current_options = EstimateOption::of($estimate->id);
		
		if ($estimate->save()) {
			$pos = 0;
			$estimate->total = 0;
			// save lines
			foreach ($lines as $data) {	
				if (isset($current_lines[$pos])) {
					$line = $current_lines[$pos];
					$line->setFromData($data);
				} else {
					$line = new EstimateLine($data);
				}
				
				if (trim($line->description) == '')
					continue;
				
				$line->estimate_id = $estimate->id;
				$line->position = $pos++;
				
				$line->save();
				
				$estimate->total += $line->total;
			}
			
			$this->_calculate($estimate);
			$estimate->save();
			
			// remove all other lines that have not been saved
			for ($pos = $pos; $pos < count($current_lines); $pos++) {
				$current_lines[$pos]->delete();
			}
			
			$pos = 0;
			// save options
			foreach ($options as $data) {
				if (isset($current_options[$pos])) {
					$option = $current_options[$pos];
					$option->setFromData($data);
				} else {
					$option = new EstimateOption($data);
				}
				
				if (trim($option->description) == '')
					continue;
				
				$option->estimate_id = $estimate->id;
				$option->position = $pos++;
				
				$option->save();
			}
			
			// remove all other options that have not been saved
			for ($pos = $pos; $pos < count($current_options); $pos++) {
				$current_options[$pos]->delete();
			}
		}
		
		redirect(get_url('estimate/view/'.$estimate->id));
	}
	
	private function _preparePost()
	{
		$this->_prepareDate();
		
		if (!empty($_POST['other']))
			$_POST['due'] == $_POST['other'];
		
		$lines = $_POST['line'];
		$options = isset($_POST['option']) ? $_POST['option']: array();
		
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
		
		unset($_POST['other'], $_POST['line'], $_POST['option']);
		
		// remove status
		unset($_POST['management_status'], $_POST['discount_status'], $_POST['tax_status'], $_POST['tax2_status'], $_POST['shipping_status']);
		
		return array($_POST, $lines, $options);
	}
	
	private function _prepareDate()
	{
		$_POST['date'] = $_POST['year'].'-'.$_POST['month'].'-'.$_POST['day'];
		unset($_POST['year'], $_POST['month'], $_POST['day']);
	}
	
	private function _calculate($estimate)
	{
		$estimate->management_fee = 0;
		if ($estimate->management) {
			$estimate->management_fee = $estimate->total * ($estimate->management/100);
			$estimate->total += $estimate->management_fee;
		}
		
		// let this here cause we need the project management included in subtotal
		$estimate->subtotal = $estimate->total;
		
		$estimate->discount_fee = 0;
		if ($estimate->discount) {
			$estimate->discount_fee = $estimate->total * ($estimate->discount/100);
			$estimate->total -= $estimate->discount_fee;
		}
		
		$estimate->tax_fee = 0;
		if ($estimate->tax) {
			$estimate->tax_fee = $estimate->total * ($estimate->tax/100);
		}
		
		if ($estimate->tax2) {
			if ($estimate->tax2_cumulative) {
				$estimate->tax2_fee = ($estimate->total + $estimate->tax_fee) * ($estimate->tax2/100);
			} else {
				$estimate->tax2_fee = $estimate->total * ($estimate->tax2/100);
			}
			$estimate->total += $estimate->tax2_fee;
		}
		$estimate->total += $estimate->tax_fee;
		
		if ($estimate->shipping) {
			$estimate->total += $estimate->shipping;
		}
	}

	// estimate options method
	
	public function accept_option($id)
	{
		$option = EstimateOption::findById($id);
		$option->accepted = 1;
		$option->save();
	}
	
	public function refuse_option($id)
	{
		$option = EstimateOption::findById($id);
		$option->accepted = 0;
		$option->save();
	}
	
}