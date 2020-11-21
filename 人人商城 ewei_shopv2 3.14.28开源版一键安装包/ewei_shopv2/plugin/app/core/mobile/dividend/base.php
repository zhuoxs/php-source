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
		$this->model = p('dividend');
		$this->set = $this->model->getSet();

		if (empty($this->set['open'])) {
			exit(app_error(1, '团队分红未开启'));
			exit();
		}

		if ($_W['action'] != 'dividend.register' && $_W['action'] != 'share') {
			$member = $this->member;
			if ($member['isheads'] != 1 || $member['headsstatus'] != 1) {
				exit(app_error(AppError::$CommissionReg, $_W['openid'] . '+' . $member['openid']));
			}
		}
	}
}

?>
