<?php
global $_W, $_GPC;
load() -> func('tpl');
$all_net=$this->get_allnet(); 
$base=$this->get_base(); 
$title=$base['title'];
$mid=$this->get_mid();
$meid=intval($_GPC['menuid']);

//定义不同帖子类型
$ss='说说';
$wxy='微心愿';
$hzr='活找人';
$zhkj='置换空间';
$flzx='法律咨询';
$xrxw='寻人寻物';
$sqtz='社区通知';
$bfxx='帮扶信息';
$xqdt='小区动态';
$sqhd='社区活动';
$zyhd='志愿活动';

$member=$this->getmember();
//查询用户是否对此类帖子有发帖权限
$grade=$member['grade'];


//判断用户是否认证
if($member['isrz']==0){
	message('您尚未认证村民！', $this -> createMobileUrl('register'), 'error');
		
}else if($member['isrz']==2){
	message('您尚未通过认证审核,请稍后重试！', $this -> createMobileUrl('index'), 'error');
}




//查询对应ID栏目详情
$menu=pdo_fetch("SELECT * FROM ".tablename('bc_community_menu')." WHERE weid=:uniacid AND meid=:meid ",array(':uniacid'=>$_W['uniacid'],':meid'=>$meid));
$menuname=$menu['mtitle'];

$authorid=$menu['authorid'];
$authorids=explode(",",$authorid);
$qx=0;
foreach ($authorids as $t => $item) {

	if($item==$grade){
		
		$qx=1;
		
	}
}
if($qx!=1){
	
	message('抱歉！此栏目您不具备发帖权限！',$this->createMobileUrl('subform',array()),'error');
	
}

//查询该用户是否被禁言，不能发帖子和留言评论
$user=pdo_fetch("SELECT * FROM ".tablename('bc_community_member')." WHERE weid=:uniacid AND mid=:mid ",array(':uniacid'=>$_W['uniacid'],':mid'=>$mid));
if(!empty($user)){
	$gag=$user['gag'];
	if($gag==1){
		message('抱歉！您被禁言了，不能发帖子和留言评论，请和管理员联系！',$this->createMobileUrl('index',array()),'error');
	}
	
	$danyuan=$user['danyuan'];
	$menpai=$user['menpai'];
}


//提交报料表单
if ($_W['ispost']) {
	if (checksubmit('submit')) {
		if($_GPC['ntitle']=='' || $_GPC['ntext']==''){
			message('标题和内容必填的哦~',$this->createMobileUrl('sub_allform',array()),'error');          
     	} 
		$images=implode("|",$_GPC['nimg']);
		$newdata = array(
			'weid'=>$_W['uniacid'],
			'nmenu'=>$meid,			
			'mid'=>$mid,
			'ntitle'=>$_GPC['ntitle'],
			'ntext'=>$_GPC['ntext'],
			'nimg'=>$images,
			'time'=>$_GPC['time'],
			'qidian'=>$_GPC['qidian'],
			'zhongdian'=>$_GPC['zhongdian'],
			'dunwei'=>$_GPC['dunwei'],
			'yunfei'=>$_GPC['yunfei'],
			'lxfs'=>$_GPC['lxfs'],
			'beizhu'=>$_GPC['beizhu'],
			'didian'=>$_GPC['didian'],
			'peoplenum'=>$_GPC['peoplenum'],
			'njmc'=>$_GPC['njmc'],
			'jxdx'=>$_GPC['jxdx'],
			'ts'=>$_GPC['ts'],
			'dwgs'=>$_GPC['dwgs'],
			'name'=>$_GPC['name'],
			'sfz'=>$_GPC['sfz'],
			'qsl'=>$_GPC['qsl'],
			'fmzl'=>$_GPC['fmzl'],
			'producttype'=>$_GPC['producttype'],
			'wishurl'=>$_GPC['wishurl'],
			'remark'=>$_GPC['remark'],
			'browser'=>1,					
			'nctime'=>time(),
			'wishrl'=>$_GPC['wishrl'],
			'wishurl'=>$_GPC['wishurl'],
			'wishtel'=>$_GPC['wishtel'],
			'wishname'=>$_GPC['wishname'],
			'wishcode'=>$_GPC['wishcode'],
			'wishcompany'=>$_GPC['wishcompany'],
			'status'=>$_GPC['status'],
			'coid'=>0,
			'danyuan'=>$danyuan,
			'menpai'=>$menpai,
			 );
		$res = pdo_insert('bc_community_news', $newdata);
		if (!empty($res)) {
			message('恭喜，帖子提交成功', $this -> createMobileUrl('index'), 'success');
		} else {
			message('抱歉，提交失败！', $this -> createMobileUrl('sub_allform'), 'error');
		}

	}

}
	




include $this -> template('sub_allform');


?>