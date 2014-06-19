<?php
global $config;

$month_time = strtotime($month);

$prev_month_time = strtotime('-1 months', $month_time);
$prev_month = date('Y-m', $prev_month_time);

$next_month_time = strtotime('+1 months', $month_time);
$next_month = date('Y-m', $next_month_time);

$participants = User::workingHours($month);
$activities = Entry::activities($month);
$entries = Entry::latest($month);
$projects = Project::activeIn($month);
$tags = Tag::mostPopular($month);

?>

<?php if ($month != date('Y-m')): ?><a class="small button right" href="time/pulse/<?php echo $next_month; ?>">next month</a><?php endif; ?>
<a class="small button right" href="time/pulse/<?php echo $prev_month; ?>">previous month</a>

<h1>Pulse <b><?php echo $range_date; ?></b></h1>

<div id="participants">
	<h2>Hours</h2>
	<ul class="no-style">
<?php foreach($participants as $index => $user): ?>
		<li><img src="_/img/<?php echo $user->id; ?>_s.png" align="absmiddle" /> <a href="people/show/<?php echo $user->id; ?>"><?php echo $user->name; ?></a> <span class="hours"><b><?php echo format_hours($user->hours); ?></b> hours</span></li>
<?php endforeach; ?>
	</ul>
</div>

<div id="activities">
	<h2>Activity</h2>
	<div id="holder"></div>
	<table id="data-analytics" class="hide">
<?php for($i=1, $days=date('t',$month_time); $i<= $days; $i++): ?>
		<tr><th><?php echo $i ?></th><td><?php echo !empty($activities[$i]) ? $activities[$i]: 0; ?></td></tr>
<?php endfor; ?>
	</table>
</div>

<div class="clear"></div>

<div id="active-projects">
	<h2>Active Projects</h2>
	<ul class="no-style">
<?php foreach($projects as $project): ?>
		<li><span id="pie-project-<?php echo $project->id; ?>" class="pie"><?php echo ($project->remainingHours()<0 ? 0: $project->remainingHours()).'/'.$project->loggedHours(); ?></span> <a href="project/show/<?php echo $project->id; ?>"><?php echo $project->name; ?></a></li>
<?php endforeach; ?>
	</ul>
</div>

<div id="who-what">
	<h2>Who's doing what?</h2>
	<ul class="no-style">
<?php foreach($entries as $entry): ?>
		<li>
			<img src="_/img/<?php echo $entry->user_id; ?>_s.png" align="absmiddle" /> 
			<a href="people/show/<?php echo $entry->user_id; ?>"><?php echo $participants[$entry->user_id]->name; ?></a>
			<b><?php echo format_hours($entry->duration); ?> hours</b> 
			on <a href="project/show/<?php echo $entry->project_id; ?>"><?php echo $projects[$entry->project_id]->name; ?></a>
		</li>
<?php endforeach; ?>
	</ul>
</div>



<div class="clear"></div>

<h2>Most popular tags</h2>

<?php foreach($tags as $tag): ?>
	<?php echo $tag->link(); ?>
<?php endforeach; ?>
