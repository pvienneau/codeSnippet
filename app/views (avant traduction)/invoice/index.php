<div class="content new_section" id="new_invoice_section" style="display: none">

<ul class="sidebar">
	<li><a href="#" id="cancel">Cancel</a></li>
</ul>

<?php include_view('client/update_new_dialog'); ?>

<h3 class="title">New Invoice</h3>

<div class="box">

<form action="invoice/add" method="post">

	<div id="update_clients">
		<div class="inline">
			<label>Client</label>
			<div class="select_wrapper">
				<select name="client_id" class="select" id="client_select">
					<option value="new_client">New Client…</option>
					<option value=""  selected="selected"> </option>
					<?php echo $clients_options = clients_select_option(); ?>
				</select>
			</div>
		</div>
	</div>

	<div class="inline">
		<label>Project Name</label>
		<input type="text" name="project_name" class="field" value="" maxlength="100" />
	</div>
	
	<div class="inline">
		<label>Date</label>
		<?php echo date_select(); ?>
	</div>

	<div class="inline" >
		<label class="id">Invoice ID</label>
		<input type="text" name="invoice_id" class="field id" value="<?php echo Invoice::getNextNumber(); ?>" maxlength="7" />
	</div>

	<!--div class="inline">
		<label class="optional">P.O. Number</label>
		<input type="text" name="po" class="field medium" maxlength="16" />
	</div-->

	<div class="inline none">
		<a href="#" id="invoice_settings">Invoice Settings</a>
	</div>

	<div id="settings_part" style="display: none">
		<div class="inline">
			<label>Due</label>
			<div class="select_wrapper">
				<select name="due" class="select" id="due">
					<option value="0">Immediately</option>
					<option value="10">10 Days</option>
					<option value="15">15 Days</option>
					<option value="30" selected="selected">30 Days</option>
					<option value="45">45 Days</option>
					<option value="60">60 Days</option>
					<option value="other">Other…</option>
				</select>
			</div>
			<span id="other" style="display: none">
				<input type="text" name="other" class="field" value="0" maxlength="3" /> Days
			</span>
		</div>

		<div class="inline">
			<label>Project Management (%)</label>
			<div class="checkbox_wrapper">
				<input type="checkbox" name="management_status" class="checkbox" id="management_status" checked="checked" />
			</div>
			<input type="text" name="management" class="field" id="management" value="10" maxlength="6" />
		</div>
		
		<!--div class="inline">
			<label>Discount (%)</label>
			<div class="checkbox_wrapper">
				<input type="checkbox" name="discount_status" class="checkbox" id="discount_status" />
			</div>
			<input type="text" name="discount" class="field" id="discount" value="0.00" maxlength="6" style="display: none" />
		</div-->

		<div class="inline">
			<label>Tax 1 (%)</label>
			<div class="checkbox_wrapper">
				<input type="checkbox" name="tax_status" class="checkbox" id="tax_status" />
			</div>
			<input type="text" name="tax_name" class="field" id="tax_name" value="TPS" style="display: none" /><input type="text" name="tax" class="field" id="tax" value="5.00" maxlength="6" style="display: none" />
		</div>

		<div class="inline">
			<label>Tax 2 (%)</label>
			<div class="checkbox_wrapper">
				<input type="checkbox" name="tax2_status" class="checkbox" id="tax2_status" />
			</div>
			<span id="tax2_span" style="display: none">
				<input type="text" name="tax2_name" class="field" id="tax2_name" value="TVQ" /><input type="text" name="tax2" class="field" id="tax2" value="9.975" maxlength="6" />
				<div class="checkbox_wrapper">
					<input type="checkbox" name="tax2_cumulative" class="checkbox" id="tax2_cumulative" />
				</div>
				cumulative
			</span>
		</div>

		<!--div class="inline">
			<label>Shipping</label>
			<div class="checkbox_wrapper">
				<input type="checkbox" name="shipping_status" class="checkbox" id="shipping_status" />
			</div>
			<input type="text" name="shipping" class="field small" id="shipping" value="0.00" style="display: none" />
		</div-->

		<!--div class="inline">
			<label>Currency Symbol</label>
			<div class="select_wrapper">
				<select name="currency_symbol" class="select" id="currency_symbol">
					<option value="" selected="selected">None</option>
					<option value="$">$</option>
					<option value="€">€</option>
					<option value="£">£</option>
					<option value="￥">￥</option>
				</select>
			</div>
		</div>

		<div class="inline">
			<label>Currency Code</label>
			<div class="select_wrapper">
				<select name="currency_code" class="select" id="currency_code">
					<option value="" selected="selected">None</option>
					<option value="USD">U.S. Dollars</option>
					<option value="EUR">Euros</option>
					<option value="CAD">Canadian Dollars</option>
				</select>
			</div>
		</div-->

		<div class="inline">
			<label>Language</label>
			<div class="select_wrapper">
				<select name="language" class="select">
					<option value="en">English</option>
					<!--option value="es">Spanish</option-->
					<option value="fr" selected="selected">Français</option>
				</select>
			</div>
		</div>

		<!--div class="inline">
			<label>Display Country</label>
			<div class="checkbox_wrapper">
				<input type="checkbox" name="display_country" class="checkbox" checked="checked">
			</div>
			<em>You can turn this off if invoicing within your own country.</em>
		</div-->

		<div class="inline last">
			<label>Notes</label>
			<textarea name="notes" class="textarea notes"></textarea>
		</div>

	</div><!-- end #settings_part -->

	<div id="line_part">
		<ul>
			<li id="bar">
				<span class="qty">Qty</span>
				<span class="description">Description</span>
				<span class="price">Price</span>
				<span class="total">Total</span>
			</li>
			<li class="line">
				<a href="#" class="remove_line">Remove Line</a>

				<span class="qty">
				<input type="text" name="line[0][qty]" class="field" value="1" />
				<div class="select_wrapper">
					<select name="line[0][kind]" class="select">
						<option value="hour">hour</option>
						<option value="day">day</option>
						<option value="service">service</option>
						<option value="product">product</option>
					</select>
				</div>

				</span>

				<span class="description"><textarea name="line[0][description]" class="textarea"></textarea></span>
				<span class="price"><input type="text" name="line[0][price]" class="field" value="<?php echo my_number_format(AuthUser::getRecord()->rate, 2); ?>"/></span>
				<span class="total"><span class="total_line">85.00</span></span>
			</li>
		</ul>

		<a href="#" id="insert">Insert</a>

		<ul class="menu" id="insert_menu" style="display: none">
			<li><a href="#" id="insert_line">Insert New Line</a></li>
			<!--li><a href="#" id="insert_project">Insert From Projects…</a></li-->
			<li><a href="#" id="insert_item">Insert From Items…</a></li>
		</ul>

		<!--div class="dialog" id="insert_project_dialog">
			<div class="confirm">Select a project</div>

			<div class="select_wrapper">
				<select class="select">
					<option value=""></option>
					<option value="223882">Sample Project</option>
				</select>
			</div>

			<div class="control">
				<input type="button" class="button insert disabled" value="Insert" disabled="disabled" />
				<a href="#" class="small_button">Cancel</a>
			</div>
		</div-->

		<div class="dialog" id="insert_item_dialog">
			<div class="confirm">Select an item</div>
			<div class="select_wrapper">
				<select class="select">
				<option value=""></option>
				<?php foreach($items as $item): ?>
				<option value="<?php echo $item->id; ?>"><?php echo $item->description; ?></option>
				<?php endforeach; ?>
				</select>
			</div>
			<div class="control">
				<input type="button" class="button insert disabled" value="Insert" disabled="disabled" />
				<a href="#" class="small_button">Cancel</a>
			</div>
		</div><!-- end #insert_item_dialog -->

		<div id="subtotal">
			<div class="left">
				<p class="management_display">Project Management<span id="management_rate"> (10%)</span></p>
				<p class="subtotal_display">Subtotal</p>
				<p class="discount_display" style="display: none">Discount<span id="discount_rate"></span></p>
				<p class="tax_display" style="display: none"><span id="tax_name_update">TPS</span><span id="tax_rate"></span></p>
				<p class="tax2_display" style="display: none"><span id="tax2_name_update">TVQ</span><span id="tax2_rate"></span></p>
				<!--p class="shipping_display" style="display: none">Shipping</p-->
				<p class="total_display">Total</p>
			</div>

			<div class="right">
				<p class="management_display">
					<span class="currency_symbol"></span><span id="management_result">5.00</span><span class="currency_code"></span>
				</p>
				<p class="subtotal_display">
					<span class="currency_symbol"></span><span id="subtotal_result">50.00</span><span class="currency_code"></span>
				</p>
				<p class="discount_display" style="display: none">
					-<span class="currency_symbol"></span><span id="discount_result">0.00</span><span class="currency_code"></span>
				</p>
				<p class="tax_display" style="display: none">
					<span class="currency_symbol"></span><span id="tax_result">0.00</span><span class="currency_code"></span>
				</p>
				<p class="tax2_display" style="display: none">
					<span class="currency_symbol"></span><span id="tax2_result">0.00</span><span class="currency_code"></span>
				</p>
				<!--p class="shipping_display" style="display: none">
					<span class="currency_symbol"></span><span id="shipping_result">0.00</span><span class="currency_code"></span>
				</p-->
				<p class="total_display">
					<span class="currency_symbol"></span><span id="total_result">55.00</span><span class="currency_code"></span>
				</p>
			</div>
		</div><!-- end .subtotal -->
	</div><!-- end #line_part -->

	<input type="submit" class="button" id="add_invoice" value="Add Invoice" />

</form><!-- end "invoice/add" -->

</div>



</div>

<div class="content main_section" id="invoices_section">
<?php if(AuthUser::accessLevel("invoices") > 1): ?>
<ul class="sidebar">
	<li><a href="#" id="new">New Invoice</a></li>
</ul>
<?php endif; ?>
<h3 class="title">Invoices</h3>

<ul>
	<li id="filter">
		<form action="invoice" method="post">
			<label>Period</label>
			<div class="select_wrapper">
				<select name="period" class="select">
					<option value="all">All</option>
					<option value="today">Today</option>
					<option value="yesterday">Yesterday</option>
					<option value="this_month">This Month</option>
					<option value="last_month">Last Month</option>
					<option value="this_year">This Year</option>
					<option value="last_year">Last Year</option>
				</select>
			</div>

			<label>Client</label>
			<div class="select_wrapper">
				<select name="client" class="select">
					<option value="all">All</option>
					<?php echo $clients_options; ?>
				</select>
			</div>

			<label>Status</label>
			<div class="select_wrapper">
				<select name="status" class="select">
					<option value="all">All</option>
					<option value="draft">Draft</option>
					<option value="sent">Sent</option>
					<option value="paid">Paid</option>
					<option value="due">Due</option>
					<option value="recurring">Recurring</option>
					<option value="broke">Broke</option>
				</select>
			</div>
		</form>
	</li>

	<li id="bar">
		<span class="id">ID</span>
		<span class="date">Date</span>
		<span class="client">Client</span>
		<span class="amount">Amount</span>
		<span class="status">Status</span>
	</li>
</ul>

<ul class="rows">

<?php $total = 0; $total_paid = 0; foreach($invoices as $invoice): $total += $invoice->total; $total_paid += $invoice->paid; ?>
	<li class="row" id="<?php echo $invoice->id; ?>">
		<?php if(AuthUser::accessLevel("invoices") > 1): ?>
			<span class="actions" style="display: none">
				<a href="#" class="remove">Remove</a>
				<a href="invoice/edit/<?php echo $invoice->id; ?>" class="edit">Edit</a>
			</span>
		<?php endif; ?>
		<span class="id"><a href="invoice/view/<?php echo $invoice->id; ?>"><?php echo $invoice->invoice_id; ?></a></span>
		<span class="date"><?php echo my_date_format($invoice->date); ?></span>
		<span class="client" title="<?php echo $invoice->client; ?>"><?php echo '<i>'.$invoice->client.'</i> <small>' . ($invoice->project_name != '' ? $invoice->project_name: '--').'</small>'; ?></span>
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