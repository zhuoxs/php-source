<?php
global $_GPC, $_W;
$GLOBALS['frames'] = $this->getMainMenu();
$where=" where a.uniacid=:uniacid";
$data[':uniacid']=$_W['uniacid']; 
$type=isset($_GPC['type'])?$_GPC['type']:'wait';
$state=$_GPC['state'];
if($type=='wait'){
  $state=1;
}
if(isset($_GPC['keywords'])){
  $where.=" and a.store_name LIKE  concat('%', :name,'%') ";
  $data[':name']=$_GPC['keywords'];  
 $type='all'; 
}else{
  if($state){
  $where.=" and  a.state=:state ";
  $data[':state']=$state;   
}
}


$pageindex = max(1, intval($_GPC['page']));
$pagesize=10;


$sql="SELECT a.*,b.type as typename FROM ".tablename('zhls_sun_store'). " a"  . " left join " . tablename("zhls_sun_in") . " b on b.id=a.type".$where." ORDER BY a.id DESC";
$total=pdo_fetchcolumn("select count(*) from " .tablename('zhls_sun_store'). " a"  . " left join " . tablename("zhls_sun_in") . " b on b.id=a.type".$where,$data);
//echo $sql;die;
$select_sql =$sql." LIMIT " .($pageindex - 1) * $pagesize.",".$pagesize;
p($select_sql);
$list=pdo_fetchall($select_sql,$data);

$pager = pagination($total, $pageindex, $pagesize);
if($_GPC['op']=='delete'){
    $res=pdo_delete('zhls_sun_store',array('id'=>$_GPC['id']));
    if($res){
         message('删除成功！', $this->createWebUrl('store'), 'success');
        }else{
              message('删除失败！','','error');
        }
}
if($_GPC['op']=='tg'){
  $rst=pdo_get('zhls_sun_store',array('id'=>$_GPC['id']));
  $time='';
  if($rst['type']==1){
    $time=24*60*60*7;
  }
  if($rst['type']==1){
    $time=24*182*60*60;
  }
  if($rst['type']==1){
    $time=24*365*60*60;
  }

    $res=pdo_update('zhls_sun_store',array('state'=>2,'sh_time'=>time(),'dq_time'=>time()+$time),array('id'=>$_GPC['id']));
    if($res){
         message('通过成功！', $this->createWebUrl('store'), 'success');
        }else{
              message('通过失败！','','error');
        }
}
if($_GPC['op']=='jj'){
    $res=pdo_update('zhls_sun_store',array('state'=>3,'sh_time'=>time()),array('id'=>$_GPC['id']));
    if($res){
         message('拒绝成功！', $this->createWebUrl('store'), 'success');
        }else{
              message('拒绝失败！','','error');
        }
}
include $this->template('web/store');