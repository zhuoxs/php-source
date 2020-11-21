<?php
//QQ63779278
if (!defined('IN_IA')) {
	exit('Access Denied');
}

global $_W;
global $_GPC;
$operation = !empty($_GPC['op']) ? $_GPC['op'] : 'display';
$openid = m('user')->getOpenid();
$member = m('member')->getMember($openid);
$shop = m('common')->getSysset('shop');
$uniacid = $_W['uniacid'];

if ($_W['isajax']) {
	if ($operation == 'display') {
		$pindex = max(1, intval($_GPC['page']));
		$psize = 10;
		$condition = ' and log.openid=:openid and log.status>0 and  log.uniacid = :uniacid';
		$params = array(':uniacid' => $_W['uniacid'], ':openid' => $openid);
		$sql = 'SELECT COUNT(*) FROM ' . tablename('ewei_shop_creditshop_log') . (' log where 1 ' . $condition);
		$total = pdo_fetchcolumn($sql, $params);
		$list = array();

		if (!empty($total)) {
			$sql = 'SELECT log.id,log.goodsid,log.status,log.eno,log.paystatus,g.title,g.type,g.thumb,g.credit,g.money FROM ' . tablename('ewei_shop_creditshop_log') . ' log ' . ' left join ' . tablename('ewei_shop_creditshop_goods') . ' g on log.goodsid = g.id ' . ' where 1 ' . $condition . ' ORDER BY log.createtime DESC LIMIT ' . ($pindex - 1) * $psize . ',' . $psize;
			$list = pdo_fetchall($sql, $params);
			$list = set_medias($list, 'thumb');

			foreach ($list as &$row) {
				if (0 < $row['credit'] & 0 < $row['money']) {
					$row['acttype'] = 0;
				}
				else if (0 < $row['credit']) {
					$row['acttype'] = 1;
				}
				else {
					if (0 < $row['money']) {
						$row['acttype'] = 2;
					}
				}
			}

			unset($row);
		}

		show_json(1, array('total' => $total, 'list' => $list, 'pagesize' => $psize));
	}
	else if ($operation == 'detail') {
		$id = intval($_GPC['id']);
		$log = pdo_fetch('select * from ' . tablename('ewei_shop_creditshop_log') . ' where id=:id and openid=:openid and uniacid=:uniacid limit 1', array(':id' => $id, ':openid' => $openid, ':uniacid' => $uniacid));

		if (empty($log)) {
			show_json(-1, '兑换记录不存在!');
		}

		$goods = $this->model->getGoods($log['goodsid'], $member);

		if (empty($goods['id'])) {
			show_json(-1, '商品记录不存在!');
		}

		$address = false;

		if (!empty($log['addressid'])) {
			$address = pdo_fetch('select id,realname,mobile,address,province,city,area from ' . tablename('ewei_shop_member_address') . ' where id=:id and openid=:openid and uniacid=:uniacid limit 1', array(':id' => $log['addressid'], ':uniacid' => $uniacid, ':openid' => $openid));
		}

		$goods['currenttime'] = time();
		show_json(1, array('log' => $log, 'goods' => $goods, 'address' => $address));
	}
	else {
		if ($operation == 'paydispatch' && $_W['ispost']) {
			$id = intval($_GPC['id']);
			$addressid = intval($_GPC['addressid']);
			$log = pdo_fetch('select * from ' . tablename('ewei_shop_creditshop_log') . ' where id=:id and openid=:openid and uniacid=:uniacid limit 1', array(':id' => $id, ':openid' => $openid, ':uniacid' => $uniacid));

			if (empty($log)) {
				show_json(0, '兑换记录不存在!');
			}

			$goods = $this->model->getGoods($log['goodsid'], $member);

			if (empty($goods['id'])) {
				show_json(0, '商品记录不存在!');
			}

			if (!empty($goods['isendtime'])) {
				if ($goods['endtime'] < time()) {
					show_json(0, '商品已过期!');
				}
			}

			if ($goods['dispatch'] <= 0) {
				pdo_update('ewei_shop_creditshop_log', array('dispatchstatus' => 1, 'addressid' => $addressid), array('id' => $log['id']));
				show_json(1, array('logid' => $logid));
			}

			if (!empty($log['dispatchstatus'])) {
				show_json(0, '商品已支付运费!');
			}

			$set = m('common')->getSysset();
			$set['pay']['weixin'] = !empty($set['pay']['weixin_sub']) ? 1 : $set['pay']['weixin'];
			$set['pay']['weixin_jie'] = !empty($set['pay']['weixin_jie_sub']) ? 1 : $set['pay']['weixin_jie'];

			if (!is_weixin()) {
				show_json(0, '非微信环境!');
			}

			if (empty($set['pay']['weixin'])) {
				show_json(0, '未开启微信支付!');
			}

			$wechat = array('success' => false);
			$dispatchno = $log['dispatchno'];

			if (empty($dispatchno)) {
				if (empty($goods['type'])) {
					$dispatchno = str_replace('EE', 'EP', $log['logno']);
				}
				else {
					$dispatchno = str_replace('EL', 'EP', $log['logno']);
				}

				pdo_update('ewei_shop_creditshop_log', array('dispatchno' => $dispatchno, 'addressid' => $addressid), array('id' => $log['id']));
			}

			$params = array();
			$params['tid'] = $dispatchno;
			$params['user'] = $openid;
			$params['fee'] = $goods['dispatch'];
			$params['title'] = $set['shop']['name'] . (empty($goods['type']) ? '积分兑换' : '积分抽奖') . ' 支付运费单号:' . $dispatchno;
			load()->model('payment');
			$setting = uni_setting($_W['uniacid'], array('payment'));
			$options = array();

			if (is_array($setting['payment'])) {
				$options = $setting['payment']['wechat'];
				$options['appid'] = $_W['account']['key'];
				$options['secret'] = $_W['account']['secret'];
			}

			$wechat = m('common')->wechat_build($params, $options, 3);
			$wechat['success'] = false;

			if (!is_error($wechat)) {
				$wechat['success'] = true;
			}

			if (!$wechat['success']) {
				show_json(0, '微信支付参数错误!');
			}

			show_json(1, array('logid' => $logid, 'wechat' => $wechat));
		}
		else {
			if ($operation == 'payresult' && $_W['ispost']) {
				$id = intval($_GPC['id']);
				$log = pdo_fetch('select * from ' . tablename('ewei_shop_creditshop_log') . ' where id=:id and openid=:openid and uniacid=:uniacid limit 1', array(':id' => $id, ':openid' => $openid, ':uniacid' => $uniacid));

				if (empty($log)) {
					show_json(0, '兑换记录不存在!');
				}

				$goods = $this->model->getGoods($log['goodsid'], $member);

				if (empty($goods['id'])) {
					show_json(0, '商品记录不存在!');
				}

				$this->model->sendMessage($id);
				show_json(1);
			}
		}
	}
}

$_W['shopshare'] = array('title' => $this->set['share_title'], 'imgUrl' => tomedia($this->set['share_icon']), 'link' => mobileUrl('creditshop'), 'desc' => $this->set['share_desc']);
$com = p('commission');

if ($com) {
	$cset = $com->getSet();

	if (!empty($cset)) {
		if ($member['isagent'] == 1 && $member['status'] == 1) {
			$_W['shopshare']['link'] = mobileUrl('creditshop', array('mid' => $member['id']));
			if (empty($cset['become_reg']) && (empty($member['realname']) || empty($member['mobile']))) {
				$trigger = true;
			}
		}
		else {
			if (!empty($_GPC['mid'])) {
				$_W['shopshare']['link'] = mobileUrl('creditshop/detail', array('mid' => $_GPC['mid']));
			}
		}
	}
}

if ($operation == 'display') {
	include $this->template('log');
	return 1;
}

if ($operation == 'detail') {
	include $this->template('log_detail');
}

?>
