<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>

	<title><?php echo $company->name . ' | ' . __('Estimate') .' '. $estimate->estimate_id; ?></title>

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
	<!--a href="public/payment/<?php echo $estimate->permalink; ?>" class="button" id="pay_with_paypal">Pay with PayPal</a-->
	<a href="public/download_estimate/<?php echo $estimate->permalink; ?>" class="button"><?php echo __('Download PDF'); ?></a>
</div>


<div class="invoice_text_normal" id="invoice">


<div id="holder">
	
<div id="invoice_head">
	
<div id="invoice_logo">
	<h1 id="logo"><?php echo $company->name; ?></h1>
</div>
	
<div id="details">

<div class="left">
	<h3><?php echo __('Estimate'); ?></h3>
	<p><?php echo __('Date'); ?></p>
	<p><?php echo __('Person in charge'); ?></p>
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
		<h3><?php echo __('Details'); ?></h3>
		<p><?php echo nl2br($estimate->notes); ?></p>
	</div>
<?php endif; ?>

<div id="lines">
	<ul>
		<li class="invoice_bar" id="bar">
			<span class="description"><?php echo __('Description'); ?></span>
			<span class="qty"><?php echo __('Qty'); ?></span>
			<span class="price"><?php echo __('Price'); ?></span>
			<span class="total"><?php echo __('Total'); ?></span>
		</li>
<?php foreach($lines as $index => $line): ?>
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
		<?php if ($estimate->management) echo "<p>".__('Project Management')." ({$estimate->management}%)</p>"; ?>
		<?php if ($estimate->subtotal != $estimate->total): ?>
			<p><?php echo __('Subtotal'); ?></p>
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
	<ul>
		<li class="option_bar" id="option_bar">
			<span class="description">Option</span>
			<span class="qty">Qty</span>
			<span class="price">Price</span>
			<span class="total">Total</span>
		</li>
<?php foreach($options as $index => $option): ?>
		<li class="option estimate_option<?php if ($index % 2) echo ' alt'; ?>">
			<span class="description"><?php echo $option->description; ?></span>
			<span class="qty"><?php echo my_qty_format($option->qty).' '.$option->kind.($option->qty>1?'s':''); ?></span>
			<span class="price"><?php echo my_number_format($option->price); ?></span>
			<span class="total"><?php echo my_number_format($option->total); ?> $</span>
		</li>
<?php endforeach; ?>
	</ul>
</div>
<?php endif; ?>


</div>


</div>
</div>

</body>
</html>