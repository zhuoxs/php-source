<?php

global $_GPC, $_W,$tag;
$GLOBALS['frames'] = $this->getMainMenu();
$type = isset($_GPC['type'])?$_GPC['type']:'all';

$headline = pdo_getall('fyly_sun_headline',array('uniacid'=>$_W['uniacid']),'','','addtime DESC');
foreach ($headline as $k=>$v){
    if($v['gid']){
        $headline[$k]['goods_name'] = pdo_getcolumn('fyly_sun_goods',array('uniacid'=>$_W['uniacid'],'id'=>$v['gid']),'goods_name');
    }else{
        $headline[$k]['goods_name'] = '暂未关联';
    }
    $headline[$k]['cname'] = pdo_getcolumn('fyly_sun_category',array('uniacid'=>$_W['uniacid'],'cid'=>$v['cid']),'cname');

}
if($_GPC['op']=='delete'){
    $res = pdo_delete('fyly_sun_headline',array('id'=>$_GPC['id']));
    if($res){
        message('删除成功',$this->createWebUrl('headline',array()),'success');
    }else{
        message('删除失败','','error');
    }
}
include $this->template('web/headline');