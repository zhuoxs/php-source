<?php
global $_GPC, $_W;
$GLOBALS['frames'] = $this->getMainMenu();

//$store = pdo_getall('yzhd_sun_branch',array('uniacid'=>$_W['uniacid'],'stutes'=>1));
$category = pdo_getall('yzhd_sun_category',array('uniacid'=>$_W['uniacid']));
$branch_id = $_GPC['branch_id'];
$store = pdo_get('yzhd_sun_branch',array('uniacid'=>$_W['uniacid'],'id'=>$branch_id));
$info=pdo_get('yzhd_sun_caipin',array('cid'=>$_GPC['gid'],'uniacid'=>$_W['uniacid']));
if (empty($info['expire_time'])) {
    unset($info['expire_time']);
} else {
    $info['expire_time'] = date('Y-m-d H:i:s',$info['expire_time']);
}
if (empty($info['start_time'])) {
    unset($info['start_time']);
} else {
    $info['start_time'] = date('Y-m-d H:i:s',$info['start_time']);
}
if(checksubmit('submit')){
    if(empty($_GPC['branch_id'])) {
        message('所属商家错误', '', 'error');
    }
    if(empty($_GPC['goods_name'])) {
        message('商品名称不能为空', '', 'error');
    }

    if (empty($_GPC['goods_details'])) {
        message('商品详情不能为空', '', 'error');
    }

    if (empty($_GPC['pic'])) {
        message('商品图片不能为空', '', 'error');
    }

    if (empty($_GPC['original_price'])) {
        message('商品原价不能为空', '', 'error');
    }

    if (! is_numeric($_GPC['original_price'])) {
        message('商品原价错误', '', 'error');
    }

    if (! is_numeric($_GPC['current_price'])) {
        message('商品现价错误', '', 'error');
    }

    if (! is_numeric($_GPC['fans_price'])) {
        message('商品粉丝价错误', '', 'error');
    }



    if (empty($_GPC['current_price'])) {
        message('商品现价不能为空', '', 'error');
    }

    if (empty($_GPC['fans_price'])) {
        message('商品粉丝价不能为空', '', 'error');
    }
    if (empty($_GPC['sp_num'])) {
        message('商品数量不能为空', '', 'error');
    }
    if (empty($_GPC['cate_name'])) {
        message('行业分类不能为空', '', 'error');
    }
    if (strlen($_GPC['cate_name'])>12) {
        message('行业分类字数不得大于四个字', '', 'error');
    }
    if (empty($_GPC['start_time'])) {
        message('开始时间错误', '', 'error');
    }
    if (empty($_GPC['expire_time'])) {
        message('过期时间错误', '', 'error');
    }
    if($_GPC['start_time']>=$_GPC['expire_time']){
        message('开始时间不得大于结束时间');
    }
    $data['goods_name'] = $_GPC['goods_name'];
    $data['goods_details'] = htmlspecialchars_decode($_GPC['goods_details']);
    $data['pic'] = $_GPC['pic'];
    $data['original_price'] = $_GPC['original_price'];
    $data['current_price'] = $_GPC['current_price'];
    $data['fans_price'] = $_GPC['fans_price'];
    $data['state'] = 1;
    $data['sp_num'] = $_GPC['sp_num'];
    $data['xg_num'] = $_GPC['xg_num'] ? $_GPC['xg_num'] : 0;
    $data['create_time'] = time();
    $data['uniacid']=$_W['uniacid'];
    $data['goods_num'] = $_GPC['goods_num'];
    $data['branch_id'] = $_GPC['branch_id'];
     $data['recommend_num'] = $_GPC['recommend_num'];
    $data['is_recommend'] = $_GPC['is_recommend'];
    $data['details'] = htmlspecialchars_decode($_GPC['details']);
    $cid = intval($_GPC['cid']);
    $cate_info=pdo_get('yzhd_sun_category',array('cid'=>$cid));
    $data['cate_name'] = $_GPC['cate_name'];
    $data['start_time'] =strtotime($_GPC['start_time']);
    $data['expire_time'] =strtotime($_GPC['expire_time']);
    if(empty($_GPC['id'])){
        $res = pdo_insert('yzhd_sun_caipin', $data);

        if($res){
            message('添加成功',$this->createWebUrl('caipin',array('type'=>'all','branch_id'=>$branch_id)),'success');
        }else{
            message('添加失败','','error');
        }
    }else{
        unset($data['state']);
        $res = pdo_update('yzhd_sun_caipin', $data, array('cid' => $_GPC['id'],'uniacid'=>$_W['uniacid']));
    }
    if($res){
        message('修改成功',$this->createWebUrl('caipin',array('type'=>'all','branch_id'=>$branch_id)),'success');
    }else{
        message('修改失败','','error');
    }
}

include $this->template('web/addcaipin');
