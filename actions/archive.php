<?php

$TITLE = sprintf('Archivo%s%s', S_TITLE, TITLE);

$query  = "SELECT `id`,`slug`,`title`,`date`";
$query .= ",DATE_FORMAT(FROM_UNIXTIME(`date`),'%m/%y') AS `mm/yy`";
$query .= " FROM `".DB_PREFIX."entries`";
$query .= " WHERE `status` = 'v'";
$query .= " ORDER BY `date` DESC";
$sql = $DB->query($query);

$totalEntries = mysql_num_rows($sql);
if ($totalEntries == 0) {
	# Si no hay entradas
	$NoEntries = true;
} else {
	# Si hay entradas
	$c = -1;
	while ($row = mysql_fetch_row($sql)) {
		$c++;
		$rows[$c] = $row;
		$rows[$c][2] = htmlspecialchars($rows[$c][2]);
		if ($c == 0) {
			$rows[$c][5] = true; # Open
		}
		if (isset($p) && $rows[$c][4] != $rows[$p][4]) {
			$rows[$p][6] = true; # Close
			$rows[$c][5] = true; # Open
		}
		if ($c == $totalEntries - 1) {
			$rows[$c][6] = true; # Close
		}
		$p = $c;
	}
	$totalFor = count($rows) - 1;
}

require('view/archive.php');

/*
 * NoEntries	-	True si no hay entradas
 * rows[]		-	Array con las entradas
 * 	[0]	id
 * 	[1]	slug
 * 	[2]	title
 * 	[3]	date
 * 	[4]	mm/yy
 * 	[5]	Abrir bloque
 * 	[6]	Cerrar bloque
 */
