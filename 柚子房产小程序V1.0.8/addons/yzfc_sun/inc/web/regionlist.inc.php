<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/6/2
 * Time: 10:54
 */
global $_GPC, $_W;
$GLOBALS['frames'] = $this->getMainMenu();
$info=pdo_getall('yzfc_sun_region',array('uniacid'=>$_W['uniacid'],'status'=>1));
foreach ($info as $key =>$value){
    $info[$key]['createtime']=date('Y-m-d H:i:s',$value['createtime']);
}
if($_GPC['op']=='delete'){

    $res=pdo_update('yzfc_sun_region',array('status'=>0),array('id'=>$_GPC['id']));
    if($res){
        message('删除成功',$this->createWebUrl('region',array()),'success');
    }else{
        message('删除失败','','error');
    }

}
include $this->template('web/regionlist');