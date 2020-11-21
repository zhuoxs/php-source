<?php
global $_GPC, $_W;
// $action = 'ad';
// $title = $this->actions_titles[$action];
$GLOBALS['frames'] = $this->getMainMenu();
$operation = !empty($_GPC['op']) ? $_GPC['op'] : 'display';
$type=isset($_GPC['type'])?$_GPC['type']:'all';
//$status=$_GPC['status'];
load()->func('tpl');
$pageindex = max(1, intval($_GPC['page']));
$pagesize=10;
if($_GPC['keywords']) {
    $op = $_GPC['keywords'];
    $cate = pdo_get('zhls_sun_category',array('uniacid'=>$_W['uniacid'],'cname like'=>'%'.$op.'%'));
    $sql = ' SELECT * FROM ' .tablename('zhls_sun_dynamics') . ' d ' . ' JOIN ' . tablename('zhls_sun_category') . ' c ' .' ON ' . ' d.cid=c.cid' . ' WHERE ' . ' d.uniacid=' . $_W['uniacid'] . ' AND ' . ' d.cid='. $cate['cid'] . ' ORDER BY ' . ' selftime desc';
    $list = pdo_fetchall($sql);

}else{
    $sql = ' SELECT * FROM ' .tablename('zhls_sun_dynamics') . ' d ' . ' JOIN ' . tablename('zhls_sun_category') . ' c ' .' ON ' . ' d.cid=c.cid' . ' WHERE ' . ' d.uniacid=' . $_W['uniacid'] . ' ORDER BY ' . ' selftime desc';
    $list = pdo_fetchall($sql);
}

if($_GPC['op']== 'delete'){
    $res = pdo_delete('zhls_sun_dynamics',array('id'=>$_GPC['id']));
    if($res){
        message('删除成功',$this->createWebUrl('dynamics',array()),'success');
    }else{
        message('删除失败','','error');
    }
}


include $this->template('web/dynamics');