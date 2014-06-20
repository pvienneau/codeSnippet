<?php

class CodeController extends Controller
{
	public function __construct(){		
		if ( ! AuthUser::isLoggedIn()) {
			$this->setLayout('user');
		}else{
			$this->setLayout('visitor');
		}
	}
	
	public function index($id = FALSE){
		echo $this->render('code/listing', array(
			'codes' => Code::findLastNth(15)
		));
	}
	
	public function insert(){
		if(self::is_submit()){
			
		}else{
			echo $this->render('code/new');
		};
	}

} // end UserController class
