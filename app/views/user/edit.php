<div class="content edit_section" id="edit_user_section">
	
<h3 class="title"><?php echo __('Edit User');?></h3>

<div class="box">

<form action="user/edit/<?php echo $user->id; ?>" method="post" autocomplete="off" >

<div class="inline">
	<label><?php echo __('Name');?></label>
	<input type="text" name="name" class="field" value="<?php echo $user->name; ?>" />
</div>

<div class="inline">
	<label><?php echo __('Email');?></label>
	<input type="text" name="email" class="field" value="<?php echo $user->email; ?>" />
</div>

<div class="inline">
	<label><?php echo __('Username');?></label>
	<input type="text" name="username" class="field" value="<?php echo $user->username; ?>" />
	<input type="password" name="oldpassword" class="field" style="display:none;" />
</div>

<div class="inline">
	<label class="optional"><?php echo __('Address Line');?> 1</label>
	<input type="text" name="address_line_1" class="field" value="<?php echo $user->address_line_1; ?>" />
</div>

<div class="inline">
	<label class="optional"><?php echo __('Address Line');?> 2</label>
	<input type="text" name="address_line_2" class="field" value="<?php echo $user->address_line_2; ?>" />
</div>

<div class="inline">
	<label class="optional"><?php echo __('City');?></label>
	<input type="text" name="city" class="field" value="<?php echo $user->city; ?>" />
</div>

<div class="inline">
	<label class="optional"><?php echo __('ZIP Code');?></label>
	<input type="text" name="zip_code" class="field" value="<?php echo $user->zip_code; ?>" />
</div>

<div class="inline">
	<label class="optional"><?php echo __('State');?></label>
	<input type="text" name="state" class="field" value="<?php echo $user->state; ?>" />
</div>

<div class="inline">
	<label><?php echo __('Country');?></label>
	<div class="select_wrapper">
		<select name="country" class="select" id="country">
			<?php echo country_select_option($user->country); ?>
		</select>
	</div>
</div>

<div class="inline">
	<label class="optional"><?php echo __('Phone Number');?></label>
	<input type="text" name="phone_number" class="field" value="<?php echo $user->phone_number; ?>" />
</div>


<?php if (AuthUser::isAdmin()): ?>
<div class="inline re_space">
	<label class="optional"><?php echo __('Is Admin');?></label>

	<div class="checkbox_wrapper">
		<input type="checkbox" name="is_admin" class="checkbox"  id="is_admin_checkbox"<?php is_checked($user->is_admin); ?> />
	</div>
	<em><?php echo __('Admins have full access in all sections');?></em>
</div>

<div class="inline">
	<label><?php echo __('Invoices');?></label>

	<div class="select_wrapper">
		<select name="invoices" class="select" id="invoices_select">
			<?php echo User::accessOptions($user->invoices); ?>
		</select>
	</div>
</div>
<div class="inline">
	<label><?php echo __('Estimates');?></label>

	<div class="select_wrapper">
		<select name="estimates" class="select" id="estimates_select">
			<?php echo User::accessOptions($user->estimates); ?>
		</select>
	</div>
</div>
<div class="inline">
	<label><?php echo __('Recurrings');?></label>

	<div class="select_wrapper">
		<select name="recurrings" class="select" id="recurrings_select">
			<?php echo User::accessOptions($user->recurrings); ?>
		</select>
	</div>
</div>
<div class="inline">
	<label><?php echo __('Clients');?></label>

	<div class="select_wrapper">
		<select name="clients" class="select" id="clients_select">
			<?php echo User::accessOptions($user->clients); ?>
		</select>
	</div>
</div>
<div class="inline">
	<label><?php echo __('Users');?></label>

	<div class="select_wrapper">
		<select name="users" class="select" id="users_select">
			<?php echo User::accessOptions($user->users); ?>
		</select>
	</div>
</div>
<div class="inline re_space">
	<label class="optional"><?php echo __('Is Active');?></label>

	<div class="checkbox_wrapper">
		<input type="checkbox" name="is_active" class="checkbox" id="is_active_checkbox"<?php is_checked($user->is_active); ?> />
	</div>
</div>
<?php endif; ?>
<h4><?php echo __('Change password');?></h4>
<div class="inline">
	<label><?php echo __('New Password');?></label>
	<input type="password" name="newpassword" class="field" value="" autocomplete="off" />
</div>
<div class="inline">
	<label><?php echo __('Confirm Password');?></label>
	<input type="password" name="confirm" class="field" value="" autocomplete="off" />
</div>

<div class="inline control">
	<input type="submit" class="button" id="save_changes" value="<?php echo __('Save Changes');?>" />
</div>

</form>

<?php if (AuthUser::isAdmin() || AuthUser::getId() == $user->id): ?>
<form id="change-picture-<?php echo $user->id; ?>" action="user/picture/<?php echo $user->id; ?>" enctype="multipart/form-data" method="post"><label class="cabinet inline"><input class="file" type="file" name="filename" onchange="$('#change-picture-<?php echo $user->id; ?>').submit();" /></label></form>
<?php endif; ?>

</div>
</div>
