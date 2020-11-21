<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/6/2
 * Time: 11:22
 */
global $_GPC, $_W;
$GLOBALS['frames'] = $this->getMainMenu();
$where=" WHERE  uniacid=".$_W['uniacid'] ." and status=1";
if($_GPC['keywords']){
    $op=$_GPC['keywords'];
    $where.=" and title LIKE  '%$op%'";
}
$page = max(1, intval($_GPC['page']));
$size = intval($_GPC['psize']) ? intval($_GPC['psize']) : 10;
$start= $page * $size;

$total=pdo_fetchcolumn("select count(*) from " . tablename("yzfc_sun_find") .$where);
$pager = pagination($total, $page, $size);

$sql = 'SELECT * FROM '.tablename('yzfc_sun_find')."{$where} ORDER BY id DESC LIMIT ".(($page-1) * $size).','.$size;
$info = pdo_fetchall($sql);
foreach ($info as $key =>$value){
    $classify=pdo_get('yzfc_sun_findclassify',array('id'=>$value['cid']));
    $info[$key]['cname']=$classify['name'];
    $info[$key]['createtime']=date('Y-m-d H:i:s',$value['createtime']);
}
//var_dump($info);exit;
if($_GPC['op']=='delete'){
    $res=pdo_update('yzfc_sun_find',array('status'=>0),array('id'=>$_GPC['id']));
    if($res){
        message('删除成功',$this->createWebUrl('findlist',array()),'success');
    }else{
        message('删除失败','','error');
    }
}
if($_GPC['op']=='sh'){
    $res=pdo_update('yzfc_sun_find',array('checks'=>1),array('id'=>$_GPC['id']));
    if($res){
        message('审核成功',$this->createWebUrl('findlist',array()),'success');
    }else{
        message('审核失败','','error');
    }
}
if($_GPC['op']=='tj'){
    $recnum=pdo_fetchcolumn("select count(*) from " . tablename("yzfc_sun_find") ."WHERE  uniacid=".$_W['uniacid']." and rec = 1");
    if($recnum>=5){
        message('最多只能设置5个精彩推荐','','error');
    }
    $res=pdo_update('yzfc_sun_find',array('rec'=>1),array('id'=>$_GPC['id']));
    if($res){
        message('推荐成功',$this->createWebUrl('findlist',array()),'success');
    }else{
        message('推荐失败','','error');
    }
}

include $this->template('web/findlist');