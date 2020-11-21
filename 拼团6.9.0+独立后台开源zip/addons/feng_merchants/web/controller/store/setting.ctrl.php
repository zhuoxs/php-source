<?php 
/**
 * [weliam] Copyright (c) 2016/3/26
 * 商城系统设置控制器
 */
defined('IN_IA') or exit('Access Denied');
$ops = array('copyright');
$op = in_array($op, $ops) ? $op : 'copyright';

if ($op == 'copyright') {
	$id = MERCHANTID;
	if(!empty($id)){
		$sql = 'SELECT * FROM '.tablename('tg_merchant').' WHERE id=:id AND uniacid=:uniacid LIMIT 1';
		$params = array(':id'=>$id, ':uniacid'=>$_W['uniacid']);
		$merchant = pdo_fetch($sql, $params);
		$saler = pdo_fetch("select * from" . tablename('tg_member') . "where uniacid={$_W['uniacid']} and openid='{$merchant['openid']}'");
		$messagesaler = pdo_fetch("select * from" . tablename('tg_member') . "where uniacid={$_W['uniacid']} and openid='{$merchant['messageopenid']}'");
	}
	
	if (checksubmit()) {
		$data = $_GPC['merchant']; // 获取打包值
		$data['detail'] = htmlspecialchars_decode($data['detail']);
		$data['openid'] = $_GPC['openid']; 
		$data['messageopenid'] = $_GPC['messageopenid'];

		$ret = pdo_update('tg_merchant', $data, array('id'=>$id));
		$user = pdo_fetch("select * from".tablename("users")."where uid=:uid",array(':uid'=>$merchant['uid']));
		$opwd = trim($_GPC['opwd']);
		$npwd = trim($_GPC['npwd']);
		$tpwd = trim($_GPC['tpwd']);
		if($data['open']==2){
			$ret = pdo_update('users', array('status'=>1), array('uid'=>$merchant['uid']));
		}else{
			if(!empty($opwd) && !empty($npwd) && !empty($tpwd)){
				if($opwd!=$merchant['password']){
					message('原密码错误！');exit;
				}else{
					if($npwd!=$tpwd){
						message('两次密码输入不一致！');exit;
					}
				}
				if(istrlen($npwd) < 8) {
					message('必须输入密码，且密码长度不得低于8位。');exit;
				}
				$p = user_hash($npwd, $user['salt']);
				$ret = pdo_update('users', array('password'=> $p,'status'=>2), array('uid'=>$merchant['uid']));
			}
			
		}
		message('店铺信息保存成功', web_url('store/setting'), 'success');
	}
}
include wl_template('store/setting');
