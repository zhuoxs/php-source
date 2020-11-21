<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/6/2
 * Time: 10:54
 */
global $_GPC, $_W;
$GLOBALS['frames'] = $this->getMainMenu();
$info=pdo_getall('yzfc_sun_question_classify',array('uniacid'=>$_W['uniacid']));
foreach ($info as $key =>$value){
    $info[$key]['createtime']=date('Y-m-d H:i:s',$value['createtime']);
}
if($_GPC['op']=='delete'){
    $res=pdo_delete('yzfc_sun_question_classify',array('id'=>$_GPC['id']));
    if($res){
        message('删除成功',$this->createWebUrl('questionclassify',array()),'success');
    }else{
        message('删除失败','','error');
    }
}
include $this->template('web/questionclassify');