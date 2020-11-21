<?php
if (!defined('IN_IA')) {
	exit('Access Denied');
}

require EWEI_SHOPV2_PLUGIN . 'app/core/page_auth_mobile.php';
class Shop_EweiShopV2Page extends AppMobileAuthPage
{
	public function main()
	{
		global $_W;
		global $_GPC;

		if (!cv('sysset.shop.edit')) {
			return app_error(AppError::$PermError, '您无操作权限');
		}

		$shopset = m('common')->getSysset('shop');

		if ($_W['ispost']) {
			$shopname = trim($_GPC['shopname']);
			$shoplogo = trim($_GPC['shoplogo']);
			$shopdesc = trim($_GPC['shopdesc']);
			$shopclose = intval($_GPC['shopclose']);

			if (empty($shopname)) {
				return app_error(AppError::$ParamsError, '请填写商城名称');
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
			return app_json();
		}

		return app_json(array('shopname' => $shopset['name'], 'shoplogo' => tomedia($shopset['logo']), 'shopdesc' => $shopset['description'], 'shopclose' => $shopset['close']));
	}
}

?>
