<?php
/**
 * 注册微客页面
 */
defined('IN_IA') or exit('Access Denied');
$sql = "SELECT nickname,username,weixinhao,mobile,wxerweima FROM " . tablename('wg_fenxiao_member') . " WHERE id=:id AND weid=:weid";
$item = pdo_fetch($sql,array(':id'=>$fenxiao_member_id,':weid'=>$_W['uniacid']));
if(checksubmit('wanshan')){
	//检测数据
	if(empty($_GPC['nickname'])){
		message('请填写您的昵称',$this->createMobileUrl('zhuceweike'),'error');
	}
	if(empty($_GPC['username'])){
		message('请填写您的姓名',$this->createMobileUrl('zhuceweike'),'error');
	}
	if(empty($_GPC['tel'])){
		message('请填写您的手机号',$this->createMobileUrl('zhuceweike'),'error');
	}
	
	$data = array(
		'nickname'=>trim($_GPC['nickname']),
		'username'=>trim($_GPC['username']),
		'mobile'=>trim($_GPC['tel']),
		'weixinhao'=>trim($_GPC['weixinhao']),
		'wxerweima'=>trim($_GPC['wxerweima'][0])
	);
	$res = pdo_update('wg_fenxiao_member',$data,array('id'=>$fenxiao_member_id,'weid'=>$_W['uniacid']));
	message('更新资料成功',$this->createMobileUrl('member'),'success');	
}
$title = '填写信息';
load()->func('tpl');
include $this->template('zhuceweike');