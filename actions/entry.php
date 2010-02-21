<?php
/*
 *		scromega blog CMS
 *		Sergio Cruz aka scromega (scr.omega at gmail dot com) http://scromega.net
 */

$id = intval($_GET['id']);
$slug = txtval($_GET['slug']);

$query  = "SELECT e.*,COUNT(c.`id`)";
$query .= " FROM `".DB_PREFIX."entries` e";
$query .= " LEFT JOIN `".DB_PREFIX."comments` c";
$query .= " ON c.`parenttype` = 'e' AND c.`parentid` = e.`id`";
$query .= " AND e.`comments` <> 'n'"; # Entradas con comentarios visibles
$query .= " AND c.`status` <> 'h'"; # Comentarios solo visibles
$query .= " WHERE e.`id` = '{$id}'";
if(!empty($slug)) $query .= " AND e.`slug` = '{$slug}'";
$query .= " AND e.`status` = 'v'"; # Entradas solo visibles
$query .= " GROUP BY e.`id`";
if(!$sql = mysql_query($query)) throw new Exception('mysql');

if(mysql_num_rows($sql) == 0) {
	# Si no existe la entrada
	require('actions/404.php');
} else {
	# Si existe la entrada
	$row = mysql_fetch_row($sql);
	$row[2] = htmlspecialchars($row[2]);
	$row[3] = format($row[3], 'e');

	$part = explode('[[CORTAR]]', $row[3]);
	$part[0] = trim($part[0]);
	if(isset($part[1])) $part[1] = trim($part[1]);

	define('PARENT_TYPE', 'e');

	if($row[7] != 'n') {
		define('COMMENTS_STATUS', $row[7]);
		require('includes/comments.php');
	}

	if($row[8] == 'y') {
		require('includes/trackbacks.php');
	}

	$_TITLE = $row[2].S_TITLE.TITLE;
	require('view/entry.php');
}

/*
 * rows		-	Array con la entrada
 * 	[0]	id
 * 	[1]	slug
 * 	[2]	title
 * 	[3]	content
 * 	[4]	date
 * 	[5]	mini
 * 	[6]	status
 * 	[7]	comments
 * 	[8]	trackback
 * 	[9]	number of comments
 * part		-	Array con el contenido segmentado
 */
