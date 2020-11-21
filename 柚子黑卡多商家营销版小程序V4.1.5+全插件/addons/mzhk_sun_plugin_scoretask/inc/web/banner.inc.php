<?php
global $_GPC, $_W;
$GLOBALS['frames'] = $this->getMainMenu();
$url=require_once 'wxapp_url_config.php';
$type = pdo_getall('mzhk_sun_type', array('uniacid' => $_W['uniacid'], 'state' => 1), array(), '', 'id asc');
$shop_url=array();
foreach($type as $k=>$val){
  $shop_url[$k]['name']=$val['type_name'];
  $shop_url[$k]['value']='mzhk_sun/pages/shop/shop?tid='.$val['id'];
}
$info=pdo_get('mzhk_sun_banner',array('uniacid' => $_W['uniacid']));
if($info['lb_imgs']){
    if(strpos($info['lb_imgs'],',')){
        $lb_imgs= explode(',',$info['lb_imgs']);
    }else{
        $lb_imgs=array(
            0=>$info['lb_imgs']
        );
    }
}

if(checksubmit('submit')){
    $data['bname']=$_GPC['bname'];
    $data['uniacid'] = $_W['uniacid'];
    if($_GPC['lb_imgs']){

        $data['lb_imgs']=implode(",",$_GPC['lb_imgs']);
    }else{
        $data['lb_imgs']='';
    }
    $url_type=$_GPC['url_type'];
 	$data['url_type']=$url_type;
    if($url_type==1){
      $data['url']=$_GPC['url'];
    }else if($url_type==2){
       $data['url']=$_GPC['shop_url'];
    }


    if($_GPC['id']==''){
        $res=pdo_insert('mzhk_sun_banner',$data);
        if($res){
            message('添加成功',$this->createWebUrl('banner',array()),'success');
        }else{
            message('添加失败','','error');
        }
    }else{

        $res = pdo_update('mzhk_sun_banner', $data, array('id' => $_GPC['id']));
        if($res){
            message('编辑成功',$this->createWebUrl('banner',array()),'success');
        }else{
            message('编辑失败','','error');
        }
    }
}
include $this->template('web/banner');