<?php
/*
 *		scromega blog CMS
 *		Sergio Cruz aka scromega (scr.omega at gmail dot com) http://scromega.net
 */

if(empty($_POST)) {
	if(empty($_GET['p']))
		$url = _u('e', $_GET['id'], $_GET['slug']);
	else
		$url = _u('p', $_GET['p']);
	header('Location: '.$url);
	die();
}

require('includes/trackback.class.php');

if(empty($_GET['p'])) {
	$tid = intval($_GET['id']);
	$ttype = 'e';
} else {
	$tid = txtval($_GET['p']);
	$ttype = 'p';
}

trackback::recieve();
if(empty(trackback::$url)) {
	trackback::response(true, 'You must include a URL');
} else {
	$ttitle = txtval(trackback::$title);
	$turl = txtval(trackback::$url);
	$tname = txtval(trackback::$blog_name);
	$texcerpt = txtval(trackback::$excerpt);
	$time = time();
	$query = "INSERT INTO `".DB_PREFIX."trackbacks` VALUES (NULL , '{$tid}', '{$ttype}', '{$ttitle}', '{$turl}', '{$tname}', '{$texcerpt}', '{$time}', 'n')";
	if(!$sql = mysql_query($query)) {
		trackback::response(true);
		throw new Exception('mysql-no');
	}
	trackback::response();
}
