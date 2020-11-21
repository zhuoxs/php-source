<?php
global $_W, $_GPC;
include 'common.php';
load() -> func('tpl');
$all_net=$this->get_allnet(); 

$base=$this->get_base(); 
$title=$base['title'];
$mid=$this->get_mid(); 

$townid=intval($_GPC['id']);

//获取乡镇列表



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

//获取当前用户的信息
$member=$this->getmember(); 
//获取当前村镇详情
$town=pdo_fetch("SELECT name FROM ".tablename('bc_community_town')." WHERE weid=:uniacid AND id=:id",array(':uniacid'=>$_W['uniacid'],':id'=>$townid));

//获取乡村组织分类列表
$organlist=pdo_fetchall("SELECT * FROM ".tablename('bc_community_organlev')." WHERE weid=:uniacid AND villageid=:villageid ORDER BY id ASC",array(':uniacid'=>$_W['uniacid'],':villageid'=>$townid));


include $this -> template('organ');


//返回组织成员列表
function getorganuserlist2($weid,$id){

    $list=pdo_fetchall("SELECT * FROM " . tablename('bc_community_organuser') . " WHERE weid=".$weid." AND organid=".$id." ORDER BY displayorder DESC");
    $comment = '';
    foreach ($list as $t => $com) {
        $comment.='<div class="mui-col-xs-12 ubb b-gra" onclick="openorganuser('.$com['id'].')">'
            .'<div class="mui-row tx-c pt05 pb05">'
            .'<div class="mui-col-xs-4 ">'.$com['username'].'</div>'
            .'<div class="mui-col-xs-8 ubl b-gra">'.$com['zhiwei'].'</div>'
            .'</div>'
            .'</div>';
    }
    return $comment;
}

?>