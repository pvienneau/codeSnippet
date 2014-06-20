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
			$this->_insert();
		}else{
			echo $this->render('code/new');
		};
	}
	
	public function _insert(){
		$post = $_POST;
		
		$code_data = array(
			'description' => $post['description'],
			'title' => $post['title']
		);
		
		$code = new Code($code_data);
		$code->save();
	}

} // end UserController class
