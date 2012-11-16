<?php

require('includes/rss.class.php');

$tmp1 = sprintf('Comentarios de %s', TITLE);
$rss = new RSS($tmp1, _u('fc'), DESCRIPTION);

$query  = "(";
$query .= "SELECT c.`parentid`, c.`order`, c.`nick`, c.`content`, c.`date` AS sort, p.`slug`, p.`title`, c.`parenttype`";
$query .= " FROM `%p_comments` c";
$query .= " INNER JOIN `%p_pages` p";
$query .= " ON c.`parenttype` = 'p' AND c.`parentid` = p.`id`";
$query .= " WHERE c.`status` <> 'h'";
$query .= " AND p.`comments` <> 'n'";
$query .= " AND p.`status` = 'v'";
$query .= ") UNION ALL (";
$query .= "SELECT c.`parentid`, c.`order`, c.`nick`, c.`content`, c.`date` AS sort, p.`slug`, p.`title`, c.`parenttype`";
$query .= " FROM `%p_comments` c";
$query .= " INNER JOIN `%p_entries` p";
$query .= " ON c.`parenttype` = 'e' AND c.`parentid` = p.`id`";
$query .= " WHERE c.`status` <> 'h'";
$query .= " AND p.`comments` <> 'n'";
$query .= " AND p.`status` = 'v'";
$query .= ")";
$query .= " ORDER BY `sort` DESC";
$query .= " LIMIT 10";
$sql = $DB->query($query);
//if (!$sql = mysql_query($query)) throw new Exception('mysql-no');

if (mysql_num_rows($sql) != 0) {
	# Si hay comentarios
	while ($row = mysql_fetch_row($sql)) {
		$row[2] = htmlspecialchars($row[2]);
		$row[6] = htmlspecialchars($row[6]);
		$tmp1 = sprintf('Comentario de %s en "%s"', $row[2], $row[6]);
		$row[3] = format($row[3], 'cf');
		$tmp2  = ($row[7] == 'e') ? _u('e', $row[0], $row[5]) : _u('p', $row[5]);
		$tmp2 .= sprintf('#comment-%s', $row[1]);
		$rss->item($tmp1, $tmp2, $row[3], $row[4]);
	}
}

$rss->result();
