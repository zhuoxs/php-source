<?php
if (!(defined('IN_IA'))) {
	exit('Access Denied');
}


require EWEI_SHOPV2_PLUGIN . 'app/core/page_mobile.php';
class Poster_EweiShopV2Page extends AppMobilePage
{
	public function getimage()
	{
		global $_W;
		global $_GPC;
		$id = intval($_GPC['id']);

		if (empty($id)) {
			app_error(AppError::$ParamsError, '参数错误');
		}


		$goods = pdo_fetch('select * from ' . tablename('ewei_shop_goods') . ' where id=:id and uniacid=:uniacid limit 1', array(':id' => $id, ':uniacid' => $_W['uniacid']));

		if (empty($goods)) {
			app_error(AppError::$GoodsNotFound, '商品未找到');
		}


		$member = $this->member;

		if (empty($member)) {
			$member = array();
		}


		$imgurl = $this->createPoster($goods, $member);

		if (empty($imgurl)) {
			app_error(AppError::$PosterCreateFail, '海报生成失败');
		}


		app_json(array('url' => $imgurl));
	}

	private function createPoster($goods = array(), $member = array())
	{
		global $_W;
		set_time_limit(0);
		@ini_set('memory_limit', '256M');
		$path = IA_ROOT . '/addons/ewei_shopv2/data/poster_wxapp/goods/' . $_W['uniacid'] . '/';

		if (!(is_dir($path))) {
			load()->func('file');
			mkdirs($path);
		}


		$md5 = md5(json_encode(array('siteroot' => $_W['siteroot'], 'openid' => $member['openid'], 'goodstitle' => $goods['title'], 'goodprice' => $goods['minprice'], 'version' => 1)));
		$filename = $md5 . '.png';
		$filepath = $path . $filename;

		if (is_file($filepath)) {
			return $this->getImgUrl($filename);
		}


		$target = imagecreatetruecolor(750, 1105);
		$white = imagecolorallocate($target, 255, 255, 255);
		imagefill($target, 0, 0, $white);

		if (!(empty($goods['thumb']))) {
			$thumb = $this->createImage(tomedia($goods['thumb']));
			imagecopyresized($target, $thumb, 32, 32, 0, 0, 686, 686, imagesx($thumb), imagesy($thumb));
		}


		$pricebgstr = file_get_contents(IA_ROOT . '/addons/ewei_shopv2/plugin/app/static/images/poster/goodsprice.png');
		$pricebg = imagecreatefromstring($pricebgstr);
		imagecopyresized($target, $pricebg, 32, 632, 0, 0, 686, 86, 686, 86);
		$font = IA_ROOT . '/addons/ewei_shopv2/static/fonts/pingfang.ttf';

		if (!(is_file($font))) {
			$font = IA_ROOT . '/addons/ewei_shopv2/static/fonts/msyh.ttf';
		}


		imagettftext($target, 50, 0, 80, 700, $white, $font, $goods['minprice']);
		imagettftext($target, 28, 0, 50, 700, $white, $font, '￥');
		$titles = $this->getGoodsTitles($goods['title'], 28, $font, 686);
		$black = imagecolorallocate($target, 0, 0, 0);
		imagettftext($target, 28, 0, 32, 782, $black, $font, $titles[0]);
		imagettftext($target, 28, 0, 32, 840, $black, $font, $titles[1]);
		$boxstr = file_get_contents(IA_ROOT . '/addons/ewei_shopv2/plugin/app/static/images/poster/goodsbox.png');
		$box = imagecreatefromstring($boxstr);
		imagecopyresized($target, $box, 32, 875, 0, 0, 686, 195, 690, 195);
		$qrcode = p('app')->getCodeUnlimit(array('scene' => 'id=' . $goods['id'] . '&mid=' . $member['id'], 'page' => '/pages/goods/detail/index'));

		if (!(is_error($qrcode))) {
			$qrcode = imagecreatefromstring($qrcode);
			imagecopyresized($target, $qrcode, 70, 885, 0, 0, 176, 176, imagesx($qrcode), imagesy($qrcode));
		}


		$gary2 = imagecolorallocate($target, 102, 102, 102);
		imagettftext($target, 24, 0, 320, 985, $gary2, $font, '长按识别小程序码访问');
		imagepng($target, $filepath);
		imagedestroy($target);
		return $this->getImgUrl($filename);
	}

	/**
     * 获取图片路径
     * @param $filename
     * @return string
     */
	private function getImgUrl($filename)
	{
		global $_W;
		return $_W['siteroot'] . 'addons/ewei_shopv2/data/poster_wxapp/goods/' . $_W['uniacid'] . '/' . $filename . '?v=1.0';
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

		if (($resp['code'] == 200) && !(empty($resp['content']))) {
			return imagecreatefromstring($resp['content']);
		}


		$i = 0;

		while ($i < 3) {
			$resp = ihttp_request($imgurl);

			if (($resp['code'] == 200) && !(empty($resp['content']))) {
				return imagecreatefromstring($resp['content']);
			}


			++$i;
		}

		return '';
	}

	/**
     * 获取商品标题
     * @param $text
     * @param int $width
     */
	private function getGoodsTitles($text, $fontsize = 30, $font = '', $width = 100)
	{
		$titles = array('', '');
		$textLen = mb_strlen($text, 'UTF8');

		if (15 < $textLen) {
			$titleLen1 = 15;
			$i = 15;

			while ($i <= $textLen) {
				$titleText1 = mb_substr($text, 0, $i, 'UTF8');
				$titleWidth1 = imagettfbbox($fontsize, 0, $font, $titleText1);

				if ($width < ($titleWidth1[4] - $titleWidth1[6])) {
					$titleLen1 = $i - 1;
					break;
				}


				++$i;
			}

			$titles[0] = mb_substr($text, 0, $titleLen1, 'UTF8');
			$titleLen2 = 15;
			$i = 15;

			while ($i <= $textLen) {
				$titleText2 = mb_substr($text, $titleLen1, $i, 'UTF8');
				$titleWidth2 = imagettfbbox($fontsize, 0, $font, $titleText2);

				if ($width < ($titleWidth2[4] - $titleWidth2[6])) {
					$titleLen2 = $i - 1;
					break;
				}


				++$i;
			}

			$titles[1] = mb_substr($text, $titleLen1, $titleLen2, 'UTF8');

			if (($titleLen1 + $titleLen2) < $textLen) {
				$titles[1] = mb_substr($titles[1], 0, $titleLen2 - 1, 'UTF8');
				$titles[1] .= '...';
			}

		}
		 else {
			$titles[0] = $text;
		}

		return $titles;
	}
}


?>