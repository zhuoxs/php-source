<?php

global $_GPC, $_W;
$GLOBALS['frames'] = $this->getMainMenu();
$where="where a.uniacid=:uniacid ";
//----------------审核状态--------------
if(!empty($_GPC['status'])&&empty($_GPC['keywords'])){
    $status = $_GPC['status'];
    $where.=" and a.status={$status} ";

}
//-------------名字搜索--------------
if(!empty($_GPC['keywords'])&&empty($_GPC['status'])){
    $keywords=$_GPC['keywords'];
    $where.=" and a.orderNum LIKE  concat('%', :name,'%') ";
    $data[':name']=$keywords;
}
else if(!empty($_GPC['status'])&&!empty($_GPC['keywords'])){
    $status = $_GPC['status'];
    $keywords=$_GPC['keywords'];
    $where .= "and a.status={$status} and a.orderNum LIKE concat('%',:name,'%')";
    $data[':name']=$_GPC['keywords'];
}

$data[':uniacid']=$_W['uniacid'];

$pageIndex = max(1, intval($_GPC['page']));
$pageSize=6;
$type=isset($_GPC['type'])?$_GPC['type']:'all';

$sql = "select a.*,a.one as two,b.gname,b.one,b.onename,b.twoname,b.threename,c.name,d.provinceName,d.cityName,d.countyName,d.detailInfo,d.telNumber,d.detailAddr from ".tablename('mzhk_sun_plugin_lottery_order')."a left join ".tablename('mzhk_sun_plugin_lottery_goods')."b on b.gid=a.gid left join ".tablename('mzhk_sun_user')."c on c.id=a.uid left join ".tablename('mzhk_sun_plugin_lottery_address')."d on d.adid=a.adid ".$where." ORDER BY a.status asc,a.oid desc";
$total=pdo_fetchcolumn("SELECT count(a.oid) FROM ".tablename('mzhk_sun_plugin_lottery_order')."a left join ".tablename('mzhk_sun_plugin_lottery_goods')."b on b.gid=a.gid left join ".tablename('mzhk_sun_user')."c on c.id=a.uid left join ".tablename('mzhk_sun_plugin_lottery_address')."d on d.adid=a.adid ".$where,$data);



$select_sql =$sql." LIMIT " .($pageIndex - 1) * $pageSize.",".$pageSize;
$lit=pdo_fetchall($select_sql,$data);

$pager = pagination($total, $pageIndex,$pageSize);

if($_GPC['op']=='delete'){
    $res=pdo_delete('mzhk_sun_plugin_lottery_order',array('orderNum'=>$_GPC['orderNum'],'uniacid'=>$_W['uniacid']));
    if($res){
         message('删除成功！', $this->createWebUrl('orderinfo'), 'success');
        }else{
              message('删除失败！','','error');
        }
}
if($_GPC['op']=='fh'){
    $res=pdo_update('mzhk_sun_plugin_lottery_order',array('status'=>6),array('orderNum'=>$_GPC['orderNum'],'uniacid'=>$_W['uniacid']));
    if($res){
         message('发货成功！', $this->createWebUrl('orderinfo'), 'success');
        }else{
              message('发货失败！','','error');
        }
}
if($_GPC['op']=='sh'){
    $res=pdo_update('mzhk_sun_plugin_lottery_order',array('status'=>5),array('orderNum'=>$_GPC['orderNum'],'uniacid'=>$_W['uniacid']));
    if($res){
         message('收货成功！', $this->createWebUrl('orderinfo'), 'success');
        }else{
              message('收货失败！','','error');
        }
}

include $this->template('web/orderinfo');