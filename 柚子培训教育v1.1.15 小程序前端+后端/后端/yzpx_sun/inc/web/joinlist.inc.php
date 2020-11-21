<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/7/10
 * Time: 15:37
 */
global $_GPC, $_W;
$GLOBALS['frames'] = $this->getMainMenu();
$where=" WHERE  uniacid=".$_W['uniacid']." and status = 1 and cid =".$_GPC['cid'];
if($_GPC['keywords']){
    $op=$_GPC['keywords'];
    $where.=" and name LIKE  '%$op%'";
}
$page = max(1, intval($_GPC['page']));
$size = intval($_GPC['psize']) ? intval($_GPC['psize']) : 10;
$start= $page * $size;

$total=pdo_fetchcolumn("select count(*) from " . tablename("yzpx_sun_course_teach") .$where);
$pager = pagination($total, $page, $size);

$sql = 'SELECT * FROM '.tablename('yzpx_sun_course_teach')."{$where} ORDER BY id DESC LIMIT ".(($page-1) * $size).','.$size;
$info = pdo_fetchall($sql);
$cname=$_GPC['cname'];
$cid=$_GPC['cid'];
if($info){
    foreach ($info as $key =>$value){
        $teacher=pdo_get('yzpx_sun_teacher',array('id'=>$value['tid']),array('name'));
        $info[$key]['tname']=$teacher['name'];
        if($value['sid']){
            $school=pdo_get('yzpx_sun_school',array('id'=>$value['sid']),array('name'));
            $info[$key]['sname']=$school['name'];
        }
        $info[$key]['createtime']=date('Y-m-d H:i:s',$value['createtime']);
    }
}

//var_dump($info);exit;
if($_GPC['op']=='delete'){
    $ress=pdo_get('yzpx_sun_course_teach',array('id'=>$_GPC['id']),array('cid'));
    $res=pdo_delete('yzpx_sun_course_teach',array('id'=>$_GPC['id']));
    if($res){
        message('删除成功',$this->createWebUrl('joinlist',array('cid'=>$ress['cid'],'cname'=>$_GPC['cname'])),'success');
    }else{
        message('删除失败','','error');
    }
}

include $this->template('web/joinlist');