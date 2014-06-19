<div class="content edit_section" id="edit_invoice_section">

<?php include_view('client/update_new_dialog'); ?>

<h3 class="title"><?php echo __('Edit Invoice');?></h3>

<div class="box" id="<?php echo $invoice->id; ?>">

<form action="invoice/edit/<?php echo $invoice->id; ?>" method="post">

	<!--input type="hidden" name="paid" value="<?php echo $invoice->paid; ?>" />
	<input type="hidden" name="status" value="<?php echo $invoice->status; ?>" /-->

<div id="update_clients">
	<div class="inline">
		<label><?php echo __('Client');?></label>

		<div class="select_wrapper">
			<select name="client_id" class="select" id="client_select">
				<option value="new_client"><?php echo __('New Client');?>…</option>	
				<option value=""> </option>
				<?php echo clients_select_option($invoice->client_id); ?>
			</select>
		</div>
	</div>
</div>

<div class="inline">
	<label><?php echo __('Project Name');?></label>
	<input type="text" name="project_name" class="field" value="<?php echo $invoice->project_name; ?>" maxlength="100" />
</div>

<div class="inline">
	<label><?php echo __('Date');?></label>
	<?php echo date_select($invoice->date); ?>
</div>


<div class="inline">
	<label class="id"><?php echo __('Invoice ID');?></label>
	<input type="text" name="invoice_id" class="field id" value="<?php echo $invoice->invoice_id; ?>" maxlength="7" />
</div>

<div class="inline">
	<label><?php echo __('Status');?></label>

	<div class="select_wrapper">
		<select name="status" class="select">
			<option value="draft"<?php is_selected($invoice->status == 'draft'); ?>><?php echo __('Draft');?></option>
			<option value="sent"<?php is_selected($invoice->status == 'sent'); ?>><?php echo __('Sent');?></option>
			<option value="paid"<?php is_selected($invoice->status == 'paid'); ?>><?php echo __('Paid');?></option>
			<option value="due"<?php is_selected($invoice->status == 'due'); ?>><?php echo __('Due');?></option>
			<option value="broke"<?php is_selected($invoice->status == 'broke'); ?>><?php echo __('Broke');?></option>
		</select>
	</div>
</div>

<!--div class="inline">
	<label class="optional">P.O. Number</label>
	<input type="text" name="po" class="field medium" maxlength="16" value="<?php echo $invoice->po; ?>" />
</div-->

<div class="edit" id="settings_part">

<div class="inline">
	<label>Due</label>

	<div class="select_wrapper">
		<select name="due" class="select" id="due">
			<option value="0"<?php is_selected($invoice->due == 0); ?>><?php echo __('Immediately');?></option>
			<option value="10"<?php is_selected($invoice->due == 10); ?>>10 <?php echo __('Days');?></option>
			<option value="15"<?php is_selected($invoice->due == 15); ?>>15 <?php echo __('Days');?></option>
			<option value="30"<?php is_selected($invoice->due == 30); ?>>30 <?php echo __('Days');?></option>
			<option value="45"<?php is_selected($invoice->due == 45); ?>>45 <?php echo __('Days');?></option>
			<option value="60"<?php is_selected($invoice->due == 60); ?>>60 <?php echo __('Days');?></option>
			<option value="other"<?php $other = !in_array($invoice->due, array(0,10,15,30,45,60)); is_selected($other); ?>><?php echo __('Other');?>…</option>
		</select>
	</div>

	<span id="other"<?php is_display($other); ?>>
		<input type="text" name="other" class="field" value="<?php echo $invoice->due; ?>" maxlength="3" /> <?php echo __('Days');?>
	</span>
</div>

<div class="inline">
	<label><?php echo __('Project Management');?> (%)</label>
	<div class="checkbox_wrapper">
		<input type="checkbox" name="management_status" class="checkbox" id="management_status"<?php is_checked(!empty($invoice->management)); ?> />
	</div>
	<input type="text" name="management" class="field" id="management" value="<?php echo my_number_format($invoice->management); ?>" maxlength="6"<?php is_display(!empty($invoice->management)); ?> />
</div>

<!--div class="inline">
	<label>Discount (%)</label>
	<div class="checkbox_wrapper">
		<input type="checkbox" name="discount_status" class="checkbox" id="discount_status"<?php is_checked(!empty($invoice->discount)); ?> />
	</div>
	<input type="text" name="discount" class="field small" id="discount" value="<?php echo my_number_format($invoice->discount); ?>" maxlength="6"<?php is_display(!empty($invoice->discount)); ?> />
</div-->

<div class="inline">
	<label><?php echo __('Tax');?> 1 (%)</label>
	<div class="checkbox_wrapper">
		<input type="checkbox" name="tax_status" class="checkbox" id="tax_status"<?php is_checked(!empty($invoice->tax)); ?> />
	</div>
	<input type="text" name="tax_name" class="field" id="tax_name" value="<?php echo $invoice->tax_name; ?>"<?php is_display(!empty($invoice->tax)); ?> /><input type="text" name="tax" class="field" id="tax" value="<?php echo my_number_format($invoice->tax,3); ?>" maxlength="6"<?php is_display(!empty($invoice->tax)); ?> />
</div>

<div class="inline">
	<label><?php echo __('Tax');?> 2 (%)</label>
	<div class="checkbox_wrapper">
		<input type="checkbox" name="tax2_status" class="checkbox" id="tax2_status"<?php is_checked(!empty($invoice->tax2)); ?> />
	</div>
	<span id="tax2_span"<?php is_display(!empty($invoice->tax2)); ?>>
		<input type="text" name="tax2_name" class="field" id="tax2_name" value="<?php echo $invoice->tax2_name; ?>" /><input type="text" name="tax2" class="field" id="tax2" value="<?php echo my_number_format($invoice->tax2, 3); ?>" maxlength="6" />
		<div class="checkbox_wrapper">
			<input type="checkbox" name="tax2_cumulative" class="checkbox" id="tax2_cumulative"<?php is_checked(!empty($invoice->tax2_cumulative)); ?> />
		</div>
		<?php echo __('cumulative');?>
	</span>
</div>

<!--div class="inline">
	<label>Shipping</label>
	<div class="checkbox_wrapper">
		<input type="checkbox" name="shipping_status" class="checkbox" id="shipping_status"<?php is_checked(!empty($invoice->shipping)); ?> />
	</div>
	<input type="text" name="shipping" class="field small" id="shipping" value="<?php echo my_number_format($invoice->shipping); ?>"<?php is_display(!empty($invoice->shipping)); ?> />
</div-->


<!--div class="inline">
	<label>Currency Symbol</label>

	<div class="select_wrapper">
		<select name="currency_symbol" class="select" id="currency_symbol">
			<option value=""<?php is_selected($invoice->currency_symbol == ''); ?>>None</option>
			<option value="$"<?php is_selected($invoice->currency_symbol == '$'); ?>>$</option>
			<option value="€"<?php is_selected($invoice->currency_symbol == '€'); ?>>€</option>
			<option value="£"<?php is_selected($invoice->currency_symbol == '£'); ?>>£</option>
			<option value="￥"<?php is_selected($invoice->currency_symbol == '￥'); ?>>￥</option>
		</select>
	</div>
</div>

<div class="inline">
	<label>Currency Code</label>

	<div class="select_wrapper">
		<select name="currency_code" class="select" id="currency_code">
			<option value=""<?php is_selected($invoice->currency_code == ''); ?>>None</option>
			<option value="USD"<?php is_selected($invoice->currency_code == 'USD'); ?>>U.S. Dollars</option>
			<option value="EUR"<?php is_selected($invoice->currency_code == 'EUR'); ?>>Euros</option>
			<option value="CAD"<?php is_selected($invoice->currency_code == 'CAD'); ?>>Canadian Dollars</option>
		</select>
	</div>
</div-->

<div class="inline">
	<label>Language</label>

	<div class="select_wrapper">
		<select name="language" class="select">
			<option value="en"<?php is_selected($invoice->language == 'en'); ?>>English</option>
			<!--option value="es">Spanish</option-->
			<option value="fr"<?php is_selected($invoice->language == 'fr'); ?>>Français</option>
		</select>
	</div>
</div>

<!--div class="inline">
	<label>Display Country</label>

	<div class="checkbox_wrapper">
		<input type="checkbox" name="display_country" class="checkbox"<?php is_checked($invoice->display_country); ?>>
	</div>
	<em>You can turn this off if invoicing within your own country.</em>
</div-->

<div class="inline last">
	<label><?php echo __('Notes');?></label>
	<textarea name="notes" class="textarea notes"><?php echo $invoice->notes; ?></textarea>
</div>

</div>

<div id="line_part">
	
<ul>
	
<li id="bar">
	<span class="qty"><?php echo __('Qty');?></span>
	<span class="description"><?php echo __('Description');?></span>
	<span class="price"><?php echo __('Price');?></span>
	<span class="total"><?php echo __('Total');?></span>
</li>

<?php if(count($lines) > 0 ): ?>

	<?php $subtotal = 0; foreach($lines as $index => $line): $subtotal += $line->total; ?>
	<li class="line">
		<a href="#" class="remove_line"><?php echo __('Remove Line');?></a>
	
		<span class="qty">
			<input type="text" name="line[<?php echo $index; ?>][qty]" class="field" value="<?php echo $line->qty; ?>" />
	
			<div class="select_wrapper">
				<select name="line[<?php echo $index; ?>][kind]" class="select">
					<option value="hour"<?php if ($line->kind=='hour') echo ' selected="selected"'; ?>><?php echo __('hours');?></option>
					<option value="day"<?php if ($line->kind=='day') echo ' selected="selected"'; ?>><?php echo __('days');?></option>
					<option value="service"<?php if ($line->kind=='service') echo ' selected="selected"'; ?>><?php echo __('services');?></option>
					<option value="product"<?php if ($line->kind=='product') echo ' selected="selected"'; ?>><?php echo __('products');?></option>
				</select>
			</div>
		</span>
	
		<span class="description"><textarea name="line[<?php echo $index; ?>][description]" class="textarea"><?php echo $line->description; ?></textarea></span>
		<span class="price"><input type="text" name="line[<?php echo $index; ?>][price]" class="field" value="<?php echo my_number_format($line->price); ?>"/></span>
		<span class="total"><span class="total_line"><?php echo my_number_format($line->total); ?></span></span>
	
	</li>
	<?php endforeach; ?>

<?php else: ?>
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
<?php endif; ?>

	
</ul>

<a href="#" id="insert"><?php echo __('Insert');?></a>

<ul class="menu" id="insert_menu" style="display: none">
	<li><a href="#" id="insert_line"><?php echo __('Insert New Line');?></a></li>
	<!--li class="disabled">Insert From Projects…</li-->
	<li><a href="#" id="insert_item"><?php echo __('Insert From Items');?>…</a></li>
</ul>


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

</div>


<div id="subtotal">

	<div class="left">
		<p class="management_display"<?php echo is_display($invoice->management); ?>><?php echo __('Project Management');?> (<?php echo $invoice->management; ?>%)</p>
		<p class="subtotal_display" style="display: none"><?php echo __('Subtotal');?></p>
		<p class="discount_display" style="display: none"><?php echo __('Discount');?><span id="discount_rate"></span></p>
		<p class="tax_display"<?php echo is_display($invoice->tax); ?>><span id="tax_name_update"><?php echo $invoice->tax_name; ?></span><span id="tax_rate"></span></p>
		<p class="tax2_display"<?php echo is_display($invoice->tax2); ?>><span id="tax2_name_update"><?php echo $invoice->tax2_name; ?></span><span id="tax2_rate"></span></p>
		<!--p class="shipping_display" style="display: none">Shipping</p-->
		<p class="total_display"><?php echo __('Total');?></p>
	</div>

	<div class="right">
		<p class="management_display"<?php echo is_display($invoice->management); ?>><?php $fee = $subtotal * $invoice->management / 100; $subtotal += $fee; echo my_number_format($fee); ?></p>
		<p class="subtotal_display"<?php if ($subtotal == $invoice->total) echo ' style="display: none"'; ?>><span class="currency_symbol"></span><span id="subtotal_result"><?php echo my_number_format($subtotal, 2); ?></span><span class="currency_code"> <?php echo $invoice->currency_code; ?></span></p>
		<p class="discount_display"<?php if (empty($invoice->discount)) echo ' style="display: none"'; ?>>-<span class="currency_symbol"></span><span id="discount_result">-<?php $subtotal -= $subtotal * ($invoice->discount/100); echo my_number_format($subtotal * ($invoice->discount/100)); ?></span><span class="currency_code"> <?php echo $invoice->currency_code; ?></span></p>
		<p class="tax_display"<?php echo is_display($invoice->tax); ?>><span class="currency_symbol"></span><span id="tax_result"><?php echo my_number_format($invoice->tax_fee); ?></span><span class="currency_code"> <?php echo $invoice->currency_code; ?></span></p>
		<p class="tax2_display"<?php echo is_display($invoice->tax2); ?>><span class="currency_symbol"></span><span id="tax2_result"><?php echo my_number_format($invoice->tax2_fee); ?></span><span class="currency_code"> <?php echo $invoice->currency_code; ?></span></p>
		<!--p class="shipping_display"<?php if (empty($invoice->shipping)) echo ' style="display: none"'; ?>><span class="currency_symbol"></span><span id="shipping_result"><?php echo my_number_format($invoice->shipping); ?></span><span class="currency_code"> <?php echo $invoice->currency_code; ?></span></p-->
		<p class="total_display"><span class="currency_symbol"></span><span id="total_result"><?php echo my_number_format($invoice->total); ?></span><span class="currency_code"> <?php echo $invoice->currency_code; ?></span></p>
	</div>

</div>
	
</div>

<input type="submit" class="button" id="add_invoice" value="<?php echo __('Save Changes');?>" />

</form>

</div>

</div>