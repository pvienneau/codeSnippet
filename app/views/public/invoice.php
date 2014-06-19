<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>

	<title><?php echo $company->name . ' | ' . __('Invoice') . $invoice->invoice_id; ?></title>

	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
	<meta http-equiv="content-language" content="en-us" />
	
	<meta name="robots" content="noindex, nofollow" />
	<base href="<?php echo BASE_URL ?>">

	<link rel="stylesheet" type="text/css" media="all" href="css/foundation.css" />
	<link rel="stylesheet" type="text/css" media="all" href="css/permalink.css" />
	<link rel="stylesheet" type="text/css" media="all" href="css/invoice_grey.css" />

	<script type="text/javascript" src="js/jquery.js"></script>
	<script type="text/javascript" src="js/jquery.permalink.js"></script>

</head>

<body id="permalink">

<div id="container">

<div id="actions">
	<!--a href="public/payment/<?php echo $invoice->permalink; ?>" class="button" id="pay_with_paypal">Pay with PayPal</a-->
	<a href="public/download/<?php echo $invoice->permalink; ?>" class="button"><?php echo __('Download PDF'); ?></a>
</div>

<div id="message" style="display: none">
	<form action="public/payment/<?php echo $invoice->permalink; ?>" method="post">

		<label><?php echo __('Amount'); ?></label>
		<input type="text" name="amount" class="field" id="amount" value="<?php echo my_number_format($invoice->balance_due); ?>" />

		<input type="submit" class="button" id="pay" value="Pay Now" />
	</form>
</div>




<div class="invoice_text_normal" id="invoice">


<div id="holder">
	
<div id="invoice_head">
	
<div id="invoice_logo">
	<h1 id="logo"><?php echo $company->name; ?></h1>
</div>
	
<div id="details">

<div class="left">
<p><?php echo __('Invoice ID'); ?></p>
<p><?php echo __('Date Of Invoice'); ?></p>
<p><?php echo __('Payment Is Due'); ?></p>
</div>

<div class="right invoice_text_light">
	<p><?php echo $invoice->invoice_id; ?></p>
	<p><?php echo my_date_format($invoice->date); ?></p>
	<p><?php echo my_date_format($invoice->due_date); ?> (<?php echo $invoice->due .' '. __('days'); ?>)</p>
</div>

</div>

</div>

<div id="address">

<div id="to">
<h3><?php echo __('To'); ?></h3>
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
if ($invoice->display_country && !empty($client->country))
echo '<p>'.$client->country.'</p>';

?>
</div>


<div id="from">
<h3><?php echo __('From'); ?></h3>
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
			<span class="description"><?php echo __('Description'); ?></span>
			<span class="qty"><?php echo __('Qty'); ?></span>
			<span class="price"><?php echo __('Price'); ?></span>
			<span class="total"><?php echo __('Total'); ?></span>
		</li>
<?php $subtotal = 0; foreach($lines as $index => $line): $subtotal += $line->total; ?>
		<li class="line invoice_line<?php if ($index % 2) echo ' alt'; ?>">
			<span class="description"><?php echo $line->description; ?></span>
				<span class="qty"><?php echo my_qty_format($line->qty).' '.__($line->kind.($line->qty>1?'s':'')); ?></span>
			<span class="price"><?php echo my_number_format($line->price); ?></span>
			<span class="total"><?php echo my_number_format($line->total); ?> $</span>
		</li>
<?php endforeach; ?>
	</ul>
	<div id="subtotal">
		<div class="left">
		<?php if ($invoice->management) echo "<p>".__('Project Management')." ({$invoice->management}%)</p>"; ?>
		<?php if ($invoice->subtotal != $invoice->total): ?>
			<p>Subtotal</p>
			<?php if ($invoice->discount) echo "<p>Discount ({$invoice->discount}%)</p>"; ?>
			<?php if ($invoice->tax) echo "<p>{$invoice->tax_name} ({$invoice->tax}%)</p>"; ?>
			<?php if ($invoice->tax2) echo "<p>{$invoice->tax2_name} ({$invoice->tax2}%)</p>"; ?>
			<?php if ($invoice->shipping) echo "<p>Shipping</p>"; ?>
		<?php endif; ?>
			<p class="total">Total</p>
			<?php if ($invoice->paid) echo "<p>Paid</p>"; ?>
			<?php if ($invoice->paid && $invoice->paid < $invoice->total) echo "<p>Balance Due</p>"; ?>
		</div>
		<div class="right invoice_text_light">
		<?php if ($invoice->management) echo '<p>'.my_number_format($invoice->management_fee).' $</p>'; ?>
		<?php if ($invoice->subtotal != $invoice->total): ?>
			<p><?php echo my_number_format($invoice->subtotal, 2); ?> $</p>
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
		<h3><?php echo __('Notes'); ?></h3>
		<p><?php echo nl2br($invoice->notes); ?></p>
	</div>
<?php endif; ?>
</div>
</div>

<div class="invoice_text_light" id="invoice_foot"><?php echo __('This account is payable upon reception of this invoice. After 30 days, an interest of 1.5% per month (18% per year) will be added to any unpaid balance.'); ?></div>


</div>
</div>

</body>
</html>