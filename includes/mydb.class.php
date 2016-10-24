<?php

class MyDBException extends Exception { }

class MyDB {
	private $prefix;
	private $magic;
	private $link;
	function __construct($server, $username, $password, $database, $prefix='', $utf8=true) {
		$this->prefix = (empty($prefix)) ? '' : sprintf('%s_', $prefix);
		$this->magic = (get_magic_quotes_gpc()) ? true : false;
		if (!$this->link = @mysqli_connect($server, $username, $password, $database)) {
			throw new MyDBException('connect');
		}
		if ($utf8 !== true) {
			return;
		}
		if (!mysqli_set_charset($this->link, 'utf8')) {
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
			$i = mysqli_real_escape_string($this->link, $i);
		}
		$query = str_replace('%p_', $this->prefix, $query);
		$query = (empty($a)) ? $query : vsprintf($query, $a);
		if (!$result = mysqli_query($this->link, $query)) {
			throw new MyDBException('query');
		}
		if (preg_match('/^insert\s+/i', $query)) {
			return mysqli_insert_id($this->link);
		} else {
			return $result;
		}
	}
	function txtval($str) {
		if ($this->magic) {
			$str = stripslashes($str);
		}
		$str = mysqli_real_escape_string($this->link, $str);
		return $str;
	}
	function __destruct() {
		@mysqli_close($this->link);
	}
}
