<?php

class User extends Record
{
	const TABLE_NAME = 'user';
	
	public	$id = false,
	 		$username = '',
	 		$password = '',
	 		$name = '',
	 		$email = '',
	 		$is_active = 1,
	 		$is_admin = 0,
	 		$created_on = '',
	 		$created_by = '',
	 		$last_login = '',
			$deleted = 0,
			$invoices = 0, // 0 = no access, 1 = view, 2 = full access
			$estimates = 0,
			$recurrings = 0,
			$clients = 0,
			$users = 0,
			$address_line_1 = '',
			$address_line_2 = '',
			$city = '',
			$zip_code = '',
			$state = '',
			$country = '',
			$phone_number = '';



	
	public function link()
	{
		// will include picture thumbnail here too ;)
		return '<a class="user link" href="user/show/'.$this->id.'/'.urlencode($this->username).'"><span>'.$this->username.'</span></a>';
	}

	public function activities($month=false)
	{
		if (!$month)
			$month = date('Y-m');

		if (strlen($month) == 4)
			$month = "AND DATE_FORMAT(created_on, '%Y')='$month'";
		else if (strlen($month) == 7)
			$month = "AND DATE_FORMAT(created_on, '%Y-%m')='$month'";

		$sql = "SELECT date_format(created_on, '%e') AS day, sum(duration) AS hours FROM entry WHERE user_id='{$this->id}' $month GROUP BY day";
		self::logQuery($sql);

		$stmt = self::$__CONN__->prepare($sql);
		$stmt->execute();
		
		$items = array();
		while (($item = $stmt->fetch(PDO::FETCH_ASSOC)) !== false)
			$items[$item['day']] = $item['hours'];
		
		return $items;
	}

	public function activeProjects($month=false)
	{
		if (!$month)
			$month = date('Y-m');

		if (strlen($month) == 4)
			$month = "AND DATE_FORMAT(entry.created_on, '%Y')='$month'";
		else if (strlen($month) == 7)
			$month = "AND DATE_FORMAT(entry.created_on, '%Y-%m')='$month'";

		$sql = "SELECT project.* FROM project, entry WHERE entry.project_id = project.id AND entry.user_id='{$this->id}' $month GROUP BY project_id";
		self::logQuery($sql);

		$stmt = self::$__CONN__->prepare($sql);
		$stmt->execute();
		
		$objects = array();
		while ($object = $stmt->fetchObject('Project')) {
			$objects[$object->id] = $object;
		}
		return $objects;
	}

	public static function get($id)
	{
		$id = (int) $id;
		$sql = "SELECT * FROM user WHERE id=$id";

		$stmt = self::$__CONN__->prepare($sql);
		$stmt->execute();
		
		return $stmt->fetchObject('User');
	}

	static public function findBy($field, $value)
	{
		return self::findOneFrom('User', $field.'=?', array($value));
	}

	public static function findAll()
	{
		$sql = 'SELECT * FROM user WHERE deleted=0 ORDER BY name';
		
		$stmt = self::$__CONN__->prepare($sql);
		$stmt->execute();
		
		$users = array();
		while ($user = $stmt->fetchObject('User')) {
			$users[] = $user;
		}
		return $users;
	}
	
	public static function workingOn($id)
	{
		$id = (int) $id;
		
		$sql = "SELECT user.*, SUM(entry.duration) AS hours FROM user, entry WHERE entry.user_id = user.id AND entry.project_id = $id GROUP BY user.id ORDER BY hours DESC";
	
		$stmt = self::$__CONN__->prepare($sql);
		$stmt->execute();
		
		$users = array();
		while ($user = $stmt->fetchObject('User')) {
			$users[$user->id] = $user;
		}
		return $users;
	}
	
	public static function workingHours($month)
	{
		$sql = "SELECT user.*, SUM(entry.duration) AS hours FROM user, entry WHERE entry.user_id = user.id AND DATE_FORMAT(entry.created_on, '%Y-%m')='$month' GROUP BY user.id ORDER BY hours DESC";
	
		$stmt = self::$__CONN__->prepare($sql);
		$stmt->execute();
		
		$users = array();
		while ($user = $stmt->fetchObject('User')) {
			$users[$user->id] = $user;
		}
		return $users;
	}
	
	public function image($size='s')
	{
		$file = '_/img/'.$this->id.'_'.$size.'.png';
		if (file_exists(CORE_ROOT.'/'.$file))
			return '<img src="'.$file.'" class="user-thumb" />';
	}
	
	public static function imageFrom($user_id, $size='s')
	{
		$file = '_/img/'.$user_id.'_'.$size.'.png';
		if (file_exists(CORE_ROOT.'/'.$file))
			return '<img src="'.$file.'" class="user-thumb" />';
	}
	public static function accessOptions($selected = 0 ){
		$arr = array("No access", "View", "Full access");
		$str="";
		foreach($arr as $key=>$opt){
			if($selected ==  $key){
				$str .= '<option value="'.$key.'" selected="selected">'.$opt.'</option>';
			}else{
				$str .= '<option value="'.$key.'">'.$opt.'</option>';
			}
		}
		return $str;
	}
	
} // end User class
