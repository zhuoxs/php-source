<?php
global $_GPC, $_W;
$GLOBALS['frames'] = $this->getMainMenu();
$where=" where uniacid=:uniacid";
$data[':uniacid']=$_W['uniacid'];
$pageindex = max(1, intval($_GPC['page']));
$pagesize=10;
$sql="SELECT * FROM ".tablename('mzhk_sun_punch').$where." ORDER BY id DESC";
$total=pdo_fetchcolumn("select count(*) from " .tablename('mzhk_sun_punch').$where,$data);
$select_sql =$sql." LIMIT " .($pageindex - 1) * $pagesize.",".$pagesize;
$list=pdo_fetchall($select_sql,$data);
$task_day=require_once 'wxapp_task_day_config.php';
$pager = pagination($total, $pageindex, $pagesize);
if($_GPC['op']=='delete'){
    $res=pdo_delete('mzhk_sun_punch',array('id'=>$_GPC['id']));
    if($res){
         message('删除成功！', $this->createWebUrl('punch'), 'success');
        }else{
              message('删除失败！','','error');
        }
}
if($_GPC['op']=='tg'){
    $res=pdo_update('mzhk_sun_punch',array('state'=>2,'tg_time'=>time()),array('id'=>$_GPC['id']));
    if($res){
         message('通过成功！', $this->createWebUrl('punch'), 'success');
    }else{
        message('通过失败！','','error');
    }
}
if($_GPC['op']=='jj'){
    $res=pdo_update('mzhk_sun_punch',array('state'=>3,'jj_time'=>time()),array('id'=>$_GPC['id']));
    if($res){
         message('拒绝成功！', $this->createWebUrl('punch'), 'success');
        }else{
              message('拒绝失败！','','error');
        }
}
include $this->template('web/punch');