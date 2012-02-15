<?php

class RSS {
	private $title, $link, $description, $items = array();
	function __construct($title, $link, $description='') {
		if(!empty($title) && !empty($link)) {
			$this->title = $title;
			$this->link = $link;
			$this->description = $description;
		}
	}
	public function result() {
		header('Content-Type: text/xml; charset=utf-8');
		echo "<?xml version=\"1.0\" encoding=\"utf-8\" ?>\n";
		echo "<rss version=\"2.0\" xmlns:atom=\"http://www.w3.org/2005/Atom\">\n";
		echo "<channel>\n";
		echo "\t<title>{$this->title}</title>\n";
		echo "\t<atom:link href=\"{$this->link}\" rel=\"self\" type=\"application/rss+xml\" />\n";
		echo "\t<link>{$this->link}</link>\n";
		echo "\t<description>{$this->description}</description>\n";
		foreach($this->items as $v) {
			echo "\t<item>\n";
			echo "\t\t<title>{$v[0]}</title>\n";
			echo "\t\t<link>{$v[1]}</link>\n";
			if(!empty($v[3])) echo "\t\t<pubDate>".date('r', $v[3])."</pubDate>\n";
			echo "\t\t<guid>{$v[1]}</guid>\n";
			if(!empty($v[2])) echo "\t\t<description><![CDATA[{$v[2]}]]></description>\n";
			echo "\t</item>\n";
		}
		echo "</channel>\n";
		echo "</rss>";
	}
	public function item($title, $link, $description='', $time='') {
		if(!empty($title) && !empty($link)) {
			$this->items[] = array($title, $link, $description, $time);
		}
	}
}
