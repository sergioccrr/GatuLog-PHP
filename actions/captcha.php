<?php

function randomText($length) {
	$key = '';
	$pattern = '1234567890abcdefghijklmnopqrstuvwxyz';
	for($i=0;$i<$length;$i++) $key .= $pattern{rand(0,35)};
	return $key;
}

function imagecenteredstring($image, $font, $str, $color) {
	$x = round((imagesx($image)/2)-((strlen($str)*imagefontwidth($font))/2), 1);
	$y = round((imagesy($image)/2)-(imagefontheight($font)/2));
	imagestring($image, $font, $x, $y, $str, $color);
}

$str = randomText(4);
$_SESSION[$_GET['cid']] = $str;

header('Cache-Control: no-store, no-cache, must-revalidate');
header('Pragma: no-cache');
header('Content-type: image/png');
$image = imagecreate(40, 20);
$color1 = imagecolorallocate($image, 255, 255, 255);
$color2 = imagecolorallocate($image, 0, 0, 0);
imagecenteredstring($image, 5, $str, $color2);
imagepng($image);

die();

?>