<?php

if (!defined('IN_IA')) {
	exit('Access Denied');
}

class Set_EweiShopV2Page extends PluginWebPage
{
	public function main()
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

			if ($data['days'] < 1) {
				show_json(0, '请填写正确天数');
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
