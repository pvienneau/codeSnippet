<html><head>
<title><?php echo $company->name; ?> | <?php echo __('Estimate').' '.$estimate->estimate_id; ?></title>

<style type="text/css">

body {
	padding: 20px 30px;
	font-family: helvetica, sans-serif;
	font-size: 9px;
	line-height: 12px;
	min-height: 650px;
}
h1 {
	font-size:18px;
}
h2 {
	font-size:13px;
}
table {
	width: 100%;
}
table.head {
	margin-bottom:1em;
}
table.head td {
	padding:0;
	line-height: 10px;
}
table.head td.right {
	padding-right: 15px;
}

table.addresses {
	margin-top: 1em;
	width: 80%;
}
table.addresses td {
	width: 50%;
}

table.lines {
	margin-top: 2em;
	margin-bottom: 1em;
	border-collapse: collapse;
	border-bottom:.5pt solid #ddd;
}
table.lines th {
	padding:6px 15px;
	border-bottom:1pt solid #ddd;
	border-top:1pt solid #ddd;
	border-left:0;
	border-right:0;
	background-color:#eee;
	text-align: left;
}
table.lines td {
	padding:3px 15px;
	border-top:1pt solid #f5f5f5;
}

table.options {
	padding:10pt;
	margin-top: 2em;
	margin-bottom: 1em;
	border-collapse: collapse;
	border-bottom:.5pt solid #ddd;
	background-color:#eee;
}
table.options th {
	padding:6px 15px;
	border-bottom:1pt solid #ddd;
	border-top:0;
	border-left:0;
	border-right:0;
	background-color:#fff;
	text-align: left;
}
table.options td {
	padding:3px 15px;
	border-top:1pt solid #ddd;
}

table.foot td {
	padding:0 12px;
}

table .right {
	text-align: right;
}

div.notes {
	padding:5px 15px;
	border-top:1pt solid #eee;
	border-bottom:1pt solid #f5f5f5;
	background-color: #fdfdfd;
}

</style>
</head><body>

<table class="head">
	<tr>
		<td rowspan="3"><h1><?php echo $company->name; ?></h1></td>
		<td class="right"><b><?php echo __('Estimate'); ?></b></td>
		<td><?php echo $estimate->estimate_id; ?></td>
	</tr>
	<tr>
		<td class="right"><b><?php echo __('Date'); ?></b></td>
		<td><?php echo my_date_format($estimate->date); ?></td>
	</tr>
	<tr>
		<td class="right"><b><?php echo __('Person in charge'); ?></b></td>
		<td><?php echo $user->name; ?></td>
	</tr>
</table>

<table class="addresses">
	<tr>
		<td>
			<big><b><?php echo __('To'); ?></b></big><br />
			<strong><?php echo empty($client->company) ? $client->name: $client->company; ?></strong>

<?php

if (!empty($client->address_line_1))
	echo '<br />'.$client->address_line_1;
if (!empty($client->address_line_2))
	echo '<br />'.$client->address_line_2;
if (!empty($client->city) || !empty($client->state))
	echo '<br />'.$client->city.' '.$client->state;
if (!empty($client->zip_code))
	echo '<br />'.$client->zip_code;
if ($estimate->display_country && !empty($client->country))
	echo '<br />'.$client->country;
	
?>
		</td>
		<td>
			<big><b><?php echo __('From'); ?></b></big><br />
			<strong><?php echo $company->name; ?></strong>
<?php

if (!empty($company->address_line_1))
	echo '<br />'.$company->address_line_1;
if (!empty($company->address_line_2))
	echo '<br />'.$company->address_line_2;
if (!empty($company->city) || !empty($company->state))
	echo '<br />'.$company->city.' '.$company->state;
if (!empty($company->zip_code))
	echo '<br />'.$company->zip_code;
if ($estimate->display_country && !empty($company->country))
	echo '<br />'.$company->country;
if (!empty($company->phone_number))
	echo '<br />T: '.$company->phone_number;

?>
		</td>
	</tr>
</table>

<?php if (!empty($estimate->notes)): ?>
<br />
<div class="notes">
	<b><?php echo __('Details'); ?></b><br />
	<?php echo nl2br($estimate->notes); ?>
</div>
<?php endif; ?>

<table class="lines">
	<tr>
		<th width="55%"><?php echo __('Description'); ?></th>
		<th width="15%"><?php echo __('Qty'); ?></th>
		<th width="15%"><?php echo __('Price'); ?></th>
		<th width="15%" class="right"><?php echo __('Total'); ?></th>
	</tr>

<?php foreach($lines as $index => $line): ?>
	<tr>
		<td><?php echo $line->description; ?></td>
		<td><?php echo $line->kind == 'service' ? $line->kind: my_qty_format($line->qty).' '. __($line->kind.($line->qty>1?'s':'')); ?></td>
		<td><?php echo my_number_format($line->price); ?></td>
		<td class="right"><?php echo my_number_format($line->total); ?> $</td>
	</tr>
<?php endforeach; ?>
</table>

<table class="foot">
<?php if ($estimate->management): ?>
	<tr>
		<td class="right"><?php echo __('Project Management'); ?> (<?php echo $estimate->management; ?>%)</td>
		<td class="right" width="20%"><?php echo my_number_format($estimate->management_fee); ?> $</td>
	</tr>
<?php endif; ?>
<?php /*if ($estimate->subtotal != $estimate->total):*/ ?>
	<tr>
		<td class="right"><h2><?php echo __('Total');/*__('Subtotal');*/ ?></h2></td>
		<td class="right" width="20%"><h2><?php echo my_number_format($estimate->subtotal); ?> $</h2></td>
	</tr>
	<tr>
		<td class="right" colspan="2">*<?php echo __('Applicable tax(es) not included'); ?></td>
	</tr>
	<?php /*if ($estimate->discount): ?>
	<tr>
		<td class="right"><?php echo __('Discount'); ?></td>
		<td class="right" width="20%"><?php echo my_number_format($estimate->dicount_fee); ?> $</td>
	</tr>
	<?php endif; ?>
	<?php if ($estimate->tax): ?>
	<tr>
		<td class="right"><?php echo $estimate->tax_name; ?></td>
		<td class="right" width="20%"><?php echo my_number_format($estimate->tax_fee); ?> $</td>
	</tr>
	<?php endif; ?>
	<?php if ($estimate->tax2): ?>
	<tr>
		<td class="right"><?php echo $estimate->tax2_name; ?></td>
		<td class="right" width="20%"><?php echo my_number_format($estimate->tax2_fee); ?> $</td>
	</tr>
	<?php endif; ?>
	<?php if ($estimate->shipping): ?>
	<tr>
		<td class="right"><?php echo __('Shipping'); ?></td>
		<td class="right" width="20%"><?php echo my_number_format($estimate->shipping); ?> $</td>
	</tr>
	<?php endif; */ ?>
<?php /*endif; /* ?>
	<tr>
		<td class="right"><h2><?php echo __('Total'); ?></h2></td>
		<td class="right" width="20%"><h2><?php echo my_number_format($estimate->total); ?> $</h2></td>
	</tr> */ ?>
</table>

<?php if (!empty($options)): ?>
<table class="options">
	<tr>
		<th width="55%"><?php echo __('Option'); ?></th>
		<th width="15%"><?php echo __('Qty'); ?></th>
		<th width="15%"><?php echo __('Price'); ?></th>
		<th width="15%" class="right"><?php echo __('Total'); ?></th>
	</tr>

<?php foreach ($options as $index => $line): ?>
	<tr>
		<td><?php echo $line->description; ?></td>
		<td><?php echo $line->kind == 'service' ? $line->kind: my_qty_format($line->qty).' '. __($line->kind.($line->qty>1?'s':'')); ?></td>
		<td><?php echo my_number_format($line->price); ?></td>
		<td class="right"><?php echo my_number_format($line->total); ?> $</td>
	</tr>
<?php endforeach; ?>
</table>
<?php endif; ?>

<script type="text/php">
if (isset($pdf)) {
	$font = Font_Metrics::get_font("helvetica");
	//$pdf->page_text(56, 680, __('Signature'), $font, 17, array(0,0,0));
	//$pdf->line(0, 701, 130, 701, array(0,0,0), .3);
	//$pdf->page_text(56, 710, __('Estimate accepted by:'), $font, 9, array(0,0,0));
	//$pdf->page_text(56, 726, __('Signature:'), $font, 9, array(0,0,0));
	//$pdf->line(160, 723, 280, 723, array(0,0,0), .5);
	//$pdf->line(160, 738, 280, 738, array(0,0,0), .5);
	//$pdf->page_text(56, 726, __('Signature'), $font, 17, array(0,0,0));
	$pdf->page_text(56, 736, __('Estimate accepted by:'), $font, 9, array(0,0,0));
	$pdf->page_text(256, 736, __('Signature:'), $font, 9, array(0,0,0));
	$pdf->line(140, 750, 250, 750, array(0,0,0), .5);
	$pdf->line(310, 750, 420, 750, array(0,0,0), .5);
}
</script>

</body>
</html>