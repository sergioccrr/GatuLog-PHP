<?php

# Función para generar la respuesta a un trackback en XML
function trackbackXML($error=false, $message='') {
	header('Content-Type: text/xml; charset=utf-8');
	echo "<?xml version=\"1.0\" encoding=\"utf-8\" ?>\n";
	echo "<response>\n";
	if ($error === true) {
		$message = (empty($message)) ? 'An error occured while tring to log your trackback...' : $message;
		echo "\t<error>1</error>\n";
		echo "\t<message>{$message}</message>\n";
	} else {
		echo "\t<error>0</error>\n";
	}
	echo "</response>";
}

if ($_GET['type'] == 'e') {
	$id = intval($_GET['id']);
	$slug = $_GET['slug'];
	$table = 'entries';
} else {
	$p = $_GET['p'];
	$table = 'pages';
}

$query  = "SELECT `id` FROM `%p_{$table}`";
$query .= " WHERE `status` = 'v'";
$query .= " AND `comments` <> 'n'";
if (isset($p)) {
	$query .= " AND `slug` = '%s'";
	$sql = $DB->query($query, $p);
} else {
	$query .= " AND `id` = '%s'";
	$query .= " AND `slug` = '%s'";
	$sql = $DB->query($query, $id, $slug);
}
//if (!$sql = mysql_query($query)) throw new Exception('mysql-no');

if (mysqli_num_rows($sql) != 0) {
	$pid = mysqli_fetch_row($sql)[0];
}

if ($_SERVER['REQUEST_METHOD'] != 'POST' && !isset($pid)) {
	# Petición GET - No existe la entrada/página
	require('actions/404.php');
} elseif ($_SERVER['REQUEST_METHOD'] != 'POST' && isset($pid)) {
	# Petición GET - Existe la entrada/página
	$tmp = ($_GET['type'] == 'e') ? _u('e', $id, $slug) : _u('p', $p);
	header(sprintf('Location: %s', $tmp));
	die();
} elseif ($_SERVER['REQUEST_METHOD'] == 'POST' && !isset($pid)) {
	# Petición POST - No existe la entrada/página
	trackbackXML(true, 'I really need a valid entry for this to work');
} elseif ($_SERVER['REQUEST_METHOD'] == 'POST') {
	# Petición POST - Existe la entrada/página
	$title = trim($_POST['title']);
	$url = trim($_POST['url']);
	$name = trim($_POST['blog_name']);
	$excerpt = trim($_POST['excerpt']);
	$time = time();
	if (empty($url)) {
		trackbackXML(true, 'You must include a URL');
	} else {
		$query = "INSERT INTO `%p_trackbacks` VALUES (NULL , '%s', '%s', '%s', '%s', '%s', '%s', '%s', 'n')";
		try {
			$sql = $DB->query($query, $pid, $_GET['type'], $title, $url, $name, $excerpt, $time);
			trackbackXML();
		} catch (MyDBException $e) {
			trackbackXML(true);
		}
	}
}
