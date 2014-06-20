<form action="<?php echo get_url('code/new'); ?>" method="POST">
	<input name="title" type="text" placeholder="Title" /><br/>
	<input name="description" type="text" placeholder="Description" /><br/>
	<br/>
	<textarea name="content" placheolder="Write your code here"></textarea>
	<br/>
	<button type="submit" name="action_code_insert">Save</button>
</form>