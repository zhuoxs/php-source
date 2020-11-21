<?php

function sort_enoughs($a, $b)
{
	$enough1 = floatval($a['enough']);
	$enough2 = floatval($b['enough']);

	if ($enough1 == $enough2) {
		return 0;
	}

	return $enough1 < $enough2 ? 1 : -1;
}

if (!defined('IN_IA')) {
	exit('Access Denied');
}

class Sale_EweiShopV2ComModel extends ComModel
{
	public function getEnoughsGoods()
	{
		global $_W;
		global $_S;
		$set = $_S['sale'];
		$goodsids = $set['goodsids'];
		return $goodsids;
	}

	public function getEnoughs()
	{
		global $_W;
		global $_S;
		$set = $_S['sale'];
		$allenoughs = array();
		$enoughs = $set['enoughs'];
		if (0 < floatval($set['enoughmoney']) && 0 < floatval($set['enoughdeduct'])) {
			$allenoughs[] = array('enough' => floatval($set['enoughmoney']), 'money' => floatval($set['enoughdeduct']));
		}

		if (is_array($enoughs)) {
			foreach ($enoughs as $e) {
				if (0 < floatval($e['enough']) && 0 < floatval($e['give'])) {
					$allenoughs[] = array('enough' => floatval($e['enough']), 'money' => floatval($e['give']));
				}
			}
		}

		usort($allenoughs, 'sort_enoughs');
		return $allenoughs;
	}

	public function getEnoughFree()
	{
		global $_W;
		global $_S;
		$set = $_S['sale'];

		if (!empty($set['enoughfree'])) {
			return 0 < $set['enoughorder'] ? $set['enoughorder'] : -1;
		}

		return false;
	}

	public function getRechargeActivity()
	{
		global $_S;
		$set = $_S['sale'];
		$recharges = iunserializer($set['recharges']);

		if (is_array($recharges)) {
			usort($recharges, 'sort_enoughs');
			return $recharges;
		}

		return false;
	}

	public function setRechargeActivity($log)
	{
		global $_W;
		global $_S;
		$set = m('common')->getPluginset('sale');
		$recharges = iunserializer($set['recharges']);
		$credit2 = 0;
		$enough = 0;
		$give = '';

		if (is_array($recharges)) {
			usort($recharges, 'sort_enoughs');

			foreach ($recharges as $r) {
				if (empty($r['enough']) || empty($r['give'])) {
					continue;
				}

				if (floatval($r['enough']) <= $log['money']) {
					if (strexists($r['give'], '%')) {
						$credit2 = round(floatval(str_replace('%', '', $r['give'])) / 100 * $log['money'], 2);
					}
					else {
						$credit2 = round(floatval($r['give']), 2);
					}

					$enough = floatval($r['enough']);
					$give = $r['give'];
					break;
				}
			}
		}

		if (0 < $credit2) {
			m('member')->setCredit($log['openid'], 'credit2', $credit2, array('0', $_S['shop']['name'] . '充值满' . $enough . '赠送' . $give, '现金活动'));
			pdo_update('ewei_shop_member_log', array('gives' => $credit2), array('id' => $log['id']));
		}

		$this->getCredit1($log['openid'], $log['money'], 21, 2);
	}

	/**
     * 传入金额,生成满立减优惠
     * @param string $openid 用户openid
     * @param int $price 传入金额
     * @param int $paytype 支付类型 1 余额支付; 3 货到付款; 21 微信支付; 22 支付宝支付; 37 收银台付款;
     * @param int $type 购物送积分 1 充值送积分 2
     * @param int $refund 是否是退款
     * @param string $desc 是否是退款
     * @return float|int
     */
	public function getCredit1($openid, $price = 0, $paytype = 1, $type = 1, $refund = 0, $desc = '')
	{
		global $_W;
		$type = intval($type);
		if (empty($openid) || empty($price) || empty($type)) {
			return 0;
		}

		$data = m('common')->getPluginset('sale');
		$credit1 = iunserializer($data['credit1']);

		if ($type == '1') {
			$name = '积分活动购物送积分';
			$enoughs = empty($credit1['enough1']) ? array() : $credit1['enough1'];

			if (empty($credit1['paytype'])) {
				return 0;
			}

			if (!empty($credit1['paytype']) && !in_array($paytype, array_keys($credit1['paytype']))) {
				return 0;
			}
		}
		else {
			if ($type = '2') {
				$name = '积分活动充值送积分';
				$enoughs = empty($credit1['enough2']) ? array() : $credit1['enough2'];
			}
		}

		if (!empty($desc)) {
			$name = $desc;
		}

		$allenoughs = array();

		if (is_array($enoughs)) {
			foreach ($enoughs as $e) {
				if (floatval($e['enough' . $type . '_1']) <= $price && $price <= floatval($e['enough' . $type . '_2'])) {
					if (0 < floatval($e['give' . $type])) {
						$allenoughs[] = floatval($e['give' . $type]);
					}
				}
			}
		}

		$money = 0;

		if (!empty($allenoughs)) {
			$money = (double) max($allenoughs);
		}

		if (0 < $money) {
			$money *= $price;
			$money = floor($money);

			if (empty($refund)) {
				m('member')->setCredit($openid, 'credit1', $money, $name . ': ' . $money . '积分');
			}
			else {
				m('member')->setCredit($openid, 'credit1', 0 - $money, $name . '退款 : ' . (0 - $money) . '积分');
			}
		}

		return $money;
	}

	public function getPeerPay()
	{
		global $_W;
		$res = array(
			'万水千山总是情,这单帮我一定行',
			array('无名侠', '支持一下,么么哒!'),
			'self_peerpay'      => 0,
			'peerpay_price'     => 0,
			'peerpay_privilege' => 0
		);
		$data = m('common')->getPluginset('sale');
		$data = $data['peerpay'];

		if (empty($data['open'])) {
			return false;
		}

		$enough1 = empty($data['enough1']) ? array() : $data['enough1'];
		$enough2 = empty($data['enough2']) ? array() : $data['enough2'];

		if (!empty($enough1)) {
			$key = array_rand($enough1);
			$res[0] = $enough1[$key];
		}

		if (!empty($enough2)) {
			$key = array_rand($enough2);
			$res[1][0] = $enough2[$key]['enough2_1'];
			$res[1][1] = $enough2[$key]['enough2_2'];
		}

		if (!empty($data['self_peerpay'])) {
			$res['self_peerpay'] = (double) $data['self_peerpay'];
		}

		if (!empty($data['peerpay_price'])) {
			$res['peerpay_price'] = (double) $data['peerpay_price'];
			$res['peerpay_privilege'] = (double) $data['peerpay_privilege'];
		}

		return $res;
	}
}

?>
