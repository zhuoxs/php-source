<?php
if (!defined('IN_IA')) {
	exit('Access Denied');
}

require_once EWEI_SHOPV2_PLUGIN . 'app/core/page_mobile.php';
class Base_EweiShopV2Page extends AppMobilePage
{
	public function __construct()
	{
		parent::__construct();
		global $_W;
		global $_GPC;
		if ($_W['action'] != 'commission.register' && $_W['action'] != 'myshop' && $_W['action'] != 'share') {
			$member = $this->member;
			if ($member['isagent'] != 1 || $member['status'] != 1) {
				exit(app_error(AppError::$CommissionReg, $_W['openid'] . '+' . $member['openid']));
			}
		}

		$this->model = p('commission');
		$this->set = $this->model->getSet();
	}
}

?>
