<?php
global $_GPC, $_W;
$GLOBALS['frames'] = $this->getMainMenu();
$where=" where a.uniacid=:uniacid";
$data[':uniacid']=$_W['uniacid']; 
$type=isset($_GPC['type'])?$_GPC['type']:'all';
$status=$_GPC['status'];

if($type=='wait'){
  $status=1;
}
if(isset($_GPC['keywords'])){
  $where.=" and a.store_name LIKE  concat('%', :name,'%') ";
  $data[':name']=$_GPC['keywords'];  
 $type='all'; 
}else{
  if($status){
  $where.=" and  a.status=:status ";
  $data[':status']=$status;   
}
}
$pageindex = max(1, intval($_GPC['page']));
$pagesize=10;


$sql="SELECT a.*,b.type as typename,c.duration FROM ".tablename('yzkm_sun_store'). " a"  . " left join " . tablename("yzkm_sun_in") . " b on b.id=a.type left join".tablename("yzkm_sun_duration")."c on a.type=c.id".$where." ORDER BY a.id DESC";

$total=pdo_fetchcolumn("select count(*) from " .tablename('yzkm_sun_store'). " a"  . " left join " . tablename("yzkm_sun_in") . " b on b.id=a.type".$where,$data);
//echo $sql;die;
$select_sql =$sql." LIMIT " .($pageindex - 1) * $pagesize.",".$pagesize;

$list=pdo_fetchall($select_sql,$data);
// p($list);die;
// $qixian=pdo_get('yzkm_sun_duration',array('id'=>$_GPC['type'],'uniacid'=>$_W['uniacid']),'duration');


$pager = pagination($total, $pageindex, $pagesize);
if($_GPC['op']=='delete'){
    $res=pdo_delete('yzkm_sun_store',array('id'=>$_GPC['id']));
    if($res){
         message('删除成功！', $this->createWebUrl('store'), 'success');
        }else{
              message('删除失败！','','error');
        }
}
  // p('tg');
  // p($_GPC['op']);
  // p($list);die;
if($_GPC['op']=='tg'){
      $res=pdo_get('yzkm_sun_store',array('id'=>$_GPC['id']));

             
      // $time1=60*60*24*7;//一周
      // $time2=60*60*24*180;//半年
      // $time3=60*60*24*365;//一年
      $day_rz=$res['day_rz'];
      $tianshu=pdo_get('yzkm_sun_duration',array('uniacid'=>$_W['uniacid'],'id'=>$day_rz));
      $time4=60*60*24*$tianshu['duration'];
      $open_time1=date('Y:m:d H:i:s',time());
      $over_time1=date("Y-m-d H:i:s",time()+$time4);
      // $over_time1=date("Y-m-d H:i:s",time()+$time4);
      // if ($_GPC['type']==1) {
      //   $over_time1=date("Y-m-d H:i:s",time()+$time1);
      // }elseif ($_GPC['type']==2) {
      //   $over_time1=date("Y-m-d H:i:s",time()+$time2);
      //   // p($_GPC['type']);
      // }elseif ($_GPC['type']==3) {
      //   $over_time1=date("Y-m-d H:i:s",time()+$time3);
      // }

    $res=pdo_update('yzkm_sun_store',array('status'=>2,'open_time'=>$open_time1,'over_time'=>$over_time1),array('id'=>$_GPC['id']));
    if($res){
         message('通过成功！', $this->createWebUrl('store'), 'success');
        }else{
              message('通过失败！','','error');
        }
}


if($_GPC['op']=='jj'){
  $open_time='--';
  $over_time='--';
  $type=4;
    $res=pdo_update('yzkm_sun_store',array('status'=>3,'open_time'=>'--','over_time'=>'--','type'=>4),array('id'=>$_GPC['id']));
    if($res){
         message('拒绝成功！', $this->createWebUrl('store'), 'success');
        }else{
              message('拒绝失败！','','error');
        }
}
include $this->template('web/store');