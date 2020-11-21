<?php 
/**
 * [weliam] Copyright (c) 2016/4/4
 * 手机端支付控制器
 */
	defined('IN_IA') or exit('Access Denied');
	global $_W;
	$moduels = uni_modules();
	load()->func('communication');
	load()->model('payment');
	if(empty($_GPC['orderid']))wl_message(array('errno'=>1,'message'=>"参数错误，缺少订单号.")); //验证是否缺失订单号。
	if($_GPC['creditType']=='recharge'){ //余额充值。
		$order = pdo_fetch("select orderno,num,openid from".tablename('tg_credit1rechargerecord')."where id={$_GPC['orderid']}");
		$order['pay_price'] = $order['num'];
		$order['uniacid'] = $_W['uniacid'];
		$goods['gname'] = "余额充值";
	}else{ //正常支付订单。
		$order = model_order::getSingleOrder($_GPC['orderid'], '*');
		$goods = model_goods::getSingleGoods($order['g_id'], '*');
	}
	if($order['pay_price'] <= 0) wl_message(array('errno'=>1,'message'=>"支付金额错误,支付金额需大于0元."));//验证支付金额是否大于0。
	$setting=setting_get_by_name("helpbuy");
	if($setting['helpbuy'] != 1){
		if($order['openid'] != $_W['openid']){
			wl_message(array('errno'=>1,'message'=>"openid不匹配,请在订单列表重新发起支付."));
		}
	}
		
	$params['tid'] = $order['orderno'];
	$params['user'] = $_W['openid']; //不用订单的openid的原因：有可能是代付
	$params['fee'] = $order['pay_price'];
	$params['title'] = $goods['gname'];
	$params['ordersn'] = $order['orderno'];
	$params['module'] = "feng_fightgroups";
	if(!array_key_exists($params['module'], $moduels)) wl_message('模块不存在.');//若模块不在微擎则报错。
	
	$pars = array();
	$pars[':uniacid'] = $order['uniacid'];
	$pars[':module'] = $params['module'];
	$pars[':tid'] = $params['tid'];
	$log = pdo_fetch('SELECT * FROM ' . tablename('core_paylog') . ' WHERE `uniacid`=:uniacid AND `module`=:module AND `tid`=:tid', $pars); //若果微擎支付记录存在则取出。
	
if($_GPC['done'] == 1) { //支付成功后 点击完成按钮执行。
	if(empty($log)) wl_debug("log empty!"); //若$log为空打印error并退出。
	if (!empty($log['tag'])) {
		$tag = iunserializer($log['tag']);
		$log['uid'] = $tag['uid'];
	}
	$ret = array();
	$ret['weid'] = $log['uniacid'];
	$ret['uniacid'] = $log['uniacid'];
	$ret['result'] = 'success';
	$ret['type'] = $log['type'];
	$ret['from'] = 'return';
	$ret['tid'] = $log['tid'];
	$ret['uniontid'] = $log['uniontid'];
	$ret['user'] = $log['openid'];
	$ret['fee'] = $log['fee'];
	$ret['tag'] = $tag;
	$ret['is_usecard'] = $log['is_usecard'];
	$ret['card_type'] = $log['card_type'];
	$ret['card_fee'] = $log['card_fee'];
	$ret['card_id'] = $log['card_id'];
	exit(payResult::payReturn($ret));
}
if ($_W['isajax']) {
	$dos = array();
	$setting = uni_setting($_W['uniacid'], array('payment', 'creditbehaviors'));
	if(!is_array($setting['payment'])) wl_message(array('errno'=>1,'message'=>"没有有效的支付方式, 请联系网站管理员.")); //判断微擎是否有支付设置内容。
	if(!empty($setting['payment']['credit']['pay_switch'])) $dos[] = 'credit';
	if(!empty($setting['payment']['alipay']['switch'])) $dos[] = 'alipay';
	if(!empty($setting['payment']['wechat']['switch'])) $dos[] = 'wechat';
	
	$type = in_array($_GPC['paytype'], $dos) ? $_GPC['paytype'] : '';
	if(empty($type)) wl_message(array('errno'=>1,'message'=>"支付方式错误,请联系商家"));
	
	$data = array(
		'uniacid' => $order['uniacid'],
		'acid' => $_W['acid'],
		'openid' => $_W['openid'], //openid为真实支付者openid
		'module' => $params['module'],
		'tid' => $params['tid'],
		'fee' => $params['fee'],
		'card_fee' => $params['fee'],
		'status' => '0',
		'is_usecard' => '0',
		'type'=>$type //支付方式
	);
	if (empty($log)) pdo_insert('core_paylog', $data); //生成paylog记录
	
	if (!empty($setting['payment']['credit']['pay_switch'])) $credtis = mc_credit_fetch($_W['member']['uid']); //如果微擎余额开启了，则获取微擎余额。
	
	$log = pdo_fetch('SELECT * FROM ' . tablename('core_paylog') . ' WHERE `uniacid`=:uniacid AND `module`=:module AND `tid`=:tid', $pars); // 取出微擎支付记录。
	
	if(!empty($log) && $type != 'credit' && $log['status'] != '0') wl_message(array('errno'=>1,'message'=>"这个订单已经支付成功, 不需要重复支付!"));
	$uniontid = $order['orderno'];
	pdo_update('core_paylog', array('type'=>$type,'uniontid'=>$uniontid), array('plid' => $log['plid'])); //更新type和uniontid到微擎core_paylog。
	
	$log = pdo_fetch('SELECT * FROM ' . tablename('core_paylog') . ' WHERE `uniacid`=:uniacid AND `module`=:module AND `tid`=:tid', $pars); //更新后再次取出支付记录。
	
	if($type == 'wechat') { //微信支付
		$wechat = $setting['payment']['wechat'];
		$paytype = tgsetting_read('paytype');
		
		$row = pdo_fetch('SELECT `key`,`secret` FROM ' . tablename('account_wechats') . ' WHERE `acid`=:acid', array(':acid' => $wechat['account']));
		$wechat['appid'] = $row['key'];
		$wechat['secret'] = $row['secret'];
		$params = array(
			'tid' => $log['tid'],
			'fee' => $log['card_fee'],
			'user' => $log['openid'],
			'title' => $params['title'],
			'uniontid' => $log['uniontid'],
		);
		if($paytype['wechatstatus'] == 3){
			$wechat['appid'] = $paytype['partner_appid'];
			$wechat['secret'] = $paytype['partner_appsecret'];
			$wechat['mchid'] = $paytype['partner_mchid'];
			$wechat['sub_mch_id'] = $paytype['partner_submchid'];
			$wechat['sub_appid'] = $paytype['partner_chappid'];
		}
		$notify_url = WL_USER_AGENT == 'yunapp'? MODULE_URL . 'payment/wechat/app_weixin_notify.php':MODULE_URL . 'payment/wechat/weixin_notify.php';
		$wOpt = model_pay::wechat_build($params, $wechat,$notify_url); 
		if (is_error($wOpt)) {
			if ($wOpt['message'] == 'invalid out_trade_no' || $wOpt['message'] == 'OUT_TRADE_NO_USED') {
				$id = date('YmdH');
				pdo_update('core_paylog', array('plid' => $id), array('plid' => $log['plid']));
				pdo_query("ALTER TABLE ".tablename('core_paylog')." auto_increment = ".($id+1).";");
				wl_message(array('errno'=>1,'message'=>"抱歉，发起支付失败，系统已经修复此问题，请重新尝试支付。"));
			}
			wl_message(array('errno'=>1,'message'=>"抱歉，发起支付失败，具体原因为：“{$wOpt['errno']}:{$wOpt['message']}”。请及时联系站点管理员。"));
		}
	}
	die(json_encode(array('errno'=>0,'message'=>"支付成功!",'data'=>$wOpt)));
}
?>
