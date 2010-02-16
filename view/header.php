<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title><?php echo $_TITLE; ?></title>
<meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
<link rel="stylesheet" href="<?php echo BASE_STATIC; ?>files/style.css" />
<meta name="description" content="<?php echo DESCRIPTION; ?>" />
<link rel="shortcut icon" href="<?php echo BASE_STATIC; ?>images/favicon.png" />
<link rel="alternate" type="application/rss+xml" title="Entradas" href="<?php echo _u('fe'); ?>" />
<link rel="alternate" type="application/rss+xml" title="Comentarios" href="<?php echo _u('fc'); ?>" />
<script type="text/javascript" src="<?php echo BASE_STATIC; ?>files/general.js"></script>
</head>
<body>

<div id="container">

<div id="header">
	<h1><a href="<?php echo BASE; ?>" title="Ir al inicio"><span><?php echo TITLE; ?></span></a></h1>
</div>

<div id="sidebar">
	<div class="menu1">
	<b>Menú:</b>
	<ul>
		<li class="li_go"><a href="<?php echo BASE; ?>">Inicio</a></li>
		<li class="li_go"><a href="<?php echo _u('p', 'acerca-de'); ?>">Acerca de...</a></li>
	</ul>
	<b>Feeds:</b>
	<ul>
		<li class="li_feed"><a href="<?php _u('fe'); ?>">Entradas</a></li>
		<li class="li_feed"><a href="<?php _u('fc'); ?>">Comentarios</a></li>
	</ul>
	</div>
	<br />
	<div class="menu2">
	<b>Links:</b>
	<ul>
		<li><a href="#">Ejemplo 1</a></li>
		<li><a href="#">Ejemplo 2</a></li>
		<li><a href="#">Ejemplo 3</a></li>
	</ul>
	</div>
</div>

<div id="main">

