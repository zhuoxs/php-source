<?php

global $_GPC, $_W;
$action = 'start';
/*if($_GPC['cityname']){

  setcookie('cityname',$_GPC['cityname']);
  //$cityname=$_COOKIE['cityname'];
  $_COOKIE['cityname']=$_GPC['cityname'];
}*/
$type=isset($_GPC['type'])?$_GPC['type']:'wait';
$GLOBALS['frames'] = $this->getNaveMenu($_COOKIE['cityname'], $action);
$where=" where a.uniacid=:uniacid and a.cityname=:cityname";
$data[':uniacid']=$_W['uniacid']; 
$data[':cityname']= $_COOKIE['cityname'];
if(isset($_GPC['keywords'])){
    $where.=" and a.user_name LIKE  concat('%', :name,'%') ";
    $data[':name']=$_GPC['keywords'];
    $type='all';  
}else{  
if($type=='wait'||$type=='ok'||$type=='no'){
    $where.=" and  a.state=:state";
     $data[':state']=$_GPC['state']; 
}
}
if(!empty($_GPC['time'])){
   $start=strtotime($_GPC['time']['start']);
   $end=strtotime($_GPC['time']['end']);
  $where.=" and a.time >={$start} and a.time<={$end}";

}

if($_GPC['top']){
      $where.=" and  a.top=:top";
     $data[':top']=$_GPC['top']; 
}
$pageindex = max(1, intval($_GPC['page']));
$pagesize=10;

$sql="select a.*,b.type from".tablename('zhls_sun_information'). " a"  . " left join " . tablename("zhls_sun_top") . " b on b.id=a.top_type".$where." ORDER BY a.id DESC";
$total=pdo_fetchcolumn("select count(*) from".tablename('zhls_sun_information'). " a"  . " left join " . tablename("zhls_sun_top") . " b on b.id=a.top_type".$where,$data);
$select_sql =$sql." LIMIT " .($pageindex - 1) * $pagesize.",".$pagesize;
$list=pdo_fetchall($select_sql,$data);
$pager = pagination($total, $pageindex, $pagesize);
if($_GPC['op']=='delete'){
    $res=pdo_delete('zhls_sun_information',array('id'=>$_GPC['id']));
    if($res){
         message('删除成功！', $this->createWebUrl2('dlininformation'), 'success');
        }else{
              message('删除失败！','','error');
        }
}

if($_GPC['op']=='tg'){
    $res=pdo_update('zhls_sun_information',array('state'=>2,'sh_time'=>time()),array('id'=>$_GPC['id']));
    if($res){
         message('通过成功！', $this->createWebUrl2('dlininformation'), 'success');
        }else{
              message('通过失败！','','error');
        }
}

if($_GPC['op']=='jj'){
    $res=pdo_update('zhls_sun_information',array('state'=>3,'sh_time'=>time()),array('id'=>$_GPC['id']));
    if($res){
         message('拒绝成功！', $this->createWebUrl2('dlininformation'), 'success');
        }else{
         message('拒绝失败！','','error');
        }
}
include $this->template('web/dlininformation');