<?php use_helper('Date'); ?>
<div class="content new_section" id="new_user_section" style="display: none">

<ul class="sidebar">

<li>
<a href="#" id="cancel">Cancel</a>
</li>

</ul>

<h3 class="title">New User</h3>

<div class="box">

<form action="user/add" method="post">

	<div class="inline">
		<label>Name</label>
		<input type="text" name="name" class="field" value="" />
	</div>

	<div class="inline">
		<label>Email</label>
		<input type="text" name="email" class="field" value="" />
	</div>

	<div class="inline">
		<label>Username</label>
		<input type="text" name="username" class="field" value="" />
	</div>

	<div class="inline">
		<label>New Password</label>
		<input type="password" name="password" class="field" value="" autocomplete="off" />
	</div>
	<div class="inline">
		<label>Confirm Password</label>
		<input type="password" name="confirm" class="field" value="" autocomplete="off" />
	</div>
	<div class="inline">
		<label class="optional">Address Line 1</label>
		<input type="text" name="address_line_1" class="field" value="" />
	</div>
	
	<div class="inline">
		<label class="optional">Address Line 2</label>
		<input type="text" name="address_line_2" class="field" value="" />
	</div>
	
	<div class="inline">
		<label class="optional">City</label>
		<input type="text" name="city" class="field" value="" />
	</div>
	
	<div class="inline">
		<label class="optional">ZIP Code</label>
		<input type="text" name="zip_code" class="field" value="" />
	</div>
	
	<div class="inline">
		<label class="optional">State</label>
		<input type="text" name="state" class="field" value="" />
	</div>
	
	<div class="inline">
		<label>Country</label>
		<div class="select_wrapper">
			<select name="country" class="select" id="country">
				<?php echo country_select_option(); ?>
			</select>
		</div>
	</div>
	
	<div class="inline">
		<label class="optional">Phone Number</label>
		<input type="text" name="phone_number" class="field" value="" />
	</div>
	
	
	<?php if (AuthUser::isAdmin()): ?>
	<div class="inline re_space">
		<label class="optional">Is Admin</label>
	
		<div class="checkbox_wrapper">
			<input type="checkbox" name="is_admin" class="checkbox"  id="is_admin_checkbox" />
		</div>
		<em>Admins have full access in all sections</em>
	</div>
	
	<div class="inline">
		<label>Invoices</label>
	
		<div class="select_wrapper">
			<select name="invoices" class="select" id="invoices_select">
				<?php echo User::accessOptions(); ?>
			</select>
		</div>
	</div>
	<div class="inline">
		<label>Estimates</label>
	
		<div class="select_wrapper">
			<select name="estimates" class="select" id="estimates_select">
				<?php echo User::accessOptions(); ?>
			</select>
		</div>
	</div>
	<div class="inline">
		<label>Recurrings</label>
	
		<div class="select_wrapper">
			<select name="recurrings" class="select" id="recurrings_select">
				<?php echo User::accessOptions(); ?>
			</select>
		</div>
	</div>
	<div class="inline">
		<label>Clients</label>
	
		<div class="select_wrapper">
			<select name="clients" class="select" id="clients_select">
				<?php echo User::accessOptions(); ?>
			</select>
		</div>
	</div>
	<div class="inline">
		<label>Users</label>
	
		<div class="select_wrapper">
			<select name="users" class="select" id="users_select">
				<?php echo User::accessOptions(); ?>
			</select>
		</div>
	</div>
	<div class="inline re_space">
		<label class="optional">Is Active</label>
	
		<div class="checkbox_wrapper">
			<input type="checkbox" name="is_active" class="checkbox" checked="checked" id="is_active_checkbox" />
		</div>
	</div>
	<?php endif; ?>



	<div class="inline control">
		<input type="submit" class="button" id="save_changes" value="Save Changes" />
	</div>

</form>

</div>

</div>

<div class="content main_section" id="users_section">
<?php if(AuthUser::accessLevel("users") > 1): ?>
<ul class="sidebar">
	<li><a href="#" id="new">New User</a></li>
</ul>
<?php endif; ?>	
<h3 class="title">Users</h3>

<ul>

<li id="bar">
	<span class="name">Name</span>
	<span class="email">Email</span>
	<span class="last_login">Last Login</span>
</li>

</ul>

<ul class="rows">

<?php foreach($users as $user): ?>
<li class="row" id="<?php echo $user->id; ?>">
<?php if(AuthUser::accessLevel("users") > 1): ?>
<span class="actions" style="display: none">
	<a href="#" class="remove">Remove</a><a href="user/edit/<?php echo $user->id; ?>" class="edit">Edit</a>
</span>
<?php endif; ?>
<span class="name">
	<?php echo $user->image(); ?>
	<span class="in_name"><?php echo $user->name; ?></span>
	<?php if ($user->is_admin): ?>
		<span class="admin">Admin</span>
	<?php endif; ?>
	<?php if (!$user->is_active): ?>
		<span class="inactive">Inactive</span>
	<?php endif; ?>
	
	<a href="#" class="show_address" style="display: none">Show Address</a>
	<span class="address" style="display: none">


	<?php if (!empty($user->address_line_1)): ?>
		<p><?php echo $user->address_line_1; ?></p>
	<?php endif; ?>
	<?php if (!empty($user->address_line_2)): ?>
		<p><?php echo $user->address_line_2; ?></p>
	<?php endif; ?>
	<?php if (!empty($user->city) || !empty($user->state)): ?>
		<p><?php echo $user->city.' '.$user->state; ?></p>
	<?php endif; ?>
	<?php if (!empty($user->zip_code)): ?>
		<p><?php echo $user->zip_code; ?></p>
	<?php endif; ?>
	<?php if (!empty($user->country)): ?>
		<p><?php echo $user->country; ?></p>
	<?php endif; ?>
	<?php if (!empty($user->phone_number)): ?>
		<p><?php echo $user->phone_number; ?></p>
	<?php endif; ?>
	<p><a href="http://maps.google.com/maps?f=q&hl=en&geocode=&q=<?php echo urlencode($user->address_line_1.' '.$user->address_line_2.' '.$user->city.' '.$user->state.' '.$user->zip_code.' '.$user->country); ?>" class="blank">Google Map</a></p>


	</span>
	
	
</span>
<span class="email"><a href="mailto:<?php echo $user->email; ?>"><?php echo $user->email; ?></a></span>
<span class="last_login"><?php echo time_ago_in_words(strtotime($user->last_login)); ?></span>

</li>
<?php endforeach; ?>
</ul>

</div>