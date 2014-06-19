<?php $company = Settings::company(); $ctrl = Dispatcher::getController(); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title><?php echo $company->name . ' | ' . $ctrl; ?></title>

	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
	
	<base href="<?php echo BASE_URL ?>">
	
	<link rel="stylesheet" type="text/css" media="all" href="css/trackr.css" />
	<link rel="stylesheet" type="text/css" media="all" href="css/foundation.css" />
	<link rel="stylesheet" type="text/css" media="all" href="css/application.css" />
	<link rel="stylesheet" type="text/css" media="all" href="css/invoice_grey.css" />
	
	<script type="text/javascript" charset="utf-8" src="js/jquery.js"></script>
	<script type="text/javascript" charset="utf-8" src="js/jquery.plugins.js"></script>
	<script type="text/javascript" charset="utf-8" src="js/jquery.application.js"></script>
	
	<script type="text/javascript" charset="utf-8" src="js/jquery.fieldselection.pack.js"></script>
	<script type="text/javascript" charset="utf-8" src="js/jquery.asuggest.js"></script>
	<script type="text/javascript" charset="utf-8" src="js/jquery.autocomplete.js"></script>
	<script type="text/javascript" charset="utf-8" src="js/jquery.calendarlite.js"></script>
	<script type="text/javascript" charset="utf-8" src="js/jquery.defaultvalue.js"></script>
	<script type="text/javascript" charset="utf-8" src="js/raphael-min.js"></script>
	<script type="text/javascript" charset="utf-8" src="js/raphael.pieChart.js"></script>

	<script type="text/javascript" charset="utf-8" src="js/trackr.shared.js"></script>
	<script type="text/javascript" charset="utf-8" src="js/trackr.js"></script>
	<script type="text/javascript" charset="utf-8" src="js/raphael.path.methods.js"></script>
	<script type="text/javascript" charset="utf-8" src="js/raphael.analytics.js"></script>
	
	<script type="text/javascript" charset="utf-8" src="js/general.js"></script>

</head>
<body>
<?php if (Flash::get('error') != null) { ?>
	<div id="error" onclick="this.style.display = 'none'"><?php echo Flash::get('error') ?></div>
<?php } ?>
<?php if (Flash::get('success') != null) { ?>
	<div id="success" onclick="this.style.display = 'none'"><?php echo Flash::get('success') ?></div>
<?php } ?>
<div id="head">
	<div id="head_inner">
		<h1 id="logo"><a href="<?php url(); ?>"><?php echo $company->name; ?></a></h1>
		<ul id="shortcut">
			<li><a href="user/edit/<?php echo AuthUser::getId(); ?>"><?php echo AuthUser::getUserName(); ?></a></li>
			
				<?php if(AuthUser::accessLevel("users") > 0): ?><li><a href="user"><?php echo __('Users');?></a></li><?php endif; ?>
				<?php if(AuthUser::isAdmin()): ?><li><a href="settings"><?php echo __('Settings');?></a></li><?php endif; ?>
			<li><a href="logout" id="logout"><?php echo __('Logout');?></a></li>
		</ul>
		<ul id="nav">
			<?php if(AuthUser::accessLevel("invoices") > 0): ?><li><a href="invoice"<?php if ($ctrl == 'invoice') echo ' class="current"'; ?> id="invoice"><?php echo __('Invoices');?></a></li><?php endif; ?>
			<?php if(AuthUser::accessLevel("estimates") > 0): ?><li><a href="estimate"<?php if ($ctrl == 'estimate') echo ' class="current"'; ?> id="estimate"><?php echo __('Estimate');?></a></li><?php endif; ?>
			<?php if(AuthUser::accessLevel("recurrings") > 0): ?><li><a href="recurring"<?php if ($ctrl == 'recurring') echo ' class="current"'; ?> id="recurring"><?php echo __('Recurring');?></a></li><?php endif; ?>
			<?php if(AuthUser::accessLevel("clients") > 0): ?><li><a href="client"<?php if ($ctrl == 'client') echo ' class="current"'; ?> id="client"><?php echo __('Clients');?></a></li><?php endif; ?>
			<!--li><a href="project"<?php if ($ctrl == 'project') echo ' class="current"'; ?> id="project">Projects</a></li-->
			<!--li><a href="task"<?php if ($ctrl == 'task') echo ' class="current"'; ?> id="task">Tasks</a></li-->
			<!--li><a href="item"<?php if ($ctrl == 'item') echo ' class="current"'; ?> id="item">Items</a></li-->			
		</ul>
	</div>
</div>
<div id="container">
<div id="page">

<!-- begin layout content -->
<?php echo $content_for_layout ?>
<!-- end layout content -->

</div><!-- end #page -->
</div><!-- end #container -->
</body>
</html>