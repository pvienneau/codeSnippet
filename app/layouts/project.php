<?php $ctrl = Dispatcher::getController(); $action = Dispatcher::getAction(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
	<title>Project Management | <?php echo $ctrl; ?></title>

	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
	
	<base href="<?php echo BASE_URL ?>">
	
	<link rel="stylesheet" type="text/css" media="all" href="css/reset.css" />
	<link rel="stylesheet" type="text/css" media="all" href="css/project-management.css" />
	
	<script type="text/javascript" charset="utf-8" src="js/jquery.min.js"></script>
	<script type="text/javascript" charset="utf-8" src="js/jquery.calendarlite.js"></script>
	<script type="text/javascript" charset="utf-8" src="js/basecamp.js"></script>

</head>
<body>
<div id="head">
	<!--ul id="shortcut">
		<li><a href="user/edit/<?php echo AuthUser::getId(); ?>"><?php echo AuthUser::getUserName(); ?></a></li>
		<li><a href="user">Users</a></li>
		<li><a href="settings">Settings</a></li>
		<li><a href="logout" id="logout">Logout</a></li>
	</ul-->
	<?php if (!empty($project)) echo '<h1><b>p.</b> '.$project->name.'</h1>'; ?>
	<div id="nav"><ul>
		<li<?php if ($ctrl == 'project' and $action == 'dashboard') echo ' class="current"'; ?>><a href="project/dashboard">dashboard</a></li>
		<li<?php if ($ctrl == 'project' and $action == 'overview') echo ' class="current"'; ?>><a href="project/<?php echo $project->id ?>/overview">overview</a></li>
		<li<?php if ($ctrl == 'todo') echo ' class="current"'; ?>><a href="project/<?php echo $project->id ?>/todo">to-do</a></li>
		<li<?php if ($ctrl == 'milestone') echo ' class="current"'; ?>><a href="project/<?php echo $project->id ?>/milestone">milestone</a></li>
		<!--li<?php if ($ctrl == 'file') echo ' class="current"'; ?>><a href="project/<?php echo $project->id ?>/file">file</a></li-->
		<li class="projects right">
			<span>Change project</span>
			<ul class="no-style">
			<?php foreach (Project::findAll() as $p): ?>
				<li><a href="project/<?php echo $p->id; ?>/overview"><?php echo $p->name; ?></a></li>
			<?php endforeach; ?>
			</ul>
		</li>
	</ul></div>
</div>
<div id="main">

<!-- begin layout content -->
<?php echo $content_for_layout ?>
<!-- end layout content -->

</div><!-- end #main -->
</body>
</html>