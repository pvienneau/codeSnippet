<a href="project/<?php echo $project->id; ?>/todo/add" class="button right">Add a new Todo List</a>

<?php if (empty($todos)): ?>
	<p>There is no Todo List assigned to this project for the moment. If you want to be the first to add one, <a href="project/<?php echo $project->id; ?>/todo/add">click here</a>.</p>
<?php else: ?>
<?php foreach ($todos as $todo) include_view('project/todo/show', array('todo' => $todo)); ?>
<?php endif; ?>