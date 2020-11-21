<?php
global $_GPC, $_W;
$GLOBALS['frames'] = $this->getMainMenu();
$item=pdo_get('mzhk_sun_goods',array('uniacid'=>$_W['uniacid']));
if(checksubmit('submit')){
    $data['is_jkopen']=$_GPC['is_jkopen'];
    $res = pdo_update('mzhk_sun_goods', $data,array('uniacid'=>$_W['uniacid']));
    if($res){
        message('编辑成功',$this->createWebUrl('jksing',array()),'success');
    }else{
        message('编辑失败','','error');
    }

}
include $this->template('web/jksing');