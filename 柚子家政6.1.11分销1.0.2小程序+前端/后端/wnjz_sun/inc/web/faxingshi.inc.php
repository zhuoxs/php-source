<?php
global $_GPC, $_W;
$GLOBALS['frames'] = $this->getMainMenu();

 global $_W, $_GPC;
    $type=pdo_getall('wnjz_sun_hairers',array('uniacid'=>$_W['uniacid']),array(),'','num asc');
//    $type2 = pdo_getall('wnjz_sun_gallery');
//    $type3=pdo_getall('wnjz_sun_label');

//      foreach($type as $key => $value){
//         $data=$this->getSon($value['id'],$type2);
//         $type[$key]['ej']=$data;
//
//    }

if($_GPC['op']=='delete'){
    $res=pdo_delete('wnjz_sun_hairers',array('id'=>$_GPC['id']));
    if($res){
        message('删除成功',$this->createWebUrl('faxingshi',array()),'success');
    }else{
        message('删除失败','','error');
    }
}
if($_GPC['op']=='change'){
	 $res=pdo_update('wnjz_sun_hairers',array('state'=>$_GPC['state']),array('id'=>$_GPC['id']));
    if($res){
        message('操作成功',$this->createWebUrl('faxingshi',array()),'success');
    }else{
        message('操作失败','','error');
    }
}

include $this->template('web/faxingshi');