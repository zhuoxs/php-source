<?php

global $_GPC, $_W;
$GLOBALS['frames'] = $this->getMainMenu();
$where = " WHERE  a.uniacid=".$_W['uniacid'];
if(!empty($_GPC['keywords'])){
    $op=$_GPC['keywords'];
    $where.=" and a.orderNumber LIKE  '%$op%'";
       $data[':name']=$op;
}
$state=$_GPC['state'];
$pageindex = max(1, intval($_GPC['page']));
$pagesize=5;
$type=isset($_GPC['type'])?$_GPC['type']:'all';
// $data[':uniacid']=$_W['uniacid'];
if($type=='all'){

    // $where.= " and d.state=1";
    $sql = "select a.*,b.name,b.user_tel,c.gname,c.pic from ".tablename('yzkm_sun_order')."a left join ".tablename('yzkm_sun_user')."b on a.userId=b.id left join".tablename('yzkm_sun_goods')."c on a.goodsId=c.gid ".$where;
    $lit=pdo_fetchall($sql);
    // p(1);
    // p($sql);
    // p($lit);die;
}else{
    $where.= " and a.state =$state ";
    // $where.= " and a.state =$state and d.state=1";
    $sql = "select a.*,b.name,b.user_tel,c.gname,c.pic  from ".tablename('yzkm_sun_order')."a left join ".tablename('yzkm_sun_user')."b on a.userId=b.id left join".tablename('yzkm_sun_goods')."c on a.goodsId=c.gid ".$where;
    $lit=pdo_fetchall($sql);
    // p(2);
    // p($sql);
    // p($lit);die;    
}
// $select_sql =$sql." LIMIT " .($pageindex - 1) * $pagesize.",".$pagesize;

// p($lit);die;

// $lits=array();
// // foreach ($lit as $k =>$v){
//     // $id = $v['id'];
//     // $wher="WHERE id=$id  AND uniacid =".$_W['uniacid'];
//     // $val ="select * from ".tablename("yzkm_sun_goods").$wher;
//     // $valu= pdo_fetch($val);
//     // $lits[$k]['gname']=$valu['gname'];
//     // $lits[$k]['openid']=$v['openid'];
//     $lits[$k]['orderNumber']=$v['orderNumber'];
//     $lits[$k]['phone']=$v['phone'];
//     $lits[$k]['addr']=$v['addr'];
//     $lits[$k]['time']=$v['time'];
//     $lits[$k]['goodsName']=$v['goodsName'];
//     $lits[$k]['userName']=$v['userName'];
//     // $lits[$k]['provinceName']=$v['provinceName'];
//     $lits[$k]['status']=$v['status'];
//     $lits[$k]['pic']=$v['pic'];

// }
// var_dump($lits);

$pager = pagination($total, $pageindex, $pagesize);
if($_GPC['op']=='delete'){
    $res=pdo_delete('yzkm_sun_order',array('id'=>$_GPC['id'],'uniacid'=>$_W['uniacid']));
    if($res){
         message('删除成功！', $this->createWebUrl('orderinfo'), 'success');
        }else{
              message('删除失败！','','error');
        }
}
if($_GPC['op']=='send'){
    $res=pdo_update('yzkm_sun_order',array('state'=>4),array('id'=>$_GPC['id'],'uniacid'=>$_W['uniacid']));
    if($res){
         message('发货成功！', $this->createWebUrl('orderinfo'), 'success');
        }else{
              message('发货失败！','','error');
        }
}
// if($_GPC['op']=='tg'){
//     $res=pdo_update('yzkm_sun_car',array('state'=>2,'sh_time'=>time()),array('id'=>$_GPC['id']));
//     if($res){
//          message('通过成功！', $this->createWebUrl('carinfo'), 'success');
//         }else{
//               message('通过失败！','','error');
//         }
// }
// if($_GPC['op']=='jj'){
//     $res=pdo_update('yzkm_sun_car',array('state'=>3,'sh_time'=>time()),array('id'=>$_GPC['id']));
//     if($res){
//          message('拒绝成功！', $this->createWebUrl('carinfo'), 'success');
//         }else{
//          message('拒绝失败！','','error');
//         }
// }
include $this->template('web/orderinfo');