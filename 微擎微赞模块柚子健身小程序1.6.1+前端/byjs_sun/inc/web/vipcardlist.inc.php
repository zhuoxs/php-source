<!--会员卡列表-->
<?php
global $_GPC, $_W;
$GLOBALS['frames'] = $this->getMainMenu();
$info=pdo_get('byjs_sun_vipcard',array('uniacid' => $_W['uniacid']));

$pageindex = max(1, intval($_GPC['page']));

$pagesize=10;
$sql="select a.*,b.name  from " . tablename("byjs_sun_vipcard") . ' a left join '.tablename("byjs_sun_storein").'b on b.id = a.type WHERE ' . 'a.uniacid=' . $_W['uniacid'];
$select_sql =$sql." LIMIT " .($pageindex - 1) * $pagesize.",".$pagesize;
$list = pdo_fetchall($select_sql);

$total=pdo_fetchcolumn("select count(*) from " . tablename("byjs_sun_user_vipcard"));
$pager = pagination($total, $pageindex, $pagesize);

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
if($_GPC['op'] == 'delete'){
    	$res = pdo_delete('byjs_sun_vipcard',array('id' => $_GPC['id'],'uniacid'=>$_W['uniacid']));
        if($res){
                    message('删除成功',$this->createWebUrl('vipcardlist',array()),'success');
                }else{
                    message('删除失败','','error');
                }
    }
include $this->template('web/vipcardlist');