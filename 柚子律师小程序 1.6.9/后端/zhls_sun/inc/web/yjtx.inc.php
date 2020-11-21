<?php
global $_GPC, $_W;
// $action = 'ad';
// $title = $this->actions_titles[$action];
$GLOBALS['frames'] = $this->getMainMenu();
$operation = !empty($_GPC['op']) ? $_GPC['op'] : 'display';
$type=empty($_GPC['type']) ? 'all' :$_GPC['type'];
$status=$_GPC['status'];
$pageindex = max(1, intval($_GPC['page']));
$pagesize=10;
$where=' WHERE  a.uniacid=:uniacid and a.is_del=1';
$data[':uniacid']=$_W['uniacid'];
if($_GPC['keywords']){
    $where.=" and c.cityname LIKE  concat('%', :name,'%') ";    
    $data[':name']=$_GPC['keywords'];
}
if($type=='all'){    
  $sql="SELECT a.*,b.username,c.cityname FROM ".tablename('zhls_sun_yjtx') .  " a"  . " left join " . tablename("users") . " b on a.account_id=b.uid left join " . tablename("zhls_sun_account") . " c on a.account_id=c.uid ". $where." ORDER BY a.cerated_time DESC";
  $total=pdo_fetchcolumn("SELECT count(*) FROM ".tablename('zhls_sun_yjtx') .  " a"  . " left join " . tablename("users") . " b on a.account_id=b.uid left join " . tablename("zhls_sun_account") . " c on a.account_id=c.uid ". $where." ORDER BY a.cerated_time DESC",$data);
}else{
    $where.= " and a.status=$status";
    $sql="SELECT a.*,b.username,c.cityname FROM ".tablename('zhls_sun_yjtx') .  " a"  . " left join " . tablename("users") . " b on a.account_id=b.uid left join " . tablename("zhls_sun_account") . " c on a.account_id=c.uid ". $where." ORDER BY a.cerated_time DESC";
    $data[':uniacid']=$_W['uniacid'];
    $total=pdo_fetchcolumn("SELECT count(*) FROM ".tablename('zhls_sun_yjtx') .  " a"  . " left join " . tablename("users") . " b on a.account_id=b.uid left join " . tablename("zhls_sun_account") . " c on a.account_id=c.uid ". $where." ORDER BY a.cerated_time DESC",$data);    
}
$list=pdo_fetchall( $sql,$data);
$select_sql =$sql." LIMIT " .($pageindex - 1) * $pagesize.",".$pagesize;
$list=pdo_fetchall($select_sql,$data);
$pager = pagination($total, $pageindex, $pagesize);


if($operation=='adopt'){//审核通过
    $id=$_GPC['id'];
    $res=pdo_update('zhls_sun_yjtx',array('status'=>2,'time'=>date('Y-m-d H:i:s')),array('id'=>$id));  
    if($res){
        message('审核成功',$this->createWebUrl('yjtx',array()),'success');
    }else{
        message('审核失败','','error');
    }
}
if($operation=='reject'){
     $id=$_GPC['id'];
    $res=pdo_update('zhls_sun_yjtx',array('status'=>3),array('id'=>$id));
     if($res){
        message('拒绝成功',$this->createWebUrl('yjtx',array()),'success');
    }else{
        message('拒绝失败','','error');
    }
}
if($operation=='delete'){
     $id=$_GPC['id'];
     $res=pdo_update('zhls_sun_yjtx',array('is_del'=>2),array('id'=>$id));
     if($res){
        message('删除成功',$this->createWebUrl('yjtx',array()),'success');
    }else{
        message('删除失败','','error');
    }

}

include $this->template('web/yjtx');