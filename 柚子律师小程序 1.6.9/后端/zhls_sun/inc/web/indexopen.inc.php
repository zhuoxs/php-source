<?php
global $_GPC, $_W;
$GLOBALS['frames'] = $this->getMainMenu();
$item=pdo_get('zhls_sun_winindex',array('uniacid'=>$_W['uniacid']));
//p($item);die;
if(checksubmit('submit')){           
    $data['is_open']=$_GPC['is_open'];
    $data['uniacid']=$_W['uniacid'];

    if($_GPC['id']==''){
        $res=pdo_insert('zhls_sun_winindex',$data);
        if($res){
            message('编辑成功',$this->createWebUrl('indexopen',array()),'success');
        }else{
            message('编辑成功','','error');
        }
    }else{
        $res = pdo_update('zhls_sun_winindex', $data, array('id' => $_GPC['id']));
        if($res){
            message('编辑成功',$this->createWebUrl('indexopen',array()),'success');
        }else{
            message('编辑失败','','error');
        }
    }
}
include $this->template('web/indexopen');