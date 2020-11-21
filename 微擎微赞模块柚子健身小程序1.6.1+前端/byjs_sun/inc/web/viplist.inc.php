<?php
global $_GPC, $_W;
$GLOBALS['frames'] = $this->getMainMenu();
$info=pdo_get('byjs_sun_vip_user',array('uniacid' => $_W['uniacid']));
$pageindex = max(1, intval($_GPC['page']));

$pagesize=10;
$sql="select a.*,b.card_name,b.type,c.name  from " . tablename("byjs_sun_vip_user") . 'a left join '.tablename("byjs_sun_vipcard").'b on b.id=a.card_type_id left join '.tablename('byjs_sun_user').'c on c.id=a.uid WHERE ' . 'a.uniacid=' . $_W['uniacid'];
$select_sql =$sql." LIMIT " .($pageindex - 1) * $pagesize.",".$pagesize;
$list = pdo_fetchall($select_sql);

//print_r($sql);die;
$total=pdo_fetchcolumn("select count(*) from " . tablename("byjs_sun_vip_user"));
$pager = pagination($total, $pageindex, $pagesize);
if($_GPC['op']=='confirm'){
	$type=$_GPC['type'];
	$day=pdo_get('byjs_sun_storein',array('uniacid'=>$_W['uniacid'],'id'=>$type),'day')['day'];
	$data['card_status']=2;
	$data['endtime']=time()+$day*24*60*60;
   	$res4=pdo_update("byjs_sun_vip_user",$data,array('id'=>$_GPC['id'],'uniacid'=>$_W['uniacid']));
    if($res4){
        message('成功！', $this->createWebUrl('viplist'), 'success');
    }else{
        message('失败！','','error');
    }
}
//if($_GPC['op']=='defriend'){
//    $res4=pdo_update("byjs_sun_user_",array('state'=>2),array('id'=>$_GPC['id']));
//    if($res4){
//        message('拉黑成功！', $this->createWebUrl('user2',array('page'=>$_GPC['page'])), 'success');
//    }else{
//        message('拉黑失败！','','error');
//    }
//}
//if($_GPC['op']=='relieve'){
//    $res4=pdo_update("byjs_sun_user",array('state'=>1),array('id'=>$_GPC['id']));
//    if($res4){
//        message('取消成功！', $this->createWebUrl('user2',array('page'=>$_GPC['page'])), 'success');
//    }else{
//        message('取消失败！','','error');
//    }
//}

include $this->template('web/viplist');