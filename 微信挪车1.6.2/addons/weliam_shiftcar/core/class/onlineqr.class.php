<?php
class onlineqr{
	
	static function createPoster($member, $qr){
		global $_W;
		$path = IA_ROOT . '/addons/weliam_shiftcar/data/apply/' . $_W['uniacid'] . '/';
		if (!is_dir($path)) {
			load()->func('file');
			mkdirs($path);
		}
		$md5 = md5(json_encode(array('openid' => $member['openid'], 'ncnumber' => $member['ncnumber'], 'bg' => $_W['wlsetting']['apply']['bg'], 'data' => $_W['wlsetting']['apply']['data'], 'version' => 1)));
		$file = $md5 . '.png';
		if (!is_file($path . $file)) {
			set_time_limit(0);
			@ini_set('memory_limit', '256M');
			$target = imagecreatetruecolor(2479, 3508);
			$bg = self::createImage(tomedia($_W['wlsetting']['apply']['bg']));
			imagecopy($target, $bg, 0, 0, 0, 0, 2479, 3508);
			imagedestroy($bg);
			$data = json_decode(str_replace('&quot;', '\'', $_W['wlsetting']['apply']['data']), true);

			foreach ($data as $d) {
				$d = self::getRealData($d);

				if ($d['type'] == 'img') {
					$target = self::mergeImage($target, $d, $d['src']);
				}
				else if ($d['type'] == 'qr') {
					$target = self::mergeImage($target, $d, $qr);
				}
				else if ($d['type'] == 'nickname') {
					$target = self::mergeText($target, $d, $member['ncnumber']);
				}
			}

			imagepng($target, $path . $file);
			imagedestroy($target);
		}

		$img = $_W['siteroot'] . 'addons/weliam_shiftcar/data/apply/' . $_W['uniacid'] . '/' . $file;

		return $img;
	}

	static function getRealData($data)
	{
		$data['left'] = intval(str_replace('px', '', $data['left'])) * 7.84;
		$data['top'] = intval(str_replace('px', '', $data['top'])) * 7.84;
		$data['width'] = intval(str_replace('px', '', $data['width'])) * 7.84;
		$data['height'] = intval(str_replace('px', '', $data['height'])) * 7.84;
		$data['size'] = intval(str_replace('px', '', $data['size'])) * 7.84;
		$data['src'] = tomedia($data['src']);
		return $data;
	}

	static function createImage($imgurl)
	{
		load()->func('communication');
		$resp = ihttp_request($imgurl);
		if (($resp['code'] == 200) && !empty($resp['content'])) {
			return imagecreatefromstring($resp['content']);
		}

		$i = 0;

		while ($i < 3) {
			$resp = ihttp_request($imgurl);
			if (($resp['code'] == 200) && !empty($resp['content'])) {
				return imagecreatefromstring($resp['content']);
			}

			++$i;
		}

		return '';
	}

	static function mergeImage($target, $data, $imgurl)
	{
		$img = self::createImage($imgurl);
		$w = imagesx($img);
		$h = imagesy($img);
		imagecopyresized($target, $img, $data['left'], $data['top'], 0, 0, $data['width'], $data['height'], $w, $h);
		imagedestroy($img);
		return $target;
	}
	
	static function mergeText($target, $data, $text)
	{
		$font = IA_ROOT . '/addons/weliam_shiftcar/web/resource/fonts/msyh.ttf';
		$colors = self::hex2rgb($data['color']);
		$color = imagecolorallocate($target, $colors['red'], $colors['green'], $colors['blue']);
		imagettftext($target, $data['size'], 0, $data['left'], $data['top'] + $data['size'], $color, $font, $text);
		return $target;
	}

	static function hex2rgb($colour)
	{
		if ($colour[0] == '#') {
			$colour = substr($colour, 1);
		}

		if (strlen($colour) == 6) {
			list($r, $g, $b) = array($colour[0] . $colour[1], $colour[2] . $colour[3], $colour[4] . $colour[5]);
		}
		else if (strlen($colour) == 3) {
			list($r, $g, $b) = array($colour[0] . $colour[0], $colour[1] . $colour[1], $colour[2] . $colour[2]);
		}
		else {
			return false;
		}

		$r = hexdec($r);
		$g = hexdec($g);
		$b = hexdec($b);
		return array('red' => $r, 'green' => $g, 'blue' => $b);
	}
}
?>