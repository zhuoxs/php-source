<?php
//QQ63779278
if (!defined('IN_IA')) {
	exit('Access Denied');
}

class InvitationModel extends PluginModel
{
	public function getQR($params = array())
	{
		global $_W;
		$expire = 2592000;
		$create = false;
		$qr = pdo_fetch('select * from ' . tablename('ewei_shop_invitation_qr') . ' where openid=:openid and acid=:acid and invitationid=:invitationid and roomid=:roomid limit 1', array(':openid' => $params['openid'], ':acid' => $_W['acid'], ':invitationid' => $params['invitationid'], ':roomid' => $params['roomid']));

		if (empty($qr)) {
			$scene_id = $this->getSceneID();
			$result = $this->getSceneTicket($scene_id, $expire);

			if (is_error($result)) {
				return $result;
			}

			if (empty($result)) {
				return error(-1, '生成二维码失败');
			}

			$qrimg = 'https://mp.weixin.qq.com/cgi-bin/showqrcode?ticket=' . $result['ticket'];
			$ims_qrcode = array('uniacid' => $_W['uniacid'], 'acid' => $_W['acid'], 'qrcid' => $scene_id, 'model' => 0, 'name' => 'EWEI_SHOP_INVITATION_QRCODE', 'keyword' => 'EWEI_SHOP_INVITATION', 'expire' => $expire, 'createtime' => time(), 'status' => 1, 'url' => $result['url'], 'ticket' => $result['ticket']);
			pdo_insert('qrcode', $ims_qrcode);
			$qr = array('acid' => $_W['acid'], 'openid' => $params['openid'], 'sceneid' => $scene_id, 'ticket' => $result['ticket'], 'qrimg' => $qrimg, 'invitationid' => $params['invitationid'], 'roomid' => $params['roomid'], 'createtime' => time(), 'expire' => $expire);
			pdo_insert('ewei_shop_invitation_qr', $qr);
			$qr['id'] = pdo_insertid();
			$create = true;
		}
		else {
			if ($qr['createtime'] + $qr['expire'] <= time()) {
				$result = $this->getSceneTicket($expire, $qr['sceneid']);

				if (is_error($result)) {
					return $result;
				}

				if (empty($result)) {
					return error(-1, '生成二维码失败');
				}

				$qrimg = 'https://mp.weixin.qq.com/cgi-bin/showqrcode?ticket=' . $result['ticket'];
				pdo_update('qrcode', array('ticket' => $result['ticket'], 'url' => $result['url']), array('acid' => $_W['acid'], 'qrcid' => $qr['sceneid']));
				pdo_update('ewei_shop_invitation_qr', array('ticket' => $result['ticket'], 'qrimg' => $qrimg, 'url' => $result['url']), array('id' => $qr['id']));
				$qr['ticket'] = $result['ticket'];
				$create = true;
			}
		}

		return $this->createImage($qr['qrimg'], $create);
	}

	/**
     * 获取场景ticket
     * @param $scene_id
     * @param int $expire
     * @return array|bool
     */
	protected function getSceneTicket($scene_id, $expire = 2592000)
	{
		$account = m('common')->getAccount();
		$bb = '{"expire_seconds":' . $expire . ',"action_info":{"scene":{"scene_id":' . $scene_id . '}},"action_name":"QR_SCENE"}';
		$token = $account->fetch_token();
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

	/**
     * 获取场景ID
     * @return int
     */
	protected function getSceneID()
	{
		global $_W;
		$start = 1;
		$end = 2147483647;
		$scene_id = rand($start, $end);

		if (empty($scene_id)) {
			$scene_id = rand($start, $end);
		}

		while (1) {
			$count = pdo_fetchcolumn('select count(*) from ' . tablename('qrcode') . ' where qrcid=:qrcid and acid=:acid and model=0 limit 1', array(':qrcid' => $scene_id, ':acid' => $_W['acid']));

			if ($count <= 0) {
				break;
			}

			$scene_id = rand($start, $end);

			if (empty($scene_id)) {
				$scene_id = rand($start, $end);
			}
		}

		return $scene_id;
	}

	/**
     * 获取图片
     * @param $url
     * @param bool $create
     * @return string
     */
	protected function createImage($url, $create = false)
	{
		global $_W;
		$path = IA_ROOT . '/addons/ewei_shopv2/data/qrcode/invitation/' . $_W['uniacid'] . '/';

		if (!is_dir($path)) {
			load()->func('file');
			mkdirs($path);
		}

		$fileContents = file_get_contents($url);
		$file = md5(base64_encode($url)) . '.jpg';
		$filename = $path . $file;
		if (!$create && is_file($filename)) {
			return $_W['siteroot'] . 'addons/ewei_shopv2/data/qrcode/invitation/' . $_W['uniacid'] . '/' . $file;
		}

		file_put_contents($filename, $fileContents);
		return $_W['siteroot'] . 'addons/ewei_shopv2/data/qrcode/invitation/' . $_W['uniacid'] . '/' . $file;
	}

	/**
     * 通过ticket获取qrcode
     * @param $ticket
     */
	public function getQRByTicket($ticket)
	{
		global $_W;

		if (empty($ticket)) {
			return false;
		}

		$qr = pdo_fetch('SELECT * FROM ' . tablename('ewei_shop_invitation_qr') . ' WHERE ticket=:ticket AND acid=:acid', array(':ticket' => $ticket, ':acid' => $_W['acid']));

		if (empty($qr)) {
			return false;
		}

		return $qr;
	}

	public function scanLog($openid = NULL, $qr = array(), $follow = false)
	{
		global $_W;
		if (empty($openid) || empty($qr)) {
			return false;
		}

		pdo_query('UPDATE ' . tablename('ewei_shop_invitation') . ' SET scan=scan+1 WHERE id=:id AND uniacid=:uniacid', array(':id' => $qr['invitationid'], ':uniacid' => $_W['uniacid']));

		if ($follow) {
			pdo_query('UPDATE ' . tablename('ewei_shop_invitation') . ' SET follow=follow+1 WHERE id=:id AND uniacid=:uniacid', array(':id' => $qr['invitationid'], ':uniacid' => $_W['uniacid']));
		}

		pdo_insert('ewei_shop_invitation_log', array('uniacid' => $_W['uniacid'], 'invitation_id' => $qr['invitationid'], 'openid' => $openid, 'invitation_openid' => $qr['openid'], 'scan_time' => time(), 'follow' => $follow ? 1 : 0));
	}
}

?>
