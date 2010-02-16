<?php
/*
 *		trackback Class
 *		Sergio Cruz aka scromega (scr.omega at gmail dot com) http://scromega.net
 *
 *		Part of scromega blog CMS
 */

class trackback {
	public static $title, $url, $blog_name, $excerpt;
	public static function recieve() {
		self::$title = trim($_POST['title']);
		self::$url = trim($_POST['url']);
		self::$blog_name = trim($_POST['blog_name']);
		self::$excerpt = trim($_POST['excerpt']);
	}
	public static function response($error=false, $message='') {
		header('Content-Type: text/xml; charset=utf-8');
		echo "<?xml version=\"1.0\" encoding=\"utf-8\" ?>\n";
		echo "<response>\n";
		if($error) {
			if(empty($message)) $message = 'An error occured while tring to log your trackback...';
			echo "\t<error>1</error>\n";
			echo "\t<message>{$message}</message>\n";
		} else {
			echo "\t<error>0</error>\n";
		}
		echo "</response>";
	}
}
