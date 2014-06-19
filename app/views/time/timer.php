<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
	<title>Timer</title>

	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
	<base href="<?php echo BASE_URL ?>">
	
	<link rel="stylesheet" type="text/css" media="all" href="css/timer.css" />

	<script type="text/javascript" charset="utf-8" src="js/jquery.js"></script>
	<script type="text/javascript" charset="utf-8" src="js/trackr.shared.js"></script>
	<script type="text/javascript" charset="utf-8" src="js/timer.js"></script>
</head>

<body id="timer">
<?php if (Flash::get('error') !== null): ?>
        <div id="error" style="display: none" onclick="$(this).fadeOut();"><?php echo Flash::get('error'); ?></div>
        <script type="text/javascript">$('#error').fadeIn();</script>
<?php endif; ?>
<?php if (Flash::get('success') !== null): ?>
        <div id="success" style="display: none" onclick="$(this).fadeOut();"><?php echo Flash::get('success'); ?></div>
        <script type="text/javascript">$('#success').fadeIn();</script>
<?php endif; ?>
<div id="container">
	<div id="timer_part">
		<form action="time/timer_log" method="post">
			<div id="top">
				<div id="time">&nbsp;</div>
			</div>
			<!--input type="hidden" id="entry-created_on" name="timer[created_on]" value="" /-->
			<div id="log-box" class="hide">
				<h3>&nbsp;</h3>
				<input type="hidden" id="timer-project" name="project_id" />
				<input class="" type="text" id="timer-duration" name="duration" title="HOURS" maxlength="5" />
				<input class="" type="text" id="timer-description" maxlength="255" name="description" title="TAGS OR DESCRIPTION" />
				<button type="submit" class="button submit">Log It</button>
				<div class="links">
					<a class="cancel" href="javascript://">cancel</a> or
					<a class="discard" href="time/timer_discard/">discard entry</a>
				</div>
			</div>
		</form>
	</div>
</div>
<ul id="projects">
<?php foreach (Project::findAll() as $project): $timer = Timer::fromProject($project->id); ?>
	<li id="project-<?php echo $project->id; ?>" <?php if ($timer && $timer->status == 'open') echo 'class="current"'; ?>>
		<span><?php echo $project->name; ?></span> <b><?php if ($timer) echo format_duration($timer->duration). 'h'; ?></b>
		<img class="check<?php if (!$timer) echo ' hide'; ?>" src="images/timer/check.png" width="36" height="24" alt="Log It" />
		<img class="pause<?php if (!$timer or $timer->status == 'stop') echo ' hide'; ?>" src="images/timer/pause.png" width="36" height="24" alt="Pause" />
		<img class="play<?php if ($timer and $timer->status == 'open') echo ' hide'; ?>" src="images/timer/play.png" width="36" height="24" alt="Play" />
	</li>
<?php endforeach; ?>
</ul>

</body>
</html>