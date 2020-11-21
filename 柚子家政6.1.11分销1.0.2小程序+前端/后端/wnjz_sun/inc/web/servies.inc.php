<?php

global $_GPC, $_W;
$GLOBALS['frames'] = $this->getMainMenu();

// 获取门店数据
$build  = pdo_getall('wnjz_sun_buildservies',array('uniacid'=>$_W['uniacid']),'','','s_id DESC');
if($_GPC['op']==1){
    if($_GPC['build_id']!=0){
        $ids = array();
        foreach ($build as $k=>$v){
            if($v['build_id']==$_GPC['build_id']){
                $ids[$k] = $v['s_id'];
            }
        }
        $ids = implode(',',$ids);
        if(empty($ids)){
            $where=" WHERE  uniacid=:uniacid ";
        }else{
            $where=" WHERE  uniacid=:uniacid AND sid in" . "(".$ids.")";
        }

    }else{
        $where=" WHERE  uniacid=:uniacid ";
    }
}else{
    $where=" WHERE  uniacid=:uniacid ";
}

if($_GPC['keywords']){
    $op=$_GPC['keywords'];
    $where.=" and servies_name LIKE  concat('%', :servies_name,'%') ";
    $data[':servies_name']=$op;
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
$sql="select * from " . tablename("wnjz_sun_servies").$where."  order by sid desc ";
$total=pdo_fetchcolumn("select count(*) as wname from " . tablename("wnjz_sun_servies") . $where."  order by sid desc ",$data);
$select_sql =$sql." LIMIT " .($pageindex - 1) * $pagesize.",".$pagesize;

$list=pdo_fetchall($select_sql,$data);
foreach ($list as $k=>$v){
    foreach ($build as $kk=>$vv){
        if($v['sid']==$vv['s_id']){
            $list[$k]['b_name'] = pdo_getcolumn('wnjz_sun_branch',array('uniacid'=>$_W['uniacid'],'id'=>$vv['build_id']),'name');
        }
    }
}
foreach ($list as $k=>$v){
    if(!$v['b_name']){
        $list[$k]['b_name'] = '暂未分配';
        $list[$k]['build_id'] = 0;
    }
}

$pager = pagination($total, $pageindex, $pagesize);
// 获取门店数据
$branch= pdo_getall('wnjz_sun_branch',array('uniacid'=>$_W['uniacid']));

if($_GPC['op']=='delete'){
    $iscun = pdo_get('wnjz_sun_buildservies',array('uniacid'=>$_W['uniacid'],'s_id'=>$_GPC['sid']));
    if($iscun){
        $res=pdo_delete('wnjz_sun_buildservies',array('s_id'=>$_GPC['sid']));
    }else{
        $none = 1;
    }
    if($res){
        message('删除成功！', $this->createWebUrl('servies'), 'success');
    }else{
        if($none==1){
            message('删除失败！确定删除,请到技师列表','','error');
        }else{
            message('删除失败！','','error');
        }
    }
}

include $this->template('web/servies');