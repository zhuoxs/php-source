<?php
global $_GPC, $_W;
$GLOBALS['frames'] = $this->getMainMenu();
$item=pdo_get('yzhyk_sun_plugin_scoretask_order',array('id'=>$_GPC['id']));
$item['title']=pdo_getcolumn('yzhyk_sun_plugin_scoretask_goods',array('id'=>$item['gid']),'title');
if($item['order_status']==0){
    $item['status_z']='进行中';
}else if($item['order_status']==1){
    $item['status_z']='待发货';
}else if($item['order_status']==3){
    $item['status_z']='已完成';
}
if(checksubmit('submit')){
   if($_W['ispost']){
       $data=array(
           'fahuo_time'=>time(),
           'wc_time'=>time(),
           'order_status'=>3,
           'express_delivery'=>$_GPC['express_delivery'],
           'express_no'=>$_GPC['express_no'],
       );
       $res=pdo_update('yzhyk_sun_plugin_scoretask_order',$data,array('id'=>$_GPC['id']));
       if($res){
           message('发货成功',$this->createWebUrl('bookinfo',array()),'success');
       }
   }
}
include $this->template('web/bookinfo_edit');