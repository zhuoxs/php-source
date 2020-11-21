<?php
global $_GPC, $_W;
// $action = 'ad';
// $title = $this->actions_titles[$action];
$GLOBALS['frames'] = $this->getMainMenu();
$item=pdo_get('zhls_sun_yjset',array('uniacid'=>$_W['uniacid']));
if(checksubmit('submit')){
    if($_GPC['type']==1){
       $data['type']=$_GPC['type'];
       $data['typer']=$_GPC['typer'];
       $data['sjper']='';
       $data['hyper']='';
       $data['pcper']='';
       $data['tzper']='';
   }
  if($_GPC['type']==2){
   $data['type']=$_GPC['type'];
   $data['typer']='';
   $data['sjper']=$_GPC['sjper'];
   $data['hyper']=$_GPC['hyper'];
   $data['pcper']=$_GPC['pcper'];
   $data['tzper']=$_GPC['tzper'];
}
$data['uniacid']=$_W['uniacid'];
if($_GPC['id']==''){                
    $res=pdo_insert('zhls_sun_yjset',$data);
    if($res){
        message('添加成功',$this->createWebUrl('commission',array()),'success');
    }else{
        message('添加失败','','error');
    }
}else{
    $res = pdo_update('zhls_sun_yjset', $data, array('id' => $_GPC['id']));
    if($res){
        message('编辑成功',$this->createWebUrl('commission',array()),'success');
    }else{
        message('编辑失败','','error');
    }
}
}
include $this->template('web/commission');