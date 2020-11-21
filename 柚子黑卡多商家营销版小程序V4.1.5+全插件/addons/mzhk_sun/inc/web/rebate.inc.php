<?php
global $_GPC, $_W;
$GLOBALS['frames'] = $this->getMainMenu();

$rebatetypes = array("","%","元");

$info=pdo_get('mzhk_sun_system',array('uniacid'=>$_W['uniacid']));


if(checksubmit('submit')){
    
    $data['uniacid']=trim($_W['uniacid']);
	$data["firstorder_open"] = $_GPC["firstorder_open"];
	$data["firstorder"] = $_GPC["firstorder"];
	$data["firstmoney"] = $_GPC["firstmoney"];
	$data["rebate_open"] = $_GPC["rebate_open"];
	$data["rebatetype"] = $_GPC["rebatetype"];
	$data["rebatemoney"] = $_GPC["rebatemoney"];
	$data["ordernum"] = $_GPC["ordernum"];

    if($_GPC['id']==''){                
        $res=pdo_insert('mzhk_sun_system',$data,array('uniacid'=>$_W['uniacid']));
        if($res){
            message('添加成功',$this->createWebUrl('rebate',array()),'success');
        }else{
            message('添加失败','','error');
        }
    }else{
        $res = pdo_update('mzhk_sun_system', $data, array('id' => $_GPC['id'],'uniacid'=>$_W['uniacid']));
        if($res){
            message('编辑成功',$this->createWebUrl('rebate',array()),'success');
        }else{
            message('编辑失败','','error');
        }
    }
}
include $this->template('web/rebate');