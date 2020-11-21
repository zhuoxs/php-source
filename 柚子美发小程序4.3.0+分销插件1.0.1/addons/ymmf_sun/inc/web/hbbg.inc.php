<?php
global $_GPC, $_W;
$GLOBALS['frames'] = $this->getMainMenu();
$info=pdo_get('ymmf_sun_system',array('uniacid'=>$_W['uniacid']));
if($info['goodspicbg']){
    $goodspicbg = $info['goodspicbg'];
}

if(checksubmit('submit')){
    $data['uniacid']=$_W['uniacid'];
    $data['goodspicbg']=$_GPC['goodspicbg'];

    if($_GPC['id']==''){
        $res=pdo_insert('ymmf_sun_system',$data,array('uniacid'=>$_W['uniacid']));


        if($res){
            message('添加成功',$this->createWebUrl('hbbg',array()),'success');
        }else{
            message('添加失败','','error');
        }

    }else{

        $res = pdo_update('ymmf_sun_system', $data, array('id' => $_GPC['id'],'uniacid'=>$_W['uniacid']));

        if($res){
            message('编辑成功',$this->createWebUrl('hbbg',array()),'success');
        }else{
            message('编辑失败','','error');
        }
    }
}
include $this->template('web/hbbg');