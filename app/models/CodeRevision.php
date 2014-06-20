<?php

class CodeRevision extends Record
{
	const TABLE_NAME = 'code_revision';
	
	public	$code_revision_id = false,
			$user_id = false,
			$code_id = false,
			$rev = false,
			$content = false,
			$description = false,
			$date_created = false,
			$deleted = 0;
	
	public function beforeInsert(){
		if(!self::_validate_data()) return FALSE;
		
		$this->date_created = mysql_now();
		return TRUE;
	}
		
	public static function findClosestRevision($code_id = FALSE, $rev = FALSE){
		if($rev === FALSE) return self::findLastRevision($code_id);
		
		return self::findLastNth(1, 'code_id = ? AND rev <= ?', array(code_id, $rev));
	}
	
	public static function findLastRevision($code_id = FALSE){		
		return self::findLastNth(1, 'code_id = ?', array($code_id));
	}
	
	private function _validate_data(){
		if(
			empty($this->content)
		) return false;
		
		return true;
	}
	
} // end CodeRevision class
