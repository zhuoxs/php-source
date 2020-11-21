<?php
global $_GPC, $_W;
load()->func('tpl');
$GLOBALS['frames'] = $this->getMainMenu();

$pageindex = max(1, intval($_GPC['page']));
$pagesize=10;

$sql = "select * from ".tablename('ymmf_sun_new_bargain')." where uniacid=".$_W['uniacid']." order by id desc";
$select_sql =$sql." LIMIT " .($pageindex - 1) * $pagesize.",".$pagesize;
$list=pdo_fetchall($select_sql);

$total=pdo_fetchcolumn("select count(*) from".tablename('ymmf_sun_new_bargain')." where uniacid={$_W['uniacid']} ");
$pager = pagination($total, $pageindex, $pagesize);

if($_GPC['op']=='delete'){
        $res=pdo_delete('ymmf_sun_new_bargain',array('id'=>$_GPC['id'],'uniacid'=>$_W['uniacid']));
        if($res){
            message('操作成功',$this->createWebUrl('bargainlist',array()),'success');
        }else{
            message('操作失败','','error');
        }

}
if($_GPC['op']=='change') {
    $res = pdo_update('ymmf_sun_new_bargain', array('status' => $_GPC['status']), array('id' => $_GPC['id']));
    if ($res) {
        message('操作成功', $this->createWebUrl('bargainlist', array()), 'success');
    } else {
        message('操作失败', '', 'error');
    }
}
if($_GPC['op']=='done'){
    $status= intval($_GPC['status']);
    if($status == 1) {
        $res=pdo_update('ymmf_sun_new_bargain',array('status'=>$_GPC['status']),array('id'=>$_GPC['id'],'uniacid'=>$_W['uniacid']));
        message('活动开启成功！', $this->createWebUrl('bargainlist'), 'success');
    }else{

        pdo_update('ymmf_sun_new_bargain', array('status'=>$_GPC['status']), array('id'=>$_GPC['id'],'uniacid'=>$_W['uniacid']));
        message('活动关闭成功！', referer(), 'success');

    }

}
//if($_GPC['op']=='gb'){
//    $res=pdo_update('ymmf_sun_new_bargain',array('status'=>2),array('id'=>$_GPC['id'],'uniacid'=>$_W['uniacid']));
//    if($res){
//        message('关闭成功！', $this->createWebUrl('bargainlist'), 'success');
//    }else{
//        message('关闭失败！','','error');
//    }
//}
include $this->template('web/bargainlist');