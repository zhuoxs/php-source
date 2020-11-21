<?php
global $_GPC, $_W;
$GLOBALS['frames'] = $this->getMainMenu();

$item=pdo_get('mzhk_sun_system',array('uniacid'=>$_W['uniacid']));

if(checksubmit('submit')){
    $data['isbusiness']=$_GPC['isbusiness'];
	$data['license']=html_entity_decode($_GPC['license']);
	$data['icplicense']=html_entity_decode($_GPC['icplicense']);
	$data['agreement']=html_entity_decode($_GPC['agreement']);
	$data['policy']=html_entity_decode($_GPC['policy']);

	if($_GPC['id']==''){ 
        $res=pdo_insert('mzhk_sun_system',$data);
        if($res){
            message('添加成功',$this->createWebUrl('business',array()),'success');
        }else{
            message('添加失败','','error');
        }
    }else{
        $res = pdo_update('mzhk_sun_system', $data, array('id' => $_GPC['id']));
        if($res){
            message('编辑成功',$this->createWebUrl('business',array()),'success');
        }else{
            message('编辑失败','','error');
        }
    }
}


include $this->template('web/business');