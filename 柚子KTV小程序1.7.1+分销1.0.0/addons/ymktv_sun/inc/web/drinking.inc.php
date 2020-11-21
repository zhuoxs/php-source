<?php

global $_GPC, $_W;
$GLOBALS['frames'] = $this->getMainMenu();
$type= isset($_GPC['type'])?$_GPC['type']:0;

$where = " where d.uniacid=".$_W['uniacid']." ";

if(!empty($_GPC['key_name'])){
    $key_name=$_GPC['key_name'];
    $where.=" and d.drink_name LIKE '%$key_name%'";
}

if(!empty($_GPC['time_start_end'])){
    $time_start_end = $_GPC["time_start_end"];
    if($time_start_end){
        $time_start_end_arr = explode(" - ",$time_start_end);
        if($time_start_end_arr){
            //$starttime = strtotime($time_start_end_arr[0]);
            //$endtime = strtotime($time_start_end_arr[1]);
            $where.=" and d.d_time >= '{$time_start_end_arr[0]}' and d.d_time <= '{$time_start_end_arr[1]}' ";
        }
    }
}

$sql = " SELECT d.*,dt.dtid,dt.dt_name FROM " . tablename('ymktv_sun_drinks') . " d " . "JOIN " . tablename('ymktv_sun_drinktype') . " dt " . " ON " . " d.dt_id=dt.dtid ".$where." ORDER BY d.sort DESC";

$list = pdo_fetchall($sql);

$drinktype = pdo_getall('ymktv_sun_drinktype',array('uniacid'=>$_W['uniacid']));

if($_GPC['op']=='delete'){
    $res=pdo_delete('ymktv_sun_drinks',array('id'=>$_GPC['id']));
    if($res){
         message('删除成功！', $this->createWebUrl('drinking'), 'success');
        }else{
              message('删除失败！','','error');
        }
}
if($_GPC['op']=='tg'){
    $res=pdo_update('ymktv_sun_drinks',array('state'=>2),array('id'=>$_GPC['id']));
    if($res){
         message('通过成功！', $this->createWebUrl('drinking'), 'success');
        }else{
              message('通过失败！','','error');
        }
}
if($_GPC['op']=='type'){
    $type = $_GPC['type'];
    if($type==0){
        $sql = ' SELECT d.*,dt.dtid,dt.dt_name FROM ' . tablename('ymktv_sun_drinks') . ' d ' . 'JOIN ' . tablename('ymktv_sun_drinktype') . ' dt ' . ' ON ' . ' d.dt_id=dt.dtid' . ' WHERE ' . ' d.uniacid=' . $_W['uniacid'] . ' ORDER BY d.sort DESC';
        $list = pdo_fetchall($sql);
    }else{
        $sql = ' SELECT d.*,dt.dtid,dt.dt_name FROM ' . tablename('ymktv_sun_drinks') . ' d ' . 'JOIN ' . tablename('ymktv_sun_drinktype') . ' dt ' . ' ON ' . ' d.dt_id=dt.dtid' . ' WHERE ' . ' d.uniacid=' . $_W['uniacid'] . ' AND ' . ' dt.dtid=' . $type . ' ORDER BY d.sort DESC';
        $list = pdo_fetchall($sql);
    }
}
include $this->template('web/drinking');