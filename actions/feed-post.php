<?php

if ($_GET['type'] == 'e') {
	$id = intval($_GET['id']);
	$slug = $_GET['slug'];
	$table = 'entries';
} else {
	$p = $_GET['p'];
	$table = 'pages';
}

$query  = "SELECT `id`,`title` FROM `%p_{$table}`";
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

if (mysql_num_rows($sql) == 0) {
	# Si no existe la entrada/página
	require('actions/404.php');
} else {
	# Si existe
	require('includes/rss.class.php');

	$pid = mysql_result($sql, 0, 0);
	$title = mysql_result($sql, 0, 1);
	$title = htmlspecialchars($title);
	$tmp1 = sprintf('Comentarios en "%s" de %s', $title, TITLE);
	$tmp2 = ($_GET['type'] == 'e') ? _u('ce', $id, $slug) : _u('cp', $p);
	$rss = new RSS($tmp1, $tmp2, DESCRIPTION);

	$queryC  = "SELECT `order`,`nick`,`content`,`date`";
	$queryC .= " FROM `%p_comments`";
	$queryC .= " WHERE `parenttype` = '%s'";
	$queryC .= " AND `parentid` = '%s'";
	$queryC .= " AND `status` <> 'h'";
	$queryC .= " ORDER BY `order` DESC";
	$sqlC = $DB->query($queryC, $_GET['type'], $pid);
	//if (!$sqlC = mysql_query($queryC)) throw new Exception('mysql-no');

	if (mysql_num_rows($sqlC) != 0) {
		# Si hay comentarios
		while ($row = mysql_fetch_row($sqlC)) {
			$row[1] = htmlspecialchars($row[1]);
			$row[2] = format($row[2], 'cf');
			$tmp1 = sprintf('Comentario de %s', $row[1]);
			$tmp2  = ($_GET['type'] == 'e') ? _u('e', $id, $slug) : _u('p', $p);
			$tmp2 .= sprintf('#comment-%s', $row[0]);
			$rss->item($tmp1, $tmp2, $row[2], $row[3]);
		}
	}

	$rss->result();
}
