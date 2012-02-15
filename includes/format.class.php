<?php

class format {
	protected $str, $code, $list, $patterns, $replacements;
	function __construct($str, $ul = false, $code = false) {
		$this->ul = $ul;
		$str = htmlspecialchars($str);
		if($code) {
			$this->code = true;
			$this->str = preg_split('/\[code\](.+)\[\/code\]/sU', $str, -1, PREG_SPLIT_DELIM_CAPTURE);
		} else {
			$this->str = $str;
		}
	}
	private static function pul($m) {
		$str = str_replace("<br />\n", "\n", $m[1]);
		$str = trim($str);
		preg_match_all('#(\*+) ([^\n]+)#', $str, $tmp);
		$str = "<ul>\n";
		foreach($tmp[2] as $k=>$v) {
			$str .= '<li>'.$v;
			if(isset($tmp[1][$k+1]) && strlen($tmp[1][$k+1]) == strlen($tmp[1][$k]) + 1) {
				$str .= "\n<ul>\n";
			} else {
				$str .= "</li>\n";
			}
			if(isset($tmp[1][$k+1]) && strlen($tmp[1][$k+1]) == strlen($tmp[1][$k]) - 1) {
				$str .= "</ul>\n</li>\n";
			}
			if(count($tmp[0]) -1 == $k && isset($tmp[1][$k-1]) && strlen($tmp[1][$k-1]) == strlen($tmp[1][$k]) - 1) {
				$str .= "</ul>\n</li>\n";
			}
		}
		$str .= "</ul>";
		return $str;
	}
	public function html($t) {
		foreach($t as $tt) {
			$this->patterns[] = "#\[{$tt}\](.*?)\[/{$tt}\]#s";
			$this->replacements[] = "<{$tt}>\\1</{$tt}>";
		}
	}
	public function tag($t, $r) {
		if(!empty($t)) {
			$this->patterns[] = "#\[{$t}\](.*?)\[/{$t}\]#s";
			$this->replacements[] = $r;
		}
	}
	public function attribute($t, $r) {
		if(!empty($t)) {
			$this->patterns[] = "#\[{$t}\=(.*?)](.*?)\[/{$t}\]#s";
			$this->replacements[] = $r;
		}
	}
	public function parse($t, $r) {
		if(!empty($t)) {
			$this->patterns[] = $t;
			$this->replacements[] = $r;
		}
	}
	private function txt($str) {
		if(!empty($this->patterns)) {
			$str = preg_replace($this->patterns, $this->replacements, $str);
		}
		$str = nl2br($str);
		if($this->ul) {
			$str = preg_replace_callback('#\[ul\](.*?)\[\/ul\]#sU', 'format::pul', $str);
		}
		return $str;
	}
	private function code($str) {
		$str = htmlspecialchars_decode($str);
		$str = highlight_string($str, true);
		return '<pre class="code">'.$str.'</pre>';
	}
	public function result() {
		if($this->code) {
			for($c = 0; $c < count($this->str); $c++) {
				$this->str[$c] = ($c % 2 == 0) ? $this->txt($this->str[$c]) : self::code($this->str[$c]);
			}
			return implode('', $this->str);
		} else {
			$this->txt($this->str);
		}
	}
}
