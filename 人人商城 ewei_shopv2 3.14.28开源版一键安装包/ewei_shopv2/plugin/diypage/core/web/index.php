<?php
if (!defined('IN_IA')) {
	exit('Access Denied');
}

class Index_EweiShopV2Page extends PluginWebPage
{
	public function main()
	{
		global $_W;
		global $_GPC;
		$time = strtotime(date('Y-m-d'));
		$sysnumall = pdo_fetchcolumn('SELECT COUNT(*) FROM ' . tablename('ewei_shop_diypage') . ' where `type`>1 and `type`<99 and merch=:merch and uniacid=:uniacid ', array(':merch' => intval($_W['merchid']), ':uniacid' => $_W['uniacid']));
		$sysnumtoday = pdo_fetchcolumn('SELECT COUNT(*) FROM ' . tablename('ewei_shop_diypage') . ' where `type`>1 and `type`<99 and createtime>:time and merch=:merch and uniacid=:uniacid ', array(':merch' => intval($_W['merchid']), ':uniacid' => $_W['uniacid'], ':time' => $time));
		$diynumall = pdo_fetchcolumn('SELECT COUNT(*) FROM ' . tablename('ewei_shop_diypage') . ' where `type`=1 and merch=:merch and uniacid=:uniacid ', array(':merch' => intval($_W['merchid']), ':uniacid' => $_W['uniacid']));
		$diynumtoday = pdo_fetchcolumn('SELECT COUNT(*) FROM ' . tablename('ewei_shop_diypage') . ' where `type`=1 and createtime>:time and merch=:merch and uniacid=:uniacid ', array(':merch' => intval($_W['merchid']), ':uniacid' => $_W['uniacid'], ':time' => $time));
		$menunumall = pdo_fetchcolumn('SELECT COUNT(*) FROM ' . tablename('ewei_shop_diypage_menu') . ' where merch=:merch and uniacid=:uniacid ', array(':merch' => intval($_W['merchid']), ':uniacid' => $_W['uniacid']));
		$menunumtoday = pdo_fetchcolumn('SELECT COUNT(*) FROM ' . tablename('ewei_shop_diypage_menu') . ' where createtime>:time and merch=:merch and uniacid=:uniacid ', array(':merch' => intval($_W['merchid']), ':uniacid' => $_W['uniacid'], ':time' => $time));
		$setmenu = $_W['shopset']['diypage']['setmenu'];
		include $this->template();
	}

	public function setmenu()
	{
		global $_W;
		global $_GPC;

		if ($_W['ispost']) {
			$status = intval($_GPC['status']);
			$data = m('common')->getPluginset('diypage');
			$data['setmenu'] = $status;
			m('common')->updatePluginset(array('diypage' => $data));
			show_json(1);
		}
	}
}

?>
