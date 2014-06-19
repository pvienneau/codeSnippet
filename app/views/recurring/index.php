<div class="content new_section" id="new_recurring_section" style="display: none">

<ul class="sidebar">
	<li><a href="#" id="cancel"><?php echo __('Cancel');?></a></li>
</ul>

<?php include_view('client/update_new_dialog'); ?>

<h3 class="title"><?php echo __('New Recurring Template');?></h3>

<div class="box">

<div class="information">
	<p><?php echo __('Recurring templates are created and added to your Invoices section on their scheduled date.');?></p>
</div>

<form action="recurring/add" method="post" id="recurring_form">

<div class="inline">
	<label><?php echo __('Name');?></label>
	<input type="text" name="name" class="field" />
</div>

<div id="update_clients">

	<div class="inline">
		<label><?php echo __('Client');?></label>
		<div class="select_wrapper">
			<select name="client_id" class="select" id="client_select">
				<option value="new_client"><?php echo __('New Client');?>…</option>
				<option value="" selected="selected"> </option>
				<?php echo $clients_options = clients_select_option(); ?>
			</select>
		</div>
	</div>

</div>

<div class="inline">
	<label><?php echo __('Schedule');?></label>
	<div class="select_wrapper">
		<select name="schedule" class="select" id="schedule">
			<option value="yearly"><?php echo __('Yearly');?></option>
			<option value="quarterly"><?php echo __('Quarterly');?></option>
			<option value="monthly" selected="selected"><?php echo __('Monthly');?></option>
			<option value="weekly"><?php echo __('Weekly');?></option>
			<option value="daily"><?php echo __('Daily');?></option>
			<option value="other"><?php echo __('Other');?>…</option>
		</select>
	</div>
	<span id="schedule_other" style="display: none">
		<span id="every"><?php echo __('Every');?></span>
		<input type="text" name="schedule_other" class="field" value="7" maxlength="3" />
		<span id="day"><?php echo __('days');?></span>
	</span>
</div>

<div class="inline">
	<label><?php echo __('Start Date');?></label>
	<?php echo date_select(); ?>
</div>

<div class="inline">
	<label class="optional"><?php echo __('Create invoice now');?></label>
	<div class="checkbox_wrapper">
		<input type="checkbox" name="create_invoice" class="checkbox" id="create_invoice_checkbox" />
	</div>
	<em><?php echo __('Create a new invoice based on this template on save.');?></em>
</div>

<?php /*
<div class="inline">
	<label class="optional">Send Invoice</label>
	<div class="checkbox_wrapper">
		<input type="checkbox" name="send" class="checkbox" id="send_invoice_checkbox" />
	</div>
	<em>Automatically send invoice to client.</em>
</div>
*/ ?>
<div id="update_send" style="display: none">

<div class="inline">
	<label class="optional"><?php echo __('Attach PDF');?></label>
	<div class="checkbox_wrapper">
		<input type="checkbox" name="send_attach" class="checkbox" checked="checked" />
	</div>
	<em><?php echo __('Attach invoice as a PDF file.');?></em>
</div>

<div class="inline">
	<label class="optional"><?php echo __('Send Copy');?></label>
	<div class="checkbox_wrapper">
		<input type="checkbox" name="send_copy" class="checkbox" />
	</div>
	<em><?php echo __('Send a copy to');?> <?php echo $company->email; ?></em>
</div>

<div class="inline">
	<label><?php echo __('Email Subject');?></label>
	<input type="text" name="send_subject" class="field subject" value="Invoice {invoice_id}" />
</div>



<div class="inline last">

<div id="email_message_part">


<label><?php echo __('Email Message');?></label>
<div id="email_message">
<textarea name="send_message" class="textarea message">Hello {client_name},

Here is the invoice of {invoice_amount}.

You can view the invoice online at:

{invoice_link}

{signature}</textarea>
</div>

<div id="email_tags">
	<h4><?php echo __('Tags');?></h4>
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
</div><!-- #inline last -->

</div><!-- #update send -->

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


<!--div class="inline">
	<label>Discount (%)</label>
	<div class="checkbox_wrapper">
		<input type="checkbox" name="discount_status" class="checkbox" id="discount_status" />
	</div>
	<input type="text" name="discount" class="field small" id="discount" value="0.00" maxlength="6" style="display: none" />
</div-->

<div class="inline">
	<label><?php echo __('Tax');?> 1 (%)</label>
	<div class="checkbox_wrapper">
		<input type="checkbox" name="tax_status" class="checkbox" id="tax_status" />
	</div>
	<input type="text" name="tax_name" class="field" id="tax_name" value="TPS" style="display: none" /><input type="text" name="tax" class="field" id="tax" value="0.00" maxlength="6" style="display: none" />
</div>

<div class="inline">
	<label><?php echo __('Tax');?> 2 (%)</label>
	<div class="checkbox_wrapper">
		<input type="checkbox" name="tax2_status" class="checkbox" id="tax2_status" />
	</div>
	<span id="tax2_span" style="display: none">
		<input type="text" name="tax2_name" class="field" id="tax2_name" value="TVQ" /><input type="text" name="tax2" class="field" id="tax2" value="0.00" maxlength="6" />
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
			<option value="none">None</option>
			<option value="USD">U.S. Dollars</option>
			<option value="EUR">Euros</option>
			<option value="CAD" selected="selected">Canadian Dollars</option>
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
	<label><?php echo __('Notes');?></label>
	<textarea name="notes" class="textarea notes"><?php echo __('Thank You!');?></textarea>
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
		<span class="price"><input type="text" name="line[0][price]" class="field" value="70.00"/></span>
		<span class="total"><span class="total_line">70.00</span></span>
	
	</li>
	
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
</div><!-- end #insert_item_dialog -->


<div id="subtotal">
	<div class="left">
		<p class="subtotal_display" style="display: none"><?php echo __('Subtotal');?></p>
		<!--p class="discount_display" style="display: none">Discount<span id="discount_rate"></span></p-->
		<p class="tax_display" style="display: none"><span id="tax_name_update"><?php echo __('Tax');?></span><span id="tax_rate"></span></p>
		<p class="tax2_display" style="display: none"><span id="tax2_name_update"><?php echo __('Tax');?></span><span id="tax2_rate"></span></p>
		<!--p class="shipping_display" style="display: none">Shipping</p-->
		<p class="total_display"><?php echo __('Total');?></p>
	</div>
	
	<div class="right">
		<p class="subtotal_display" style="display: none"><span class="currency_symbol"></span><span id="subtotal_result">0.00</span><span class="currency_code"></span></p>
		<!--p class="discount_display" style="display: none">-<span class="currency_symbol"></span><span id="discount_result">0.00</span><span class="currency_code"></span></p-->
		<p class="tax_display" style="display: none"><span class="currency_symbol"></span><span id="tax_result">0.00</span><span class="currency_code"></span></p>
		<p class="tax2_display" style="display: none"><span class="currency_symbol"></span><span id="tax2_result">0.00</span><span class="currency_code"></span></p>
		<!--p class="shipping_display" style="display: none"><span class="currency_symbol"></span><span id="shipping_result">0.00</span><span class="currency_code"></span></p-->
		<p class="total_display"><span class="currency_symbol"></span><span id="total_result">70.00</span><span class="currency_code"></span></p>
	</div>
</div>



</div><!-- #line_part -->

<input type="submit" class="button" id="add_recurring" value="<?php echo __('Add Template');?>" />

</form>

</div>

</div><div class="content main_section" id="recurring_section">
<?php if(AuthUser::accessLevel("recurrings") > 1): ?>
<ul class="sidebar">
	<li><a href="#" id="new"><?php echo __('New Template');?></a></li>
</ul>
<?php endif; ?>

<h3 class="title"><?php echo __('Recurring Templates');?></h3>

<ul>

<li id="bar">
	<span class="name"><?php echo __('Name');?></span>
	<span class="client"><?php echo __('Client');?></span>
	<span class="schedule"><?php echo __('Schedule');?></span>
	<span class="active"><?php echo __('Active');?></span>
</li>

</ul>

<ul class="rows">

<?php foreach($recurrings as $recurring): ?>
	<li class="row" id="<?php echo $recurring->id; ?>">
		<?php if(AuthUser::accessLevel("recurrings") > 1): ?>
			<span class="actions" style="display: none">
				<a href="#" class="remove"><?php echo __('Remove');?></a>
				<a href="recurring/edit/<?php echo $recurring->id; ?>" class="edit"><?php echo __('Edit');?></a>
			</span>
		<?php endif; ?>
		<span class="name"><a href="recurring/view/<?php echo $recurring->id; ?>"><?php echo $recurring->name; ?></a></span>
		<span class="client"><?php echo $recurring->client; ?></span>
		<span class="schedule" title="Upcoming: ...">
		<?php echo __($recurring->schedule); ?> <br> <small><?php echo my_date_format($recurring->date); ?></small>
		</span>

		<span class="active">
		<?php if(AuthUser::accessLevel("recurrings") > 1): ?>
			<?php echo $recurring->is_active ? '<a href="recurring/desactivate/'.$recurring->id.'">'.__('On').'</a>' : '<a href="recurring/activate/'.$recurring->id.'">'.__('Off').'</a>'; ?>
		<?php else: ?>
			<?php echo $recurring->is_active ? __('On') : __('Off'); ?>
		<?php endif; ?>
	
		</span>

	</li>
<?php endforeach; ?>
</ul>

</div>
