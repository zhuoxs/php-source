<?php
global $_GPC, $_W;
$GLOBALS['frames'] = $this->getMainMenu();
$info=pdo_get('yzhyk_sun_plugin_scoretask_system',array('uniacid'=>$_W['uniacid']));
if(checksubmit('submit')){
    $data['uniacid']=$_W['uniacid'];
    $data['lottery_score']=$_GPC['lottery_score'];
    $data['lottery_rule']=htmlspecialchars_decode($_GPC['lottery_rule']);
    if($_GPC['id']==''){
        $res=pdo_insert('yzhyk_sun_plugin_scoretask_system',$data);
        if($res){
            message('添加成功',$this->createWebUrl('lotteryset',array()),'success');
        }else{
            message('添加失败','','error');
        }
    }else{
        $res = pdo_update('yzhyk_sun_plugin_scoretask_system', $data, array('id' => $_GPC['id']));
        if($res){
            message('编辑成功',$this->createWebUrl('lotteryset',array()),'success');
        }else{
            message('编辑失败','','error');
        }
    }
}
include $this->template('web/lotteryset');