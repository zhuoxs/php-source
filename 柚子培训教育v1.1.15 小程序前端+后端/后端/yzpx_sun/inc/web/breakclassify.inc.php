<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/6/2
 * Time: 10:54
 */
global $_GPC, $_W;
$GLOBALS['frames'] = $this->getMainMenu();
$info=pdo_getall('yzpx_sun_breakclassify',array('uniacid'=>$_W['uniacid']));
foreach ($info as $key =>$value){
    $info[$key]['createtime']=date('Y-m-d H:i:s',$value['createtime']);
}
if($_GPC['op']=='delete'){
    $isnews=pdo_getall('yzpx_sun_break',array('cid'=>$_GPC['id']));
    if($isnews){
        message('删除失败,请先到课间列表修改课间分类','','error');
    }else{
        $res=pdo_delete('yzpx_sun_breakclassify',array('id'=>$_GPC['id']));
        if($res){
            message('删除成功',$this->createWebUrl('breakclassify',array()),'success');
        }else{
            message('删除失败','','error');
        }
    }
}
include $this->template('web/breakclassify');