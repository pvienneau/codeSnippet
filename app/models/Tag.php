<?php
/*
   Class: Tag 
      Enter description here...

   Generated on Mon, 31 Aug 2009 20:00:28 -0400 by Framework.php

   Author:
      Philippe Archambault <philippe.archambault@gmail.com>
*/

class Tag extends Record
{
	const TABLE_NAME = 'tag';
	
	public $name = '';
	public $is_billable = 1;
	
	public function link($href=false)
	{
		if (!$href)
			$href = 'tag/show/'.$this->id.'/'.urlencode(trim($this->name, ' *'));
		return '<a class="tag link" href="'.$href.'"><span>'.str_replace('*', '<b>*</b>', $this->name).'</span></a>';
	}
	
	public static function findByName($name)
	{
		$name = self::escape($name);
		$sql = "SELECT * FROM tag WHERE name = '$name'";
		//self::logQuery($sql);
		
		$stmt = self::$__CONN__->prepare($sql);
		$stmt->execute();
		
		return $stmt->fetchObject('Tag');
	}

	public static function get($id)
	{
		$id = (int) ($id);
		$sql = "SELECT * FROM tag WHERE id = $id";
		//self::logQuery($sql);
		
		$stmt = self::$__CONN__->prepare($sql);
		$stmt->execute();
		
		return $stmt->fetchObject('Tag');
	}
	
	public static function all()
	{
		$sql = "SELECT * FROM tag";
		//self::logQuery($sql);
		
		$stmt = self::$__CONN__->prepare($sql);
		$stmt->execute();
		
		$items = array();
		while (($item = $stmt->fetchObject('Tag')) !== false)
			$items[] = $item;
		
		return $items;
	}
	
	public static function mostPopular($month, $limit=10)
	{
		$sql = "SELECT tag.*, count(tag_id) AS num FROM entry_tag, entry, tag WHERE entry_id = entry.id AND tag_id = tag.id AND DATE_FORMAT(entry.created_on, '%Y-%m')='$month' GROUP BY tag.id ORDER BY num DESC LIMIT 0, $limit";
		//self::logQuery($sql);
		
		$stmt = self::$__CONN__->prepare($sql);
		$stmt->execute();
		
		$items = array();
		while (($item = $stmt->fetchObject('Tag')) !== false)
			$items[] = $item;
		
		return $items;
	}
} // end Tag class
