<?php

global $_GPC, $_W;
$GLOBALS['frames'] = $this->getMainMenu();

$pageindex = max(1, intval($_GPC['page']));
$pagesize=10;
// 获取门店数据
//$build  = pdo_getall('ymmf_sun_buildhair',array('uniacid'=>$_W['uniacid']),'','','hair_id DESC');
$sql = "select * from ".tablename('ymmf_sun_buildhair')." where uniacid=".$_W['uniacid']." order by hair_id desc";
$select_sql =$sql." LIMIT " .($pageindex - 1) * $pagesize.",".$pagesize;
$build=pdo_fetchall($select_sql);

$total=pdo_fetchcolumn("select count(*) from".tablename('ymmf_sun_buildhair')." where uniacid={$_W['uniacid']} ");
$pager = pagination($total, $pageindex, $pagesize);

if($_GPC['op']==1){
    if($_GPC['build_id']!=0){
        $ids = array();
        foreach ($build as $k=>$v){
            if($v['build_id']==$_GPC['build_id']){
                $ids[$k] = $v['hair_id'];
            }
        }
        $ids = implode(',',$ids);
        $where=" WHERE  uniacid=:uniacid AND id in" . "(".$ids.")";
    }else{
        $where=" WHERE  uniacid=:uniacid ";
    }
}else{
    $where=" WHERE  uniacid=:uniacid ";
}

if($_GPC['keywords']){
    $op=$_GPC['keywords'];
    $where.=" and hair_name LIKE  concat('%', :name,'%') ";
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
$sql="select * from " . tablename("ymmf_sun_hairers").$where."  order by id desc ";
$total=pdo_fetchcolumn("select count(*) as wname from " . tablename("ymmf_sun_hairers") . $where."  order by id desc ",$data);
$select_sql =$sql." LIMIT " .($pageindex - 1) * $pagesize.",".$pagesize;

$list=pdo_fetchall($select_sql,$data);
foreach ($list as $k=>$v){
    foreach ($build as $kk=>$vv){
        if($v['id']==$vv['hair_id']){
            $list[$k]['b_name'] = pdo_getcolumn('ymmf_sun_branch',array('uniacid'=>$_W['uniacid'],'id'=>$vv['build_id']),'name');
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
$branch= pdo_getall('ymmf_sun_branch',array('uniacid'=>$_W['uniacid']));

if($_GPC['op']=='delete'){
    $iscun = pdo_get('ymmf_sun_buildhair',array('uniacid'=>$_W['uniacid'],'hair_id'=>$_GPC['id']));
    if($iscun){
        $res=pdo_delete('ymmf_sun_buildhair',array('hair_id'=>$_GPC['id']));
    }else{
        $none = 1;
    }
    if($res){
        message('删除成功！', $this->createWebUrl('building'), 'success');
    }else{
        if($none==1){
            message('删除失败！确定删除,请到技师列表','','error');
        }else{
            message('删除失败！','','error');
        }
    }
}
include $this->template('web/building');