<?php
global $_GPC, $_W;
$GLOBALS['frames'] = $this->getMainMenu();

if($_GPC['op']=='delete'){
    $res=pdo_update('yzqzk_sun_mercapdetails',array('del_status'=>1),array('id'=>$_GPC['id'],'uniacid'=>$_W['uniacid']));
    if($res){
        message('删除成功！', $this->createWebUrl('mercapdetails'), 'success');
    }else{
        message('删除失败！','','error');
    }
}else{
    $where=" WHERE uniacid=:uniacid ";
    $keyword = $_GPC['keyword'];
    if($_GPC['keyword']){
        $op=$_GPC['keyword'];
        $where.=" and store_name LIKE  '%$op%'";
    }
    $type=isset($_GPC['type'])?$_GPC['type']:'all';
    if($_GPC["type"]=='s'){
        $status = intval($_GPC['status']);
        if($status!=999){
            $where .= " and mcd_type=:status ";
            $data[':status']=$status;
        }
    }else{
        $status = 999;
    }
    $data[':uniacid']=$_W['uniacid'];
    $where .= " and del_status=0 ";
    $pageindex = max(1, intval($_GPC['page']));
    $pagesize=10;
    $sql="select * from " . tablename("yzqzk_sun_mercapdetails") ." ".$where." order by id desc ";
    $total=pdo_fetchcolumn("select count(*) as wname from " . tablename("yzqzk_sun_mercapdetails") . " " .$where." ",$data);
    $select_sql =$sql." LIMIT " .($pageindex - 1) * $pagesize.",".$pagesize;
    $list=pdo_fetchall($select_sql,$data);
    $pager = pagination($total, $pageindex, $pagesize);

    //提现方式
    $widthdraw = array("","订单收入","提现",'提现审核失败','核销订单完成收入','提现失败返还');
}
include $this->template('web/mercapdetails');