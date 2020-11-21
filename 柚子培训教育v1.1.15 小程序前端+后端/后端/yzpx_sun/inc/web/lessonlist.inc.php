<?php
/**
 * Created by PhpStorm.
 * User: lts
 * Date: 2018/4/27
 * Time: 17:51
 */
global $_GPC, $_W;
$GLOBALS['frames'] = $this->getMainMenu();
$where=" WHERE  uniacid=".$_W['uniacid'].' and couid ='.$_GPC['couid'];
if($_GPC['keywords']){
    $op=$_GPC['keywords'];
    $where.=" and title LIKE  '%$op%'";
}
$page = max(1, intval($_GPC['page']));
$size = intval($_GPC['psize']) ? intval($_GPC['psize']) : 10;
$start= $page * $size;

$total=pdo_fetchcolumn("select count(*) from " . tablename("yzpx_sun_lesson") .$where);
$pager = pagination($total, $page, $size);

$sql = 'SELECT * FROM '.tablename('yzpx_sun_lesson')."{$where} ORDER BY id asc LIMIT ".(($page-1) * $size).','.$size;
$info = pdo_fetchall($sql);
if($info){
    foreach ($info as $key =>$value){
        $info[$key]['start_time']=date('Y-m-d H:i:s',$value['start_time']);
        $info[$key]['end_time']=date('Y-m-d H:i:s',$value['end_time']);
    }
}
$couid=$_GPC['couid'];
$type=$_GPC['type'];
//var_dump($type);exit;
if($_GPC['op']=='delete'){
    $res=pdo_delete('yzpx_sun_lesson',array('id'=>$_GPC['id']));
    if($res){
        message('删除成功',$this->createWebUrl('lessonlist',array('couid'=>$_GPC['couid'])),'success');
    }else{
        message('删除失败','','error');
    }
}

include $this->template('web/lessonlist');