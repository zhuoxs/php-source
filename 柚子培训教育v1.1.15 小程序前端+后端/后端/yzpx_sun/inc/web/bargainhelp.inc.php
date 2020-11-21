<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/7/14
 * Time: 10:24
 */
global $_GPC, $_W;
$GLOBALS['frames'] = $this->getMainMenu();
$where=" WHERE  uniacid=".$_W['uniacid']." and cid =".$_GPC['cid']." and uid = ".$_GPC['uid'] ." and help_uid > 0";
if($_GPC['keywords']){
    $op=$_GPC['keywords'];
    $where.=" and username LIKE  '%$op%'";
}
$page = max(1, intval($_GPC['page']));
$size = intval($_GPC['psize']) ? intval($_GPC['psize']) : 10;
$start= $page * $size;

$total=pdo_fetchcolumn("select count(*) from " . tablename("yzpx_sun_bargain") .$where);
$pager = pagination($total, $page, $size);

$sql = 'SELECT * FROM '.tablename('yzpx_sun_bargain')."{$where} ORDER BY id DESC LIMIT ".(($page-1) * $size).','.$size;
$info = pdo_fetchall($sql);
$cid=$_GPC['cid'];
$uid=$_GPC['uid'];
if($info){
    foreach ($info as $key =>$value){
//        $classify=pdo_get('yzpx_sun_bargainclassify',array('id'=>$value['cid']));
//        $info[$key]['cname']=$classify['name'];
//        if($value['sid']){
//            $classify=pdo_get('yzpx_sun_school',array('id'=>$value['sid']));
//            $info[$key]['sname']=$classify['name'];
//        }
//        $teacher=pdo_get('yzpx_sun_teacher',array('id'=>$value['tid']));
//        $info[$key]['tname']=$teacher['name'];
        if($value['pay_time']>0){
            $info[$key]['pay_time']=date('Y-m-d H:i:s',$value['pay_time']);
        }

        $info[$key]['createtime']=date('Y-m-d H:i:s',$value['createtime']);
//        $info[$key]['lesson']=pdo_fetchcolumn("select count(*) from " . tablename("yzpx_sun_lesson")  ."where couid =".$value['id']);
    }
}

//var_dump($info);exit;
if($_GPC['op']=='delete'){
    $res=pdo_update('yzpx_sun_bargain',array('status'=>0),array('id'=>$_GPC['id']));
    if($res){
        pdo_update('yzpx_sun_bargain_teach',array('status'=>0),array('cid'=>$_GPC['cid']));
        message('删除成功',$this->createWebUrl('courselist',array()),'success');
    }else{
        message('删除失败','','error');
    }
}

include $this->template('web/bargainhelp');