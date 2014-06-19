<?php use_helper('Date'); ?>

<div id="comment">
<?php if ($object == 'milestone'): ?>
	<div class="box">
		<h2>Comments on this milestone <a href="project/<?php echo $project->id ?>/milestone">&larr; back to milestones</a></h2>
		<div class="meta">
			<b class="date"><?php echo pretty_date(strtotime($milestone->due_on)); ?></b> 
			<span class="date">(<?php echo my_full_date_format($milestone->due_on); ?>)</span>
		</div>
		<?php echo $milestone->title; ?>
	</div>
	
<?php elseif ($object == 'todo_list'): ?>
	<h2><a href="project/<?php echo $project->id ?>/todo">&larr; back to to-do list</a></h2>
	<?php echo $todo_list->description ?>
<?php endif; ?>

<div class="comments">
	<div class="wrapper">
		<form action="comment/add" method="post">
			<input type="hidden" name="project_id" value="<?php echo $project->id; ?>" />
			<input type="hidden" name="comment[object]" value="<?php echo $object; ?>" />
			<input type="hidden" name="comment[object_id]" value="<?php echo $object_id; ?>" />
	
			<label for="comment_message">Comment</label>
	
			<textarea name="comment[message]" class="textarea small" id="comment_message"></textarea>
			<button type="submit" class="button">Post</button>
		</form>
		
		<ul class="no-style">
<?php foreach(Comment::findAll($object, $object_id) as $comment): ?>
			<li>
				<p><b><?php echo $comment->user_name; ?></b> <?php echo $comment->message; ?></p>
				<h5><?php echo my_datetime_format($comment->created_on); ?></h5>
			</li>
<?php endforeach; ?>
		</ul>
	</div>
</div>
</div><!-- end #comment -->