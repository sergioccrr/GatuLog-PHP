<?php
/*
 *		scromega blog CMS
 *		Sergio Cruz aka scromega (scr.omega at gmail dot com) http://scromega.net
 */

$queryT  = "SELECT * ";
$queryT .= "FROM `".DB_PREFIX."trackbacks` ";
$queryT .= "WHERE `parentid` = '{$row[0]}' "; # Trackbacks de esta entrada o pagina
$queryT .= "AND `parenttype` = '".PARENT_TYPE."' "; # Trackbacks de entradas o paginas
$queryT .= "ORDER BY `date` DESC, `id` DESC";
if(!$sqlT = mysql_query($queryT)) throw new Exception('mysql');

while($rowT = mysql_fetch_row($sqlT)) {
		static $c = 0;
		$c++;
		$rowsT[$c] = $rowT;
		$rowsT[$c][3] = htmlspecialchars($rowsT[$c][3]);
		$rowsT[$c][4] = htmlspecialchars($rowsT[$c][4]);
		$rowsT[$c][5] = htmlspecialchars($rowsT[$c][5]);
		$rowsT[$c][6] = htmlspecialchars($rowsT[$c][6]);
}

/*
 * rowsT[]		-	Array con los trackbacks
 * 	[0]	id
 * 	[1]	parentid
 * 	[2]	parenttype
 * 	[3]	title
 * 	[4]	url
 * 	[5]	blog_name
 * 	[6]	expert
 * 	[7]	date
 * 	[8]	approved
 */