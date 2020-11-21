<?php
if (!defined('IN_IA')) {
	exit('Access Denied');
}

require __DIR__ . '/base.php';
class Index_EweiShopV2Page extends Base_EweiShopV2Page
{
	public function main()
	{
		global $_W;
		global $_GPC;
		$member = p('commission')->getInfo($_W['openid'], array('total', 'ordercount0', 'ok', 'ordercount', 'wait', 'pay'));
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
		$level = p('commission')->getLevel($_W['openid']);
		$commissionshow = 0;

		if (p('dividend')) {
			$data = m('common')->getPluginset('dividend');
			$commissionshow = $data['commissionshow'];
		}

		$up = false;

		if (!empty($member['agentid'])) {
			$up = m('member')->getMember($member['agentid']);
		}

		$posercount = pdo_fetchcolumn('SELECT COUNT(id) FROM ' . tablename('ewei_shop_wxapp_poster') . ' WHERE uniacid=:uniacid AND status=1', array(':uniacid' => $_W['uniacid']));
		$return_set = array('texts' => $this->set['texts'], 'closed_qrcode' => (int) $this->set['closed_qrcode'], 'postercount' => intval($posercount), 'hideicode' => intval($this->set['hideicode']), 'commissionshow' => intval($commissionshow));
		$return_member = array('id' => intval($member['id']), 'avatar' => (string) $member['avatar'], 'nickname' => (string) $member['nickname'], 'commission_pay' => (double) $member['commission_pay'], 'commission_ok' => (double) $member['commission_ok'], 'commission_total' => (double) $member['commission_total'], 'ordercount0' => (double) $member['ordercount0'], 'applycount' => (double) $member['applycount'], 'downcount' => (double) $member['downcount']);
		$data = array('set' => $return_set, 'member' => $return_member, 'levelname' => empty($level) ? (empty($this->set['levelname']) ? '普通等级' : $this->set['levelname']) : $level['levelname'], 'agentname' => empty($up) ? '总店' : $up['nickname'], 'cansettle' => $cansettle, 'menu' => p('app')->diyMenu('commission'));
		return app_json($data);
	}

	public function withdraw()
	{
		global $_W;
		global $_GPC;
		$member = $this->model->getInfo($_W['openid'], array('total', 'ok', 'apply', 'check', 'lock', 'pay', 'wait', 'fail'));
		$cansettle = 1 <= $member['commission_ok'] && floatval($this->set['withdraw']) <= $member['commission_ok'];
		$agentid = $member['id'];

		if (!empty($agentid)) {
			$data = pdo_fetch('select sum(deductionmoney) as sumcharge from ' . tablename('ewei_shop_commission_log') . ' where mid=:mid and uniacid=:uniacid  limit 1', array(':uniacid' => $_W['uniacid'], ':mid' => $agentid));
			$commission_charge = $data['sumcharge'];
			$member['commission_charge'] = $commission_charge;
		}
		else {
			$member['commission_charge'] = 0;
		}

		$set = array('texts' => $this->set['texts'], 'settledays' => (double) $this->set['settledays'], 'withdraw' => (double) $this->set['withdraw']);
		$member = array('commission_total' => (double) $member['commission_total'], 'commission_ok' => (double) $member['commission_ok'], 'commission_apply' => (double) $member['commission_apply'], 'commission_check' => (double) $member['commission_check'], 'commission_fail' => (double) $member['commission_fail'], 'commission_pay' => (double) $member['commission_pay'], 'commission_charge' => (double) $member['commission_charge'], 'commission_wait' => (double) $member['commission_wait'], 'commission_lock' => (double) $member['commission_lock']);
		$data = array('set' => $set, 'member' => $member, 'cansettle' => $cansettle, 'menu' => p('app')->diyMenu('commission'));
		return app_json($data);
	}

	public function apply()
	{
		global $_W;
		global $_GPC;
		$openid = $_W['openid'];
		$level = $this->set['level'];
		$member = $this->model->getInfo($openid, array());
		$become_reg = $this->set['become_reg'];

		if (empty($become_reg)) {
			if (empty($member['realname'])) {
				return app_error(AppError::$CommissionNoUserInfo);
			}
		}

		$time = time();
		$day_times = intval($this->set['settledays']) * 3600 * 24;
		$agentLevel = $this->model->getLevel($openid);
		$commission_ok = 0;
		$orderids = array();

		if (1 <= $level) {
			$level1_orders = pdo_fetchall('select distinct o.id from ' . tablename('ewei_shop_order') . ' o ' . ' left join  ' . tablename('ewei_shop_order_goods') . ' og on og.orderid=o.id ' . (' where o.agentid=:agentid and o.status>=3  and og.status1=0 and og.nocommission=0 and (' . $time . ' - o.finishtime > ' . $day_times . ') and o.uniacid=:uniacid  group by o.id'), array(':uniacid' => $_W['uniacid'], ':agentid' => $member['id']));

			foreach ($level1_orders as $o) {
				if (empty($o['id'])) {
					continue;
				}

				$hasorder = false;

				foreach ($orderids as $or) {
					if ($or['orderid'] == $o['id']) {
						$hasorder = true;
						break;
					}
				}

				if ($hasorder) {
					continue;
				}

				$orderids[] = array('orderid' => $o['id'], 'level' => 1);
			}
		}

		if (2 <= $level) {
			if (0 < $member['level1']) {
				$level2_orders = pdo_fetchall('select distinct o.id from ' . tablename('ewei_shop_order') . ' o ' . ' left join  ' . tablename('ewei_shop_order_goods') . ' og on og.orderid=o.id ' . ' where o.agentid in( ' . implode(',', array_keys($member['level1_agentids'])) . (')  and o.status>=3  and og.status2=0 and og.nocommission=0 and (' . $time . ' - o.finishtime > ' . $day_times . ') and o.uniacid=:uniacid  group by o.id'), array(':uniacid' => $_W['uniacid']));

				foreach ($level2_orders as $o) {
					if (empty($o['id'])) {
						continue;
					}

					$hasorder = false;

					foreach ($orderids as $or) {
						if ($or['orderid'] == $o['id']) {
							$hasorder = true;
							break;
						}
					}

					if ($hasorder) {
						continue;
					}

					$orderids[] = array('orderid' => $o['id'], 'level' => 2);
				}
			}
		}

		if (3 <= $level) {
			if (0 < $member['level2']) {
				$level3_orders = pdo_fetchall('select distinct o.id from ' . tablename('ewei_shop_order') . ' o ' . ' left join  ' . tablename('ewei_shop_order_goods') . ' og on og.orderid=o.id ' . ' where o.agentid in( ' . implode(',', array_keys($member['level2_agentids'])) . (')  and o.status>=3  and  og.status3=0 and og.nocommission=0 and (' . $time . ' - o.finishtime > ' . $day_times . ')   and o.uniacid=:uniacid  group by o.id'), array(':uniacid' => $_W['uniacid']));

				foreach ($level3_orders as $o) {
					if (empty($o['id'])) {
						continue;
					}

					$hasorder = false;

					foreach ($orderids as $or) {
						if ($or['orderid'] == $o['id']) {
							$hasorder = true;
							break;
						}
					}

					if ($hasorder) {
						continue;
					}

					$orderids[] = array('orderid' => $o['id'], 'level' => 3);
				}
			}
		}

		foreach ($orderids as $o) {
			$goods = pdo_fetchall('SELECT ' . 'og.commission1,og.commission2,og.commission3,og.commissions,' . 'og.status1,og.status2,og.status3,' . 'og.content1,og.content2,og.content3 from ' . tablename('ewei_shop_order_goods') . ' og' . ' left join ' . tablename('ewei_shop_goods') . ' g on g.id=og.goodsid  ' . ' where og.orderid=:orderid and og.nocommission=0 and og.uniacid = :uniacid order by og.createtime  desc ', array(':uniacid' => $_W['uniacid'], ':orderid' => $o['orderid']));

			foreach ($goods as $g) {
				$commissions = iunserializer($g['commissions']);
				if ($o['level'] == 1 && $g['status1'] == 0) {
					$commission1 = iunserializer($g['commission1']);

					if (empty($commissions)) {
						$commission_ok += isset($commission1['level' . $agentLevel['id']]) ? $commission1['level' . $agentLevel['id']] : $commission1['default'];
					}
					else {
						$commission_ok += isset($commissions['level1']) ? floatval($commissions['level1']) : 0;
					}
				}

				if ($o['level'] == 2 && $g['status2'] == 0) {
					$commission2 = iunserializer($g['commission2']);

					if (empty($commissions)) {
						$commission_ok += isset($commission2['level' . $agentLevel['id']]) ? $commission2['level' . $agentLevel['id']] : $commission2['default'];
					}
					else {
						$commission_ok += isset($commissions['level2']) ? floatval($commissions['level2']) : 0;
					}
				}

				if ($o['level'] == 3 && $g['status3'] == 0) {
					$commission3 = iunserializer($g['commission3']);

					if (empty($commissions)) {
						$commission_ok += isset($commission3['level' . $agentLevel['id']]) ? $commission3['level' . $agentLevel['id']] : $commission3['default'];
					}
					else {
						$commission_ok += isset($commissions['level3']) ? floatval($commissions['level3']) : 0;
					}
				}
			}
		}

		$withdraw = floatval($this->set['withdraw']);

		if ($withdraw <= 0) {
			$withdraw = 1;
		}

		$cansettle = $withdraw <= $commission_ok;
		$member['commission_ok'] = number_format($commission_ok, 2);
		$set_array = array();
		$set_array['charge'] = floatval($this->set['withdrawcharge']);
		$set_array['begin'] = floatval($this->set['withdrawbegin']);
		$set_array['end'] = floatval($this->set['withdrawend']);
		$realmoney = $commission_ok;
		$deductionmoney = 0;

		if (!empty($set_array['charge'])) {
			$money_array = m('member')->getCalculateMoney($commission_ok, $set_array);

			if ($money_array['flag']) {
				$realmoney = $money_array['realmoney'];
				$deductionmoney = $money_array['deductionmoney'];
			}
		}

		$last_data = $this->model->getLastApply($member['id']);
		$last_data = empty($last_data) ? array() : $last_data;
		$type_array = array();
		$type_array_new = array();

		if ($this->set['cashcredit'] == 1) {
			$type_array[] = array('type' => 0, 'title' => $this->set['texts']['withdraw'] . '到' . $_W['shopset']['trade']['moneytext']);
			$type_array_new[] = 0;
		}

		if ($this->set['cashweixin'] == 1 && !is_h5app()) {
			$type_array[] = array('type' => 1, 'title' => $this->set['texts']['withdraw'] . '到微信钱包');
			$type_array_new[] = 1;
		}

		if ($this->set['cashother'] == 1) {
			if ($this->set['cashalipay'] == 1) {
				$type_array[] = array('type' => 2, 'title' => $this->set['texts']['withdraw'] . '到支付宝');
				$type_array_new[] = 2;

				if (!empty($last_data)) {
					if ($last_data['type'] != 2) {
						$type_last = $this->model->getLastApply($member['id'], 2);

						if (!empty($type_last)) {
							$last_data['realname'] = $type_last['realname'];
							$last_data['alipay'] = $type_last['alipay'];
						}
					}
				}
			}

			if ($this->set['cashcard'] == 1) {
				$type_array[] = array('type' => 3, 'title' => $this->set['texts']['withdraw'] . '到银行卡');
				$type_array_new[] = 3;

				if (!empty($last_data)) {
					if ($last_data['type'] != 3) {
						$type_last = $this->model->getLastApply($member['id'], 3);

						if (!empty($type_last)) {
							$last_data['realname'] = $type_last['realname'];
							$last_data['bankname'] = $type_last['bankname'];
							$last_data['bankcard'] = $type_last['bankcard'];
						}
					}
				}

				$condition = ' and uniacid=:uniacid';
				$params = array(':uniacid' => $_W['uniacid']);
				$banklist = pdo_fetchall('SELECT * FROM ' . tablename('ewei_shop_commission_bank') . (' WHERE 1 ' . $condition . '  ORDER BY displayorder DESC'), $params);
			}
		}

		$applyIndex = 0;
		if (!empty($last_data) && !empty($type_array)) {
			foreach ($type_array as $index => $v) {
				if ($v['type'] == $last_data['type']) {
					$type_array[$index]['checked'] = 1;
					$applyIndex = $index;
				}
			}
		}

		if ($_W['ispost']) {
			$open_redis = function_exists('redis') && !is_error(redis());

			if ($open_redis) {
				$redis_key = $_W['uniacid'] . '_commission_apply_token_' . $openid;
				$redis = redis();

				if (!is_error($redis)) {
					if ($redis->setnx($redis_key, time())) {
						$redis->expireAt($redis_key, time() + 2);
					}
					else if ($redis->get($redis_key) + 2 < time()) {
						$redis->del($redis_key);
					}
					else {
						return app_error(AppError::$CommissionNotShortTimeSubmit);
					}
				}
			}

			if ($commission_ok <= 0 || empty($orderids)) {
				return app_error(-2, '参数错误,请刷新页面后重新提交!');
			}

			$type = intval($_GPC['type']);

			if (!in_array($type, $type_array_new)) {
				return app_error(AppError::$WithdrawNotType);
			}

			$apply = array();

			if ($type == 2) {
				$realname = trim($_GPC['realname']);
				$alipay = trim($_GPC['alipay']);
				$alipay1 = trim($_GPC['alipay1']);

				if (empty($realname)) {
					return app_error(AppError::$ParamsError, '请填写姓名!');
				}

				if (empty($alipay)) {
					return app_error(AppError::$ParamsError, '请填写支付宝帐号!');
				}

				if (empty($alipay1)) {
					return app_error(AppError::$ParamsError, '请填写确认帐号!');
				}

				if ($alipay != $alipay1) {
					return app_error(AppError::$ParamsError, '支付宝帐号与确认帐号不一致!');
				}

				$apply['realname'] = $realname;
				$apply['alipay'] = $alipay;
			}
			else {
				if ($type == 3) {
					$realname = trim($_GPC['realname']);
					$bankname = trim($_GPC['bankname']);
					$bankcard = trim($_GPC['bankcard']);
					$bankcard1 = trim($_GPC['bankcard1']);

					if (empty($realname)) {
						return app_error(AppError::$ParamsError, '请填写姓名!');
					}

					if (empty($bankname)) {
						return app_error(AppError::$ParamsError, '请选择银行!');
					}

					if (empty($bankcard)) {
						return app_error(AppError::$ParamsError, '请填写银行卡号!');
					}

					if (empty($bankcard1)) {
						return app_error(AppError::$ParamsError, '请填写确认卡号!');
					}

					if ($bankcard != $bankcard1) {
						return app_error(AppError::$ParamsError, '银行卡号与确认卡号不一致!');
					}

					$apply['realname'] = $realname;
					$apply['bankname'] = $bankname;
					$apply['bankcard'] = $bankcard;
				}
			}

			foreach ($orderids as $o) {
				pdo_update('ewei_shop_order_goods', array('status' . $o['level'] => 1, 'applytime' . $o['level'] => $time), array('orderid' => $o['orderid'], 'uniacid' => $_W['uniacid']));
			}

			$applyno = m('common')->createNO('commission_apply', 'applyno', 'CA');
			$apply['uniacid'] = $_W['uniacid'];
			$apply['applyno'] = $applyno;
			$apply['orderids'] = iserializer($orderids);
			$apply['mid'] = $member['id'];
			$apply['commission'] = $commission_ok;
			$apply['type'] = $type;
			$apply['status'] = 1;
			$apply['applytime'] = $time;
			$apply['realmoney'] = $realmoney;
			$apply['deductionmoney'] = $deductionmoney;
			$apply['charge'] = $set_array['charge'];
			$apply['beginmoney'] = $set_array['begin'];
			$apply['endmoney'] = $set_array['end'];
			pdo_insert('ewei_shop_commission_apply', $apply);
			$apply_type = array('余额', '微信钱包', '支付宝', '银行卡');
			$mcommission = $commission_ok;

			if (!empty($deductionmoney)) {
				$mcommission .= ',实际到账金额:' . $realmoney . ',提现手续费金额:' . $deductionmoney;
			}

			$this->model->sendMessage($openid, array('commission' => $mcommission, 'type' => $apply_type[$apply['type']]), TM_COMMISSION_APPLY);
			return app_json();
		}

		$set = array('texts' => $this->set['texts']);
		$applytype = 0;
		$applytype_res = array();

		foreach ($type_array as $k => $v) {
			if (isset($v['checked'])) {
				$applytype = $v['type'];
			}

			$applytype_res[] = $v;
		}

		$banklist = isset($banklist) ? $banklist : array();
		$bankIndex = false;

		foreach ($banklist as $key => $val) {
			if ($last_data['bankname'] == $val['bankname']) {
				$bankIndex = $key;
				break;
			}
		}

		$data = array('set' => $set, 'type_array' => $applytype_res, 'applytype' => $applytype, 'applyIndex' => $applyIndex, 'commission_ok' => $commission_ok, 'bankIndex' => $bankIndex, 'banklist' => $banklist, 'last_data' => $last_data, 'cansettle' => $cansettle, 'set_array' => !empty($set_array) ? $set_array : array(), 'deductionmoney' => $deductionmoney, 'withdraw' => $withdraw, 'realmoney' => $realmoney, 'menu' => p('app')->diyMenu('commission'));
		return app_json($data);
	}

	public function register()
	{
		global $_W;
		global $_GPC;
		$openid = $_W['openid'];
		$set = set_medias($this->set, 'regbg');
		$member = m('member')->getMember($openid);
		if ($member['isagent'] == 1 && $member['status'] == 1) {
			return app_error(AppError::$CommissionIsAgent);
		}

		if ($member['agentblack']) {
			return app_error(AppError::$UserIsBlack);
		}

		$apply_set = array();
		$apply_set['open_protocol'] = (int) $set['open_protocol'];

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
			$commission_diyform_open = $set_config['commission_diyform_open'];

			if ($commission_diyform_open == 1) {
				$template_flag = 1;
				$diyform_id = $set_config['commission_diyform'];

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

		$mid = intval($_GPC['mid']);
		$agent = false;

		if (!empty($member['fixagentid'])) {
			$mid = $member['agentid'];

			if (!empty($mid)) {
				$agent = m('member')->getMember($member['agentid']);
			}
		}
		else if (!empty($member['agentid'])) {
			$mid = $member['agentid'];
			$agent = m('member')->getMember($member['agentid']);
		}
		else if (!empty($member['inviter'])) {
			$mid = $member['inviter'];
			$agent = m('member')->getMember($member['inviter']);
		}
		else {
			if (!empty($mid)) {
				$agent = m('member')->getMember($mid);
			}
		}

		if ($_W['ispost']) {
			if ($set['become'] != '1') {
				return app_error(AppError::$SystemError, '未开启' . $set['texts']['agent'] . '注册!');
			}

			$icode = intval($_GPC['icode']);
			$become_check = intval($set['become_check']);
			$ret['status'] = $become_check;

			if (0 < $icode) {
				$iagent = m('member')->getMember($icode);
				if (!empty($iagent) && $iagent['isagent'] == 1) {
					$mid = $icode;
				}
			}

			if ($template_flag == 1) {
				$memberdata = $_GPC['memberdata'];

				if (is_string($memberdata)) {
					$memberdatastring = htmlspecialchars_decode(str_replace('\\', '', $memberdata));
					$memberdata = @json_decode($memberdatastring, true);
				}

				$insert_data = $diyform_plugin->getInsertData($fields, $memberdata, true);
				$data = $insert_data['data'];
				$m_data = $insert_data['m_data'];
				$mc_data = $insert_data['mc_data'];
				$m_data['diycommissionid'] = $diyform_id;
				$m_data['diycommissionfields'] = iserializer($fields);
				$m_data['diycommissiondata'] = $data;
				$m_data['isagent'] = 1;
				$m_data['agentid'] = $mid;
				$m_data['status'] = $become_check;
				$m_data['agenttime'] = $become_check == 1 ? time() : 0;
				unset($m_data['credit1']);
				unset($m_data['credit2']);
				pdo_update('ewei_shop_member', $m_data, array('id' => $member['id']));

				if ($become_check == 1) {
					$this->model->sendMessage($member['openid'], array('nickname' => $member['nickname'], 'agenttime' => $m_data['agenttime']), TM_COMMISSION_BECOME);
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
				$data = array('isagent' => 1, 'agentid' => $mid, 'status' => $become_check, 'realname' => trim($_GPC['realname']), 'mobile' => trim($_GPC['mobile']), 'weixin' => trim($_GPC['weixin']), 'agenttime' => $become_check == 1 ? time() : 0);
				pdo_update('ewei_shop_member', $data, array('id' => $member['id']));

				if ($become_check == 1) {
					$this->model->sendMessage($member['openid'], array('nickname' => $member['nickname'], 'agenttime' => $data['agenttime']), TM_COMMISSION_BECOME);

					if (!empty($mid)) {
						$this->model->upgradeLevelByAgent($mid);

						if (p('globonus')) {
							p('globonus')->upgradeLevelByAgent($mid);
						}

						if (p('author')) {
							p('author')->upgradeLevelByAgent($mid);
						}
					}
				}

				if (!empty($member['uid'])) {
					m('member')->mc_update($member['uid'], array('realname' => $data['realname'], 'mobile' => $data['mobile']));
				}
			}

			return app_json(array('check' => $become_check));
		}

		$order_status = intval($set['become_order']) == 0 ? 1 : 3;
		$become_check = intval($set['become_check']);
		$to_check_agent = false;

		if (empty($set['become'])) {
			if (empty($member['status']) || empty($member['isagent'])) {
				$data = array('isagent' => 1, 'agentid' => $mid, 'status' => $become_check, 'realname' => $_GPC['realname'], 'mobile' => $_GPC['mobile'], 'weixin' => $_GPC['weixin'], 'agenttime' => $become_check == 1 ? time() : 0);
				pdo_update('ewei_shop_member', $data, array('id' => $member['id']));

				if ($become_check == 1) {
					$this->model->sendMessage($member['openid'], array('nickname' => $member['nickname'], 'agenttime' => $data['agenttime']), TM_COMMISSION_BECOME);
					$this->model->upgradeLevelByAgent($member['id']);

					if (p('globonus')) {
						p('globonus')->upgradeLevelByAgent($member['id']);
					}

					if (p('author')) {
						p('author')->upgradeLevelByAgent($member['id']);
					}
				}

				if (!empty($member['uid'])) {
					m('member')->mc_update($member['uid'], array('realname' => $data['realname'], 'mobile' => $data['mobile']));
				}

				$member['isagent'] = 1;
				$member['status'] = $become_check;
			}
		}
		else if ($set['become'] == '2') {
			$status = 1;
			$ordercount = pdo_fetchcolumn('select count(*) from ' . tablename('ewei_shop_order') . (' where uniacid=:uniacid and openid=:openid and status>=' . $order_status . ' limit 1'), array(':uniacid' => $_W['uniacid'], ':openid' => $openid));

			if ($ordercount < intval($set['become_ordercount'])) {
				$status = 0;
				$order_count = number_format($ordercount, 0);
				$order_totalcount = number_format($set['become_ordercount'], 0);
			}
			else {
				$to_check_agent = true;
			}
		}
		else if ($set['become'] == '3') {
			$status = 1;
			$moneycount = pdo_fetchcolumn('select sum(goodsprice) from ' . tablename('ewei_shop_order') . (' where uniacid=:uniacid and openid=:openid and status>=' . $order_status . ' limit 1'), array(':uniacid' => $_W['uniacid'], ':openid' => $openid));

			if ($moneycount < floatval($set['become_moneycount'])) {
				$status = 0;
			}
			else {
				$to_check_agent = true;
			}
		}
		else {
			if ($set['become'] == 4) {
				$goods = pdo_fetch('select id,title,thumb,marketprice from' . tablename('ewei_shop_goods') . ' where id=:id and uniacid=:uniacid limit 1', array(':id' => $set['become_goodsid'], ':uniacid' => $_W['uniacid']));
				$goodscount = pdo_fetchcolumn('select count(*) from ' . tablename('ewei_shop_order_goods') . ' og ' . '  left join ' . tablename('ewei_shop_order') . ' o on o.id = og.orderid' . (' where og.goodsid=:goodsid and o.openid=:openid and o.status>=' . $order_status . '  limit 1'), array(':goodsid' => $set['become_goodsid'], ':openid' => $openid));

				if ($goodscount <= 0) {
					$status = 0;
					$goods['thumb'] = tomedia($goods['thumb']);
					$buy_goods = $goods;
				}
				else {
					$to_check_agent = true;
					$status = 1;
				}

				if (p('cmember')) {
					$status = 0;
					$to_check_agent = false;
				}
			}
		}

		if ($to_check_agent) {
			if (empty($member['isagent'])) {
				$data = array('isagent' => 1, 'status' => $become_check, 'agenttime' => time());
				$member['isagent'] = 1;
				$member['status'] = $become_check;
				pdo_update('ewei_shop_member', $data, array('id' => $member['id']));

				if ($become_check == 1) {
					$this->model->sendMessage($member['openid'], array('nickname' => $member['nickname'], 'agenttime' => $data['agenttime']), TM_COMMISSION_BECOME);

					if (!empty($member['agentid'])) {
						$parent = m('member')->getMember($member['agentid']);
						if (!empty($parent) && !empty($parent['status']) && !empty($parent['isagent'])) {
							$this->model->upgradeLevelByAgent($parent['id']);
						}
					}
				}
			}
		}

		$res = array(
			'set'              => array('texts' => $this->set['texts'], 'regbg' => empty($set['regbg']) ? $_W['siteroot'] . 'addons/ewei_shopv2/plugin/commission/template/mobile/default/static/images/bg.png' : $set['regbg'], 'become' => (int) $set['become'], 'open_protocol' => $set['open_protocol'], 'applytitle' => $set['applytitle'], 'applycontent' => $set['applycontent'], 'register_bottom' => (int) $set['register_bottom'], 'register_bottom_title1' => $set['register_bottom_title1'], 'register_bottom_content1' => $set['register_bottom_content1'], 'register_bottom_title2' => $set['register_bottom_title2'], 'register_bottom_content2' => $set['register_bottom_content2'], 'register_bottom_title3' => $set['register_bottom_title3'], 'register_bottom_content3' => $set['register_bottom_content3'], 'register_bottom_content' => $set['register_bottom_content'], 'register_bottom_remark' => $set['register_bottom_remark']),
			'member'           => array('agentblack' => (int) $member['agentblack'], 'isagent' => (int) $member['isagent'], 'status' => (int) $member['status'], 'realname' => $member['realname'], 'mobile' => $member['mobile'], 'weixin' => $member['weixin']),
			'status'           => (int) $status,
			'order_totalcount' => (int) $order_totalcount,
			'order_count'      => (int) $order_count,
			'money_totalcount' => (double) $set['become_moneycount'],
			'moneycount'       => (double) $moneycount,
			'buy_goods'        => isset($buy_goods) ? $buy_goods : array(),
			'agent'            => $agent,
			'template_flag'    => $template_flag,
			'apply_set'        => $apply_set,
			'shopname'         => $_W['shopset']['shop']['name'],
			'mid'              => $mid,
			'template_flag'    => $template_flag,
			'f_data'           => $appDatas['f_data'],
			'fields'           => $appDatas['fields'],
			'menu'             => p('app')->diyMenu('commission'),
			'hideicode'        => $set['hideicode']
		);
		return app_json($res);
	}
}

?>
