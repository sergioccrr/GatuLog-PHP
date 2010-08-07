<?php
/*
 *		scromega blog CMS
 *		Sergio Cruz aka scromega (scr.omega at gmail dot com) http://scromega.net
 */

require('includes/rss.class.php');

$rss = new RSS(TITLE, _u('fe'), DESCRIPTION);

$query  = "SELECT *";
$query .= " FROM `".DB_PREFIX."entries`";
$query .= " WHERE `status` = 'v'";
$query .= " ORDER BY `date` DESC, `id` DESC";
$query .= " LIMIT ";
$query .= P_LIMIT;
if(!$sql = mysql_query($query)) throw new Exception('mysql-no');

if(mysql_num_rows($sql) != 0) {
	# Si hay entradas
	while($row = mysql_fetch_row($sql)) {
		$row[2] = htmlspecialchars($row[2]);
		$row[3] = format($row[3], 'e');
		$tmp = _u('e', $row[0], $row[1]);
		$rss->item($row[2], $tmp, $row[3], $row[4]);
	}
}

$rss->result();
