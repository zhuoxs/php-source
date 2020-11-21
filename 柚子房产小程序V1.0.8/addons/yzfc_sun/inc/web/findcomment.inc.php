<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/6/2
 * Time: 14:21
 */
global $_GPC, $_W;
$GLOBALS['frames'] = $this->getMainMenu();
$where=" WHERE  uniacid=".$_W['uniacid'].' and fid ='.$_GPC['fid'];
if($_GPC['keywords']){
    $op=$_GPC['keywords'];
    $where.=" and content LIKE  '%$op%'";
}
$page = max(1, intval($_GPC['page']));
$size = intval($_GPC['psize']) ? intval($_GPC['psize']) : 10;
$start= $page * $size;

$total=pdo_fetchcolumn("select count(*) from " . tablename("yzfc_sun_find_comment") .$where);
$pager = pagination($total, $page, $size);

$sql = 'SELECT * FROM '.tablename('yzfc_sun_find_comment')."{$where} ORDER BY id DESC LIMIT ".(($page-1) * $size).','.$size;
$info = pdo_fetchall($sql);
$fid=$_GPC['fid'];
foreach ($info as $key =>$value){
    $info[$key]['createtime']=date('Y-m-d H:i:s',$value['createtime']);
}
$bid=$_GPC['bid'];
if($_GPC['op']=='delete'){
    $res=pdo_delete('yzfc_sun_find_comment',array('id'=>$_GPC['id']));
    if($res){
        message('删除成功',$this->createWebUrl('findcomment',array('bid'=>$_GPC['bid'])),'success');
    }else{
        message('删除失败','','error');
    }
}

include $this->template('web/findcomment');