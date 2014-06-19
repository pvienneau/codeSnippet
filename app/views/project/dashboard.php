<?php use_helper('Date'); $today = date('Y-m-d'); ?>

<div id="dashboard">

<h2>Projects overview & activity</h2>

<div class="box-milestones">
<h3>Late &  Upcoming Milestones</h3>

<?php foreach (Milestone::late() as $milestone): ?>
	<div class="late">
		<b class="date"><?php echo pretty_date(strtotime($milestone->due_on)); ?></b>: 
		<a href="project/<?php echo $milestone->project_id ?>/milestone"><?php echo $milestone->title ?></a>
		<?php if ($milestone->assigned_to) echo '<small>('.minimize_name($milestone->assigned_name).' is responsible)</small>'; ?>
	</div>
<?php endforeach; ?>

<?php include_view('milestone/quick-table', array('upcoming' => Milestone::upcoming())); ?>

</div><!-- end .box-milestones -->

<table class="overview">

<?php $curr_date = false; foreach (Activity::all() as $event): ?>
<?php if ($event->date != $curr_date): $curr_date = $event->date; ?>
  <tr class="date">
    <td colspan="4">
      <h2 class="date">
		<?php if ($curr_date == $today): ?>
          <span class="today">Today</span>
		<?php else: ?>
		  <span><?php echo my_full_date_format($curr_date) ?></span>
		<?php endif; ?>
      </h2>
    </td>
  </tr>
<?php endif; ?>

  <tr class="event" id="event_<?php echo $event->id ?>">
    <td class="what">
      <span class="<?php echo $event->what ?>"><?php echo $event->what ?></span>
    </td>
    <td class="item"><?php echo $event->item ?></td>
    <td class="action"><?php echo $event->action ?></td>
    <td class="name"><?php echo minimize_name(empty($event->user_name)?'Anyone': $event->user_name) ?></td>
  </tr>
<?php endforeach; ?>
</table>

</div><!-- end #dashboard -->
<div id="sidebar">
	
	<a href="<?php echo str_replace('http://', 'webcal://', get_url('ical')); ?>" class="ical-link"><img src="images/project/ical.gif" width="17" height="19" alt="Ical" align="absmiddle"> Global iCalendar</a> Get milestones from all your projects in a single iCalendar feed. 
</div>