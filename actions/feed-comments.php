<?php
/*
 *		scromega blog CMS
 *		Sergio Cruz aka scromega (scr.omega at gmail dot com) http://scromega.net
 */

require('includes/rss.class.php');

$query  = "(";
$query .= "SELECT c.`parentid`, c.`order`, c.`nick`, c.`content`, c.`date` AS sort, p.`slug`, p.`title`, c.`parenttype`";
$query .= " FROM `".DB_PREFIX."comments` c";
$query .= " INNER JOIN `".DB_PREFIX."pages` p";
$query .= " ON c.`parenttype` = 'p' AND c.`parentid` = p.`id`"; # Unión
$query .= " WHERE c.`status` <> 'h'";
$query .= " AND p.`comments` <> 'n'";
$query .= " AND p.`status` = 'v'";
$query .= ") UNION ALL (";
$query .= "SELECT c.`parentid`, c.`order`, c.`nick`, c.`content`, c.`date` AS sort, p.`slug`, p.`title`, c.`parenttype`";
$query .= " FROM `".DB_PREFIX."comments` c";
$query .= " INNER JOIN `".DB_PREFIX."entries` p";
$query .= " ON c.`parenttype` = 'e' AND c.`parentid` = p.`id`";
$query .= " WHERE c.`status` <> 'h'";
$query .= " AND p.`comments` <> 'n'";
$query .= " AND p.`status` = 'v'";
$query .= ")";
$query .= " ORDER BY `sort` DESC";
$query .= " LIMIT 10";
if(!$sql = mysql_query($query)) throw new Exception('mysql-no');

$rss = new RSS('Comentarios para '.TITLE, _u('fc'), DESCRIPTION);

if(mysql_num_rows($sql) != 0) {
	# Si hay comentarios
	while($row = mysql_fetch_row($sql)) {
		$row[2] = htmlspecialchars($row[2]);
		$row[6] = htmlspecialchars($row[6]);
		$t = sprintf('Comentario de %s en %s', $row[2], $row[6]);
		$row[3] = format($row[3], 'cf');
		$l = _u($row[7], (($row[7] == 'e') ? $row[0] : $row[5]), (($row[7] == 'e') ? $row[5] : '')).'#comment-'.$row[1];
		$rss->item($t, $l, $row[3], $row[4]);
	}
}

$rss->result();
