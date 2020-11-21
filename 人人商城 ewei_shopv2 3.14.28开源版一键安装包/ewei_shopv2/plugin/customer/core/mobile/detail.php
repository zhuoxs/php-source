<?php
//QQ63779278
global $_W;
global $_GPC;
$operation = !empty($_GPC['op']) ? $_GPC['op'] : 'display';
$openid = m('user')->getOpenid();
$uniacid = $_W['uniacid'];
$id = intval($_GPC['id']);
$shop = m('common')->getSysset('shop');
$member = m('member')->getMember($openid);
$goods = $this->model->getGoods($id, $member);
$credit = $member['credit1'];
$money = $member['credit2'];

if ($_W['isajax']) {
	if ($operation == 'display') {
		if (!empty($goods)) {
			pdo_update('ewei_shop_creditshop_goods', array('views' => $goods['views'] + 1), array('id' => $id));
		}

		show_json(1, array('followed' => m('user')->followed($openid), 'creditstr' => number_format(intval($credit), 0), 'credit' => intval($credit), 'moneystr' => number_format(intval($money), 2), 'money' => $money, 'goods' => $goods));
	}
	else {
		if ($operation == 'pay' && $_W['ispost']) {
			if (empty($goods['canbuy'])) {
				show_json(0, $goods['buymsg']);
			}

			$needpay = false;

			if (0 < $goods['money']) {
				pdo_delete('ewei_shop_creditshop_log', array('goodsid' => $id, 'openid' => $openid, 'status' => 0, 'paystatus' => 0));
				$needpay = true;
				$lastlog = pdo_fetch('select * from ' . tablename('ewei_shop_creditshop_log') . ' where goodsid=:goodsid and openid=:openid  and status=0 and paystatus=1 and uniacid=:uniacid limit 1', array(':goodsid' => $id, ':openid' => $openid, ':uniacid' => $uniacid));

				if (!empty($lastlog)) {
					show_json(1, array('logid' => $lastlog['id']));
				}
			}
			else {
				pdo_delete('ewei_shop_creditshop_log', array('goodsid' => $id, 'openid' => $openid, 'status' => 0));
			}

			$log = array('uniacid' => $uniacid, 'openid' => $openid, 'logno' => m('common')->createNO('creditshop_log', 'logno', empty($goods['type']) ? 'EE' : 'EL'), 'goodsid' => $id, 'status' => 0, 'paystatus' => 0 < $goods['money'] ? 0 : -1, 'dispatchstatus' => $goods['isverify'] == 1 ? -1 : 0, 'createtime' => time());

			if (empty($goods['type'])) {
				$log['eno'] = $this->model->createENO();
			}

			pdo_insert('ewei_shop_creditshop_log', $log);
			$logid = pdo_insertid();

			if ($needpay) {
				$useweixin = true;

				if (!empty($goods['usecredit2'])) {
					if ($goods['money'] < $money) {
						$useweixin = false;
					}
				}

				pdo_update('ewei_shop_creditshop_log', array('paytype' => $useweixin ? 1 : 0), array('id' => $logid));

				if ($useweixin) {
					$set = m('common')->getSysset();

					if (!is_weixin()) {
						show_json(0, '非微信环境!');
					}

					if (empty($set['pay']['weixin'])) {
						show_json(0, '未开启微信支付!');
					}

					$wechat = array('success' => false);
					$params = array();
					$params['tid'] = $log['logno'];
					$params['user'] = $openid;
					$params['fee'] = $goods['money'];
					$params['title'] = $set['shop']['name'] . (empty($goods['type']) ? '积分兑换' : '积分抽奖') . ' 单号:' . $log['logno'];
					load()->model('payment');
					$setting = uni_setting($_W['uniacid'], array('payment'));
					$options = array();

					if (is_array($setting['payment'])) {
						$options = $setting['payment']['wechat'];
						$options['appid'] = $_W['account']['key'];
						$options['secret'] = $_W['account']['secret'];
					}

					$wechat = m('common')->wechat_build($params, $options, 2);
					$wechat['success'] = false;

					if (!is_error($wechat)) {
						$wechat['success'] = true;
					}

					if (!$wechat['success']) {
						show_json(0, '微信支付参数错误!');
					}

					show_json(1, array('logid' => $logid, 'wechat' => $wechat));
				}
			}

			show_json(1, array('logid' => $logid));
		}
		else {
			if ($operation == 'lottery' && $_W['ispost']) {
				$logid = intval($_GPC['logid']);
				$log = pdo_fetch('select * from ' . tablename('ewei_shop_creditshop_log') . ' where id=:id and uniacid=:uniacid limit 1', array(':id' => $logid, ':uniacid' => $uniacid));

				if (empty($log)) {
					show_json(-1, '服务器错误!');
				}

				if (1 <= $log['status']) {
					show_json(-1, '此记录已作废!');
				}

				if (empty($goods['canbuy'])) {
					show_json(-1, $goods['buymsg']);
				}

				pdo_update('ewei_shop_creditshop_goods', array('joins' => $goods['joins'] + 1), array('id' => $id));
				$upgrade = array();
				if (0 < $goods['credit'] && empty($log['creditpay'])) {
					m('member')->setCredit($openid, 'credit1', 0 - $goods['credit'], '积分商城抽奖扣除积分 ' . $goods['credit']);
					$update['creditpay'] = 1;
				}

				if (0 < $goods['money'] && empty($log['paystatus'])) {
					if ($goods['paytype'] == 0) {
						m('member')->setCredit($openid, 'credit2', 0 - $goods['money'], '积分商城抽奖扣除余额度 ' . $goods['credit']);
					}

					$update['paystatus'] = 1;
				}

				$status = 1;

				if (!empty($goods['type'])) {
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

					if ($status == 2) {
						$update['eno'] = $this->model->createENO();
					}
				}
				else {
					$status = 2;
				}

				$update['status'] = $status;
				pdo_update('ewei_shop_creditshop_log', $update, array('id' => $logid));

				if ($status == 2) {
					$this->model->sendMessage($logid);
				}

				show_json($status);
			}
		}
	}
}

$_W['shopshare'] = array('title' => !empty($goods['share_title']) ? $goods['share_title'] : $goods['title'], 'imgUrl' => !empty($goods['share_icon']) ? tomedia($goods['share_icon']) : tomedia($goods['thumb']), 'link' => mobileUrl('creditshop/detail', array('id' => $id)), 'desc' => !empty($goods['share_desc']) ? $goods['share_desc'] : $goods['title']);
$com = p('commission');

if ($com) {
	$cset = $com->getSet();

	if (!empty($cset)) {
		if ($member['isagent'] == 1 && $member['status'] == 1) {
			$_W['shopshare']['link'] = mobileUrl('creditshop/detail', array('id' => $id, 'mid' => $member['id']));
			if (empty($cset['become_reg']) && (empty($member['realname']) || empty($member['mobile']))) {
				$trigger = true;
			}
		}
		else {
			if (!empty($_GPC['mid'])) {
				$_W['shopshare']['link'] = mobileUrl('creditshop/detail', array('id' => $id, 'mid' => $_GPC['mid']));
			}
		}
	}
}

include $this->template('detail');

?>
