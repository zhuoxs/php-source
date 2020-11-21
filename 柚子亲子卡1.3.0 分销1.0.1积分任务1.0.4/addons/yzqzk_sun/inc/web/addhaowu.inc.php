<?php
global $_GPC, $_W;
$GLOBALS['frames'] = $this->getMainMenu();
$info=pdo_get('yzqzk_sun_goods',array('id'=>$_GPC['id']));
$spec=pdo_getall('yzqzk_sun_goods_spec');
$type=pdo_getall('yzqzk_sun_type',array('uniacid'=>$_W['uniacid'],'state'=>1));
$goods=pdo_getall('yzqzk_sun_goods',array('uniacid'=>$_W['uniacid'],'lid'=>array(1,2,4,5,6)));
if($info['imgs']){
    if(strpos($info['imgs'],',')){
        $imgs= explode(',',$info['imgs']);
    }else{
        $imgs=array(
            0=>$info['imgs']
        );
    }
}
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
/*    if(empty($_GPC['goods_name'])){
        message('请填写商品名称');
    }

    if($_GPC['imgs']){
        $data['imgs']=implode(",",$_GPC['imgs']);
    }else{
        $data['imgs']='';
    }
    if($_GPC['lb_imgs']){
        $data['lb_imgs']=implode(",",$_GPC['lb_imgs']);
    }else{
        $data['lb_imgs']='';
    }*/
    $data['uniacid']=$_GPC['__uniacid'];
  /* $data['goods_name']=$_GPC['goods_name'];
    $data['goods_cost']=$_GPC['goods_cost'];
   $data['goods_price']=$_GPC['goods_price'];
    $data['goods_volume']=$_GPC['goods_volume'];
    $data['spec_name']=$_GPC['spec_name'];
    $data['spec_value']=$_GPC['spec_value'];
    $data['spec_names']=$_GPC['spec_names'];
    $data['spec_values']=$_GPC['spec_values'];
    $data['type_id']=$_GPC['type_id'];
    $data['freight']=$_GPC['freight'];
    $data['delivery']=$_GPC['delivery'];
    $data['quality']=$_GPC['quality'];*/
    $data['goods_details']=htmlspecialchars_decode($_GPC['goods_details']);
  /*  $data['free']=$_GPC['free'];
    $data['all_day']=$_GPC['all_day'];
    $data['service']=$_GPC['service'];
    $data['refund']=$_GPC['refund'];
    $data['weeks']=$_GPC['weeks'];*/
    $data['time']= time();
    $data['lid']=3;
 //   $data['num']=$_GPC['num'];
    $data['title']=$_GPC['title'];
    $data['title_dec']=$_GPC['title_dec'];
    $data['haowuimg']=$_GPC['haowuimg'];
    $data['haowu_info']=$_GPC['haowu_info'];
    $data['video']=$_GPC['video'];
    $data['show_recommend']=$_GPC['show_recommend'];
    $data['show_columns']=$_GPC['show_columns'];
//    $data['tag']=$_GPC['tag'];
    $data['show_index']=$_GPC['show_index'];
    $data['related_gid']=$_GPC['related_gid'];
    if(empty($_GPC['id'])){
        $res = pdo_insert('yzqzk_sun_goods', $data);
    }else{
        $res = pdo_update('yzqzk_sun_goods', $data, array('id' => $_GPC['id']));
    }
    if($res){
        message('编辑成功',$this->createWebUrl('haowu',array()),'success');
    }else{
        message('编辑失败','','error');
    }
}
include $this->template('web/addhaowu');