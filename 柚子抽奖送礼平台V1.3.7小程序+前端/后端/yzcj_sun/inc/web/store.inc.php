<?php
global $_GPC, $_W;
$GLOBALS['frames'] = $this->getMainMenu();
$where="where a.uniacid=:uniacid ";
//----------------审核状态--------------
if(!empty($_GPC['status'])&&empty($_GPC['keywords'])){
    $status = $_GPC['status'];
    $where.=" and status={$status} ";
}
//-------------名字搜索--------------
if(!empty($_GPC['keywords'])&&empty($_GPC['status'])){
    $keywords=$_GPC['keywords'];
    $where.=" and a.sname LIKE  concat('%', :name,'%') ";
    $data[':name']=$keywords;

}
else if(!empty($_GPC['status'])&&!empty($_GPC['keywords'])){
    $status = $_GPC['status'];
    $keywords=$_GPC['keywords'];
    $where .= "and status={$status} and a.sname LIKE concat('%',:name,'%')";
    $data[':name']=$_GPC['keywords'];
}
$data[':uniacid']=$_W['uniacid'];
$pageIndex = max(1, intval($_GPC['page']));
$pageSize=6;
$type=isset($_GPC['type'])?$_GPC['type']:'all';

$sql="SELECT a.*,b.`name` FROM ".tablename('yzcj_sun_sponsorship'). " a"  . " left join " . tablename("yzcj_sun_user") . " b on b.id=a.uid ". $where. " ORDER BY a.sid desc";
$total=pdo_fetchcolumn("SELECT count(*) FROM ".tablename('yzcj_sun_sponsorship'). " a" ." left join " . tablename("yzcj_sun_user") . " b on b.id=a.uid ".$where,$data);

$select_sql =$sql." LIMIT " .($pageIndex - 1) * $pageSize.",".$pageSize;
$list=pdo_fetchall($select_sql,$data);

$pager = pagination($total, $pageIndex,$pageSize);

//赞助期限
$in=pdo_getall('yzcj_sun_in',array('uniacid'=>$_W['uniacid']));

if($_GPC['op']=='delete'){
    $res=pdo_delete('yzcj_sun_sponsorship',array('sid'=>$_GPC['id'],'uniacid'=>$_W['uniacid']));
    if($res){
      message('删除成功！', $this->createWebUrl('store'), 'success');
    }else{
      message('删除失败！','','error');
    }
}

if($_GPC['op']=='renewal'){
    $day=$_GPC['day'];

    $starttime=date("Y-m-d H:i:s",time());

    $time=24*60*60*$day;

    $endtime=date("Y-m-d H:i:s",time()+$time);  
    // p($_GPC);
    $res=pdo_update('yzcj_sun_sponsorship',array('status'=>2,'day'=>$day,'time'=>$starttime,'endtime'=>$endtime),array('sid'=>$_GPC['id'],'uniacid'=>$_W['uniacid']));

    if($res){
      message('续费成功！', $this->createWebUrl('store'), 'success');
    }else{
      message('续费失败！','','error');
    }
}

if($_GPC['op']=='tg'){
    $rst=pdo_get('yzcj_sun_sponsorship',array('sid'=>$_GPC['id'],'uniacid'=>$_W['uniacid']));
    $starttime=date("Y-m-d H:i:s",time());

    $time=24*60*60*$rst['day'];

    $endtime=date("Y-m-d H:i:s",time()+$time);  
    // p($time);die;
    $res=pdo_update('yzcj_sun_sponsorship',array('status'=>2,'time'=>$starttime,'endtime'=>$endtime),array('sid'=>$_GPC['id'],'uniacid'=>$_W['uniacid']));
    if($res){
          message('通过成功！', $this->createWebUrl('store'), 'success');
        }else{
          message('通过失败！','','error');
        }
}
if($_GPC['op']=='jj'){
    $res=pdo_update('yzcj_sun_sponsorship',array('status'=>3),array('sid'=>$_GPC['id'],'uniacid'=>$_W['uniacid']));
    if($res){
          message('拒绝成功！', $this->createWebUrl('store'), 'success');
        }else{
          message('拒绝失败！','','error');
        }
}
// if($_GPC['op']=='cz'){
//     $pwd=md5('123456');
//     $res=pdo_update('yzcj_sun_sponsorship',array('pwd'=>$pwd),array('sid'=>$_GPC['id'],'uniacid'=>$_W['uniacid']));
//     // p($res);
//     if($res){
//           message('重置成功！', $this->createWebUrl('store'), 'success');
//         }else{
//           message('重置失败！','','error');
//         }
// }

include $this->template('web/store');