<?php
//QQ63779278
if (!defined('IN_IA')) {
	exit('Access Denied');
}

require EWEI_SHOPV2_PLUGIN . 'abonus/core/page_login_mobile.php';
class Index_EweiShopV2Page extends AbonusMobileLoginPage
{
	public function main()
	{
		global $_W;
		global $_GPC;
		$set = $this->getSet();
		$member = m('member')->getMember($_W['openid']);
		$bonus = $this->model->getBonus($_W['openid'], array('ok', 'lock', 'ok1', 'ok2', 'ok3', 'lock1', 'lock2', 'lock3', 'total', 'total1', 'total2', 'total3'));
		$levelname = empty($set['levelname']) ? '默认等级' : $set['levelname'];
		$level = $this->model->getLevel($_W['openid']);

		if (!empty($level)) {
			$levelname = $level['levelname'];
		}

		if ($member['aagenttype'] == 1) {
			$cols = 4;
		}
		else if ($member['aagenttype'] == 2) {
			$cols = 3;
		}
		else if ($member['aagenttype'] == 3) {
			$cols = 2;
		}
		else {
			$cols = 4;
		}

		$bonus_wait = 0;
		$year = date('Y');
		$month = intval(date('m'));
		$week = 0;

		if ($set['paytype'] == 2) {
			$ds = explode('-', date('Y-m-d'));
			$day = intval($ds[2]);
			$week = ceil($day / 7);
		}

		$bonusall = $this->model->getBonusData($year, $month, $week, $_W['openid']);
		$bonus_wait1 = $bonusall['aagents'][0]['bonusmoney_send1'];
		$bonus_wait2 = $bonusall['aagents'][0]['bonusmoney_send2'];
		$bonus_wait3 = $bonusall['aagents'][0]['bonusmoney_send3'];
		$bonus_wait = $bonusall['aagents'][0]['bonusmoney_send1'] + $bonusall['aagents'][0]['bonusmoney_send2'] + $bonusall['aagents'][0]['bonusmoney_send3'];
		include $this->template();
	}
}

?>
