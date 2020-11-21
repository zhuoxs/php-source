<?php
global $_W, $_GPC;
include 'common.php';
load() -> func('tpl');
$all_net=$this->get_allnet(); 

$base=$this->get_base(); 
$title=$base['title'];
$mid=$this->get_mid(); 


$gz=$this->guanzhu(); 
//判断是否需要进入强制关注页
if($gz==1){
	if ($_W['fans']['follow']==0){
		include $this -> template('follow');
		exit;
	};
}else{
	//取得用户授权
	mc_oauth_userinfo();
}

//查询用户角色是否有权限发帖
$user=pdo_fetch("SELECT * FROM ".tablename('bc_community_member')." WHERE weid=:uniacid AND mid=:mid",array(':uniacid'=>$_W['uniacid'],':mid'=>$mid));

if($user['isrz']!=1){
	message('抱歉！认证为村民才可以操作哦！',$this->createMobileUrl('register',array()),'error');
}


$res=pdo_fetch("SELECT * FROM ".tablename('bc_community_help')." WHERE weid=:uniacid AND mid=:mid",array(':uniacid'=>$_W['uniacid'],':mid'=>$mid));
$images=explode("|",$res['photo']);


if ($_W['ispost']) {
	if (checksubmit('submit')) {
		//先查询该用户是否有提交记录
		$t=pdo_fetch("SELECT * FROM ".tablename('bc_community_help')." WHERE weid=:uniacid AND mid=:mid",array(':uniacid'=>$_W['uniacid'],':mid'=>$mid));
		if(empty($t)){
			
			$images=implode("|",$_GPC['photo']);
			$newdata = array(
				'weid'=>$_W['uniacid'],
				'mid'=>$mid,
				'townid'=>$user['danyuan'],
				'menpai'=>$user['menpai'],
				'uname'=>$_GPC['uname'],
				'sex'=>$_GPC['sex'],
				'age'=>$_GPC['age'],
				'tel'=>$_GPC['tel'],
				'xueli'=>$_GPC['xueli'],
				'family'=>$_GPC['family'],
				'stzk'=>$_GPC['stzk'],
				'jtsr'=>$_GPC['jtsr'],
				'jtzk'=>$_GPC['jtzk'],
				'nhgs'=>$_GPC['nhgs'],
				'jtcp'=>$_GPC['jtcp'],
				'jiage'=>$_GPC['jiage'],
				'srly'=>$_GPC['srly'],
				'cpxq'=>$_GPC['cpxq'],
				'cover'=>$_GPC['cover'],
				'photo'=>$images,
				'createtime'=>time(),
			
			);
			$res = pdo_insert('bc_community_help', $newdata);
			if (!empty($res)) {
				message('提交成功！', $this -> createMobileUrl('help'), 'success');
			} else {
				message('提交失败！', $this -> createMobileUrl('help'), 'error');
			}
			
		}else{
			$images=implode("|",$_GPC['photo']);
			if($images==''){
				$images=$t['photo'];
			}
			$newdata = array(
				'townid'=>$user['danyuan'],
				'menpai'=>$user['menpai'],
				'uname'=>$_GPC['uname'],
				'sex'=>$_GPC['sex'],
				'age'=>$_GPC['age'],
				'tel'=>$_GPC['tel'],
				'xueli'=>$_GPC['xueli'],
				'family'=>$_GPC['family'],
				'stzk'=>$_GPC['stzk'],
				'jtsr'=>$_GPC['jtsr'],
				'jtzk'=>$_GPC['jtzk'],
				'nhgs'=>$_GPC['nhgs'],
				'jtcp'=>$_GPC['jtcp'],
				'jiage'=>$_GPC['jiage'],
				'srly'=>$_GPC['srly'],
				'cpxq'=>$_GPC['cpxq'],
				'cover'=>$_GPC['cover'],
				'photo'=>$images,
				
			
			);
			$res = pdo_update('bc_community_help', $newdata,array('id'=>$t['id']));
			if (!empty($res)) {
				message('提交成功！', $this -> createMobileUrl('help'), 'success');
			} else {
				message('提交失败！', $this -> createMobileUrl('help'), 'error');
			}
			
		}
		
		
		

	}

}
	

include $this -> template('help');




?>