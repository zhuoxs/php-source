<?php
global $_GPC, $_W;
$GLOBALS['frames'] = $this->getMainMenu();
$item=pdo_get('byjs_sun_cardindex',array('uniacid'=>$_W['uniacid']));
if(checksubmit('submit')){
    $data['is_open']=$_GPC['is_open'];
    $data['uniacid']=$_W['uniacid'];
    if($_GPC['id']==''){
        $res=pdo_insert('byjs_sun_cardindex',$data);
        if($res){
            message('添加成功',$this->createWebUrl('cardopen',array()),'success');
        }else{
            message('添加失败','','error');
        }
    }else{
        $res = pdo_update('byjs_sun_cardindex', $data, array('id' => $_GPC['id'],'uniacid'=>$_W['uniacid']));
        if($res){
            message('编辑成功',$this->createWebUrl('cardopen',array()),'success');
        }else{
            message('编辑失败','','error');
        }
    }
}
include $this->template('web/cardopen');