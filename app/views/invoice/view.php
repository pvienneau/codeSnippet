<div class="content" id="view_invoice_section">
<?php if(AuthUser::accessLevel("invoices") > 1): ?>
<div id="update_sidebar">
	<ul class="sidebar" id="<?php echo $invoice->id; ?>">
		<li><a href="#" id="send"><?php echo __('Send Invoice');?></a></li>
		<li><a href="invoice/download/<?php echo $invoice->id; ?>" id="download"><?php echo __('Download PDF');?></a></li>
		<li><a href="#" id="payment"><?php echo __('Add Payment');?></a></li>
		<li><a href="#" id="history"><?php echo __('View History');?></a></li>
		<li><a href="public/invoice/<?php echo $invoice->permalink; ?>" class="blank" id="permalink"><?php echo __('Permalink');?></a></li>
		<li><a href="invoice/edit/<?php echo $invoice->id; ?>" id="edit"><?php echo __('Edit Invoice');?></a></li>
		<li><a href="#" id="remove"><?php echo __('Remove Invoice');?></a></li>
	</ul>
</div>
<?php endif; ?>
<div id="update_send_dialog">

<div class="dialog" id="send_dialog" style="display: none">

<form action="invoice/send/<?php echo $invoice->id; ?>" method="post">

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
	<label><?php echo __('Send a copy to');?> <?php echo $company->email; ?></label>
</div>

<div class="more" style="display: none">

	<label>Sujet</label>
	<input type="text" name="subject" class="field" value="Facture <?php echo $invoice->invoice_id; ?>" />

	<label>Message</label>
<textarea name="message" class="textarea">Bonjour <?php echo $client->name; ?>,

Voici la facture de <?php echo my_number_format($invoice->total); ?> $.

Vous pouvez voir cette facture en ligne à l'adresse suivante:

<?php echo BASE_URL; ?>public/invoice/<?php echo $invoice->permalink; ?> 

Cordialement,
<?php echo $company->name; ?>
</textarea>

</div>

<a href="#" class="add_more">Edit email message…</a>

<div class="control">
	<input type="submit" class="button" id="send_invoice" value="Send" />
	<a class="small_button">Cancel</a>
</div>

</form>

</div>

</div>




<div id="update_thank_you_dialog"></div>


<div id="update_payment_dialog">
	<div class="dialog" id="payment_dialog" style="display: none">
		<form action="invoice/payment/<?php echo $invoice->id; ?>" method="post">

			<div class="selection">
				<div id="amount">
					<label><?php echo __('Amount');?></label>
					<input type="text" name="amount" class="field" value="<?php echo my_number_format($invoice->balance_due); ?>" />
				</div>

				<div id="date">
					<label><?php echo __('Date');?></label>
					<?php echo date_select(); ?>
				</div>
				
				<div id="description">
					<label style="width:100%"><?php echo __('Description');?></label><br />
					<input style="width:100%" type="text" name="description" class="field" value="" />
				</div>
				
			</div>

			<div class="control">
				<input type="submit" class="button" id="add_payment" value="<?php echo __('Add Payment');?>" />
				<a class="small_button"><?php echo __('Cancel');?></a>
			</div>

		</form>
	</div>
</div>





<div id="update_history_dialog">
	<div class="dialog" id="history_dialog" style="display: none">
<?php foreach ($histories as $history): ?>
		<div class="row">
			<h3><?php echo my_date_format($history->date); ?></h3>
			<p><?php echo $history->event; ?></p>
			<p><?php echo $history->description; ?></p>
<?php if (strpos($history->event, 'Payment') !== false): ?>
			<a id="<?php echo $history->id; ?>" class="remove_payment" href="#"><?php echo __('Remove this payment');?></a>
<?php endif; ?>
		</div>
<?php endforeach; ?>
		<a href="#" class="small_button" id="close"><?php echo __('Close');?></a>
	</div>
</div>

<div id="update_invoice">






<div class="invoice_text_normal" id="invoice">

<div id="badge" class="<?php echo $invoice->status; ?>"></div>

<div id="holder">
	
<div id="invoice_head">
	
<div id="invoice_logo"><h1 id="logo"><?php echo $company->name; ?></h1></div>
	
<div id="details">

	<div class="left">
		<p><?php echo __('Invoice ID');?></p>
		<p><?php echo __('Date Of Invoice');?></p>
		<p><?php echo __('Payment Is Due');?></p>
		<?php if(($recurring = RecurringHistory::ofInvoice($invoice->id)) && (AuthUser::accessLevel("recurrings") > 0)):?>
			<p><a href="recurring/view/<?php echo $recurring->recurring_id;?>"><?php echo __('Recurring invoice');?></a></p>
		<?php endif; ?>
	</div>
	
	<div class="right invoice_text_light">
		<p><?php echo $invoice->invoice_id; ?></p>
		<p><?php echo my_date_format($invoice->date); ?></p>
		<p><?php echo my_date_format($invoice->due_date); ?> (<?php echo $invoice->due; ?> <?php echo __('days');?>)</p>
	</div>


</div>

</div>

<div id="address">

<div id="to">
	<h3><?php echo __('To');?></h3>
	<p><strong><?php echo empty($client->company) ? $client->name: $client->company; ?></strong></p>

<?php

if (!empty($client->address_line_1))
	echo '<p>'.$client->address_line_1.'</p>';
if (!empty($client->address_line_2))
	echo '<p>'.$client->address_line_2.'</p>';
if (!empty($client->city) || !empty($client->state))
	echo '<p>'.$client->city.', '.$client->state.'</p>';
if (!empty($client->zip_code))
	echo '<p>'.$client->zip_code.'</p>';
if ($invoice->display_country && !empty($client->country))
	echo '<p>'.$client->country.'</p>';

?>

</div>


<div id="from">
	<h3><?php echo __('From');?></h3>
	<p><strong><?php echo $company->name; ?></strong></p>
<?php

if (!empty($company->address_line_1))
	echo '<p>'.$company->address_line_1.'</p>';
if (!empty($company->address_line_2))
	echo '<p>'.$company->address_line_2.'</p>';
if (!empty($company->city) || !empty($company->state))
	echo '<p>'.$company->city.' '.$company->state.'</p>';
if (!empty($company->zip_code))
	echo '<p>'.$company->zip_code.'</p>';
if ($invoice->display_country && !empty($company->country))
	echo '<p>'.$company->country.'</p>';

?>
</div>




</div>

<div id="lines">
	
	<ul>
		<li class="invoice_bar" id="bar">
			<span class="description"><?php echo __('Description');?></span>
			<span class="qty"><?php echo __('Qty');?></span>
			<span class="price"><?php echo __('Price');?></span>
			<span class="total"><?php echo __('Total');?></span>
		</li>
<?php foreach($lines as $index => $line): ?>
		<li class="line invoice_line<?php if ($index % 2) echo ' alt'; ?>">
			<span class="description"><?php echo $line->description; ?></span>
			<span class="qty"><?php echo my_qty_format($line->qty).' '.$line->kind.($line->qty>1?'s':''); ?></span>
			<span class="price"><?php echo my_number_format($line->price); ?></span>
			<span class="total"><?php echo my_number_format($line->total); ?> $</span>
		</li>
<?php endforeach; ?>
	</ul>
	<div id="subtotal">
		<div class="left">
		<?php if ($invoice->management) echo "<p>".__('Project Management')." ({$invoice->management}%)</p>"; ?>
		<?php if ($invoice->subtotal != $invoice->total): ?>
			<p><?php echo __('Subtotal');?></p>
			<?php if ($invoice->discount) echo "<p>".__('Discount')." ({$invoice->discount}%)</p>"; ?>
			<?php if ($invoice->tax) echo "<p>{$invoice->tax_name} ({$invoice->tax}%)</p>"; ?>
			<?php if ($invoice->tax2) echo "<p>{$invoice->tax2_name} ({$invoice->tax2}%)</p>"; ?>
			<?php if ($invoice->shipping) echo "<p>".__('Shipping')."</p>"; ?>
		<?php endif; ?>
			<p class="total"><?php echo __('Total');?></p>
			<?php if ($invoice->paid) echo "<p>Paid</p>"; ?>
			<?php if ($invoice->paid && $invoice->paid < $invoice->total) echo "<p>Balance Due</p>"; ?>
		</div>
		<div class="right invoice_text_light">
		<?php if ($invoice->management) echo '<p>'.my_number_format($invoice->management_fee).' $</p>'; ?>
		<?php if ($invoice->subtotal != $invoice->total): ?>
			<p><?php echo my_number_format($invoice->subtotal); ?> $</p>
			<?php if ($invoice->discount) echo '<p>-'.my_number_format($invoice->discount_fee).' $</p>'; ?>
			<?php if ($invoice->tax) echo '<p>'.my_number_format($invoice->tax_fee).' $</p>'; ?>
			<?php if ($invoice->tax2) echo '<p>'.my_number_format($invoice->tax2_fee).' $</p>'; ?>
			<?php if ($invoice->shipping) echo '<p>'.my_number_format($invoice->shipping).' $</p>'; ?>
		<?php endif; ?>
			<p class="total invoice_total"><?php echo my_number_format($invoice->total); ?> $</p>
			<?php if ($invoice->paid) echo '<p>'.my_number_format($invoice->paid).' $</p>'; ?>
			<?php if ($invoice->paid && $invoice->paid < $invoice->total) echo '<p>'.my_number_format($invoice->balance_due).' $</p>'; ?>
		</div>
	</div>
<?php if (!empty($invoice->notes)): ?>
	<div class="invoice_notes" id="notes">
		<h3><?php echo __('Notes');?></h3>
		<p><?php echo nl2br($invoice->notes); ?></p>
	</div>
<?php endif; ?>
</div>

</div>
<div class="invoice_text_light" id="invoice_foot"><?php echo __('This account is payable upon reception of this invoice. After 30 days, an interest of 1.5% per month (18% per year) will be added to any unpaid balance.');?></div>

</div></div>

</div>