<?php
global $config;

$participants = User::workingOn($project->id);
$percent = empty($project->budgeted) ? 100: number_format($project->loggedHours() / $project->budgeted * 100, 1);

if ($percent > 100) $percent = 100;

$month_time = strtotime($month);
$prev_month_time = strtotime('-1 months', $month_time);
$prev_month = date('Y-m', $prev_month_time);
$year = substr($month, 0, 4);

$activities = $project->activities($month);

?>

<?php if (!$project->is_active): ?>
	<h2 class="error">This project is archived</h2>
	<a class="small time-button right" href="project/activate/<?php echo $project->id; ?>">reactivate this project</a>
<?php else: ?>
	<a class="small time-button edit right" href="project/edit/<?php echo $project->id; ?>">edit this project</a>
	<a class="small time-button right" href="project/archive/<?php echo $project->id; ?>">archive this project</a>
<?php endif; ?>

<a class="small time-button right" href="project/csv/<?php echo $project->id; ?>">download entries as CSV</a>

<h1>Project <b><?php echo $project->name ?></b></h1>

<div id="project-details">
	<span class="hours"><b><?php echo $project->loggedHours(); ?>h</b> LOGGED</span>
	<span class="hours"><b><?php echo $project->budgeted; ?>h</b> BUDGETED</span>
	<span class="hours"><b><?php echo $project->remainingHours(); ?>h</b> REMAINING</span>
	
	<div class="bar-container">
		<div class="bar" style="width: <?php echo $percent; ?>%"><?php echo $percent; ?>%</div>
	</div>
	<br class="clear" />
</div>

<?php if ($project->unbillableHours()): ?>
	<p class="unbillable">
		<b><?php echo $project->unbillableHours(); ?> hours</b> 
		(<?php echo number_format($project->unbillableHours() / ($project->unbillableHours() + $project->loggedHours()) * 100, 1); ?>%) 
		are marked as <span class="unbillable">unbillable*</span> and are not deducted from the budget.
	</p>
<?php endif; ?>

<div id="participants">
	<h2>Participant</h2>
	<ul class="no-style">
<?php foreach($participants as $index => $user): ?>
		<li><img src="_/img/<?php echo $user->id; ?>_s.png" align="absmiddle" /> <a href="people/show/<?php echo $user->id; ?>"><?php echo $user->username; ?></a> <span class="hours"><b><?php echo format_hours($user->hours); ?></b>h</span></li>
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

<a class="small time-button report right" href="report/this_week">this week</a>
<a class="small time-button report right" href="report/this_month">this month</a>
<a class="small time-button report right" href="report/last_month">last month</a>

<h2>Log Entries</h2>
<table cellpadding="0" cellspacing="0" width="100%">
<?php foreach(Entry::fromProject($project->id, 50, $month) as $entry): ?>
	<tr<?php if (!$project->is_active) echo ' class="archived"' ?>>
		<td class="hours"><b><?php echo format_hours($entry->duration); ?></b>h</td>
		<td class="user"><img src="_/img/<?php echo $entry->user_id; ?>_s.png" align="absmiddle" /> <a href="<?php url('people/show/'.$entry->user_id); ?>"><?php echo $participants[$entry->user_id]->username; ?></a></td>
		<td class="description"><?php echo $entry->tagsLink().' '.$entry->description; ?></td>
		<td class="date"><?php display_date($entry->created_on); ?></td>
		<td class="actions">
<?php if ($project->is_active): ?>
			<a href="<?php url('time/edit/'.$entry->id); ?>" class="small time-button">edit</a>
			<a href="<?php url('time/delete/'.$entry->id); ?>" class="small time-button delete">x</a>
<?php else: ?>
			<a>archived</a>
<?php endif; ?>
		</td>
	</tr>
<?php endforeach; ?>
</table>

<br />

back in time: 
<a class="time-button" href="project/show/<?php echo $project->id.'/'.($year-1); ?>"><?php echo ($year-1); ?></a>
<a class="time-button" href="project/show/<?php echo $project->id.'/'.$year; ?>"><?php echo $year; ?></a>
<a class="time-button" href="project/show/<?php echo $project->id.'/'.$prev_month; ?>"><?php echo date('F', $prev_month_time) ?></a>