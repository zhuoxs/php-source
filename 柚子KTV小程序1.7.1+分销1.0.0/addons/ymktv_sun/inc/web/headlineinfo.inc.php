<?php
global $_GPC, $_W;
$GLOBALS['frames'] = $this->getMainMenu();
// 获取对应id的头条数据
if($_GPC['id']){
    $info = pdo_get('fyly_sun_headline',array('uniacid'=>$_W['uniacid'],'id'=>$_GPC['id']));
}else{
    $info = [];
}


// 查找头条分类数据
$cateData = pdo_getall('fyly_sun_category',array('uniacid'=>$_W['uniacid']));
// 查找商品数据
$goodData = pdo_getall('fyly_sun_goods',array('uniacid'=>$_W['uniacid'],'state'=>2),'','','time DESC');

if(checksubmit('submit')){
    $data['head_name'] = $_GPC['head_name'];
    $data['cid'] = $_GPC['cid'];
    $data['gid'] = $_GPC['gid'];
    $data['uniacid'] = $_W['uniacid'];
    $data['head_num'] = $_GPC['head_num'];
    $data['head_img'] = $_GPC['head_img'];
    $data['head_details'] = htmlspecialchars_decode($_GPC['head_details']);
    $data['addtime'] = time();
    if($_GPC['id']=='' || $_GPC['id']==null){
        $res = pdo_insert('fyly_sun_headline',$data);
    }else{
        $res = pdo_update('fyly_sun_headline',$data,array('id'=>$_GPC['id']));
    }

    if($res){
        message('编辑成功',$this->createWebUrl('headline',array()),'success');
    }else{
        message('编辑失败','','error');
    }
}
include $this->template('web/headlineinfo');