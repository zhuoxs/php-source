<?php
if (!defined('IN_IA')) {
	exit('Access Denied');
}

class Notice_EweiShopV2Page extends MobilePage
{
	public function main()
	{
		global $_W;
		global $_GPC;
		$openid = $_W['openid'];
		$uniacid = $_W['uniacid'];
		$member = m('member')->getMember($openid);
		$notice = iunserializer($member['noticeset']);
		$hascommission = false;

		if (p('commission')) {
			$cset = p('commission')->getSet();
			$hascommission = !empty($cset['level']);
		}

		return app_json(array('notice' => $notice, 'hascommission' => $hascommission));
	}

	public function submit()
	{
		global $_W;
		global $_GPC;
		$openid = $_W['openid'];
		$uniacid = $_W['uniacid'];
		$type = trim($_GPC['type']);
		$member = m('member')->getMember($openid);
		$notice = iunserializer($member['noticeset']);

		if (empty($type)) {
			return app_error(AppError::$ParamsError);
		}

		$checked = intval($_GPC['checked']);

		if (empty($checked)) {
			$notice[$type] = 1;
		}
		else {
			unset($notice[$type]);
		}

		pdo_update('ewei_shop_member', array('noticeset' => iserializer($notice)), array('openid' => $openid, 'uniacid' => $uniacid));
		return app_json();
	}
}

?>
