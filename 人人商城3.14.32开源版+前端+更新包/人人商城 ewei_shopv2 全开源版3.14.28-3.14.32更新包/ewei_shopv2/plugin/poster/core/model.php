<?php
if (!defined('IN_IA')) {
	exit('Access Denied');
}

class PosterModel extends PluginModel
{
	public function checkScan($openid = '')
	{
		global $_W;
		global $_GPC;
		$posterid = intval($_GPC['posterid']);

		if (empty($posterid)) {
			return NULL;
		}

		$poster = pdo_fetch('select id,times from ' . tablename('ewei_shop_poster') . ' where id=:id and uniacid=:uniacid limit 1', array(':uniacid' => $_W['uniacid'], ':id' => $posterid));

		if (empty($poster)) {
			return NULL;
		}

		$mid = intval($_GPC['mid']);

		if (empty($mid)) {
			return NULL;
		}

		$parent = m('member')->getMember($mid);

		if (empty($parent)) {
			return NULL;
		}

		$this->scanTime($openid, $parent['openid'], $poster);
	}

	public function scanTime($openid, $from_openid, $poster)
	{
		if ($openid == $from_openid) {
			return NULL;
		}

		global $_W;
		global $_GPC;
		$scancount = pdo_fetchcolumn('select count(*) from ' . tablename('ewei_shop_poster_scan') . ' where openid=:openid  and posterid=:posterid and uniacid=:uniacid limit 1', array(':openid' => $openid, ':posterid' => $poster['id'], ':uniacid' => $_W['uniacid']));

		if ($scancount <= 0) {
			$scan = array('uniacid' => $_W['uniacid'], 'posterid' => $poster['id'], 'openid' => $openid, 'from_openid' => $from_openid, 'scantime' => time());
			pdo_insert('ewei_shop_poster_scan', $scan);
			pdo_update('ewei_shop_poster', array('times' => $poster['times'] + 1), array('id' => $poster['id']));
		}
	}

	public function createCommissionPoster($openid, $goodsid = 0, $type = 0)
	{
		global $_W;

		if (!$type) {
			$type = 2;

			if (!empty($goodsid)) {
				$type = 3;
			}
		}

		$poster = pdo_fetch('select * from ' . tablename('ewei_shop_poster') . ' where uniacid=:uniacid and `type`=:type and isdefault=1 limit 1', array(':uniacid' => $_W['uniacid'], ':type' => $type));

		if (empty($poster)) {
			return '';
		}

		$member = m('member')->getMember($openid);

		if (empty($poster)) {
			return '';
		}

		$qr = $this->getQR($poster, $member, $goodsid);

		if (empty($qr)) {
			return '';
		}

		return $this->createPoster($poster, $member, $qr, false);
	}

	public function getFixedTicket($poster, $member, $uniaccount)
	{
		global $_W;
		global $_GPC;
		$scene_str = md5('ewei_shop_poster:' . $_W['uniacid'] . ':' . $member['openid'] . ':' . $poster['id']);
		$bb = '{"action_info":{"scene":{"scene_str":"' . $scene_str . '"} },"action_name":"QR_LIMIT_STR_SCENE"}';
		$token = $uniaccount->fetch_token();
		$url = 'https://api.weixin.qq.com/cgi-bin/qrcode/create?access_token=' . $token;
		$ch1 = curl_init();
		curl_setopt($ch1, CURLOPT_URL, $url);
		curl_setopt($ch1, CURLOPT_POST, 1);
		curl_setopt($ch1, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch1, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch1, CURLOPT_SSL_VERIFYHOST, false);
		curl_setopt($ch1, CURLOPT_POSTFIELDS, $bb);
		$c = curl_exec($ch1);
		$result = @json_decode($c, true);

		if (!is_array($result)) {
			return false;
		}

		if (!empty($result['errcode'])) {
			return error(-1, $result['errmsg']);
		}

		$ticket = $result['ticket'];
		return array('barcode' => json_decode($bb, true), 'ticket' => $ticket);
	}

	public function getQR($poster, $member, $goodsid = 0)
	{
		global $_W;
		global $_GPC;
		$acid = $_W['acid'];

		if ($poster['type'] == 1) {
			$qrimg = m('qrcode')->createShopQrcode($member['id'], $poster['id']);
			$qr = pdo_fetch('select * from ' . tablename('ewei_shop_poster_qr') . ' where openid=:openid and acid=:acid and type=:type limit 1', array(':openid' => $member['openid'], ':acid' => $_W['acid'], ':type' => 1));

			if (empty($qr)) {
				$qr = array('acid' => $acid, 'openid' => $member['openid'], 'type' => 1, 'qrimg' => $qrimg);
				pdo_insert('ewei_shop_poster_qr', $qr);
				$qr['id'] = pdo_insertid();
			}

			$qr['current_qrimg'] = $qrimg;
			return $qr;
		}

		if ($poster['type'] == 2) {
			$p = p('commission');

			if ($p) {
				$qrimg = $p->createMyShopQrcode($member['id'], $poster['id']);
				$qr = pdo_fetch('select * from ' . tablename('ewei_shop_poster_qr') . ' where openid=:openid and acid=:acid and type=:type limit 1', array(':openid' => $member['openid'], ':acid' => $_W['acid'], ':type' => 2));

				if (empty($qr)) {
					$qr = array('acid' => $acid, 'openid' => $member['openid'], 'type' => 2, 'qrimg' => $qrimg);
					pdo_insert('ewei_shop_poster_qr', $qr);
					$qr['id'] = pdo_insertid();
				}

				$qr['current_qrimg'] = $qrimg;
				return $qr;
			}
		}
		else {
			if ($poster['type'] == 3) {
				$qrimg = m('qrcode')->createGoodsQrcode($member['id'], $goodsid, $poster['id']);
				$qr = pdo_fetch('select * from ' . tablename('ewei_shop_poster_qr') . ' where openid=:openid and acid=:acid and type=:type and goodsid=:goodsid limit 1', array(':openid' => $member['openid'], ':acid' => $_W['acid'], ':type' => 3, ':goodsid' => $goodsid));

				if (empty($qr)) {
					$qr = array('acid' => $acid, 'openid' => $member['openid'], 'type' => 3, 'goodsid' => $goodsid, 'qrimg' => $qrimg);
					pdo_insert('ewei_shop_poster_qr', $qr);
					$qr['id'] = pdo_insertid();
				}

				$qr['current_qrimg'] = $qrimg;
				return $qr;
			}

			if ($poster['type'] == 4) {
				$uniaccount = WeAccount::create($acid);
				$qr = pdo_fetch('select * from ' . tablename('ewei_shop_poster_qr') . ' where openid=:openid and acid=:acid and type=4 limit 1', array(':openid' => $member['openid'], ':acid' => $acid));
				if (empty($qr) || empty($qr['scenestr'])) {
					$result = $this->getFixedTicket($poster, $member, $uniaccount);

					if (is_error($result)) {
						return $result;
					}

					if (empty($result)) {
						return error(-1, '生成二维码失败');
					}

					$barcode = $result['barcode'];
					$ticket = $result['ticket'];
					$qrimg = 'https://mp.weixin.qq.com/cgi-bin/showqrcode?ticket=' . $ticket;
					$ims_qrcode = array('uniacid' => $_W['uniacid'], 'acid' => $_W['acid'], 'scene_str' => $barcode['action_info']['scene']['scene_str'], 'model' => 2, 'name' => 'EWEI_SHOPV2_POSTER_QRCODE', 'keyword' => 'EWEI_SHOPV2_POSTER', 'expire' => 0, 'createtime' => time(), 'status' => 1, 'url' => $result['url'], 'ticket' => $result['ticket']);
					pdo_insert('qrcode', $ims_qrcode);
				}

				if (empty($qr)) {
					$qr = array('acid' => $acid, 'openid' => $member['openid'], 'type' => 4, 'scenestr' => $barcode['action_info']['scene']['scene_str'], 'ticket' => $result['ticket'], 'qrimg' => $qrimg, 'url' => $result['url']);
					pdo_insert('ewei_shop_poster_qr', $qr);
					$qr['id'] = pdo_insertid();
					$qr['current_qrimg'] = $qrimg;
				}
				else if (empty($qr['scenestr'])) {
					pdo_update('ewei_shop_poster_qr', array('scenestr' => $barcode['action_info']['scene']['scene_str'], 'ticket' => $result['ticket'], 'qrimg' => $qrimg), array('id' => $qr['id']));
					$qr['current_qrimg'] = 'https://mp.weixin.qq.com/cgi-bin/showqrcode?ticket=' . $result['ticket'];
				}
				else {
					$qr['current_qrimg'] = 'https://mp.weixin.qq.com/cgi-bin/showqrcode?ticket=' . $qr['ticket'];
				}

				return $qr;
			}
		}
	}

	public function getRealData($data)
	{
		$data['left'] = intval(str_replace('px', '', $data['left'])) * 2;
		$data['top'] = intval(str_replace('px', '', $data['top'])) * 2;
		$data['width'] = intval(str_replace('px', '', $data['width'])) * 2;
		$data['height'] = intval(str_replace('px', '', $data['height'])) * 2;
		$data['size'] = intval(str_replace('px', '', $data['size'])) * 2;
		$data['src'] = tomedia($data['src']);
		return $data;
	}

	public function createImage($imgurl)
	{
		load()->func('communication');
		$resp = ihttp_request($imgurl);
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

	public function mergeImage($target, $data, $imgurl)
	{
		$img = $this->createImage($imgurl);
		$w = imagesx($img);
		$h = imagesy($img);
		imagecopyresized($target, $img, $data['left'], $data['top'], 0, 0, $data['width'], $data['height'], $w, $h);
		imagedestroy($img);
		return $target;
	}

	public function mergeText($target, $data, $text)
	{
		$font = IA_ROOT . '/addons/ewei_shopv2/static/fonts/msyh.ttf';
		$colors = $this->hex2rgb($data['color']);
		$color = imagecolorallocate($target, $colors['red'], $colors['green'], $colors['blue']);
		imagettftext($target, $data['size'], 0, $data['left'], $data['top'] + $data['size'], $color, $font, $text);
		return $target;
	}

	public function hex2rgb($colour)
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

	public function createPoster($poster, $member, $qr, $upload = true)
	{
		global $_W;
		$path = IA_ROOT . '/addons/ewei_shopv2/data/poster/' . $_W['uniacid'] . '/';

		if (!is_dir($path)) {
			load()->func('file');
			mkdirs($path);
		}

		if (!empty($qr['goodsid'])) {
			$goods = pdo_fetch('select id,title,thumb,commission_thumb,marketprice,productprice from ' . tablename('ewei_shop_goods') . ' where id=:id and uniacid=:uniacid limit 1', array(':id' => $qr['goodsid'], ':uniacid' => $_W['uniacid']));

			if (empty($goods)) {
				m('message')->sendCustomNotice($member['openid'], '未找到商品，无法生成海报');
				exit();
			}
		}

		$md5 = md5(json_encode(array('siteroot' => $_W['siteroot'], 'openid' => $member['openid'], 'goodsid' => $qr['goodsid'], 'bg' => $poster['bg'], 'data' => $poster['data'], 'version' => 1)));
		$file = $md5 . '.png';
		if (!is_file($path . $file) || $qr['qrimg'] != $qr['current_qrimg']) {
			set_time_limit(0);
			@ini_set('memory_limit', '256M');
			$target = imagecreatetruecolor(640, 1008);
			$bg = $this->createImage(tomedia($poster['bg']));
			if (!empty($bg)) {
			imagecopy($target, $bg, 0, 0, 0, 0, 640, 1008);
			imagedestroy($bg);
			}
			$data = json_decode(str_replace('&quot;', '\'', $poster['data']), true);

			foreach ($data as $d) {
				$d = $this->getRealData($d);

				if ($d['type'] == 'head') {
					$avatar = preg_replace('/\\/0$/i', '/96', $member['avatar']);
					$target = $this->mergeImage($target, $d, $avatar);
				}
				else if ($d['type'] == 'img') {
					$target = $this->mergeImage($target, $d, $d['src']);
				}
				else if ($d['type'] == 'qr') {
					$target = $this->mergeImage($target, $d, tomedia($qr['current_qrimg']));
				}
				else if ($d['type'] == 'nickname') {
					$target = $this->mergeText($target, $d, $member['nickname']);
				}
				else {
					if (!empty($goods)) {
						if ($d['type'] == 'title') {
							$title_width = (int) ($d['width'] / $d['size'] / 1.2);
							$width_left = 0;

							while ($width_left < strlen($goods['title'])) {
								$title = mb_substr($goods['title'], $width_left, $title_width, 'utf-8');
								$width_left += $title_width;
								$d['top'] += $d['size'] * 2;
								$target = $this->mergeText($target, $d, $title);
							}
						}
						else if ($d['type'] == 'thumb') {
							$thumb = !empty($goods['commission_thumb']) ? tomedia($goods['commission_thumb']) : tomedia($goods['thumb']);
							$target = $this->mergeImage($target, $d, $thumb);
						}
						else if ($d['type'] == 'marketprice') {
							$target = $this->mergeText($target, $d, $goods['marketprice']);
						}
						else {
							if ($d['type'] == 'productprice') {
								$target = $this->mergeText($target, $d, $goods['productprice']);
							}
						}
					}
				}
			}

			imagepng($target, $path . $file);
			imagedestroy($target);

			if ($qr['qrimg'] != $qr['current_qrimg']) {
				pdo_update('ewei_shop_poster_qr', array('qrimg' => $qr['current_qrimg']), array('id' => $qr['id']));
			}
		}

		$img = $_W['siteroot'] . 'addons/ewei_shopv2/data/poster/' . $_W['uniacid'] . '/' . $file;

		if (!$upload) {
			return $img;
		}

		if ($qr['qrimg'] != $qr['current_qrimg'] || empty($qr['mediaid']) || empty($qr['createtime']) || $qr['createtime'] + 3600 * 24 * 3 - 7200 < time()) {
			$mediaid = $this->uploadImage($path . $file);
			$qr['mediaid'] = $mediaid;
			pdo_update('ewei_shop_poster_qr', array('mediaid' => $mediaid, 'createtime' => time()), array('id' => $qr['id']));
		}

		return array('img' => $img, 'mediaid' => $qr['mediaid']);
	}

	public function uploadImage($img)
	{
		load()->func('communication');
		$account = m('common')->getAccount();
		$access_token = $account->fetch_token();
		$url = 'http://file.api.weixin.qq.com/cgi-bin/media/upload?access_token=' . $access_token . '&type=image';
		$ch1 = curl_init();
		$data = array('media' => '@' . $img);

		if (version_compare(PHP_VERSION, '5.5.0', '>')) {
			$data = array('media' => curl_file_create($img));
		}

		curl_setopt($ch1, CURLOPT_URL, $url);
		curl_setopt($ch1, CURLOPT_POST, 1);
		curl_setopt($ch1, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch1, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch1, CURLOPT_SSL_VERIFYHOST, false);
		curl_setopt($ch1, CURLOPT_POSTFIELDS, $data);
		$content = @json_decode(curl_exec($ch1), true);

		if (!is_array($content)) {
			$content = array('media_id' => '');
		}

		curl_close($ch1);
		return $content['media_id'];
	}

	public function getQRByTicket($ticket = '')
	{
		global $_W;

		if (empty($ticket)) {
			return false;
		}

		$qrs = pdo_fetchall('select * from ' . tablename('ewei_shop_poster_qr') . ' where ticket=:ticket and acid=:acid and type=4 limit 1', array(':ticket' => $ticket, ':acid' => $_W['acid']));
		$count = count($qrs);

		if ($count <= 0) {
			return false;
		}

		if ($count == 1) {
			return $qrs[0];
		}

		return false;
	}

	public function checkMember($openid = '', $acc = '')
	{
		global $_W;

		if (empty($acc)) {
			$acc = WeiXinAccount::create();
		}

		$userinfo = $acc->fansQueryInfo($openid);
		$userinfo['avatar'] = $userinfo['headimgurl'];
		load()->model('mc');
		$uid = mc_openid2uid($openid);

		if (!empty($uid)) {
			pdo_update('mc_members', array('nickname' => $userinfo['nickname'], 'gender' => $userinfo['sex'], 'nationality' => $userinfo['country'], 'resideprovince' => $userinfo['province'], 'residecity' => $userinfo['city'], 'avatar' => $userinfo['headimgurl']), array('uid' => $uid));
		}

		pdo_update('mc_mapping_fans', array('nickname' => $userinfo['nickname']), array('uniacid' => $_W['uniacid'], 'openid' => $openid));
		$model = m('member');
		$member = $model->getMember($openid);

		if (empty($member)) {
			$mc = mc_fetch($uid, array('realname', 'nickname', 'mobile', 'avatar', 'resideprovince', 'residecity', 'residedist'));
			$member = array('uniacid' => $_W['uniacid'], 'uid' => $uid, 'openid' => $openid, 'realname' => $mc['realname'], 'mobile' => $mc['mobile'], 'nickname' => !empty($mc['nickname']) ? $mc['nickname'] : $userinfo['nickname'], 'avatar' => !empty($mc['avatar']) ? $mc['avatar'] : $userinfo['avatar'], 'gender' => !empty($mc['gender']) ? $mc['gender'] : $userinfo['sex'], 'province' => !empty($mc['resideprovince']) ? $mc['resideprovince'] : $userinfo['province'], 'city' => !empty($mc['residecity']) ? $mc['residecity'] : $userinfo['city'], 'area' => $mc['residedist'], 'createtime' => time(), 'status' => 0);
			pdo_insert('ewei_shop_member', $member);
			$member['id'] = pdo_insertid();
			$member['isnew'] = true;

			if (method_exists(m('member'), 'memberRadisCountDelete')) {
				m('member')->memberRadisCountDelete();
			}

			$_SESSION['eweishop']['poster_member'] = true;
		}
		else {
			$member['nickname'] = $userinfo['nickname'];
			$member['avatar'] = $userinfo['headimgurl'];
			$member['province'] = $userinfo['province'];
			$member['city'] = $userinfo['city'];
			pdo_update('ewei_shop_member', $member, array('id' => $member['id']));
			$member['isnew'] = false;
		}

		return $member;
	}
}

?>
