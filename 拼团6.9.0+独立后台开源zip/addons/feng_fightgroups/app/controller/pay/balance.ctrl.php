<?php 
	defined('IN_IA') or exit('Access Denied');
	global $_W,$_GPC;
	$moduels = uni_modules();
	load()->func('communication');
	load()->model('payment');
	load()->model('mc');
	if(!empty($_GPC['orderid'])){
		$order = model_order::getSingleOrder($_GPC['orderid'], '*');
		$goods = model_goods::getSingleGoods($order['g_id'], '*');
	}else{
		$message = "参数错误，缺少订单号.";
		message($message);
	}
	if($order['pay_price'] <= 0) {
		$message = "支付金额错误,支付金额需大于0元.";
		message($message);
	}
	$setting = uni_setting($_W['uniacid'], array('payment', 'creditbehaviors'));
	$dos = array();
	if(!empty($setting['payment']['credit']['pay_switch']) || $setting['payment']['credit']['switch']) {
		$dos[] = 'credit';
	}
	if(!empty($setting['payment']['alipay']['switch'])) {
		$dos[] = 'alipay';
	}
	if(!empty($setting['payment']['wechat']['switch'])) {
		$dos[] = 'wechat';
	}
	$type = in_array($_GPC['paytype'], $dos) ? $_GPC['paytype'] : '';
	if(empty($type)) {
		$message = "支付方式错误,请联系商家";
		message($message);
	}
	$params['tid'] = $order['orderno'];
	$params['user'] = $_W['openid'];
	$params['fee'] = $order['pay_price'];
	$params['title'] = $goods['gname'];
	$params['ordersn'] = $order['orderno'];
	$params['module'] = "feng_fightgroups";
	
	$sql = 'SELECT * FROM ' . tablename('core_paylog') . ' WHERE `uniacid`=:uniacid AND `module`=:module AND `tid`=:tid';
	$pars = array();
	$pars[':uniacid'] = $_W['uniacid'];
	$pars[':module'] = $params['module'];
	$pars[':tid'] = $params['tid'];
	$log = pdo_fetch($sql, $pars);
	$data = array(
		'uniacid' => $_W['uniacid'],
		'acid' => $_W['acid'],
		'openid' => $_W['openid'],
		'module' => $params['module'],
		'tid' => $params['tid'],
		'fee' => $params['fee'],
		'card_fee' => $params['fee'],
		'status' => '0',
		'is_usecard' => '0',
		'type'=>$type
	);
	if (empty($log)){
		pdo_insert('core_paylog', $data);
	}else{
		pdo_update('core_paylog',array('type'=>'credit'),array('tid'=>$params['tid'],'uniacid'=>$_W['uniacid'],'module'=>$params['module']));
	}
	$sql = 'SELECT * FROM ' . tablename('core_paylog') . ' WHERE `uniacid`=:uniacid AND `module`=:module AND `tid`=:tid';
	$pars  = array();
	$pars[':uniacid'] = $_W['uniacid'];
	$pars[':module'] = $params['module'];
	$pars[':tid'] = $params['tid'];
	$log = pdo_fetch($sql, $pars);
	if(!empty($log) && $log['status'] == '0') {
	    if($type == 'credit') {
			wl_load()->model('credit');
			wl_load()->model('setting');
			$tgsetting=setting_get_by_name("member");
			$credit_type = $tgsetting['credit_type']?$tgsetting['credit_type']:1; //$credit_type=1为微擎积分余额
			$fee = floatval($log['fee']);
			$uid = mc_openid2uid($_W['openid']);
			if($credit_type==2){ //拼团积分余额
				$credtis=credit_get_by_uid($uid,$credit_type);
				if($credtis['credit2'] < $log['fee']) message("余额不足以支付, 需要 {$log['fee']}, 当前 {$credtis['credit2']}");
				credit_update_credit2($uid,0-$fee,$credit_type,"购买商品【".$goods['gname']."】");
			}
			if($credit_type==1){ //微擎积分余额
				if (empty($uid)){
					$setting['payment']['credit']['pay_switch'] = false; //如果uid为空则关闭余额支付
					message("微擎余额未开启");
				} 
				if ($setting['payment']['credit']['pay_switch'] || $setting['payment']['credit']['switch']) $credtis = mc_credit_fetch($uid);  //若果微擎余额支付开启 获得余额
				if(!empty($log) && empty($log['status'])) {
					if($credtis['credit2'] < $log['fee']) message("余额不足以支付, 需要 {$log['fee']}, 当前 {$credtis['credit2']}");
					$result=credit_update_credit2($uid,0-$fee,$credit_type,'购买:'.$goods['gname'].':' . $fee);
					if (!$result) message('余额支付错误', '', 'error');
					pdo_update('core_paylog', array('status' => '1'), array('plid' => $log['plid']));
				}
			}
			
			$ret = array();
			$ret['result'] = 'success';
			$ret['type'] = $log['type'];
			$ret['from'] = 'notify';
			$ret['tid'] = $log['tid'];
			$ret['user'] = $log['openid'];
			$ret['fee'] = $log['fee'];
			$ret['weid'] = $log['weid'];
			$ret['uniacid'] = $log['uniacid'];
			$ret['acid'] = $log['acid'];
			$ret['is_usecard'] = $log['is_usecard'];
			$ret['card_type'] = $log['card_type'];
			$ret['card_fee'] = $log['card_fee'];
			$ret['card_id'] = $log['card_id'];
			
			
			payResult::payNotify($ret);
			payResult::payReturn($ret);
		}
	}else{
		$order_out = pdo_fetch("select * from".tablename('tg_order')."where orderno='{$params['tid']}'");
		
		if($order_out['tuan_id'])
			header("location:".app_url('order/group', array('tuan_id' => $order_out['tuan_id'],'pay'=>'pay')));
		else
			wl_message('订单参数错误！');
	}
?>
