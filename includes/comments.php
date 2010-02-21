<?php
/*
 *		scromega blog CMS
 *		Sergio Cruz aka scromega (scr.omega at gmail dot com) http://scromega.net
 */

########################################################################
#
# SESSION & COOKIE Name
#
$tid = 't-'.PARENT_TYPE.$row[0];
$cid = 'c-'.PARENT_TYPE.$row[0];
$rid = 'gatita';

########################################################################
#
# Insertar comentario
#
if(COMMENTS_STATUS == 'y' && isset($_POST['submit'])) {

	if(empty($_SESSION[$tid]) || $_SESSION[$tid] != $_POST['token']) {
		$errorMsg = 1;
	} elseif(empty($_SESSION[$cid]) || $_SESSION[$cid] != $_POST['captcha']) {
		$errorMsg = 2;
	} else {
		$_POST['nick'] = trim(txtval($_POST['nick']));
		$_POST['email'] = trim(txtval($_POST['email']));
		$_POST['web'] = ($_POST['web'] != 'http://') ? trim(txtval($_POST['web'])) : '';
		$_POST['content'] = trim(txtval($_POST['content']));
		$date  = time();
		$ip = ip();
		$ua = trim(txtval($_SERVER['HTTP_USER_AGENT']));

		if(empty($_POST['nick']) || empty($_POST['email']) || empty($_POST['content'])) {
			$errorMsg = 3;
		} else {
			if(isset($_POST['remember'])) {
				$tmp = array($_POST['nick'], $_POST['email'], $_POST['web']);
				$tmp = serialize($tmp);
				setcookie($rid, $tmp, time()+60*60*24*100, "/");
				$_COOKIE[$rid] = $tmp;
			} else {
				setcookie($rid, '', time()-60*60*24*100, "/");
				$_COOKIE[$rid] = '';
			}

			$query  = "SELECT MAX(`order`) ";
			$query .= "FROM `".DB_PREFIX."comments` ";
			$query .= "WHERE `parentid` = '{$row[0]}' ";
			$query .= "AND `parenttype` = '".PARENT_TYPE."'";
			if(!$sql = mysql_query($query)) throw new Exception('mysql');

			$order = mysql_result($sql, 0, 0) + 1;
			$query  = "INSERT INTO `".DB_PREFIX."comments` ";
			$query .= "VALUES (NULL,'{$row[0]}','".PARENT_TYPE."','{$order}','{$_POST['nick']}','{$_POST['email']}','{$_POST['web']}','{$_POST['content']}','{$date}','{$ip}','{$ua}','n')";
			if(!$sql = mysql_query($query)) throw new Exception('mysql');
			unset($_POST);
		}
	}

}

########################################################################
#
# Leer comentarios
#
$queryC  = "SELECT * ";
$queryC .= "FROM `".DB_PREFIX."comments` ";
$queryC .= "WHERE `parentid` = '{$row[0]}' "; # Comentarios de esta entrada o pagina
$queryC .= "AND `parenttype` = '".PARENT_TYPE."' "; # Comentarios de entradas o paginas
$queryC .= "AND `status` <> 'h' "; # Comentarios no ocultos
$queryC .= "ORDER BY `order` ASC";
if(!$sqlC = mysql_query($queryC)) throw new Exception('mysql');

$totalC = mysql_num_rows($sqlC);
if($totalC == 0) {
	# Si no hay comentarios
	$NoComments = true;
} else {
	# Si hay comentarios
	while($rowC = mysql_fetch_row($sqlC)) {
		static $c = 0;
		$c++;
		$rowsC[$c] = $rowC;
		$rowsC[$c][4] = htmlspecialchars($rowsC[$c][4]);
		$rowsC[$c][5] = md5($rowsC[$c][5]);
		$rowsC[$c][6] = htmlspecialchars($rowsC[$c][6]);
		$rowsC[$c][7] = format($rowsC[$c][7], 'c');
	}
}

/*
 * NoComments	-	True si no hay comentarios
 * rowsC[]		-	Array con los comentarios
 * 	[0]	id
 * 	[1]	parentid
 * 	[2]	parenttype
 * 	[3]	order
 * 	[4]	nick
 * 	[5]	email (md5)
 * 	[6]	web
 * 	[7]	content
 * 	[8]	date
 * 	[9]	ip
 * 	[10] useragent
 * 	[11] status
 */

########################################################################
#
# Form
#
$form['action'] = _u(PARENT_TYPE, ((PARENT_TYPE == 'e') ? $row[0] : $row[1]), ((PARENT_TYPE == 'e') ? $row[1] : ''));
$form['token'] = md5(uniqid(rand(), true));
$_SESSION[$tid] = $form['token'];

if(!empty($_COOKIE[$rid])) {
	$tmp = stripslashes($_COOKIE[$rid]);
	$tmp = unserialize($tmp);
	$form['nick'] = $tmp[0];
	$form['email'] = $tmp[1];
	$form['web'] = $tmp[2];
	$_POST['remember'] = true;
}

if(isset($_POST['submit'])) {
	$form['nick'] = $_POST['nick'];
	$form['email'] = $_POST['email'];
	$form['web'] = $_POST['web'];
	$form['content'] = $_POST['content'];
}

$form['nick'] = htmlspecialchars(stripslashes($form['nick']));
$form['email'] = htmlspecialchars(stripslashes($form['email']));
$form['web'] = (empty($form['web'])) ? 'http://' : htmlspecialchars(stripslashes($form['web']));
$form['content'] = htmlspecialchars(stripslashes($form['content']));
if(isset($_POST['remember'])) $form['remember'] = ' checked="checked"';
