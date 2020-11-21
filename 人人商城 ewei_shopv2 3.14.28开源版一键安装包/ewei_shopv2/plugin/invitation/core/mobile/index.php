<?php
//QQ63779278
if (!defined('IN_IA')) {
	exit('Access Denied');
}

class Index_EweiShopV2Page extends PluginMobilePage
{
	public function main()
	{
		global $_W;
		global $_GPC;
		$openid = trim($_W['openid']);
		$id = intval($_GPC['id']);
		$item = pdo_fetch('SELECT * FROM ' . tablename('ewei_shop_invitation') . ' WHERE id =:id and uniacid=:uniacid limit 1', array(':id' => $id, ':uniacid' => $_W['uniacid']));
		if (empty($item) || empty($item['status'])) {
			$this->message('邀请卡不存在');
		}

		$item['data'] = iunserializer($item['data']);

		if (empty($item['data']['selected'])) {
			$this->message('邀请卡模板配置错误');
		}

		$templist = $this->getTemp($item);

		if (empty($templist)) {
			$this->message('邀请卡模板配置错误');
		}

		$member = m('member')->getMember($openid);
		$mid = $member['isagent'] && $member['status'] ? $member['id'] : 0;

		if ($item['type'] == 0) {
			$roomid = intval($_GPC['roomid']);
			$room = pdo_fetch('SELECT id,title,introduce,invitation_id FROM ' . tablename('ewei_shop_live') . ' where uniacid = :uniacid and id=:roomid ', array(':uniacid' => $_W['uniacid'], ':roomid' => $roomid));

			if (empty($room)) {
				$this->message('邀请卡生成失败(直播间不存在)');
			}

			if ($room['invitation_id'] != $id) {
				$this->message('邀请卡生成失败(直播间未使用此邀请卡)');
			}

			$sharetext = '向你推荐了一个直播间';
			$cardname = $item['title'];
			$cardtitle = $room['title'];
			$descname = '直播间介绍';
			$search = array('\'<script[^>]*?>.*?</script>\'si', '\'<[\\/\\!]*?[^<>]*?>\'si', '\'([
])[\\s]+\'', '\'&(quot|#34);\'i', '\'&(amp|#38);\'i', '\'&(lt|#60);\'i', '\'&(gt|#62);\'i', '\'&(nbsp|#160);\'i', '\'&(iexcl|#161);\'i', '\'&(cent|#162);\'i', '\'&(pound|#163);\'i', '\'&(copy|#169);\'i');
			$replace = array('', '', '\\1', '"', '&', '<', '>', ' ', chr(161), chr(162), chr(163), chr(169), 'chr(\\1)');
			$desctext = preg_replace($search, $replace, $room['introduce']);
			$desctext = !empty($desctext) ? $desctext : '介绍未设置...';

			if ($item['qrcode'] == 0) {
				$url = mobileUrl('live/room', array('id' => $roomid, 'mid' => $mid, 'invitationid' => $id, 'invitation_openid' => $openid), true);
				$qrcode = m('qrcode')->createQrcode($url);
			}
			else {
				if ($item['qrcode'] == 1) {
					$qrcode = $this->model->getQR(array('openid' => $openid, 'invitationid' => $id, 'roomid' => $roomid, 'mid' => $mid));

					if (is_error($qrcode)) {
						$this->message('创建微信临时二维码时出错');
					}
				}
			}
		}
		else {
			$this->message('直播间类型设置错误');
		}

		if ((!strpos($member['avatar'], '.jpg') || !strpos($member['avatar'], '.png')) && !empty($member['avatar'])) {
			$member['avatar'] = $member['avatar'] . '.jpg';
		}

		$json = json_encode(array('bgImg' => '', 'logoimg' => tomedia($_W['shopset']['shop']['logo']), 'headImg' => !empty($member['avatar']) ? $member['avatar'] : tomedia($_W['shopset']['shop']['logo']), 'qrCode' => $qrcode, 'nickName' => $member['nickname'], 'shareText' => $sharetext, 'cardName' => $cardname, 'cardTitle' => $cardtitle, 'descName' => $descname, 'descText' => $desctext, 'element' => '#img'));
		$_W['shopshare'] = array('title' => $member['nickname'] . '制作了自己的邀请卡', 'imgUrl' => tomedia($templist[0]['nail']), 'desc' => '你也来试试，超好玩的！', 'link' => mobileUrl('invitation', array('id' => $id, 'mid' => $mid), true));

		if ($item['type'] == 0) {
			$_W['shopshare']['link'] .= '&roomid=' . $roomid;
		}

		include $this->template();
	}

	public function getqr()
	{
		$a = $_GET['qrcode'];
		$curl = curl_init();
		curl_setopt($curl, CURLOPT_URL, $a);
		curl_setopt($curl, CURLOPT_REFERER, '');
		curl_setopt($curl, CURLOPT_USERAGENT, 'Baiduspider');
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
		$result = curl_exec($curl);
		header('Content-type: image/jpg');
		echo $result;
	}

	/**
     * 获取邀请卡可用模板
     * @param $item
     * @return array
     */
	protected function getTemp($item)
	{
		if (empty($item['data']['selected'])) {
			return array();
		}

		$templist = array();

		foreach ($item['data']['selected'] as $tempid) {
			if (0 < intval($tempid)) {
				$templist[] = array('bg' => '../addons/ewei_shopv2/plugin/invitation/static/templist/image_' . $tempid . '_bg.jpg', 'nail' => '../addons/ewei_shopv2/plugin/invitation/static/templist/image_' . $tempid . '_nail.jpg');
			}
			else {
				if (empty($item['data']['upload'])) {
					continue;
				}

				if (empty($item['data']['upload'][$tempid])) {
					continue;
				}

				if (empty($item['data']['upload'][$tempid]['bg']) || empty($item['data']['upload'][$tempid]['nail'])) {
					continue;
				}

				$templist[] = array('bg' => tomedia($item['data']['upload'][$tempid]['bg']), 'nail' => tomedia($item['data']['upload'][$tempid]['nail']));
			}
		}

		unset($item);
		return $templist;
	}
}

?>
