<?php

define('DEBUG', true);

define('DB_DSN', 'mysql:dbname=codesnippet;host=localhost');
define('DB_USER', 'mysql_user');
define('DB_PASS', 'DmTeVb4');

$config = array();

// email config
$config['email_protocol'] = 'mail'; // mail, smtp or sendmail are available

// if smtp is your choice and you need to autheticate yourself then uncomment those line
//$config['smtp_host'] = 'smtp.gmail.com';     // sets the SMTP server
//$config['smtp_port'] = 465;                  // 26 is the default port but this example is for a gmail config
//$config['smtp_user'] = 'username@gmail.com'; // SMTP account username
//$config['smtp_pass'] = 'password';           // SMTP account password

// here is a other smtp config if you want to use gmail for example
//$config['smtp_secure'] = 'ssl';             // ssl or tls (sets the prefix to the server)

date_default_timezone_set('America/Montreal');

$config['months'] = array('','January','February','March','April','May','June','July','August','September','October','November','December');
