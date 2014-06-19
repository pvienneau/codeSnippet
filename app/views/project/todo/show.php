<div id="todo-<?php echo $todo->id ?>" class="todo">
	<h2><?php echo $todo->name; ?>
		<div class="actions show-over">
			<a href="<?php url('todo/delete/'.$todo->id); ?>" class="delete"><img src="images/project/trash.gif" width="10" height="11" alt="Delete"></a>
			<a href="<?php url('todo/edit/'.$todo->id); ?>" class="edit">edit</a>
		</div>
	</h2>
	<ul class="todo-open no-style">
<?php foreach (TodoItem::openFromTodo($todo->id) as $item): ?>
		<li>
			<input type="checkbox" value="<?php echo $item->id; ?>"> <?php if ($item->assigned_to) { echo '<b>'.$item->assigned_name.'</b> '; } echo $item->description; ?>
			<a href="<?php url('comment/show/todo_item/'.$item->id); ?>" class="show-over"><img src="images/project/comments-empty.gif" width="13" height="13" alt="Comments"></a>
			<div class="actions show-over">
				<a href="<?php url('todo/delete_item/'.$item->id); ?>" class="delete"><img src="images/project/trash.gif" width="10" height="11" alt="Delete"></a>
				<a href="<?php url('todo/edit_item/'.$item->id); ?>" class="edit">edit</a>
				<a href="<?php url('todo/edit_item/'.$item->id); ?>" class="drag"><img src="images/project/drag_handle.gif" width="11" height="11" alt="Drag Handle"></a>
			</div>
		</li>
<?php endforeach; ?>
	</ul>
	<div class="add-item">
		<a href="#">Add an item</a>
		<form action="todo/add_item/<?php echo $todo->id; ?>" method="post" class="default hide">
			<div class="left border-right">
				<label>When's it due?</label>
				<input type="hidden" name="item[due_on]" id="item-due_on-<?php echo $todo->id ?>" />
				<div class="calendar"></div>
				<div class="center"><a href="#" class="reset-due">No due date</a></div>
				<script type="text/javascript">
					$('#todo-<?php echo $todo->id ?> .calendar').calendarLite( { onSelect: function(date) { $('#item-due_on-<?php echo $todo->id ?>').val(date); return false; }});
				</script>
			</div>
			
			<div class="left">
				<label>Enter a to-do item</label>
				<textarea name="item[description]" maxlegth="255"></textarea>
				
				<label>Who's responsible?</label>
				<select name="item[assigned_to]">
					<option value="0">Anyone</option>
					<?php echo users_select_option(); ?>
				</select>
				
				<div class="buttons">
					<button type="submit">Add this item</button> or
					<a href="#">I'm done adding items</a>
				</div>
			</div>
		</form>
	</div>
	<ul class="todo-done no-style">
<?php foreach (TodoItem::doneFromTodo($todo->id) as $item): ?>
		<li>
			<input type="checkbox" checked="checked" value="<?php echo $item->id; ?>"> <i class="date"><?php echo my_date_format($item->done_on, false); ?></i> <?php if ($item->assigned_to) { echo '<b>'.$item->assigned_name.'</b> '; } echo $item->description; ?>
			<a href="<?php url('comment/show/todo_item/'.$item->id); ?>" class="show-over"><img src="images/project/comments-empty.gif" width="13" height="13" alt="Comments"></a>
			<div class="actions show-over">
				<a href="<?php url('todo/delete_item/'.$item->id); ?>" class="delete"><img src="images/project/trash.gif" width="10" height="11" alt="Delete"></a>
				<a href="<?php url('todo/edit_item/'.$item->id); ?>" class="edit">edit</a>
				<a href="<?php url('todo/edit_item/'.$item->id); ?>" class="drag"><img src="images/project/drag_handle.gif" width="11" height="11" alt="Drag Handle"></a>
			</div>
		</li>
<?php endforeach; ?>
	</ul>
	
</div><!-- end .todo -->
