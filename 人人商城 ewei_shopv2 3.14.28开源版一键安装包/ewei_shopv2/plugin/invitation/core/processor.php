<?php

if (!defined('IN_IA')) {
	exit('Access Denied');
}

require_once IA_ROOT . '/addons/ewei_shopv2/defines.php';
require_once EWEI_SHOPV2_INC . 'plugin_processor.php';
require_once EWEI_SHOPV2_INC . 'receiver.php';
class InvitationProcessor extends PluginProcessor
{
	public function __construct()
	{
		parent::__construct('invitation');
	}

	public function respond($obj = NULL)
	{
		global $_W;
		$message = $obj->message;
		$msgtype = strtolower($message['msgtype']);
		$event = strtolower($message['event']);
		if ($msgtype == 'text' || $event == 'click') {
			return $this->responseText($obj);
		}

		if ($msgtype == 'event') {
			if ($event == 'scan') {
				return $this->handle($obj);
			}

			if ($event == 'subscribe') {
				return $this->handle($obj, true);
			}
		}
	}

	private function responseEmpty()
	{
		ob_clean();
		ob_start();
		echo '';
		ob_flush();
		ob_end_flush();
		exit(0);
	}

	private function responseDefault($obj, $code = 0)
	{
		$text = '感谢您的关注';

		if (!empty($code)) {
			$text .= '(' . $code . ')';
		}

		return $obj->respText($text);
	}

	private function handle($obj, $follow = false)
	{
		global $_W;
		$openid = $obj->message['from'];
		$sceneid = $obj->message['eventkey'];
		$ticket = $obj->message['ticket'];

		if (empty($ticket)) {
			return $this->responseDefault($obj, 1);
		}

		$qr = $this->model->getQRByTicket($ticket);
		if (empty($qr) || empty($qr['invitationid']) || empty($qr['roomid'])) {
			return $this->responseDefault($obj, 2);
		}

		$invitation = pdo_fetch('SELECT * FROM ' . tablename('ewei_shop_invitation') . ' WHERE id=:id AND status=1 AND qrcode=1 AND uniacid=:uniacid', array(':id' => $qr['invitationid'], ':uniacid' => $_W['uniacid']));

		if (empty($invitation)) {
			$this->responseDefault($obj, 3);
		}

		if ($invitation['type'] == 0 && p('live')) {
			$room = pdo_fetch('SELECT * FROM ' . tablename('ewei_shop_live') . ' WHERE id=:id AND status=1 AND uniacid=:uniacid', array(':id' => $qr['roomid'], ':uniacid' => $_W['uniacid']));

			if (empty($room)) {
				$this->responseDefault($obj, 4);
			}

			$this->model->scanLog($openid, $qr, $follow);
			$member = m('member')->getMember($qr['openid']);
			$news = array(
				array('title' => !empty($room['share_title']) ? $room['share_title'] : $room['title'], 'picurl' => !empty($room['share_icon']) ? tomedia($room['share_icon']) : tomedia($room['thumb']), 'description' => !empty($room['share_desc']) ? $room['share_desc'] : $this->filter($room['introduce']), 'url' => $_W['siteroot'] . 'app/index.php?i=' . $_W['uniacid'] . '&c=entry&m=ewei_shopv2&do=mobile&r=live.room&id=' . $room['id'] . '&mid=' . $member['id'])
			);
		}
		else {
			$this->responseDefault($obj, 4);
		}

		return $obj->respNews($news);
	}

	/**
     * 过滤特殊字符/html标签
     * @param $str
     * @return mixed
     */
	protected function filter($str)
	{
		if (!empty($str)) {
			$search = array('\'<script[^>]*?>.*?</script>\'si', '\'<[\\/\\!]*?[^<>]*?>\'si', '\'([
])[\\s]+\'', '\'&(quot|#34);\'i', '\'&(amp|#38);\'i', '\'&(lt|#60);\'i', '\'&(gt|#62);\'i', '\'&(nbsp|#160);\'i', '\'&(iexcl|#161);\'i', '\'&(cent|#162);\'i', '\'&(pound|#163);\'i', '\'&(copy|#169);\'i');
			$replace = array('', '', '\\1', '"', '&', '<', '>', ' ', chr(161), chr(162), chr(163), chr(169), 'chr(\\1)');
			$str = preg_replace($search, $replace, $str);
		}

		return $str;
	}
}

?>
