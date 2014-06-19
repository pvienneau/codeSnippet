<div class="content edit_section" id="edit_invoice_section">

<?php include_view('client/update_new_dialog'); ?>

<h3 class="title">Edit Invoice</h3>

<div class="box" id="<?php echo $invoice->id; ?>">

<form action="invoice/edit/<?php echo $invoice->id; ?>" method="post">

	<!--input type="hidden" name="paid" value="<?php echo $invoice->paid; ?>" />
	<input type="hidden" name="status" value="<?php echo $invoice->status; ?>" /-->

<div id="update_clients">
	<div class="inline">
		<label>Client</label>

		<div class="select_wrapper">
			<select name="client_id" class="select" id="client_select">
				<option value="new_client">New Client…</option>	
				<option value=""> </option>
				<?php echo clients_select_option($invoice->client_id); ?>
			</select>
		</div>
	</div>
</div>

<div class="inline">
	<label>Project Name</label>
	<input type="text" name="project_name" class="field" value="<?php echo $invoice->project_name; ?>" maxlength="100" />
</div>

<div class="inline">
	<label>Date</label>
	<?php echo date_select($invoice->date); ?>
</div>


<div class="inline">
	<label class="id">Invoice ID</label>
	<input type="text" name="invoice_id" class="field id" value="<?php echo $invoice->invoice_id; ?>" maxlength="7" />
</div>

<div class="inline">
	<label>Status</label>

	<div class="select_wrapper">
		<select name="status" class="select">
			<option value="draft"<?php is_selected($invoice->status == 'draft'); ?>>Draft</option>
			<option value="sent"<?php is_selected($invoice->status == 'sent'); ?>>Sent</option>
			<option value="paid"<?php is_selected($invoice->status == 'paid'); ?>>Paid</option>
			<option value="due"<?php is_selected($invoice->status == 'due'); ?>>Due</option>
			<option value="broke"<?php is_selected($invoice->status == 'broke'); ?>>Broke</option>
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
			<option value="0"<?php is_selected($invoice->due == 0); ?>>Immediately</option>
			<option value="10"<?php is_selected($invoice->due == 10); ?>>10 Days</option>
			<option value="15"<?php is_selected($invoice->due == 15); ?>>15 Days</option>
			<option value="30"<?php is_selected($invoice->due == 30); ?>>30 Days</option>
			<option value="45"<?php is_selected($invoice->due == 45); ?>>45 Days</option>
			<option value="60"<?php is_selected($invoice->due == 60); ?>>60 Days</option>
			<option value="other"<?php $other = !in_array($invoice->due, array(0,10,15,30,45,60)); is_selected($other); ?>>Other…</option>
		</select>
	</div>

	<span id="other"<?php is_display($other); ?>>
		<input type="text" name="other" class="field" value="<?php echo $invoice->due; ?>" maxlength="3" /> Days
	</span>
</div>

<div class="inline">
	<label>Project Management (%)</label>
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
	<label>Tax 1 (%)</label>
	<div class="checkbox_wrapper">
		<input type="checkbox" name="tax_status" class="checkbox" id="tax_status"<?php is_checked(!empty($invoice->tax)); ?> />
	</div>
	<input type="text" name="tax_name" class="field" id="tax_name" value="<?php echo $invoice->tax_name; ?>"<?php is_display(!empty($invoice->tax)); ?> /><input type="text" name="tax" class="field" id="tax" value="<?php echo my_number_format($invoice->tax,3); ?>" maxlength="6"<?php is_display(!empty($invoice->tax)); ?> />
</div>

<div class="inline">
	<label>Tax 2 (%)</label>
	<div class="checkbox_wrapper">
		<input type="checkbox" name="tax2_status" class="checkbox" id="tax2_status"<?php is_checked(!empty($invoice->tax2)); ?> />
	</div>
	<span id="tax2_span"<?php is_display(!empty($invoice->tax2)); ?>>
		<input type="text" name="tax2_name" class="field" id="tax2_name" value="<?php echo $invoice->tax2_name; ?>" /><input type="text" name="tax2" class="field" id="tax2" value="<?php echo my_number_format($invoice->tax2, 3); ?>" maxlength="6" />
		<div class="checkbox_wrapper">
			<input type="checkbox" name="tax2_cumulative" class="checkbox" id="tax2_cumulative"<?php is_checked(!empty($invoice->tax2_cumulative)); ?> />
		</div>
		cumulative
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
	<label>Notes</label>
	<textarea name="notes" class="textarea notes"><?php echo $invoice->notes; ?></textarea>
</div>

</div>

<div id="line_part">
	
<ul>
	
<li id="bar">
	<span class="qty">Qty</span>
	<span class="description">Description</span>
	<span class="price">Price</span>
	<span class="total">Total</span>
</li>

<?php if(count($lines) > 0 ): ?>

	<?php $subtotal = 0; foreach($lines as $index => $line): $subtotal += $line->total; ?>
	<li class="line">
		<a href="#" class="remove_line">Remove Line</a>
	
		<span class="qty">
			<input type="text" name="line[<?php echo $index; ?>][qty]" class="field" value="<?php echo $line->qty; ?>" />
	
			<div class="select_wrapper">
				<select name="line[<?php echo $index; ?>][kind]" class="select">
					<option value="hour"<?php if ($line->kind=='hour') echo ' selected="selected"'; ?>>hours</option>
					<option value="day"<?php if ($line->kind=='day') echo ' selected="selected"'; ?>>days</option>
					<option value="service"<?php if ($line->kind=='service') echo ' selected="selected"'; ?>>services</option>
					<option value="product"<?php if ($line->kind=='product') echo ' selected="selected"'; ?>>products</option>
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
<?php endif; ?>

	
</ul>

<a href="#" id="insert">Insert</a>

<ul class="menu" id="insert_menu" style="display: none">
	<li><a href="#" id="insert_line">Insert New Line</a></li>
	<!--li class="disabled">Insert From Projects…</li-->
	<li><a href="#" id="insert_item">Insert From Items…</a></li>
</ul>


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

</div>


<div id="subtotal">

	<div class="left">
		<p class="management_display"<?php echo is_display($invoice->management); ?>>Project Management (<?php echo $invoice->management; ?>%)</p>
		<p class="subtotal_display" style="display: none">Subtotal</p>
		<p class="discount_display" style="display: none">Discount<span id="discount_rate"></span></p>
		<p class="tax_display"<?php echo is_display($invoice->tax); ?>><span id="tax_name_update"><?php echo $invoice->tax_name; ?></span><span id="tax_rate"></span></p>
		<p class="tax2_display"<?php echo is_display($invoice->tax2); ?>><span id="tax2_name_update"><?php echo $invoice->tax2_name; ?></span><span id="tax2_rate"></span></p>
		<!--p class="shipping_display" style="display: none">Shipping</p-->
		<p class="total_display">Total</p>
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

<input type="submit" class="button" id="add_invoice" value="Save Changes" />

</form>

</div>

</div>