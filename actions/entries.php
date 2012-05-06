<?php

$page = intval($_GET['page']);
if(empty($page)) $page = 1;

$query  = "SELECT COUNT(1)";
$query .= " FROM `".DB_PREFIX."entries`";
$query .= " WHERE `status` = 'v'"; # Entradas solo visibles
$sql = $DB->query($query);

$totalEntries = mysql_result($sql, 0, 0);
if($totalEntries == 0) {
	# Si no hay entradas
	$NoEntries = true;
	require('view/entries.php');
} else {
	# Si hay entradas
	$query  = "SELECT e.*,COUNT(c.`id`)";
	$query .= " FROM `".DB_PREFIX."entries` e";
	$query .= " LEFT JOIN `".DB_PREFIX."comments` c";
	$query .= " ON c.`parenttype` = 'e' AND c.`parentid` = e.`id`";
	$query .= " AND e.`comments` <> 'n'"; # Entradas con comentarios visibles
	$query .= " AND c.`status` <> 'h'"; # Comentarios solo visibles
	$query .= " WHERE e.`status` = 'v'"; # Entradas solo visibles
	$query .= " GROUP BY e.`id`";
	$query .= " ORDER BY e.`date` DESC, e.`id` DESC";
	$query .= " LIMIT ";
	$query .= ($page * P_LIMIT) - P_LIMIT;
	$query .= ", ";
	$query .= P_LIMIT;
	$sql = $DB->query($query);

	if(mysql_num_rows($sql) == 0) {
		# No existe la pagina
		require('actions/404.php');
	} else {
		# Existe la pagina
		$c = -1;
		while($row = mysql_fetch_row($sql)) {
			$c++;
			$rows[$c] = $row;
			$rows[$c][2] = htmlspecialchars($rows[$c][2]);
			$rows[$c][3] = format($rows[$c][3], 'e');
			$part[$c] = explode('[[CORTAR]]', $rows[$c][3]);
		}
		$totalFor = count($rows) - 1;

		# Paginador
		$totalPages = ceil($totalEntries / P_LIMIT);
		if($totalPages != 1) {
			for($c = $page-P_RANGE; $c <= $page+P_RANGE; $c++) {
				if($c >= 1 && $c <= $totalPages && $page >= 1 && $page <= $totalPages) $pages[] = $c;
			}
		}

		if($page != 1) $TITLE = 'Pagina '.$page.S_TITLE.TITLE;
		require('view/entries.php');
	}
}

/*
 * NoEntries	-	True si no hay entradas
 * rows[]		-	Array con las entradas
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
 * part[]		-	Array con el contenido segmentado
 * totalPages	-	Numero total de paginas
 * pages[]		-	Array con la paginación
 */

?>