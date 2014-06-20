<?php

class CodeController extends Controller
{
	public function __construct(){
		parent::__construct();
		
		if (AuthUser::isLoggedIn()) {
			$this->setLayout('user');
		}else{
			$this->setLayout('visitor');
		}
	}
	
	public function index($code_id = FALSE, $revision = FALSE){
		if($code_id === FALSE){
			echo $this->render('code/listing', array(
				'codes' => Code::findLastNth(15)
			));
		}else{
			echo $this->render('code/view', array(
				'code' => Code::findById($code_id),
				'revision' => CodeRevision::findClosestRevision($code_id, $revision)
			));
		}
	}
	
	public function insert(){
		if(self::is_submit()){
			return $this->_insert();
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
