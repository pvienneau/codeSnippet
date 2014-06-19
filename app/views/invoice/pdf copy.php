<html><head>

<title><?php echo $company->name .' | '.__('Invoice').' '. $invoice->invoice_id; ?></title>

<style type="text/css">

body {
	padding: 20px 30px;
	font-family: helvetica, sans-serif;
	font-size: 10px;
	line-height: 14px;
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

table.head td {
	padding:0;
	line-height: 12px;
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
	margin-bottom: 3em;
	border-collapse: collapse;
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
	padding:5px 15px;
	border-top:1pt solid #f5f5f5;
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
		<td class="right"><b><?php echo __('Invoice ID'); ?></b></td>
		<td><?php echo $invoice->invoice_id; ?></td>
	</tr>
	<tr>
		<td class="right"><b><?php echo __('Date Of Invoice'); ?></b></td>
		<td><?php echo my_date_format($invoice->date); ?></td>
	</tr>
	<tr>
		<td class="right"><b><?php echo __('Payment Is Due'); ?></b></td>
		<td><?php echo my_date_format($invoice->due_date); ?> (<?php echo $invoice->due .' '. __('days'); ?>)</td>
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
if ($invoice->display_country && !empty($client->country))
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
if ($invoice->display_country && !empty($company->country))
	echo '<br />'.$company->country;

?>
		</td>
	</tr>
</table>

<table class="lines">
	<tr>
		<th width="15%"><?php echo __('Qty'); ?></th>
		<th width="50%"><?php echo __('Description'); ?></th>
		<th width="15%"><?php echo __('Price'); ?></th>
		<th width="20%" class="right"><?php echo __('Total'); ?></th>
	</tr>

<?php $subtotal = 0; foreach($lines as $index => $line): $subtotal += $line->total; ?>
	<tr>
		<td><?php echo $line->qty.' '.__($line->kind.($line->qty>1?'s':'')); ?></td>
		<td><?php echo $line->description; ?></td>
		<td><?php echo my_number_format($line->price, 2); ?></td>
		<td class="right"><?php echo my_number_format($line->total, 2); ?> $</td>
	</tr>
<?php endforeach; ?>

	<tr>
		<td colspan="2"></td>
		<td><h2><?php echo __('Total'); ?></h2></td>
		<td class="right"><h2><?php echo my_number_format($invoice->total, 2); ?> $</h2></td>
	</tr>
</table>

<?php if (!empty($invoice->notes)): ?>
<div class="notes">
	<b><?php echo __('Notes'); ?></b><br />
	<?php echo nl2br($invoice->notes); ?>
</div>
<?php endif; ?>

<script type="text/php">
if ( isset($pdf) ) {
	$font = Font_Metrics::get_font("helvetica");
	$pdf->page_text(26, 745, __('This account is payable upon reception of this invoice. After 30 days, an interest of 1.5% per month (18% per year) will be added to any unpaid balance.'), $font, 8.3, array(.3,.3,.3));
}
</script>


</body>
</html>