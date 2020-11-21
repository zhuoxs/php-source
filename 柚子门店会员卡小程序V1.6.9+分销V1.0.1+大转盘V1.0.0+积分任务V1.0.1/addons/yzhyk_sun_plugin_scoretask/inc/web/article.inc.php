<?php
global $_GPC, $_W;
$GLOBALS['frames'] = $this->getMainMenu();
$where=" where uniacid=:uniacid";
$data[':uniacid']=$_W['uniacid'];
$pageindex = max(1, intval($_GPC['page']));
$pagesize=10;
$sql="SELECT * FROM ".tablename('yzhyk_sun_plugin_scoretask_article').$where." ORDER BY id DESC";
$total=pdo_fetchcolumn("select count(*) from " .tablename('yzhyk_sun_plugin_scoretask_article').$where,$data);
$select_sql =$sql." LIMIT " .($pageindex - 1) * $pagesize.",".$pagesize;
$list=pdo_fetchall($select_sql,$data);
$pager = pagination($total, $pageindex, $pagesize);
if($_GPC['op']=='delete'){
    $res=pdo_delete('yzhyk_sun_plugin_scoretask_article',array('id'=>$_GPC['id']));
    if($res){
         message('删除成功！', $this->createWebUrl('article'), 'success');
        }else{
              message('删除失败！','','error');
        }
}
if($_GPC['op']=='tg'){
    $res=pdo_update('yzhyk_sun_plugin_scoretask_article',array('state'=>1,'tg_time'=>time()),array('id'=>$_GPC['id']));
    if($res){
         message('通过成功！', $this->createWebUrl('article'), 'success');
    }else{
        message('通过失败！','','error');
    }
}
if($_GPC['op']=='jj'){
    $res=pdo_update('yzhyk_sun_plugin_scoretask_article',array('state'=>2,'jj_time'=>time()),array('id'=>$_GPC['id']));
    if($res){
         message('拒绝成功！', $this->createWebUrl('article'), 'success');
        }else{
              message('拒绝失败！','','error');
        }
}
include $this->template('web/article');