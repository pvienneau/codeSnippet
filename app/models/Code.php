<?php

class Code extends Record
{
	const TABLE_NAME = 'code';
	
	public	$code_id = false,
			$description = false,
			$title = false,
			$deleted = 0,
			$date_created = false;
			
	// public function __construct(){
	// 		parent::__construct();
	// 		
	// 		$this->date_created = mysql_now();
	// 	}
		
	public function beforeInsert(){
		if(!self::_validate_data()) return FALSE;
		
		$this->date_created = mysql_now();
		
		return TRUE;
	}
			
	private function _validate_data(){
		if(
			empty($this->description) ||
			empty($this->title)
		) return false;
		
		return true;
	}
	
} // end Code class
