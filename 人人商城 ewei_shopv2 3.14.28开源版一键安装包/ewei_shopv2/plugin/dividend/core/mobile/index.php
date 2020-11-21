<?php

if (!defined('IN_IA')) {
	exit('Access Denied');
}

require EWEI_SHOPV2_PLUGIN . 'dividend/core/page_login_mobile.php';
class Index_EweiShopV2Page extends DividendMobileLoginPage
{
	public function main()
	{
		global $_W;
		global $_GPC;
		$page_title = '商城';

		if (!empty($_W['shopset']['shop']['name'])) {
			$page_title = $_W['shopset']['shop']['name'];
		}

		$member = $this->model->getInfo($_W['openid'], array('total', 'ordercount0', 'ok', 'ordercount', 'wait', 'pay'));
		$initData = pdo_fetch('select * from ' . tablename('ewei_shop_dividend_init') . ' where headsid = :headsid and uniacid = :uniacid', array(':headsid' => $member['id'], ':uniacid' => $_W['uniacid']));
		$isbuild = $initData['status'];
		$cansettle = 1 <= $member['commission_ok'] && floatval($this->set['withdraw']) <= $member['commission_ok'];
		$member['applycount'] = pdo_fetchcolumn('select count(id) from ' . tablename('ewei_shop_dividend_apply') . ' where mid=:mid and uniacid=:uniacid limit 1', array(':uniacid' => $_W['uniacid'], ':mid' => $member['id']));

		if (p('commission')) {
			$level = p('commission')->getLevel($member['openid']);

			if (empty($level)) {
				$member['levelname'] = '默认等级';
			}
			else {
				$member['levelname'] = $level['levelname'];
			}
		}

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

		include $this->template();
	}

	/**
     *  创建团队
     */
	public function createTeam()
	{
		global $_W;
		global $_GPC;
		$member = m('member')->getMember($_W['openid']);
		if (empty($member['isheads']) || empty($member['headsstatus'])) {
			show_json(1, '您还不是队长');
		}

		$data = pdo_fetchall('select  r.id,r.pid,m.isheads from ' . tablename('ewei_shop_commission_relation') . ' r ' . ' left join ' . tablename('ewei_shop_member') . ' m on m.id = r.id where  r.pid=:pid and m.uniacid=:uniacid', array(':pid' => $member['id'], ':uniacid' => $_W['uniacid']));

		if (!empty($data)) {
			$heads = array();
			$later = array();
			$ids = array();

			foreach ($data as $k => $v) {
				if (!empty($v['isheads'])) {
					$heads[] = $v['id'];
					continue;
				}

				$ids[] = $v['id'];
			}

			if (!empty($heads)) {
				$later = pdo_fetchall('select id from ' . tablename('ewei_shop_commission_relation') . ' where pid in (' . implode(',', $heads) . ')');
			}

			if (!empty($ids)) {
				if (!empty($later)) {
					$later = array_column($later, 'id');
					$ids = array_diff($ids, $later);
				}

				pdo_update('ewei_shop_member', array('headsid' => $member['id']), array('id' => $ids));
			}
		}

		pdo_update('ewei_shop_dividend_init', array('status' => 1), array('headsid' => $member['id']));
		show_json(1, '创建成功！');
	}
}

?>
