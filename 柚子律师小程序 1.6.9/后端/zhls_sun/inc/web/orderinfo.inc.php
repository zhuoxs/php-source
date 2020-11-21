<?php
global $_GPC, $_W;
$GLOBALS['frames'] = $this->getMainMenu();
$item=pdo_get('zhls_sun_order',array('id'=>$_GPC['id']));

if(checksubmit('submit')){
    if($_W['ispost']){
        $res = pdo_update('zhls_sun_order',['isdefault'=>$_GPC['isdefault'],'addtime'=>date('Y-m-d H:i:s',time())],['uniacid'=>$_W['uniacid'],'id'=>$_GPC['id']]);
        if($res){
            message('编辑成功！', $this->createWebUrl('ddgl'), 'success');
        }else{
            message('编辑失败！','','error');
        }
    }
}
include $this->template('web/orderinfo');