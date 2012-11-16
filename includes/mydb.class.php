<?php

class MyDBException extends Exception { }

class MyDB {
	private $prefix;
	private $magic;
	private $link;
	function __construct($server, $username, $password, $database, $prefix='', $utf8=true) {
		$this->prefix = (empty($prefix)) ? '' : sprintf('%s_', $prefix);
		$this->magic = (get_magic_quotes_gpc()) ? true : false;
		if (!$this->link = @mysql_connect($server, $username, $password, true)) {
			throw new MyDBException('connect');
		}
		if (!mysql_select_db($database, $this->link)) {
			throw new MyDBException('select_db');
		}
		if ($utf8 !== true) {
			return;
		}
		if (!mysql_query("SET NAMES 'utf8'", $this->link)) {
			throw new MyDBException('utf8');
		}
	}
	function query($query) {
		$a = func_get_args();
		array_shift($a);
		if ($this->magic) {
			$a = array_map('stripslashes', $a);
		}
		foreach ($a as &$i) {
			$i = mysql_real_escape_string($i, $this->link);
		}
		$query = str_replace('%p_', $this->prefix, $query);
		$query = (empty($a)) ? $query : vsprintf($query, $a);
		if (!$result = mysql_query($query, $this->link)) {
			throw new MyDBException('query');
		}
		if (preg_match('/^insert\s+/i', $query)) {
			return mysql_insert_id($this->link);
		} else {
			return $result;
		}
	}
	function txtval($str) {
		if ($this->magic) {
			$str = stripslashes($str);
		}
		$str = mysql_real_escape_string($str, $this->link);
		return $str;
	}
	function __destruct() {
		@mysql_close($this->link);
	}
}
