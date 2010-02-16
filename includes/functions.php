<?php
/*
 *		scromega blog CMS
 *		Sergio Cruz aka scromega (scr.omega at gmail dot com) http://scromega.net
 */

# Función anti SQL injection
function txtval($str) {
	return !get_magic_quotes_gpc() ? addslashes($str) : $str;
}

# Función para la fecha
function _d($f, $t) {
	$a = array('Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre');
	$r1 = $a[date('n', $t) - 1];
	$r2 = substr($r1, 0, 3);
	$d = date($f, $t);
	$d = str_replace(date('F', $t), $r1, $d);
	$d = str_replace(date('M', $t), $r2, $d);
	return $d;
}

# Función para dar formato al texto
function format($str, $type='') {
	$tmp = new format($str, true, true);
	if($type == 'e' || $type == 'p') {
		$tmp->html(array('b','i','u','s'));
		$tmp->parse('#\[tex\](.*?)\[/tex\]#se', '"[img]http://chart.apis.google.com/chart?cht=tx&chl=".rawurlencode("\\1")."[/img]"');
		$tmp->tag('img', '<img src="\\1" alt="" />');
		$tmp->attribute('img', '<img src="\\2" alt="\\1" />');
		$tmp->tag('url', '<a href="\\1" target="_blank">\\1</a>');
		$tmp->attribute('url', '<a href="\\1" target="_blank">\\2</a>');
		$tmp->tag('link', '<a href="\\1">\\1</a>');
		$tmp->attribute('link', '<a href="\\1">\\2</a>');
		$tmp->attribute('acronym', '<acronym title="\\1">\\2</acronym>');
		$tmp->tag('center', '<div align="center">\\1</div>');
	} elseif($type == 'c') {
		$tmp->parse('#https?://[^.\s]+\.[^\s]+#ix', '<a href="\\0" target="_blank">\\0</a>');
		$tmp->parse('#(\s|\A)\#([0-9]+)#', '<a href="#comment-\\2">\\0</a>');
	} elseif($type == 'cf') {
		$tmp->parse('#https?://[^.\s]+\.[^\s]+#ix', '<a href="\\0" target="_blank">\\0</a>');
	}
	return $tmp->result();
}

# Función para obtener la IP
function ip() {
	if($_SERVER['HTTP_X_FORWARDED_FOR']) {
		$ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
	} elseif($_SERVER['HTTP_CLIENT_IP']) {
		$ip = $_SERVER['HTTP_CLIENT_IP'];
	} else {
		$ip = $_SERVER['REMOTE_ADDR'];
	}
	return $ip;
}
