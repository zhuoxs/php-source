<?php
$op = !empty($op) ? $op : 'account_display';
$ops = array('display', 'search', 'edit', 'delete', 'account_display', 'data_record', 'account', 'record', 'permissions', 'merchantAccount', 'merchantApply', 'cover');

if ($op == 'display') {
	$id = $_GPC['id'];
	$merchant = model_merchant::getSingleMerchant($id, '*');
	$account = pdo_fetch("SELECT amount,no_money,no_money_doing FROM " . tablename('tg_merchant_account') . " WHERE uniacid = {$_W['uniacid']} and merchantid={$id}");
	$records = pdo_fetchall("SELECT * FROM " . tablename('tg_merchant_record') . " WHERE uniacid = {$_W['uniacid']} and merchantid={$id}");
	$rm = $delivery = 0;
	foreach ($records as $key => $val) {
		$rm += $val['money'];
	}
	$orders = pdo_fetchall('select price,status,pay_type from' . tablename('tg_order') . 'where merchantid=' . $id . ' and status in(1,2,3,4,6)');
	$km = 0;
	$zm = 0;
	foreach ($orders as $ke => $va) {
		if ($va['pay_type'] == 4)
			$delivery += $va['price'];
		if (in_array($va['status'], array(3, 4)))
			$km += $va['price'];
		$zm += $va['price'];
	}

	$am = $km - $rm;
	$am = $am > 0 ? $am : 0;
	if ($_GPC['submit']) {
		if (pdo_update('tg_merchant_account', array('no_money' => $_GPC['no_money'], 'amount' => $_GPC['amount']), array('merchantid' => $id)))
			message('成功', referer(), 'success');
		message('失败', referer(), 'error');
	}
	include  wl_template('application/merchant/updateData');
}
if ($op == 'search') {//选择通知管理员
	$con = $con2 = "uniacid='{$_W['uniacid']}' ";
	$keyword = $_GPC['keyword'];
	$type = $_GPC['t'];
	if ($keyword != '') {
		$con .= " and nickname LIKE '%{$keyword}%' or uid  LIKE '%{$keyword}%' or openid LIKE '%{$keyword}%'";
		$con2 .= " and nickname LIKE '%{$keyword}%' or uid  LIKE '%{$keyword}%'";
	}
	$ds = pdo_fetchall("select * from" . tablename('tg_member') . "where $con");
	if (empty($ds)) {
		$ds = pdo_fetchall("select * from" . tablename('mc_members') . "where $con2");
	}
	//		wl_debug($ds);
	include  wl_template('application/merchant/select_merchanter');
	exit ;
}
if ($op == 'edit') {//商家编辑
	$id = intval($_GPC['id']);
	if (!empty($id)) {
		$merchant = model_merchant::getSingleMerchant($id, '*');
		$saler = pdo_fetch("select * from" . tablename('tg_member') . "where uniacid={$_W['uniacid']} and openid='{$merchant['openid']}'");
		$messagesaler = pdo_fetch("select * from" . tablename('tg_member') . "where uniacid={$_W['uniacid']} and openid='{$merchant['messageopenid']}'");
		if (empty($merchant))
			message('商家信息不存在', web_url('application/merchant', array('op' => 'display')), 'success');
		$merchant['tag'] = unserialize($merchant['tag']);
		//wl_debug($merchant);
	}

	if (checksubmit()) {
		$data = $_GPC['merchant'];
		// 获取打包值
		$data_img = $_GPC['data_img'];
		$data_tag = $_GPC['data_tag'];
		$data_status = $_GPC['data_status'];
		$len = count($data_img);
		$data['tag'] = array();
		for ($k = 0; $k < $len; $k++) {
			$data['tag'][$k]['data_img'] = $data_img[$k];
			$data['tag'][$k]['data_tag'] = $data_tag[$k];
			$data['tag'][$k]['data_status'] = $data_status[$k];
		}
		$data['tag'] = serialize($data['tag']);
		$data['detail'] = htmlspecialchars_decode($data['detail']);
		$data['openid'] = $_GPC['openid'];
		$data['messageopenid'] = $_GPC['messageopenid'];
		$data['allsalenum'] = intval($data['salenum']) + $data['falsenum'];
		$data['lng'] = $_GPC['map']['lng'];
		$data['lat'] = $_GPC['map']['lat'];

		if (empty($merchant)) {
			$data['uniacid'] = $_W['uniacid'];
			$data['createtime'] = TIMESTAMP;

			if ($data['open'] == 1) {
				load() -> model('user');
				if (!preg_match(REGULAR_USERNAME, $data['uname'])) {
					message('必须输入用户名，格式为 3-15 位字符，可以包括汉字、字母（不区分大小写）、数字、下划线和句点。');
				}
				if (user_check(array('username' => $data['uname']))) {
					message('非常抱歉，此用户名已经被注册，你需要更换注册名称！');
				} else {
					$tpwd = trim($_GPC['tpwd']);
					$data['password'] = trim($data['password']);
					if (empty($data['password']) || empty($tpwd)) {
						message('密码不能为空！');
						exit ;
					}
					if ($data['password'] != $tpwd) {
						message('两次密码输入不一致！');
						exit ;
					}
					if (istrlen($data['password']) < 8) {
						message('必须输入密码，且密码长度不得低于8位。');
						exit ;
					}
				}
			}
			$ret = pdo_insert('tg_merchant', $data);
		} else {

			$user = pdo_fetch("select * from" . tablename("users") . "where uid=:uid", array(':uid' => $merchant['uid']));
			$opwd = trim($_GPC['opwd']);
			$npwd = trim($_GPC['npwd']);
			$tpwd = trim($_GPC['tpwd']);
			if ($data['open'] == 2) {
				$ret = pdo_update('users', array('status' => 1), array('uid' => $merchant['uid']));
			} else {
				if (empty($npwd) || empty($tpwd)) {
				} else {
					if ($npwd != $tpwd) {
						message('两次密码输入不一致！');
						exit ;
					}
					if (istrlen($npwd) < 8) {
						message('必须输入密码，且密码长度不得低于8位。');
						exit ;
					}
					load() -> model('user');
					$p = user_hash($npwd, $user['salt']);
					$data['password'] = $npwd;
				}

			}
			$ret = pdo_update('tg_merchant', $data, array('id' => $id));
			$ret = pdo_update('users', array('password' => $npwd, 'status' => 2), array('uid' => $merchant['uid']));
		}
		message('商家信息保存成功', web_url('application/merchant', array('op' => 'account_display', 'id' => $id)), 'success');
	}

	include  wl_template('application/merchant/merchant_list');
}
if ($op == 'delete') {//删除商家
	$id = intval($_GPC['id']);
	$merchant = model_merchant::getSingleMerchant($id, 'uid');
	if (empty($id))
		message('商家不存在');
	if (pdo_delete('tg_merchant', array('id' => $id, 'uniacid' => $_W['uniacid']))) {
		pdo_delete('users', array('uid' => $merchant['uid']));
		message('删除商家成功.', web_url('application/merchant'), 'success');
	} else {
		message('删除商家失败.');
	}
}
if ($op == 'account_display') {//可结算商家列表
	$pindex = max(1, intval($_GPC['page']));
	$psize = 15;
	$where = array();
	if ($_GPC['keyword'])
		$where['id^name^linkman_name^linkman_mobile'] = $_GPC['keyword'];
	$merchantsData = Util::getNumData('*', 'tg_merchant', $where, 'id desc', $pindex, $psize, 1);
	$merchants = $merchantsData[0];
	$pager = $merchantsData[1];

	foreach ($merchants as $key => $value) {
		$account = pdo_fetch("SELECT amount,no_money FROM " . tablename('tg_merchant_account') . " WHERE uniacid = {$_W['uniacid']} and merchantid={$value['id']}");
		$merchants[$key]['amount'] = $account['amount'];
		$merchants[$key]['no_money'] = $account['no_money'];
		$delivery = 0;
		$orders = pdo_fetchall("select price,pay_type from" . tablename('tg_order') . "where merchantid={$value['id']} and status in(3,4,6)");
		foreach ($orders as $ke => $va) {
			if ($va['pay_type'] == 4)
				$delivery += $va['price'];
		}
		$merchants[$key]['delivery'] = $delivery;
	}
	include  wl_template('application/merchant/account');
}

if ($op == 'data_record') {//金额变动记录
	$id = $_GPC['id'];
	$merchant = model_merchant::getSingleMerchant($id, 'thumb,name,openid,percent');
	$account = pdo_fetch("SELECT * FROM " . tablename('tg_merchant_account') . " WHERE uniacid = {$_W['uniacid']} and merchantid={$id}");

	$merchant['amount'] = $account['amount'];
	$merchant['no_money'] = $account['no_money'];
	$pindex = max(1, intval($_GPC['page']));
	$psize = 15;
	$moneyRecordData = model_merchant::getMoneyRecord($id, $pindex, $psize, 1);
	$moneyRecord = $moneyRecordData[0];
	$pager = $moneyRecordData[1];
	foreach ($moneyRecord as &$item) {
		if ($item['orderid'])
			$item['order'] = model_order::getSingleOrder($item['orderid'], '*');
	}
	include  wl_template('application/merchant/account');
}

if ($op == 'account') {//结算操作
	$id = $_GPC['id'];
	$_GPC['accountType'] = $_GPC['accountType'] ? $_GPC['accountType'] : 'weixin';
	$merchant = model_merchant::getSingleMerchant($id, '*');
	$account = pdo_fetch("SELECT amount,no_money,no_money_doing FROM " . tablename('tg_merchant_account') . " WHERE uniacid = {$_W['uniacid']} and merchantid={$id}");
	$merchant['amount'] = $account['amount'];
	$merchant['no_money'] = $account['no_money'];
	$merchant['no_money_doing'] = $account['no_money_doing'];
	if (checksubmit('submit') && $_GPC['accountType'] == 'weixin') {
		/*先判断是否有正在申请中的结算申请*/
		if ($account['no_money_doing'] > 0)
			message('上一笔申请未处理完成，不可重复操作！', referer(), 'error');
		/*先判断是否有正在申请中的结算申请*/
		if (empty($merchant['openid']))
			message('您未绑定提现微信号！', referer(), 'error');
		$money = $_GPC['money'];
		$mm = $money;
		//输入的结算金额（元）
		if (!empty($merchant['percent']))
			$money = (1 - $merchant['percent'] * 0.01) * $money;
		else
			$money = $money;
		$no_money = model_merchant::getNoSettlementMoney($id);
		//未结算金额
		if (is_numeric($money)) {
			$money = sprintf("%.2f", $money);
			if ($money < 1)
				message('到账金额需要大于1元！', referer(), 'error');
			if ($no_money < $money)
				message('您没有足够的可结算金额！', referer(), 'error');
			if (MERCHANTID) {
				pdo_update('tg_merchant_account', array('no_money_doing' => $money), array('merchantid' => $id));
				pdo_insert("tg_merchant_record", array('status' => 1, 'updatetime' => TIMESTAMP, 'percent' => $merchant['percent'], 'get_money' => $money, 'merchantid' => $id, 'money' => $mm, 'uid' => $_W['uid'], 'createtime' => TIMESTAMP, 'uniacid' => $_W['uniacid'], 'orderno' => date('Ymd') . substr(time(), -5) . substr(microtime(), 2, 5) . sprintf('%02d', rand(0, 99))));
			} else {
				$result = model_merchant::finance($merchant['openid'], $money * 100, '商家提现');
				//结算操作
				if ($result['return_code'] != 'SUCCESS' || $result['result_code'] != 'SUCCESS') {
					message('微信钱包提现失败: ' . $result['err_code'] . "|" . $result['err_code_des'], '', 'error');
					// 结算失败
				} else {//结算成功
					pdo_insert("tg_merchant_money_record", array('merchantid' => $id, 'uniacid' => $_W['uniacid'], 'money' => 0 - $mm, 'orderid' => '', 'createtime' => TIMESTAMP, 'type' => 4, 'detail' => '商家结算'));
					$res = model_merchant::updateNoSettlementMoney(0 - $mm, $id);
					if ($res == 'success') {
						pdo_update('tg_merchant_account', array('no_money_doing' => 0), array('merchantid' => $id));
						pdo_insert("tg_merchant_record", array('type' => 1, 'status' => 3, 'updatetime' => TIMESTAMP, 'percent' => $merchant['percent'], 'get_money' => $money, 'merchantid' => $id, 'money' => $mm, 'uid' => $_W['uid'], 'createtime' => TIMESTAMP, 'uniacid' => $_W['uniacid'], 'orderno' => date('Ymd') . substr(time(), -5) . substr(microtime(), 2, 5) . sprintf('%02d', rand(0, 99))));
					} else {
						message($res, '', 'error');
						// 结算失败
					}
				}
			}
		} else {
			message('结算金额输入错误！', referer(), 'error');
		}
		message('操作成功！', referer(), 'success');
	}
	if (checksubmit('submit') && $_GPC['accountType'] == 'f2f') {
		/*先判断是否有正在申请中的结算申请*/
		if ($account['no_money_doing'] > 0)
			message('上一笔申请未处理完成，不可重复操作！', referer(), 'error');
		$money = $_GPC['money'];
		$mm = $money;
		//输入的结算金额（元）
		if (!empty($merchant['percent']))
			$money = (1 - $merchant['percent'] * 0.01) * $money;
		else
			$money = $money;
		$no_money = model_merchant::getNoSettlementMoney($id);
		//未结算金额
		if (is_numeric($money)) {
			if ($money < 1)
				message('到账金额需要大于1元！', referer(), 'error');
			if ($no_money < $money)
				message('您没有足够的可结算金额！', referer(), 'error');
			//结算成功
			pdo_insert("tg_merchant_money_record", array('merchantid' => $id, 'uniacid' => $_W['uniacid'], 'money' => 0 - $mm, 'orderid' => '', 'createtime' => TIMESTAMP, 'type' => 4, 'detail' => '商家结算'));
			if (model_merchant::updateNoSettlementMoney(0 - $mm, $id)) {
				pdo_update('tg_merchant_account', array('no_money_doing' => 0), array('merchantid' => $id));
				pdo_insert("tg_merchant_record", array('type' => 2, 'status' => 3, 'updatetime' => TIMESTAMP, 'percent' => $merchant['percent'], 'get_money' => $money, 'merchantid' => $id, 'money' => $mm, 'uid' => $_W['uid'], 'createtime' => TIMESTAMP, 'uniacid' => $_W['uniacid'], 'orderno' => date('Ymd') . substr(time(), -5) . substr(microtime(), 2, 5) . sprintf('%02d', rand(0, 99))));
			}

		} else {
			message('结算金额输入错误！', referer(), 'error');
		}
		message('操作成功！', referer(), 'success');
	}
	include  wl_template('application/merchant/account');
}

if ($op == 'record') {//结算记录
	$id = $_GPC['id'];
	$merchant = model_merchant::getSingleMerchant($id, 'thumb,name,openid,percent');
	$account = pdo_fetch("SELECT * FROM " . tablename('tg_merchant_account') . " WHERE uniacid = {$_W['uniacid']} and merchantid={$id}");
	$merchant['amount'] = $account['amount'];
	$merchant['no_money'] = $account['no_money'];
	$merchant['no_money_doing'] = $account['no_money_doing'];
	$list = pdo_fetchall("select * from" . tablename('tg_merchant_record') . "where merchantid='{$id}' and uniacid={$_W['uniacid']} ");
	include  wl_template('application/merchant/account');
}

if ($op == 'permissions') {//权限
	$id = intval($_GPC['id']);
	$nodes = pdo_fetchall("select * from" . tablename('tg_user_node') . " where status=2 and do_id=0");
	foreach ($nodes as $key => &$value) {
		$value['children'] = pdo_fetchall("select * from" . tablename('tg_user_node') . " where status=2 and do_id={$value['id']} and ac_id=0");
		foreach ($value['children'] as $k => &$v) {
			$v['children'] = pdo_fetchall("select * from" . tablename('tg_user_node') . " where status=2 and do_id={$value['id']} and ac_id={$v['id']}");
		}
	}
	$role = pdo_fetch("select * from" . tablename('tg_user_role') . "where uniacid={$_W['uniacid']} and merchantid={$id}");
	if (checksubmit('submit')) {
		$nodes = $_GPC['node_ids'];
		$nodes = serialize($nodes);
		$data = array('merchantid' => $id, 'nodes' => $nodes, 'uniacid' => $_W['uniacid']);
		if ($role) {
			pdo_update('tg_user_role', $data, array('merchantid' => $id));
		} else {
			pdo_insert('tg_user_role', $data);
		}
		message('保存成功！', referer(), 'success');
	}
	$role = pdo_fetch("select * from" . tablename('tg_user_role') . "where uniacid={$_W['uniacid']} and merchantid={$id}");
	if ($role) {
		$role['node_ids'] = unserialize($role['nodes']);
	}
	include  wl_template('application/merchant/permissions');
}

if ($op == 'merchantAccount') {//商户中心（商家登陆可见）
	if (!MERCHANTID)
		message('非法入口!');
	header('Location:' . web_url('application/merchant/data_record', array('id' => MERCHANTID)));
}

if ($op == 'merchantApply') {//提现申请
	$status = $_GPC['status'] ? $_GPC['status'] : 1;
	if ($_GPC['id']) {
		$record = pdo_fetch("select merchantid,money from" . tablename('tg_merchant_record') . "where  uniacid={$_W['uniacid']} and id={$_GPC['id']}");
		$merchant = model_merchant::getSingleMerchant($record['merchantid'], '*');
		if ($_GPC['type'] == 1) {
			pdo_update('tg_merchant_record', array('status' => 2, 'updatetime' => TIMESTAMP), array('id' => $_GPC['id']));
		} elseif ($_GPC['type'] == 2) {//打款到微信钱包
			if (empty($merchant['openid']))
				message('您未绑定提现微信号！', referer(), 'error');
			$money = $record['money'];
			$mm = $money;
			//输入的结算金额（元）
			if (!empty($merchant['percent']))
				$money = (1 - $merchant['percent'] * 0.01) * $money;
			else
				$money = $money;
			$no_money = model_merchant::getNoSettlementMoney($record['merchantid']);
			//未结算金额

			if (!is_numeric($money))
				message('金额错误！', referer(), 'error');
			if ($money < 1)
				message('到账金额需要大于1元！', referer(), 'error');
			if ($no_money < $money)
				message('您没有足够的可结算金额！', referer(), 'error');

			$result = model_merchant::finance($merchant['openid'], $money * 100, '商家提现');
			//结算操作
			if (is_error($result)) {
				message('微信钱包提现失败: ' . $result['message'], '', 'error');
				// 结算失败
			} else {
				pdo_update('tg_merchant_account', array('no_money_doing' => 0), array('merchantid' => $record['merchantid']));
				pdo_insert("tg_merchant_money_record", array('merchantid' => $record['merchantid'], 'uniacid' => $_W['uniacid'], 'money' => 0 - $mm, 'orderid' => '', 'createtime' => TIMESTAMP, 'type' => 4, 'detail' => '商家结算'));
				$res = model_merchant::updateNoSettlementMoney(0 - $mm, $record['merchantid']);
				if ($res) {
					pdo_update('tg_merchant_record', array('status' => 3, 'updatetime' => TIMESTAMP, 'type' => 1), array('id' => $_GPC['id']));
				} else {
					message('打款成功，更新结算金额失败！', referer(), 'success');
				}

			}
			message('打款成功！', referer(), 'success');
		} elseif ($_GPC['type'] == 3) {//手动处理，不打款
			$money = $record['money'];
			$mm = $money;
			//输入的结算金额（元）
			if (!empty($merchant['percent']))
				$money = (1 - $merchant['percent'] * 0.01) * $money;
			else
				$money = $money;
			$no_money = model_merchant::getNoSettlementMoney($record['merchantid']);
			//未结算金额
			if (!is_numeric($money))
				message('金额错误！', referer(), 'error');
			if ($money < 1)
				message('到账金额需要大于1元！', referer(), 'error');
			if ($no_money < $money)
				message('您没有足够的可结算金额！', referer(), 'error');

			pdo_update('tg_merchant_account', array('no_money_doing' => 0), array('merchantid' => $record['merchantid']));

			pdo_insert("tg_merchant_money_record", array('merchantid' => $record['merchantid'], 'uniacid' => $_W['uniacid'], 'money' => 0 - $mm, 'orderid' => '', 'createtime' => TIMESTAMP, 'type' => 4, 'detail' => '商家结算'));
			if (model_merchant::updateNoSettlementMoney(0 - $mm, $record['merchantid']))//更新结算后商家可结算余额
				pdo_update('tg_merchant_record', array('status' => 3, 'updatetime' => TIMESTAMP, 'type' => 2), array('id' => $_GPC['id']));
			message('手动处理成功！', referer(), 'success');
		}
	}
	$list = pdo_fetchall("select * from" . tablename('tg_merchant_record') . "where  uniacid={$_W['uniacid']} and status={$status}");
	foreach ($list as $key => &$value) {
		$value['merchant'] = model_merchant::getSingleMerchant($value['merchantid'], 'thumb,name,openid,percent');
	}
	include  wl_template('application/merchant/cashConfirm');
}

if ($op == 'tag') {
	include  wl_template('application/merchant/imgandtag');
}

if ($op == 'cover') {//商家入口
	require IA_ROOT . '/framework/library/qrcode/phpqrcode.php';
	$cover = $_GPC['type'] ? $_GPC['type'] : 'web';
	$url = app_url('goods/list/merchant', array('id' => MERCHANTID));
	QRcode::png($_GPC['url'], false, QR_ECLEVEL_H, 4);
	include  wl_template('application/merchant/cover');
}