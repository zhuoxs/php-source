<?php
//QQ63779278
if (!defined('IN_IA')) {
	exit('Access Denied');
}

require EWEI_SHOPV2_PLUGIN . 'mmanage/core/inc/page_mmanage.php';
class Index_EweiShopV2Page extends MmanageMobilePage
{
	public function main()
	{
		global $_W;
		global $_GPC;
		ca('sysset.shop.edit');
		$shopset = m('common')->getSysset();

		if ($_W['ispost']) {
			ca('sysset.shop.edit');
			$shopname = trim($_GPC['shopname']);
			$shoplogo = trim($_GPC['shoplogo']);
			$shopdesc = trim($_GPC['shopdesc']);
			$shopclose = intval($_GPC['shopclose']);

			if (empty($shopname)) {
				show_json(0, '请填写商城名称');
			}

			$data = $shopset['shop'];
			$data['name'] = $shopname;
			$data['description'] = $shopdesc;
			$data['close'] = $shopclose;
			$data['logo'] = $shoplogo;
			m('common')->updateSysset(array(
				'shop'  => $data,
				'close' => array('flag' => $shopclose)
			));
			plog('sysset.shop.edit', '修改系统设置-商城设置');
			show_json(1);
		}

		include $this->template();
	}
}

?>
