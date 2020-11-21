<?php
global $_GPC, $_W;
$GLOBALS['frames'] = $this->getMainMenu();
$where=" where uniacid=:uniacid";
$where.=" and task_id={$_GPC['task_id']}";
$data[':uniacid']=$_W['uniacid'];
$pageindex = max(1, intval($_GPC['page']));
$pagesize=10;
$sql="SELECT * FROM ".tablename('yzqzk_sun_plugin_scoretask_taskset').$where." ORDER BY id ASC";
$total=pdo_fetchcolumn("select count(*) from " .tablename('yzqzk_sun_plugin_scoretask_taskset').$where,$data);
$select_sql =$sql." LIMIT " .($pageindex - 1) * $pagesize.",".$pagesize;
$list=pdo_fetchall($select_sql,$data);
foreach ($list as $key=>&$val) {
    $val['num_z']=$key+1+($pageindex-1)*$pagesize;
}
$pager = pagination($total, $pageindex, $pagesize);
if($_GPC['op']=='delete'){
    $res=pdo_delete('yzqzk_sun_plugin_scoretask_taskset',array('id'=>$_GPC['id']));
    if($res){
              message('删除成功！', $this->createWebUrl('task'), 'success');
        }else{
              message('删除失败！','','error');
        }
}
if($_GPC['op']=='tg'){
    $res=pdo_update('yzqzk_sun_plugin_scoretask_taskset',array('state'=>2,'tg_time'=>time()),array('id'=>$_GPC['id']));
    if($res){
         message('通过成功！', $this->createWebUrl('task'), 'success');
    }else{
        message('通过失败！','','error');
    }
}
if($_GPC['op']=='jj'){
    $res=pdo_update('yzqzk_sun_plugin_scoretask_taskset',array('state'=>3,'jj_time'=>time()),array('id'=>$_GPC['id']));
    if($res){
         message('拒绝成功！', $this->createWebUrl('task'), 'success');
        }else{
              message('拒绝失败！','','error');
        }
}
include $this->template('web/taskset');