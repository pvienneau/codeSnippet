<?php

class User extends Record
{
	const TABLE_NAME = 'user';
	
	public	$user_id = false,
			$username = false,
			$email = false,
			$first_name = false,
			$last_name = false,
			$password = false,
			$date_created = false,
			$date_last_login = false;
	
	public static function findByUsername($username){
		return self::findOneFrom(self::TABLE_NAME, 'username=?', array($username));
	}
	
} // end User class
