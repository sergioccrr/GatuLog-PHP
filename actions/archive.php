<?php
/*
 *		scromega blog CMS
 *		Sergio Cruz aka scromega (scr.omega at gmail dot com) http://scromega.net
 */

$TITLE = 'Archivo'.S_TITLE.TITLE;

$query  = "SELECT `id`,`slug`,`title`,`date`";
$query .= ",DATE_FORMAT(FROM_UNIXTIME(`date`),'%m') AS `mm`";
$query .= ",DATE_FORMAT(FROM_UNIXTIME(`date`),'%y') AS `yy`";
$query .= " FROM `".DB_PREFIX."entries`";
$query .= " WHERE `status` = 'v'"; # Entradas solo visibles
$query .= " ORDER BY `date` DESC";
if(!$sql = mysql_query($query)) throw new Exception('mysql');

$totalEntries = mysql_num_rows($sql);
if($totalEntries == 0) {
	# Si no hay entradas
	$NoEntries = true;
} else {
	# Si hay entradas
	$c = -1;
	while($row = mysql_fetch_row($sql)) {
		$c++;
		$rows[$c][0] = $row[0];
		$rows[$c][1] = $row[1];
		$rows[$c][2] = htmlspecialchars($row[2]);
		$rows[$c][3] = $row[3];
		$rows[$c][4] = $row[4].'-'.$row[5];
		if($c == 0) {
			$rows[$c][5] = true; # Open
		}
		if(isset($p) && $rows[$c][4] != $rows[$p][4]) {
			$rows[$p][6] = true; # Close
			$rows[$c][5] = true; # Open
		}
		if($c == $totalEntries - 1) {
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
 * 	[4]	mm-yy
 * 	[5]	Abrir bloque
 * 	[6]	Cerrar bloque
 */
