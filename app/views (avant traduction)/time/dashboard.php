<?php include_view('time/quick-entry'); ?>

<h2><a href="people/show/<?php echo AuthUser::getId() ?>"><img src="_/img/<?php echo AuthUser::getId(); ?>_s.png" align="absmiddle" /></a> Your recent entries</h2>

<table cellpadding="0" cellspacing="0" width="100%">
<?php foreach(Entry::fromUser(AuthUser::getId()) as $entry): $project = Project::findById($entry->project_id); ?>
	<tr<?php if (!$project->is_active) echo ' class="archived"' ?>>
		<td class="hours"><b><?php echo format_hours($entry->duration); ?></b>h</td>
		<td class="chart"><span id="pie-<?php echo $entry->id; ?>" class="pie"><?php echo ($project->remainingHours()<0 ? 0: $project->remainingHours()).'/'.$project->loggedHours(); ?></span></td>
		<td class="project"><a href="<?php echo url('project/show/'.$entry->project_id); ?>"><?php echo $project->name; ?></a></td>
		<td class="description"><?php echo $entry->tagsLink().' '.$entry->description; ?></td>
		<td class="date"><?php display_date($entry->created_on); ?></td>
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
