<?php
global $_GPC, $_W;
$GLOBALS['frames'] = $this->getMainMenu();

$pageindex = max(1, intval($_GPC['page']));
$pagesize=10;
$where=" WHERE  uniacid=:uniacid  ";
$data[':uniacid']=$_W['uniacid'];

$sql="SELECT * FROM ".tablename('byjs_sun_mall').$where;

$total=pdo_fetchcolumn("SELECT count(*) FROM ".tablename('byjs_sun_mall').$where,$data);

$select_sql =$sql." LIMIT " .($pageindex - 1) * $pagesize.",".$pagesize;
$info=pdo_fetchall($select_sql,$data);
$pager = pagination($total, $pageindex, $pagesize);


//$list = pdo_getall('ymmf_sun_type',array('uniacid' => $_W['uniacid']),array(),'','num ASC');
// $info = pdo_getall('byjs_sun_mall',array('uniacid'=>$_W['uniacid']));

if($_GPC['op']=='delete'){

        $res=pdo_delete('byjs_sun_mall',array('id'=>$_GPC['id'],'uniacid'=>$_W['uniacid']));
        if($res){
            message('操作成功',$this->createWebUrl('malllist',array()),'success');
        }else{
            message('操作失败','','error');
        }

}
if($_GPC['op']=='change'){
    $res=pdo_update('byjs_sun_mall',array('stutes'=>$_GPC['stutes']),array('id'=>$_GPC['id'],'uniacid'=>$_W['uniacid']));
    if($res){
        message('操作成功',$this->createWebUrl('malllist',array()),'success');
    }else{
        message('操作失败','','error');
    }
}


include $this->template('web/malllist');