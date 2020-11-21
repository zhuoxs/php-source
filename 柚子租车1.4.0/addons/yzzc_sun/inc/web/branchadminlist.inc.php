<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/10/17
 * Time: 15:17
 */
global $_GPC, $_W;
$GLOBALS['frames'] = $this->getMainMenu();
$where=" WHERE  uniacid=".$_W['uniacid'].' and bid ='.$_GPC['bid'];
if($_GPC['keywords']){
    $op=$_GPC['keywords'];
    $where.=" and uid LIKE  '%$op%'";
}
$page = max(1, intval($_GPC['page']));
$size = intval($_GPC['psize']) ? intval($_GPC['psize']) : 10;
$start= $page * $size;

$total=pdo_fetchcolumn("select count(*) from " . tablename("yzzc_sun_branch_admin") .$where);
$pager = pagination($total, $page, $size);

$sql = 'SELECT * FROM '.tablename('yzzc_sun_branch_admin')."{$where} ORDER BY id asc LIMIT ".(($page-1) * $size).','.$size;
$info = pdo_fetchall($sql);
$bid=$_GPC['bid'];
if($info){
    foreach ($info as $key =>$value){
        $info[$key]['createtime']=date('Y-m-d H:i:s',$value['createtime']);
        $user=pdo_get('yzzc_sun_user',array('id'=>$value['uid']),array('user_name'));
        $info[$key]['username']=$user['user_name'];
    }
}
if($_GPC['op']=='delete'){
    $res=pdo_delete('yzzc_sun_branch_admin',array('id'=>$_GPC['id']));
    if($res){
        message('删除成功',$this->createWebUrl('branchadminlist',array('bid'=>$_GPC['bid'])),'success');
    }else{
        message('删除失败','','error');
    }
}

include $this->template('web/branchadminlist');