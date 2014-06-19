<div id="edit-todo">
	<form action="project/<?php echo $project->id ?>/todo/<?php echo $todo->id ? 'edit/'.$todo->id: 'add'; ?>" method="post" class="default">
		<h2><?php echo $todo->id ? 'Edit this': 'Add a new'; ?> to-do list</h2>

		<label>First give the list a name <small>(eg. "Things for the meeting")</small></label>
		<input type="text" class="text title" name="todo[name]" maxlength="100" value="<?php echo $todo->name; ?>" />
		
		<hr />
	
		<label class="optional">List description or notes about this list </label>
		<textarea name="todo[description]" maxlegth="255"><?php echo $todo->description; ?></textarea>
		
		<label class="optional">Does this list relate to a milestone?</label>
		<select name="todo_milestone[milestone_id]">
			<option value="0">NONE</option>
			<?php echo milestones_select_option(); ?>
		</select>
	
		<div class="buttons">
			<button type="submit"><?php echo $todo->id ? 'Save Changes': 'Create this list'; ?></button> or
			<a href="<?php url('project/'.$project->id.'/todo'); ?>">Cancel</a>
		</div>
	</form>
</div>