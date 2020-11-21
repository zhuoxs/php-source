<?php
/**
 * [WeEngine System] Copyright (c) 2014 WE7.CC
 * WeEngine is NOT a free software, it under the license terms, visited http://www.we7.cc/ for more details.
 */
defined('IN_IA') or exit('Access Denied');

class RechargeModuleSite extends WeModuleSite {
	
	public function doMobilePay() {
		global $_W, $_GPC;
		checkauth();
		$type = trim($_GPC['type']) ? trim($_GPC['type']) : 'credit';
		if($type == 'credit') {
			load() -> model('card');
			$recharge_settings = card_params_setting('cardRecharge');
			if(checksubmit()) {
				$fee = floatval($_GPC['fee']);
				$backtype = trim($_GPC['backtype']);
				$back= floatval($_GPC['back']);
				if (empty($fee) || $fee <= 0) {
					message('请选择充值金额', referer(), 'error');
				}
				$chargerecord = array(
					'uid' => $_W['member']['uid'],
					'openid' => $_W['openid'],
					'uniacid' => $_W['uniacid'],
					'tid' => date('YmdHi').random(8, 1),
					'fee' => $fee,
					'type' => 'credit',
					'tag' => $back,
					'backtype' => $backtype,
					'status' => 0,
					'createtime' => TIMESTAMP,
				);
				if (!pdo_insert('mc_credits_recharge', $chargerecord)) {
					message('创建充值订单失败，请重试！', url('entry', array('m' => 'recharge', 'do' => 'pay')), 'error');
				}
				$params = array(
					'tid' => $chargerecord['tid'],
					'ordersn' => $chargerecord['tid'],
					'title' => '会员余额充值',
					'fee' => $chargerecord['fee'],
					'user' => $_W['member']['uid'],
				);
				$mine = array();
				if (empty($backtype)) {
					$condition = $fee;
					$mine = array(
						'name' => "充{$condition}送{$back}元",
						'value' => $fee
					);
				} elseif ($backtype == '1') {
					$condition = $fee;
					$mine = array(
						'name' => "充{$condition}送{$back}积分",
						'value' => $fee
					);
				} elseif ($backtype == '2') {
					$condition = $fee;
				}
				$this->pay($params, $mine);
				exit();
			}
			$member = mc_fetch($_W['member']['uid']);
			$name = $member['mobile'];
			if(empty($name)) {
				$name = $member['realname'];
			}
			if(empty($name)) {
				$name = $member['uid'];
			}
			include $this->template('recharge');
		} else {
			$fee = floatval($_GPC['fee']);
			if(!$fee) {
				message('充值金额不能为0', referer(), 'error');
			}
			if($fee <= 0) {
				message('请输入充值的金额', referer(), 'error');
			}
			$setting = pdo_get('mc_card', array('uniacid' => $_W['uniacid'], 'status' => 1));
			if(empty($setting)) {
				message('会员卡未开启,请联系商家', referer(), 'error');
			}
			if($type == 'card_nums') {
				if(!$setting['nums_status']) {
					message("会员卡未开启{$setting['nums_text']}充值,请联系商家", referer(), 'error');
				}
				$setting['nums'] = iunserializer($setting['nums']);
				$num_keys = array_keys($setting['nums']);
				if (!in_array($fee, $num_keys)) {
					message('充值金额错误,请联系商家', referer(), 'error');
				}
				foreach ($setting['nums'] as $key => $val) {
					if ($fee == $val['recharge']) {
						$num_back = $val['num'];
					}
				}
				$mine = array(
					'name' => "充{$fee}送{$num_back}次",
					'value' => "送{$num_back}次"
				);
				$tag = $num_back;
			}
			if($type == 'card_times') {
				if(!$setting['times_status']) {
					message("会员卡未开启{$setting['times_text']}充值,请联系商家", referer(), 'error');
				}

				$setting['times'] = iunserializer($setting['times']);
				$time_keys = array_keys($setting['times']);
				if (!in_array($fee, $time_keys)) {
					message('充值金额错误,请联系商家', referer(), 'error');
				}
				foreach ($setting['times'] as $key => $val) {
					if ($fee == $val['recharge']) {
						$time_back = $val['time'];
					}
				}
				$member_card = pdo_get('mc_card_members', array('uniacid' => $_W['uniacid'], 'uid' => $_W['member']['uid']));
				if($member_card['endtime'] > TIMESTAMP) {
					$endtime = $member_card['endtime'] + time_back * 86400;
				} else {
					$endtime = strtotime($time_back . 'days');
				}
				$mine = array(
					'name' => "充{$fee}送{$time_back}天",
					'value' => date('Y-m-d', $endtime) . '到期'
				);
				$tag = $time_back;
			}
	
			$chargerecord = pdo_fetch("SELECT * FROM ".tablename('mc_credits_recharge')." WHERE uniacid = :uniacid AND uid = :uid AND fee = :fee AND type = :type  AND status = 0 AND tag = :tag", array(
				':uniacid' => $_W['uniacid'],
				':uid' => $_W['member']['uid'],
				':fee' => $fee,
				':type' => $type,
				':tag' => $tag,
			));
			if (empty($chargerecord)) {
				$chargerecord = array(
					'uid' => $_W['member']['uid'],
					'openid' => $_W['openid'],
					'uniacid' => $_W['uniacid'],
					'tid' => date('YmdHi').random(8, 1),
					'fee' => $fee,
					'type' => $type,
					'tag' => $tag,
					'status' => 0,
					'createtime' => TIMESTAMP,
				);
				if (!pdo_insert('mc_credits_recharge', $chargerecord)) {
					message('创建充值订单失败，请重试！', url('mc/card/mycard'), 'error');
				}
			}
			$types = array(
				'card_nums' => $setting['nums_text'],
				'card_times' => $setting['times_text'],
			);
			$params = array(
				'tid' => $chargerecord['tid'],
				'ordersn' => $chargerecord['tid'],
				'title' => "会员卡{$types[$type]}充值",
				'fee' => $chargerecord['fee'],
				'user' => $_W['member']['uid'],
			);
			$this->pay($params, $mine);
			exit();
		}
	}
	
	
	public function payResult($params) {
		global $_W;
		load()-> model('mc');
		load() -> model('card');
		$order = pdo_fetch("SELECT * FROM ".tablename('mc_credits_recharge')." WHERE tid = :tid", array(':tid' => $params['tid']));
		if ($params['result'] == 'success' && $params['from'] == 'notify') {
			$fee = $params['fee'];
			$total_fee = $fee;
			$data = array('status' => $params['result'] == 'success' ? 1 : -1);
						if ($params['type'] == 'wechat') {
				$data['transid'] = $params['tag']['transaction_id'];
				$params['user'] = mc_openid2uid($params['user']);
			}
			pdo_update('mc_credits_recharge', $data, array('tid' => $params['tid']));
			$paydata = array('wechat' => '微信', 'alipay' => '支付宝', 'baifubao' => '百付宝', 'unionpay' => '银联');
						if(empty($order['type']) || $order['type'] == 'credit') {
				$setting = uni_setting($_W['uniacid'], array('creditbehaviors', 'recharge'));
				$credit = $setting['creditbehaviors']['currency'];
				$recharge_settings = card_params_setting('cardRecharge');
				$recharge_params = $recharge_settings['params'];
				if(empty($credit)) {
					message('站点积分行为参数配置错误,请联系服务商', '', 'error');
				} else {
					if ($recharge_params['recharge_type'] == '1') {
						$recharges = $recharge_params['recharges'];
					}
					if ($order['backtype'] == '2') {
						$total_fee = $fee;
					} else {
						foreach ($recharges as $key => $recharge) {
							if ($recharge['backtype'] == $order['backtype'] && $recharge['condition'] == $order['fee']) {
								if ($order['backtype'] == '1') {
									$total_fee = $fee;
									$add_credit = $recharge['back'];
								} else {
									$total_fee = $fee + $recharge['back'];
								}
							}
						}
					}
					if ($order['backtype'] == '1') {
						$add_str = ",充值成功,返积分{$add_credit}分,本次操作共增加余额{$total_fee}元,积分{$add_credit}分";
						$remark = '用户通过' . $paydata[$params['type']] . '充值' . $fee . $add_str;
						$record[] = $params['user'];
						$record[] = $remark;
						mc_credit_update($order['uid'], 'credit1', $add_credit, $record);
						mc_credit_update($order['uid'], 'credit2', $total_fee, $record);
						mc_notice_recharge($order['openid'], $order['uid'], $total_fee, '', $remark);
					} else {
						$add_str = ",充值成功,本次操作共增加余额{$total_fee}元";
						$remark = '用户通过' . $paydata[$params['type']] . '充值' . $fee . $add_str;
						$record[] = $params['user'];
						$record[] = $remark;
						mc_credit_update($order['uid'], 'credit2', $total_fee, $record);
						mc_notice_recharge($order['openid'], $order['uid'], $total_fee, '', $remark);
					}
				}
			}

						if($order['type'] == 'card_nums') {
				$member_card = pdo_get('mc_card_members', array('uniacid' => $order['uniacid'], 'uid' => $order['uid']));
				$total_num = $member_card['nums'] + $order['tag'];
				pdo_update('mc_card_members', array('nums' => $total_num), array('uniacid' => $order['uniacid'], 'uid' => $order['uid']));
								$log = array(
					'uniacid' => $order['uniacid'],
					'uid' => $order['uid'],
					'type' => 'nums',
					'fee' => $params['fee'],
					'model' => '1',
					'tag' => $order['tag'], 					'note' => date('Y-m-d H:i') . "通过{$paydata[$params['type']]}充值{$params['fee']}元，返{$order['tag']}次，总共剩余{$total_num}次",
					'addtime' => TIMESTAMP
				);
				pdo_insert('mc_card_record', $log);
				$type = pdo_fetchcolumn('SELECT nums_text FROM ' . tablename('mc_card') . ' WHERE uniacid = :uniacid', array(':uniacid' => $order['uniacid']));
				$total_num = $member_card['nums'] + $order['tag'];
				mc_notice_nums_plus($order['openid'], $type, $order['tag'], $total_num);
			}

						if($order['type'] == 'card_times') {
				$member_card = pdo_get('mc_card_members', array('uniacid' => $order['uniacid'], 'uid' => $order['uid']));
				if($member_card['endtime'] > TIMESTAMP) {
					$endtime = $member_card['endtime'] + $order['tag'] * 86400;
				} else {
					$endtime = strtotime($order['tag'] . 'days');
				}
				pdo_update('mc_card_members', array('endtime' => $endtime), array('uniacid' => $order['uniacid'], 'uid' => $order['uid']));
				$log = array(
					'uniacid' => $order['uniacid'],
					'uid' => $order['uid'],
					'type' => 'times',
					'model' => '1',
					'fee' => $params['fee'],
					'tag' => $order['tag'], 					'note' => date('Y-m-d H:i') . "通过{$paydata[$params['type']]}充值{$params['fee']}元，返{$order['tag']}天，充值后到期时间:". date('Y-m-d', $endtime),
					'addtime' => TIMESTAMP
				);
				pdo_insert('mc_card_record', $log);
				$type = pdo_fetchcolumn('SELECT times_text FROM ' . tablename('mc_card') . ' WHERE uniacid = :uniacid', array(':uniacid' => $order['uniacid']));
				$endtime = date('Y-m-d', $endtime);
				mc_notice_times_plus($order['openid'], $member_card['cardsn'], $type, $fee, $order['tag'], $endtime);
			}
		}
		if($order['type'] == 'credit' || $order['type'] == '') {
			$url = murl('mc/home');
		} else {
			$url = murl('mc/card/mycard');
		}
				if ($params['from'] == 'return') {
			if ($params['result'] == 'success') {
				message('支付成功！', $_W['siteroot'] . 'app/' . $url, 'success');
			} else {
				message('支付失败！', $_W['siteroot'] . 'app/' . $url, 'error');
			}
		}
	}

	protected function pay($params = array(), $mine = array()) {
		global $_W;
		$params['module'] = $this->module['name'];
		$sql = 'SELECT * FROM ' . tablename('core_paylog') . ' WHERE `uniacid`=:uniacid AND `module`=:module AND `tid`=:tid';
		$pars = array();
		$pars[':uniacid'] = $_W['uniacid'];
		$pars[':module'] = $params['module'];
		$pars[':tid'] = $params['tid'];
		$log = pdo_fetch($sql, $pars);
		if(!empty($log) && $log['status'] == '1') {
			itoast('这个订单已经支付成功, 不需要重复支付.', '', 'info');
		}
		$setting = uni_setting($_W['uniacid'], array('payment', 'creditbehaviors'));
		if(!is_array($setting['payment'])) {
			itoast('没有有效的支付方式, 请联系网站管理员.', '', 'error');
		}
		$log = pdo_get('core_paylog', array('uniacid' => $_W['uniacid'], 'module' => $params['module'], 'tid' => $params['tid']));
		if (empty($log)) {
			$log = array(
				'uniacid' => $_W['uniacid'],
				'acid' => $_W['acid'],
				'openid' => $_W['member']['uid'],
				'module' => $this->module['name'], 				'tid' => $params['tid'],
				'fee' => $params['fee'],
				'card_fee' => $params['fee'],
				'status' => '0',
				'is_usecard' => '0',
			);
			pdo_insert('core_paylog', $log);
		}
		$pay = $setting['payment'];
		foreach ($pay as &$value) {
			$value['switch'] = $value['recharge_switch'];
		}
		unset($value);
		$pay['credit']['switch'] = false;
		$pay['delivery']['switch'] = false;
		include $this->template('common/paycenter');
	}
}