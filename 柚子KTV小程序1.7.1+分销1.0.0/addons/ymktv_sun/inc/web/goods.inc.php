<?php

global $_GPC, $_W;
$GLOBALS['frames'] = $this->getMainMenu();

$where = " where g.uniacid=".$_W['uniacid']." ";

if(!empty($_GPC['key_name'])){
    $key_name=$_GPC['key_name'];
    $where.=" and g.goods_name LIKE '%$key_name%'";
}

if(!empty($_GPC['time_start_end'])){
    $time_start_end = $_GPC["time_start_end"];
    if($time_start_end){
        $time_start_end_arr = explode(" - ",$time_start_end);
        if($time_start_end_arr){
            //$starttime = strtotime($time_start_end_arr[0]);
            //$endtime = strtotime($time_start_end_arr[1]);
            $where.=" and g.time >= '{$time_start_end_arr[0]}' and g.time <= '{$time_start_end_arr[1]}' ";
        }
    }
}

$sql = " SELECT * FROM " . tablename('ymktv_sun_type') . " t " . "JOIN " . tablename('ymktv_sun_goods') . " g " . " ON " . " g.type_id=t.id ".$where." ORDER BY g.sort DESC";
$list = pdo_fetchall($sql);


/*if($_GPC['keywords']){
    $op = $_GPC['keywords'];
    $sid = pdo_getcolumn('ymktv_sun_servies',array('uniacid'=>$_W['uniacid'],'servies_name like'=>'%'.$op.'%'),'sid');
    $sql = ' SELECT * FROM ' . tablename('ymktv_sun_type') . ' t ' . 'JOIN ' . tablename('ymktv_sun_goods') . ' g ' . ' ON ' . ' g.type_id=t.id' . ' WHERE ' . ' g.uniacid=' . $_W['uniacid'] . ' AND ' . ' g.s_sid='.$sid . ' ORDER BY g.sort DESC';
    $list = pdo_fetchall($sql);
    foreach ($list as $k=>$v){
        $list[$k]['servies_name'] = pdo_getcolumn('ymktv_sun_servies',array('uniacid'=>$_W['uniacid'],'sid'=>$v['s_sid']),'servies_name');
    }
}*/

if($_GPC['op']=='delete'){
    $res=pdo_delete('ymktv_sun_goods',array('id'=>$_GPC['id']));
    if($res){
         message('删除成功！', $this->createWebUrl('goods'), 'success');
        }else{
              message('删除失败！','','error');
        }
}
if($_GPC['op']=='tg'){
    $res=pdo_update('ymktv_sun_goods',array('state'=>2),array('id'=>$_GPC['id']));
    if($res){
         message('通过成功！', $this->createWebUrl('goods'), 'success');
        }else{
              message('通过失败！','','error');
        }
}
if($_GPC['op']=='jj'){
    $res=pdo_update('ymktv_sun_goods',array('state'=>3),array('id'=>$_GPC['id']));
    if($res){
         message('拒绝成功！', $this->createWebUrl('goods'), 'success');
        }else{
         message('拒绝失败！','','error');
        }
}
include $this->template('web/goods');