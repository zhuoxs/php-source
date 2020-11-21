<?php

global $_GPC, $_W;

$GLOBALS['frames'] = $this->getMainMenu();
$where="where a.uniacid=:uniacid ";

// ----------------审核状态--------------
if(!empty($_GPC['status'])&&empty($_GPC['keywords'])&&empty($_GPC['cid'])&&empty($_GPC['sid'])){
    $status = $_GPC['status'];
    $where.=" and a.status={$status} ";
}
//-------------名字搜索--------------
if(!empty($_GPC['keywords'])&&empty($_GPC['status'])&&empty($_GPC['cid'])&&empty($_GPC['sid'])){
    $keywords=$_GPC['keywords'];
    $where.=" and a.gname LIKE  concat('%', :name,'%') ";
    $data[':name']=$keywords;
}
//-------------礼物类型--------------
if(empty($_GPC['keywords'])&&empty($_GPC['status'])&&!empty($_GPC['cid'])&&empty($_GPC['sid'])){
    $cid = $_GPC['cid'];
    $where.=" and a.type={$cid} ";
}
else if(empty($_GPC['keywords'])&&empty($_GPC['status'])&&empty($_GPC['cid'])&&!empty($_GPC['sid'])){
    $sid = $_GPC['sid'];
    if($_GPC['sid']==1){
        $where.=" and a.sid!='' ";
    }else{
        $where.=" and a.sid=0 ";
    }
}
else if(!empty($_GPC['status'])&&!empty($_GPC['keywords'])&&empty($_GPC['cid'])&&empty($_GPC['sid'])){
    $status = $_GPC['status'];
    $keywords=$_GPC['keywords'];
    $where .= "and a.status={$status} and a.gname LIKE concat('%',:name,'%')";
    $data[':name']=$_GPC['keywords'];
}
else if(!empty($_GPC['status'])&&empty($_GPC['keywords'])&&!empty($_GPC['cid'])&&empty($_GPC['sid'])){
    $status = $_GPC['status'];
    $cid = $_GPC['cid'];
    $where .= "and a.status={$status} and a.type={$cid}";
}
else if(!empty($_GPC['status'])&&empty($_GPC['keywords'])&&empty($_GPC['cid'])&&!empty($_GPC['sid'])){
    $status = $_GPC['status'];
    $sid = $_GPC['sid'];
    if($_GPC['sid']==1){
        $where.="and a.status={$status} and a.sid!=0 ";
    }else{
        $where.="and a.status={$status} and a.sid=0 ";
    }
}
else if(empty($_GPC['status'])&&!empty($_GPC['keywords'])&&!empty($_GPC['cid'])&&empty($_GPC['sid'])){
    $keywords=$_GPC['keywords'];
    $cid = $_GPC['cid'];
    $where .= "and a.type={$cid} and a.gname LIKE concat('%',:name,'%')";
    $data[':name']=$_GPC['keywords'];
}
else if(empty($_GPC['status'])&&!empty($_GPC['keywords'])&&empty($_GPC['cid'])&&!empty($_GPC['sid'])){
    $keywords=$_GPC['keywords'];
    $sid = $_GPC['sid'];
    if($_GPC['sid']==1){
        $where.="and a.gname LIKE concat('%',:name,'%') and a.sid!=0 ";
    }else{
        $where.="and a.gname LIKE concat('%',:name,'%') and a.sid=0 ";
    }
    $data[':name']=$_GPC['keywords'];
}
else if(empty($_GPC['status'])&&empty($_GPC['keywords'])&&!empty($_GPC['cid'])&&!empty($_GPC['sid'])){
    $cid = $_GPC['cid'];
    $sid = $_GPC['sid'];
    if($_GPC['sid']==1){
        $where.="and a.type={$cid} and a.sid!=0 ";
    }else{
        $where.="and a.type={$cid} and a.sid=0 ";
    }
}
else if(!empty($_GPC['status'])&&!empty($_GPC['keywords'])&&!empty($_GPC['cid'])&&empty($_GPC['sid'])){
    $status = $_GPC['status'];
    $keywords=$_GPC['keywords'];
    $cid = $_GPC['cid'];
    $where .= "and a.status={$status} and a.gname LIKE concat('%',:name,'%') and a.type={$cid} ";
    $data[':name']=$_GPC['keywords'];
}
else if(!empty($_GPC['status'])&&!empty($_GPC['keywords'])&&empty($_GPC['cid'])&&!empty($_GPC['sid'])){
    $status = $_GPC['status'];
    $keywords=$_GPC['keywords'];
    $sid = $_GPC['sid'];
    if($_GPC['sid']==1){
        $where .= "and a.status={$status} and a.gname LIKE concat('%',:name,'%')  and a.sid!=0";
    }else{
        $where .= "and a.status={$status} and a.gname LIKE concat('%',:name,'%')  and a.sid==0";
    }
    $data[':name']=$_GPC['keywords'];
}
else if(!empty($_GPC['status'])&&empty($_GPC['keywords'])&&!empty($_GPC['cid'])&&!empty($_GPC['sid'])){
    $status = $_GPC['status'];
    $cid = $_GPC['cid'];
    $sid = $_GPC['sid'];
    if($_GPC['sid']==1){
        $where .= "and a.status={$status}  and a.type={$cid} and a.sid!=0";
    }else{
        $where .= "and a.status={$status}  and a.type={$cid} and a.sid=0";
    }
}
else if(empty($_GPC['status'])&&!empty($_GPC['keywords'])&&!empty($_GPC['cid'])&&!empty($_GPC['sid'])){
    $keywords=$_GPC['keywords'];
    $cid = $_GPC['cid'];
    $sid = $_GPC['sid'];
    if($_GPC['sid']==1){
        $where .= " and a.gname LIKE concat('%',:name,'%') and a.type={$cid} and a.sid!=0";
    }else{
        $where .= " and a.gname LIKE concat('%',:name,'%') and a.type={$cid} and a.sid=0";
    }
    $data[':name']=$_GPC['keywords'];
}
else if(!empty($_GPC['status'])&&!empty($_GPC['keywords'])&&!empty($_GPC['cid'])&&!empty($_GPC['sid'])){
    $status = $_GPC['status'];
    $keywords=$_GPC['keywords'];
    $cid = $_GPC['cid'];
    $sid = $_GPC['sid'];
    if($_GPC['sid']==1){
        $where .= "and a.status={$status} and a.gname LIKE concat('%',:name,'%') and a.type={$cid} and a.sid!=0";
    }else{
        $where .= "and a.status={$status} and a.gname LIKE concat('%',:name,'%') and a.type={$cid} and a.sid=0";
    }
    $data[':name']=$_GPC['keywords'];
}
// p($where);
$pageIndex = max(1, intval($_GPC['page']));
$pageSize=8;

$type=isset($_GPC['type'])?$_GPC['type']:'all';
$DrawType=$_GPC['DrawType'];
$initiate=$_GPC['initiate'];

$data[':uniacid']=$_W['uniacid'];

$Giftstype=pdo_getall('yzcj_sun_type',array('uniacid'=>$_W['uniacid']));

$sql="SELECT a.*,b.`type`,c.`sname` FROM ".tablename('yzcj_sun_gifts'). " a"  . " left join " . tablename("yzcj_sun_type") . " b on b.id=a.type left join ". tablename("yzcj_sun_sponsorship") ." c on c.sid=a.sid ".$where. " ORDER BY a.status asc,a.id desc";
$total=pdo_fetchcolumn("SELECT count(*) FROM ".tablename('yzcj_sun_gifts'). " a" ." left join " . tablename("yzcj_sun_type") . " b on b.id=a.type ".$where,$data);

$select_sql =$sql." LIMIT " .($pageIndex - 1) * $pageSize.",".$pageSize;

$list=pdo_fetchall($select_sql,$data);

$pager = pagination($total, $pageIndex, $pageSize);


if($_GPC['op']=='delete'){
    // $gname=$_GPC['gname'];
    // $cid=$_GPC['cid'];
    // $status=$_GPC['status'];
    // $count=$_GPC['count'];
    $res=pdo_delete('yzcj_sun_gifts',array('id'=>$_GPC['id'],'uniacid'=>$_W['uniacid']));
    // $order=pdo_getall('yzcj_sun_order',array('id'=>$_GPC['id'],'uniacid'=>$_W['uniacid']));
    // if(!empty($order)){
    //     $result=pdo_delete('yzcj_sun_order',array('id'=>$_GPC['id'],'uniacid'=>$_W['uniacid']));
    // }
    
    if($res){
        // pdo_commit();
        message('删除成功！', $this->createWebUrl('gifts'), 'success');
    }else{
        // pdo_rollback();
        message('删除失败！','','error');
    }
}
if($_GPC['op']=='tg'){
    // p($_GPC['id']);die;
    $res=pdo_update('yzcj_sun_gifts',array('status'=>2),array('id'=>$_GPC['id'],'uniacid'=>$_W['uniacid']));
    if($res){
          message('通过成功！', $this->createWebUrl('gifts'), 'success');
        }else{
          message('通过失败！','','error');
        }
}
if($_GPC['op']=='ty'){
    // p($_GPC['id']);die;
    $res=pdo_update('yzcj_sun_gifts',array('status'=>1),array('id'=>$_GPC['id'],'uniacid'=>$_W['uniacid']));
    if($res){
          message('停用成功！', $this->createWebUrl('gifts'), 'success');
        }else{
          message('停用失败！','','error');
        }
}
if($_GPC['op']=='jj'){
    $res=pdo_update('yzcj_sun_gifts',array('status'=>3),array('id'=>$_GPC['id'],'uniacid'=>$_W['uniacid']));
    if($res){
         message('拒绝成功！', $this->createWebUrl('gifts'), 'success');
        }else{
         message('拒绝失败！','','error');
        }
}
include $this->template('web/gifts');