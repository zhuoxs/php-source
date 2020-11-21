<?php
global $_GPC, $_W;

$GLOBALS['frames'] = $this->getMainMenu();
$item=pdo_get('mzhk_sun_system',array('uniacid'=>$_W['uniacid']));
if(checksubmit('submit')){
    $data['store_open']=intval($_GPC['store_open']);
	$data['wxcode_open']=intval($_GPC['wxcode_open']);
	$data['allow_open']=intval($_GPC['allow_open']);
    $data['store_in_notice']=html_entity_decode($_GPC['store_in_notice']);
    $data['store_in_name']=$_GPC['store_in_name']?$_GPC['store_in_name']:"商家入驻";
	$data['open_payment']=intval($_GPC['open_payment']);
    
    
	$brands = pdo_getall('mzhk_sun_brand',array('uniacid'=>$_W['uniacid']),array('bid','open_payment'));
	if($data["open_payment"]==1){//全部开启线下付
		foreach($brands as $k=>$v){
			pdo_update('mzhk_sun_brand',array('open_payment'=>1),array('bid'=>$v['bid']));
		}
	}else{//全部不开启线下付
		foreach($brands as $k=>$v){
			pdo_update('mzhk_sun_brand',array('open_payment'=>0),array('bid'=>$v['bid']));
		}
	}
	
	
	if($_GPC['id']==''){  
        $data['uniacid']=$_W['uniacid'];                  
        $res=pdo_insert('mzhk_sun_system',$data);
        if($res){
            message('添加成功',$this->createWebUrl('storeset',array()),'success');
        }else{
            message('添加失败','','error');
        }
    }else{
        $res = pdo_update('mzhk_sun_system', $data, array('id' => $_GPC['id']));
        if($res){
            message('编辑成功',$this->createWebUrl('storeset',array()),'success');
        }else{
            message('编辑失败','','error');
        }
    }
}
include $this->template('web/storeset');