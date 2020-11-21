<?php
/**
 * Created by PhpStorm.
 * User: lts
 * Date: 2018/4/27
 * Time: 17:51
 */
global $_GPC, $_W;
$GLOBALS['frames'] = $this->getMainMenu();
//$list = pdo_getall('yzzc_sun_type',array('uniacid' => $_W['uniacid']),array(),'','num ASC');
$info = pdo_getall('yzzc_sun_new',array('uniacid'=>$_W['uniacid']));
//p($info);die;
global $_W, $_GPC;

if($_GPC['op']=='delete'){

    $res=pdo_delete('yzzc_sun_new',array('id'=>$_GPC['id']));
    if($res){
        message('删除成功',$this->createWebUrl('newslist',array()),'success');
    }else{
        message('删除失败','','error');
    }

}

include $this->template('web/newslist');