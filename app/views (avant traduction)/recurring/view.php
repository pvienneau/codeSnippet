<div class="content " >

	<h3 class="title">View Recurring Template</h3>
	
	<div class="box" id="<?php echo $recurring->id; ?>">
	
	
	
		<div class="inline">
			<label>Name</label>
			<?php echo $recurring->name; ?>
		</div>
		
		<div class="inline">
			<label>Client</label>
			<?php echo $client->company; ?>
		</div>
		<div class="inline">
			<label>Contact</label>
			<a href="mailto:<?php echo $client->email; ?>"><?php echo $client->name; ?></a>
		</div>
		
		<div class="inline">
			<label>Schedule</label>
			<?php echo $recurring->schedule ?>
		
			<?php if($recurring->schedule == 'other'): ?> 
				: <?php echo $recurring->schedule_other ?> days
			<?php endif; ?>
		</div>
		
		<div class="inline">
			<label>Created on</label>
			<?php echo $recurring->date; ?>
		</div>
		<div class="inline">
			<label>Next Occurence</label>
			<?php echo $recurring->nextOccurence(); ?>
		</div>
	<div id="line_part">
	<ul>
		
		<li id="bar">
			<span class="qty">Qty</span>
			<span class="description">Description</span>
			<span class="price">Price</span>
			<span class="total">Total</span>
		</li>
		
		<?php foreach($lines as $index => $line): ?>
		<li class="line">
			<div style="float:left;width:40px;">&nbsp;</div>
		
			<span class="qty">
				<?php echo $line->qty; ?> <?php echo $line->kind; ?>
			</span>
		
			<span class="description"><?php echo $line->description; ?></span>
			<span class="price"><?php echo my_number_format($line->price); ?></span>
			<span class="total"><span class="total_line"><?php echo my_number_format($line->total); ?></span></span>
		
		</li>
		<?php endforeach; ?>
	
	</ul>
</div>	
		
	</div>
	
</div>

<?php if ($recurringInvoices && AuthUser::accessLevel("invoices") > 0):?>
<br style="clear:both;" /><br />
<div class="content main_section" id="invoices_section">
<h3 class="title">Invoices</h3>
	
	
	<ul>
		<li id="bar">
			<span class="id">ID</span>
			<span class="date">Invoice Date</span>
			<span class="client">Recurring Date</span>
			<span class="amount">Amount</span>
			<span class="status">Status</span>
		</li>
	</ul>
	
	<ul class="rows">
	
		<?php 
		$total = 0; 
		$total_paid = 0; 
		foreach($recurringInvoices as $invoice): 
			$total += $invoice->total; 
			$total_paid += $invoice->paid; ?>
			<li class="row" id="<?php echo $invoice->id; ?>">
	
		
				<span class="id"><a href="invoice/view/<?php echo $invoice->id; ?>"><?php echo $invoice->invoice_id; ?></a></span>
				<span class="date"><?php echo my_date_format($invoice->date); ?></span>
				<span class="client" style="margin-top:0;"><?php echo my_date_format($invoice->recurringDate); ?></span>
				
				<span class="amount"><?php echo my_number_format($invoice->total); ?> $</span>
				<span class="status <?php echo $invoice->status; ?>"><?php echo ucfirst($invoice->status); ?></span>
		
			</li>
		<?php endforeach; ?>
	
		<li class="row no-border">
			<span class="total"><h3>Total</h3></span>
			<span class="amount_total"><h3><?php echo my_number_format($total); ?> $</h3></span>
			<span class="total"><h3>Total Paid</h3></span>
			<span class="amount_total"><h3><?php echo my_number_format($total_paid); ?> $</h3></span>
		</li>
	</ul>
</div>
<?php endif; ?>

