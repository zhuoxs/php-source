<?php
global $_GPC, $_W;
$GLOBALS['frames'] = $this->getMainMenu();
$id = $_GPC['id'];
// p($id);
$course_coach = pdo_get('byjs_sun_coach',array('uniacid'=>$_W['uniacid'],'id'=>$id),'coach_name');

$info=pdo_getall('byjs_sun_course',array('uniacid'=>$_W['uniacid'],'course_coach'=>$course_coach),array(),'','id asc');

//    $type2 = pdo_getall('ymmf_sun_gallery');
//    $type3=pdo_getall('ymmf_sun_label');

//      foreach($type as $key => $value){
//         $data=$this->getSon($value['id'],$type2);
//         $type[$key]['ej']=$data;
//
//    }

if($_GPC['op']=='delete'){
    // p($id);
    $res=pdo_delete('byjs_sun_course',array('id'=>$_GPC['cid'],'uniacid'=>$_W['uniacid']));
    if($res){
        message('删除成功',$this->createWebUrl('service',array('id'=>$id)),'success');
    }else{
        message('删除失败','','error');
    }
}
// if($_GPC['op']=='change'){
//     $res=pdo_update('byjs_sun_course',array('state'=>$_GPC['state']),array('id'=>$_GPC['id'],'uniacid'=>$_W['uniacid']));
//     if($res){
//         message('操作成功',$this->createWebUrl('service',array()),'success');
//     }else{
//         message('操作失败','','error');
//     }
// }

include $this->template('web/service');