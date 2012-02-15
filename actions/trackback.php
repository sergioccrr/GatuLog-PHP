<?php

$_GET['type'] = txtval($_GET['type']);

if($_GET['type'] == 'e') {
	$id = intval($_GET['id']);
	$slug = txtval($_GET['slug']);
	$table = 'entries';
} else {
	$p = txtval($_GET['p']);
	$table = 'pages';
}

$query  = "SELECT `id` FROM `".DB_PREFIX."{$table}`";
$query .= " WHERE `status` = 'v'";
$query .= " AND `comments` <> 'n'";
if(isset($p)) {
	$query .= " AND `slug` = '{$p}'";
} else {
	$query .= " AND `id` = '{$id}'";
	$query .= " AND `slug` = '{$slug}'";
}
if(!$sql = mysql_query($query)) throw new Exception('mysql-no');

if(mysql_num_rows($sql) != 0) {
	$pid = mysql_result($sql, 0, 0);
}

if($_SERVER['REQUEST_METHOD'] != 'POST' && !isset($pid)) {
	# Petición GET - No existe la entrada/página
	require('actions/404.php');
} elseif($_SERVER['REQUEST_METHOD'] != 'POST' && isset($pid)) {
	# Petición GET - Existe la entrada/página
	$tmp = ($_GET['type'] == 'e') ? _u('e', $id, $slug) : _u('p', $p);
	header('Location: '.$tmp);
	die();
} elseif($_SERVER['REQUEST_METHOD'] == 'POST' && !isset($pid)) {
	# Petición POST - No existe la entrada/página
	trackbackXML(true, 'I really need a valid entry for this to work');
} elseif($_SERVER['REQUEST_METHOD'] == 'POST') {
	# Petición POST - Existe la entrada/página
	$title = trim(txtval($_POST['title']));
	$url = trim(txtval($_POST['url']));
	$name = trim(txtval($_POST['blog_name']));
	$excerpt = trim(txtval($_POST['excerpt']));
	$time = time();
	if(empty($url)) {
		trackbackXML(true, 'You must include a URL');
	} else {
		$query = "INSERT INTO `".DB_PREFIX."trackbacks` VALUES (NULL , '{$pid}', '{$_GET['type']}', '{$title}', '{$url}', '{$name}', '{$excerpt}', '{$time}', 'n')";
		if($sql = mysql_query($query)) {
			trackbackXML();
		} else {
			trackbackXML(true);
		}
	}
}
