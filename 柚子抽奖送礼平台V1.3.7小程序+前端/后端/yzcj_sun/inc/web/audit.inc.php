<?php
global $_GPC, $_W;
$GLOBALS['frames'] = $this->getMainMenu();
$info=pdo_get('yzcj_sun_audit',array('uniacid'=>$_W['uniacid']));

if(checksubmit('submit')){

        $data['status']=$_GPC['status'];
        $data['uniacid']=$_W['uniacid'];

    if($_GPC['id']==''){

        $res1=pdo_insert('yzcj_sun_audit',$data,array('uniacid'=>$_W['uniacid']));

        if($res1){
            message('添加成功！', $this->createWebUrl('audit'), 'success');
        }else{
            message('添加失败！','','error');
        }
    }else{

        $res1=pdo_update('yzcj_sun_audit',$data,array('id'=>$_GPC['id'],'uniacid'=>$_W['uniacid']));
        if($res1){
             message('编辑成功！', $this->createWebUrl('audit'), 'success');
        }else{
             message('编辑失败！','','error');
        }
    }
}
include $this->template('web/audit');