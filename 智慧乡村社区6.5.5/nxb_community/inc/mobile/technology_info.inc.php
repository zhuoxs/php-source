<?php
global $_W, $_GPC;
include 'common.php';
$all_net=$this->get_allnet(); 
$base=$this->get_base(); 
$title=$base['title'];
$mid=$this->get_mid();



$id=intval($_GPC['id']);
$sid=intval($_GPC['sid']);


$res = pdo_fetch("SELECT * FROM " . tablename('bc_community_courselesson') . " WHERE weid=:uniacid AND id=:id",array(':uniacid'=>$_W['uniacid'],':id'=>$id));	


if(!empty($res)){
	//获取所有课时
	$list=pdo_fetchall("SELECT * FROM ".tablename('bc_community_coursesection')." WHERE weid=:uniacid AND lessonid=:id ORDER BY id ASC",array(':uniacid'=>$_W['uniacid'],':id'=>$res['id']));
	if(!empty($list)){
		
		if($sid!==0){
			$result=pdo_fetch("SELECT * FROM " . tablename('bc_community_coursesection') . " WHERE weid=:uniacid AND id=:id",array(':uniacid'=>$_W['uniacid'],':id'=>$sid));	
		
		}else{
			$result=pdo_fetch("SELECT * FROM " . tablename('bc_community_coursesection') . " WHERE weid=:uniacid AND id=:id",array(':uniacid'=>$_W['uniacid'],':id'=>$list[0]['id']));	
		
		}
		
		
	}else{
		message('本教程下暂无课时！', $this -> createMobileUrl('technology'), 'error');
	}
}

    $result['videourl'] = str_replace('<iframe','<iframe width="100%" height="300"',htmlspecialchars_decode($result['videourl']));
    if(strpos($result['videourl'],'.mp4')>0){
        $result['videourl'] = '<video  width="100%" height="300" autoplay="autoplay"><source src="'.$result['videourl'].'" type="video/mp4"></video>';
    }


	include $this -> template('technology_info');

?>