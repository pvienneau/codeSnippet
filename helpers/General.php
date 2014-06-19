<?php

function sanatize_number($n)
{
	$n = str_replace(' ', '', $n);
	return str_replace(',', '.', $n);
}

function minimize_name($name)
{
	if (strlen($name) <= 8)
		return $name;
	
	$arr = explode(' ', $name);
	
	$first = $arr[0];
	$last = array_pop($arr);
	
	return substr($first, 0, 4). ' ' .$last[0].'.';
}

function country_select_option($selected='Canada')
{
	$country = array("Afghanistan","Aland Islands","Albania","Algeria","American Samoa","Andorra","Angola","Anguilla","Antarctica","Antigua and Barbuda","Argentina","Armenia","Aruba","Ascension Island","Australia","Austria","Azerbaijan","Bahamas","Bahrain","Bangladesh","Barbados","Belarus","Belgium","Belize","Benin","Bermuda","Bhutan","Bolivia","Bosnia and Herzegovina","Botswana","Bouvet Island","Brazil","British Indian Ocean Territory","British Virgin Islands","Brunei Darussalam","Bulgaria","Burkina Faso","Burundi","Cambodia","Cameroon","Canada","Cape Verde","Cayman Islands","Central African Republic","Chad","Chile","China","Christmas Island","Cocos Keeling Islands","Colombia","Comoros","Congo","Congo, Democratic Republic","Cook Islands","Costa Rica","Cote D'Ivoire","Croatia","Cuba","Cyprus","Czech Republic","Denmark","Djibouti","Dominica","Dominican Republic","East Timor","Ecuador","Egypt","El Salvador","Equatorial Guinea","Eritrea","Estonia","Ethiopia","Falkland Islands","Faroe Islands","Fiji","Finland","France","France, Metropolitan","French Guiana","French Polynesia","French Southern Territories","Gabon","Gambia","Georgia","Germany","Ghana","Gibraltar","Greece","Greenland","Grenada","Guadeloupe","Guam","Guatemala","Guinea","Guyana","Haiti","Heard and McDonald Islands","Honduras","Hong Kong","Hungary","Iceland","India","Indonesia","Iran","Iraq","Ireland","Isle of Man","Israel","Italy","Jamaica","Japan","Jersey","Jordan","Kazakhstan","Kenya","Kiribati","Korea (North)","Korea (South)","Kuwait","Kyrgyzstan","Laos","Latvia","Lebanon","Lesotho","Liberia","Libya","Liechtenstein","Lithuania","Luxembourg","Macau","Macedonia","Madagascar","Malawi","Malaysia","Maldives","Mali","Malta","Marshall Islands","Martinique","Mauritania","Mauritius","Mayotte","Mexico","Micronesia","Moldova","Monaco","Mongolia","Montserrat","Morocco","Mozambique","Myanmar","Namibia","Nauru","Nepal","Netherlands","Netherlands Antilles","Neutral Zone","New Caledonia","New Zealand","Nicaragua","Niger","Nigeria","Niue","Norfolk Island","Northern Mariana Islands","Norway","Oman","Pakistan","Palau","Palestinian Territory, Occupied","Panama","Papua New Guinea","Paraguay","Peru","Philippines","Pitcairn","Poland","Portugal","Puerto Rico","Qatar","Reunion","Romania","Russian Federation","Rwanda","S. Georgia and S. Sandwich Isls.","Saint Kitts and Nevis","Saint Lucia","Saint Vincent the Grenadines","Samoa","San Marino","Sao Tome and Principe","Saudi Arabia","Senegal","Serbia and Montenegro","Seychelles","Sierra Leone","Singapore","Slovak Republic","Slovenia","Solomon Islands","Somalia","South Africa","Spain","Sri Lanka","St. Helena","St. Pierre and Miquelon","Sudan","Suriname","Svalbard Jan Mayen Islands","Swaziland","Sweden","Switzerland","Syria","Taiwan","Tajikistan","Tanzania","Thailand","Togo","Tokelau","Tonga","Trinidad and Tobago","Tunisia","Turkey","Turkmenistan","Turks and Caicos Islands","Tuvalu","US Minor Outlying Islands","Uganda","Ukraine","United Arab Emirates","United Kingdom","United States","Uruguay","Uzbekistan","Vanuatu","Vatican City State","Venezuela","Viet Nam","Virgin Islands","Wallis and Futuna Islands","Western Sahara","Yemen","Zambia","Zimbabwe");
	$out = '';
	
	foreach ($country as $key) {
		$out .= '<option value="'.$key.'"'.($selected == $key ? ' selected="selected"':'').'>'.$key.'</option>';
	}
	
	return $out;
}

function users_select_option($selected='')
{
	$out = '';
	foreach (User::findAll() as $user)
		$out .= '<option value="'.$user->id.'"'.($user->id==$selected ? ' selected="selected"':'').'>'.$user->name.'</option>';
		
	return $out;
}

function clients_select_option($selected='')
{
	$out = '';
	foreach (Client::findAll() as $client)//$client->tax
		$out .= '<option'
			.($client->tax != '0' ? ' data-tax1="'.$client->tax.'"':'')
			.($client->tax2 != '0' ? ' data-tax2="'.$client->tax2.'"':'')
			.($client->tax_name != '' ? ' data-tax1_name="'.$client->tax_name.'"':'')
			.($client->tax2_name != '' ? ' data-tax2_name="'.$client->tax2_name.'"':'')
				.' value="'.$client->id.'"'.($client->id==$selected ? ' selected="selected"':'').'>'.(empty($client->company) ? $client->name: $client->company).'</option>';
		
	return $out;
}

function estimates_select_option($selected='')
{
	$out = '';
	foreach (Estimate::findAll() as $estimate)
		$out .= '<option value="'.$estimate->id.'"'.($estimate->id==$selected ? ' selected="selected"':'').'>#'.$estimate->estimate_id.' / '.$estimate->client.'</option>';
		
	return $out;
}

function projects_select_option($selected='')
{
	$out = '';
	foreach (Project::findAll('draft') as $project)
		$out .= '<option value="'.$project->id.'"'.($project->id==$selected ? ' selected="selected"':'').'>'.$project->name.'</option>';
		
	return $out;
}

function tasks_select_option($selected='')
{
	$out = '';
	foreach (Project::findAll('draft') as $project) {
		$out .= '<optgroup label="'.$project->name.'">';
		foreach (Task::fromProject($project->id) as $task) {
			$out .= '<option value="'.$task->id.'"'.($task->id==$selected ? ' selected="selected"':'').'>'.$task->description.'</option>';
		}
		$out .= '</optgroup>';
	}
		
	return $out;
}

function milestones_select_option($selected='')
{
	$out = '';
	foreach (Milestone::findAll() as $milestone)
		$out .= '<option value="'.$milestone->id.'"'.($milestone->id==$selected ? ' selected="selected"':'').'>'.$milestone->title.'</option>';
		
	return $out;
}

function date_select($date=false)
{
	if (empty($date)) {
		$date = date('Y-m-d');
	}
	
	list($year, $month, $day) = explode('-', $date);
	
	$out = '<div class="select_wrapper"><select name="day" class="select">';
	
	foreach (array('01','02','03','04','05','06','07','08','09',10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25,26,27,28,29,30,31) as $i) {
		$out .= '<option value="'.$i.'"'.($i == $day ? ' selected="selected"':'').'>'.$i.'</option>';
	}
	
	$out .= '</select></div><div class="select_wrapper"><select name="month" class="select">';
	
	foreach (array("01"=>'January',"02"=>'February',"03"=>'March',"04"=>'April',"05"=>'May',"06"=>'June',"07"=>'July',"08"=>'August',"09"=>'September',"10"=>'October',"11"=>'November',"12"=>'December') as $k => $v) {
		$out .= '<option value="'.$k.'"'.($k == $month ? ' selected="selected"':'').'>'.$v.'</option>';
	}
	
	$out .= '</select></div><div class="select_wrapper"><select name="year" class="select">';
	
	for ($i = $year-4; $i <= $year+4; $i++) {
		$out .= '<option value="'.$i.'"'.($i == $year ? ' selected="selected"':'').'>'.$i.'</option>';
	}
	
	return $out . "</select></div>\n";
}

function is_selected($true)
{
	if ($true)
		echo ' selected="selected"';
}
function is_checked($true)
{
	if ($true)
		echo ' checked="checked"';
}
function is_display($true)
{
	if (!$true)
		echo ' style="display:none"';
}

function my_number_format($number, $dec=2, $sep='.', $sep_t=' ')
{
	if (I18n::getLocale() == 'fr')
		return number_format($number, $dec, ',', ' ');

	return number_format($number, $dec, '.', ' ');
}

function my_qty_format($number)
{
	//if (I18n::getLocale() == 'fr')
	//	return str_replace(',00', '', my_number_format($number));
	
	//return str_replace('.00', '', my_number_format($number));
	if (strpos($number, '.') !== false or strpos($number, ',') !== false)
		$number = trim($number, '0');
	else
		$number = ltrim($number, '0');
		
	return preg_replace('/^([0-9]+)[.,]$/', "$1", $number);
}

function my_date_format($date)
{
	return strftime('%e %b %Y', strtotime($date));
	//return date('j M Y', strtotime($date));
}

function my_full_date_format($date, $display_year=true)
{
	if (!$display_year && strpos($date, date('Y')) === 0)
		return date('l, j F', strtotime($date));
	else
		return date('l, j F Y', strtotime($date));
}

function my_datetime_format($date)
{
	return date('j M Y \a\t H:i', strtotime($date));
}

// ----------------------------------------------------------------
//	 global function
// ----------------------------------------------------------------

function last_month()
{
	static $return = false;
	
	if (!$return) {
		$time = strtotime('-1 month');
		$return = array(
			'year' => date('Y', $time),
			'month' => date('m', $time),
			'days' => date('t', $time)
		);
	}
	return $return;
} //return: ['year': 2009, 'month':'09', 'days': 31]
function this_month()
{
	static $return = false;
	
	if (!$return) {
		$return = array(
			'year' => date('Y'),
			'month' => date('m'),
			'days' => date('t')
		);
	}
	return $return;
} //return: ['year': 2009, 'month':'09', 'days': 31]

// from sunday to saterday
function last_week()
{
	static $return = false;
	
	if (!$return) {
		
		$time = date('L') ? strtotime('-1 week'): strtotime('-2 week');
		$time -= (date('L', $time)-1) * 86400;

		$return = array();
		$return['first-day'] = date('Y-m-d', $time);
		$return['last-day'] = date('Y-m-d', $time+518400);
	}
	return $return;
}
function this_week()
{
	static $return = false;
	
	if (!$return) {
		$time = (date('L') ? $_SERVER['REQUEST_TIME']: strtotime('-1 week')) - (date('L')-1) * 86400;

		$return = array();
		$return['first-day'] = date('Y-m-d', $time);
		$return['last-day'] = date('Y-m-d', $time+518400);
	}
	return $return;
}

function display_date($date, $echo=true)
{
	if ($date == date('Y-m-d'))
		$date = 'today';
	else if ($date ==  date('Y-m-d', strtotime('-1 day')))
		$date = 'yesterday';
	else
		$date = (int) $date == date('Y') ? date('M j', strtotime($date)):  date('M j, Y', strtotime($date));
	
	if (!$echo)
		return $date;
	
	echo $date;
}

function format_hours($h)
{
	return str_replace(array('.25','.5','.75'), array('¼','½','¾'), ltrim($h, 0));
}

function format_duration($h)
{
	$split = explode('.', $h);
	
	return $h;
}