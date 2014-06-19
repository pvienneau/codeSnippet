<h1>Tags</h1>

<?php if (count($tags)): ?>

<table cellpadding="0" cellspacing="0" width="100%">
<?php foreach ($tags as $tag): ?>
<tr>
	<td><?php echo $tag->link(); ?></td>
	<td class='actions'>
		<a class="button edit" href="tag/edit/<?php echo $tag->id; ?>">edit</a>
		<a class="button delete" href="tag/delete/<?php echo $tag->id; ?>" onclick="return confirm('Are you sure you wish to delete this tag?');">x</a>
	</td>
</tr>
<?php endforeach; ?> 
</table>

<?php else: ?> 

<h2>No tags found!</h2>

<?php endif; ?> 

<p><span style="color:#ED5D90">*</span> defined as unbillable by you</p>

<div class="help">
	<p><b>Creating a new tag.</b> To create a new tag, simply enter a phrase that is two words or fewer. To create more than one tag, separate them with commas.</p>
</div>