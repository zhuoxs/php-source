<?php
/**
 * Created by PhpStorm.
 * User: lts
 * Date: 2018/4/27
 * Time: 17:51
 */
global $_GPC, $_W;
$GLOBALS['frames'] = $this->getMainMenu();
$where=" WHERE  uniacid=".$_W['uniacid'];
if($_GPC['keywords']){
    $op=$_GPC['keywords'];
    $where.=" and title LIKE  '%$op%'";
}
$page = max(1, intval($_GPC['page']));
$size = intval($_GPC['psize']) ? intval($_GPC['psize']) : 10;
$start= $page * $size;

$total=pdo_fetchcolumn("select count(*) from " . tablename("yzfc_sun_news") .$where);
$pager = pagination($total, $page, $size);

$sql = 'SELECT * FROM '.tablename('yzfc_sun_news')."{$where} ORDER BY id DESC LIMIT ".(($page-1) * $size).','.$size;
$info = pdo_fetchall($sql);
foreach ($info as $key =>$value){
    if($value['hid']>0){
        $house=pdo_get('yzfc_sun_house',array('id'=>$value['hid']));
        $info[$key]['hname']=$house['name'];
    }else{
        $info[$key]['hname']='不关联';
    }

    $info[$key]['createtime']=date('Y-m-d H:i:s',$value['createtime']);
}
//var_dump($info);exit;
if($_GPC['op']=='delete'){
    $res=pdo_delete('yzfc_sun_news',array('id'=>$_GPC['id']));
    if($res){
        message('删除成功',$this->createWebUrl('newslist',array()),'success');
    }else{
        message('删除失败','','error');
    }
}
if($_GPC['op']=='deletearr'){
    $res=pdo_delete('yzfc_sun_news',array('id'=>$_GPC['id']));
    if($res){
        message('删除成功',$this->createWebUrl('newslist',array()),'success');
    }else{
        message('删除失败','','error');
    }
}
if($_GPC['op']=='tj'){
    $totaltj=pdo_fetchcolumn("select count(*) from " . tablename("yzfc_sun_news") ." where uniacid =".$_W['uniacid']." and rec = 1");
    if($totaltj<2){
        $res=pdo_update('yzfc_sun_news',array('rec'=>1),array('id'=>$_GPC['id']));
        if($res){
            message('推荐成功',$this->createWebUrl('newslist',array()),'success');
        }else{
            message('推荐失败','','error');
        }
    }else{
        message('最多只能推荐两个','','error');
    }
}
if($_GPC['op']=='qxtj'){
    $res=pdo_update('yzfc_sun_news',array('rec'=>0),array('id'=>$_GPC['id']));
    if($res){
        message('取消成功',$this->createWebUrl('newslist',array()),'success');
    }else{
        message('取消失败','','error');
    }
}
include $this->template('web/newslist');