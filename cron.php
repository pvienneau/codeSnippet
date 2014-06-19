<?php

define('CORE_ROOT', dirname(__FILE__));
define('APP_PATH', CORE_ROOT.DIRECTORY_SEPARATOR.'app');
define('DEFAULT_CONTROLLER', 'time');

include CORE_ROOT.'/config.php';
include CORE_ROOT.'/framework.php';

use_helper('I18n', 'General');

setlocale(LC_ALL, 'en_US.UTF-8');

// important for everything that is save to database as a float
setlocale(LC_NUMERIC, 'en_US');

$PDO = new PDO(DB_DSN, DB_USER, DB_PASS);
Record::connection($PDO);
Record::getConnection()->exec("set names 'utf8'");

// load default user
$user = User::get(2); // Fred Audet (2)
AuthUser::setInfos($user); 

// update invoice to due if passed due date
Invoice::checkDue();


use_helper('Email');
// look for recurring templates due to be sent today
foreach(Recurring::findAll(true, true) as $recurring){
	$nextOcc = $recurring->nextOccurence();
	$nextNotice = $recurring->nextOccurence(true);
	if(strtotime($nextOcc) <= time()){
		$client = $recurring->client;
		unset($recurring->client);
		$invoice = $recurring->createInvoice();
		email("info@carbure.co", "", $user->email, $user->name, "Facture récurante pour ".$client, 'Facture récurante créée, voir <a href="http://http://client.oncarbure.net/invoice/view/'.$invoice->id.'">ici</a>.');	
	}
}

AuthUser::logout();