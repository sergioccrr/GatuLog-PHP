<?php
/*
 *		scromega blog CMS
 *		Sergio Cruz aka scromega (scr.omega at gmail dot com) http://scromega.net
 */

$p = txtval($_GET['p']);

$query  = "SELECT p.*,COUNT(c.`id`)";
$query .= " FROM `".DB_PREFIX."pages` p";
$query .= " LEFT JOIN `".DB_PREFIX."comments` c";
$query .= " ON p.`comments` <> 'n'"; # Paginas con comentarios visibles
$query .= " AND c.`parentid` = p.`id`"; # Comentarios de esta pagina
$query .= " AND c.`parenttype` = 'p'"; # Comentarios de paginas
$query .= " AND c.`status` <> 'h'"; # Comentarios no ocultos
$query .= " WHERE p.`slug` = '{$p}'";
$query .= " AND p.`status` = 'v'"; # Paginas solo visibles
$query .= " GROUP BY p.`id`";
if(!$sql = mysql_query($query)) throw new Exception('mysql');

if(mysql_num_rows($sql) == 0) {
	# Si no existe la pagina
	require('actions/404.php');
} else {
	# Si existe la pagina
	$row = mysql_fetch_row($sql);
	$row[2] = htmlspecialchars($row[2]);
	$row[3] = format($row[3], 'p');

	define('PARENT_TYPE', 'p');

	if($row[5] != 'n') {
		$FEED = _u('cp', $p);
		define('COMMENTS_STATUS', $row[5]);
		require('includes/comments.php');
	}

	if($row[6] == 'y') {
		require('includes/trackbacks.php');
	}

	$TITLE = $row[2].S_TITLE.TITLE;
	require('view/page.php');
}

/*
 * row		-	Array con la pagina
 * 	[0]	id
 * 	[1]	slug
 * 	[2]	title
 * 	[3]	content
 * 	[4]	status
 * 	[5]	comments
 * 	[6]	trackback
 * 	[7]	number of comments
 */
