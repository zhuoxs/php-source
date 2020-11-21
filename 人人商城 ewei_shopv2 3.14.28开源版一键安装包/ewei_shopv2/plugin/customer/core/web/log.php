<?php
//QQ63779278
global $_W;
global $_GPC;
check_shop_auth('http://120.26.212.219/api.php', $this->pluginname);
$type = intval($_GPC['type']);
$operation = empty($_GPC['op']) ? 'display' : $_GPC['op'];

if ($operation == 'display') {
	ca('creditshop.log.view' . $type);
	$pindex = max(1, intval($_GPC['page']));
	$psize = 20;
	$condition = ' and log.uniacid=:uniacid and g.type=:type and log.status>0';
	$params = array(':uniacid' => $_W['uniacid'], ':type' => $type);

	if (!empty($_GPC['keyword'])) {
		$_GPC['keyword'] = trim($_GPC['keyword']);
		$condition .= ' and ( log.logno like :keyword or log.eno like :keyword or g.title like :keyword ) ';
		$params[':keyword'] = '%' . $_GPC['keyword'] . '%';
	}

	if ($_GPC['status'] != '') {
		$condition .= ' and log.status=' . intval($_GPC['status']);
	}

	if (!empty($_GPC['realname'])) {
		$_GPC['realname'] = trim($_GPC['realname']);
		$condition .= ' and ( m.realname like :realname or m.nickname like :realname or m.mobile like :realname or a.realname like :realname or a.mobile like :realname  ) ';
		$params[':realname'] = '%' . $_GPC['realname'] . '%';
	}

	if (empty($starttime) || empty($endtime)) {
		$starttime = strtotime('-1 month');
		$endtime = time();
	}

	$searchtime = $_GPC['searchtime'];

	if (!empty($_GPC['searchtime'])) {
		$starttime = strtotime($_GPC['time']['start']);
		$endtime = strtotime($_GPC['time']['end']);

		if (!empty($searchtime)) {
			$condition .= ' AND log.createtime >= :starttime AND log.createtime <= :endtime ';
			$params[':starttime'] = $starttime;
			$params[':endtime'] = $endtime;
		}
	}

	$list = pdo_fetchall('select log.*, m.nickname,m.avatar,m.realname,m.mobile,g.title,g.thumb,g.thumb,g.credit,g.money,g.type as goodstype from ' . tablename('ewei_shop_creditshop_log') . ' log ' . ' left join ' . tablename('ewei_shop_member') . ' m on m.openid = log.openid and m.uniacid=log.uniacid' . ' left join ' . tablename('ewei_shop_member_address') . ' a on a.id = log.addressid' . ' left join ' . tablename('ewei_shop_creditshop_goods') . ' g on g.id = log.goodsid' . (' where 1 ' . $condition . ' ORDER BY log.createtime desc limit ') . ($pindex - 1) * $psize . ',' . $psize, $params);
	$total = pdo_fetchcolumn('select count(log.id) from' . tablename('ewei_shop_creditshop_log') . ' log ' . ' left join ' . tablename('ewei_shop_member') . ' m on m.openid = log.openid and m.uniacid=log.uniacid' . ' left join ' . tablename('ewei_shop_member_address') . ' a on a.id = log.addressid' . ' left join ' . tablename('ewei_shop_creditshop_goods') . ' g on g.id = log.goodsid' . (' where 1 ' . $condition), $params);

	foreach ($list as &$row) {
		$row['address'] = array();

		if (!empty($row['addressid'])) {
			$row['address'] = pdo_fetch('select realname,mobile,address,province,city,area from ' . tablename('ewei_shop_member_address') . ' where id=:id and uniacid=:uniacid limit 1', array(':id' => $row['addressid'], ':uniacid' => $_W['uniacid']));
		}

		$row['address']['logid'] = $row['id'];
		$canexchange = true;

		if ($row['status'] == 2) {
			if (empty($row['paystatus'])) {
				$canexchange = false;
			}

			if (empty($row['dispatchstatus'])) {
				$canexchange = false;
			}
		}
		else {
			$canexchange = false;
		}

		$row['canexchange'] = $canexchange;
	}

	unset($row);
	$pager = pagination($total, $pindex, $psize);
}
else if ($operation == 'detail') {
	$id = intval($_GPC['id']);
	$log = pdo_fetch('select * from ' . tablename('ewei_shop_creditshop_log') . ' where id=:id and uniacid=:uniacid limit 1', array(':id' => $id, ':uniacid' => $_W['uniacid']));

	if (empty($log)) {
		$this->message('兑换记录不存在!', referer(), 'error');
	}

	$type = $log['type'];
	ca('creditshop.log.view' . $log['type']);
	$member = m('member')->getMember($log['openid']);
	$goods = $this->model->getGoods($log['goodsid'], $member);

	if (empty($goods['id'])) {
		$this->message('商品记录不存在!', referer(), 'error');
	}

	$canexchange = true;

	if ($log['status'] == 2) {
		if (empty($log['paystatus'])) {
			$canexchange = false;
		}

		if (empty($log['dispatchstatus'])) {
			$canexchange = false;
		}
	}
	else {
		$canexchange = false;
	}

	$log['canexchange'] = $canexchange;
	$address = false;

	if (!empty($log['addressid'])) {
		$address = pdo_fetch('select id,realname,mobile,address,province,city,area from ' . tablename('ewei_shop_member_address') . ' where id=:id and uniacid=:uniacid limit 1', array(':id' => $log['addressid'], ':uniacid' => $_W['uniacid']));
	}

	$address['logid'] = $id;
}
else {
	if ($operation == 'exchange') {
		ca('creditshop.log.exchange');
		$id = intval($_GPC['id']);
		$log = pdo_fetch('select * from ' . tablename('ewei_shop_creditshop_log') . ' where id=:id and uniacid=:uniacid limit 1', array(':id' => $id, ':uniacid' => $_W['uniacid']));

		if (empty($log)) {
			$this->message('兑换记录不存在!', referer(), 'error');
		}

		if (empty($log['status'])) {
			$this->message('无效兑换记录!', referer(), 'error');
		}

		if (3 <= $log['status']) {
			$this->message('此记录已兑换过了!', referer(), 'error');
		}

		$member = m('member')->getMember($log['openid']);
		$goods = $this->model->getGoods($log['goodsid'], $member);

		if (empty($goods['id'])) {
			$this->message('商品记录不存在!', referer(), 'error');
		}

		if (!empty($goods['type'])) {
			if ($log['status'] <= 1) {
				$this->message('未中奖，不能兑换!', referer(), 'error');
			}
		}

		if (0 < $goods['money'] && empty($log['paystatus'])) {
			$this->message('未支付，无法进行兑换!', referer(), 'error');
		}

		if (0 < $goods['dispatch'] && empty($log['dispatchstatus'])) {
			$this->message('未支付运费，无法进行兑换!', referer(), 'error');
		}

		pdo_update('ewei_shop_creditshop_log', array('status' => 3, 'usetime' => time(), 'expresscom' => $_GPC['expresscom'], 'expresssn' => $_GPC['expresssn'], 'express' => $_GPC['express']), array('id' => $id));
		$this->model->sendMessage($id);
		plog('creditshop.log.exchange', '积分商城兑换 兑换记录ID: ' . $id);
		$this->message('兑换成功!', webUrl('creditshop/log', array('type' => $goods['type'])), 'success');
	}
}

load()->func('tpl');
include $this->template('log');

?>
