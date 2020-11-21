<?php
if (!defined('IN_IA')) {
	exit('Access Denied');
}

require __DIR__ . '/base.php';
class Poster_EweiShopV2Page extends Base_EweiShopV2Page
{
	public function main()
	{
		global $_W;
		$list = pdo_fetchall('SELECT id FROM ' . tablename('ewei_shop_wxapp_poster') . ' WHERE uniacid=:uniacid AND status=1 ORDER BY displayorder ASC, id DESC', array(':uniacid' => $_W['uniacid']));

		if (empty($list)) {
			return app_error(AppError::$CommissionPosterNotFound, '未设置默认海报');
		}

		return app_json(array('poster' => $list));
	}

	/**
     * 获取图片
     */
	public function getimage()
	{
		global $_W;
		global $_GPC;
		$id = intval($_GPC['id']);

		if (empty($id)) {
			return app_error(AppError::$ParamsError);
		}

		$member = $this->member;

		if (empty($member)) {
			return app_error(AppError::$UserLoginFail);
		}

		$poster = pdo_fetch('SELECT * FROM ' . tablename('ewei_shop_wxapp_poster') . ' WHERE id=:id AND uniacid=:uniacid LIMIT 1', array(':id' => $id, ':uniacid' => $_W['uniacid']));

		if (empty($poster)) {
			return app_error(AppError::$CommissionPosterNotFound);
		}

		$poster['data'] = iunserializer($poster['data']);
		$items = is_array($poster['data']) && is_array($poster['data']['items']) ? $poster['data']['items'] : array();
		set_time_limit(0);
		@ini_set('memory_limit', '256M');
		$path = IA_ROOT . '/addons/ewei_shopv2/data/poster_wxapp/commission/' . $_W['uniacid'] . '/';

		if (!is_dir($path)) {
			load()->func('file');
			mkdirs($path);
		}

		$md5 = md5(json_encode(array('siteroot' => $_W['siteroot'], 'openid' => $member['openid'], 'nickname' => $member['nickname'], 'bg' => $poster['bgimg'], 'data' => $poster['data'], 'version' => 1)));
		$filename = $md5 . '.png';
		$filename_thumb = $md5 . '_thumb.png';
		$filepath = $path . $filename;
		$filepath_thumb = $path . $filename_thumb;

		if (is_file($filepath)) {
			return app_json(array('thumb' => $this->getImgUrl($filename_thumb), 'poster' => $this->getImgUrl($filename)));
		}

		$bgimg = $this->createImage(tomedia($poster['bgimg']));
		$bgsize = array(imagesx($bgimg), imagesy($bgimg));
		$target = imagecreatetruecolor($bgsize[0], $bgsize[1]);
		imagecopy($target, $bgimg, 0, 0, 0, 0, $bgsize[0], $bgsize[1]);
		imagedestroy($bgimg);

		foreach ($items as $item) {
			if (empty($item) || empty($item['type'])) {
				continue;
			}

			switch ($item['type']) {
			case 'qrcode':
				$qrcode = $this->getQR($poster, $member);

				if (is_error($qrcode)) {
					break;
				}

				$target = $this->mergeImage($target, $item, $qrcode, true);
				break;

			case 'avatar':
				$avatar = preg_replace('/\\/0$/i', '/96', $member['avatar']);
				$target = $this->mergeImage($target, $item, $avatar);
				break;

			case 'nickname':
				$target = $this->mergeText($target, $item, $member['nickname']);
				break;
			}
		}

		imagepng($target, $filepath);
		$width_thumb = $bgsize[0];
		$height_thumb = $bgsize[1];
		$final_width = 640;
		$final_height = round($final_width * $height_thumb / $width_thumb);
		$target_thumb = imagecreatetruecolor($final_width, 1135);
		imagecopyresized($target_thumb, $target, 0, 0, 0, 0, $final_width, $final_height, $width_thumb, $height_thumb);
		imagepng($target_thumb, $filepath_thumb);
		imagedestroy($target_thumb);
		imagedestroy($target);
		return app_json(array('thumb' => $this->getImgUrl($filename_thumb), 'poster' => $this->getImgUrl($filename)));
	}

	/**
     * 获取图片路径
     * @param $filename
     * @return string
     */
	private function getImgUrl($filename)
	{
		global $_W;
		return $_W['siteroot'] . 'addons/ewei_shopv2/data/poster_wxapp/commission/' . $_W['uniacid'] . '/' . $filename . '?v=' . time();
	}

	/**
     * 获取二维码
     * @param array $poster
     * @param array $member
     * @return string
     */
	private function getQR($poster = array(), $member = array())
	{
		if (empty($poster) || empty($member)) {
			return '';
		}

		$image = p('app')->getCodeUnlimit(array('scene' => 'mid=' . $member['id'], 'page' => 'pages/index/index'));
		return $image;
	}

	/**
     * 获取背景图尺寸
     * @param string $imgurl
     * @return array
     */
	private function getImgSize($imgurl = '')
	{
		$size = array(640, 1008);
		if (!empty($imgurl) && function_exists('getimagesize')) {
			$imgsize = getimagesize($imgurl);

			if (is_array($imgsize)) {
				$size = $imgsize;
			}
		}

		return $size;
	}

	/**
     * 创建图片
     * @param $imgurl
     * @return resource|string
     */
	private function createImage($imgurl)
	{
		if (empty($imgurl)) {
			return '';
		}

		load()->func('communication');
		$resp = ihttp_request($imgurl);

		if (isset($resp['errno'])) {
			$urlArr = explode(':', $imgurl);

			if ($urlArr[0] == 'https') {
				$imgurl = 'http:' . $urlArr[1];
				$resp = ihttp_request($imgurl);
			}
		}

		if ($resp['code'] == 200 && !empty($resp['content'])) {
			return imagecreatefromstring($resp['content']);
		}

		$i = 0;

		while ($i < 3) {
			$resp = ihttp_request($imgurl);
			if ($resp['code'] == 200 && !empty($resp['content'])) {
				return imagecreatefromstring($resp['content']);
			}

			++$i;
		}

		return '';
	}

	/**
     * 合并图片
     * @param $target
     * @param $data
     * @param $imgurl
     */
	private function mergeImage($target = false, $data = array(), $imgurl = '', $local = false)
	{
		if (empty($data) || empty($imgurl)) {
			return $target;
		}

		if (!$local) {
			$image = $this->createImage($imgurl);
		}
		else {
			$image = imagecreatefromstring($imgurl);
		}

		$sizes = $sizes_default = array('width' => imagesx($image), 'height' => imagesy($image));

		if ($data['type'] == 'avatar') {
			switch ($data['size']) {
			case 'big':
				$sizes = array('width' => 150, 'height' => 150);
				break;

			case 'medium':
				$sizes = array('width' => 120, 'height' => 120);
				break;

			case 'small':
				$sizes = array('width' => 90, 'height' => 90);
				break;
			}
		}
		else {
			if ($data['type'] == 'qrcode') {
				switch ($data['size']) {
				case 'big':
					$sizes = array('width' => 240, 'height' => 240);
					break;

				case 'medium':
					$sizes = array('width' => 200, 'height' => 200);
					break;

				case 'small':
					$sizes = array('width' => 160, 'height' => 160);
					break;
				}
			}
		}

		if ($data['style'] == 'radius' || $data['style'] == 'circle') {
			$image = $this->imageZoom($image, 4);
			$image = $this->imageRadius($image, $data['style'] == 'circle');
			$sizes_default = array('width' => $sizes_default['width'] * 4, 'height' => $sizes_default['height'] * 4);
		}

		imagecopyresampled($target, $image, intval($data['left']) * 2, intval($data['top']) * 2, 0, 0, $sizes['width'], $sizes['height'], $sizes_default['width'], $sizes_default['height']);
		imagedestroy($image);
		return $target;
	}

	/**
     * 图片缩放
     * @param bool $image
     * @param int $zoom
     * @return resource
     */
	private function imageZoom($image = false, $zoom = 2)
	{
		$width = imagesx($image);
		$height = imagesy($image);
		$target = imagecreatetruecolor($width * $zoom, $height * $zoom);
		imagecopyresampled($target, $image, 0, 0, 0, 0, $width * $zoom, $height * $zoom, $width, $height);
		imagedestroy($image);
		return $target;
	}

	/**
     * 图片圆角
     * @param bool $target
     * @param bool $circle
     * @return resource
     */
	private function imageRadius($target = false, $circle = false)
	{
		$w = imagesx($target);
		$h = imagesy($target);
		$w = min($w, $h);
		$h = $w;
		$img = imagecreatetruecolor($w, $h);
		imagesavealpha($img, true);
		$bg = imagecolorallocatealpha($img, 255, 255, 255, 127);
		imagefill($img, 0, 0, $bg);
		$radius = $circle ? $w / 2 : 20;
		$r = $radius;
		$x = 0;

		while ($x < $w) {
			$y = 0;

			while ($y < $h) {
				$rgbColor = imagecolorat($target, $x, $y);
				if ($radius <= $x && $x <= $w - $radius || $radius <= $y && $y <= $h - $radius) {
					imagesetpixel($img, $x, $y, $rgbColor);
				}
				else {
					$y_x = $r;
					$y_y = $r;

					if (($x - $y_x) * ($x - $y_x) + ($y - $y_y) * ($y - $y_y) <= $r * $r) {
						imagesetpixel($img, $x, $y, $rgbColor);
					}

					$y_x = $w - $r;
					$y_y = $r;

					if (($x - $y_x) * ($x - $y_x) + ($y - $y_y) * ($y - $y_y) <= $r * $r) {
						imagesetpixel($img, $x, $y, $rgbColor);
					}

					$y_x = $r;
					$y_y = $h - $r;

					if (($x - $y_x) * ($x - $y_x) + ($y - $y_y) * ($y - $y_y) <= $r * $r) {
						imagesetpixel($img, $x, $y, $rgbColor);
					}

					$y_x = $w - $r;
					$y_y = $h - $r;

					if (($x - $y_x) * ($x - $y_x) + ($y - $y_y) * ($y - $y_y) <= $r * $r) {
						imagesetpixel($img, $x, $y, $rgbColor);
					}
				}

				++$y;
			}

			++$x;
		}

		return $img;
	}

	/**
     * 合并文字
     * @param $target
     * @param $data
     * @param $text
     */
	private function mergeText($target = false, $data = array(), $text = '')
	{
		if (empty($data) || empty($text)) {
			return $target;
		}

		$font = IA_ROOT . '/addons/ewei_shopv2/static/fonts/msyh.ttf';

		if (!is_file($font)) {
			return $target;
		}

		$colors = $this->hex2rgb($data['color']);
		$color = imagecolorallocate($target, $colors['red'], $colors['green'], $colors['blue']);

		switch ($data['size']) {
		case 'big':
			$fontsize = 32;
			break;

		case 'medium':
			$fontsize = 28;
			break;

		case 'small':
			$fontsize = 24;
			break;
		}

		$textbox = imagettfbbox($fontsize, 0, $font, $text);
		$textwidth = $textbox[4] - $textbox[6];
		$left = intval($data['left']) * 2;

		if ($data['align'] == 'center') {
			$left = imagesx($target) / 2 - $textwidth / 2;
		}

		imagettftext($target, $fontsize, 0, $left, intval($data['top']) * 2 + $fontsize * 1.5, $color, $font, $text);
		return $target;
	}

	/**
     * hex转rgb
     * @param $colour
     * @return array|bool
     */
	private function hex2rgb($colour)
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
