<h1>Tag <b><?php echo $tag->name; ?></b></h1>

<h2>Log Entries</h2>
<table cellpadding="0" cellspacing="0" width="100%">
<?php foreach(Entry::withTag($tag->id) as $entry): $project = Project::get($entry->project_id); ?>
	<tr>
		<td class="hours"><b><?php echo format_hours($entry->duration); ?></b>h</td>
		<td class="project"><a href="<?php echo url('project/show/'.$entry->project_id); ?>"><?php echo $project->name; ?></a></td>
		<td class="description"><?php echo $entry->tagsLink().' '.$entry->description; ?></td>
		<td class="date"><?php display_date($entry->created_on); ?></td>
		<td class="actions">
			<a href="<?php url('time/edit/'.$entry->id); ?>" class="small button edit">edit</a>
			<a href="<?php url('time/delete/'.$entry->id); ?>" class="small button delete">x</a>
		</td>
	</tr>
<?php endforeach; ?>
</table>
