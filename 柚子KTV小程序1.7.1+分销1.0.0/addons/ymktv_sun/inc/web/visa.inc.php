<?php
global $_GPC, $_W;
$GLOBALS['frames'] = $this->getMainMenu();
$info = pdo_get('fyly_sun_visa',array('uniacid' => $_W['uniacid'],'id' => $_GPC['id']));
// 获取门店数据
$branch = pdo_getall('fyly_sun_branch',array('uniacid'=>$_W['uniacid']));
if($info['imgs']){
    if(strpos($info['imgs'],',')){
        $imgs= explode(',',$info['imgs']);
    }else{
        $imgs=array(
            0=>$info['imgs']
        );
    }
}
if($info['build_id']){
    $build_id = explode(',',$info['build_id']);
}
if (checksubmit('submit')) {
    if($_GPC['imgs']){
        $data['imgs']=implode(",",$_GPC['imgs']);
    }else{
        $data['imgs']='';
    }
    $data['uniacid'] = $_W['uniacid'];
    $appinfo = pdo_get('fyly_sun_system',array('uniacid' => $_W['uniacid']));
    $data['app_name'] = $appinfo['pt_name']; //小程序名字
    $data['visa_name'] = $_GPC['visa_name'];
    $data['build_id'] = implode(',',$_GPC['build_id']); // 门店id
    $data['visa_cost'] = $_GPC['visa_cost'];
    $data['visa_price'] = $_GPC['visa_price'];
    $data['visa_country'] = $_GPC['visa_country'];
    $data['entry_num'] = $_GPC['entry_num'];
    $data['stay_days'] = $_GPC['stay_days'];
    $data['valid_term'] = $_GPC['valid_term'];
    $data['visa_type'] = $_GPC['visa_type'];
    $data['affiliation'] = $_GPC['affiliation'];
    $data['handle_time'] = $_GPC['handle_time'];
    $data['baseinfo'] = htmlspecialchars_decode($_GPC['baseinfo']);
    $data['required_material'] = htmlspecialchars_decode($_GPC['required_material']);
    $data['process'] = htmlspecialchars_decode($_GPC['process']);
    $data['time'] = date("Y-m-d H:i:s");
    //商品缩略小图
    if ($_GPC['thumbnail']){
        $data['thumbnail'] = $_GPC['thumbnail'];
    }else{
        $data['thumbnail'] = '';
    }
    //商品缩略大图
    if ($_GPC['big_thumbnail']){
        $data['big_thumbnail'] = $_GPC['big_thumbnail'];
    }else{
        $data['big_thumbnail'] = '';
    }
    if (empty($_GPC['id'])) {
        $res = pdo_insert('fyly_sun_visa', $data);
    } else {
        $res = pdo_update('fyly_sun_visa', $data,array('id' => $_GPC['id']));
    }
    if ($res) {
        message('编辑成功', $this->createWebUrl('visas', array()), 'success');
    } else {
        message('编辑失败', '', 'error');
    }
}

include $this->template('web/visa');