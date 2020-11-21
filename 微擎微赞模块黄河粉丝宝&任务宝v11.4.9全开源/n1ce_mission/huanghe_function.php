<?php 


function trimPx($data) {

	$data['left'] = intval(str_replace('px', '', $data['left'])) * 2;

	$data['top'] = intval(str_replace('px', '', $data['top'])) * 2;

	$data['width'] = intval(str_replace('px', '', $data['width'])) * 2;

	$data['height'] = intval(str_replace('px', '', $data['height'])) * 2;

	$data['size'] = intval(str_replace('px', '', $data['size'])) * 2;

	$data['src'] = tomedia($data['src']);

	return $data;

}



 function mergeImage($target, $imgurl , $data) {

	$img = imagecreates($imgurl);

	$w = imagesx($img);

	$h = imagesy($img);

	imagecopyresized($target, $img, $data['left'], $data['top'], 0, 0, $data['width'], $data['height'], $w, $h);

	imagedestroy($img);

	return $target;

}

 function mergeText($target ,$text , $data, $font) {

	$colors = hex2rgb($data['color']);

	$color = imagecolorallocate($target, $colors['red'], $colors['green'], $colors['blue']);

	imagettftext($target, $data['size'], 0, $data['left'], $data['top'] + $data['size'], $color, $font, $text);

	return $target;

}



function hex2rgb($colour) {

	if ($colour[0] == '#') {

		$colour = substr($colour, 1);

	}

	if (strlen($colour) == 6) {

		list($r, $g, $b) = array($colour[0] . $colour[1], $colour[2] . $colour[3], $colour[4] . $colour[5]);

	} elseif (strlen($colour) == 3) {

		list($r, $g, $b) = array($colour[0] . $colour[0], $colour[1] . $colour[1], $colour[2] . $colour[2]);

	} else {

		return false;

	}

	$r = hexdec($r);

	$g = hexdec($g);

	$b = hexdec($b);

	return array('red' => $r, 'green' => $g, 'blue' => $b);

}



/**合并图片

 * @param  $bg 背景图

 * @param  $qr 其他图

 * @param  $out 存放路径

 * @param $param 大小参数

 */

function mergeImage1($bgImg, $qr, $out, $param) {

	list($qrWidth, $qrHeight) = getimagesize($qr);

	$qrImg = imagecreates($qr);

	imagecopyresized($bgImg, $qrImg, $param['left'], $param['top'], 0, 0, $param['width'], $param['height'], $qrWidth, $qrHeight);

	ob_start();

	imagejpeg($bgImg, NULL, 100);

	$contents = ob_get_contents();

	ob_end_clean();

	imagedestroy($bgImg);

	imagedestroy($qrImg);

	$fh = fopen($out, "w+");

	fwrite($fh, $contents);

	fclose($fh);

}





/**创建图片

 * @param $bg 图片路径

 * @return

 */

function imagecreates($bg) {
	if(strpos($bg,'.jpg')){
		$bgImg = @imagecreatefromjpeg($bg);
	}elseif (strpos($bg,'.png')) {
		$bgImg = @imagecreatefrompng($bg);
	}elseif (strpos($bg,'.gif')) {
		$bgImg = @imagecreatefromgif($bg);
	}
	return $bgImg;
}



function saveImage($url) {

	$ch = curl_init ();

	curl_setopt ( $ch, CURLOPT_CUSTOMREQUEST, 'GET' );

	curl_setopt ( $ch, CURLOPT_SSL_VERIFYPEER, false );

	if(defined('CURLOPT_IPRESOLVE') && defined('CURL_IPRESOLVE_V4')){

		curl_setopt($ch, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4);

	}

	curl_setopt ( $ch, CURLOPT_URL, $url );

	ob_start ();

	curl_exec ( $ch );

	$return_content = ob_get_contents ();

	ob_end_clean ();

	$return_code = curl_getinfo ( $ch, CURLINFO_HTTP_CODE );

	$filename = IA_ROOT.'/attachment/images/temp'.time().rand(1000,9999).'.jpg';

	$fp= @fopen($filename,"a"); //将文件绑定到流

	fwrite($fp,$return_content); //写入文件

	return $filename;
 
}

function save_yuan($im){
	
	$filename = IA_ROOT.'/attachment/images/temp'.time().rand(1000,9999).'.png';
	imagepng($im,$filename);
	return $filename;
}
function yuan_img($src_img,$size) {
	$ch = curl_init ();
	curl_setopt ( $ch, CURLOPT_CUSTOMREQUEST, 'GET' );
	curl_setopt ( $ch, CURLOPT_SSL_VERIFYPEER, false );
	if(defined('CURLOPT_IPRESOLVE') && defined('CURL_IPRESOLVE_V4')){
		curl_setopt($ch, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4);
	}
	curl_setopt ( $ch, CURLOPT_URL, $src_img );
	ob_start ();
	curl_exec ( $ch );
	$src_img = ob_get_contents ();
	ob_end_clean ();
	$src_img = @imagecreatefromstring($src_img);
	$w = $h = $size;
	$img = imagecreatetruecolor($w, $h);
	//这一句一定要有
	imagesavealpha($img, true);
	//拾取一个完全透明的颜色,最后一个参数127为全透明
	$bg = imagecolorallocatealpha($img, 255, 255, 255, 127);
	imagefill($img, 0, 0, $bg);
	$r   = $w / 2; //圆半径
	$y_x = $r; //圆心X坐标
	$y_y = $r; //圆心Y坐标
	for ($x = 0; $x < $w; $x++) {
		for ($y = 0; $y < $h; $y++) {
			$rgbColor = imagecolorat($src_img, $x, $y);
			if (((($x - $r) * ($x - $r) + ($y - $r) * ($y - $r)) < ($r * $r))) {
				imagesetpixel($img, $x, $y, $rgbColor);
			}
		}
	}
	return $img;
}