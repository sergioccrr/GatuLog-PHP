<?php
/*
 *		scromega blog CMS
 *		Sergio Cruz aka scromega (scr.omega at gmail dot com) http://scromega.net
 */

session_start();

require (file_exists('config-localhost.php')) ? 'config-localhost.php' : 'config.php';
require('includes/format.class.php');
require('includes/functions.php');
require('includes/routes.php');

try {

	if(!$_LINK = mysql_connect(DB_HOST, DB_USER, DB_PASSWORD)) throw new Exception('mysql');
	if(!mysql_select_db(DB_NAME)) throw new Exception('mysql');
	if(!mysql_query("SET NAMES 'utf8'")) throw new Exception('mysql');

	$_TITLE = TITLE;

	$act = basename($_GET['a']);
	if(empty($act) && empty($_ROUTE)) $act = 'entries';
	$tmp = 'actions/'.$act.'.php';
	require (file_exists($tmp)) ? $tmp : 'actions/404.php';

	mysql_close($_LINK);

} catch(Exception $_E) {
	require('actions/error.php');
}
