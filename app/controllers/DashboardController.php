<?php

class DashboardController extends Controller
{
	public function __construct(){		
		if ( ! AuthUser::isLoggedIn()) {
			redirect(get_url('login'));
		}
		
		$this->setLayout('user');
	}
	
	public function index(){
		echo 'welcome';
	}

} // end UserController class
