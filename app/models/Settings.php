<?php

class Settings extends Record
{
	public static $_company = false;
	
	public static function company()
	{
		if (!self::$_company) {
			self::$_company = Client::findById(1);
		}
		return self::$_company;
	}
}