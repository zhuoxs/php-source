<?php
global $_W, $_GPC;
load() -> func('tpl');
$all_net=$this->get_allnet(); 
$base=$this->get_base(); 
$title=$base['title'];
$mid=$this->get_mid();
$townid = intval($_GPC['town_id']);

//查询用户角色是否有权限发帖
$user=pdo_fetch("SELECT * FROM ".tablename('bc_community_member')." WHERE weid=:uniacid AND mid=:mid",array(':uniacid'=>$_W['uniacid'],':mid'=>$mid));

//判断用户是否认证
if($user['isrz']==0){
	message('您尚未认证村民！', $this -> createMobileUrl('register'), 'error');
		
}else if($user['isrz']==2){
	message('您尚未通过认证审核,请稍后重试！', $this -> createMobileUrl('index'), 'error');
}

//获取所有问题类型列表
//$townid = $user['menpai'];

$typelist=pdo_fetchall("SELECT * FROM ".tablename('bc_community_type')." WHERE weid=:uniacid AND tstatus=0 AND town_id=$townid ORDER BY tid DESC",array(':uniacid'=>$_W['uniacid']));


//提交意见建议表单

if ($_W['ispost']) {
	if (checksubmit('submit')) {
		if($_GPC['ptype']==0 || $_GPC['ptext']==''){
			message('问题类型、反馈内容必填的哦~',$this->createMobileUrl('proposal',array()),'error');          
     	} 
		$images=implode("|",$_GPC['pimg']);
		$newdata = array(
			'weid'=>$_W['uniacid'],
			'mid'=>$mid,
			'ptype'=>$_GPC['ptype'],
			'ptext'=>$_GPC['ptext'],
			'paddress'=>$_GPC['paddress'],
			'pimg'=>$images,
			'pctime'=>time(),
			'phandle'=>'',
			'phandleper'=>'',
			'phandletime'=>'',
			'pstatus'=>1,
            'town_id'=>$townid,
			 );
		$res = pdo_insert('bc_community_proposal', $newdata);
		if (!empty($res)) {
			message('恭喜，建议提交成功！', $this -> createMobileUrl('usercenter'), 'success');
		} else {
			message('抱歉，提交失败！', $this -> createMobileUrl('proposal'), 'error');
		}

	}

}
	

include $this -> template('proposal');




?>