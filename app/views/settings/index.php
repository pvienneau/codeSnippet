<div class="content" id="settings_section">
	
<h3 class="title"><?php echo __('Settings');?></h3>

<?php /*?><ul id="tab">
	<li><a href="#" class="current"><span><?php echo __('Company Details');?></span></a></li>
	<li><a href="#"><span><?php echo __('General');?></span></a></li>
	<li><a href="#"><span><?php echo __('Invoices');?></span></a></li>
	<li><a href="#"><span><?php echo __('Email Messages');?></span></a></li>
	<li><a href="#"><span><?php echo __('PayPal Integration');?></span></a></li>
</ul><?php */?>

<div class="box" id="show_account_details">

<form method="post" action="settings/company">

<div class="inline">
	<label><?php echo __('Company Name');?></label>
	<input type="text" class="field" name="name" value="<?php echo $company->name; ?>" />
</div>

<div class="inline">
	<label class="optional"><?php echo __('Address Line');?> 1</label>
	<input type="text" class="field" name="address_line_1" value="<?php echo $company->address_line_1; ?>" />
</div>

<div class="inline">
	<label class="optional"><?php echo __('Address Line');?> 2</label>
	<input type="text" class="field" name="address_line_2" value="<?php echo $company->address_line_2; ?>" />
</div>

<div class="inline">
	<label class="optional"><?php echo __('City');?></label>
	<input type="text" class="field" name="city" value="<?php echo $company->city; ?>" />
</div>

<div class="inline">
	<label class="optional"><?php echo __('ZIP Code');?></label>
	<input type="text" class="field" name="zip_code" value="<?php echo $company->zip_code; ?>" />
</div>

<div class="inline">
	<label class="optional"><?php echo __('State');?></label>
	<input type="text" class="field" name="state" value="<?php echo $company->state; ?>" />
</div>

<div class="inline">
	<label><?php echo __('Country');?></label>
	<div class="select_wrapper"><span>Canada</span>
		<select id="country" class="select" name="country">
			<?php echo country_select_option($company->country); ?>
		</select>
	</div>
</div>

<div class="inline">
	<label class="optional"><?php echo __('Phone Number');?></label>
	<input type="text" name="phone_number" class="field" value="<?php echo $company->phone_number; ?>" />
</div>

<div class="inline ">
	<label><?php echo __('Email');?></label>
	<input type="text" name="email" class="field" value="<?php echo $company->email; ?>" />
</div>

<div class="inline">
	<label><?php echo __('Tax');?> 1 (%)</label>
	<div class="checkbox_wrapper">
		<input type="checkbox" name="tax_status" class="checkbox" id="tax_status"<?php is_checked(!empty($company->tax)); ?> />
	</div>
	<input type="text" name="tax_name" class="field" id="tax_name" value="<?php echo $company->tax_name; ?>" <?php is_checked(!empty($company->tax)); ?> /><input type="text" name="tax" class="field" id="tax" value="<?php echo my_number_format($company->tax, 3); ?>" maxlength="6"<?php is_display(!empty($company->tax)); ?> />
</div>

<div class="inline">
	<label><?php echo __('Tax');?> 2 (%)</label>
	<div class="checkbox_wrapper">
		<input type="checkbox" name="tax2_status" class="checkbox" id="tax2_status"<?php is_checked(!empty($company->tax2)); ?> />
	</div>
	<span id="tax2_span"<?php is_display(!empty($company->tax2)); ?>>
		<input type="text" name="tax2_name" class="field" id="tax2_name" value="<?php echo $company->tax2_name; ?>" /><input type="text" name="tax2" class="field" id="tax2" value="<?php echo my_number_format($company->tax2, 3); ?>" maxlength="6" />
		<div class="checkbox_wrapper">
			<input type="checkbox" name="tax2_cumulative" class="checkbox" id="tax2_cumulative"<?php is_checked(!empty($company->tax2_cumulative)); ?> />
		</div>
		cumulative
	</span>
</div>

<div class="inline last">
	<label class="optional"><?php echo __('Tax ID');?></label>
	<input type="text" class="field" name="tax_id" value="<?php echo $company->tax_id; ?>" />
</div>

<!--div class="inline last">
	<label class="optional">Tax ID Name</label>
	<input type="text" value="" class="field" name="tax_name"/>
</div-->

<div class="inline control">
	<input type="submit" value="<?php echo __('Save Changes');?>" id="save_changes" class="button"/>
</div>

</form>

</div><!-- end #show_account_details -->






<div class="box" id="show_general_settings" style="display: none">

<?php /*?><div class="information">
	<p><?php echo __('Here you can personalize The Invoice Machine such as time zone, date and number format. You can also add your own application logo.');?></p>
</div>
<?php */?>
<form action="settings/general" method="post" enctype="multipart/form-data">


<div class="inline">
	<label><?php echo __('Timezone');?></label>

	<div class="select_wrapper">
		<select name="timezone" class="select">
			<option value="UM12">(UTC - 12:00) Eniwetok, Kwajalein</option>
			<option value="UM11">(UTC - 11:00) Nome, Midway Island, Samoa</option>
			<option value="UM10">(UTC - 10:00) Hawaii</option>
			<option value="UM9">(UTC - 9:00) Alaska</option>
			<option value="UM8">(UTC - 8:00) Pacific Time</option>
			<option value="UM7">(UTC - 7:00) Mountain Time</option>
			<option value="UM6">(UTC - 6:00) Central Time, Mexico City</option>
			<option value="UM5" selected="selected">(UTC - 5:00) Eastern Time, Bogota, Lima, Quito</option>
			<option value="UM4">(UTC - 4:00) Atlantic Time, Caracas, La Paz</option>
			<option value="UM25">(UTC - 3:30) Newfoundland</option>
			<option value="UM3">(UTC - 3:00) Brazil, Buenos Aires, Georgetown, Falkland Is.</option>
			<option value="UM2">(UTC - 2:00) Mid-Atlantic, Ascension Is., St. Helena</option>
			<option value="UM1">(UTC - 1:00) Azores, Cape Verde Islands</option>
			<option value="UTC">(UTC) Casablanca, Dublin, Edinburgh, London, Lisbon, Monrovia</option>
			<option value="UP1">(UTC + 1:00) Berlin, Brussels, Copenhagen, Madrid, Paris, Rome</option>
			<option value="UP2">(UTC + 2:00) Kaliningrad, South Africa, Warsaw</option>
			<option value="UP3">(UTC + 3:00) Baghdad, Riyadh, Moscow, Nairobi</option>
			<option value="UP25">(UTC + 3:30) Tehran</option>
			<option value="UP4">(UTC + 4:00) Abu Dhabi, Baku, Muscat, Tbilisi</option>
			<option value="UP35">(UTC + 4:30) Kabul</option>
			<option value="UP5">(UTC + 5:00) Islamabad, Karachi, Tashkent</option>
			<option value="UP45">(UTC + 5:30) Mumbai, Kolkata, Chennai, New Delhi</option>
			<option value="UP6">(UTC + 6:00) Almaty, Colomba, Dhaka</option>
			<option value="UP7">(UTC + 7:00) Bangkok, Hanoi, Jakarta</option>
			<option value="UP8">(UTC + 8:00) Beijing, Hong Kong, Perth, Singapore, Taipei</option>
			<option value="UP9">(UTC + 9:00) Osaka, Sapporo, Seoul, Tokyo, Yakutsk</option>
			<option value="UP85">(UTC + 9:30) Adelaide, Darwin</option>
			<option value="UP10">(UTC + 10:00) Melbourne, Papua New Guinea, Sydney, Vladivostok</option>
			<option value="UP11">(UTC + 11:00) Magadan, New Caledonia, Solomon Islands</option>
			<option value="UP12">(UTC + 12:00) Auckland, Wellington, Fiji, Marshall Islands</option>
		</select>
	</div>
</div>

<?php /*?><div class="inline">
	<label>Daylight Saving</label>
	<div class="checkbox_wrapper">
		<input type="checkbox" name="dst" class="checkbox" checked="checked" />
	</div>
</div><?php */?>

<?php /*?><div class="inline">
	<label>Date Format</label>

	<div class="select_wrapper">
		<select name="date_format" class="select">
			<option value="01">12/06/2009</option>
			<option value="02">12/06/09</option>
			<option value="03">06.12.2009</option>
			<option value="04">06.12.09</option>
			<option value="05">06-12-2009</option>
			<option value="06">06-12-09</option>
			<option value="07">06/12/2009</option>
			<option value="08">06/12/09</option>
			<option value="09">12.06.2009</option>
			<option value="10">12.06.09</option>
			<option value="11">12-06-2009</option>
			<option value="12">12-06-09</option>
			<option value="13" selected="selected">06 Dec 2009</option>
			<option value="14">06 Dec 09</option>
			<option value="15">2009-12-06</option>
			<option value="16">09-12-06</option>
		</select>
	</div>
</div>

<div class="inline">
	<label>Number Format</label>
	<div class="select_wrapper">
		<select name="my_number_format" class="select">
			<option value="1">1 000,00</option>
			<option value="2" selected="selected">1 000.00</option>
		</select>
	</div>
</div><?php */?>

<div class="inline control">
	<input type="submit" class="button" id="save_changes" value="<?php echo __('Save Changes');?>" />
</div>

</form>

</div>



<div>


<div class="box" id="show_invoice_settings" style="display: none">

<?php /*?><div class="information">
	<p><?php echo __('Here you can specify your default invoice settings so you don\'t need to enter them every time. You can override all these settings except, logo, color theme and footer text when you create a new invoice. The color theme, logo and footer will impact all invoices, including already existing ones.');?></p>
</div><?php */?>

<form action="settings/invoice" method="post" enctype="multipart/form-data">

<div class="inline">
	<label><?php echo __('Due');?></label>

	<div class="select_wrapper">
		<select name="due" class="select" id="due">
			<option value="0"><?php echo __('Immediately');?></option>
			<option value="10">10 <?php echo __('Days');?></option>
			<option value="15" selected="selected">15 <?php echo __('Days');?></option>
			<option value="30">30 <?php echo __('Days');?></option>
			<option value="45">45 <?php echo __('Days');?></option>
			<option value="60">60 <?php echo __('Days');?></option>
			<option value="other"><?php echo __('Other');?>…</option>
		</select>
	</div>

	<span id="other" style="display: none">
		<input type="text" name="other" class="field" value="0" maxlength="3" /> <?php echo __('Days');?>
	</span>
</div>

<?php /*?><div class="inline">
	<label>Discount (%)</label>
	<input type="text" name="discount" class="field small" value="0.00" />
</div><?php */?>

<div class="inline">
	<label><?php echo __('Tax');?> 1 (%)</label>
	<input type="text" name="tax_name" class="field" id="tax_name" value="TPS" /><input type="text" name="tax" class="field" id="tax" value="5.00" maxlength="6" />
</div>

<div class="inline">
	<label><?php echo __('Tax');?> 2 (%)</label>
	<input type="text" name="tax2_name" class="field" id="tax2_name" value="TVQ" /><input type="text" name="tax2" class="field" id="tax2" value="7.50" maxlength="6" />
	<div class="checkbox_wrapper">
		<input type="checkbox" name="tax2_cumulative" class="checkbox" id="tax2_cumulative" checked="checked" />
	</div>
	<?php echo __('cumulative');?>
</div>

<?php /*?><div class="inline">
<label>Tax 2 (%)</label>
<input type="text" name="tax_name_02" class="field" id="tax_name_02" value="Tax" /><input type="text" name="tax_02" class="field" id="tax_02" value="0.00" maxlength="6" />
</div>

<div class="inline">
	<label>Shipping</label>
	<input type="text" name="shipping" class="field small" value="0.00" />
</div><?php */?>

<div class="inline">
	<label><?php echo __('Currency Symbol');?></label>
	<div class="select_wrapper">
		<select name="currency_symbol" class="select">
			<option value="" selected="selected">None</option>
			<option value="$">$</option>
			<option value="€">€</option>
			<option value="£">£</option>
			<option value="￥">￥</option>
		</select>
	</div>
</div>


<div class="inline">
	<label><?php echo __('Currency Code');?></label>

	<div class="select_wrapper">
		<select name="currency_code" class="select">
			<option value="none"><?php echo __('None');?></option>
			<option value="USD"><?php echo __('U.S. Dollars');?></option>
			<option value="EUR"><?php echo __('Euros');?></option>
			<option value="CAD" selected="selected"><?php echo __('Canadian Dollars');?></option>
		</select>
	</div>
</div>



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

<div class="inline">
	<label><?php echo __('Display Country');?></label>
	<div class="checkbox_wrapper">
		<input type="checkbox" name="display_country" class="checkbox" checked="checked" />
	</div>
	<em><?php echo __('You can turn this off if invoicing within your own country.');?></em>
</div>

<div class="inline">
	<label><?php echo __('Notes');?></label>
	<textarea name="notes" class="textarea notes"><?php echo __('Thank You!');?></textarea>
</div>

<?php /*?><div id="invoice_logo">
	<div class="inline">
		<label>Invoice Logo</label>
		<input type="file" name="invoice_logo" size="20" />
		<div class="image_details">
			<p>The invoice logo image must be <strong>920x160 pixels</strong> and in <strong>GIF or PNG format</strong> without transparency. You can <a href="downloads/invoice_logo_template.zip">Download the invoice logo template</a> and use as a reference.</p>
		</div>
	</div>
</div>


<div class="inline last">
	<label>Footer Text</label>
	<div class="with">
		<em>Change or remove the branded footer text.</em>
		<input type="text" name="foot" class="field largest" value="Philippe Archambault - http://www.philworks.com" />
	</div>
</div><?php */?>

<div class="inline control">
	<input type="submit" class="button" id="save_changes" value="<?php echo __('Save Changes');?>" />
</div>



</form>

</div>




<?php /*?><div class="box" id="show_email_message_settings" style="display: none">

<div class="message purple">
	<a class="close" href="#">Close</a>
	<h2>Not done yet!</h2>
	<p>We are sorry, the paypal integration has not been done yet.</p>
</div>
	
<div class="information">
	<p>You can customize the emails you send to your clients. You can also choose if you want to run in automatic mode, then you don't have to worry to whom you have sent reminder or thank you emails to, The Invoice Machine will automatically send it for you.</p>
</div>

<form action="settings/email" method="post" enctype="multipart/form-data">

<div class="inline">
	<label>Automatic Mode</label>

	<div class="checkbox_wrapper">
		<input type="checkbox" name="automatic_mode" class="checkbox" />
	</div>
	Send Thank you and Reminder emails automatically.
</div>

<div class="inline">
	<label>Invoice Email</label>
	<div class="with">
		<input type="text" name="invoice_email_subject" class="field" value="Invoice {invoice_id}" />
		<textarea name="invoice_email_message" class="textarea largest">Hello {client_name},

Here is the invoice of {invoice_amount}.

You can view the invoice online at:

{invoice_link}

{signature}</textarea>

		<input type="hidden" class="default_subject" value="Invoice {invoice_id}" />

		<textarea class="default_message" style="display: none">
Hello {client_name},

Here is the invoice of {invoice_amount}.

You can view the invoice online at:

{invoice_link}

{signature}</textarea>

		<div class="tags">
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
			<a href="#" class="small_button">Restore</a>
		</div>

	</div>
</div>

<div class="inline">
	<label>Thank You Email</label>
	<div class="with">
		<input type="text" name="thank_you_email_subject" class="field" value="Thank You" />
		<textarea name="thank_you_email_message" class="textarea largest">Hello {client_name},

We have received the payment for invoice {invoice_id}, thank you!

You can view the invoice online at:

{invoice_link}

{signature}</textarea>

		<input type="hidden" class="default_subject" value="Thank You" />

		<textarea class="default_message" style="display: none">
Hello {client_name},

We have received the payment for invoice {invoice_id}, thank you!

You can view the invoice online at:

{invoice_link}

{signature}</textarea>

		<div class="tags">
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
			<a href="#" class="small_button">Restore</a>
		</div>

	</div>
</div>

<div class="inline">
	<label>Reminder Email</label>
	<div class="with">
		<input type="text" name="reminder_email_subject" class="field" value="Reminder" />
		<textarea name="reminder_email_message" class="textarea largest">Hello {client_name},

Just a reminder that Invoice {invoice_id} was due on {invoice_due_date}. Please make the payment of {invoice_amount} as soon as possible.

You can view the invoice online at:

{invoice_link}

{signature}</textarea>

		<input type="hidden" class="default_subject" value="Reminder" />

		<textarea class="default_message" style="display: none">
Hello {client_name},

Just a reminder that Invoice {invoice_id} was due on {invoice_due_date}. Please make the payment of {invoice_amount} as soon as possible.

You can view the invoice online at:

{invoice_link}

{signature}</textarea>

		<div class="tags">
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
			<a href="#" class="small_button">Restore</a>
		</div>

	</div>
</div>

<div class="inline last">
	<label>Signature</label>
	<div class="with">
		<textarea name="signature" class="textarea medium">Best regards,
{name}

{company}</textarea>

		<textarea class="default_message" style="display: none">
Best regards,
{name}

{company}</textarea>

		<div class="tags last">
			<h4>Tags</h4>
			<ul>
				<li>{name}</li>
				<li>{company}</li>
			</ul>
			<a href="#" class="small_button">Restore</a>
		</div>

	</div>
</div>

<div class="inline control">
	<input type="submit" class="button" id="save_changes" value="Save Changes" />
</div>

</form>

</div>


<?php */?>

<?php /*?>
<div class="box" id="show_paypal_intergration_settings" style="display: none">

<div class="message purple">
	<a class="close" href="#">Close</a>
	<h2>Not done yet!</h2>
	<p>We are sorry, the paypal integration has not been done yet.</p>
</div>

<div class="information">
	<p>You can easily let your clients pay you with PayPal by enabling the PayPal integration. A PayPal payment link will be generated and placed on the client's invoice page. The Invoice Machine will be automatically notified and will add the payment to the history and change the status to Paid when an invoice is fully paid. Your client doesn't need a PayPal account to pay you, just a credit card. If you don't have a PayPal account you can <a href="https://www.paypal.com/se/mrb/pal=JAJA3ZGAG69AW" class="blank">signup for one free</a>.</p>
</div>

<form action="settings/paypal" method="post">

<div class="inline">
	<label>Enabled</label>
	<div class="checkbox_wrapper">
		<input type="checkbox" name="paypal_enabled" class="checkbox" />
	</div>
</div>

<div class="inline">
	<label>PayPal Email</label>
	<input type="text" name="paypal_email" class="field" value="" />
</div>

<div class="inline">
	<label>Secondary Currency</label>

<div class="select_wrapper">
	<select name="paypal_currency" class="select">
		<option value="AUD">Australian Dollars</option>
		<option value="GBP">British Pounds</option>
		<option value="CAD" selected="selected">Canadian Dollars</option>
		<option value="CZK">Czech Koruna</option>
		<option value="DKK">Danish Kroner</option>
		<option value="HKD">Hong Kong Dollars</option>
		<option value="HUF">Hungarian Forint</option>
		<option value="ILS">Israeli New Shekels</option>
		<option value="JPY">Japanese Yen</option>
		<option value="MXN">Mexican Pesos</option>
		<option value="NZD">New Zealand Dollars</option>
		<option value="NOK">Norwegian Kroner</option>
		<option value="PLN">Polish Zlotych</option>
		<option value="SGD">Singapore Dollars</option>
		<option value="SEK">Swedish Kronor</option>
		<option value="CHF">Swiss Francs</option>
		<option value="USD">U.S. Dollars</option>
	</select>
</div>

</div>

<div class="inline last">
	<label>Notification</label>
	<div class="checkbox_wrapper">
		<input type="checkbox" name="paypal_notification" class="checkbox" />
	</div>
	Send a notification by email when a payment is made.

</div>




<div class="inline control">
	<input type="submit" class="button" id="save_changes" value="Save Changes" />
</div>

</form>

</div>

<?php */?>



</div>