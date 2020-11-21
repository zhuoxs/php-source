<?php
global $_W, $_GPC;
include 'common.php';
load()->func('tpl');
$base=$this->get_base(); 
$title=$base['title'];
//查询缓存是否存在，如果有，就直接登录后台，如果没有就显示登录页
$webtoken = $_SESSION['webtoken']; //cache_load('webtoken');
if($webtoken==''){
	header('Location: '.$_W['siteroot'].'web/index.php?c=user&a=login&referer='.urlencode($_W['siteroot'].'app/'.$this->createMobileUrl('manage_login_go')));
}else{
	
	$nav=intval($_GPC['nav']);
	if($nav==0){
		$nav=1;
	}
	
	//通过缓存查找到管理员信息
	$manageid = $_SESSION['manageid']; //cache_load('manageid');
	
	$manage=pdo_fetch("SELECT * FROM ".tablename('bc_community_jurisdiction')." WHERE weid=:uniacid AND id=:id",array(':uniacid'=>$_W['uniacid'],'id'=>$manageid));
	$v=0;
	if($manage['lev']==2 || $manage['lev']==3){		
		$v=1;		
	}
	
	//获取角色列表
	$rolelsit=pdo_fetchall("SELECT * FROM ".tablename('bc_community_authority')." WHERE weid=:uniacid ORDER BY id DESC",array(':uniacid'=>$_W['uniacid']));
	//获取当前记录详情
	$id=intval($_GPC['id']);
	$res=pdo_fetch("SELECT * FROM ".tablename('bc_community_help')." WHERE weid=:uniacid AND id=:id",array(':uniacid'=>$_W['uniacid'],'id'=>$id));
	$images=explode("|",$res['photo']);
}
	




if ($_W['ispost']) {
	if (checksubmit('submit')) {
		$images1=implode("|",$_GPC['photo']);
		if($images1==''){
			$images1=$res['photo'];
		}
		$cover=$_GPC['cover'];
		if($cover==''){
			$cover=$res['cover'];
		}
		
		$newdata = array(
				
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
				'cover'=>$cover,
				'photo'=>$images1,
				
			
			);
			
			$res1 = pdo_update('bc_community_help', $newdata,array('id'=>$id));
		if (!empty($res1)) {
			message('提交成功', $this -> createMobileUrl('manage_help'), 'success');
		} else {
			message('提交失败！', $this -> createMobileUrl('manage_help'), 'error');
		}

	}

}
	
	
	
	
	
	include $this->template('manage_help_edit');





?>