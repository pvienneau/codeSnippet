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
	
	public function search($query = false){
		if($query === FALSE) return self::findAll();
		
		$sql = "SELECT * FROM code AS c INNER JOIN (SELECT MAX(cr.rev) AS rev, cr.code_id, cr.content, cr.code_revision_id FROM code_revision AS cr) cr ON c.code_id = cr.code_id WHERE c.title LIKE %?% OR c.description LIKE %?%, cr.content LIKE %?%";
		
		$stmt = self::$__CONN__->prepare($sql);
		$stmt->execute(array($query, $query, $query));
		
		self::logQuery($sql);
		
		return $stmt->fetchAll(self::FETCH_CLASS, $class_name);
	}
		
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
