<html><head>
<title><?php echo $company->name; ?> | <?php echo __('Estimate').' '.$estimate->estimate_id; ?></title>

<style type="text/css">

body {
	padding: 20px 30px;
	font-family: "decima", sans-serif;
	font-size: 7px;
	line-height: 11px;
	min-height: 650px;
	text-transform:uppercase;
}
h1 {
	margin:0;
	padding:0;
	font-size:14px;
}
h2 {
	margin:0;
	padding:40px 0;
	font-size:14px;
	font-weight:normal;
}
b { color:#777; }
table {
	width: 100%;
	border-collapse: collapse;
}
table.layout .one { width:18%; }
table.layout .two { padding:0 0 0 5%; width:57%; }


table.lines {
	border-collapse: collapse;
}
table.lines th {
	padding:0 0 5px 0;
	border-bottom:1pt solid #000;
	border-left:0;
	border-right:0;
	border-top:0;
	text-align: left;
	color:#777;
}
table.lines td {
	padding:9px 0 9px 0;
	border-bottom:1pt solid #000;
}
table.foot { padding-top:14px; padding-bottom:14px; }
table.foot td { padding:0; }
table.foot .subtotal td { font-weight:bold }
table .total td { padding:8px 0 16px 0; border-top:3pt solid #000; border-bottom:3pt solid #000; }
table .total h1 { margin:0;padding:0; font-size:12px }
table .right { text-align: right; }

div.notes {
	padding:25px 0;
}


</style>
</head><body>

	<table class="layout">
		<tr>
			<td class="one"><img src="<?php echo dirname(__FILE__); ?>/../invoice/small-carbure.jpg" /></td>
			<td class="two">
				<h1><?php echo mb_strtoupper(__('Estimate'), 'UTF-8'); ?></h1>
				<h2><?php echo mb_strtoupper($estimate->project_name, 'UTF-8'); ?></h2>
			</td>
		</tr>
		<tr>
			<td class="one">
				<b><?php echo mb_strtoupper(__('From'), 'UTF-8'); ?></b><br />
				<?php echo mb_strtoupper($company->name, 'UTF-8'); ?>
				<?php

				if (!empty($company->address_line_1))
					echo '<br />'.mb_strtoupper($company->address_line_1, 'UTF-8');
				if (!empty($company->address_line_2))
					echo '<br />'.mb_strtoupper($company->address_line_2, 'UTF-8');
				if (!empty($company->city) || !empty($company->state))
					echo '<br />'.mb_strtoupper($company->city.' '.$company->state, 'UTF-8');
				if (!empty($company->zip_code))
					echo '<br />'.mb_strtoupper($company->zip_code, 'UTF-8');
				if ($estimate->display_country && !empty($company->country))
					echo '<br />'.mb_strtoupper($company->country, 'UTF-8');
				if (!empty($company->phone_number))
					echo '<br />T: '.$company->phone_number;

				?>
				<br /><br />

				<b><?php echo mb_strtoupper(__('To'), 'UTF-8'); ?></b><br />
				<?php echo empty($client->company) ? mb_strtoupper($client->name, 'UTF-8'): mb_strtoupper($client->company, 'UTF-8'); ?>

				<?php

				if (!empty($client->address_line_1))
					echo '<br />'.mb_strtoupper($client->address_line_1, 'UTF-8');
				if (!empty($client->address_line_2))
					echo '<br />'.mb_strtoupper($client->address_line_2, 'UTF-8');
				if (!empty($client->city) || !empty($client->state))
					echo '<br />'.mb_strtoupper($client->city.' '.$client->state, 'UTF-8');
				if (!empty($client->zip_code))
					echo '<br />'.mb_strtoupper($client->zip_code, 'UTF-8');
				if ($estimate->display_country && !empty($client->country))
					echo '<br />'.mb_strtoupper($client->country, 'UTF-8');

				?>
				<br /><br />

				<b><?php echo mb_strtoupper(__('Estimate ID'), 'UTF-8'); ?></b><br />
				<?php echo $estimate->estimate_id; ?><br />
				<br />

				<b><?php echo mb_strtoupper(__('Date Of Estimate'), 'UTF-8'); ?></b><br />
				<?php echo mb_strtoupper(my_date_format($estimate->date), 'UTF-8'); ?><br />
				<br />

				<br />

				<?php if (!empty($company->tax_id)): ?>

				<b><?php echo mb_strtoupper(__('Tax ID'), 'UTF-8'); ?></b><br />
				<?php echo __('TPS'); ?> / <?php echo $GLOBALS['config']['tax_id'][1]; ?><br />
				<?php echo __('TVQ'); ?> / <?php echo $GLOBALS['config']['tax_id'][2]; ?><br />
				<br />

				<?php endif; ?>
			</td>
			<td class="two">

				<table class="lines" cellspacing="0" cellspacing="0">
					<tr>
						<th width="80%"><?php echo mb_strtoupper(__('Description'), 'UTF-8'); ?></th>
						<th width="20%" class="right"><?php echo mb_strtoupper(__('Total'), 'UTF-8'); ?></th>
					</tr>

				<?php $subtotal = 0; foreach($lines as $index => $line): $subtotal += $line->total; ?>
					<tr>
						<td><?php echo wordwrap(mb_strtoupper($line->description, 'UTF-8'), 70, "<br />\n"); ?></td>
						<td class="right"><?php echo my_number_format($line->total, 2); ?> $</td>
					</tr>
				<?php endforeach; ?>
				</table>

				<table class="foot" cellspacing="0" cellspacing="0">
				<?php if ($estimate->management): ?>
					<tr>
						<td><?php echo mb_strtoupper(__('Project Management'), 'UTF-8'); ?> (<?php echo $estimate->management; ?>%)</td>
						<td class="right"><?php echo my_number_format($estimate->management_fee); ?> $</td>
					</tr>
				<?php endif; ?>
				<?php if ($estimate->subtotal != $estimate->total): ?>
					<tr class="subtotal">
						<td><?php echo mb_strtoupper(__('Total'), 'UTF-8'); ?> <?php echo mb_strtoupper(__('(TAXES NOT INCLUDED)'), 'UTF-8'); ?></td>
						<td class="right"><?php echo my_number_format($estimate->subtotal); ?> $</td>
					</tr>

				<?php endif; ?>
				</table>
<?php if (!empty($options)): ?>
				<h2><?php echo __('Option'); ?></h2>
				<table class="lines" cellspacing="0" cellspacing="0">
					<tr>
						<th width="80%"><?php echo mb_strtoupper(__('Option'), 'UTF-8'); ?></th>
						<th width="20%" class="right"><?php echo mb_strtoupper(__('Total'), 'UTF-8'); ?></th>
					</tr>

				<?php foreach($options as $index => $line): ?>
					<tr>
						<td><?php echo wordwrap(mb_strtoupper($line->description, 'UTF-8'), 70, "<br />\n"); ?></td>
						<td class="right"><?php echo my_number_format($line->total, 2); ?> $</td>
					</tr>
				<?php endforeach; ?>
				</table>
<?php endif; ?>

				<?php if (!empty($estimate->notes)): ?>
				<div class="notes">
					<b><?php echo mb_strtoupper(__('Notes'), 'UTF-8'); ?></b><br />
					<?php echo mb_strtoupper(nl2br($estimate->notes), 'UTF-8'); ?>
				</div>
				<?php endif; ?>

			</td>
		</tr>
	</table>

	<script type="text/php">
	if ( isset($pdf) ) {
		// // Open the object: all drawing commands will
		// // go to the object instead of the current page
		// $footer = $pdf->open_object();
		// 
		// $w = $pdf->get_width();
		// 
		// // Add an initals box
		// 
		// $pdf->filled_rectangle(186, 719, 388, 40, array(.95,.95,.95));
		// 
		// $size = 6.6;
		// $font = Font_Metrics::get_font("decima");
		// $text1 = mb_strtoupper(__('This account is payable upon reception of this invoice. After 30 days, an interest '), 'UTF-8');
		// $text2 = mb_strtoupper(__('of 1.5% per month (18% per year) will be added to any unpaid balance.'), 'UTF-8');
		// $width = Font_Metrics::get_text_width($text1, $font, $size);
		// 
		// $pdf->text(($w - $width)/2 + 75, 728, $text1, $font, $size, array(0,0,0));
		// $width = Font_Metrics::get_text_width($text2, $font, $size);
		// 
		// $pdf->text(($w - $width)/2 + 75, 738, $text2, $font, $size, array(0,0,0));
		// 
		// // Close the object (stop capture)
		// $pdf->close_object();
		// 
		// // Add the object to every page. You can
		// // also specify "odd" or "even"
		// $pdf->add_object($footer, "all");
		// 
		// //$font = Font_Metrics::get_font("decima");
		// //$pdf->page_text(26, 745, mb_strtoupper(__('This account is payable upon reception of this invoice. After 30 days, an interest of 1.5% per month (18% per year) will be added to any unpaid balance.'), 'UTF-8'), $font, 6.6, array(.3,.3,.3));
		
		$font = Font_Metrics::get_font("decima");
		$pdf->page_text(56, 736, mb_strtoupper(__('Estimate accepted by:'), 'UTF-8'), $font, 7, array(0,0,0));
		$pdf->page_text(280, 736, mb_strtoupper(__('Signature:'), 'UTF-8'), $font, 7, array(0,0,0));
		$pdf->line(134, 745, 250, 745, array(0,0,0), .75);
		$pdf->line(324, 745, 440, 745, array(0,0,0), .75);
	}
	</script>


</body>
</html>