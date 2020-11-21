<?php
global $_GPC, $_W;
$GLOBALS['frames'] = $this->getMainMenu();
// $list = pdo_getall('byjs_sun_mealtype',array('uniacid' => $_W['uniacid']),array(),'','num ASC');
$pageindex = max(1, intval($_GPC['page']));
$pagesize=10;
$where=" WHERE  uniacid=:uniacid  ";
$data[':uniacid']=$_W['uniacid'];

$sql="SELECT * FROM ".tablename('byjs_sun_mealtype').$where." order BY num asc";

$total=pdo_fetchcolumn("SELECT count(*) FROM ".tablename('byjs_sun_mealtype').$where." order BY num asc",$data);

$select_sql =$sql." LIMIT " .($pageindex - 1) * $pagesize.",".$pagesize;
$list=pdo_fetchall($select_sql,$data);
$pager = pagination($total, $pageindex, $pagesize);



// $info  = pdo_get('byjs_sun_mealtype_show',array(),array('id','mealtype_id'));
if($_GPC['op']=='delete'){
    $res=pdo_delete('byjs_sun_mealtype',array('id'=>$_GPC['id'],'uniacid'=>$_W['uniacid']));
    if($res){
        message('删除成功',$this->createWebUrl('mealtype',array()),'success');
    }else{
        message('删除失败','','error');
    }
}
if($_GPC['op']=='change'){
	 $res=pdo_update('byjs_sun_mealtype',array('status'=>$_GPC['status']),array('id'=>$_GPC['id'],'uniacid'=>$_W['uniacid']));
    if($res){
        message('操作成功',$this->createWebUrl('mealtype',array()),'success');
    }else{
        message('操作失败','','error');
    }
}


include $this->template('web/mealtype');