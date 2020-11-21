<?php
/**
 * Created by PhpStorm.
 * User: lts
 * Date: 2018/4/25
 * Time: 16:17
 */

global $_GPC, $_W;

$GLOBALS['frames'] = $this->getMainMenu();

$where="uniacid =".$_W['uniacid'];
if($_GPC['keywords']){
    $op=$_GPC['keywords'];
    $where="uniacid =".$_W['uniacid']." and ordernum LIKE  '%$op%'";
}
if($_GPC['type']){
    if($_GPC['type']=='all'){
        $where="uniacid =".$_W['uniacid'];
    }else{
        $where="uniacid =".$_W['uniacid']." and ispay =" .$_GPC['ispay'];

    }
}
if($_GPC['cid']){
    $where .=" and cid =".$_GPC['cid'];
}
$type=$_GPC['type']?$_GPC['type']:'all';
$page = max(1, intval($_GPC['page']));
$size = intval($_GPC['psize']) ? intval($_GPC['psize']) : 10;
$sql = "SELECT * FROM ims_yzpx_sun_course_sign where ".$where." ORDER BY id DESC LIMIT ".(($page-1) * $size).','.$size;
//var_dump($sql);exit;
$list = pdo_fetchall($sql);
if($list){
    foreach ($list as $key =>$value){
        $list[$key]['createtime']=date('Y-m-d H:i:s',$value['createtime']);
        if($value['paytime']){
            $list[$key]['paytime']=date('Y-m-d H:i:s',$value['paytime']);
        }
        $list[$key]['cname']=pdo_get('yzpx_sun_course',array('id'=>$value['cid']),array('title'))['title'];
        if($value['sid']>0){
            $school=pdo_get('yzpx_sun_school',array('id'=>$value['sid']),array('name'));
            $list[$key]['school']=$school['name'];
        }else{
            $list[$key]['school']='总校';
        }
    }
    $total=pdo_fetchcolumn("select count(*) from ims_yzpx_sun_course_sign where ".$where);
    $pager = pagination($total, $page, $size);
}


if($_GPC['op']=='delete'){

    $res=pdo_delete('wyzc_sun_order',array('id'=>$_GPC['id'],'uniacid'=>$_W['uniacid']));

    if($res){
        message('删除成功！', $this->createWebUrl('order'), 'success');
    }else{
        message('删除失败！','','error');
    }
}
if($_GPC['op']=='tg'){
    $res=pdo_update('wyzc_sun_order',array('status'=>2),array('id'=>$_GPC['id'],'uniacid'=>$_W['uniacid']));
    if($res){
        message('通过成功！', $this->createWebUrl('order'), 'success');
    }else{
        message('通过失败！','','error');
    }
}
if($_GPC['op']=='jj'){
    $res=pdo_update('wyzc_sun_order',array('status'=>3),array('id'=>$_GPC['id'],'uniacid'=>$_W['uniacid']));
    if($res){
        message('拒绝成功！', $this->createWebUrl('order'), 'success');
    }else{
        message('拒绝失败！','','error');
    }
}
include $this->template('web/order');