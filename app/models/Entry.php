<?php
/*
   Class: Entry 
      Enter description here...

   Generated on Mon, 31 Aug 2009 20:00:28 -0400 by Framework.php

   Author:
      Philippe Archambault <philippe.archambault@gmail.com>
*/

class Entry extends Record
{
	const TABLE_NAME = 'entry';
	
	public	$user_id = '',
			$project_id = '0',
	 		$duration = '',
	 		$description = '',
	 		$created_on = '',
	 		$is_billable = 1;
	
	public function getColumns()
	{
		return array('user_id', 'project_id', 'duration', 'description', 'created_on', 'is_billable');
	}

	public function beforeInsert()
	{
		$this->user_id = AuthUser::getId();
		
		if (empty($this->created_on) || $this->created_on == '0000-00-00')
			$this->created_on = date('Y-m-d');
		
		return true;
	}

	public function beforeSave()
	{
		$this->_relations = array(); // sql that will be executed after the save of the entry
		
		// format duration
		if (strpos($this->duration, ':') !== false) {
			list($hours, $minutes) = explode(':', $this->duration);
			$this->duration = ($minutes / 60) + $hours;
		}
		
		// now we need to take care of the tags / descriptions
		$desc = trim(strip_tags($this->description), ' ,');
		$this->description = '';
		
		$tags = explode(',', $desc);
		$current_tags = $this->tags();
		
		while (($tag = array_shift($tags)) !== null) {
			$tag = trim($tag, ' ,');

			if (empty($tag)) continue;
			
			if ($tag[0] == '!' || str_word_count($tag) > 2) {
				$this->description .= ' '.$tag;
				continue;
			} else if ($this->description != '') {
				$this->description .= ', '.$tag;
				continue;
			}
			
			$tag = strtolower($tag);
			
			//try to find if the tag already exist
			if (!$t = Tag::findByName($tag)) {
				$t = new Tag(array(
					'name' => $tag, 
					'is_billable' => $tag[strlen($tag)-1] == '*' ? 0: 1)
				);
				$t->save();
				
				$this->_relations[$t->id] = 'add';
			} else {
				if (!isset($current_tags[$t->id])) {
					$this->_relations[$t->id] = 'add';
				}
				else unset($current_tags[$t->id]);
			}
			
			if (!$t->is_billable)
				$this->is_billable = 0;
		}
		
		$this->description = trim($this->description);
		
		// removing old tags
		while (($tag = array_shift($current_tags)) !== null)
			$this->_relations[$tag->id] = 'del';
		
		return true;
	}
	
	public function beforeDelete()
	{
		$sql = 'DELETE FROM entry_tag WHERE entry_id='.$this->id;
		
		return (bool) self::exec($sql);
	}
	
	public function afterSave()
	{
		// execute all query logged in the beforeSave function ;)
		foreach ($this->_relations as $id => $action)
			if ($action == 'add') self::exec("INSERT INTO entry_tag (entry_id, tag_id) VALUES ({$this->id}, $id)");
			else self::exec("DELETE FROM entry_tag WHERE entry_id = {$this->id} AND tag_id = $id");
		
		return true;
	}

	public function tags()
	{
		if (!isset($this->tags)) {
			$this->tags = array();
			
			if ($this->id) {
				$sql = "SELECT tag.* FROM entry_tag, tag WHERE entry_id = {$this->id} AND tag_id = tag.id ORDER BY tag.name";
				//self::logQuery($sql);
			
				$stmt = self::$__CONN__->prepare($sql);
				$stmt->execute();

				$this->tags = array();
				while (($tag = $stmt->fetchObject('Entry')) !== false)
					$this->tags[$tag->id] = $tag;
			}
		}
		return $this->tags;
	}
	
	public function tagsLink()
	{
		$html = '';
		foreach ($this->tags() as $tag)
			$html .= $tag->link();
		
		return $html;
	}

	//
	// S T A T I C
	//

	public static function get($id)
	{
		$id = (int) $id;
		$sql = 'SELECT * FROM entry WHERE id=?';
		self::logQuery($sql);
		
		$stmt = self::$__CONN__->prepare($sql);
		$stmt->execute(array($id));
		
		return $stmt->fetchObject('Entry');
	}

	/*public static function findAll()
	{
		$sql = 'SELECT * FROM '.self::TABLE_NAME;
	
		$stmt = self::$__CONN__->prepare($sql);
		$stmt->execute();
	
		$objects = array();
		while ($object = $stmt->fetchObject('Entry'))
			$objects[] = $object;
		
		return $objects;
	}*/
	
	public static function fromUser($id, $limit=10, $month='')
	{
		$id = (int) $id;
		
		// auto offset generated with _GET 'page'
		$offset = empty($_GET['page']) || $_GET['page'] == 1 ? 0: ($_GET['page']-1) * $limit;
		
		if (strlen($month) == 4)
			$month = "AND DATE_FORMAT(created_on, '%Y')='$month'";
		else if (strlen($month) == 7)
			$month = "AND DATE_FORMAT(created_on, '%Y-%m')='$month'";
		
		$sql = "SELECT * FROM entry WHERE user_id=$id $month ORDER BY created_on DESC, id DESC LIMIT $offset, $limit";
	
		//self::logQuery($sql);
		
		$stmt = self::$__CONN__->prepare($sql);
		$stmt->execute();
		
		$items = array();
		while (($item = $stmt->fetchObject('Entry')) !== false)
			$items[] = $item;
		
		return $items;
	}
	
	public static function fromProject($id, $limit=10, $month='')
	{
		$id = (int) $id;
		
		// auto offset generated with _GET 'page'
		$offset = empty($_GET['page']) || $_GET['page'] == 1 ? 0: ($_GET['page']-1) * $limit;
		
		if (strlen($month) == 4)
			$month = "AND DATE_FORMAT(created_on, '%Y')='$month'";
		else if (strlen($month) == 7)
			$month = "AND DATE_FORMAT(created_on, '%Y-%m')='$month'";
		
		$sql = "SELECT * FROM entry WHERE project_id=$id $month ORDER BY created_on DESC, id DESC LIMIT $offset, $limit";
	
		//self::logQuery($sql);
		
		$stmt = self::$__CONN__->prepare($sql);
		$stmt->execute();
		
		$items = array();
		while (($item = $stmt->fetchObject('Entry')) !== false)
			$items[] = $item;
		
		return $items;
	}
	
	public static function latest($month='', $limit=10)
	{
		// auto offset generated with _GET 'page'
		$offset = empty($_GET['page']) || $_GET['page'] == 1 ? 0: ($_GET['page']-1) * $limit;
		
		if (strlen($month) == 7)
			$month = "WHERE DATE_FORMAT(created_on, '%Y-%m')='$month'";
		
		$sql = "SELECT * FROM entry $month ORDER BY created_on DESC, id DESC LIMIT $offset, $limit";
	
		//self::logQuery($sql);
		
		$stmt = self::$__CONN__->prepare($sql);
		$stmt->execute();
		
		$items = array();
		while (($item = $stmt->fetchObject('Entry')) !== false)
			$items[] = $item;
		
		return $items;
	}
	
	public static function withTag($id, $limit=10)
	{
		$id = (int) $id;
		
		// auto offset generated with _GET 'page'
		$offset = empty($_GET['page']) || $_GET['page'] == 1 ? 0: ($_GET['page']-1) * $limit;
		
		$sql = "SELECT entry.* FROM entry_tag, entry WHERE tag_id=$id AND entry_id = entry.id ORDER BY created_on DESC, id DESC LIMIT $offset, $limit";
	
		//self::logQuery($sql);
		
		$stmt = self::$__CONN__->prepare($sql);
		$stmt->execute();
		
		$items = array();
		while (($item = $stmt->fetchObject('Entry')) !== false)
			$items[] = $item;
		
		return $items;
	}
	
	public static function hoursFrom($id, $date=false)
	{
		$id = (int) $id;
		
		if (!$date)
			$date = date('Y-m-d');
			
		$sql = "SELECT SUM(duration) FROM entry WHERE user_id = $id AND created_on = '$date'";
		
		//self::logQuery($sql);
		
		$stmt = self::$__CONN__->prepare($sql);
		$stmt->execute();

		$hours = (float) $stmt->fetchColumn();
		
		return $hours == 0 ? 'None': $hours.' hours';
	}
	
	public static function getBillable($where='', $limit=25, $billable=1)
	{
		// auto offset generated with _GET 'page'
		$offset = empty($_GET['page']) || $_GET['page'] == 1 ? 0: ($_GET['page']-1) * $limit;
		
		$from = 'entry, project, user';
		
		if ($where != '') $where = 'AND '.$where;
		if (!empty($_GET['user'])) {
			$_GET['user'] = preg_replace('/[^0-9,]/','', trim($_GET['user'], ' ,'));
			$where .= ' AND user_id IN ('.$_GET['user'].')';
		}
		if (!empty($_GET['project'])) $where .= ' AND project_id ='.(int)$_GET['project'];
		if (!empty($_GET['tags'])) {
			$_GET['tags'] = preg_replace('/[^0-9,]/','', trim($_GET['tags'], ' ,'));
			$from .= ', entry_tag';
			$where .= ' AND entry_id = entry.id AND tag_id IN ('.$_GET['tags'].')';
		}

		$sql = "SELECT entry.*, user.name AS user_name, project.name AS project_name, project.is_active AS project_is_active
				FROM $from
				WHERE is_billable=$billable AND project_id = project.id AND user_id = user.id $where ORDER BY entry.created_on DESC, entry.id DESC LIMIT $offset, $limit";
	
		//self::logQuery($sql);
		
		$stmt = self::$__CONN__->prepare($sql);
		$stmt->execute();
		
		$items = array();
		while (($item = $stmt->fetchObject('Entry')) !== false)
			$items[] = $item;
		
		return $items;
	}
	
	public static function getUnbillable($where='', $limit=25)
	{
		return self::getBillable($where, $limit, 0);
	}
	
	public static function activities($month)
	{
		$sql = "SELECT date_format(created_on, '%e') AS day, sum(duration) AS hours FROM entry WHERE DATE_FORMAT(created_on, '%Y-%m')='$month' GROUP BY day";
		self::logQuery($sql);
		
		$stmt = self::$__CONN__->prepare($sql);
		$stmt->execute();
		
		$items = array();
		while (($item = $stmt->fetch(PDO::FETCH_ASSOC)) !== false)
			$items[$item['day']] = $item['hours'];
		
		return $items;
	}
	
} // end Entry class
