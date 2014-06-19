<div class="content new_section" id="new_project_section" style="display: none">

<ul class="sidebar">
	<li><a href="#" id="cancel">Cancel</a></li>
</ul>

<?php /*include_view('client/update_new_dialog');*/ ?>

<h3 class="title">New Project</h3>

<div class="box">

<form action="project/from_estimate" method="post">

	<div class="inline">
		<label>From this Estimate</label>
		<div class="select_wrapper">
			<select name="estimate_id" class="select" id="estimate_select">
				<?php echo estimates_select_option(); ?>
			</select>
		</div>
	</div>
	
	<div class="inline">
		<label>Name</label>
		<input type="text" name="name" class="field" />
	</div>
	
	<div class="inline control">
		<input type="submit" class="button add" value="Add Project" />
	</div>

</form>

<!--form action="project/add" method="post">

	<div id="update_clients">
		<div class="inline">
			<label>Client</label>
			<div class="select_wrapper">
				<select name="client_id" class="select" id="client_select">
					<option value="new_client">New Client…</option>
					<option value=""  selected="selected"> </option>
					<?php echo clients_select_option(); ?>
				</select>
			</div>
		</div>
	</div>
	
	<div class="inline">
		<label>Name</label>
		<input type="text" name="name" class="field" />
	</div>
	
	<div class="inline">
		<label class="optional">Description</label>
		<textarea name="description" class="textarea notes"></textarea>
	</div>
	
	<div class="inline">
		<label>Hours</label>
		<input type="text" name="hours" class="field smallest" value="0.00" />
	</div>

	<div class="inline control">
		<input type="submit" class="button add" value="Add Project" />
	</div>

</form-->

</div>

</div><div class="content main_section" id="projects_section">

<ul class="sidebar">
	<li><a href="#" id="new">New Project</a></li>
	<li><a href="#" id="timer">Timer</a></li>
</ul>

	
<h3 class="title">Projects - <a href="project/dashboard">Dashboard</a></h3>

<ul>
	<li id="bar">
		<span class="description">Name</span>
		<span class="hours">Budgeted</span>
		<span class="rate">Logged</span>
		<span class="total">Due on</span>
		<!--span class="status">Status</span-->
	</li>
</ul>

<ul class="rows">

<?php foreach ($projects as $project): ?>
	<li class="row" id="<?php echo $project->id; ?>">
		<span class="actions" style="display: none">
			<a href="#" class="remove">Remove</a>
			<a href="project/edit/<?php echo $project->id; ?>" class="edit">Edit</a>
		</span>
		<a class="timer">go</a>
		<span class="description"><small><?php echo $project->client; ?></small><br /><a href="project/show/<?php echo $project->id; ?>"><?php echo $project->name; ?></a></span>
		<span class="hours"><?php echo $project->budgeted; ?></span>
		<span class="rate"><?php echo $project->loggedHours(); ?></span>
		<span class="total"><?php echo ($project->due_on == '0000-00-00' ? '--': my_date_format($project->due_on)); ?></span>
		<!--span class="status <?php echo $project->status; ?>"><?php echo ucfirst($project->status); ?></span-->
	</li>
<?php endforeach; ?>
</ul>

</div>