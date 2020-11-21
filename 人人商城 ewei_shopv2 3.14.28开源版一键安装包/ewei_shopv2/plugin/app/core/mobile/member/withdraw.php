<?php
if (!defined('IN_IA')) {
	exit('Access Denied');
}

require_once EWEI_SHOPV2_PLUGIN . 'app/core/page_mobile.php';
class Withdraw_EweiShopV2Page extends AppMobilePage
{
	public function main()
	{
		global $_W;
		global $_GPC;
		$set = $_W['shopset']['trade'];
		$status = 1;
		$openid = $_W['openid'];

		if (empty($openid)) {
			return app_error(AppError::$UserNotLogin);
		}

		if (empty($set['withdraw'])) {
			return app_error(AppError::$WithdrawNotOpen);
		}

		$withdrawcharge = $set['withdrawcharge'];
		$withdrawbegin = floatval($set['withdrawbegin']);
		$withdrawend = floatval($set['withdrawend']);
		$member = $this->member;
		$credit = $member['credit2'];
		$last_data = $this->getLastApply($openid);
		$type_array = array();

		if ($set['withdrawcashweixin'] == 1) {
			$type_array[] = array('type' => 0, 'title' => '提现到微信钱包');
		}

		if ($set['withdrawcashalipay'] == 1) {
			$type_array[] = array('type' => 2, 'title' => '提现到支付宝');

			if (!empty($last_data)) {
				if ($last_data['applytype'] != 2) {
					$type_last = $this->getLastApply($openid, 2);

					if (!empty($type_last)) {
						$last_data['alipay'] = $type_last['alipay'];
					}
				}
			}
		}

		if ($set['withdrawcashcard'] == 1) {
			$type_array[] = array('type' => 3, 'title' => '提现到银行卡');

			if (!empty($last_data)) {
				if ($last_data['applytype'] != 3) {
					$type_last = $this->getLastApply($openid, 3);

					if (!empty($type_last)) {
						$last_data['bankname'] = $type_last['bankname'];
						$last_data['bankcard'] = $type_last['bankcard'];
					}
				}
			}

			$condition = ' and uniacid=:uniacid';
			$params = array(':uniacid' => $_W['uniacid']);
			$banklist = pdo_fetchall('SELECT * FROM ' . tablename('ewei_shop_commission_bank') . (' WHERE 1 ' . $condition . '  ORDER BY displayorder DESC'), $params);
		}

		if (!empty($last_data) && !empty($type_array)) {
			foreach ($type_array as $index => $v) {
				if ($v['type'] == $last_data['type']) {
					$type_array[$index]['checked'] = 1;
				}
			}
		}

		if (empty($banklist) || !is_array($banklist)) {
			unset($type_array[3]);
		}

		$result = array();
		$result['moneytext'] = $_W['shopset']['trade']['moneytext'];
		$result['credit'] = floatval($credit);
		$result['type_array'] = $type_array;
		$result['withdrawcharge'] = $withdrawcharge;
		$result['withdrawbegin'] = $withdrawbegin;
		$result['withdrawend'] = $withdrawend;
		$result['last_data'] = $last_data;
		$result['banklist'] = $banklist;
		$result['withdrawmoney'] = $set['withdrawmoney'];
		if (!empty($last_data['bankname']) && !empty($banklist)) {
			foreach ($banklist as $index => $bankitem) {
				if ($bankitem['bankname'] == $last_data['bankname']) {
					$result['lastbankindex'] = $index;
					break;
				}
			}
		}

		return app_json($result);
	}

	public function submit()
	{
		global $_W;
		global $_GPC;
		$set = $_W['shopset']['trade'];

		if (empty($set['withdraw'])) {
			show_json(0, '系统未开启提现!');
		}

		$set_array = array();
		$set_array['charge'] = $set['withdrawcharge'];
		$set_array['begin'] = floatval($set['withdrawbegin']);
		$set_array['end'] = floatval($set['withdrawend']);
		$money = floatval($_GPC['money']);
		$credit = m('member')->getCredit($_W['openid'], 'credit2');

		if ($money <= 0) {
			show_json(0, '提现金额错误!');
		}

		if ($credit < $money) {
			show_json(0, '提现金额过大!');
		}

		$apply = array();
		$type_array = array();

		if ($set['withdrawcashweixin'] == 1) {
			$type_array[0]['title'] = '提现到微信钱包';
		}

		if ($set['withdrawcashalipay'] == 1) {
			$type_array[2]['title'] = '提现到支付宝';
		}

		if ($set['withdrawcashcard'] == 1) {
			$type_array[3]['title'] = '提现到银行卡';
			$condition = ' and uniacid=:uniacid';
			$params = array(':uniacid' => $_W['uniacid']);
			$banklist = pdo_fetchall('SELECT * FROM ' . tablename('ewei_shop_commission_bank') . (' WHERE 1 ' . $condition . '  ORDER BY displayorder DESC'), $params);
		}

		$applytype = intval($_GPC['applytype']);

		if (!array_key_exists($applytype, $type_array)) {
			show_json(0, '未选择提现方式，请您选择提现方式后重试!');
		}

		if ($applytype == 2) {
			$realname = trim($_GPC['realname']);
			$alipay = trim($_GPC['alipay']);
			$alipay1 = trim($_GPC['alipay1']);

			if (empty($realname)) {
				return app_error(AppError::$ParamsError, '请填写姓名');
			}

			if (empty($alipay)) {
				return app_error(AppError::$ParamsError, '请填写支付宝帐号');
			}

			if (empty($alipay1)) {
				return app_error(AppError::$ParamsError, '请填写确认帐号');
			}

			if ($alipay != $alipay1) {
				return app_error(AppError::$ParamsError, '支付宝帐号与确认帐号不一致');
			}

			$apply['realname'] = $realname;
			$apply['alipay'] = $alipay;
		}
		else {
			if ($applytype == 3) {
				$realname = trim($_GPC['realname']);
				$bankname = trim($_GPC['bankname']);
				$bankcard = trim($_GPC['bankcard']);
				$bankcard1 = trim($_GPC['bankcard1']);

				if (empty($realname)) {
					return app_error(AppError::$ParamsError, '请填写姓名!');
				}

				if (empty($bankname)) {
					return app_error(AppError::$ParamsError, '请选择银行');
				}

				if (empty($bankcard)) {
					return app_error(AppError::$ParamsError, '请填写银行卡号');
				}

				if (empty($bankcard1)) {
					return app_error(AppError::$ParamsError, '请填写确认卡号');
				}

				if ($bankcard != $bankcard1) {
					return app_error(AppError::$ParamsError, '银行卡号与确认卡号不一致');
				}

				$apply['realname'] = $realname;
				$apply['bankname'] = $bankname;
				$apply['bankcard'] = $bankcard;
			}
		}

		$realmoney = $money;

		if (!empty($set_array['charge'])) {
			$money_array = m('member')->getCalculateMoney($money, $set_array);

			if ($money_array['flag']) {
				$realmoney = $money_array['realmoney'];
				$deductionmoney = $money_array['deductionmoney'];
			}
		}

		m('member')->setCredit($_W['openid'], 'credit2', 0 - $money, array(0, $_W['shopset']['set'][''] . '余额提现预扣除: ' . $money . ',实际到账金额:' . $realmoney . ',手续费金额:' . $deductionmoney));
		$logno = m('common')->createNO('member_log', 'logno', 'RW');
		$apply['uniacid'] = $_W['uniacid'];
		$apply['logno'] = $logno;
		$apply['openid'] = $_W['openid'];
		$apply['title'] = '余额提现';
		$apply['type'] = 1;
		$apply['createtime'] = time();
		$apply['status'] = 0;
		$apply['money'] = $money;
		$apply['realmoney'] = $realmoney;
		$apply['deductionmoney'] = $deductionmoney;
		$apply['charge'] = $set_array['charge'];
		$apply['applytype'] = $applytype;
		pdo_insert('ewei_shop_member_log', $apply);
		$logid = pdo_insertid();
		m('notice')->sendMemberLogMessage($logid);
		return app_json();
	}

	public function getLastApply($openid, $applytype = -1)
	{
		global $_W;
		$params = array(':uniacid' => $_W['uniacid'], ':openid' => $openid);
		$sql = 'select applytype,alipay,bankname,bankcard,realname from ' . tablename('ewei_shop_member_log') . ' where openid=:openid and uniacid=:uniacid';

		if (-1 < $applytype) {
			$sql .= ' and applytype=:applytype';
			$params[':applytype'] = $applytype;
		}

		$sql .= ' order by id desc Limit 1';
		$data = pdo_fetch($sql, $params);
		return $data;
	}
}

?>
