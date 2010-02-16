function re(n) {
	c = document.comment.content;
	if(c.value.length == 0) {
		c.value = c.value + '#' + n + ' ';
	} else {
		c.value = c.value + "\n#" + n + ' ';
	}
	c.focus();
}
