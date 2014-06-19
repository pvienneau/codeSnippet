<div class="content new_section" id="new_invoice_section" style="display: none">

<ul class="sidebar">
	<li><a href="#" id="cancel"><?php echo __('Cancel');?></a></li>
</ul>

<?php include_view('client/update_new_dialog'); ?>

<h3 class="title"><?php echo __('New Invoice');?></h3>

<div class="box">

<form action="invoice/add" method="post">

	<div id="update_clients">
		<div class="inline">
			<label><?php echo __('Client');?></label>
			<div class="select_wrapper">
				<select name="client_id" class="select" id="client_select">
					<option value="new_client"><?php echo __('New Client');?>…</option>
					<option value=""  selected="selected"> </option>
					<?php echo $clients_options = clients_select_option(); ?>
				</select>
			</div>
		</div>
	</div>

	<div class="inline">
		<label><?php echo __('Project Name');?></label>
		<input type="text" name="project_name" class="field" value="" maxlength="100" />
	</div>
	
	<div class="inline">
		<label><?php echo __('Date');?></label>
		<?php echo date_select(); ?>
	</div>

	<div class="inline" >
		<label class="id"><?php echo __('Invoice ID');?></label>
		<input type="text" name="invoice_id" class="field id" value="<?php echo Invoice::getNextNumber(); ?>" maxlength="7" />
	</div>

	<!--div class="inline">
		<label class="optional">P.O. Number</label>
		<input type="text" name="po" class="field medium" maxlength="16" />
	</div-->

	<div class="inline none">
		<a href="#" id="invoice_settings"><?php echo __('Invoice Settings');?></a>
	</div>

	<div id="settings_part" style="display: none">
		<div class="inline">
			<label><?php echo __('Due');?></label>
			<div class="select_wrapper">
				<select name="due" class="select" id="due">
					<option value="0"><?php echo __('Immediately');?></option>
					<option value="10">10 <?php echo __('Days');?></option>
					<option value="15">15 <?php echo __('Days');?></option>
					<option value="30" selected="selected">30 <?php echo __('Days');?></option>
					<option value="45">45 <?php echo __('Days');?></option>
					<option value="60">60 <?php echo __('Days');?></option>
					<option value="other"><?php echo __('Other');?>…</option>
				</select>
			</div>
			<span id="other" style="display: none">
				<input type="text" name="other" class="field" value="0" maxlength="3" /> <?php echo __('Days');?>
			</span>
		</div>

		<div class="inline">
			<label><?php echo __('Project Management');?> (%)</label>
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
			<label><?php echo __('Tax');?> 1 (%)</label>
			<div class="checkbox_wrapper">
				<input type="checkbox" name="tax_status" class="checkbox" id="tax_status" />
			</div>
			<input type="text" name="tax_name" class="field" id="tax_name" value="TPS" style="display: none" /><input type="text" name="tax" class="field" id="tax" value="5.00" maxlength="6" style="display: none" />
		</div>

		<div class="inline">
			<label><?php echo __('Tax');?> 2 (%)</label>
			<div class="checkbox_wrapper">
				<input type="checkbox" name="tax2_status" class="checkbox" id="tax2_status" />
			</div>
			<span id="tax2_span" style="display: none">
				<input type="text" name="tax2_name" class="field" id="tax2_name" value="TVQ" /><input type="text" name="tax2" class="field" id="tax2" value="9.975" maxlength="6" />
				<div class="checkbox_wrapper">
					<input type="checkbox" name="tax2_cumulative" class="checkbox" id="tax2_cumulative" />
				</div>
				<?php echo __('cumulative');?>
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
			<label><?php echo __('Language');?></label>
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
			<label><?php echo __('Notes');?></label>
			<textarea name="notes" class="textarea notes"></textarea>
		</div>

	</div><!-- end #settings_part -->

	<div id="line_part">
		<ul>
			<li id="bar">
				<span class="qty"><?php echo __('Qty');?></span>
				<span class="description"><?php echo __('Description');?></span>
				<span class="price"><?php echo __('Price');?></span>
				<span class="total"><?php echo __('Total');?></span>
			</li>
			<li class="line">
				<a href="#" class="remove_line"><?php echo __('Remove Line');?></a>

				<span class="qty">
				<input type="text" name="line[0][qty]" class="field" value="1" />
				<div class="select_wrapper">
					<select name="line[0][kind]" class="select">
						<option value="hour"><?php echo __('hour');?></option>
						<option value="day"><?php echo __('day');?></option>
						<option value="service"><?php echo __('service');?></option>
						<option value="product"><?php echo __('product');?></option>
					</select>
				</div>

				</span>

				<span class="description"><textarea name="line[0][description]" class="textarea"></textarea></span>
				<span class="price"><input type="text" name="line[0][price]" class="field" value="<?php echo my_number_format(AuthUser::getRecord()->rate, 2); ?>"/></span>
				<span class="total"><span class="total_line">85.00</span></span>
			</li>
		</ul>

		<a href="#" id="insert"><?php echo __('Insert');?></a>

		<ul class="menu" id="insert_menu" style="display: none">
			<li><a href="#" id="insert_line"><?php echo __('Insert New Line');?></a></li>
			<!--li><a href="#" id="insert_project">Insert From Projects…</a></li-->
			<li><a href="#" id="insert_item"><?php echo __('Insert From Items');?>…</a></li>
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
			<div class="confirm"><?php echo __('Select an item');?></div>
			<div class="select_wrapper">
				<select class="select">
				<option value=""></option>
				<?php foreach($items as $item): ?>
				<option value="<?php echo $item->id; ?>"><?php echo $item->description; ?></option>
				<?php endforeach; ?>
				</select>
			</div>
			<div class="control">
				<input type="button" class="button insert disabled" value="<?php echo __('Insert');?>" disabled="disabled" />
				<a href="#" class="small_button"><?php echo __('Cancel');?></a>
			</div>
		</div><!-- end #insert_item_dialog -->

		<div id="subtotal">
			<div class="left">
				<p class="management_display"><?php echo __('Project Management');?><span id="management_rate"> (10%)</span></p>
				<p class="subtotal_display"><?php echo __('Subtotal');?></p>
				<p class="discount_display" style="display: none"><?php echo __('Discount');?><span id="discount_rate"></span></p>
				<p class="tax_display" style="display: none"><span id="tax_name_update">TPS</span><span id="tax_rate"></span></p>
				<p class="tax2_display" style="display: none"><span id="tax2_name_update">TVQ</span><span id="tax2_rate"></span></p>
				<!--p class="shipping_display" style="display: none">Shipping</p-->
				<p class="total_display"><?php echo __('Total');?></p>
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

	<input type="submit" class="button" id="add_invoice" value="<?php echo __('Add Invoice');?>" />

</form><!-- end "invoice/add" -->

</div>



</div>

<div class="content main_section" id="invoices_section">
<?php if(AuthUser::accessLevel("invoices") > 1): ?>
<ul class="sidebar">
	<li><a href="#" id="new"><?php echo __('New Invoice');?></a></li>
</ul>
<?php endif; ?>
<h3 class="title"><?php echo __('Invoices');?></h3>

<ul>
	<li id="filter">
		<form action="invoice" method="post">
			<label><?php echo __('Period');?></label>
			<div class="select_wrapper">
				<select name="period" class="select">
					<option value="all"><?php echo __('All');?></option>
					<option value="today"><?php echo __('Today');?></option>
					<option value="yesterday"><?php echo __('Yesterday');?></option>
					<option value="this_month"><?php echo __('This Month');?></option>
					<option value="last_month"><?php echo __('Last Month');?></option>
					<option value="this_year"><?php echo __('This Year');?></option>
					<option value="last_year"><?php echo __('Last Year');?></option>
				</select>
			</div>

			<label><?php echo __('Client');?></label>
			<div class="select_wrapper">
				<select name="client" class="select">
					<option value="all"><?php echo __('All');?></option>
					<?php echo $clients_options; ?>
				</select>
			</div>

			<label><?php echo __('Status');?></label>
			<div class="select_wrapper">
				<select name="status" class="select">
					<option value="all"><?php echo __('All');?></option>
					<option value="draft"><?php echo __('Draft');?></option>
					<option value="sent"><?php echo __('Sent');?></option>
					<option value="paid"><?php echo __('Paid');?></option>
					<option value="due"><?php echo __('Due');?></option>
					<option value="recurring"><?php echo __('Recurring');?></option>
					<option value="broke"><?php echo __('Broke');?></option>
				</select>
			</div>
		</form>
	</li>

	<li id="bar">
		<span class="id"><?php echo __('ID');?></span>
		<span class="date"><?php echo __('Date');?></span>
		<span class="client"><?php echo __('Client');?></span>
		<span class="amount"><?php echo __('Amount');?></span>
		<span class="status"><?php echo __('Status');?></span>
	</li>
</ul>

<ul class="rows">

<?php $total = 0; $total_paid = 0; foreach($invoices as $invoice): $total += $invoice->total; $total_paid += $invoice->paid; ?>
	<li class="row" id="<?php echo $invoice->id; ?>">
		<?php if(AuthUser::accessLevel("invoices") > 1): ?>
			<span class="actions" style="display: none">
				<a href="#" class="remove"><?php echo __('Remove');?></a>
				<a href="invoice/edit/<?php echo $invoice->id; ?>" class="edit"><?php echo __('Edit');?></a>
			</span>
		<?php endif; ?>
		<span class="id"><a href="invoice/view/<?php echo $invoice->id; ?>"><?php echo $invoice->invoice_id; ?></a></span>
		<span class="date"><?php echo my_date_format($invoice->date); ?></span>
		<span class="client" title="<?php echo $invoice->client; ?>"><?php echo '<i>'.$invoice->client.'</i> <small>' . ($invoice->project_name != '' ? $invoice->project_name: '--').'</small>'; ?></span>
		<span class="amount"><?php echo my_number_format($invoice->total); ?> $</span>
		<span class="status <?php echo $invoice->status; ?>"><?php echo __(ucfirst($invoice->status)); ?></span>

	</li>
<?php endforeach; ?>

	<li class="row no-border">
		<span class="total"><h3><?php echo __('Total');?></h3></span>
		<span class="amount_total"><h3><?php echo my_number_format($total); ?> $</h3></span>
		<span class="total"><h3><?php echo __('Total Paid');?></h3></span>
		<span class="amount_total"><h3><?php echo my_number_format($total_paid); ?> $</h3></span>
	</li>
</ul>

</div>