<?php


global $_W, $_GPC;
include 'common.php';
load() -> func('tpl');
$all_net=$this->get_allnet(); 

$base=$this->get_base(); 
$title=$base['title'].' - 乡村旅游';
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
$weid = $_W['uniacid'];
//获取当前用户的信息
$member=$this->getmember();
$id = intval($_GPC['town_id']);
$tour = pdo_fetch("SELECT * FROM ".tablename('bc_community_tour_info')." WHERE weid=$weid AND town_id = $id");
$town = pdo_fetch("SELECT * FROM ".tablename('bc_community_town')." WHERE weid=$weid AND  id = $id");



if($_GPC['act'] == 'list_ajax'){
    $page = intval($_GPC['page']);
    $psize = 10;
    $start = ($page-1)*$psize;
    $list = pdo_fetchall("SELECT * FROM ".tablename('bc_community_tour_sights')." WHERE weid=$weid AND town_id = $id ORDER BY dateline DESC LIMIT $start,$psize");

    foreach ($list as $key => $value) {
        echo '<div style="margin-bottom: 10px;" class="link" data-url="'.$this->createMobileUrl('tour_sights_view',array('sights_id'=>$value['sights_id'])).'">
            <div>
                <img src="'.tomedia($value['cover']).'" style="width: 100%; height: 190px; display: block;">
                <span style="position: absolute; font-size: 16px; padding: 5px 15px; margin-left: 15px; margin-top: -48px; color: #fff; background-color: #FF5600;  border-radius: 3px;">'.$value['price'].'元起</span>
            </div>
            <div style=" background-color: #ffffff;padding: 12px;">
                <div style=" line-height: 20px; height: 20px; font-size: 16px; white-space: nowrap;overflow: hidden;text-overflow: ellipsis;">
                    '.$value['sights_name'].'
                </div>
                <div style=" line-height: 20px; height: 20px; font-size: 12px; color: #aaa; white-space: nowrap;overflow: hidden;text-overflow: ellipsis;">
                    '.mb_substr(strip_tags(htmlspecialchars_decode($value['content'])),0,30).'
                </div>
            </div>
        </div>';
    }

    exit;
}









include $this -> template('tour_sights');

?>