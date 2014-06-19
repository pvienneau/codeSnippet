<div class="content new_section" id="new_client_section" style="display: none">

<ul class="sidebar">
	<li><a href="#" id="cancel"><?php echo __('Cancel');?></a></li>
</ul>

<h3 class="title"><?php echo __('New Client');?></h3>

<div class="box">

<form action="client/add" method="post">

<div id="update_client">

	<div class="inline">
		<label><?php echo __('Name');?></label>
		<input type="text" name="name" class="field" />
	</div>

	<div class="inline space">
		<label><?php echo __('Email');?></label>
		<input type="text" name="email" class="field" />
	</div>

	<div class="inline">
		<label class="optional"><?php echo __('Company');?></label>
		<input type="text" name="company" class="field" />
	</div>

	<div class="inline">
		<label class="optional"><?php echo __('Address Line');?> 1</label>
		<input type="text" name="address_line_1" class="field" />
	</div>

	<div class="inline">
		<label class="optional"><?php echo __('Address Line');?> 2</label>
		<input type="text" name="address_line_2" class="field" />
	</div>

	<div class="inline">
		<label class="optional"><?php echo __('City');?></label>
		<input type="text" name="city" class="field" />
	</div>

	<div class="inline">
		<label class="optional"><?php echo __('ZIP Code');?></label>
		<input type="text" name="zip_code" class="field" />
	</div>

	<div class="inline">
		<label class="optional"><?php echo __('State');?></label>
		<input type="text" name="state" class="field" />
	</div>

	<div class="inline">
		<label><?php echo __('Country');?></label>
		<div class="select_wrapper">
		<select name="country" class="select" id="country">
			<?php echo country_select_option(); ?>
		</select>
		</div>
	</div>
	
	<div class="inline">
		<label class="optional"><?php echo __('Phone Number');?></label>
		<input type="text" name="phone_number" class="field" />
	</div>

	<div class="inline">
		<label><?php echo __('Tax');?> 1 (%)</label>
		<div class="checkbox_wrapper">
			<input type="checkbox" name="tax_status" class="checkbox" id="tax_status"<?php is_checked(!empty($company->tax)); ?> />
		</div>
		<input type="text" name="tax_name" class="field" id="tax_name" value="<?php echo $company->tax_name; ?>" /><input type="text" name="tax" class="field" id="tax" value="<?php echo my_number_format($company->tax, 3); ?>" maxlength="6"<?php is_display(!empty($company->tax)); ?> />
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
		<input type="text" name="tax_id" class="field" />
	</div>

</div>


<div class="inline control">
	<input type="submit" class="button add" value="Add Client" />
</div>

</form>

</div>

</div>

<div class="content main_section" id="clients_section">
<?php if(AuthUser::accessLevel("clients") > 1): ?>

	<ul class="sidebar">
		<li><a href="#" id="new"><?php echo __('New Client');?></a></li>
	</ul>
<?php endif; ?>

<h3 class="title"><?php echo __('Clients');?></h3>

<ul>
<li id="bar">
	<span class="company"><?php echo __('Company');?></span>
	<span class="name"><?php echo __('Name');?></span>
	<span class="email"><?php echo __('Email');?></span>
</li>

</ul>

<ul class="rows">

<?php foreach($clients as $client): ?>
<li class="row" id="<?php echo $client->id; ?>">
<?php if(AuthUser::accessLevel("clients") > 1): ?>
	<span class="actions" style="display: none">
		<a href="#" class="remove"><?php echo __('Remove');?></a>
		<a href="client/edit/<?php echo $client->id; ?>" class="edit"><?php echo __('Edit');?></a>
	</span>
<?php endif; ?>
<span class="company"><em><?php echo $client->company; ?></em>

	<a href="#" class="show_address" style="display: none"><?php echo __('Show Address');?></a>
	<span class="address" style="display: none">


	<?php if (!empty($client->address_line_1)): ?>
		<p><?php echo $client->address_line_1; ?></p>
	<?php endif; ?>
	<?php if (!empty($client->address_line_2)): ?>
		<p><?php echo $client->address_line_2; ?></p>
	<?php endif; ?>
	<?php if (!empty($client->city) || !empty($client->state)): ?>
		<p><?php echo $client->city.' '.$client->state; ?></p>
	<?php endif; ?>
	<?php if (!empty($client->zip_code)): ?>
		<p><?php echo $client->zip_code; ?></p>
	<?php endif; ?>
	<?php if (!empty($client->country)): ?>
		<p><?php echo $client->country; ?></p>
	<?php endif; ?>
	<?php if (!empty($client->phone_number)): ?>
		<p><?php echo $client->phone_number; ?></p>
	<?php endif; ?>
	<a href="http://maps.google.com/maps?f=q&hl=en&geocode=&q=<?php echo urlencode($client->address_line_1.' '.$client->address_line_2.' '.$client->city.' '.$client->state.' '.$client->zip_code.' '.$client->country); ?>" class="blank"><?php echo __('Google Map');?></a>


	</span>
</span>
<span class="name"><p><?php echo $client->name; ?></p></span>
<span class="email"><a href="mailto:<?php echo $client->email; ?>"><?php echo $client->email; ?></a></span>

</li>
<?php endforeach; ?>


</ul>

</div>