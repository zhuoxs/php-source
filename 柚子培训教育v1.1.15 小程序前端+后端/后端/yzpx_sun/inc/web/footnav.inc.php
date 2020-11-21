<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/8/27
 * Time: 15:36
 */

global $_GPC, $_W;

$GLOBALS['frames'] = $this->getMainMenu();

$where="uniacid =".$_W['uniacid'];

$page = max(1, intval($_GPC['page']));
$size = intval($_GPC['psize']) ? intval($_GPC['psize']) : 10;
$sql = "SELECT * FROM ims_yzpx_sun_footnav where ".$where." ORDER BY id DESC LIMIT ".(($page-1) * $size).','.$size;
$list = pdo_fetchall($sql);

$total=pdo_fetchcolumn("select count(*) from ims_yzpx_sun_footnav where ".$where);
$pager = pagination($total, $page, $size);

if($_GPC['op']=='delete'){

    $res=pdo_delete('yzpx_sun_footnav',array('id'=>$_GPC['id']));
    if($res){
        message('删除成功',$this->createWebUrl('footnav',array()),'success');
    }else{
        message('删除失败','','error');
    }

}

include $this->template('web/footnav');