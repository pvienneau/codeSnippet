<div class="content main_section" id="tasks_section">

<ul class="sidebar">
	<li><a href="#" id="timer">Timer</a></li>
</ul>

	
<h3 class="title">Clients / Tasks</h3>

<ul>
	<li id="bar">
		<span class="description">Description</span>
		<span class="hours">Hours</span>
		<span class="rate">Rate</span>
		<span class="total">Total</span>
		<span class="status">Status</span>
	</li>
</ul>

<ul class="rows">

<?php foreach ($clients as $client): ?>
	<li class="row" id="<?php echo $client->id; ?>">

		<span class="actions" style="display: none">
			<!--a href="#" class="remove">Remove</a-->
			<a href="client/edit/<?php echo $client->id; ?>" class="edit">Edit</a>
		</span>

		<span class="description"><?php echo $client->company; ?></span>
		<span class="hours"><?php echo $client->hours; ?></span>
		<span class="rate"><?php echo $client->rate; ?></span>
		<span class="total"><?php echo my_number_format($client->total); ?> $</span>
		<span class="status <?php echo $client->status; ?>"><?php echo ucfirst($client->status); ?></span>

	</li>
<?php endforeach; ?>
</ul>

</div>