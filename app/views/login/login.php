<?php $company = Settings::company();?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title><?php echo $company->name; ?> | Login</title>
	<base href="<?php echo BASE_URL ?>">
	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
	<meta http-equiv="content-language" content="en-us" />

	<link rel="stylesheet" type="text/css" media="all" href="css/foundation.css" />
	<link rel="stylesheet" type="text/css" media="all" href="css/application.css" />

	<script type="text/javascript" src="js/jquery.js"></script>
	<script type="text/javascript" src="js/jquery.plugins.js"></script>
	<script type="text/javascript" src="js/jquery.application.js"></script>
</head>
<body id="login">

<div id="container">

<div id="box">

<div id="login_head"><h1 id="logo"><?php echo $company->name; ?></h1></div>

	<div id="login_part">
		<form action="<?php echo get_url('login/login') ?>" method="post">
			<label><?php echo __('Username');?></label>
			<input type="text" name="username" class="field" />
			<label><?php echo __('Password');?></label>
			<input type="password" name="password" class="field" />
			<a href="#" id="forgot"><?php echo __('Forgot your password');?>?</a>
			<input type="submit" class="button" id="login" value="<?php echo __('Login');?>" />
		</form>
	</div>

	<div id="forgot_part" style="display: none">
		<form action="<?php echo get_url('login/forgot') ?>" method="post">
			<label><?php echo __('Email');?></label>
			<input type="text" name="email" class="field" />
			<input type="submit" class="button" id="reset" value="<?php echo __('Reset');?>" /><a href="#" class="small_button"><?php echo __('Cancel');?></a>
		</form>
	</div>

</div>

</div>

</body>
</html>