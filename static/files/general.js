/*
 * scromega blog CMS
 * Sergio Cruz aka scromega (scr.omega at gmail dot com) http://scromega.net
 */

function re(id, nick) {
	var str = '#' + id + ' ' + nick + ': ';
	c = document.comment.content;
	if(c.value.length == 0) {
		c.value += str;
	} else {
		c.value += "\n" + str;
	}
	c.focus();
}
