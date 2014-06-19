<?php

class UserController extends Controller
{
	public function __construct(){	
		parent::__construct();
		
		if (!AuthUser::isLoggedIn()) {
			redirect(get_url('login'));
		}
		
		$this->setLayout('user');
	}
	
	function listing(){
		echo $this->render('user/listing', array(
			'users' => User::findAll()
		));
	}
	
	function view($id = FALSE){
		echo 'view';
		
		echo $this->render('user/view', array(
			'user' => (is_numeric($id))?User::findById($id):User::findByUsername($id)
		));
	}
	
	function profile(){
		$this->view(AuthUser::getId());
	}

} // end UserController class
