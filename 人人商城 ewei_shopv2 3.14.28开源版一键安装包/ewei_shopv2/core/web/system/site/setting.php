<?php
//QQ63779278
if (!defined('IN_IA')) {
	exit('Access Denied');
}

class Setting_EweiShopV2Page extends SystemPage
{
	public function main()
	{
		global $_W;
		global $_GPC;
		$uniacid = $_W['uniacid'];

		if ($_W['ispost']) {
			$data = array('uniacid' => $uniacid, 'casebanner' => save_media($_GPC['casebanner']), 'background' => trim($_GPC['background']), 'contact' => m('common')->html_to_images($_GPC['contact']));
			$set = pdo_fetch('select * from ' . tablename('ewei_shop_system_setting') . ' where uniacid = :uniacid ', array(':uniacid' => $uniacid));

			if ($set) {
				pdo_update('ewei_shop_system_setting', $data, array('id' => $set['id']));
				plog('system.site.setting', '修改基础设置 ID:' . $set['id']);
			}
			else {
				pdo_insert('ewei_shop_system_setting', $data);
				$id = pdo_insertid();
				plog('system.site.setting', '添加基础设置 ID:' . $set['id']);
			}

			show_json(1);
		}
		else {
			$item = pdo_fetch('select * from ' . tablename('ewei_shop_system_setting') . ' where uniacid = :uniacid ', array(':uniacid' => $uniacid));
			include $this->template();
		}
	}
}

?>
