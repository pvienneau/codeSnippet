<?php use_helper('Date'); ?>

<div id="milestones">

<a href="project/<?php echo $project->id; ?>/milestone/add" class="button right">Add a new Milestone</a>

<h2>Milestone <small>(Today is <?php echo my_date_format(date('Y-m-d'), false); ?>)</small></h2>

<?php if (!empty($late)): ?>
<h3 class="late">Late</h3>
<ul class="no-style late">
<?php foreach($late as $milestone): ?>
	<li>
		<div class="meta">
			<b class="date"><?php echo pretty_date(strtotime($milestone->due_on)); ?></b> 
			<span class="date">(<?php echo my_full_date_format($milestone->due_on); ?>)</span>
			<?php echo $milestone->assigned_name; ?>
		</div>
		<input type="checkbox" value="<?php echo $milestone->id; ?>"> <?php echo $milestone->title; ?>
		<a href="<?php url('comment/show/milestone/'.$milestone->id); ?>" class="show-over"><img src="images/project/comments-empty.gif" width="13" height="13" alt="Comments"></a>
		<div class="actions show-over">
			<a href="<?php url('milestone/delete/'.$milestone->id); ?>" class="delete"><img src="images/project/trash.gif" width="10" height="11" alt="Delete"></a>
			<a href="<?php url('milestone/edit/'.$milestone->id); ?>" class="edit">edit</a>
		</div>
		<?php foreach(Todo::inMilestone($milestone->id) as $todo): ?>
			<div class="to-do<?php if ($todo->is_completed) echo ' done'; ?>">To-Do: <a href="project/<?php echo $project->id; ?>/todo/show/<?php echo $todo->id; ?>"><?php echo $todo->name; ?></a></div>
		<?php endforeach; ?>
	</li>
<?php endforeach; ?>
</ul>
<?php endif; ?>

<?php if (!empty($upcoming)): ?>
<h3 class="upcoming">Upcoming</h3>

<?php include_view('milestone/quick-table', array('upcoming' => $upcoming)); ?>

<ul class="no-style upcoming">
<?php foreach($upcoming as $milestone): ?>
	<li>
		<div class="meta">
			<b class="date"><?php echo my_full_date_format($milestone->due_on); ?></b> 
			<span class="date">(<?php echo pretty_date(strtotime($milestone->due_on)); ?>)</span>
			<?php echo $milestone->assigned_name; ?>
		</div>
		<input type="checkbox" value="<?php echo $milestone->id; ?>"> <?php echo $milestone->title; ?>
		<a href="<?php url('comment/show/milestone/'.$milestone->id); ?>" class="show-over"><img src="images/project/comments-empty.gif" width="13" height="13" alt="Comments"></a>
		<div class="actions show-over">
			<a href="<?php url('milestone/delete/'.$milestone->id); ?>" class="delete"><img src="images/project/trash.gif" width="10" height="11" alt="Delete"></a>
			<a href="<?php url('milestone/edit/'.$milestone->id); ?>" class="edit">edit</a>
		</div>
		<?php foreach(Todo::inMilestone($milestone->id) as $todo): ?>
			<div class="to-do<?php if ($todo->is_completed) echo ' done'; ?>">To-Do: <a href="project/<?php echo $project->id; ?>/todo/show/<?php echo $todo->id; ?>"><?php echo $todo->name; ?></a></div>
		<?php endforeach; ?>
	</li>
<?php endforeach; ?>
</ul>
<?php endif; ?>

<?php if (!empty($complete)): ?>
<h3 class="complete">Complete</h3>
<ul class="no-style complete">
<?php foreach($complete as $milestone): ?>
	<li>
		<div class="meta">
			<span class="date"><?php echo my_full_date_format($milestone->completed_on); ?></span>
			<?php echo $milestone->assigned_name; ?>
		</div>
		<input type="checkbox" checked="checked" value="<?php echo $milestone->id; ?>"> <?php echo $milestone->title; ?>
		<a href="<?php url('comment/show/milestone/'.$milestone->id); ?>" class="show-over"><img src="images/project/comments-empty.gif" width="13" height="13" alt="Comments"></a>
		<div class="actions show-over">
			<a href="<?php url('milestone/delete/'.$milestone->id); ?>" class="delete"><img src="images/project/trash.gif" width="10" height="11" alt="Delete"></a>
			<a href="<?php url('milestone/edit/'.$milestone->id); ?>" class="edit">edit</a>
		</div>
		<?php foreach(Todo::inMilestone($milestone->id) as $todo): ?>
			<div class="to-do<?php if ($todo->is_completed) echo ' done'; ?>">To-Do: <a href="project/<?php echo $project->id; ?>/todo/show/<?php echo $todo->id; ?>"><?php echo $todo->name; ?></a></div>
		<?php endforeach; ?>
	</li>
<?php endforeach; ?>
</ul>
<?php endif; ?>

</div><!-- end #milestones -->
<div id="sidebar">
	
	<a href="ical/project/<?php echo $project->id ?>" class="ical-link"><img src="images/project/ical.gif" width="17" height="19" alt="Ical" align="absmiddle"> Subscribe to iCalendar</a>
	
</div>