<?php
global $_GPC, $_W;
$GLOBALS['frames'] = $this->getMainMenu();

$url=require_once 'wxapp_url_config.php';
$type = pdo_getall('mzhk_sun_activity_category', array('uniacid' => $_W['uniacid']), array(), '', 'id asc');
$shop_url=array();
foreach($type as $k=>$val){
  $shop_url[$k]['name']=$val['title'];
  $shop_url[$k]['value']='/mzhk_sun/pages/index/parenting/parenting?tid='.$val['id'];
}
$info=pdo_get('mzhk_sun_plugin_scoretask_customize',array('id'=>$_GPC['id']));
if(checksubmit('submit')){
    $data['uniacid']=$_W['uniacid'];
    $data['type']=3 ;
    $data['title']=$_GPC['title'];
    $data['clickago_icon']=$_GPC['clickago_icon'];
    $data['clickafter_icon']=$_GPC['clickafter_icon'];
    $data['sort']=$_GPC['sort'];
    $data['add_time']= time();  
    $url_type=$_GPC['url_type'];
 	$data['url_type']=$url_type;
  
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
        $res = pdo_insert('mzhk_sun_plugin_scoretask_customize', $data);
        if($res){
            message('添加成功',$this->createWebUrl('zdytab',array()),'success');
        }else{
            message('添加失败','','error');
        }
    }else{
        $res = pdo_update('mzhk_sun_plugin_scoretask_customize', $data, array('id' => $_GPC['id']));
        if($res){
            message('编辑成功',$this->createWebUrl('zdytab',array()),'success');
        }else{
            message('编辑失败','','error');
        }  
    }  
    
}
include $this->template('web/addzdytab');