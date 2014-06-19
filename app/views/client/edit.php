<div class="content edit_section" id="edit_client_section">

	
<h3 class="title"><?php echo __('Edit Client');?></h3>

<div class="box">

<form action="client/edit/<?php echo $client->id; ?>" method="post">

<form action="clients" method="post">

<div id="update_client">

<div class="inline">
	<label><?php echo __('Name');?></label>
	<input type="text" name="name" class="field" value="<?php echo $client->name; ?>" />
</div>

<div class="inline space">
	<label><?php echo __('Email');?></label>
	<input type="text" name="email" class="field" value="<?php echo $client->email; ?>" />
</div>

<div class="inline">
	<label class="optional"><?php echo __('Company');?></label>
	<input type="text" name="company" class="field" value="<?php echo $client->company; ?>" />
</div>

<div class="inline">
	<label class="optional"><?php echo __('Address Line');?> 1</label>
	<input type="text" name="address_line_1" class="field" value="<?php echo $client->address_line_1; ?>" />
</div>

<div class="inline">
	<label class="optional"><?php echo __('Address Line');?> 2</label>
	<input type="text" name="address_line_2" class="field" value="<?php echo $client->address_line_2; ?>" />
</div>

<div class="inline">
	<label class="optional"><?php echo __('City');?></label>
	<input type="text" name="city" class="field" value="<?php echo $client->city; ?>" />
</div>

<div class="inline">
	<label class="optional"><?php echo __('ZIP Code');?></label>
	<input type="text" name="zip_code" class="field" value="<?php echo $client->zip_code; ?>" />
</div>

<div class="inline">
	<label class="optional"><?php echo __('State');?></label>
	<input type="text" name="state" class="field" value="<?php echo $client->state; ?>" />
</div>

<div class="inline">
	<label><?php echo __('Country');?></label>
	<div class="select_wrapper">
		<select name="country" class="select" id="country">
			<?php echo country_select_option($client->country); ?>
		</select>
	</div>
</div>

<div class="inline">
	<label class="optional"><?php echo __('Phone Number');?></label>
	<input type="text" name="phone_number" class="field" value="<?php echo $client->phone_number; ?>" />
</div>
<div class="inline">
	<label><?php echo __('Tax');?> 1 (%)</label>
	<div class="checkbox_wrapper">
		<input type="checkbox" name="tax_status" class="checkbox" id="tax_status"<?php is_checked(!empty($client->tax)); ?> />
	</div>
	<input type="text" name="tax_name" class="field" id="tax_name" value="Tax"  style="display: none" /><input type="text" name="tax" class="field" id="tax" value="<?php echo my_number_format($client->tax, 3); ?>" maxlength="6"<?php is_display(!empty($client->tax)); ?> />
</div>

<div class="inline">
	<label><?php echo __('Tax');?> 2 (%)</label>
	<div class="checkbox_wrapper">
		<input type="checkbox" name="tax2_status" class="checkbox" id="tax2_status"<?php is_checked(!empty($client->tax2)); ?> />
	</div>
	<span id="tax2_span"<?php is_display(!empty($client->tax2)); ?>>
		<input type="text" name="tax2_name" class="field" id="tax2_name" value="<?php echo $client->tax2_name; ?>" /><input type="text" name="tax2" class="field" id="tax2" value="<?php echo my_number_format($client->tax2, 3); ?>" maxlength="6" />
		<div class="checkbox_wrapper">
			<input type="checkbox" name="tax2_cumulative" class="checkbox" id="tax2_cumulative"<?php is_checked(!empty($client->tax2_cumulative)); ?> />
		</div>
		<?php echo __('cumulative');?>
	</span>
</div>

<div class="inline last">
	<label class="optional"><?php echo __('Tax ID');?></label>
	<input type="text" name="tax_id" class="field" value="<?php echo $client->tax_id; ?>" />
</div>

</div>


<div class="inline control">
	<input type="submit" class="button add" value="<?php echo __('Save Changes');?>" />
</div>

</form>

</div>

</div>