<?php
defined('IN_IA') or exit('Access Denied');
global $_GPC, $_W;
$uniacid = $_W['uniacid'];
$op = !empty($_GPC['op']) ? $_GPC['op'] : 'display';
if($op == 'display'){
    //积分设置
    $res = pdo_get('hyb_yl_jifensite',array('uniacid'=>$uniacid));
    $res['show_thumb'] =unserialize($res['show_thumb']);
    $data =array(
         'uniacid'=>$uniacid,
         'show_thumb'=>serialize($_GPC['show_thumb']),
         'qdjifen' =>$_GPC['qdjifen'],
         'jifensx' =>$_GPC['jifensx'],
         'guize'   =>$_GPC['guize']
        );

    if(checksubmit()){
       $j_id = $_GPC['j_id'];
       if(empty($j_id)){
         pdo_insert('hyb_yl_jifensite',$data);
         message("添加成功!",$this->createWebUrl("jifensite",array("op"=>"display")),"success");
       }else{
         pdo_update('hyb_yl_jifensite',$data,array('j_id'=>$j_id));
         message("修改成功!",$this->createWebUrl("jifensite",array("op"=>"display")),"success");
       }
    }
}
if($op == 'post'){
   //积分商城
}
include $this->template('jifensite/jifensite');