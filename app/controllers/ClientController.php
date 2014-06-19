<?php

class ClientController extends Controller
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
		if ( ! (AuthUser::accessLevel("clients") > 0)) {
			// this is the best way to let the user think that there is nothing here !!
			page_not_found();
		}
		
		echo $this->render('client/index', array(
			'clients' => Client::findAll(),
			'company' => Settings::company()
		));
	}
	
	function show($id)
	{
		if ( ! (AuthUser::accessLevel("clients") > 0)) {
			// this is the best way to let the user think that there is nothing here !!
			page_not_found();
		}
		echo $this->render('client/show', array(
			'client' => Client::findById($id),
			'projects' => Project::findByClient($id),
			'contacts' => Contact::findByClient($id)
		));
	}
	
	function add()
	{
		if ( ! (AuthUser::accessLevel("clients") > 1)) {
			// this is the best way to let the user think that there is nothing here !!
			page_not_found();
		}
		if (!empty($_POST)) {
			return $this->_add();
		}
		
		echo $this->render('client/edit', array('client' => new Client));
	}
	
	function _add()
	{
		$this->_preparePost();
		
		$client = new Client($_POST);
		$client->save();
		
		echo 'done!';
		//redirect(get_url('client'));
	}
	
	function edit($id)
	{
		if ( ! (AuthUser::accessLevel("clients") > 1)) {
			// this is the best way to let the user think that there is nothing here !!
			page_not_found();
		}
		if (!empty($_POST)) {
			return $this->_edit($id);
		}
		
		echo $this->render('client/edit', array(
			'client' => Client::findById($id),
			'company' => Settings::company()
		));
	}
	
	function _edit($id)
	{
		if (!$client = Client::findById($id)) {
			Flash::set('error', 'Client not found!');
			redirect(get_url('client'));
		}
		
		$this->_preparePost();
		
		if (Record::update('Client', $_POST, 'id=?', array($id))) {
			Flash::set('success', 'Client <strong>'.$client->name.'</strong> has been updated with success!');
		} else {
			Flash::set('error', 'Client <strong>'.$client->name.'</strong> has NOT been updated!');
		}
		redirect(get_url('client'));
	}
	
	function remove($id)
	{
		if ( ! (AuthUser::accessLevel("clients") > 1)) {
			// this is the best way to let the user think that there is nothing here !!
			page_not_found();
		}
	}
	
	function _preparePost()
	{
		if (!isset($_POST['tax_status']))
			$_POST['tax'] = 0;
		
		if (!isset($_POST['tax2_status']))
			$_POST['tax2'] = 0;
		
		$_POST['tax2_cumulative'] = isset($_POST['tax2_cumulative']) ? 1: 0;
			
		// remove status
		unset($_POST['tax_status'], $_POST['tax2_status']);
	}
}