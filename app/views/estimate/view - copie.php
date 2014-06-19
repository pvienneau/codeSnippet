<div class="content" id="view_estimate_section">

<div id="update_sidebar">
	<ul class="sidebar" id="<?php echo $estimate->id; ?>">
		<li><a href="#" id="send">Send Estimate</a></li>
		<li><a href="estimate/download/<?php echo $estimate->id; ?>" id="download">Download PDF</a></li>
		<li><a href="#" id="history">View History</a></li>
		<li><a href="public/estimate/<?php echo $estimate->permalink; ?>" class="blank" id="permalink">Permalink</a></li>
		<li><a href="estimate/edit/<?php echo $estimate->id; ?>" id="edit">Edit Estimate</a></li>
		<li><a href="#" id="remove">Remove Estimate</a></li>
	</ul>
</div>

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
	<h3>Devis</h3>
	<p>Date</p>
	<p>Responsable</p>
</div>

<div class="right invoice_text_light">
	<h3><?php echo $estimate->estimate_id; ?></h3>
	<p><?php echo my_date_format($estimate->date); ?></p>
	<p><?php echo $user->name; ?></p>
</div>

</div>

</div>



<?php if (!empty($estimate->notes)): ?>
	<div class="invoice_notes" id="notes">
		<h3>Détails</h3>
		<p><?php echo nl2br($estimate->notes); ?></p>
	</div>
<?php endif; ?>

<div id="lines">
	
	<ul>
		<li class="invoice_bar" id="bar">
			<span class="qty">Qté</span>
			<span class="description">Description</span>
			<span class="price">Prix</span>
			<span class="total">Total</span>
		</li>
<?php $subtotal = 0; foreach($lines as $index => $line): $subtotal += $line->total; ?>
		<li class="line invoice_line<?php if ($index % 2) echo ' alt'; ?>">
			<span class="qty"><?php echo $line->qty.' '.$line->kind; ?></span>
			<span class="description"><?php echo $line->description; ?></span>
			<span class="price"><?php echo my_number_format($line->price); ?></span>
			<span class="total"><?php echo my_number_format($line->total); ?> $</span>
		</li>
<?php endforeach; ?>
	</ul>
	<div id="subtotal">
		<div class="left">
		<?php if ($subtotal != $estimate->total): ?>
			<p>Subtotal</p>
			<?php if ($estimate->discount) echo "<p>Discount ({$estimate->discount}%)</p>"; ?>
			<?php if ($estimate->tax) echo "<p>{$estimate->tax_name} ({$estimate->tax}%)</p>"; ?>
			<?php if ($estimate->shipping) echo "<p>Tvq (7%)</p>"; ?>
		<?php endif; ?>
			<p class="total">Total</p>
		</div>
		<div class="right invoice_text_light">
		<?php if ($subtotal != $estimate->total): ?>
			<p><?php echo my_number_format($subtotal, 2); ?></p>
			<?php if ($estimate->discount) echo '<p>-'.my_number_format($subtotal*($estimate->discount/100)).' $</p>'; ?>
			<?php if ($estimate->tax) echo '<p>'.my_number_format($subtotal*($estimate->tax/100)).' $</p>'; ?>
			<?php if ($estimate->shipping) echo '<p>'.my_number_format($estimate->shipping).' $</p>'; ?>
		<?php endif; ?>
			<p class="total invoice_total"><?php echo my_number_format($estimate->total); ?> $</p>
		</div>
	</div>

</div>

</div>

</div></div>

</div>