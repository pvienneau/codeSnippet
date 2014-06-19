<div class="content" id="view_estimate_section">
<?php if(AuthUser::accessLevel("estimates") > 1): ?>
<div id="update_sidebar">
	<ul class="sidebar" id="<?php echo $estimate->id; ?>">
	<?php if (!$estimate->invoiced): ?>
		<?php if ($estimate->status != 'accepted'): ?><li><a href="estimate/accepted/<?php echo $estimate->id; ?>" id="accepted">Accepted</a></li><?php endif; ?>
		<?php if ($estimate->status != 'refused'): ?><li><a href="estimate/refused/<?php echo $estimate->id; ?>" id="refused">Refused</a></li><?php endif; ?>
		<li><a href="#" id="send">Send Estimate</a></li>
	<?php endif; ?>
		<li><a href="estimate/download/<?php echo $estimate->id; ?>" id="download">Download PDF</a></li>
		<li><a href="#" id="history">View History</a></li>
		<li><a href="public/estimate/<?php echo $estimate->permalink; ?>" class="blank" id="permalink">Permalink</a></li>
		<li><a href="estimate/edit/<?php echo $estimate->id; ?>" id="edit">Edit Estimate</a></li>
	<?php //if ($estimate->status != 'sent' && $estimate->status != 'accepted' && !$estimate->invoiced): ?>
		<li><a href="#" id="remove">Remove Estimate</a></li>
	<?php //endif; ?>
	</ul>
</div>
<?php endif; ?>
<div id="update_send_dialog">

<div class="dialog" id="send_dialog" style="display: none">

<form action="estimate/send/<?php echo $estimate->id; ?>" method="post">

<!--div id="attachment">
	<div class="checkbox_wrapper">
		<input type="checkbox" name="attachment" class="checkbox" checked="checked" />
	</div>
	<label>Attach invoice as a PDF file.</label>
</div-->

<div id="copy">
	<div class="checkbox_wrapper">
		<input type="checkbox" name="copy" class="checkbox" />
	</div>
	<label>Send a copy to <?php echo $company->email; ?></label>
</div>

<div class="more" style="display: none">

	<label>Subject</label>
	<input type="text" name="subject" class="field" value="Devis <?php echo $estimate->estimate_id; ?>" />

	<label>Message</label>
<textarea name="message" class="textarea">Bonjour <?php echo $client->name; ?>,

Voici un devis de <?php echo my_number_format($estimate->total); ?> $.

Vous pouvez voir ce devis en ligne à l'adresse suivante:

<?php echo BASE_URL; ?>public/estimate/<?php echo $estimate->permalink; ?> 

Cordialement,
<?php echo $company->name; ?>
</textarea>

</div>

<a href="#" class="add_more">Edit email message…</a>

<div class="control">
	<input type="submit" class="button" id="send_estimate" value="Send" />
	<a class="small_button">Cancel</a>
</div>

</form>

</div>

</div>




<div id="update_thank_you_dialog"></div>



<div id="update_history_dialog">
	<div class="dialog" id="history_dialog" style="display: none">
<?php foreach ($histories as $history): ?>
		<div class="row">
			<h3><?php echo my_date_format($history->date); ?></h3>
			<p><?php echo $history->event; ?></p>
		</div>
<?php endforeach; ?>
		<a href="#" class="small_button" id="close">Close</a>
	</div>
</div>

<div id="update_estimate">




<div class="invoice_text_normal" id="invoice">

<div id="badge" class="<?php echo $estimate->status; ?>"></div>

<div id="holder">
	
<div id="invoice_head">
	
<div id="invoice_logo"><h1 id="logo"><?php echo $company->name; ?></h1></div>
	
<div id="details">

<div class="left">
	<h3>Estimate</h3>
	<p>Date</p>
	<p>Person in charge</p>
</div>

<div class="right invoice_text_light">
	<h3><?php echo $estimate->estimate_id; ?></h3>
	<p><?php echo my_date_format($estimate->date); ?></p>
	<p><?php echo $user->name; ?></p>
</div>

</div>

</div>

<div id="address">

<div id="to">
	<?php if (!empty($estimate->project_name)) echo '<h3>'.$estimate->project_name.'</h3>'; ?>
	<p><strong><?php echo empty($client->company) ? $client->name: $client->company; ?></strong></p>

<?php

if (!empty($client->address_line_1))
	echo '<p>'.$client->address_line_1.'</p>';
if (!empty($client->address_line_2))
	echo '<p>'.$client->address_line_2.'</p>';
if (!empty($client->city) || !empty($client->state))
	echo '<p>'.$client->city.' '.$client->state.'</p>';
if (!empty($client->zip_code))
	echo '<p>'.$client->zip_code.'</p>';
if (!empty($client->country))
	echo '<p>'.$client->country.'</p>';

?>

</div>
</div>

<?php if (!empty($estimate->notes)): ?>
	<div class="invoice_notes" id="notes">
		<h3>Details</h3>
		<p><?php echo nl2br($estimate->notes); ?></p>
	</div>
<?php endif; ?>

<div id="lines">
	
	<ul>
		<li class="invoice_bar" id="bar">
			<span class="description">Description</span>
			<span class="qty">Qty</span>
			<span class="price">Price</span>
			<span class="total">Total</span>
		</li>
<?php $total_hours = 0; foreach($lines as $index => $line): if ($line->kind == 'hour') $total_hours += $line->qty; ?>
		<li class="line invoice_line<?php if ($index % 2) echo ' alt'; ?>">
			<span class="description"><?php echo $line->description; ?></span>
			<span class="qty"><?php echo my_qty_format($line->qty).' '.$line->kind.($line->qty>1?'s':''); ?></span>
			<span class="price"><?php echo my_number_format($line->price); ?></span>
			<span class="total"><?php echo my_number_format($line->total); ?> $</span>
		</li>
<?php endforeach; ?>
		<li class="line invoice_line<?php if (!($index % 2)) echo ' alt'; ?>">
			<span class="description" style="text-align:right"><b>Total</b></span>
			<span class="qty"><b><?php echo my_qty_format($total_hours).' hour'.($total_hours>1?'s':''); ?></b></span>
			<span class="price"></span>
			<span class="total"></span>
		</li>
	</ul>
	<div id="subtotal">
		<div class="left">
		<?php if ($estimate->management) echo "<p>Project Management ({$estimate->management}%)</p>"; ?>
		<?php if ($estimate->subtotal != $estimate->total): ?>
			<p>Subtotal</p>
			<?php if ($estimate->discount) echo "<p>Discount ({$estimate->discount}%)</p>"; ?>
			<?php if ($estimate->tax) echo "<p>{$estimate->tax_name} ({$estimate->tax}%)</p>"; ?>
			<?php if ($estimate->tax2) echo "<p>{$estimate->tax2_name} ({$estimate->tax2}%)</p>"; ?>
			<?php if ($estimate->shipping) echo "<p>Shipping</p>"; ?>
		<?php endif; ?>
			<p class="total">Total</p>
		</div>
		<div class="right invoice_text_light">
		<?php if ($estimate->management) echo '<p>'.my_number_format($estimate->management_fee).' $</p>'; ?>
		<?php if ($estimate->subtotal != $estimate->total): ?>
			<p><?php echo my_number_format($estimate->subtotal); ?> $</p>
			<?php if ($estimate->discount) echo '<p>-'.my_number_format($estimate->discount_fee).' $</p>'; ?>
			<?php if ($estimate->tax) echo '<p>'.my_number_format($estimate->tax_fee).' $</p>'; ?>
			<?php if ($estimate->tax2) echo '<p>'.my_number_format($estimate->tax2_fee).' $</p>'; ?>
			<?php if ($estimate->shipping) echo '<p>'.my_number_format($estimate->shipping).' $</p>'; ?>
		<?php endif; ?>
			<p class="total invoice_total"><?php echo my_number_format($estimate->total); ?> $</p>
		</div>
	</div>

</div>

<?php if (!empty($options)): ?>
<div id="options">
	<h2>Options</h2>
	<ul>
		<li class="option_bar" id="option_bar">
			<span class="description">Description</span>
			<span class="qty">Qty</span>
			<span class="price">Price</span>
			<span class="total">Total</span>
		</li>
<?php foreach($options as $index => $option): ?>
		<li class="option estimate_option<?php if ($index % 2) echo ' alt'; ?>">
			<div class="checkbox_wrapper">
				<input type="checkbox" name="id" value="<?php echo $option->id; ?>" class="checkbox" title="accept this option" />
			</div>
			<span class="description"><?php echo $option->description; ?></span>
			<span class="qty"><?php echo my_qty_format($option->qty).' '.$option->kind.($option->qty>1?'s':''); ?></span>
			<span class="price"><?php echo my_number_format($option->price); ?></span>
			<span class="total"><?php echo my_number_format($option->total); ?> $</span>
		</li>
<?php endforeach; ?>
	</ul>
</div>
<?php endif; ?>

<?php if (!$estimate->invoiced && AuthUser::accessLevel("estimates") > 1): ?>
	<a href="estimate/to_invoice/<?php echo $estimate->id; ?>" class="small_button">Invoice Me</a>
<?php endif; ?>

</div>

</div></div>

</div>