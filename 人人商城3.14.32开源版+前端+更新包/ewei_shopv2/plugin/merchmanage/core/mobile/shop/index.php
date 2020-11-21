<?php
if (!(defined('IN_IA'))) {
	exit('Access Denied');
}


require EWEI_SHOPV2_PLUGIN . 'merchmanage/core/inc/page_merchmanage.php';
class Index_EweiShopV2Page extends MerchmanageMobilePage
{
	public function main()
	{
		global $_W;
		global $_GPC;
		
		$merchid = $_W['merchmanage']['merchid'];

		$shopset = pdo_fetch('select * from '.tablename('ewei_shop_merch_user').' where id ="'.$merchid.'"');

		if ($_W['ispost']) {
			
			$merchname = trim($_GPC['shopname']);
			$logo = trim($_GPC['shoplogo']);
			$desc = trim($_GPC['shopdesc']);
			$mobile = intval($_GPC['mobile']);
			$realname = trim($_GPC['realname']);
			if (empty($merchname)) {
				show_json(0, '请填写商户名称');
			}
			
			$data['merchname'] = $merchname;
			$data['desc'] = $desc;
			if (!empty($logo)) {
				$data['logo'] = $logo;
			}
			
			$data['mobile'] = $mobile;
			$data['realname'] = $realname;
			#更新
			pdo_update('ewei_shop_merch_user',$data,array('id'=>$merchid));
			show_json(1);
		}


		include $this->template();
	}
}


?>