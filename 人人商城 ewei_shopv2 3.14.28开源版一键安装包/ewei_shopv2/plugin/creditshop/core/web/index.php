<?php
//QQ63779278
if (!defined('IN_IA')) {
	exit('Access Denied');
}

class Index_EweiShopV2Page extends PluginWebPage
{
	public function main()
	{
		global $_W;

		if (cv('creditshop.goods')) {
			header('location: ' . webUrl('creditshop/goods'));
		}
		else if (cv('creditshop.category')) {
			header('location: ' . webUrl('creditshop/category'));
		}
		else if (cv('creditshop.adv')) {
			header('location: ' . webUrl('creditshop/adv'));
		}
		else if (cv('creditshop.log')) {
			header('location: ' . webUrl('creditshop/log'));
		}
		else if (cv('creditshop.cover')) {
			header('location: ' . webUrl('creditshop/cover'));
		}
		else if (cv('creditshop.notice')) {
			header('location: ' . webUrl('creditshop/notice'));
		}
		else if (cv('creditshop.set')) {
			header('location: ' . webUrl('creditshop/set'));
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
		$set = $this->set;

		if ($_W['ispost']) {
			ca('creditshop.notice.edit');
			$data = is_array($_GPC['tm']) ? $_GPC['tm'] : array();

			if (is_array($_GPC['openids'])) {
				$data['openids'] = implode(',', $_GPC['openids']);
			}

			$this->updateSet(array('tm' => $data));
			plog('creditshop.notice.edit', '修改积分商城通知设置');
			show_json(1);
		}

		$salers = array();

		if (isset($set['tm']['openids'])) {
			if (!empty($set['tm']['openids'])) {
				$openids = array();
				$strsopenids = explode(',', $set['tm']['openids']);

				foreach ($strsopenids as $openid) {
					$openids[] = '\'' . $openid . '\'';
				}

				$salers = pdo_fetchall('select id,nickname,avatar,openid from ' . tablename('ewei_shop_member') . ' where openid in (' . implode(',', $openids) . (') and uniacid=' . $_W['uniacid']));
			}
		}

		include $this->template();
	}
}

?>
