<?php
//QQ63779278
if (!defined('IN_IA')) {
	exit('Access Denied');
}

class Notice_EweiShopV2Page extends PluginWebPage
{
	public function main()
	{
		global $_W;
		global $_GPC;

		if ($_W['ispost']) {
			$data = is_array($_GPC['data']) ? $_GPC['data'] : array();

			if (is_array($_GPC['openids'])) {
				$data['openid'] = implode(',', $_GPC['openids']);
			}

			m('common')->updatePluginset(array(
				'cashier' => array('notice' => $data)
			));
			plog('cashier.notice.edit', '修改收银台通知设置');
			show_json(1);
		}

		$data = m('common')->getPluginset('cashier');
		$notice = $data['notice'];
		$salers = array();

		if (!empty($notice['openid'])) {
			$openids = array();
			$strsopenids = explode(',', $notice['openid']);

			foreach ($strsopenids as $openid) {
				$openids[] = '\'' . $openid . '\'';
			}

			$salers = pdo_fetchall('select id,nickname,avatar,openid from ' . tablename('ewei_shop_member') . ' where openid in (' . implode(',', $openids) . (') and uniacid=' . $_W['uniacid']));
		}

		$template_list = pdo_fetchall('SELECT id,title FROM ' . tablename('ewei_shop_member_message_template') . ' WHERE uniacid=:uniacid ', array(':uniacid' => $_W['uniacid']));
		include $this->template();
	}
}

?>
