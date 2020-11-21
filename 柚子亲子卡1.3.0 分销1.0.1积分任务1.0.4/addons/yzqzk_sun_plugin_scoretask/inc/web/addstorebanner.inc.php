<?php
global $_GPC, $_W;
$GLOBALS['frames'] = $this->getMainMenu();
$url=require_once 'wxapp_url_config.php';
$type = pdo_getall('yzqzk_sun_activity_category', array('uniacid' => $_W['uniacid']), array(), '', 'id asc');
$store_name=pdo_getcolumn('yzqzk_sun_store',array('uniacid'=>$_W['uniacid'],'id'=>$_GPC['store_id']),'store_name',1);
$shop_url=array();
foreach($type as $k=>$val){
  $shop_url[$k]['name']=$val['title'];
  $shop_url[$k]['value']='/yzqzk_sun/pages/index/parenting/parenting?tid='.$val['id'];
}
$info=pdo_get('yzqzk_sun_customize',array('id'=>$_GPC['id']));
if(checksubmit('submit')){
    $data['uniacid']=$_W['uniacid'];
    $data['type']=5;
    $data['title']=$_GPC['title'];
    $data['pic']=$_GPC['pic'];
    $data['sort']=$_GPC['sort'];
    $data['add_time']= time();  
    $url_type=$_GPC['url_type'];
 	$data['url_type']=$url_type;
 	$data['store_id']=$_GPC['store_id'];
  
    if($url_type==1){
      $data['url']=$_GPC['url'];
      foreach($url as $v){
      	if($v['value']==$_GPC['url']){
        	$data['url_name']=$v['name'];
            break;
        }
      }
      
    }else if($url_type==2){
       $data['url']=$_GPC['shop_url'];
       foreach($shop_url as $v){
      	if($v['value']==$_GPC['shop_url']){
        	$data['url_name']=$v['name'];
            break;
        }
       }
 
    }
    if(empty($_GPC['id'])){  
        $res = pdo_insert('yzqzk_sun_customize', $data);
        if($res){
            message('添加成功',$this->createWebUrl('storebanner',array('store_id'=>$_GPC['store_id'])),'success');
        }else{
            message('添加失败','','error');
        }
    }else{
        $res = pdo_update('yzqzk_sun_customize', $data, array('id' => $_GPC['id']));
        if($res){
            message('编辑成功',$this->createWebUrl('storebanner',array('store_id'=>$_GPC['store_id'])),'success');
        }else{
            message('编辑失败','','error');
        }  
    }  
    
}
include $this->template('web/addstorebanner');