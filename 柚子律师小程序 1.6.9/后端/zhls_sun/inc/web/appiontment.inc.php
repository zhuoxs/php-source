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
    $list = pdo_getall('zhls_sun_appointment',array('subtime like'=>'%'.$op.'%','uniacid'=>$_W['uniacid']));
}else{
    $list = pdo_getall('zhls_sun_appointment',['uniacid'=>$_W['uniacid']],'','','subtime DESC');
}

if($_GPC['op'] == 'delete'){
    $res = pdo_delete('zhls_sun_appointment',array('uniacid'=>$_W['uniacid'],'id'=>$_GPC['id']));
    if($res){
        message('编辑成功！', $this->createWebUrl('appiontment'), 'success');
    }else{
        message('编辑失败！');
    }
}

include $this->template('web/appiontment');