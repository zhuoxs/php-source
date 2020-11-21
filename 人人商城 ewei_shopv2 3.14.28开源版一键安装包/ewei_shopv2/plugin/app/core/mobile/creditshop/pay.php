<?php
if (!defined('IN_IA')) {
	exit('Access Denied');
}

require_once EWEI_SHOPV2_PLUGIN . 'app/core/page_mobile.php';
class Pay_EweiShopV2Page extends AppMobilePage
{
	public function lottery()
	{
		global $_W;
		global $_GPC;
		$number = max(1, $_GPC['num']);
		$openid = $_W['openid'];
		$uniacid = $_W['uniacid'];
		$open_redis = function_exists('redis') && !is_error(redis());

		if ($open_redis) {
			$redis_key = $_W['setting']['site']['key'] . '_' . $_W['account']['key'] . '_' . $uniacid . '_creditshop_lottery_' . $openid;
			$redis = redis();

			if (!is_error($redis)) {
				if ($redis->setnx($redis_key, time())) {
					$redis->expireAt($redis_key, time() + 2);
				}
				else {
					show_json(0, array('status' => '-1', 'message' => '操作频繁，请稍后再试!'));
				}
			}
		}

		$logid = intval($_GPC['logid']);
		$shop = m('common')->getSysset('shop');
		$member = m('member')->getMember($openid);
		$goodsid = intval($_GPC['goodsid']);
		$log = pdo_fetch('select * from ' . tablename('ewei_shop_creditshop_log') . ' where id=:id and uniacid=:uniacid limit 1', array(':id' => $logid, ':uniacid' => $uniacid));

		if (empty($log)) {
			$logno = $_GPC['logno'];
			$log = pdo_fetch('select * from ' . tablename('ewei_shop_creditshop_log') . ' where logno=:logno and uniacid=:uniacid limit 1', array(':logno' => $logno, ':uniacid' => $uniacid));
		}

		$optionid = $log['optionid'];
		$goods = p('creditshop')->getGoods($log['goodsid'], $member, $log['optionid'], $number);
		$goods['money'] *= $number;
		$goods['credit'] *= $number;
		$goods['dispatch'] = p('creditshop')->dispatchPrice($log['goodsid'], $log['addressid'], $log['optionid'], $number);
		$credit = $member['credit1'];
		$money = $member['credit2'];

		if (empty($log)) {
			show_json(0, array('status' => '-1', 'message' => '服务器错误!'));
		}

		if (empty($goods['canbuy'])) {
			show_json(0, array('status' => '-1', 'message' => $goods['buymsg']));
		}

		$update = array('couponid' => $goods['couponid']);

		if (empty($log['paystatus'])) {
			if (0 < $goods['credit'] && $credit < $goods['credit']) {
				show_json(0, array('status' => '-1', 'message' => '积分不足!'));
			}

			if (0 < $goods['money'] && $money < $goods['money'] && $log['paytype'] == 0) {
				show_json(0, array('status' => '-1', 'message' => '余额不足!'));
			}
		}

		$update['money'] = $goods['money'];
		if (0 < $goods['money'] + $goods['dispatch'] && $log['paystatus'] < 1) {
			if ($log['paytype'] == 0) {
				m('member')->setCredit($openid, 'credit2', 0 - ($goods['money'] + $goods['dispatch']), '积分商城扣除余额度 ' . $goods['money']);
				$update['paystatus'] = 1;
			}

			if ($log['paytype'] == 1) {
				$payquery = m('finance')->isWeixinPay($log['logno'], $goods['money'] + $goods['dispatch'], is_h5app() ? true : false);
				$payqueryBorrow = m('finance')->isWeixinPayBorrow($log['logno'], $goods['money'] + $goods['dispatch']);
				if (!is_error($payquery) || !is_error($payqueryBorrow)) {
					p('creditshop')->payResult($log['logno'], 'wechat', $goods['money'] + $goods['dispatch'], is_h5app() ? true : false);
				}
				else {
					show_json(0, array('status' => '-1', 'message' => '支付出错,请重试(1)!'));
				}
			}

			if ($log['paytype'] == 2) {
				if ($log['paystatus'] < 1) {
					show_json(0, array('status' => '-1', 'message' => '未支付成功!'));
				}
			}
		}

		if (0 < $goods['credit'] && empty($log['creditpay'])) {
			$update['credit'] = $goods['credit'];
			m('member')->setCredit($openid, 'credit1', 0 - $goods['credit'], '积分商城扣除积分 ' . $goods['credit']);
			$update['creditpay'] = 1;
			pdo_query('update ' . tablename('ewei_shop_creditshop_goods') . ' set joins=joins+1 where id=' . $log['goodsid']);
		}

		$status = 1;

		if ($goods['type'] == 1) {
			if (0 < $goods['rate1'] && 0 < $goods['rate2']) {
				if ($goods['rate1'] == $goods['rate2']) {
					$status = 2;
				}
				else {
					$rand = rand(0, intval($goods['rate2']));

					if ($rand <= intval($goods['rate1'])) {
						$status = 2;
					}
				}
			}
		}
		else {
			$status = 2;
		}

		if ($status == 2 && $goods['isverify'] == 1) {
			$update['eno'] = p('creditshop')->createENO();
		}

		if ($goods['isverify'] == 1) {
			$update['verifynum'] = 0 < $goods['verifynum'] ? $goods['verifynum'] : 1;

			if ($goods['isendtime'] == 0) {
				if (0 < $goods['usetime']) {
					$update['verifytime'] = time() + 3600 * 24 * intval($goods['usetime']);
				}
				else {
					$update['verifytime'] = 0;
				}
			}
			else {
				$update['verifytime'] = intval($goods['endtime']);
			}
		}

		$update['status'] = $status;
		if (0 < $goods['dispatch'] && $goods['goodstype'] == 0 && $goods['type'] == 0) {
			$update['dispatchstatus'] = '1';
			$update['dispatch'] = $goods['dispatch'];
		}

		pdo_update('ewei_shop_creditshop_log', $update, array('id' => $log['id']));
		$log = pdo_fetch('select * from ' . tablename('ewei_shop_creditshop_log') . ' where id=:id and uniacid=:uniacid limit 1', array(':id' => $logid, ':uniacid' => $uniacid));
		if ($status == 2 && $update['creditpay'] == 1) {
			if ($goods['goodstype'] == 1) {
				if (com('coupon')) {
					com('coupon')->creditshop($logid);
					$status = 3;
				}

				$update['time_finish'] = time();
			}
			else if ($goods['goodstype'] == 2) {
				$credittype = 'credit2';
				$creditstr = '积分商城兑换余额';
				$num = abs($goods['grant1']) * intval($log['goods_num']);
				$member = m('member')->getMember($openid);
				$credit2 = floatval($member['credit2']) + $num;
				m('member')->setCredit($openid, $credittype, $num, array($_W['uid'], $creditstr));
				$set = m('common')->getSysset('shop');
				$logno = m('common')->createNO('member_log', 'logno', 'RC');
				$data = array('openid' => $openid, 'logno' => $logno, 'uniacid' => $_W['uniacid'], 'type' => '0', 'createtime' => TIMESTAMP, 'status' => '1', 'title' => $set['name'] . '积分商城兑换余额', 'money' => $num, 'remark' => $creditstr, 'rechargetype' => 'creditshop');
				pdo_insert('ewei_shop_member_log', $data);
				$mlogid = pdo_insertid();
				m('notice')->sendMemberLogMessage($mlogid);
				plog('finance.recharge.' . $credittype, '充值' . $creditstr . ': ' . $num . ' <br/>会员信息: ID: ' . $member['id'] . ' /  ' . $member['openid'] . '/' . $member['nickname'] . '/' . $member['realname'] . '/' . $member['mobile']);
				$status = 3;
				$update['time_finish'] = time();
			}
			else {
				if ($goods['goodstype'] == 3) {
				}
			}

			$update['status'] = $status;
			pdo_update('ewei_shop_creditshop_log', $update, array('id' => $logid));
			p('creditshop')->sendMessage($logid);

			if ($status == 3) {
				pdo_query('update ' . tablename('ewei_shop_creditshop_goods') . ' set total=total-' . $number . ' where id=' . $log['goodsid']);
			}

			if ($goods['goodstype'] == 0 && $status == 2) {
				pdo_query('update ' . tablename('ewei_shop_creditshop_goods') . ' set total=total-' . $number . ' where id=' . $log['goodsid']);
			}

			if ($goods['goodstype'] == 3 && $status == 2) {
				pdo_query('update ' . tablename('ewei_shop_creditshop_goods') . ' set packetsurplus=packetsurplus-' . $number . ' where id=' . $log['goodsid']);
			}

			if ($goods['hasoption'] && $log['optionid']) {
				pdo_query('update ' . tablename('ewei_shop_creditshop_option') . ' set total=total-' . $number . ' where id=' . $log['optionid']);
			}
		}

		show_json(1, array('status' => $status, 'goodstype' => $goods['goodstype']));
	}
}

?>
