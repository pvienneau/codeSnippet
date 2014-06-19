<div class="content edit_section" id="edit_recurring_section">

<?php include_view('client/update_new_dialog'); ?>

<h3 class="title">Edit Recurring Template</h3>

<div class="box" id="<?php echo $recurring->id; ?>">

<div class="information">
<p>Recurring templates are created and added to your Invoices section on their scheduled date. The Invoice ID will be generated based on your most recent invoice. Additionally, you can choose to send the invoice directly to your client, the invoice will then get it's status changed to "Sent". All schedules are processed at midnight (PST time).</p>
</div>

<form action="recurring/edit/<?php echo $recurring->id; ?>" method="post" id="recurring_form">

<div class="inline">
	<label>Name</label>
	<input type="text" name="name" class="field" value="<?php echo $recurring->name; ?>" />
</div>

<div id="update_clients">

<div class="inline">
	<label>Client</label>

	<div class="select_wrapper">
		<select name="client_id" class="select" id="client">
			<option value="new_client">New Client…</option>	
			<option value=""> </option>
			<?php echo clients_select_option($recurring->client_id); ?>
		</select>
	</div>
</div>

</div>


<div class="inline">
	<label>Schedule</label>

	<div class="select_wrapper">
		<select name="schedule" class="select" id="schedule">
			<option value="yearly"<?php is_selected($recurring->schedule == 'yearly'); ?>>Yearly</option>
			<option value="quarterly"<?php is_selected($recurring->schedule == 'quarterly'); ?>>Quarterly</option>
			<option value="monthly"<?php is_selected($recurring->schedule == 'monthly'); ?>>Monthly</option>
			<option value="weekly"<?php is_selected($recurring->schedule == 'weekly'); ?>>Weekly</option>
			<option value="daily"<?php is_selected($recurring->schedule == 'daily'); ?>>Daily</option>
			<option value="other"<?php is_selected($recurring->schedule == 'other'); ?>>Other…</option>
		</select>
	</div>

	<span id="schedule_other"<?php is_display($recurring->schedule == 'other'); ?>>
		<span id="every">Every</span>
		<input type="text" name="schedule_other" class="field" value="<?php echo $recurring->schedule_other ?>" maxlength="3" />
		<span id="day">days</span>
	</span>
</div>

<div class="inline">
	<label>Start Date</label>
	<?php echo date_select($recurring->date); ?>
</div>

<div class="inline re_space">
	<label class="optional">Send Invoice</label>

	<div class="checkbox_wrapper">
		<input type="checkbox" name="send" class="checkbox" id="send_invoice_checkbox"<?php is_checked($recurring->send); ?> />
	</div>
	<em>Automatically send invoice to client.</em>
</div>

<div id="update_send"<?php is_display($recurring->send); ?>>

<div class="inline">
<label class="optional">Attach PDF</label>

<div class="checkbox_wrapper">
<input type="checkbox" name="send_attach" class="checkbox"<?php is_checked($recurring->send_attach); ?> />
</div>
<em>Attach invoice as a PDF file.</em>
</div>

<div class="inline">
	<label class="optional">Send Copy</label>

	<div class="checkbox_wrapper">
		<input type="checkbox" name="send_copy" class="checkbox"<?php is_checked($recurring->send_copy); ?> />
	</div>
	<em>Send a copy to phil@oncarbure.com</em>
</div>

<div class="inline">


<label>Email Subject</label>
<input type="text" name="send_subject" class="field subject" value="<?php echo $recurring->send_subject; ?>" />
</div>



<div class="inline last">
<div id="email_message_part">


<label>Email Message</label>
<div id="email_message">
<textarea name="send_message" class="textarea message"><?php echo $recurring->send_message; ?></textarea>
</div>

<div id="email_tags">
	<h4>Tags</h4>
	<ul>
		<li>{client_name}</li>
		<li>{client_company}</li>
		<li>{invoice_id}</li>
		<li>{invoice_amount}</li>
		<li>{invoice_date}</li>
		<li>{invoice_due_date}</li>
		<li>{invoice_link}</li>
		<li>{signature}</li>
	</ul>
</div>

</div>

</div>

</div>

<div class="edit" id="settings_part">

<div class="inline">
	<label>Due</label>

	<div class="select_wrapper">
		<select name="due" class="select" id="due">
			<option value="0"<?php is_selected($recurring->due == 0); ?>>Immediately</option>
			<option value="10"<?php is_selected($recurring->due == 10); ?>>10 Days</option>
			<option value="15"<?php is_selected($recurring->due == 15); ?>>15 Days</option>
			<option value="30"<?php is_selected($recurring->due == 30); ?>>30 Days</option>
			<option value="45"<?php is_selected($recurring->due == 45); ?>>45 Days</option>
			<option value="60"<?php is_selected($recurring->due == 60); ?>>60 Days</option>
			<option value="other"<?php $other = !in_array($recurring->due, array(0,10,15,30,45,60)); is_selected($other); ?>>Other…</option>
		</select>
	</div>

	<span id="other"<?php is_display($other); ?>>
		<input type="text" name="other" class="field" value="<?php echo $recurring->due; ?>" maxlength="3" /> Days
	</span>
</div>





<!--div class="inline">
<label>Discount (%)</label>
<div class="checkbox_wrapper">
<input type="checkbox" name="discount_status" class="checkbox" id="discount_status" />
</div>
<input type="text" name="discount" class="field small" id="discount" value="0.00" maxlength="6"  style="display: none" />
</div-->


<div class="inline">
	<label>Tax 1 (%)</label>
	<div class="checkbox_wrapper">
		<input type="checkbox" name="tax_status" class="checkbox" id="tax_status"<?php is_checked(!empty($recurring->tax)); ?> />
	</div>
	<input type="text" name="tax_name" class="field" id="tax_name" value="<?php echo $recurring->tax_name; ?>"<?php is_display(!empty($recurring->tax)); ?> /><input type="text" name="tax" class="field" id="tax" value="<?php echo my_number_format($recurring->tax, 3); ?>" maxlength="6"<?php is_display(!empty($recurring->tax)); ?> />
</div>

<div class="inline">
	<label>Tax 2 (%)</label>
	<div class="checkbox_wrapper">
		<input type="checkbox" name="tax2_status" class="checkbox" id="tax2_status"<?php is_checked(!empty($recurring->tax2)); ?> />
	</div>
	<span id="tax2_span"<?php is_display(!empty($recurring->tax2)); ?>>
		<input type="text" name="tax2_name" class="field" id="tax2_name" value="<?php echo $recurring->tax2_name; ?>" /><input type="text" name="tax2" class="field" id="tax2" value="<?php echo my_number_format($recurring->tax2, 3); ?>" maxlength="6" />
		<div class="checkbox_wrapper">
			<input type="checkbox" name="tax2_cumulative" class="checkbox" id="tax2_cumulative"<?php is_checked(!empty($recurring->tax2_cumulative)); ?> />
		</div>
		cumulative
	</span>
</div>

<!--div class="inline">
	<label>Shipping</label>
	<div class="checkbox_wrapper">
		<input type="checkbox" name="shipping_status" class="checkbox" id="shipping_status" />
	</div>
	<input type="text" name="shipping" class="field small" id="shipping" value="0.00"  style="display: none" />
</div-->


<!--div class="inline">
	<label>Currency Symbol</label>

	<div class="select_wrapper">
		<select name="currency_symbol" class="select" id="currency_symbol">
			<option value=""<?php is_selected($recurring->currency_symbol == ''); ?>>None</option>
			<option value="$"<?php is_selected($recurring->currency_symbol == '$'); ?>>$</option>
			<option value="€"<?php is_selected($recurring->currency_symbol == '€'); ?>>€</option>
			<option value="£"<?php is_selected($recurring->currency_symbol == '£'); ?>>£</option>
			<option value="￥"<?php is_selected($recurring->currency_symbol == '￥'); ?>>￥</option>
		</select>
	</div>
</div>

<div class="inline">
	<label>Currency Code</label>

	<div class="select_wrapper">
		<select name="currency_code" class="select" id="currency_code">
			<option value=""<?php is_selected($recurring->currency_code == ''); ?>>None</option>
			<option value="USD"<?php is_selected($recurring->currency_code == 'USD'); ?>>U.S. Dollars</option>
			<option value="EUR"<?php is_selected($recurring->currency_code == 'EUR'); ?>>Euros</option>
			<option value="CAD"<?php is_selected($recurring->currency_code == 'CAD'); ?>>Canadian Dollars</option>
		</select>
	</div>
</div-->

<div class="inline">
	<label>Language</label>

	<div class="select_wrapper">
		<select name="language" class="select">
			<option value="en"<?php is_selected($recurring->language == 'en'); ?>>English</option>
			<!--option value="es">Spanish</option-->
			<option value="fr"<?php is_selected($recurring->language == 'fr'); ?>>Français</option>
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
	<textarea name="notes" class="textarea notes"><?php echo $recurring->notes; ?></textarea>
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

</ul>

<a href="#" id="insert">Insert</a>


<ul class="menu" id="insert_menu" style="display: none">
	<li><a href="#" id="insert_line">Insert New Line</a></li>
	<!--li><a href="#" id="insert_project">Insert From Projects…</a></li-->
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
		<p class="subtotal_display"<?php echo is_display($recurring->subtotal != $recurring->total); ?>>Subtotal</p>
		<p class="discount_display"<?php echo is_display($recurring->discount); ?>>Discount<span id="discount_rate"></span></p>
		<p class="tax_display"<?php echo is_display($recurring->tax); ?>><span id="tax_name_update">Tax</span><span id="tax_rate"></span></p>
		<p class="tax2_display"<?php echo is_display($recurring->tax2); ?>><span id="tax2_name_update">Tax</span><span id="tax2_rate"></span></p>
		<!--p class="shipping_display" style="display: none">Shipping</p-->
		<p class="total_display">Total</p>
	</div>

	<div class="right">
		<p class="subtotal_display"<?php echo is_display($recurring->subtotal != $recurring->total); ?>><span class="currency_symbol"></span><span id="subtotal_result"><?php echo my_number_format($recurring->subtotal); ?></span><span class="currency_code"> <?php echo $recurring->currency_code; ?></span></p>
		<p class="discount_display"<?php echo is_display($recurring->discount); ?>>-<span class="currency_symbol"></span><span id="discount_result">-<?php echo my_number_format($recurring->discount_fee); ?></span><span class="currency_code"> <?php echo $recurring->currency_code; ?></span></p>
		<p class="tax_display"<?php echo is_display($recurring->tax); ?>><span class="currency_symbol"></span><span id="tax_result"><?php echo my_number_format($recurring->tax_fee); ?></span><span class="currency_code"> <?php echo $recurring->currency_code; ?></span></p>
		<p class="tax2_display"<?php echo is_display($recurring->tax2); ?>><span class="currency_symbol"></span><span id="tax2_result"><?php echo my_number_format($recurring->tax2_fee); ?></span><span class="currency_code"> <?php echo $recurring->currency_code; ?></span></p>
		<!--p class="shipping_display"<?php if (empty($recurring->shipping)) echo ' style="display: none"'; ?>><span class="currency_symbol"></span><span id="shipping_result"><?php echo my_number_format($recurring->shipping); ?></span><span class="currency_code"> <?php echo $recurring->currency_code; ?></span></p-->
		<p class="total_display"><span class="currency_symbol"></span><span id="total_result"><?php echo my_number_format($recurring->total); ?></span><span class="currency_code"> <?php echo $recurring->currency_code; ?></span></p>
	</div>

</div>
	
</div>

<input type="submit" class="button" id="save_changes" value="Save Changes" />

</form>

</div>
