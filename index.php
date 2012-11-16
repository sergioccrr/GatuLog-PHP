<?php

session_start();

require('config.php');
require('includes/format.class.php');
require('includes/mydb.class.php');
require('includes/functions.php');
require('includes/routes.php');

try {

	$TITLE = TITLE;
	$DB = new MyDB(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME, DB_PREFIX, true);

	$act = '';
	if (isset($_GET['a'])) {
		$act = basename($_GET['a']);
	}
	if (empty($act) && empty($_ROUTE)) {
		$act = 'entries';
	}
	$tmp = sprintf('actions/%s.php', $act);
	if (file_exists($tmp)) {
		require($tmp);
	} else {
		require('actions/404.php');
	}

} catch (Exception $e) {
	$ERROR = $e->getMessage();
	require('actions/error.php');
}
