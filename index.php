<?php

//define('DEFAULT_RATE', 50);
define('DEFAULT_CONTROLLER', 'invoice');

define('CORE_ROOT', dirname(__FILE__));
define('APP_PATH', CORE_ROOT.DIRECTORY_SEPARATOR.'app');

include CORE_ROOT.'/config.php';
include CORE_ROOT.'/framework.php';

$PDO = new PDO(DB_DSN, DB_USER, DB_PASS);
Record::connection($PDO);
Record::getConnection()->exec("set names 'utf8'");
//include 'Record.php';

use_helper('I18n', 'General');
I18n::setLocale('fr');

setlocale(LC_ALL, 'fr_CA');
//setlocale(LC_ALL, 'en_US.UTF-8');

// important for everything that is save to database as a float
setlocale(LC_NUMERIC, 'en_US');


Dispatcher::addRoute(array(
	'/project/:num/overview' => 'project/overview/$1',
	'/project/:num/todo' => 'todo/project/$1',
	'/project/:num/milestone' => 'milestone/project/$1',
	'/project/:num/:any' => '$2/$1',
	'/logout' => 'login/logout',
	'/people:any' => 'user$1'
));

Dispatcher::dispatch(isset($_GET['u']) ? $_GET['u']: AuthUser::getDefaultController());

//I18n::printMissing();