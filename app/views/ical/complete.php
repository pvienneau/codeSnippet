<?php

/*
	BEGIN:VTODO
	DTSTAMP:19980130T134500Z
	SEQUENCE:2
	UID:uid4@host1.com
	ORGANIZER:MAILTO:unclesam@us.gov
	ATTENDEE;PARTSTAT=ACCEPTED:MAILTO:jqpublic@host.com
	DUE:19980415T235959
	STATUS:NEEDS-ACTION
	SUMMARY:Submit Income Taxes
	END:VTODO
*/
$last_modif = date('Ymd\THis\Z');
$ts = time();
?>
BEGIN:VCALENDAR
CALSCALE:GREGORIAN
X-WR-CALNAME:carbure milestone
X-WR-TIMEZONE:US/Eastern
VERSION:2.0
<?php foreach (Milestone::findAll() as $milestone): $time = strtotime($milestone->due_on); ?>
BEGIN:VEVENT
DTSTART;VALUE=DATE:<?php echo date('Ymd', $time).PHP_EOL ?>
DTEND;VALUE=DATE:<?php echo date('Ymd', $time + 86400).PHP_EOL ?>
SUMMARY:<?php echo $milestone->title .' ['.$milestone->project_name.']'.PHP_EOL ?>
DESCRIPTION:<?php if ($milestone->assigned_to) { echo $milestone->assigned_name.' is responsible\n\n'; } url('project/'.$milestone->project_id.'/milestone') ?> 
UID:<?php echo $milestone->id.PHP_EOL ?>
LAST-MODIFIED:<?php echo $last_modif.PHP_EOL ?>
SEQUENCE:<?php echo $ts.PHP_EOL ?>
END:VEVENT
<?php endforeach; ?>
END:VCALENDAR