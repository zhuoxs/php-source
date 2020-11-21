<?php

if (!defined('IN_IA')) {
	exit('Access Denied');
}

class Index_EweiShopV2Page extends PluginWebPage
{
	public function main()
	{
		global $_W;

		if (cv('cycelbuy.goods')) {
			header('location: ' . webUrl('cycelbuy/goods'));
		}
		else if (cv('cycelbuy.order')) {
			header('location: ' . webUrl('cycelbuy/order'));
		}
		else if (cv('cycelbuy.set')) {
			header('location: ' . webUrl('cycelbuy/set'));
		}
		else if (cv('globonus.notice')) {
			header('location: ' . webUrl('cycelbuy/notice'));
			exit();
		}
		else {
			header('location: ' . webUrl());
		}

		exit();
	}

	public function notice()
	{
		global $_W;
		global $_GPC;

		if ($_W['ispost']) {
			$data = is_array($_GPC['data']) ? $_GPC['data'] : array();
			$data['openids'] = empty($_GPC['openids']) && is_array($_GPC['openids']) ? '' : implode(',', $_GPC['openids']);
			m('common')->updatePluginset(array(
	'cycelbuy' => array('tm' => $data)
	));
			plog('cycelbuy.notice.edit', '修改通知设置');
			show_json(1);
		}

		$data = m('common')->getPluginset('cycelbuy');
		$template_lists = pdo_fetchall('SELECT id,title,typecode FROM ' . tablename('ewei_shop_member_message_template') . ' WHERE uniacid=:uniacid ', array(':uniacid' => $_W['uniacid']));
		$templatetype_list = pdo_fetchall('SELECT * FROM  ' . tablename('ewei_shop_member_message_template_type'));
		$template_group = array();

		foreach ($templatetype_list as $type) {
			$templates = array();

			foreach ($template_lists as $template) {
				if ($template['typecode'] == $type['typecode']) {
					$templates[] = $template;
				}
			}

			$template_group[$type['typecode']] = $templates;
		}

		$salers = array();

		if (!empty($data['tm']['openids'])) {
			$openids = array();
			$strsopenids = explode(',', $data['tm']['openids']);

			foreach ($strsopenids as $openid) {
				$openids[] = '\'' . $openid . '\'';
			}

			$salers = pdo_fetchall('select id,nickname,avatar,openid from ' . tablename('ewei_shop_member') . ' where openid in (' . implode(',', $openids) . (') and uniacid=' . $_W['uniacid']));
		}

		$template_list = $template_group;
		include $this->template();
	}

	public function set()
	{
		global $_W;
		global $_GPC;

		if ($_W['ispost']) {
			ca('cycelbuy.set.edit');
			$data = is_array($_GPC['data']) ? $_GPC['data'] : array();
			$data['receive_goods'] = intval($data['receive_goods']);
			$data['ahead_goods'] = intval($data['ahead_goods']);
			$data['days'] = intval($data['days']);
			$data['max_day'] = intval($data['max_day']);
			$data['terminal'] = intval($data['terminal']);

			if ($data['receive_goods'] <= 0) {
				$data['receive_goods'] = 15;
			}

			if ($data['ahead_goods'] <= 0) {
				$data['ahead_goods'] = 3;
			}

			if ($data['ahead_goods'] <= 0) {
				$data['ahead_goods'] = 3;
			}

			if ($data['max_day'] <= 0) {
				$data['max_day'] = 15;
			}

			if ($data['days'] <= 0) {
				$data['days'] = 7;
			}

			m('common')->updateSysset(array('cycelbuy' => $data));
			plog('cycelbuy.set.edit', '周期购-修改基本设置');
			show_json(1, array('url' => webUrl('cycelbuy/set')));
		}

		$data = m('common')->getSysset('cycelbuy');
		include $this->template();
	}
}

?>
