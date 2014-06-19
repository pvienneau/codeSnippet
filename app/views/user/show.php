<?php
global $config;

$projects = $user->activeProjects($month);
$activities = $user->activities($month);

$month_time = strtotime($month);
$prev_month_time = strtotime('-1 months', $month_time);
$prev_month = date('Y-m', $prev_month_time);
$year = substr($month, 0, 4);

?>

<img src="_/img/<?php echo $user->id; ?>_m.png" align="left" />
<a class="small time-button right" href="people/edit/<?php echo $user->id; ?>">edit settings</a>
<h1><?php echo $user->name.' <small>(aka <span class="aka">'.$user->username.'</span>)</small>' ?></h1>
<p><a href="mailto:<?php echo $user->email; ?>"><?php echo $user->email; ?></a> <?php if ($user->is_admin) echo ' <span class="admin">admin</span>' ?>

<div class="clear"></div>

<div id="active-projects">
	<h2>Active Projects</h2>
	<ul class="no-style">
<?php foreach($projects as $index => $project): ?>
		<li><span id="pie-project-<?php echo $project->id; ?>" class="pie"><?php echo ($project->remainingHours()<0 ? 0: $project->remainingHours()).'/'.$project->loggedHours(); ?></span> <a href="project/show/<?php echo $project->id; ?>"><?php echo $project->name; ?></a></li>
<?php endforeach; ?>
	</ul>
</div>


<div id="activities">
	<h2>Activities</h2>
	<div id="holder"></div>
	<table id="data-analytics" class="hide">
<?php if (strlen($month) == 4): ?>
	<?php for($i=1; $i <= 12; $i++): ?>
			<tr><th><?php echo substr($config['months'][$i], 0, 3); ?></th><td><?php echo !empty($activities[$i]) ? $activities[$i]: 0; ?></td></tr>
	<?php endfor; ?>
<?php else: ?>
	<?php for($i=1, $days=date('t',$month_time); $i<= $days; $i++): ?>
		<tr><th><?php echo $i ?></th><td><?php echo !empty($activities[$i]) ? $activities[$i]: 0; ?></td></tr>
	<?php endfor; ?>
<?php endif; ?>
	</table>
</div>

<div class="clear"></div>

<h2>Recent entries</h2>
<table cellpadding="0" cellspacing="0" width="100%">
<?php foreach(Entry::fromUser($user->id, 50, $month) as $entry): $project = $projects[$entry->project_id]; ?>
	<tr<?php if (!$project->is_active) echo ' class="archived"' ?>>
		<td class="hours"><b><?php echo format_hours($entry->duration); ?></b>h</td>
		<td class="chart"><span id="pie-<?php echo $entry->id; ?>" class="pie"><?php echo ($project->remainingHours()<0 ? 0: $project->remainingHours()).'/'.$project->loggedHours(); ?></span></td>
		<td class="project"><a href="project/show/<?php echo $entry->project_id; ?>"><?php echo $project->name; ?></a></td>
		<td class="description"><?php echo $entry->tagsLink().' '.$entry->description; ?></td>
		<td class="date"><?php echo date('M j', strtotime($entry->created_on)); ?></td>
		<td class="actions">
<?php if ($project->is_active): ?>
			<a href="<?php echo url('time/edit/'.$entry->id); ?>" class="small time-button">edit</a>
			<a href="<?php echo url('time/delete/'.$entry->id); ?>" class="small time-button delete">x</a>
<?php else: ?>
			<a>archived</a>
<?php endif; ?>
		</td>
	</tr>
<?php endforeach; ?>
</table>
<br />

back in time: 
<a class="time-button" href="people/show/<?php echo $user->id.'/'.($year-1); ?>"><?php echo ($year-1); ?></a>
<a class="time-button" href="people/show/<?php echo $user->id.'/'.$year; ?>"><?php echo $year; ?></a>
<a class="time-button" href="people/show/<?php echo $user->id.'/'.$prev_month; ?>"><?php echo date('F', $prev_month_time) ?></a>