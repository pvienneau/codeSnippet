<?php
$days = array('Sun','Mon','Tue','Wed','Thu','Fri','Sat');
$start_week_day = date('w');

$arr = array();
foreach ($upcoming as $milestone) {
	$date = substr($milestone->due_on, 0, 10);
	if (!isset($arr[$date]))
		$arr[$date] = array();
	$arr[$date][] = $milestone;
}

?>
<small><b>Due in the next 21 days</b></small>
<table cellspacing="0" class="dashcal">
  <thead><tr>
<?php for ($i = $start_week_day; $i < $start_week_day + 7; $i++): ?>
      <th><?php echo isset($days[$i]) ? $days[$i]: array_pop($days) ?></th>
<?php endfor; ?>
  </tr></thead>
  <tbody><tr>
<?php for ($i = 0; $i < 21; $i++): $time = strtotime('+'.$i.' days'); $date = date('Y-m-d', $time); ?>
	<td<?php if (!empty($arr[$date])) echo ' class="with"'; ?>>
      <?php echo $i == 0 ? 'TODAY': date('j', $time); ?>
	  <?php if (!empty($arr[$date])): ?>
		<ul>
		<?php foreach($arr[$date] as $milestone): ?>
			<li><?php echo $milestone->title; ?></li>
		<?php endforeach; ?>
		</ul>
	  <?php endif; ?>
    </td>
	<?php if ($i == 6 or $i == 13) echo '</tr><tr>'; ?>
<?php endfor; ?>
  </tr>
</tbody></table>