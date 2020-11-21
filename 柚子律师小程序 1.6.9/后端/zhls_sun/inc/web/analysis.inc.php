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
    $list = pdo_getall('zhls_sun_category',array('cname like'=>'%'.$op.'%'));

}else{
    $list = pdo_getall('zhls_sun_category',['uniacid'=>$_W['uniacid']],'','','cid ASC');
}

if($_GPC['op']== 'delete'){
    $res = pdo_delete('zhls_sun_category',array('cid'=>$_GPC['cid']));
    if($res){
        message('删除成功',$this->createWebUrl('analysis',array()),'success');
    }else{
        message('删除失败','','error');
    }
}


include $this->template('web/analysis');