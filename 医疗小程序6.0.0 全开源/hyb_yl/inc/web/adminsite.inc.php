<?php
global $_W,$_GPC;

load()->func('tpl');
$uniacid = $_W['uniacid'];
$op = !empty($_GPC['op']) ? $_GPC['op'] : 'display';
if($op == 'kaiqi'){
    $hy_id =$_GPC['hy_id'];
  if(empty($hy_id)){
       pdo_insert("hyb_yl_hyzhucesite",array('hy_type'=>1,'uniacid'=>$uniacid));
       message("开启成功!",$this->createWebUrl("adminsite",array("op"=>"display")),"success");
  }else{
      pdo_update("hyb_yl_hyzhucesite",array('hy_type'=>1),array('uniacid'=>$uniacid));
      message("开启成功!",$this->createWebUrl("adminsite",array("op"=>"display")),"success");
  }

}
if($op == 'guanbi'){
  pdo_update("hyb_yl_hyzhucesite",array('hy_type'=>0),array('uniacid'=>$uniacid));
  message("关闭成功!",$this->createWebUrl("adminsite",array("op"=>"display")),"success");
}
if($op =='display'){
    //会员注册

      $hy = pdo_get("hyb_yl_hyzhucesite",array('uniacid'=>$uniacid));
      $total = pdo_fetchcolumn('SELECT COUNT(*) FROM '.tablename("hyb_yl_adminusersite")."where uniacid = '{$uniacid}'");
      $pindex = max(1, intval($_GPC['page'])); 
      $pagesize = 10;
      $p = ($pindex-1) * $pagesize; 
      $products = pdo_fetchall('SELECT * FROM '.tablename('hyb_yl_adminusersite')." where uniacid = '{$uniacid}' ORDER BY admin_id limit ".$p.",".$pagesize);
      foreach ($products as $key => $value) {
        $products[$key]['times'] = date('Y-m-d H:i:s',$products[$key]['times']);
      }  
    }
    if($op =='post'){
          $admin_id  =$_GPC['admin_id'];
          $items =pdo_fetch('SELECT * FROM'.tablename('hyb_yl_adminusersite')."where uniacid='{$uniacid}' and admin_id='{$admin_id}'");
        if(checksubmit()){
            
             $data = array(
                 'uniacid'  =>$_W['uniacid'],
                 'adusername'    =>$_GPC['adusername'],
                 'aduserdenqx'    =>$_GPC['aduserdenqx'],
                 'adusermoney'    =>$_GPC['adusermoney'],
                 'aduserzhekou'    =>$_GPC['aduserzhekou'],
                 'times'  =>strtotime('now'),
                 'types' =>'month'
            );
             //var_dump($data);exit();
             if(empty($admin_id)){
                pdo_insert('hyb_yl_adminusersite',$data);
                message("添加成功!",$this->createWebUrl("adminsite",array("op"=>"display")),"success");
             }else{
                pdo_update('hyb_yl_adminusersite',$data,array('uniacid'=>$uniacid,'admin_id'=>$admin_id));
                message("更新成功!",$this->createWebUrl("adminsite",array("op"=>"display")),"success");
             }
        }

    }
    if($op =='delete'){
       $admin_id  =$_GPC['admin_id'];
       pdo_delete("hyb_yl_adminusersite",array('admin_id'=>$admin_id,'uniacid'=>$uniacid));
       message("删除成功!",$this->createWebUrl("adminsite",array("op"=>"display")),"success");
    }

include $this->template("adminsite/adminsite");