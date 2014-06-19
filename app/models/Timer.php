<?php

class Timer extends Record
{	
	const TABLE_NAME = 'timer';
	
	public  $id = false,
			$user_id = 0,
			$project_id = 0,
			$duration = 0,
			$status = 'open',
			$start_time = '',
			$created_on = '';
	
	public function beforeInsert()
	{
		$this->created_on = date('Y-m-d');
		$this->user_id = AuthUser::getId();
		
		
		return true;
	}
	
	public function start()
	{
		$this->status = 'open';
		$this->start_time = date('Y-m-d H:i:s');
		$this->save();
	}
	
	public function pause()
	{
		$hours = number_format((time() - strtotime($this->start_time)) / 3600, 2, '.', '');
		
		if ($hours < .01) $hours = .01;
		
		$this->duration += $hours;
		
		$this->status = 'stop';
		$this->start_time = '00:00:00 00:00:00';
		$this->save();
		
		return $this->duration;
	}
	
	static function fromProject($id)
	{
		$sql = 'SELECT * FROM timer WHERE project_id = '.$id.' AND user_id = '.AuthUser::getId();
		
		$stmt = self::$__CONN__->prepare($sql);
		$stmt->execute();

		return $stmt->fetchObject('Timer');
	}
}
