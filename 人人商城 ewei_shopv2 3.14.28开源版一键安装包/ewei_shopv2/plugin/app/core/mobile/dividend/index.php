<?php
if (!defined('IN_IA')) {
	exit('Access Denied');
}

require __DIR__ . '/base.php';
class Index_EweiShopV2Page extends Base_EweiShopV2Page
{
	/**
     *     团长申请
     */
	public function register()
	{
		global $_W;
		global $_GPC;
		$openid = $_W['openid'];
		$set = set_medias($this->set, 'regbg');
		$area_set = m('util')->get_area_config_set();
		$new_area = intval($area_set['new_area']);
		$member = m('member')->getMember($openid);
		if ($member['isagent'] == 0 || $member['status'] == 0) {
			return app_error(AppError::$CommissionIsNotAgent);
		}

		if ($member['isheads'] == 1 && $member['headsstatus'] == 1) {
			return app_error(AppError::$DividendAgent);
		}

		if ($member['headsblack']) {
			return app_error(AppError::$UserIsBlack);
		}

		$apply_set = array();
		$apply_set['open_protocol'] = $set['open_protocol'];

		if (empty($set['applytitle'])) {
			$apply_set['applytitle'] = '分销商申请协议';
		}
		else {
			$apply_set['applytitle'] = $set['applytitle'];
		}

		$template_flag = 0;
		$diyform_plugin = p('diyform');

		if ($diyform_plugin) {
			$set_config = $diyform_plugin->getSet();
			$dividend_diyform_open = $set_config['dividend_diyform_open'];

			if ($dividend_diyform_open == 1) {
				$template_flag = 1;
				$diyform_id = $set_config['dividend_diyform'];

				if (!empty($diyform_id)) {
					$formInfo = $diyform_plugin->getDiyformInfo($diyform_id);
					$fields = $formInfo['fields'];
					$diyform_data = iunserializer($member['diycommissiondata']);
					$f_data = $diyform_plugin->getDiyformData($diyform_data, $fields, $member);
				}
			}

			if ($diyform_plugin) {
				$appDatas = $diyform_plugin->wxApp($fields, $f_data, $this->member);
			}
		}

		if ($_W['ispost']) {
			if ($set['condition'] != '0') {
				show_json(0, '未开启' . $set['texts']['agent'] . '注册!');
			}

			$check = intval($set['check']);
			$ret['headsstatus'] = $check;

			if ($template_flag == 1) {
				$memberdata = $_GPC['memberdata'];
				$insert_data = $diyform_plugin->getInsertData($fields, $memberdata);
				$data = $insert_data['data'];
				$m_data = $insert_data['m_data'];
				$mc_data = $insert_data['mc_data'];
				$m_data['diyheadsid'] = $diyform_id;
				$m_data['diyheadsfields'] = iserializer($fields);
				$m_data['diyheadsdata'] = $data;
				$m_data['isheads'] = 1;
				$m_data['headsstatus'] = $check;
				$m_data['headstime'] = $check == 1 ? time() : 0;
				unset($m_data['credit1']);
				unset($m_data['credit2']);
				pdo_update('ewei_shop_member', $m_data, array('id' => $member['id']));

				if ($check == 1) {
					$this->model->sendMessage($member['openid'], array('nickname' => $member['nickname'], 'headstime' => $m_data['headstime']), TM_DIVIDEND_BECOME);
				}

				if (!empty($member['uid'])) {
					if (!empty($mc_data)) {
						unset($mc_data['credit1']);
						unset($mc_data['credit2']);
						m('member')->mc_update($member['uid'], $mc_data);
					}
				}
			}
			else {
				$data = array('isheads' => 1, 'headsstatus' => $check, 'realname' => $_GPC['realname'], 'mobile' => $_GPC['mobile'], 'headstime' => $check == 1 ? time() : 0);
				pdo_update('ewei_shop_member', $data, array('id' => $member['id']));

				if ($check == 1) {
					$this->model->sendMessage($member['openid'], array('nickname' => $member['nickname'], 'headstime' => $data['headstime']), TM_DIVIDEND_BECOME);

					if (!empty($mid)) {
					}
				}

				if (!empty($member['uid'])) {
					m('member')->mc_update($member['uid'], array('realname' => $data['realname'], 'mobile' => $data['mobile']));
				}
			}

			return app_json(0, array('check' => $check));
		}

		$to_check_heads = false;

		if ($set['condition'] == 1) {
			$status = 1;
			$membercount = pdo_fetchcolumn('select count(*) from ' . tablename('ewei_shop_member') . ' where  agentid = ' . $member['id'] . ' and id <> ' . $member['id'] . '  and uniacid=:uniacid  limit 1', array(':uniacid' => $_W['uniacid']));

			if ($membercount < intval($set['downline'])) {
				$status = 0;
				$member_count = number_format($membercount, 0);
				$member_totalcount = number_format($set['downline'], 0);
			}
			else {
				$to_check_heads = true;
			}
		}
		else if ($set['condition'] == 2) {
			$status = 1;
			$commissiondownlinecount = pdo_fetchcolumn('select count(*) from ' . tablename('ewei_shop_member') . ' where  agentid = ' . $member['id'] . ' and isagend = 1 and id <> ' . $member['id'] . '  and uniacid=:uniacid  limit 1', array(':uniacid' => $_W['uniacid']));

			if ($commissiondownlinecount < floatval($set['commissiondownline'])) {
				$status = 0;
				$commissiondownline_count = number_format($commissiondownlinecount, 0);
				$commissiondownline_totalcount = number_format($set['commissiondownline'], 0);
			}
			else {
				$to_check_heads = true;
			}
		}
		else if ($set['condition'] == 3) {
			$status = 1;
			$commission_info = p('commission')->getInfo($member['openid'], array('total'));
			$totalcommissioncount = $commission_info['commission_total'];

			if ($totalcommissioncount < floatval($set['total_commission'])) {
				$status = 0;
				$total_commission_count = number_format($totalcommissioncount, 0);
				$total_commission_totalcount = number_format($set['total_commission'], 0);
			}
			else {
				$to_check_heads = true;
			}
		}
		else {
			if ($set['condition'] == 4) {
				$status = 1;
				$commission_info = p('commission')->getInfo($member['openid'], array('pay'));
				$cashcommissioncount = $commission_info['commission_pay'];

				if ($cashcommissioncount < floatval($set['cash_commission'])) {
					$status = 0;
					$cash_commission_count = number_format($cashcommissioncount, 0);
					$cash_commission_totalcount = number_format($set['cash_commission'], 0);
				}
				else {
					$to_check_heads = true;
				}
			}
		}

		if ($to_check_heads) {
			if (empty($member['isheads'])) {
				$data = array('isheads' => 1, 'headsstatus' => 0, 'headstime' => time());
				$heads_data['headsid'] = $member['id'];
				$heads_data['uniacid'] = $_W['uniacid'];
				$heads_data['status'] = 0;
				pdo_update('ewei_shop_member', $data, array('id' => $member['id']));
				pdo_insert('ewei_shop_dividend_init', $heads_data);
				$this->model->sendMessage($member['openid'], array('nickname' => $member['nickname'], 'headstime' => $data['headstime']), TM_DIVIDEND_BECOME);
			}
		}

		$result = array(
			'set'                           => array('open' => $set['open'], 'texts' => $this->set['texts'], 'regbg' => empty($set['regbg']) ? $_W['siteroot'] . 'addons/ewei_shopv2/plugin/dividend/template/mobile/default/static/images/banner.jpg' : $set['regbg'], 'condition' => (int) $set['condition'], 'open_protocol' => $set['open_protocol'], 'applytitle' => $set['applytitle'], 'applycontent' => $set['applycontent'], 'register_bottom' => $set['register_bottom'], 'register_bottom_title1' => $set['register_bottom_title1'], 'register_bottom_content1' => $set['register_bottom_content1'], 'register_bottom_title2' => $set['register_bottom_title2'], 'register_bottom_content2' => $set['register_bottom_content2'], 'register_bottom_content' => $set['register_bottom_content']),
			'member'                        => array('headsblack' => (int) $member['headsblack'], 'isheads' => (int) $member['isheads'], 'headsstatus' => (int) $member['headsstatus'], 'realname' => $member['realname'], 'mobile' => $member['mobile']),
			'status'                        => intval($status),
			'member_totalcount'             => $member_totalcount,
			'member_count'                  => $member_count,
			'commissiondownline_totalcount' => $commissiondownline_totalcount,
			'commissiondownline_count'      => $commissiondownline_count,
			'total_commission_totalcount'   => $total_commission_totalcount,
			'total_commission_count'        => $total_commission_count,
			'cash_commission_totalcount'    => $cash_commission_totalcount,
			'cash_commission_count'         => $cash_commission_count,
			'template_flag'                 => $template_flag,
			'f_data'                        => $appDatas['f_data'],
			'fields'                        => $appDatas['fields']
		);
		return app_json($result);
	}

	/**
     *  分红中心
     */
	public function main()
	{
		global $_GPC;
		global $_W;
		$member = $this->model->getInfo($_W['openid'], array('total', 'ordercount0', 'ok', 'ordercount', 'wait', 'pay'));
		$member['applycount'] = pdo_fetchcolumn('select count(id) from ' . tablename('ewei_shop_dividend_apply') . ' where mid=:mid and uniacid=:uniacid limit 1', array(':uniacid' => $_W['uniacid'], ':mid' => $member['id']));
		$initData = pdo_fetch('select * from ' . tablename('ewei_shop_dividend_init') . ' where headsid = :headsid and uniacid = :uniacid', array(':headsid' => $member['id'], ':uniacid' => $_W['uniacid']));
		$isbuild = $initData['status'];
		$member['applycount'] = pdo_fetchcolumn('select count(id) from ' . tablename('ewei_shop_dividend_apply') . ' where mid=:mid and uniacid=:uniacid limit 1', array(':uniacid' => $_W['uniacid'], ':mid' => $member['id']));
		$result = array(
			'member'  => $member,
			'isbuild' => $isbuild,
			'set'     => array('texts' => $this->set['texts'])
		);
		return app_json($result);
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
			return app_error(1, '您还不是团长');
		}

		$data = pdo_fetchall('select id from ' . tablename('ewei_shop_commission_relation') . ' where pid = :pid', array(':pid' => $member['id']));

		if (!empty($data)) {
			$ids = array();

			foreach ($data as $k => $v) {
				$ids[] = $v['id'];
			}

			pdo_update('ewei_shop_member', array('headsid' => $member['id']), array('id' => $ids));
			pdo_update('ewei_shop_dividend_init', array('status' => 1), array('headsid' => $member['id']));
			$arr['message'] = '创建完成';
			return app_json($arr);
		}

		pdo_update('ewei_shop_dividend_init', array('status' => 1), array('headsid' => $member['id']));
		$arr['message'] = '创建完成';
		return app_json($arr);
	}
}

?>
