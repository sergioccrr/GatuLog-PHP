<?php

if (!isset($_ROUTES) || empty($_ROUTES)) {
	die('Failure routes.');
}

function _u() {
	global $_ROUTES;
	$args = func_get_args();
	if (!array_key_exists($args[0], $_ROUTES)) {
		return '';
	}
	$url = '';
	if (defined('BASE')) {
		$url .= BASE;
	}
	if (!defined('REWRITE') || REWRITE !== true) {
		$url .= 'index.php/';
	}
	$url .= preg_replace_callback('!(%|{)([0-9]+)(%|})!', function ($matches) use ($args) {
		return $args[$matches[2]];
	}, $_ROUTES[$args[0]][0]);
	return $url;
}

if (defined('REWRITE') && REWRITE === true) {
	$_ROUTE = $_SERVER['REQUEST_URI'];
} elseif (isset($_SERVER['PATH_INFO'])) {
	$_ROUTE = $_SERVER['PATH_INFO'];
} else {
	$_ROUTE = '';
}
$_ROUTE = urldecode($_ROUTE);
$_ROUTE = substr($_ROUTE, 1);

foreach ($_ROUTES as $k=>$v) {
	$pattern = $v[0];
	$pattern = preg_replace('!%(.*?)%!', '([0-9]+)', $pattern);
	$pattern = preg_replace('!{(.*?)}!', '(.+?)', $pattern);
	$pattern = sprintf('!^%s$!', $pattern);
	if (preg_match($pattern, $_ROUTE, $matches)) {
		parse_str(preg_replace_callback('!\{([0-9]+)\}!', function ($m) use ($matches) {
			return $matches[$m[1]];
		}, $v[1]), $_GET);
		$_FOUND = $k;
	}
}
