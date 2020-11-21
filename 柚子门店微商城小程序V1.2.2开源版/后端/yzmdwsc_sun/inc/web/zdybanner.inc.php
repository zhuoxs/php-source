<?php
global $_GPC, $_W;
$GLOBALS['frames'] = $this->getMainMenu();
$operation = !empty($_GPC['op']) ? $_GPC['op'] : 'display';
$where=" WHERE  uniacid=:uniacid ";
$where.=" and type=1 ";
if($_GPC['keywords']){
    $op=$_GPC['keywords'];
    $where.=" and a.goods_name LIKE  concat('%', :name,'%') ";
    $data[':name']=$op;
}
if($_GPC['state']){
    $where.=" and a.state={$_GPC['state']} ";
}
if(!empty($_GPC['time'])){
    $start=strtotime($_GPC['time']['start']);
    $end=strtotime($_GPC['time']['end']);
    $where.=" and a.time >={$start} and a.time<={$end}";
}
$state=$_GPC['state'];
$pageindex = max(1, intval($_GPC['page']));
$pagesize=10;
$type=isset($_GPC['type'])?$_GPC['type']:'all';
$data[':uniacid']=$_W['uniacid'];
$sql="select * from " . tablename("yzmdwsc_sun_customize").$where."  order by id desc ";
$total=pdo_fetchcolumn("select count(*) as wname from " .tablename("yzmdwsc_sun_customize") .$where."  order by id desc ",$data);
$select_sql =$sql." LIMIT " .($pageindex - 1) * $pagesize.",".$pagesize;
$list=pdo_fetchall($select_sql,$data);
if($list){
   foreach($list as &$val){
      $val['nickname']=pdo_getcolumn('yzmdwsc_sun_user', array('uniacid' => $_W['uniacid'],'openid'=>$val['openid']), 'name',1);
   }
}
 
$pager = pagination($total, $pageindex, $pagesize);
if($_GPC['op']=='delete'){
    $res=pdo_delete('yzmdwsc_sun_customize',array('id'=>$_GPC['id']));
    if($res){
        message('删除成功！', $this->createWebUrl('zdybanner'), 'success'); 
    }else{
        message('删除失败！','','error');
    }
}
if($operation == 'done'){
    $id = intval($_GPC['id']);
    $row = pdo_fetch("SELECT id FROM " . tablename('yzmdwsc_sun_customize') . " WHERE id = :id", array(':id' => $id));
    if (empty($row)) {
        message('抱歉，活动不存在或是已经被删除！');
    }

    $status= intval($_GPC['status']);
    if($status == 1)
    {
        $condition = ' WHERE `uniacid` = :uniacid AND `status` =:status ';
        $params = array(':uniacid' => $_W['uniacid'],':status'=>$status);
        $active = pdo_fetch("SELECT id FROM " . tablename('yzmdwsc_sun_customize') .$condition , $params);
        pdo_update('yzmdwsc_sun_customize', array('status'=>$status), array('id' => $id));
        message('活动开启成功！', referer(), 'success');

    }else{
        pdo_update('yzmdwsc_sun_customize', array('status'=>$status), array('id' => $id));
        message('活动关闭成功！', referer(), 'success');
    }
}

if($_GPC['op']=='tg'){
    $res=pdo_update('yzmdwsc_sun_customize',array('status'=>2),array('id'=>$_GPC['id']));
    if($res){
        message('通过成功！', $this->createWebUrl('goods'), 'success');
    }else{
        message('通过失败！','','error');
    }
}
if($_GPC['op']=='jj'){
    $res=pdo_update('yzmdwsc_sun_customize',array('state'=>3),array('id'=>$_GPC['id']));
    if($res){
        message('拒绝成功！', $this->createWebUrl('goods'), 'success');
    }else{
        message('拒绝失败！','','error');
    }
}
include $this->template('web/zdybanner');