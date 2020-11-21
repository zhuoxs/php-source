<?php

global $_GPC, $_W;

$GLOBALS['frames'] = $this->getMainMenu();
$where=" WHERE  a.uniacid=:uniacid ";
if($_GPC['branch_id']){
    $branch_id = $_GPC['branch_id'];
    $where.=" and a.branch_id={$_GPC['branch_id']} ";
}
if($_GPC['keywords']){
    $branch_id = $_GPC['branch_id'];
    $op=$_GPC['keywords'];
    $where.=" and a.goods_name LIKE  concat('%', :name,'%') and a.branch_id={$branch_id}";
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
$sql="select a.*,b.name from " . tablename("yzhd_sun_caipin") . " a"  . " left join " . tablename("yzhd_sun_branch") . " b on a.branch_id=b.id" .$where."  order by a.create_time desc ";
$total=pdo_fetchcolumn("select count(*) as wname from " . tablename("yzhd_sun_caipin") . " a"  . " left join " . tablename("yzhd_sun_branch") . " b on a.branch_id=b.id".$where."  order by a.create_time desc ",$data);
$select_sql =$sql." LIMIT " .($pageindex - 1) * $pagesize.",".$pagesize;

$list=pdo_fetchall($select_sql,$data);

foreach ($list as $k=>$v){
    $list[$k]['catename'] = pdo_getcolumn('yzhd_sun_category',array('uniacid'=>$_W['uniacid'],'cid'=>$v['cate_name']),'cname');
}

$pager = pagination($total, $pageindex, $pagesize);
if($_GPC['op']=='delete'){
    $res=pdo_delete('yzhd_sun_caipin',array('cid'=>$_GPC['gid']));
    if($res){
        message('删除成功！', $this->createWebUrl('caipin',array('type'=>'all','brnach_id'=>$_GPC['branch_id'])), 'success');
    }else{
        message('删除失败！','','error');
    }
}
if($_GPC['op']=='tg'){
    $res=pdo_update('yzhd_sun_caipin',array('state'=>2),array('cid'=>$_GPC['gid']));
    if($res){
        message('通过成功！', $this->createWebUrl('caipin',array('type'=>'all','branch_id'=>$_GPC['branch_id'])), 'success');
    }else{
        message('通过失败！','','error');
    }
}
if($_GPC['op']=='jj'){
    $res=pdo_update('yzhd_sun_caipin',array('state'=>3),array('cid'=>$_GPC['gid']));
    if($res){
        message('拒绝成功！', $this->createWebUrl('caipin',array('type'=>'all','brnach_id'=>$_GPC['branch_id'])), 'success');
    }else{
        message('拒绝失败！','','error');
    }
}

include $this->template('web/caipin');