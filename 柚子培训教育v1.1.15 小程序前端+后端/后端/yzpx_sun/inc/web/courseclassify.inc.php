<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/6/2
 * Time: 10:54
 */
global $_GPC, $_W;
$GLOBALS['frames'] = $this->getMainMenu();
$info=pdo_getall('yzpx_sun_courseclassify',array('uniacid'=>$_W['uniacid']));
foreach ($info as $key =>$value){
    $info[$key]['createtime']=date('Y-m-d H:i:s',$value['createtime']);
}
if($_GPC['op']=='delete'){
    $isnews=pdo_getall('yzpx_sun_course',array('cid'=>$_GPC['id'],'status'=>1));
    if($isnews){
        message('删除失败,请先到课程列表修改课程分类','','error');
    }else{
        $res=pdo_delete('yzpx_sun_courseclassify',array('id'=>$_GPC['id']));
        if($res){
            message('删除成功',$this->createWebUrl('courseclassify',array()),'success');
        }else{
            message('删除失败','','error');
        }
    }
}
include $this->template('web/courseclassify');