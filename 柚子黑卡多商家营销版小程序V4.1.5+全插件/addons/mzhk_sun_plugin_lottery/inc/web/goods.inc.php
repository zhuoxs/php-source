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
//-------------抽奖类型--------------
if(empty($_GPC['keywords'])&&empty($_GPC['status'])&&!empty($_GPC['cid'])&&empty($_GPC['sid'])){
    $cid = $_GPC['cid'];
    $where.=" and cid={$_GPC['cid']} ";
}
else if(empty($_GPC['keywords'])&&empty($_GPC['status'])&&empty($_GPC['cid'])&&!empty($_GPC['sid'])){
    $sid = $_GPC['sid'];
    if($_GPC['sid']==1){
        $where.=" and a.sid!='' ";
    }else{
        $where.=" and a.uid!='' ";
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
    $where .= "and a.status={$status} and cid={$cid}";
}
else if(!empty($_GPC['status'])&&empty($_GPC['keywords'])&&empty($_GPC['cid'])&&!empty($_GPC['sid'])){
    $status = $_GPC['status'];
    $sid = $_GPC['sid'];
    if($_GPC['sid']==1){
        $where.="and a.status={$status} and a.sid!='' ";
    }else{
        $where.="and a.status={$status} and a.uid!='' ";
    }
}
else if(empty($_GPC['status'])&&!empty($_GPC['keywords'])&&!empty($_GPC['cid'])&&empty($_GPC['sid'])){
    $keywords=$_GPC['keywords'];
    $cid = $_GPC['cid'];
    $where .= "and cid={$cid} and a.gname LIKE concat('%',:name,'%')";
    $data[':name']=$_GPC['keywords'];
}
else if(empty($_GPC['status'])&&!empty($_GPC['keywords'])&&empty($_GPC['cid'])&&!empty($_GPC['sid'])){
    $keywords=$_GPC['keywords'];
    $sid = $_GPC['sid'];
    if($_GPC['sid']==1){
        $where.="and a.gname LIKE concat('%',:name,'%') and a.sid!='' ";
    }else{
        $where.="and a.gname LIKE concat('%',:name,'%') and a.uid!='' ";
    }
    $data[':name']=$_GPC['keywords'];
}
else if(empty($_GPC['status'])&&empty($_GPC['keywords'])&&!empty($_GPC['cid'])&&!empty($_GPC['sid'])){
    $cid = $_GPC['cid'];
    $sid = $_GPC['sid'];
    if($_GPC['sid']==1){
        $where.="and cid={$cid} and a.sid!='' ";
    }else{
        $where.="and cid={$cid} and a.uid!='' ";
    }
}
else if(!empty($_GPC['status'])&&!empty($_GPC['keywords'])&&!empty($_GPC['cid'])&&empty($_GPC['sid'])){
    $status = $_GPC['status'];
    $keywords=$_GPC['keywords'];
    $cid = $_GPC['cid'];

    $where .= "and a.status={$status} and a.gname LIKE concat('%',:name,'%') and cid={$cid} ";

    
    $data[':name']=$_GPC['keywords'];
}
else if(!empty($_GPC['status'])&&!empty($_GPC['keywords'])&&empty($_GPC['cid'])&&!empty($_GPC['sid'])){
    $status = $_GPC['status'];
    $keywords=$_GPC['keywords'];
    $sid = $_GPC['sid'];
    if($_GPC['sid']==1){

        $where .= "and a.status={$status} and a.gname LIKE concat('%',:name,'%')  and a.sid!=''";
    }else{

        $where .= "and a.status={$status} and a.gname LIKE concat('%',:name,'%')  and a.uid!=''";
    }
    
    $data[':name']=$_GPC['keywords'];
}
else if(!empty($_GPC['status'])&&empty($_GPC['keywords'])&&!empty($_GPC['cid'])&&!empty($_GPC['sid'])){
    $status = $_GPC['status'];
    $cid = $_GPC['cid'];
    $sid = $_GPC['sid'];
    if($_GPC['sid']==1){

        $where .= "and a.status={$status}  and cid={$cid} and a.sid!=''";
    }else{

        $where .= "and a.status={$status}  and cid={$cid} and a.uid!=''";
    }

}
else if(empty($_GPC['status'])&&!empty($_GPC['keywords'])&&!empty($_GPC['cid'])&&!empty($_GPC['sid'])){
    $keywords=$_GPC['keywords'];
    $cid = $_GPC['cid'];
    $sid = $_GPC['sid'];
    if($_GPC['sid']==1){

        $where .= " and a.gname LIKE concat('%',:name,'%') and cid={$cid} and a.sid!=''";
    }else{

        $where .= " and a.gname LIKE concat('%',:name,'%') and cid={$cid} and a.uid!=''";
    }
    
    $data[':name']=$_GPC['keywords'];
}
else if(!empty($_GPC['status'])&&!empty($_GPC['keywords'])&&!empty($_GPC['cid'])&&!empty($_GPC['sid'])){
    $status = $_GPC['status'];
    $keywords=$_GPC['keywords'];
    $cid = $_GPC['cid'];
    $sid = $_GPC['sid'];
    if($_GPC['sid']==1){

        $where .= "and a.status={$status} and a.gname LIKE concat('%',:name,'%') and cid={$cid} and a.sid!=''";
    }else{

        $where .= "and a.status={$status} and a.gname LIKE concat('%',:name,'%') and cid={$cid} and a.uid!=''";
    }
    
    $data[':name']=$_GPC['keywords'];
}
// p($where);
$pageIndex = max(1, intval($_GPC['page']));
$pageSize=8;

$type=isset($_GPC['type'])?$_GPC['type']:'all';
$DrawType=$_GPC['DrawType'];
$initiate=$_GPC['initiate'];
// p($DrawType);die;
$data[':uniacid']=$_W['uniacid'];

$sql="SELECT a.*,b.`sname` FROM ".tablename('mzhk_sun_plugin_lottery_goods'). " a"  . " left join " . tablename("mzhk_sun_plugin_lottery_sponsorship") . " b on b.sid=a.sid ".$where. " ORDER BY a.status asc,a.gid desc";
$total=pdo_fetchcolumn("SELECT count(*) FROM ".tablename('mzhk_sun_plugin_lottery_goods'). " a" ." left join " . tablename("mzhk_sun_plugin_lottery_sponsorship") . " b on b.sid=a.sid ".$where,$data);

$select_sql =$sql." LIMIT " .($pageIndex - 1) * $pageSize.",".$pageSize;

$list=pdo_fetchall($select_sql,$data);
foreach ($list as $key => $value) {
    if($value['isbuy']==1){
        $list[$key]['bindcount']=pdo_fetchcolumn('select count(*) as count from '.tablename('mzhk_sun_goods')." where iscj = 1 and cjid = ".$value['gid']." and uniacid = ".$_W['uniacid']);
    }
}

$pager = pagination($total, $pageIndex, $pageSize);


if($_GPC['op']=='delete'){

    $gname=$_GPC['gname'];
    $cid=$_GPC['cid'];

    $status=$_GPC['status'];
    $count=$_GPC['count'];

    if($cid==2&&$status==2){

        $uid=pdo_get('mzhk_sun_plugin_lottery_goods',array('gid'=>$_GPC['gid'],'uniacid'=>$_W['uniacid']),'uid')['uid'];
        $sid=pdo_get('mzhk_sun_plugin_lottery_goods',array('gid'=>$_GPC['gid'],'uniacid'=>$_W['uniacid']),'sid')['sid'];
      //退钱
      if(!empty($uid)){
        //余额
        $money=pdo_get('mzhk_sun_user',array('id'=>$uid,'uniacid'=>$_W['uniacid']),'money')['money'];
        $nowmoney=$gname*$count+$money;
        $data1['money']=$nowmoney;
      }else{
        $uid=pdo_get('mzhk_sun_plugin_lottery_sponsorship',array('sid'=>$sid,'uniacid'=>$_W['uniacid'],'status'=>2),'uid')['uid'];
        //余额
        $money=pdo_get('mzhk_sun_user',array('id'=>$uid,'uniacid'=>$_W['uniacid']),'money')['money'];
        $nowmoney=$gname*$count+$money;
        $data1['money']=$nowmoney;
      }

      $result=pdo_update('mzhk_sun_user',$data1, array('id' =>$uid,'uniacid'=>$_W['uniacid']));
    }
    $res=pdo_delete('mzhk_sun_plugin_lottery_goods',array('gid'=>$_GPC['gid'],'uniacid'=>$_W['uniacid']));
    $order=pdo_getall('mzhk_sun_plugin_lottery_order',array('gid'=>$_GPC['gid'],'uniacid'=>$_W['uniacid']));
    if(!empty($order)){
        $result=pdo_delete('mzhk_sun_plugin_lottery_order',array('gid'=>$_GPC['gid'],'uniacid'=>$_W['uniacid']));
    }
    

    if($res){
        // pdo_commit();
        message('删除成功！', $this->createWebUrl('goods'), 'success');
    }else{
        // pdo_rollback();
        message('删除失败！','','error');
    }
}
if($_GPC['op']=='tg'){
    // p($_GPC['gid']);die;
    $res=pdo_update('mzhk_sun_plugin_lottery_goods',array('status'=>2),array('gid'=>$_GPC['gid'],'uniacid'=>$_W['uniacid']));
    if($res){
          message('通过成功！', $this->createWebUrl('goods'), 'success');
        }else{
          message('通过失败！','','error');
        }
}
if($_GPC['op']=='jj'){
    $res=pdo_update('mzhk_sun_plugin_lottery_goods',array('status'=>3),array('gid'=>$_GPC['gid'],'uniacid'=>$_W['uniacid']));
    if($res){
         message('拒绝成功！', $this->createWebUrl('goods'), 'success');
        }else{
         message('拒绝失败！','','error');
        }
}
include $this->template('web/goods');