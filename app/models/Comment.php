<?php

class Comment extends Record
{
	const TABLE_NAME = 'comment';
	
	public	$id = false,
			$object = '',
	 		$object_id = 0,
			$user_id = 0,
			$message = '',
			$created_on = '';
	
	public function beforeInsert()
	{
		$this->message = nl2br($this->message);
		$this->user_id = AuthUser::getId();
		$this->created_on = date('Y-m-d H:i:s');
		return true;
	}
	
	public static function find($object, $id)
	{
		$id = (int) $id;
		$sql = 'SELECT * FROM comment WHERE object = ? AND object_id = ?';
		
		$stmt = self::$__CONN__->prepare($sql);
		$stmt->execute(array($object, $id));
		
		return $stmt->fetchObject('Comment');
	}
	
	public static function findById($id)
	{
		$sql = 'SELECT * FROM comment WHERE id = ?';
		
		$stmt = self::$__CONN__->prepare($sql);
		$stmt->execute(array($id));
		
		return $stmt->fetchObject('Comment');
	}
	
	public static function findAll($object, $object_id)
	{
		$sql = 'SELECT comment.*, user.name AS user_name FROM comment, user WHERE user_id = user.id AND object = ? AND object_id = ? ORDER BY created_on DESC';
		
		$stmt = self::$__CONN__->prepare($sql);
		$stmt->execute(array($object, $object_id));
		
		return $stmt->fetchAll(self::FETCH_OBJ);
	}
	

} // end Comment class
