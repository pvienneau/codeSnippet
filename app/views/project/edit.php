<div class="content edit_section" id="edit_project_section">

<?php include_view('client/update_new_dialog'); ?>
	
<h3 class="title">Edit Project</h3>

<div class="box">

<form action="project/edit/<?php echo $project->id; ?>" method="post">

	<div id="update_clients">
		<div class="inline">
			<label>Client</label>

			<div class="select_wrapper">
				<select name="client_id" class="select" id="client_select">
					<option value="new_client">New Client…</option>	
					<option value=""> </option>
					<?php echo clients_select_option($project->client_id); ?>
				</select>
			</div>
		</div>
	</div>

	<div class="inline">
		<label>Name</label>
		<input type="text" name="name" class="field" value="<?php echo $project->name; ?>" />
	</div>
	
	<div class="inline">
		<label class="optional">Description</label>
		<textarea name="description" class="textarea notes"><?php echo $project->description; ?></textarea>
	</div>

	<div class="inline">
		<label>Budgeted Hours</label>
		<input type="text" name="budgeted" class="field smallest" value="<?php echo $project->budgeted; ?>" />
	</div>

	<div class="inline">
		<label>Due On <small>(yyyy-mm-dd)</small></label>
		<input type="text" name="due_on" class="field" value="<?php echo $project->due_on; ?>" />
	</div>

	<div class="inline control">
		<input type="submit" class="button edit" value="Save Changes" />
	</div>

</form>

</div>

</div>