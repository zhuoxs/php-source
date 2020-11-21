<?php
global $_GPC, $_W;
$GLOBALS['frames'] = $this->getMainMenu();

global $_W, $_GPC;
// $type=pdo_getall('byjs_sun_coach',array('uniacid'=>$_W['uniacid']),array(),'','id asc');

$pageindex = max(1, intval($_GPC['page']));
$pagesize=10;
$where=" WHERE  a.uniacid=:uniacid  ";
$data[':uniacid']=$_W['uniacid'];

$sql="SELECT a.*,b.`name` as mall_name FROM ".tablename('byjs_sun_coach')."a left join ". tablename('byjs_sun_mall') ." b on b.id = a.mall ".$where." order BY a.id asc";

$total=pdo_fetchcolumn("SELECT count(*) FROM ".tablename('byjs_sun_coach')."a left join ". tablename('byjs_sun_mall') ." b on b.id = a.mall ".$where." order BY a.id asc",$data);

$select_sql =$sql." LIMIT " .($pageindex - 1) * $pagesize.",".$pagesize;
$type=pdo_fetchall($select_sql,$data);
$pager = pagination($total, $pageindex, $pagesize);



if($_GPC['op']=='delete'){
    $res=pdo_delete('byjs_sun_coach',array('id'=>$_GPC['id'],'uniacid'=>$_W['uniacid']));
    if($res){
        message('删除成功',$this->createWebUrl('coachlist',array()),'success');
    }else{
        message('删除失败','','error');
    }
}
if($_GPC['op']=='change'){
    $res=pdo_update('byjs_sun_coach',array('state'=>$_GPC['state']),array('id'=>$_GPC['id'],'uniacid'=>$_W['uniacid']));
    if($res){
        message('操作成功',$this->createWebUrl('coachlist',array()),'success');
    }else{
        message('操作失败','','error');
    }
}

include $this->template('web/coachlist');