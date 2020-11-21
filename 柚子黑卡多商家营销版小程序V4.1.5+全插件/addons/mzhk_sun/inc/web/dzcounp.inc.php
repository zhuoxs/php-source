<?php
global $_GPC, $_W;
$GLOBALS['frames'] = $this->getMainMenu();

$where=" WHERE  a.uniacid=:uniacid and a.type=1 and a.isdelete=0";
$pageindex = max(1, intval($_GPC['page']));
$pagesize=10;
$data[':uniacid']=$_W['uniacid'];
$sql="select a.*,b.bname from " . tablename("mzhk_sun_coupon") . " a"  . " left join " . tablename("mzhk_sun_brand") . " b on a.bid=b.bid " .$where." order by a.id desc ";
$total=pdo_fetchcolumn("select count(*) as wname from " . tablename("mzhk_sun_coupon") . " a"  . " left join " . tablename("mzhk_sun_brand") . " b on a.bid=b.bid ".$where." order by a.id desc ",$data);
$select_sql =$sql." LIMIT " .($pageindex - 1) * $pagesize.",".$pagesize;
$list=pdo_fetchall($select_sql,$data);
$pager = pagination($total, $pageindex, $pagesize);

if($_GPC['op']=='delete'){
    if($_W['ispost']){
        // $res=pdo_delete('mzhk_sun_coupon',array('id'=>$_GPC['id'],'uniacid'=>$_W['uniacid']));
        $res=pdo_update('mzhk_sun_coupon',array('isdelete'=>1),array('id'=>$_GPC['id'],'uniacid'=>$_W['uniacid']));
        if($res){
            message('操作成功',$this->createWebUrl('dzcounp',array()),'success');

        }else{
            message('操作失败','','error');
        }
    }
}
if($_GPC['op']=='change'){
    $res=pdo_update('mzhk_sun_coupon',array('state'=>$_GPC['state']),array('id'=>$_GPC['id'],'uniacid'=>$_W['uniacid']));
    if($res){
        message('操作成功',$this->createWebUrl('dzcounp',array()),'success');
    }else{
        message('操作失败','','error');
    }
}

include $this->template('web/dzcounp');