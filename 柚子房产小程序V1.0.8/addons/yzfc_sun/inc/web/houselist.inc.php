<?php
/**
 * Created by PhpStorm.
 * User: lts
 * Date: 2018/4/27
 * Time: 17:51
 */
global $_GPC, $_W;
$GLOBALS['frames'] = $this->getMainMenu();
$where=" WHERE  uniacid=".$_W['uniacid']." and status =1 ";
if($_GPC['keywords']){
    $op=$_GPC['keywords'];
    $where.=" and name LIKE  '%$op%'";
}
$page = max(1, intval($_GPC['page']));
$size = intval($_GPC['psize']) ? intval($_GPC['psize']) : 10;
$start= $page * $size;

$total=pdo_fetchcolumn("select count(*) from " . tablename("yzfc_sun_house") .$where);
$pager = pagination($total, $page, $size);

$sql = 'SELECT * FROM '.tablename('yzfc_sun_house')."{$where} ORDER BY id DESC LIMIT ".(($page-1) * $size).','.$size;
$info = pdo_fetchall($sql);
foreach ($info as $key =>$value){
    $region=pdo_get('yzfc_sun_region',array('id'=>$value['region']),array('name'));
    $info[$key]['region']=$region['name'];
    $info[$key]['opentime']=date('Y-m-d',$value['opentime']);
}
//if($info){
//    foreach ($info as $key =>$value){
//        $classify=pdo_get('yzfc_sun_houseclassify',array('id'=>$value['cid']));
//        $info[$key]['cname']=$classify['name'];
//        if($value['sid']){
//            $classify=pdo_get('yzfc_sun_school',array('id'=>$value['sid']));
//            $info[$key]['sname']=$classify['name'];
//        }
//        $teacher=pdo_get('yzfc_sun_teacher',array('id'=>$value['tid']));
//        $info[$key]['tname']=$teacher['name'];
//        $info[$key]['start_time']=date('Y-m-d H:i:s',$value['start_time']);
//        $info[$key]['end_time']=date('Y-m-d H:i:s',$value['end_time']);
//        $info[$key]['lesson']=pdo_fetchcolumn("select count(*) from " . tablename("yzfc_sun_lesson")  ."where couid =".$value['id']);
//    }
//}

//var_dump($info);exit;
if($_GPC['op']=='delete'){
    $res=pdo_update('yzfc_sun_house',array('status'=>0),array('id'=>$_GPC['id']));
    if($res){
        message('删除成功',$this->createWebUrl('houselist',array()),'success');
    }else{
        message('删除失败','','error');
    }
}
if($_GPC['op']=='tj'){
    $res=pdo_update('yzfc_sun_house',array('rec'=>1),array('id'=>$_GPC['id']));
    if($res){
        message('推荐成功',$this->createWebUrl('houselist',array()),'success');
    }else{
        message('推荐失败','','error');
    }

}
if($_GPC['op']=='qxtj'){
    $res=pdo_update('yzfc_sun_house',array('rec'=>0),array('id'=>$_GPC['id']));
    if($res){
        message('取消成功',$this->createWebUrl('houselist',array()),'success');
    }else{
        message('取消失败','','error');
    }
}

include $this->template('web/houselist');