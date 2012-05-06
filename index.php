<?php

session_start();

require('config.php');
require('includes/format.class.php');
require('includes/mydb.class.php');
require('includes/functions.php');
require('includes/routes.php');

try {

	$TITLE = TITLE;
	$DB = new MyDB(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

	$act = basename($_GET['a']);
	if(empty($act) && empty($_ROUTE)) $act = 'entries';
	$tmp = 'actions/'.$act.'.php';
	require (file_exists($tmp)) ? $tmp : 'actions/404.php';

} catch(Exception $e) {
	$ERROR = $e->getMessage();
	require('actions/error.php');
}

?>