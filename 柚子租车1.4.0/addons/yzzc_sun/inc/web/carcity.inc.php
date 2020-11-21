<?php
global $_GPC, $_W;
$GLOBALS['frames'] = $this->getMainMenu();
//$list = pdo_getall('wyzc_sun_type',array('uniacid' => $_W['uniacid']),array(),'','num ASC');
$info = pdo_getall('yzzc_sun_carcity',array('uniacid'=>$_W['uniacid']),array(),'','zimu ASC');
foreach ($info as $key =>$val){
    $num=pdo_fetchcolumn("SELECT COUNT(id) FROM ".tablename('yzzc_sun_car')."where carcity = ".$val['id']);
    $info[$key]['num']=$num;
}
global $_W, $_GPC;

if(checksubmit('submit')){
    if($_GPC['name']==null) {
        message('请填写城市名称', '', 'error');
    }
    if($_GPC['zimu']==null) {
        message('请填写城市首字母', '', 'error');
    }
    $data['zimu']=$_GPC['zimu'];
    $data['name']=$_GPC['name'];
    $data['rec']=$_GPC['rec'];
    $data['uniacid']=$_W['uniacid'];

    if($_GPC['id']==''){
        $res=pdo_insert('yzzc_sun_carcity',$data,array('uniacid'=>$_W['uniacid']));
        if($res){
            message('添加成功',$this->createWebUrl('carcity',array()),'success');
        }else{
            message('添加失败','','error');
        }
    }
}
if($_GPC['op']=='rec2'){
    $res=pdo_update('yzzc_sun_carcity',array('rec'=>1),array('id'=>$_GPC['id'],'uniacid'=>$_W['uniacid']));
    if($res){
        message('推荐成功！', $this->createWebUrl('carcity'), 'success');
    }else{
        message('推荐失败！','','error');
    }
}
if($_GPC['op']=='rec1'){
    $res=pdo_update('yzzc_sun_carcity',array('rec'=>2),array('id'=>$_GPC['id'],'uniacid'=>$_W['uniacid']));
    if($res){
        message('取消推荐成功！', $this->createWebUrl('carcity'), 'success');
    }else{
        message('取消推荐失败！','','error');
    }
}
if($_GPC['op']=='delete'){

    $res=pdo_delete('yzzc_sun_carcity',array('id'=>$_GPC['id']));
    if($res){
        message('操作成功',$this->createWebUrl('carcity',array()),'success');
    }else{
        message('操作失败','','error');
    }

}
if($_GPC['op']=='change'){
    $res=pdo_update('yzzc_sun_carcity',array('status'=>$_GPC['states']),array('id'=>$_GPC['id']));
    if($res){
        message('操作成功',$this->createWebUrl('carcity',array()),'success');
    }else{
        message('操作失败','','error');
    }
}

include $this->template('web/carcity');