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
			$code = Code::findById($code_id);
			
			if(empty($code)){
				redirect(get_url('code'));
			}
			
			echo $this->render('code/view', array(
				'code' => $code,
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

		$code_revision_data = array(
			'user_id' => AuthUser::getId(),
			'code_id' => $code->code_id,
			'rev' => 1,
			'content' => $post['content'],
			'description' => 'initial commit.'
		);
		
		$code_revision = new CodeRevision($code_revision_data);
		$code_revision->save();
		
		redirect(get_url('code/'.$code->code_id));
	}
	
	public function search($query = FALSE){
		if($query === FALSE) return $this->index();
		
		echo $this->render('code/listing', array(
			'codes' => Code::search($query)
		));
	}

} // end UserController class
