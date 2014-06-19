<h1>All Users</h1>

<ul>
	<?php foreach($users as $user): ?>
		<li>
			<?php echo $user->first_name; ?> <?php echo $user->last_name; ?>
		</li>
	<?php endforeach; ?>
</ul>
