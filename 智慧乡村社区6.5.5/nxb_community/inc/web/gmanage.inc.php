<?php
global $_W, $_GPC;
load()->web('tpl'); 



//添加群发管理员
if ($_W['ispost']) {
	if (checksubmit('submit')) {
		$openid=$_GPC['openid'];
		$username=$_GPC['gmname'];
		$password=$_GPC['gmpassword'];
		$password2=$_GPC['gmpassword2'];
		if($openid=='' || $username=='' || $password==''){
			message('openid、用户名、登录密码都不能为空哦~',$this->createWebUrl('gmanage',array()),'error');  
		}		
		if($password!=$password2){
			message('密码不一致~',$this->createWebUrl('gmanage',array()),'error');  
		}
		//查询用户名是否已存在
		$res=pdo_fetch("SELECT * FROM".tablename('bc_community_gmanage')."WHERE weid=:uniacid AND gmname=:gmname",array(':uniacid'=>$_W['uniacid'],':gmname'=>$username));
		if(!empty($res)){
			message('用户名已存在，请重新设置用户名~',$this->createWebUrl('gmanage',array()),'error');  
		}

		$newdata = array(
			'weid'=>$_W['uniacid'],
			'openid'=>$openid,
			'gmname'=>$username,
			'gmpassword'=>$password,
			'gmctime'=>time(),
			 );
		$res = pdo_insert('bc_community_gmanage', $newdata);
		if (!empty($res)) {
			message('恭喜，设置成功！', $this -> createWebUrl('gmanage'), 'success');
		} else {
			message('抱歉，设置失败！', $this -> createWebUrl('gmanage'), 'error');
		}

	}

}else{
	
	//获取群发管理员列表
	$managelist=pdo_fetchall("SELECT * FROM".tablename('bc_community_gmanage')."WHERE weid=:uniacid ORDER BY gmid DESC",array(':uniacid'=>$_W['uniacid']));
	
	include $this->template('web/gmanage');	
	
}


?>