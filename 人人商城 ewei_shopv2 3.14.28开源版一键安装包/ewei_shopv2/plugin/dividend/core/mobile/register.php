<?php

if (!defined('IN_IA')) {
	exit('Access Denied');
}

require EWEI_SHOPV2_PLUGIN . 'dividend/core/page_login_mobile.php';
class Register_EweiShopV2Page extends DividendMobileLoginPage
{
	public function main()
	{
		global $_W;
		global $_GPC;
		$page_title = '商城';

		if (!empty($_W['shopset']['shop']['name'])) {
			$page_title = $_W['shopset']['shop']['name'];
		}

		$openid = $_W['openid'];
		$set = set_medias($this->set, 'regbg');
		$area_set = m('util')->get_area_config_set();
		$new_area = intval($area_set['new_area']);
		$member = m('member')->getMember($openid);
		if ($member['isagent'] != 1 || $member['status'] != 1) {
			header('location: ' . mobileUrl('commission/register'));
			exit();
		}

		if ($member['isheads'] == 1 && $member['headsstatus'] == 1) {
			header('location: ' . mobileUrl('dividend'));
			exit();
		}

		if ($member['headsblack']) {
			include $this->template();
			exit();
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
		}

		$mid = intval($_GPC['mid']);

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

			show_json(1, array('check' => $check));
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
			$commissiondownlinecount = pdo_fetchcolumn('select count(*) from ' . tablename('ewei_shop_member') . ' where  agentid = ' . $member['id'] . ' and isagent = 1 and id <> ' . $member['id'] . '  and uniacid=:uniacid  limit 1', array(':uniacid' => $_W['uniacid']));

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
				echo '<script language=JavaScript> location.replace(location.href);</script>';
			}
		}

		include $this->template();
	}
}

?>
