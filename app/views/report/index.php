<?php

$action = Dispatcher::getAction();
$params = Dispatcher::getParams();

if ($action == 'day') 
	$date = $params[0];

?>

<?php include_view('time/quick-entry'); ?>

<h1>Report <b><?php echo $range_date; ?></b></h1>
<?php if (!empty($_GET['tags'])) foreach (explode(',', $_GET['tags']) as $id) if ($tag = Tag::get($id)) echo $tag->link('report/'.($action=='day'?'day/'.$date:$action).'?tags='.$tag->id); ?>
<?php if (!empty($_GET['project']) && $project = Project::get($_GET['project'])): ?>
	<h4>Project <b><?php echo $project->name; ?></b></h4>
<?php endif; ?>
<?php if (!empty($_GET['user'])): $users = explode(',', $_GET['user']); ?>
	<?php foreach ($users as $id) if ($user = User::get($id)) echo $user->link(); ?>
<?php endif; ?>

<div class="billable"><div class="toggle" onclick="$('#billable').toggleClass('hide');">&nbsp;</div><span>Billable hours</span><span class="right">Total: </span></div>
<table id="billable" cellpadding="0" cellspacing="0" width="100%">
<?php $tb = $tub = 0; foreach($billable as $entry): $tb += $entry->duration; ?>
	<tr<?php if (!$entry->project_is_active) echo ' class="archived"' ?>>
		<td class="hours"><b><?php echo format_hours($entry->duration); ?></b>h</td>
		<td class="project"><a href="<?php url('project/show/'.$entry->project_id); ?>"><?php echo $entry->project_name; ?></a></td>
		<td class="user"><img src="_/img/<?php echo $entry->user_id; ?>_s.png" align="absmiddle" /> <a href="<?php url('people/show/'.$entry->user_id); ?>"><?php echo $entry->user_name; ?></a></td>
		<td class="description"><?php echo $entry->tagsLink().' '.$entry->description; ?></td>
		<td class="date"><?php display_date($entry->created_on); ?></td>
		<td class="actions">
<?php if ($entry->project_is_active): ?>
			<a href="<?php url('time/edit/'.$entry->id); ?>" class="small button edit">edit</a>
			<a href="<?php url('time/delete/'.$entry->id); ?>" class="small button delete">x</a>
<?php else: ?>
			<a>archived</a>
<?php endif; ?>
		</td>
	</tr>
<?php endforeach; ?>
</table>

<div class="unbillable"><div class="toggle" onclick="$('#unbillable').toggleClass('hide');">&nbsp;</div><span>UnBillable hours</span><span class="right">Total: </span></div>
<table id="unbillable" cellpadding="0" cellspacing="0" width="100%">
<?php foreach($unbillable as $entry): $tub += $entry->duration; ?>
	<tr<?php if (!$entry->project_is_active) echo ' class="archived"' ?>>
		<td class="hours"><b><?php echo format_hours($entry->duration); ?></b>h</td>
		<td class="project"><a href="<?php url('project/show/'.$entry->project_id); ?>"><?php echo $entry->project_name; ?></a></td>
		<td class="user"><img src="_/img/<?php echo $entry->user_id; ?>_s.png" align="absmiddle" /> <a href="<?php url('people/show/'.$entry->user_id); ?>"><?php echo $entry->user_name; ?></a></td>
		<td class="description"><?php echo $entry->tagsLink().' '.$entry->description; ?></td>
		<td class="date"><?php display_date($entry->created_on); ?></td>
		<td class="actions">
<?php if ($entry->project_is_active): ?>
			<a href="<?php url('time/edit/'.$entry->id); ?>" class="small button edit">edit</a>
			<a href="<?php url('time/delete/'.$entry->id); ?>" class="small button delete">x</a>
<?php else: ?>
			<a>archived</a>
<?php endif; ?>
		</td>
	</tr>
<?php endforeach; ?>
</table>

<script type="text/javascript">
$('.billable .right').html('Total: <b><?php echo format_hours($tb); ?></b>h&nbsp;');
$('.unbillable .right').html('Total: <b><?php echo format_hours($tub); ?></b>h&nbsp;');
</script>