<?php

//use_helper('Number');

class InvoiceController extends Controller
{
	public function __construct()
	{
		AuthUser::load();
		if ( !AuthUser::isLoggedIn()) {
			redirect(get_url('login'));
		}
	}
	
	public function index()
	{
		
		if ( !(AuthUser::accessLevel("invoices")) > 0) {
			// this is the best way to let the user think that there is nothing here !!
			page_not_found();
		}
		
		$this->setLayout('default');
		echo $this->render('invoice/index', array(
			'invoices' => Invoice::findAll(),
			'items' => InvoiceItem::findAll()
		));
	}
	
	public function view($id)
	{
		if ( !(AuthUser::accessLevel("invoices")) > 0) {
			// this is the best way to let the user think that there is nothing here !!
			page_not_found();
		}
		$invoice = Invoice::findById($id);
		$lines = InvoiceLine::of($invoice->id);
		$client = Client::findById($invoice->client_id);
		$histories = InvoiceHistory::of($invoice->id);
		
		$this->setLayout('default');
		echo $this->render('invoice/view', array(
			'invoice' => $invoice,
			'lines' => $lines,
			'client' => $client,
			'histories' => $histories,
			'company' => Settings::company()
		));
	}
	
	public function add()
	{
		if ( !(AuthUser::accessLevel("invoices")) > 1) {
			// this is the best way to let the user think that there is nothing here !!
			page_not_found();
		}

		list($data, $lines) = $this->_preparePost();
		
		$invoice = new Invoice($data);
		
		$invoice->due_date = date('Y-m-d', strtotime('+'.$invoice->due.' days', strtotime($invoice->date)));
		
		if ($invoice->save()) {
			$pos = 0;
			$invoice->total = 0;
			// add lines
			foreach ($lines as $data) {
				$line = new InvoiceLine($data);
				$line->invoice_id = $invoice->id;
				$line->position = $pos++;
				
				$line->save();
				$invoice->total += $line->total;
			}
			
			$this->_calculate($invoice);
			$invoice->save();
		}
		
		redirect(get_url('invoice/view/'.$invoice->id));
	}

	public function edit($id)
	{
		
		if ( !(AuthUser::accessLevel("invoices") > 1)) {
			// this is the best way to let the user think that there is nothing here !!
			page_not_found();
		}
		if (!empty($_POST)) {
			return $this->_edit($id);
		}
		
		$invoice = Invoice::findById($id);
		$lines = InvoiceLine::of($invoice->id);
		
		$this->setLayout('default');
		echo $this->render('invoice/edit', array(
			'invoice' => $invoice,
			'lines' => $lines,
			'items' => InvoiceItem::findAll()
		));
	}

	public function download($id)
	{
		error_reporting(0);
		
		AutoLoader::addFunction('DOMPDF_autoload');
		
		use_helper('dompdf/dompdf_config.inc');
		
		$invoice = Invoice::findById($id);
		$lines = InvoiceLine::of($invoice->id);
		$client = Client::findById($invoice->client_id);
		
		I18n::setLocale($invoice->language);
		setlocale(LC_TIME, $invoice->language == 'fr' ? 'fr_CA.utf8': 'en_US.utf8');
		//setlocale(LC_ALL, $invoice->language == 'fr' ? 'fr_CA.UTF-8': 'en_US.UTF-8');
		
		$html = $this->render('invoice/pdf', array(
			'invoice' => $invoice,
			'lines' => $lines,
			'client' => $client,
			'company' => Settings::company()
		));
		
		//$old_limit = ini_set("memory_limit", "16M");
		
		$dompdf = new DOMPDF();
		$dompdf->load_html(stripslashes(iconv("UTF-8", "ISO-8859-1//TRANSLIT", $html)));
		$dompdf->set_paper('letter', 'portrait');
		$dompdf->render();

		$dompdf->stream("{$invoice->invoice_id}.pdf");
	}
	
	public function send($id)
	{
		use_helper('Email', 'dompdf/dompdf_config.inc');
		
		$invoice = Invoice::findById($id);
		$lines = InvoiceLine::of($invoice->id);
		$client = Client::findById($invoice->client_id);
		$company = Settings::company();
		
		I18n::setLocale($invoice->language);
		setlocale(LC_TIME, $invoice->language == 'fr' ? 'fr_CA.utf8': 'en_US.utf8');
		//setlocale(LC_ALL, $invoice->language == 'fr' ? 'fr_CA.UTF-8': 'en_US.UTF-8');
		
		$html = $this->render('invoice/pdf', array(
			'invoice' => $invoice,
			'lines' => $lines,
			'client' => $client,
			'company' => $company
		));
		
		//$old_limit = ini_set("memory_limit", "16M");
		
		$dompdf = new DOMPDF();
		$dompdf->load_html(stripslashes(iconv("UTF-8", "ISO-8859-1//TRANSLIT", $html)));
		$dompdf->set_paper('letter', 'portrait');
		$dompdf->render();

		$content = $dompdf->output();
		
		file_put_contents("/tmp/{$invoice->invoice_id}.pdf", $content);
		
		//email($from, $from_name, $to, $to_name, $subject, $message, $attachments=false)
		email($company->email, $company->name, $client->email, $client->name, $_POST['subject'], $_POST['message'], "/tmp/{$invoice->invoice_id}.pdf");
		
		$invoice->status = 'sent';
		$invoice->save();
		
		$invoice->addHistory('Invoice sent.');
		
		if (isset($_POST['copy']))
			email($company->email, $company->name, $company->email, $company->name, $_POST['subject'], $_POST['message'], "/tmp/{$invoice->invoice_id}.pdf");
	}
	
	public function payment($id)
	{
		$invoice = Invoice::findById($id);
		
		$this->_prepareDate();
		$date = $_POST['date'];
		$amount = str_replace(' ', '', $_POST['amount']);
		$description = $_POST['description'];
		
		$invoice->paid += number_format($amount,2,'.','');
		
		$invoice->addHistory('Payment of '.number_format($amount,2,'.',' ').' received.', $date, $description);
		
		if ($invoice->paid == $invoice->total) {
			$invoice->status = 'paid';
			$invoice->addHistory('Invoice paid.', $date);
		}
		
		$invoice->save();
	}
	
	public function remove_payment($history_id)
	{
		if ($history = InvoiceHistory::findById($history_id)) {
			if (strpos($history->event, 'Payment') === false)
				return;
			
			$amount = preg_replace('/^Payment of ([0-9\. ]*) received.$/', "$1", $history->event);
			$amount = str_replace(' ', '', $amount);
			
			$invoice = Invoice::findById($history->invoice_id);
			
			$invoice->paid -= number_format($amount, 2, '.', '');
			$invoice->save();
			
			$history->delete();
		}
	}
	
	public function insert_item($id, $index)
	{
		$item = InvoiceItem::findById($id);
		echo $this->render('item/line', array(
			'index' => $index,
			'line' => $item
		));
	}
	
	public function remove($id)
	{
		if ( ! (AuthUser::accessLevel("invoices") > 1)) {
			// this is the best way to let the user think that there is nothing here !!
			page_not_found();
		}
		if ($invoice = Invoice::findById($id)) {
			$invoice->deleted = 1;
			$invoice->save();
			Flash::set('success', 'Invoice #'.$invoice->invoice_id.' has been deleted!');
		}
		redirect(get_url('invoice'));
	}
	
	public function _edit($id)
	{
		list($data, $lines) = $this->_preparePost();
		
		$invoice = Invoice::findById($id);
		$invoice->setFromData($data);
		
		$invoice->due_date = date('Y-m-d', strtotime('+'.$invoice->due.' days', strtotime($invoice->date)));
		
		$current_lines = InvoiceLine::of($invoice->id);
		
		if ($invoice->save()) {
			$i = 0;
			$pos = 0;
			$invoice->total = 0;
			
			foreach ($lines as $data) {
				if (isset($current_lines[$i])) {
					$line = $current_lines[$i];
					$line->setFromData($data);
				} else {
					$line = new InvoiceLine($data);
				}
				
				$line->invoice_id = $invoice->id;
				$line->position = $pos++;
				
				$line->save();
				
				$invoice->total += $line->total;
				$i++;
			}
			
			$this->_calculate($invoice);
			$invoice->save();
			
			// remove all other that have not been saved
			for ($i = $i; $i < count($current_lines); $i++) {
				$current_lines[$i]->delete();
			}
		} else {
			echo 'save does not work';
		}
		
		redirect(get_url('invoice/view/'.$invoice->id));
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
			
		unset($_POST['other'], $_POST['line']);
		
		// remove status
		unset($_POST['management_status'], $_POST['discount_status'], $_POST['tax_status'], $_POST['tax2_status'], $_POST['shipping_status']);
		
		return array($_POST, $lines);
	}
	
	private function _prepareDate()
	{
		$_POST['date'] = $_POST['year'].'-'.$_POST['month'].'-'.$_POST['day'];
		unset($_POST['year'], $_POST['month'], $_POST['day']);
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
	
	/*public function test()
	{
		use_helper('PdfInvoice');
		
		$invoice = new PdfInvoice(CORE_ROOT.'/invoices/templates/invoice-tmpl-fr.pdf');
		$invoice->setNumber(date('y-mdHi'));
		$invoice->setClient('Société des Arts Technologiques');
		$invoice->setClientAddress("1195 boulevard Saint-Laurent\nC.P. 1083 Succursale Desjardins\nMontréal (Québec) H5B 1C2 Canada");
		$invoice->addRow('Modification du calcul Paypal pour le Cart', 'Description du test 1 et quelques modification effectué sur une tonne de truc', 2.5, 25);
		$invoice->addRow('Nouvelle interface capsule et nouveau système de bannière', '', 37.25, 25);
		$invoice->addRow('Nouvelle interface capsule', 'it is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using \'Content here, content here\', making it look like readable English. Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text, and a search for \'lorem ipsum\' will uncover many', 5, 25);
		$invoice->display();
	}
	
	public function generate($project_id)
	{
		use_helper('PdfInvoice');
		
		$project = Project::findById($project_id);
		$client = Client::findById($project->client_id);
		$tasks = Task::findBillableForProject($project_id);
		
		$due = 0;
		// count the amount due for this invoice
		foreach ($tasks as $task) $due += ($task->duration * $project->rate);
		
		$invoice = new Invoice;
		$invoice->project_id = $project_id;
		$invoice->due = $due;
		$invoice->save();
		
		$pdf = new PdfInvoice(CORE_ROOT.'/invoices/templates/invoice-tmpl-'.$client->language.'.pdf');
		
		if ($client->language == 'fr')
		{
			$pdf->setInvoiceLabel('Facture');
			$pdf->setProjectLabel('Projet');
			$pdf->setColumnsLabel('Service(s)', 'Heure(s)', 'Total');
		}
		
		$pdf->setNumber(Invoice::formatNumber($invoice->id));
		$pdf->setClient($client->name);
		$pdf->setClientAddress($client->address);
		
		$pdf->setProject($project->name);
		
		foreach ($tasks as $task) {
			// assign this invoice id to the task
			$task->invoice_id = $invoice->id;
			$task->save();
			// add a new row to the pdf of the invoice
			$pdf->addRow($task->name, $task->description, $task->duration, $project->rate);
		}
		
		$pdf->save();
		redirect(get_url('invoice'));
	}
	
	public function regenerate($invoice_id)
	{
		use_helper('PdfInvoice');
		
		$invoice = Invoice::findById($invoice_id);
		
		$tasks = Task::findByInvoice($invoice->id);

		$project = Project::findById($invoice->project_id);
		$client = Client::findById($project->client_id);
		
		$due = 0;
		// count the amount due for this invoice
		foreach ($tasks as $task)
			$due += ($task->duration * $project->rate);
		
		$invoice->due = $due;
		$invoice->save();
		//if ($invoice->save()) {
		//	  Flash::set('success', 'Invoice '.$invoice->id.' has been regenerated with success!');
		//} else {
		//	  Flash::set('error', 'Invoice '.$invoice->id.' has NOT been regenerated with success! '.print_r(Record::getQueryLog(), true));
		//}
		
		$pdf = new PdfInvoice(CORE_ROOT.'/invoices/templates/invoice-tmpl-'.$client->language.'.pdf');
		
		if ($client->language == 'fr')
		{
			$pdf->setInvoiceLabel('Facture');
			$pdf->setProjectLabel('Projet');
			$pdf->setColumnsLabel('Service(s)', 'Heure(s)', 'Total');
		}
		
		$pdf->setNumber(Invoice::formatNumber($invoice->id));
		$pdf->setClient($client->name);
		$pdf->setClientAddress($client->address);
		
		$pdf->setProject($project->name);
		
		foreach ($tasks as $task) {
			// add a new row to the pdf of the invoice
			$pdf->addRow($task->name, $task->description, $task->duration, $project->rate);
		}
		
		$pdf->save();
		redirect(get_url('invoice'));
	}
	
	function edit($id)
	{
		if (get_request_method() == 'POST') {
			return $this->_edit($id);
		}
		
		$this->setLayout('default');
		echo $this->render('invoice/edit', array(
			'invoice' => Invoice::findById($id),
			'projects' => Project::findAll()
		));
	}
	
	function _edit($id)
	{
		use_helper('Number');
		
		if ( ! $invoice = Invoice::findById($id)) {
			Flash::set('error', 'Invoice not found!');
			redirect(get_url('invoice'));
		}
		
		if (Record::update('Invoice', $_POST['invoice'], 'id=?', array($id))) {
			Flash::set('success', 'Invoice <strong>'.$invoice->name.'</strong> has been updated with success!');
		} else {
			Flash::set('error', 'Invoice <strong>'.$invoice->name.'</strong> has NOT been updated!');
		}
		redirect(get_url('invoice'));
	}
	*/
	
}