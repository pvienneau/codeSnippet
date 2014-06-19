<?php 

/*
   Class: ReportController
      Enter description here...

   Generated on Mon, 31 Aug 2009 20:00:28 -0400 by Framework.php

   Author:
      Philippe Archambault <philippe.archambault@gmail.com>
*/

class ReportController extends Controller
{
	public function __construct()
	{
		AuthUser::load();
		if ( ! AuthUser::isLoggedIn())
			redirect(get_url('login'));

		$this->setLayout('default');
	}

	public function execute($action, $params)
	{
		switch($action) {
			case 'index':
			case 'this_month': return $this->_month(this_month());
			case 'last_month': return $this->_month(last_month());
			case 'this_week':
				$range = this_week();
				return $this->_between($range['first-day'], $range['last-day']);
			case 'last_week':
				$range = last_week();
				return $this->_between($range['first-day'], $range['last-day']);
			case 'today':
				return $this->day(date('Y-m-d'));
		}
		
		// it's a private method of the class or action is not a method of the class
		if (substr($action, 0, 1) == '_' || ! method_exists($this, $action)) {
			throw new Exception("Action '{$action}' is not valid!");
		}
		call_user_func_array(array($this, $action), $params);
	}

	//public function index() { $this->_month(this_month()); }
	//public function this_month() { $this->_month(this_month()); }
	//public function last_month() { $this->_month(last_month()); }
	
	private function _month($range)
	{
		$this->_getifyPost();
		$year_month = $range['year'].'-'.$range['month'];
		
		$where = "date_format(entry.created_on, '%Y-%m') = '$year_month'";
		
		$this->display('report/index', array(
			'range_date' => display_date($year_month.'-01', false).
							' - '.
							display_date($year_month.'-'.$range['days'], false),
			'billable'   => Entry::getBillable($where),
			'unbillable' => Entry::getUnbillable($where)
		));
	}
	
	//public function this_week() { $range = this_week(); $this->_between($range['first-day'], $range['last-day']); }
	//public function last_week() { $range = last_week(); $this->_between($range['first-day'], $range['last-day']); }
	
	private function _between($from, $to)
	{
		$this->_getifyPost();
		$where = "entry.created_on >= '$from' AND entry.created_on <= '$to'";
		
		$this->display('report/index', array(
			'range_date' => display_date($from, false).
							' - '.
							display_date($to, false),
			'billable'   => Entry::getBillable($where),
			'unbillable' => Entry::getUnbillable($where)
		));
	}
	
	//public function today() { $this->day(date('Y-m-d')); }

	public function day($date)
	{
		$this->_getifyPost();
		$where = "entry.created_on = '$date'";
		
		$this->display('report/index', array(
			'range_date' => display_date($date, false),
			'billable'   => Entry::getBillable($where),
			'unbillable' => Entry::getUnbillable($where)
		));
	}
	
	private function _getifyPost()
	{
		if (empty($_POST['report']))
			return;
			
		$criteria = $_POST['report'];
		
		if (!empty($criteria['project']) && $project = Project::findByName($criteria['project']))
			$_GET['project'] = $project->id;
		
		if (!empty($criteria['tags'])) {
			$tags_id = '';
			foreach (explode(',', $criteria['tags']) as $tag)
				if ($tag = Tag::findByName(trim($tag)))
					$tags_id .= $tag->id.',';
			
			if (!empty($tags_id))
				$_GET['tags'] = $tags_id;
		}
	}
	
} // end ReportController class
