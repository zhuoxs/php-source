<?php
global $_GPC, $_W;
$GLOBALS['frames'] = $this->getMainMenu();
$where=" where uniacid=:uniacid";
$data[':uniacid']=$_W['uniacid']; 
//$type=isset($_GPC['type'])?$_GPC['type']:'wait';
//
//$state=$_GPC['state'];
//if($type=='wait'){
//  $state=1;
//}
$pageindex = max(1, intval($_GPC['page']));
$pagesize=10;

//$sql="SELECT * FROM ".tablename('yzmdwsc_sun_store_active'). " a"  . " left join " . tablename("yzmdwsc_sun_in") . " b on b.type=a.time_type".$where." ORDER BY a.id DESC";
$sql="SELECT * FROM ".tablename('yzmdwsc_sun_store_active').$where." ORDER BY id DESC";
$total=pdo_fetchcolumn("select count(*) from " .tablename('yzmdwsc_sun_store_active').$where,$data);

$select_sql =$sql." LIMIT " .($pageindex - 1) * $pagesize.",".$pagesize;

$list=pdo_fetchall($select_sql,$data);

$pager = pagination($total, $pageindex, $pagesize);
if($_GPC['op']=='delete'){
    $res=pdo_delete('yzmdwsc_sun_store_active',array('id'=>$_GPC['id']));
    if($res){
         message('删除成功！', $this->createWebUrl('store'), 'success');
        }else{
              message('删除失败！','','error');
        }
}
if($_GPC['op']=='tg'){
  $rst=pdo_get('yzmdwsc_sun_store_active',array('id'=>$_GPC['id']));
  $time='';
  if($rst['time_type']==1){
    $time=24*60*60*7;

  }
  if($rst['time_type']==2){
    $time=24*30*60*60;

  }
  if($rst['time_type']==3){
    $time=24*91*60*60;

  }
  if($rst['time_type']==4){
      $time=24*182*60*60;

  }
  if($rst['time_type']==5){
      $time=24*365*60*60;

    }

    $res=pdo_update('yzmdwsc_sun_store_active',array('state'=>2,'rz_time'=>time(),'dq_time'=>time()+$time),array('id'=>$_GPC['id']));

    if($res){
         message('通过成功！', $this->createWebUrl('store'), 'success');
    }else{
        message('通过失败！','','error');
    }
}
if($_GPC['op']=='jj'){
    $res=pdo_update('yzmdwsc_sun_store_active',array('state'=>3,'rz_time'=>time()),array('id'=>$_GPC['id']));
    if($res){
         message('拒绝成功！', $this->createWebUrl('store'), 'success');
        }else{
              message('拒绝失败！','','error');
        }
}
include $this->template('web/store');