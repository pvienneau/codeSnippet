<?php

class SettingsController extends Controller
{
	function __construct()
	{
		AuthUser::load();
		if ( ! AuthUser::isLoggedIn()) {
			redirect(get_url('login'));
		}
		$this->setLayout('default');
	}
	
	function index()
	{
		echo $this->render('settings/index', array(
			'company' => Settings::company()
		));
	}
	
	function company()
	{
		ClientController::_preparePost();
			
		$company = Client::findById(1);
		$company->setFromData($_POST);
		$company->company = $company->name;
		$company->save();
	}
	
	function _edit($id)
	{
		if (!$item = InvoiceItem::findById($id)) {
			Flash::set('error', 'Invoice item not found!');
			redirect(get_url('item'));
		}
		
		$data = $_POST;
		$item->setFromData($data);
		
		if ($item->save()) {
			Flash::set('success', 'Invoice item <strong>'.$item->description.'</strong> has been updated with success!');
		} else {
			Flash::set('error', 'Invoice item <strong>'.$item->description.'</strong> has NOT been updated!');
		}
		redirect(get_url('item'));
	}

}