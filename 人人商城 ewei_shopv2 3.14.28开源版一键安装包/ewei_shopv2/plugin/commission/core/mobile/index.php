<?php
//QQ63779278
if (!defined('IN_IA')) {
	exit('Access Denied');
}

require EWEI_SHOPV2_PLUGIN . 'commission/core/page_login_mobile.php';
class Index_EweiShopV2Page extends CommissionMobileLoginPage
{
	public function main()
	{
		global $_W;
		global $_GPC;
		$this->diypage('commission');
		$member = $this->model->getInfo($_W['openid'], array('total', 'ordercount0', 'ok', 'ordercount', 'wait', 'pay'));
		$cansettle = 1 <= $member['commission_ok'] && floatval($this->set['withdraw']) <= $member['commission_ok'];
		$level1 = $level2 = $level3 = 0;
		$level1 = pdo_fetchcolumn('select count(*) from ' . tablename('ewei_shop_member') . ' where agentid=:agentid and uniacid=:uniacid limit 1', array(':agentid' => $member['id'], ':uniacid' => $_W['uniacid']));
		if (2 <= $this->set['level'] && 0 < count($member['level1_agentids'])) {
			$level2 = pdo_fetchcolumn('select count(*) from ' . tablename('ewei_shop_member') . ' where agentid in( ' . implode(',', array_keys($member['level1_agentids'])) . ') and uniacid=:uniacid limit 1', array(':uniacid' => $_W['uniacid']));
		}

		if (3 <= $this->set['level'] && 0 < count($member['level2_agentids'])) {
			$level3 = pdo_fetchcolumn('select count(*) from ' . tablename('ewei_shop_member') . ' where agentid in( ' . implode(',', array_keys($member['level2_agentids'])) . ') and uniacid=:uniacid limit 1', array(':uniacid' => $_W['uniacid']));
		}

		$member['downcount'] = $level1 + $level2 + $level3;
		$member['applycount'] = pdo_fetchcolumn('select count(id) from ' . tablename('ewei_shop_commission_apply') . ' where mid=:mid and uniacid=:uniacid limit 1', array(':uniacid' => $_W['uniacid'], ':mid' => $member['id']));
		$openselect = false;

		if ($this->set['select_goods'] == '1') {
			if (empty($member['agentselectgoods']) || $member['agentselectgoods'] == 2) {
				$openselect = true;
			}
		}
		else {
			if ($member['agentselectgoods'] == 2) {
				$openselect = true;
			}
		}

		$this->set['openselect'] = $openselect;
		$level = $this->model->getLevel($_W['openid']);
		$up = false;

		if (!empty($member['agentid'])) {
			$up = m('member')->getMember($member['agentid']);
		}

		$hasglobonus = false;
		$plugin_globonus = p('globonus');

		if ($plugin_globonus) {
			$plugin_globonus_set = $plugin_globonus->getSet();
			$hasglobonus = !empty($plugin_globonus_set['open']) && empty($plugin_globonus_set['closecommissioncenter']);
		}

		$hasabonus = false;
		$plugin_abonus = p('abonus');

		if ($plugin_abonus) {
			$plugin_abonus_set = $plugin_abonus->getSet();
			$hasabonus = !empty($plugin_abonus_set['open']) && empty($plugin_abonus_set['closecommissioncenter']);
		}

		$hasauthor = false;
		$plugin_author = p('author');

		if ($plugin_author) {
			$plugin_author_set = $plugin_author->getSet();
			$hasauthor = !empty($plugin_author_set['open']) && empty($plugin_author_set['closecommissioncenter']);

			if ($hasauthor) {
				$team_money = $plugin_author->getTeamPay($member['id']);
			}
		}

		$hasdividend = false;
		$plugin_dividend = p('dividend');

		if ($plugin_dividend) {
			$plugin_dividend_set = $plugin_dividend->getSet();
			if (!empty($plugin_dividend_set['open']) && !empty($plugin_dividend_set['commissionshow'])) {
				$hasdividend = true;
			}
		}

		include $this->template();
	}
}

?>
