<div id="add-milestone">
	<form action="project/<?php echo $project->id; ?>/milestone/<?php echo $milestone->id ? 'edit/'.$milestone->id: 'add'; ?>" method="post" class="default">
		<h2><?php echo $milestone->id ? 'Edit this': 'Add a new'; ?> milestone</h2>
		<div class="left border-right">
			<label>When's it due?</label>
			<input type="hidden" name="milestone[due_on]" id="milestone-due_on" value="<?php echo $milestone->due_on; ?>" />
			<div class="calendar"></div>
			<script type="text/javascript">
				$('#add-milestone .calendar').calendarLite({
					<?php if ($milestone->id) echo 'year:'.date('Y', strtotime($milestone->due_on)).', month:'.(date('n', strtotime($milestone->due_on))-1).', day:'.date('j', strtotime($milestone->due_on)).','; ?>
					onSelect: function(date) { $('#milestone-due_on').val(date); return false; }
				});
			</script>
		</div>
		<div class="left">
			<label>Enter a title <small>(eg. Design review 2)</small></label>
			<input type="text" class="text title" name="milestone[title]" maxlength="100" value="<?php echo $milestone->title; ?>" />
		
			<label>Who's responsible?</label>
			<select name="milestone[assigned_to]">
				<option value="0">NONE</option>
				<?php echo users_select_option($milestone->assigned_to); ?>
			</select>
		
			<div class="buttons">
				<button type="submit"><?php echo $milestone->id ? 'Save Changes': 'Create this milestone'; ?></button> or
				<a href="project/<?php echo $project->id; ?>/milestone">Cancel</a>
			</div>
		</div>
	</form>
</div>