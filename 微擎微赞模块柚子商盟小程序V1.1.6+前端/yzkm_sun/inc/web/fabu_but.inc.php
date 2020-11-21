<?php
global $_GPC, $_W;
$GLOBALS['frames'] = $this->getMainMenu();
$item=pdo_get('yzkm_sun_custom',array('uniacid'=>$_W['uniacid']));
if(checksubmit('submit')){           
    $data['key']=$_GPC['key'];
    $data['uniacid']=$_W['uniacid'];    
    if($_GPC['id']==''){                
        $res=pdo_insert('yzkm_sun_custom',$data);
        if($res){
            message('添加成功',$this->createWebUrl('fabu_but',array()),'success');
        }else{
            message('添加失败','','error');
        }
    }else{
        $res = pdo_update('yzkm_sun_custom', $data, array('id' => $_GPC['id']));
        if($res){
            message('编辑成功',$this->createWebUrl('fabu_but',array()),'success');
        }else{
            message('编辑失败','','error');
        }
    }
}
include $this->template('web/fabu_but');