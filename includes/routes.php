<?php
/*
 *		Routing System
 *		Sergio Cruz aka scromega (scr.omega at gmail dot com) http://scromega.net
 *
 *		Part of scromega blog CMS
 */

$_ROUTES = array(
	'a'=>array('page-%1%.html','a=entries&page={1}'),
	'e'=>array('%1%-{2}.html','a=entry&id={1}&slug={2}'),
	'p'=>array('p-{1}.html','a=page&p={1}'),
	'fe'=>array('feed/entries.xml','a=feed-entries'),
	'fc'=>array('feed/comments.xml','a=feed-comments'),
	'te'=>array('%1%-{2}/trackback','a=trackback&id={1}&slug={2}'),
	'tp'=>array('p-{1}/trackback','a=trackback&p={1}'),
	'ca'=>array('captcha-{1}.png','a=captcha&cid={1}')
);

function _u() {
	global $_ROUTES;
	$args = func_get_args();
	if(array_key_exists($args[0], $_ROUTES)) {
		if(defined('BASE')) $url = BASE;
		if(REWRITE != 'On') $url .= 'index.php/';
		$url .= preg_replace("!(%|{)([0-9]+)(%|})!e", '$args[\\2]', $_ROUTES[$args[0]][0]);
		return $url;
	}
}

if(defined('REWRITE') && REWRITE == 'On') {
	$_ROUTE = urldecode(substr($_SERVER['REQUEST_URI'], 1));
} else {
	$_ROUTE = urldecode(substr($_SERVER['PATH_INFO'], 1));
}

foreach($_ROUTES as $k=>$v) {
	$pattern = preg_replace("!%(.*?)%!", '([0-9]+)', $v[0]);
	$pattern = preg_replace("!{(.*?)}!", '(.+?)', $pattern);
	if(preg_match('!^'.$pattern.'$!', $_ROUTE, $matches)) {
		parse_str(preg_replace("!\{([0-9]+)\}!e", '$matches[\\1]', $v[1]), $_GET);
		$_FOUND = $k;
	}
}
