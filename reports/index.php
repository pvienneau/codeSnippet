<?php

session_start();

if (!isset($_SESSION['invoice.auth.user']) or !isset($_SESSION['invoice.auth.user']['username']))
	exit;

include '../config.php';

class Client { }

$PDO = new PDO(DB_DSN, DB_USER, DB_PASS);
$PDO->exec("set names 'utf8'");

$sql = 'SELECT * FROM client WHERE deleted=0 AND id != 1 ORDER BY name';

$clients = $PDO->query($sql, PDO::FETCH_CLASS, 'Client');

// -------------------------------------------------------------

$from = isset($_POST['from']) ? preg_replace('/[^0-9\-]/', '', $_POST['from']): date('Y-m-d', strtotime('-3 months'));
$to = isset($_POST['to']) ? preg_replace('/[^0-9\-]/', '', $_POST['to']): date('Y-m-d');

$client_id = !empty($_POST['client_id']) ? (int) $_POST['client_id']: '';

$where_date = " AND `date` >= '$from' AND `date` <= '$to'";
$where_client = empty($client_id) ? '': " AND client_id = $client_id";

function echo_number($n) { echo number_format($n, 2, '.', ' '); }

?><!DOCTYPE html>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>Carbure - Reports</title>
	
<style type="text/css">

body { font: normal 13px/18px arial, sans-serif; color: #333; }
.green { color: green; }
.red { color: red; }

table       { margin-bottom: 1.4em; }
th          { font-weight: bold; }
thead th 		{ background: #eee; }
th,td,caption { padding: 4px 10px 4px 5px; border-bottom: 1px solid #ddd }
tr.even td  { background: #e5ecf9; }
tfoot       { font-style: italic; }
caption     { background: #eee; }
td.right { text-align:right }

h1 { font-weight: normal; }

</style>
	
</head>
<body>

<form action="index.php" method="post">
<select name="client_id" onchange="this.submit()">
	<option value="">All clients</option>
<?php foreach($clients as $client): ?>
	<option value="<?php echo $client->id ?>"<?php if ($client->id == $client_id) echo ' selected="selected"'; ?>><?php echo empty($client->company) ? $client->name: $client->company ?></option>
<?php endforeach; ?>
</select>
<input type="text" name="from" value="<?php echo $from ?>" maxlength="10" />
<input type="text" name="to" value="<?php echo $to ?>" maxlength="10" />
<button type="submit" name="commit">Generate</button>
</form>

<?php 

$sql = "SELECT sum(tax_fee) AS tax, sum(tax2_fee) AS tax2, sum(total) AS total, sum(paid) AS paid FROM invoice, client WHERE invoice.status != 'draft' AND invoice.deleted = 0 AND invoice.client_id = client.id $where_date $where_client";
$stmt  = $PDO->query($sql); 
$total = $stmt->fetchObject();
	
?>

<h1>Report from <b><?php echo strftime('%e %B %Y', strtotime($from)); ?></b> to <b><?php echo strftime('%e %B %Y', strtotime($to)); ?></b></h1>

<h1>Total: <?php echo_number($total->total); ?></h1>
<h1 class="green">Paid: <?php echo_number($total->paid); ?></h1>
<h1 class="red">Due: <?php echo_number($total->total - $total->paid); ?></h1>
<h1>TPS: <?php echo_number($total->tax); ?></h1>
<h1>TVQ: <?php echo_number($total->tax2); ?></h1>
<h1>Total taxes: <?php echo_number($total->tax + $total->tax2); ?></h1>

<?php 

$sql = "SELECT sum(tax_fee) AS tax, sum(tax2_fee) AS tax2, sum(total) AS total, sum(paid) AS paid, client.name AS client_name, client.company AS company FROM invoice, client WHERE invoice.status != 'draft' AND invoice.deleted = 0 AND invoice.client_id = client.id $where_date $where_client GROUP BY client_id";
$clients  = $PDO->query($sql, PDO::FETCH_CLASS, 'Client'); 
	
?>

<table>
	<thead>
	<tr>
		<th>Client</th>
		<th class="green">Paid</th>
		<th class="red">Due</th>
		<th>Taxes</th>
		<th>Total</th>
	</tr>
	</thead>
	<tbody>
<?php foreach($clients as $client): ?>
	<tr>
		<td><?php echo '<b>'.$client->client_name. '</b><br>'. $client->company ?></td>
		<td class="green right"><?php echo echo_number($client->paid); ?></td>
		<td class="red right"><?php echo echo_number($client->total - $client->paid); ?></td>
		<td class="right"><?php echo echo_number($client->tax + $client->tax2); ?></td>
		<td class="right"><?php echo echo_number($client->total); ?></td>
	</tr>
<?php endforeach; ?>
	</tbody>
</table>

</body>
</html>