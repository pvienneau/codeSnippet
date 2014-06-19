<?php

class PublicController extends Controller
{
	//function __construct() {}
	
	function invoice($permalink)
	{
		if (!$invoice = Invoice::findByPermalink($permalink))
			page_not_found();
		
		$lines = InvoiceLine::of($invoice->id);
		$client = Client::findById($invoice->client_id);
		
		I18n::setLocale($invoice->language);
		setlocale(LC_TIME, $invoice->language == 'fr' ? 'fr_CA.utf8': 'en_US.utf8');
		//setlocale(LC_ALL, $invoice->language == 'fr' ? 'fr_CA.UTF-8': 'en_US.UTF-8');
		
		echo $this->render('public/invoice', array(
			'company' => Settings::company(),
			'invoice' => $invoice,
			'lines' => $lines,
			'client' => $client
		));
	}
	
	function estimate($permalink)
	{
		if (!$estimate = Estimate::findByPermalink($permalink))
			page_not_found();
		
		$lines = EstimateLine::of($estimate->id);
		$options = EstimateOption::of($estimate->id);
		$client = Client::findById($estimate->client_id);
		
		I18n::setLocale($estimate->language);
		setlocale(LC_TIME, $estimate->language == 'fr' ? 'fr_CA.utf8': 'en_US.utf8');
		//setlocale(LC_ALL, $estimate->language == 'fr' ? 'fr_CA.UTF-8': 'en_US.UTF-8');
		
		echo $this->render('public/estimate', array(
			'company' => Settings::company(),
			'estimate' => $estimate,
			'lines' => $lines,
			'options' => $options,
			'client' => $client,
			'user' => User::findBy('id', $estimate->created_by)
		));
	}
	
	public function download($permalink)
	{
		if (!$invoice = Invoice::findByPermalink($permalink))
			page_not_found();
			
		use_helper('dompdf/dompdf_config.inc');
		
		$lines = InvoiceLine::of($invoice->id);
		$client = Client::findById($invoice->client_id);
		
		I18n::setLocale($invoice->language);
		setlocale(LC_ALL, $invoice->language == 'fr' ? 'fr_CA.UTF-8': 'en_US.UTF-8');
		
		$html = $this->render('invoice/pdf', array(
			'invoice' => $invoice,
			'lines' => $lines,
			'client' => $client,
			'company' => Settings::company()
		));
		//exit;
		//$old_limit = ini_set("memory_limit", "16M");
		
		$dompdf = new DOMPDF();
		$dompdf->load_html(stripslashes(iconv("UTF-8", "ISO-8859-1//TRANSLIT", $html)));
		$dompdf->set_paper('letter', 'portrait');
		$dompdf->render();

		$dompdf->stream("{$invoice->invoice_id}.pdf");
	}
	
	public function download_estimate($permalink)
	{
		if (!$estimate = Estimate::findByPermalink($permalink))
			page_not_found();
			
		use_helper('dompdf/dompdf_config.inc');
		
		$lines = EstimateLine::of($estimate->id);
		$options = EstimateOption::of($estimate->id);
		$client = Client::findById($estimate->client_id);
		
		I18n::setLocale($estimate->language);
		setlocale(LC_ALL, $estimate->language == 'fr' ? 'fr_CA.UTF-8': 'en_US.UTF-8');
		
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
}