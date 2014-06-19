<div class="content edit_section" id="edit_estimate_section">

<?php include_view('client/update_new_dialog'); ?>

<h3 class="title">Edit Estimate</h3>

<div class="box" id="<?php echo $estimate->id; ?>">

<form action="estimate/edit/<?php echo $estimate->id; ?>" method="post">

<div id="update_clients">
	<div class="inline">
		<label>Client</label>

		<div class="select_wrapper">
			<select name="client_id" class="select" id="client_select">
				<option value="new_client">New Client…</option>	
				<option value=""> </option>
				<?php echo clients_select_option($estimate->client_id); ?>
			</select>
		</div>
	</div>
</div>

<div class="inline">
	<label>Project Name</label>
	<input type="text" name="project_name" class="field" value="<?php echo $estimate->project_name; ?>" maxlength="100" />
</div>

<div class="inline">
	<label>Date</label>
	<?php echo date_select($estimate->date); ?>
</div>


<div class="inline" >
	<label class="id">Estimate ID</label>
	<input type="text" name="estimate_id" class="field id" value="<?php echo $estimate->estimate_id; ?>" maxlength="7" />
</div>


<div class="inline">
	<label>Status</label>

	<div class="select_wrapper">
		<select name="status" class="select">
			<option value="draft"<?php is_selected($estimate->status == 'draft'); ?>>Draft</option>
			<option value="sent"<?php is_selected($estimate->status == 'sent'); ?>>Sent</option>
			<option value="accepted"<?php is_selected($estimate->status == 'accepted'); ?>>Accepted</option>
			<option value="refused"<?php is_selected($estimate->status == 'refused'); ?>>Refused</option>
			<option value="invoiced"<?php is_selected($estimate->status == 'invoiced'); ?>>Invoiced</option>
		</select>
	</div>
</div>

<!--div class="inline">
	<label class="optional">P.O. Number</label>
	<input type="text" name="po" class="field medium" maxlength="16" value="<?php echo $estimate->po; ?>" />
</div-->

<div class="edit" id="settings_part">

<div class="inline">
	<label>Project Management (%)</label>
	<div class="checkbox_wrapper">
		<input type="checkbox" name="management_status" class="checkbox" id="management_status"<?php is_checked(!empty($estimate->management)); ?> />
	</div>
	<input type="text" name="management" class="field" id="management" value="<?php echo my_number_format($estimate->management); ?>" maxlength="6"<?php is_display(!empty($estimate->management)); ?> />
</div>

<!--div class="inline">
	<label>Discount (%)</label>
	<div class="checkbox_wrapper">
		<input type="checkbox" name="discount_status" class="checkbox" id="discount_status"<?php is_checked(!empty($estimate->discount)); ?> />
	</div>
	<input type="text" name="discount" class="field small" id="discount" value="<?php echo my_number_format($estimate->discount); ?>" maxlength="6"<?php is_display(!empty($estimate->discount)); ?> />
</div-->

<div class="inline">
	<label>Tax 1 (%)</label>
	<div class="checkbox_wrapper">
		<input type="checkbox" name="tax_status" class="checkbox" id="tax_status"<?php is_checked(!empty($estimate->tax)); ?> />
	</div>
	<input type="text" name="tax_name" class="field" id="tax_name" value="<?php echo $estimate->tax_name; ?>"<?php is_display(!empty($estimate->tax)); ?> /><input type="text" name="tax" class="field" id="tax" value="<?php echo my_number_format($estimate->tax,3); ?>" maxlength="6"<?php is_display(!empty($estimate->tax)); ?> />
</div>

<div class="inline">
	<label>Tax 2 (%)</label>
	<div class="checkbox_wrapper">
		<input type="checkbox" name="tax2_status" class="checkbox" id="tax2_status"<?php is_checked(!empty($estimate->tax2)); ?> />
	</div>
	<span id="tax2_span"<?php is_display(!empty($estimate->tax2)); ?>>
		<input type="text" name="tax2_name" class="field" id="tax2_name" value="<?php echo $estimate->tax2_name; ?>" /><input type="text" name="tax2" class="field" id="tax2" value="<?php echo my_number_format($estimate->tax2,3); ?>" maxlength="6" />
		<div class="checkbox_wrapper">
			<input type="checkbox" name="tax2_cumulative" class="checkbox" id="tax2_cumulative"<?php is_checked(!empty($estimate->tax2_cumulative)); ?> />
		</div>
		cumulative
	</span>
</div>

<!--div class="inline">
	<label>Shipping</label>
	<div class="checkbox_wrapper">
		<input type="checkbox" name="shipping_status" class="checkbox" id="shipping_status"<?php is_checked(!empty($estimate->shipping)); ?> />
	</div>
	<input type="text" name="shipping" class="field small" id="shipping" value="<?php echo my_number_format($estimate->shipping); ?>"<?php is_display(!empty($estimate->shipping)); ?> />
</div-->


<!--div class="inline">
	<label>Currency Symbol</label>

	<div class="select_wrapper">
		<select name="currency_symbol" class="select" id="currency_symbol">
			<option value=""<?php is_selected($estimate->currency_symbol == ''); ?>>None</option>
			<option value="$"<?php is_selected($estimate->currency_symbol == '$'); ?>>$</option>
			<option value="€"<?php is_selected($estimate->currency_symbol == '€'); ?>>€</option>
			<option value="£"<?php is_selected($estimate->currency_symbol == '£'); ?>>£</option>
			<option value="￥"<?php is_selected($estimate->currency_symbol == '￥'); ?>>￥</option>
		</select>
	</div>
</div>

<div class="inline">
	<label>Currency Code</label>

	<div class="select_wrapper">
		<select name="currency_code" class="select" id="currency_code">
			<option value=""<?php is_selected($estimate->currency_code == ''); ?>>None</option>
			<option value="USD"<?php is_selected($estimate->currency_code == 'USD'); ?>>U.S. Dollars</option>
			<option value="EUR"<?php is_selected($estimate->currency_code == 'EUR'); ?>>Euros</option>
			<option value="CAD"<?php is_selected($estimate->currency_code == 'CAD'); ?>>Canadian Dollars</option>
		</select>
	</div>
</div-->

<div class="inline">
	<label>Language</label>

	<div class="select_wrapper">
		<select name="language" class="select">
			<option value="en"<?php is_selected($estimate->language == 'en'); ?>>English</option>
			<!--option value="es">Spanish</option-->
			<option value="fr"<?php is_selected($estimate->language == 'fr'); ?>>Français</option>
		</select>
	</div>
</div>

<!--div class="inline">
	<label>Display Country</label>

	<div class="checkbox_wrapper">
		<input type="checkbox" name="display_country" class="checkbox"<?php is_checked($estimate->display_country); ?>>
	</div>
	<em>You can turn this off if invoicing within your own country.</em>
</div-->

<div class="inline last">
	<label>Details</label>
	<textarea name="notes" class="textarea notes"><?php echo $estimate->notes; ?></textarea>
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
	<?php foreach($lines as $index => $line): ?>
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
		<span class="price"><input type="text" name="line[0][price]" class="field" value="<?php echo my_number_format(AuthUser::getRecord()->rate); ?>"/></span>
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
		<p class="management_display"<?php echo is_display($estimate->management); ?>>Project Management<span id="management_rate"></span></p>
		<p class="subtotal_display"<?php echo is_display($estimate->subtotal != $estimate->total); ?>>Subtotal</p>
		<p class="discount_display"<?php echo is_display($estimate->discount); ?>>Discount<span id="discount_rate"></span></p>
		<p class="tax_display"<?php echo is_display($estimate->tax); ?>><span id="tax_name_update"><?php echo $estimate->tax_name; ?></span><span id="tax_rate"></span></p>
		<p class="tax2_display"<?php echo is_display($estimate->tax2); ?>><span id="tax2_name_update"><?php echo $estimate->tax2_name; ?></span><span id="tax2_rate"></span></p>
		<!--p class="shipping_display" style="display: none">Shipping</p-->
		<p class="total_display">Total</p>
	</div>

	<div class="right">
		<p class="management_display"<?php echo is_display($estimate->management); ?>><span id="management_result"><?php echo my_number_format($estimate->management_fee); ?></span></p>
		<p class="subtotal_display"<?php echo is_display($estimate->subtotal != $estimate->total); ?>><span class="currency_symbol"></span><span id="subtotal_result"><?php echo my_number_format($estimate->subtotal); ?></span><span class="currency_code"> <?php echo $estimate->currency_code; ?></span></p>
		<p class="discount_display"<?php echo is_display($estimate->discount); ?>>-<span class="currency_symbol"></span><span id="discount_result">-<?php echo my_number_format($estimate->discount_fee); ?></span><span class="currency_code"> <?php echo $estimate->currency_code; ?></span></p>
		<p class="tax_display"<?php echo is_display($estimate->tax); ?>><span class="currency_symbol"></span><span id="tax_result"><?php echo my_number_format($estimate->tax_fee); ?></span><span class="currency_code"> <?php echo $estimate->currency_code; ?></span></p>
		<p class="tax2_display"<?php echo is_display($estimate->tax2); ?>><span class="currency_symbol"></span><span id="tax2_result"><?php echo my_number_format($estimate->tax2_fee); ?></span><span class="currency_code"> <?php echo $estimate->currency_code; ?></span></p>
		<!--p class="shipping_display"<?php if (empty($estimate->shipping)) echo ' style="display: none"'; ?>><span class="currency_symbol"></span><span id="shipping_result"><?php echo my_number_format($estimate->shipping); ?></span><span class="currency_code"> <?php echo $estimate->currency_code; ?></span></p-->
		<p class="total_display"><span class="currency_symbol"></span><span id="total_result"><?php echo my_number_format($estimate->total); ?></span><span class="currency_code"> <?php echo $estimate->currency_code; ?></span></p>
	</div>

</div>
	
</div><!-- #line_part -->


<div id="option_part">
	<h3>Options</h3><br/>
	<ul>
		<li id="option_bar">
			<span class="qty">Qty</span>
			<span class="description">Description</span>
			<span class="price">Price</span>
			<span class="total">Total</span>
		</li>
<?php if (!$options) $options = array(new EstimateOption()); ?>
<?php foreach($options as $index => $option): ?>
		<li class="option">
			<a href="#" class="remove_option">Remove Option</a>

			<span class="qty">
			<input type="text" name="option[<?php echo $index; ?>][qty]" class="field" value="<?php echo $option->qty; ?>" />
			<div class="select_wrapper">
				<select name="option[<?php echo $index; ?>][kind]" class="select">
					<option value="hour"<?php echo is_selected($option->kind == 'hour'); ?>>hour</option>
					<option value="day"<?php echo is_selected($option->kind == 'day'); ?>>day</option>
					<option value="service"<?php echo is_selected($option->kind == 'service'); ?>>service</option>
					<option value="product"<?php echo is_selected($option->kind == 'product'); ?>>product</option>
				</select>
			</div>

			</span>

			<span class="description"><textarea name="option[<?php echo $index; ?>][description]" class="textarea"><?php echo html_encode($option->description); ?></textarea></span>
			<span class="price"><input type="text" name="option[<?php echo $index; ?>][price]" class="field" value="<?php echo my_number_format($option->price); ?>"/></span>
			<span class="total"><span class="total_option"><?php echo $option->total; ?></span></span>
		</li>
<?php endforeach; ?>
	</ul>

	<a href="#" id="insert_option">Insert</a>

	<ul class="menu" id="insert_option_menu" style="display: none">
		<li><a href="#" id="insert_new_option">Insert New Option</a></li>
		<!--li><a href="#" id="insert_project">Insert From Projects…</a></li-->
		<li><a href="#" id="insert_option_item">Insert From Items…</a></li>
	</ul>

</div><!-- end #option_part -->
<input type="submit" class="button" id="add_estimate" value="Save Changes" />

</form>

</div>

</div>