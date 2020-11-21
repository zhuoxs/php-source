<?php
global $_GPC, $_W;
$GLOBALS['frames'] = $this->getMainMenu();
$item=pdo_get('chbl_sun_system',array('uniacid'=>$_W['uniacid']));
if(checksubmit('submit')){           
    $data['is_kanjiaopen']=$_GPC['is_kanjiaopen'];
    $data['uniacid']=$_W['uniacid'];
    $data['bargain_price']=$_GPC['bargain_price'];
    $data['bargain_title']=$_GPC['bargain_title'];
    if($_GPC['id']==''){                
        $res=pdo_insert('chbl_sun_system',$data);
        if($res){
            message('编辑成功',$this->createWebUrl('kanjiaopen',array()),'success');
        }else{
            message('编辑成功','','error');
        }
    }else{
        $res = pdo_update('chbl_sun_system', $data, array('id' => $_GPC['id']));
        if($res){
            message('编辑成功',$this->createWebUrl('kanjiaopen',array()),'success');
        }else{
            message('编辑失败','','error');
        }
    }
}
include $this->template('web/kanjiaopen');