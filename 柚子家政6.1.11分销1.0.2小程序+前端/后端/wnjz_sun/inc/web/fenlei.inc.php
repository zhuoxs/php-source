<?php
global $_GPC, $_W;
$GLOBALS['frames'] = $this->getMainMenu();
$id=1;
$hair = pdo_get('wnjz_sun_hairers',['id'=>$id,'uniacid'=>$_W['uniacid']]);
$a = pdo_getall('wnjz_sun_service',['uniacid'=>$_W['uniacid'],'hair_id'=>$id]);
$b = pdo_getall('wnjz_sun_gallery',['uniacid'=>$_W['uniacid'],'hair_id'=>$id]);
$hair['gallery'] = $b;
$hair['service'] = $a;
p($hair);die;

//$list = pdo_getall('wnjz_sun_type',array('uniacid' => $_W['uniacid']),array(),'','num ASC');
    $type=pdo_getall('wnjz_sun_type',array('uniacid'=>$_W['uniacid']),array(),'','num asc');
    $type2=pdo_getall('wnjz_sun_type2',array('uniacid'=>$_W['uniacid']),array(),'','num asc');
    $sql=" select * from".tablename('wnjz_sun_label')." where type2_id in (select id from ".tablename('wnjz_sun_type2')." where uniacid={$_W['uniacid']})";
    $type3=pdo_getall('wnjz_sun_label');

      foreach ($type2 as $key => $value2) {
            $data2=$this->getSon2($value2['id'],$type3);
             $type2[$key]['bq']=$data2;
         }
      foreach($type as $key => $value){
         $data=$this->getSon($value['id'],$type2);
         $type[$key]['ej']=$data;
       
    }

if($_GPC['op']=='delete'){
    $res=pdo_delete('wnjz_sun_type',array('id'=>$_GPC['id']));
    if($res){
        message('删除成功',$this->createWebUrl('fenlei',array()),'success');
    }else{
        message('删除失败','','error');
    }
}
if($_GPC['op']=='change'){
	 $res=pdo_update('wnjz_sun_type',array('state'=>$_GPC['state']),array('id'=>$_GPC['id']));
    if($res){
        message('操作成功',$this->createWebUrl('fenlei',array()),'success');
    }else{
        message('操作失败','','error');
    }
}

if($_GPC['op']=='delete2'){
    $res=pdo_delete('wnjz_sun_type2',array('id'=>$_GPC['id']));
    if($res){
        message('删除成功',$this->createWebUrl('fenlei',array()),'success');
    }else{
        message('删除失败','','error');
    }
}

if($_GPC['op']=='change2'){
     $res=pdo_update('wnjz_sun_type2',array('state'=>$_GPC['state']),array('id'=>$_GPC['id']));
    if($res){
        message('操作成功',$this->createWebUrl('fenlei',array()),'success');
    }else{
        message('操作失败','','error');
    }
}
include $this->template('web/fenlei');