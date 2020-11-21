<?php
global $_GPC, $_W;
$GLOBALS['frames'] = $this->getMainMenu();
//$list = pdo_getall('wyzc_sun_type',array('uniacid' => $_W['uniacid']),array(),'','num ASC');
$info = pdo_getall('yzzc_sun_cartype',array('uniacid'=>$_W['uniacid']));
foreach ($info as $key =>$val){
    $num=pdo_fetchcolumn("SELECT COUNT(id) FROM ".tablename('yzzc_sun_goods')."where cartype = ".$val['id']);
    $info[$key]['num']=$num;
}
global $_W, $_GPC;

if(checksubmit('submit')){
    if($_GPC['name']==null) {
        message('请填写分类名称', '', 'error');
    }
    $data['name']=$_GPC['name'];
    $data['uniacid']=$_W['uniacid'];

    if($_GPC['id']==''){
        $res=pdo_insert('yzzc_sun_cartype',$data,array('uniacid'=>$_W['uniacid']));
        if($res){
            message('添加成功',$this->createWebUrl('cartype',array()),'success');
        }else{
            message('添加失败','','error');
        }
    }
}
if($_GPC['op']=='delete'){

    $res=pdo_delete('yzzc_sun_cartype',array('id'=>$_GPC['id']));
    if($res){
        message('操作成功',$this->createWebUrl('cartype',array()),'success');
    }else{
        message('操作失败','','error');
    }

}
if($_GPC['op']=='change'){
    $res=pdo_update('yzzc_sun_cartype',array('status'=>$_GPC['states']),array('id'=>$_GPC['id']));
    if($res){
        message('操作成功',$this->createWebUrl('cartype',array()),'success');
    }else{
        message('操作失败','','error');
    }
}

include $this->template('web/cartype');