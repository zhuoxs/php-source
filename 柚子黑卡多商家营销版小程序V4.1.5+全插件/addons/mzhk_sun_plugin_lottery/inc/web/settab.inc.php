<?php
global $_GPC, $_W;
$GLOBALS['frames'] = $this->getMainMenu();
$uniacid = $_W['uniacid'];
$data[':uniacid']=$_W['uniacid'];
$template = "web/settab";

if($_GPC['op']=='delete'){
    $res=pdo_delete('mzhk_sun_plugin_lottery_settab',array('id'=>$_GPC['id'],'uniacid'=>$uniacid));
    if($res){
        message('删除成功！', $this->createWebUrl('settab'), 'success');
    }else{
        message('删除失败！','','error');
    }
}elseif($_GPC['op']=='pass'){
    $res=pdo_update('mzhk_sun_plugin_lottery_settab',array('status'=>2),array('id'=>$_GPC['id'],'uniacid'=>$uniacid));
    if($res){
        message('操作成功！', $this->createWebUrl('settab'), 'success');
    }else{
        message('操作失败！','','error');
    }
}elseif($_GPC['op']=='nopass'){
    $res=pdo_update('mzhk_sun_plugin_lottery_settab',array('status'=>1),array('id'=>$_GPC['id'],'uniacid'=>$uniacid));
    if($res){
        message('操作成功！', $this->createWebUrl('settab'), 'success');
    }else{
        message('操作失败！','','error');
    }
}else{
    $where=" WHERE uniacid= :uniacid";
    $type=isset($_GPC['type'])?$_GPC['type']:'all';
    $pageindex = max(1, intval($_GPC['page']));
    if($_GPC['status']){
        $status=$_GPC['status'];
        $data[':status']=$status;
        $where .=" and status=:status ";
    }
    $pagesize=10;
    $sql="SELECT * from".tablename('mzhk_sun_plugin_lottery_settab').$where." order by sort asc ";
    $total=pdo_fetchcolumn("SELECT  count(*) as wname FROM ".tablename('mzhk_sun_plugin_lottery_settab').$where." order by sort asc ",$data);
    $select_sql =$sql." LIMIT " .($pageindex - 1) * $pagesize.",".$pagesize;
    $list=pdo_fetchall($select_sql,$data);

    $pager = pagination($total, $pageindex, $pagesize);
}

include $this->template($template);