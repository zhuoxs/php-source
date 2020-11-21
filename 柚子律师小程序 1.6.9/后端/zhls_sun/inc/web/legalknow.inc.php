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
    $list = pdo_getall('zhls_sun_legalknow',array('law_name like'=>'%'.$op.'%'));

}else{
    $list = pdo_getall('zhls_sun_legalknow',['uniacid'=>$_W['uniacid']],'','','selftime DESC');
}

if($_GPC['op']== 'delete'){
    $res = pdo_delete('zhls_sun_legalknow',array('id'=>$_GPC['id']));
    if($res){
        message('删除成功',$this->createWebUrl('legalknow',array()),'success');
    }else{
        message('删除失败','','error');
    }
}


include $this->template('web/legalknow');