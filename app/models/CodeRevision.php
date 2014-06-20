<?php

class CodeRevision extends Record
{
	const TABLE_NAME = 'code_revision';
	
	public	$code_revision_id = false,
			$user_id = false,
			$post_id = false,
			$rev = false,
			$content = false,
			$description = false,
			$date_created = false,
			$deleted = 0;
			
	public static function findClosestRevision($code_id = FALSE, $rev = FALSE){
		if($rev === FALSE) return self::findLastRevision($code_id);
		
		return self::findLastNth(1, 'code_id = ? AND rev <= ?', array(code_id, $rev));
	}
	
	public static function findLastRevision($code_id = FALSE){		
		return self::findLastNth(1, 'code_id = ?', array($code_id));
	}
	
} // end CodeRevision class
