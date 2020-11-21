<?php
global $_GPC, $_W;
$GLOBALS['frames'] = $this->getMainMenu();
$where=" where uniacid=:uniacid";
$data[':uniacid']=$_W['uniacid'];
$pageindex = max(1, intval($_GPC['page']));
$pagesize=10;
$sql="SELECT * FROM ".tablename('yzqzk_sun_plugin_scoretask_task').$where." ORDER BY id DESC";
$total=pdo_fetchcolumn("select count(*) from " .tablename('yzqzk_sun_plugin_scoretask_task').$where,$data);
$select_sql =$sql." LIMIT " .($pageindex - 1) * $pagesize.",".$pagesize;
$list=pdo_fetchall($select_sql,$data);
$pager = pagination($total, $pageindex, $pagesize);
$type=array('','签到','阅读文章','邀请好友看文章','邀请好友砍积分','积分抽奖','收藏','邀请好友');
if($_GPC['op']=='delete'){
    $res=pdo_delete('yzqzk_sun_plugin_scoretask_task',array('id'=>$_GPC['id']));
    if($res){
         message('删除成功！', $this->createWebUrl('task'), 'success');
        }else{
              message('删除失败！','','error');
        }
}
if($_GPC['op']=='tg'){
    $res=pdo_update('yzqzk_sun_plugin_scoretask_task',array('state'=>2,'tg_time'=>time()),array('id'=>$_GPC['id']));
    if($res){
         message('通过成功！', $this->createWebUrl('task'), 'success');
    }else{
        message('通过失败！','','error');
    }
}
if($_GPC['op']=='jj'){
    $res=pdo_update('yzqzk_sun_plugin_scoretask_task',array('state'=>3,'jj_time'=>time()),array('id'=>$_GPC['id']));
    if($res){
         message('拒绝成功！', $this->createWebUrl('task'), 'success');
        }else{
              message('拒绝失败！','','error');
        }
}
include $this->template('web/task');