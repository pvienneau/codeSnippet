<html><head>

<title><?php echo $company->name; ?> | Estimate <?php echo $estimate->estimate_id; ?></title>

<meta http-equiv="content-type" content="text/html; charset=utf-8">
<meta http-equiv="content-language" content="en-us">
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
table.head {
	margin-bottom:1em;
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
		<td class="right"><b>Devis</b></td>
		<td><?php echo $estimate->estimate_id; ?></td>
	</tr>
	<tr>
		<td class="right"><b>Date</b></td>
		<td><?php echo my_date_format($estimate->date); ?></td>
	</tr>
	<tr>
		<td class="right"><b>Responsable</b></td>
		<td><?php echo $user->name; ?></td>
	</tr>
</table>

<?php if (!empty($estimate->notes)): ?>
<br />
<div class="notes">
	<b>D&eacute;tails</b><br />
	<?php echo nl2br($estimate->notes); ?>
</div>
<?php endif; ?>

<table class="lines">
	<tr>
		<th width="15%">Qt&eacute;</th>
		<th width="50%">Description</th>
		<th width="15%">Prix</th>
		<th width="20%" class="right">Total</th>
	</tr>

<?php $subtotal = 0; foreach($lines as $index => $line): $subtotal += $line->total; ?>
	<tr>
		<td><?php echo $line->qty.' '.$line->kind; ?></td>
		<td><?php echo $line->description; ?></td>
		<td><?php echo my_number_format($line->price, 2); ?></td>
		<td class="right"><?php echo my_number_format($line->total, 2); ?> $</td>
	</tr>
<?php endforeach; ?>

	<tr>
		<td colspan="2"></td>
		<td><h2>Total</h2></td>
		<td class="right"><h2><?php echo my_number_format($estimate->total, 2); ?> $</h2></td>
	</tr>
</table>


</body>
</html>