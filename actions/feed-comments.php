<?php
/*
 *		scromega blog CMS
 *		Sergio Cruz aka scromega (scr.omega at gmail dot com) http://scromega.net
 */

require('includes/rss.class.php');

$query  = "SELECT c.*,e.`slug`,e.`title`";
$query .= " FROM `".DB_PREFIX."comments` c";
$query .= " LEFT JOIN `".DB_PREFIX."entries` e";
$query .= " ON c.`parenttype` = 'e' AND c.`parentid` = e.`id`"; # Unión
$query .= " WHERE c.`status` <> 'h'"; # Comentarios visibles
$query .= " AND e.`comments` <> 'n'"; # Entradas con comentarios visibles
$query .= " AND e.`status` = 'v'"; # Entradas visibles
$query .= " ORDER BY c.`date` DESC, c.`id` DESC";
$query .= " LIMIT ";
$query .= P_LIMIT;
if(!$sql = mysql_query($query)) throw new Exception('mysql-no');

$rss = new RSS('Comentarios para '.TITLE, _u('fc'), DESCRIPTION);

if(mysql_num_rows($sql) != 0) {
	# Si hay comentarios
	while($row = mysql_fetch_row($sql)) {
		$row[4] = htmlspecialchars($row[4]);
		$row[13] = htmlspecialchars($row[13]);
		$t = sprintf('Comentario de %s en %s', $row[4], $row[13]);
		$row[7] = format($row[7], 'cf');
		$l = _u('e', $row[1], $row[12]).'#comment-'.$row[3];
		$rss->item($t, $l, $row[7], $row[8]);
	}
}

$rss->result();
