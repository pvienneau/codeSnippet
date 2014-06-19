<?php

class ItemController extends Controller
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
		echo $this->render('item/index', array('items' => InvoiceItem::findAll()));
	}
	
	function add()
	{
		if (!empty($_POST)) {
			return $this->_add();
		}
		
		echo $this->render('item/edit', array('item' => new InvoiceItem));
	}
	
	function _add()
	{
		$data = $_POST;
		$item = new InvoiceItem;
		$item->setFromData($data);
		$item->save();
		
		echo 'done!';
		//redirect(get_url('client'));
	}
	
	function edit($id)
	{
		if (!empty($_POST)) {
			return $this->_edit($id);
		}
		
		echo $this->render('item/edit', array('item' => InvoiceItem::findById($id)));
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
	
	function delete($id)
	{
		
	}
}