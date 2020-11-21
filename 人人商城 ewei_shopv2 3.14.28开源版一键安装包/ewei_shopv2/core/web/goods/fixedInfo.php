<?php
//QQ63779278
if (!defined('IN_IA')) {
	exit('Access Denied');
}

class FixedInfo_EweiShopV2Page extends WebPage
{
	public function main()
	{
		global $_W;
		global $_GPC;
		$shopSet = m('common')->getSysset('shop');
		$bottomFixedImageSetting = $shopSet['bottomFixedImage'];

		if ($_W['ispost']) {
			$images = empty($_GPC['fixedImages']) ? NULL : $_GPC['fixedImages'];
			if (!empty($images) && isset($images)) {
				array_walk($images, function(&$value) {
					$value = tomedia($value);
				});
			}

			$bottomFixedImageSetting = array('shopStatus' => (bool) $_GPC['shopStatus'], 'merchStatus' => (bool) $_GPC['merchStatus'], 'urls' => $images);
			$shopSet['bottomFixedImage'] = $bottomFixedImageSetting;
			m('common')->updateSysset(array('shop' => $shopSet));
			show_json(1, '操作成功');
		}

		list($shopStatus, $merchStatus, $picList) = array_values($bottomFixedImageSetting);
		include $this->template();
	}
}

?>
