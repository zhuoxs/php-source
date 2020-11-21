<?php
defined('IN_IA') or exit('Access Denied');

class ymfNotify_WeliamController{
	
	function Notify(){
		global $_W,$_GPC;
		$log = pdo_get(PDO_NAME.'paylog', array('tid' => $_GPC['selfOrdernum'], 'uniacid' => $_GPC['i']));
		$className = $log['plugin'];
		$ret = array();
		$ret['weid'] = $log['uniacid'];
		$ret['uniacid'] = $log['uniacid'];
		$ret['result'] = 'success';
		$ret['type'] = 'ymf';
		$ret['tid'] = $log['tid'];
		$ret['uniontid'] = $log['uniontid'];
		$ret['user'] = $log['openid'];
		$ret['fee'] = $log['fee'];
		$ret['tag'] = $log['tag'];
		$ret['is_usecard'] = $log['is_usecard'];
		$ret['card_type'] = $log['card_type'];
		$ret['card_fee'] = $log['card_fee'];
		$ret['card_id'] = $log['card_id'];
		pdo_update(PDO_NAME.'paylog', array('status' => 1,'type' => 'ymf'), array('tid' => $_GPC['selfOrdernum'], 'uniacid' => $_GPC['i']));
    	$ret['from'] = 'notify';
    	$functionName = 'pay'.$log['payfor'].'Notify';
    	$className::$functionName($ret);
	}
	
	function Result(){
		global $_W,$_GPC;
		
		$log = pdo_get(PDO_NAME.'paylog', array('tid' => $_GPC['selfOrdernum'], 'uniacid' => $_GPC['i']));
		$className = $log['plugin'];
		$ret = array();
		$ret['weid'] = $log['uniacid'];
		$ret['uniacid'] = $log['uniacid'];
		$ret['result'] = 'success';
		$ret['type'] = 'ymf';
		$ret['tid'] = $log['tid'];
		$ret['uniontid'] = $log['uniontid'];
		$ret['user'] = $log['openid'];
		$ret['fee'] = $log['fee'];
		$ret['tag'] = $log['tag'];
		$ret['is_usecard'] = $log['is_usecard'];
		$ret['card_type'] = $log['card_type'];
		$ret['card_fee'] = $log['card_fee'];
		$ret['card_id'] = $log['card_id'];
		
		pdo_update(PDO_NAME.'paylog', array('status' => 1,'type' => 'ymf'), array('tid' => $_GPC['selfOrdernum'], 'uniacid' => $_GPC['i']));
		$ret['from'] = 'notify';
        $functionName2 = 'pay'.$log['payfor'].'Return';
    	$functionName = 'pay'.$log['payfor'].'Notify';
    	$className::$functionName($ret);
		
		$ret['from'] = 'return';
		$className::$functionName2($ret);
	}
}
?>