<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
	<title>Timer</title>

	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
	<base href="<?php echo BASE_URL ?>">
	
	<link rel="stylesheet" type="text/css" media="all" href="css/foundation.css" />
	<link rel="stylesheet" type="text/css" media="all" href="css/application.css" />

	<script type="text/javascript" src="js/jquery.js"></script>
	<script type="text/javascript" src="js/jquery.plugins.js"></script>
	<script type="text/javascript" src="js/jquery.application.js"></script>
</head>

<body id="timer">

<div id="container">
	<div id="timer_part">
		<form action="project/add_time" method="post">
			<div id="top">
				<div id="time">00:00:00</div>
				<div id="start" class="not_started"></div>
				<a href="javascript://" id="reset">Reset</a>
			</div>
			<div id="selection">
				<div id="select_project">
					Select a task
					<div class="select_wrapper">
						<select name="project" class="select">
							<!--option value="new_project">New Project…</option>
							<option value=""  selected="selected"></option-->
							<?php echo tasks_select_option(); ?>
						</select>
					</div>
					<input type="hidden" name="time" value="00:00:00" />
					<input type="submit" class="button" id="add_time" value="Add Time" />
				</div>
			</div>
		</form>
	</div>
</div>

<!--div id="update_new_project_part">
	<div id="new_project_part_wrapper" style="display: none">
		<div id="new_project_part">
			<form action="project/add" method="post">
				<div class="inline">
					<label>Description</label>
					<input type="text" name="description" class="field" value="" />
				</div>

				<div class="inline">
					<label>Hours</label>
					<input type="text" name="hours" class="field" value="0.00" />
				</div>

				<div class="inline">
					<label>Rate</label>
					<input type="text" name="rate" class="field" value="0.00" />
				</div>

				<input type="submit" class="button" id="add_project" value="Add Project" />

				<a href="javascript://" class="small_button">Cancel</a>
			</form>
		</div>
	</div>
</div-->

</body>
</html>