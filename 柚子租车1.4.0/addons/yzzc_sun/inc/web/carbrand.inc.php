<?php
global $_GPC, $_W;
$GLOBALS['frames'] = $this->getMainMenu();
//$list = pdo_getall('wyzc_sun_type',array('uniacid' => $_W['uniacid']),array(),'','num ASC');
$info = pdo_getall('yzzc_sun_carbrand',array('uniacid'=>$_W['uniacid']),array(),'','zimu ASC');
foreach ($info as $key =>$val){
    $num=pdo_fetchcolumn("SELECT COUNT(id) FROM ".tablename('yzzc_sun_car')."where carbrand = ".$val['id']);
    $info[$key]['num']=$num;
}

if(checksubmit('submit')){
    if($_GPC['name']==null) {
        message('请填写品牌名称', '', 'error');
    }
    if($_GPC['zimu']==null) {
        message('请填写品牌首字母', '', 'error');
    }
    $data['name']=$_GPC['name'];
    $data['zimu']=$_GPC['zimu'];
    $data['uniacid']=$_W['uniacid'];

    if($_GPC['id']==''){
        $res=pdo_insert('yzzc_sun_carbrand',$data,array('uniacid'=>$_W['uniacid']));
        if($res){
            message('添加成功',$this->createWebUrl('carbrand',array()),'success');
        }else{
            message('添加失败','','error');
        }
    }
}
if($_GPC['op']=='delete'){

    $res=pdo_delete('yzzc_sun_carbrand',array('id'=>$_GPC['id']));
    if($res){
        message('操作成功',$this->createWebUrl('carbrand',array()),'success');
    }else{
        message('操作失败','','error');
    }

}
if($_GPC['op']=='change'){
    $res=pdo_update('yzzc_sun_carbrand',array('status'=>$_GPC['states']),array('id'=>$_GPC['id']));
    if($res){
        message('操作成功',$this->createWebUrl('carbrand',array()),'success');
    }else{
        message('操作失败','','error');
    }
}

include $this->template('web/carbrand');