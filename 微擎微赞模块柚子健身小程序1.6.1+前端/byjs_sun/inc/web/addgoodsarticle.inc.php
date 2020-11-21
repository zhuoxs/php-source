<?php
global $_GPC, $_W;
$GLOBALS['frames'] = $this->getMainMenu();
if($_GPC['id']){
    $info=pdo_get('byjs_sun_goodsarticle',array('id'=>$_GPC['id'],'uniacid'=>$_W['uniacid']));
    $info['goods_name'] = pdo_getcolumn('byjs_sun_goods',array('id'=>$info['goods_id'],'uniacid'=>$_W['uniacid']),'goods_name');
	$goods=pdo_getall('byjs_sun_goods',array('uniacid'=>$_W['uniacid']),array('goods_name','id'));
}else if($_GPC['id'] == ''){
    $goods=pdo_getAll('byjs_sun_goods',array('uniacid'=>$_W['uniacid']));
    $info['op'] = 1;
}
//对goods_id进行处理
//$id = $info[0]['goods_id'];
//$goods_name = pdo_getcolumn('byjs_sun_goods',array('id'=>$id),'goods_name');
//$info[0]['goods_name'] = $goods_name;


if(checksubmit('submit')){
 // print_r($_GPC['goods_id']);die;
    if(empty($_GPC['title'])){
        message('请填写文章标题');
    }
    $data['uniacid']=$_W['uniacid'];
    $data['title'] = $_GPC['title'];
    $data['article'] = htmlspecialchars_decode($_GPC['article']);
    $data['img']  = $_GPC['img'];
    $data['goods_id'] = $_GPC['goods_id'];
    $data['top'] = 1;
    $data['top_time']=Date('Y-m-d H:i:s');

    if(empty($_GPC['id'])){
        $res = pdo_insert('byjs_sun_goodsarticle', $data);
    }else{
        $res = pdo_update('byjs_sun_goodsarticle', $data, array('id' => $_GPC['id'],'uniacid'=>$_W['uniacid']));
    }
    if($res){
        message('编辑成功',$this->createWebUrl('goodsarticle',array()),'success');
    }else{
        message('编辑失败','','error');
    }
}
include $this->template('web/addgoodsarticle');