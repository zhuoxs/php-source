<?php

global $_GPC, $_W;
$GLOBALS['frames'] = $this->getMainMenu();

$list = pdo_getall('yzhd_sun_comment',array('uniacid'=>$_W['uniacid'],'branch_id'=>$_GPC['id']));
foreach ($list as $k=>$v){
    $list[$k]['username'] = pdo_getcolumn('yzhd_sun_user',array('uniacid'=>$_W['uniacid'],'openid'=>$v['openid']),'name');
}
if($_GPC['op'] == 'delete'){
    $res = pdo_delete('yzhd_sun_comment',array('id'=>$_GPC['id']));
    if($res){
        message('删除成功！', $this->createWebUrl('comment',array('id'=>$_GPC['branch_id'])), 'success');
    }else{
        message('删除失败！','','error');
    }
}
include $this->template('web/comment');
