<?php
global $_GPC, $_W;
$GLOBALS['frames'] = $this->getMainMenu();

$pageindex = max(1, intval($_GPC['page']));
$pagesize=10;
$data[':uniacid']=$_W['uniacid'];

$status=$_GPC['status'];

if($status==1){
    $sql = ' SELECT a.title,a.price,b.* FROM ' . tablename('yzhd_sun_vip') . ' a ' . ' JOIN ' . tablename('yzhd_sun_vipcode') . ' b ' . ' ON ' . ' b.vipid=a.id ' . ' WHERE ' .  ' b.uniacid=' . $_W['uniacid'];
    $total=pdo_fetchcolumn("select count(*) from " . tablename("yzhd_sun_vip") . ' a ' . ' JOIN ' . tablename('yzhd_sun_vipcode') . ' b ' . ' ON ' . ' b.vipid=a.id '. ' WHERE ' . ' b.uniacid=' . $_W['uniacid']);
} elseif($status==2){
    $sql = ' SELECT a.title,a.price,b.* FROM ' . tablename('yzhd_sun_vip') . ' a ' . ' JOIN ' . tablename('yzhd_sun_vipcode') . ' b ' . ' ON ' . ' b.vipid=a.id ' . ' WHERE ' .  ' b.uniacid=' . $_W['uniacid']. ' AND ' .' b.vc_isuse=1';
    $total=pdo_fetchcolumn("select count(*) from " . tablename("yzhd_sun_vip") . ' a ' . ' JOIN ' . tablename('yzhd_sun_vipcode') . ' b ' . ' ON ' . ' b.vipid=a.id '. ' WHERE ' . ' b.uniacid=' . $_W['uniacid'] . ' AND ' .' b.vc_isuse=1');
} elseif($status==3){
    $sql = ' SELECT a.title,a.price,b.* FROM ' . tablename('yzhd_sun_vip') . ' a ' . ' JOIN ' . tablename('yzhd_sun_vipcode') . ' b ' . ' ON ' . ' b.vipid=a.id ' . ' WHERE ' .  ' b.uniacid=' . $_W['uniacid']. ' AND ' .' b.vc_isuse=0';
    $total=pdo_fetchcolumn("select count(*) from " . tablename("yzhd_sun_vip") . ' a ' . ' JOIN ' . tablename('yzhd_sun_vipcode') . ' b ' . ' ON ' . ' b.vipid=a.id '. ' WHERE ' . ' b.uniacid=' . $_W['uniacid'] . ' AND ' .' b.vc_isuse=0');
}else{
    $sql = ' SELECT a.title,a.price,b.* FROM ' . tablename('yzhd_sun_vip') . ' a ' . ' JOIN ' . tablename('yzhd_sun_vipcode') . ' b ' . ' ON ' . ' b.vipid=a.id ' . ' WHERE ' .  ' b.uniacid=' . $_W['uniacid'];
    $total=pdo_fetchcolumn("select count(*) from " . tablename("yzhd_sun_vip") . ' a ' . ' JOIN ' . tablename('yzhd_sun_vipcode') . ' b ' . ' ON ' . ' b.vipid=a.id '. ' WHERE ' . ' b.uniacid=' . $_W['uniacid']);
}

$select_sql =$sql." LIMIT " .($pageindex - 1) * $pagesize.",".$pagesize;
$list=pdo_fetchall($select_sql);

foreach ($list as $k=>$v){
    if($list[$k]['uid']==0){
        $list[$k]['openid'] = '0';
    }else{
        $list[$k]['openid'] = pdo_getcolumn('yzhd_sun_user',array('id'=>$v['uid'],'uniacid'=>$_W['uniacid']),'openid');
    }
    if($list[$k]['vc_isuse']==0){
        $list[$k]['use'] = '未使用';
    }else{
        $list[$k]['use'] = '已使用';
    }
}
$pager = pagination($total, $pageindex, $pagesize);
if($_GPC['op']=='delete'){

    //先查看是否存在激活码，有择不能删除
    $res=pdo_delete('yzhd_sun_vipcode',array('id'=>$_GPC['id']));
    if($res){
        message('操作成功',$this->createWebUrl('vipcodelist',array('status'=>1)),'success');
    }else{
        message('操作失败','','error');
    }
}
if($_GPC['op']=='change'){
    $res=pdo_update('yzhd_sun_vipcode',array('state'=>$_GPC['state']),array('id'=>$_GPC['id'],'uniacid'=>$_W['uniacid']));
    if($res){
        message('操作成功',$this->createWebUrl('vipcodelist',array('status'=>1)),'success');
    }else{
        message('操作失败','','error');
    }
}


if($_GPC['op']=='excel'){
    $new_array = array();
    foreach ($list as $k=>$v){
        $new_array[] = $v;
    }
    foreach ($new_array as $k=>$v){
        unset($new_array[$k]['id']);
        unset($new_array[$k]['vipid']);
        unset($new_array[$k]['vc_isuse']);
        unset($new_array[$k]['uniacid']);
        unset($new_array[$k]['uid']);

    }
    $this->toCSV('会员卡激活码'.date('ymdhis').'.csv',['粉丝卡类型名称','粉丝卡价格','VIP激活码','开始时间','过期时间','使用者/openid','使用状态'],$new_array);
    die;
}
//[$list['title'],$list['price'],$list['vc_code'],$list['use'],$list['openid']]
include $this->template('web/vipcodelist');