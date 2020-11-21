<?php 
defined('IN_IA') or exit('Access Denied');
$moduels = uni_modules();
load()->func('communication');
load()->model('payment');

if(!empty($_GPC['orderid'])){
	$order = model_order::getSingleOrder($_GPC['orderid'], '*');
	$goods = model_goods::getSingleGoods($order['g_id'], '*');
}else{
	wl_message("参数错误，缺少订单号.");
}

if($order['pay_price'] <= 0) {
	wl_message("支付金额错误,支付金额需大于0元.");
}

$params['tid'] = $order['orderno'];
$params['user'] = $_W['openid'];
$params['fee'] = $order['pay_price'];
$params['title'] = $goods['gname'];
$params['ordersn'] = $order['orderno'];
$params['module'] = "feng_fightgroups";

//生成paylog记录
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
);
if (empty($log)) {
	pdo_insert('core_paylog', $data);
}
$setting = uni_setting($_W['uniacid'], array('payment', 'creditbehaviors'));
if(empty($params) || !array_key_exists($params['module'], $moduels)) {
	wl_message('访问错误.');
}

$dos = array();
$dos[] = 'delivery';
if(!empty($setting['payment']['alipay']['switch'])) {
	$dos[] = 'alipay';
}
$type = in_array($_GPC['paytype'], $dos) ? $_GPC['paytype'] : '';
if(empty($type)) {
	wl_message("支付方式错误,请联系商家");
}
	
if(!empty($type)) {
	$sql = 'SELECT * FROM ' . tablename('core_paylog') . ' WHERE `uniacid`=:uniacid AND `module`=:module AND `tid`=:tid';
	$pars  = array();
	$pars[':uniacid'] = $_W['uniacid'];
	$pars[':module'] = $params['module'];
	$pars[':tid'] = $params['tid'];
	$log = pdo_fetch($sql, $pars);
	if(!empty($log) && $type != 'credit' && $log['status'] != '0') {
		wl_message("这个订单已经支付成功, 不需要重复支付!");
	}
	
	$moduleid = pdo_fetchcolumn("SELECT mid FROM ".tablename('modules')." WHERE name = :name", array(':name' => $params['module']));
	$moduleid = empty($moduleid) ? '000000' : sprintf("%06d", $moduleid);
	$record = array();
	$record['type'] = $type;
	$record['uniontid'] = date('YmdHis').$moduleid.random(8,1);
	
	pdo_update('core_paylog', $record, array('plid' => $log['plid']));
	$sql = 'SELECT * FROM ' . tablename('core_paylog') . ' WHERE `uniacid`=:uniacid AND `module`=:module AND `tid`=:tid';
	$log = pdo_fetch($sql, $pars);
	
	if($type == 'alipay') {
		$ret = alipay_build(array('uniontid' => $record['uniontid'],'title' => $goods['gname'],'fee' => $params['fee']), $setting['payment']['alipay']);
		if($ret['url']) {
			echo '<script type="text/javascript" src="'. $_W['siteroot'] .'payment/alipay/ap.js"></script><script type="text/javascript">_AP.pay("'.$ret['url'].'");</script>';
			exit();
		}
	}
	
	if ($type == 'delivery') {
		if(!empty($log) && $log['status'] == '0') {
			$ret = array();
			$ret['result'] = 'success';
			$ret['type'] = $log['type'];
			$ret['from'] = 'return';
			$ret['tid'] = $log['tid'];
			$ret['user'] = $log['openid'];
			$ret['fee'] = $log['fee']; 					
			$ret['weid'] = $log['weid'];
			$ret['uniacid'] = $log['uniacid'];
			$ret['is_usecard'] = $log['is_usecard'];
			$ret['card_type'] = $log['card_type']; 					
			$ret['card_fee'] = $log['card_fee'];
			$ret['card_id'] = $log['card_id'];
			payResult::payNotify($ret);
			payResult::payReturn($ret);
		}
	}
}