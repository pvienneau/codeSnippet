<?php

$ctrl = Dispatcher::getController();
$action = Dispatcher::getAction();
$params = Dispatcher::getParams();

if ($action == 'day') 
	$date = $params[0];

$yesterday = strtotime('-1 days');
$before_yesterday = strtotime('-2 days');

$users = User::findAll('is_active=1 ORDER BY name');

?>
<div id="toggle-report" onclick="$('#toggle-quick-entry').removeClass('current'); $(this).toggleClass('current'); $('#quick-entry').slideUp(); $('#report').slideToggle();"></div>
<div id="toggle-quick-entry" onclick="$('#toggle-report').removeClass('current'); $(this).toggleClass('current'); $('#report').slideUp(); $('#quick-entry').slideToggle();"></div>

<div id="report"<?php if ($ctrl != 'report') echo ' class="hide"' ?>>
	<div class="tab<?php if ($action == 'last_month') echo ' current'; ?>" onclick="$('#report .tab').removeClass('current'); $(this).addClass('current'); $('#form-report').attr('action', 'report/last_month');">Last Month</div>
	<div class="tab<?php if ($action == 'last_week') echo ' current'; ?>" onclick="$('#report .tab').removeClass('current'); $(this).addClass('current'); $('#form-report').attr('action', 'report/last_week');">Last Week</div>
	<div class="tab<?php if ($action == 'today') echo ' current'; ?>" onclick="$('#report .tab').removeClass('current'); $(this).addClass('current'); $('#form-report').attr('action', 'report/today');">Today</div>
	<div class="tab<?php if ($action == 'this_week') echo ' current'; ?>" onclick="$('#report .tab').removeClass('current'); $(this).addClass('current'); $('#form-report').attr('action', 'report/this_week');">This Week</div>
	<div class="tab<?php if ($action == 'this_month' || !in_array($action, array('last_month','last_week','today','this_week','day'))) echo ' current'; ?>" onclick="$('#report .tab').removeClass('current'); $(this).addClass('current'); $('#form-report').attr('action', 'report');">This Month</div>
	<div class="tab cal right<?php if ($action == 'day') echo ' current'; ?>" onclick="$('#report .tab').removeClass('current'); $(this).addClass('current'); $('.calendar', this).toggleClass('hide')"><span class="label"><?php echo empty($date) ? 'Calendar': date('M j', strtotime($date)); ?></span><div class="calendar hide"><script type="text/javascript">$('#report .calendar').calendarLite({onSelect: function(date) { $('#report .calendar').toggleClass('hide'); $('#form-report').attr('action', 'report/day/'+date); $('#report .tab .label').text(trackr.humanizeDate(date)); return false; }});</script></div></div>

	<form id="form-report" action="report/<?php echo $action == 'day' ? 'day/'.$date: $action; ?>" method="post">
	  <input type="text" id="report-project" name="report[project]" title="CLIENT OR PROJECT" />
	  <input type="text" id="report-tags" maxlength="255" name="report[tags]" title="TAGS" />
	  <button type="submit" class="button submit">Run It</button>
	</form>
	
	<ul class="users no-style">
<?php foreach ($users as $user): ?>
		<li onclick="$(this).toggleClass('selected');" class="selected"><img src="_/img/<?php echo $user->id; ?>_s.png" align="absmiddle" /> <?php echo $user->username; ?></li>
<?php endforeach; ?>
	</ul>
	<div class="clear"></div>
</div><!-- /#report -->

<div id="quick-entry"<?php if ($ctrl != 'time') echo ' class="hide"' ?>>
	<div class="tab" onclick="$('#quick-entry .tab').removeClass('current'); $(this).addClass('current'); $('#entry-created_on').val('<?php echo date('Y-m-d', $before_yesterday); ?>');"><?php echo date('M j', $before_yesterday); ?></div>
	<div class="tab" onclick="$('#quick-entry .tab').removeClass('current'); $(this).addClass('current'); $('#entry-created_on').val('<?php echo date('Y-m-d', $yesterday); ?>');"><?php echo date('M j', $yesterday); ?></div>
	<div class="tab current" onclick="$('#quick-entry .tab').removeClass('current'); $(this).addClass('current'); $('#entry-created_on').val('');">Today</div>
	<div class="tab cal" onclick="$('#quick-entry .tab').removeClass('current'); $(this).addClass('current'); $('.calendar', this).toggleClass('hide')"><span class="label">Calendar</span><div class="calendar hide"><script type="text/javascript">$('#quick-entry .calendar').calendarLite({onSelect: function(date) { $('#quick-entry .calendar').toggleClass('hide'); $('#entry-created_on').val(date); $('#quick-entry .tab .label').text(trackr.humanizeDate(date)); return false; }});</script></div></div>

	<form id="form-quick-entry" action="time/add" method="post">
	  <input type="hidden" id="entry-created_on" name="entry[created_on]" value="" />
	  <input class="" type="text" id="entry-duration" name="entry[duration]" title="HOURS" maxlength="5" />
	  <input class="" type="text" id="entry-project" name="project" title="CLIENT OR PROJECT" />
	  <input class="" type="text" id="entry-description" maxlength="255" name="entry[description]" title="TAGS OR DESCRIPTION" />
	  <button type="submit" class="button submit">Log It</button>
	</form>
	<p>Logged for today: <b><?php echo Entry::hoursFrom(AuthUser::getId()); ?></b></p>
</div><!-- /#quick-entry -->

<br />