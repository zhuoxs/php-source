<?php
global $_GPC, $_W;
$GLOBALS['frames'] = $this->getMainMenu();
$info=pdo_get('ymktv_sun_active',array('uniacid'=>$_W['uniacid'],'id'=>$_GPC['id']));
// 分店数据
$build = pdo_getall('ymktv_sun_building',array('uniacid'=>$_W['uniacid']));
if($info){
    $lb_imgs = explode(',',$info['lb_imgs']);
}
if($info['build_id']){
    $info['build_id'] = explode(',',$info['build_id']);
}

$id = $_GPC['id'];
if (!empty($id)) {
    $item = pdo_fetch("SELECT *  FROM " . tablename('ymktv_sun_active') . " WHERE id = :id", array(':id' => $id));
    $piclist1 = unserialize($item['thumb_url']);
    $piclist = array();
    if(is_array($piclist1)){
        foreach($piclist1 as $p){
            $piclist[] = is_array($p)?$p['attachment']:$p;
        }
    }
}

if(checksubmit('submit')){

        if(is_array($_GPC['thumbs'])){
            $thumb_data['thumb_url'] = serialize($_GPC['thumbs']);
        }
        if(strlen($_GPC['title']) > 42 ){
            message('标题限制字数14个');
        }
        if($_GPC['lb_imgs']){
            $datas['lb_imgs']=implode(',',$_GPC['lb_imgs']);
        }else{
            $datas['lb_imgs']='';
        }
        $data = array(
            'storeinfo' => $_GPC['storeinfo'],
            'uniacid' => $_W['uniacid'],
            'title'=>$_GPC['title'],
            'subtitle'=>$_GPC['subtitle'],
            'content' => ihtmlspecialchars($_GPC['content']),
            'astime' => $_GPC['astime'],
            'antime' => $_GPC['antime'],
            'active_num' => $_GPC['active_num'],
            'share_plus' => $_GPC['share_plus'],
            'new_partnum' => $_GPC['new_partnum'],
            'sort'=>$_GPC['sort'],
            'showindex' => $_GPC['showindex'],
            'thumb'=>$_GPC['thumb'],
            'sharenum'=>$_GPC['sharenum'],
            'createtime' => TIMESTAMP,
            'num'=>$_GPC['num'],
            'details'=>htmlspecialchars_decode($_GPC['details']),
            'thumb_url'=>$thumb_data['thumb_url'],
            'lb_imgs'=>$datas['lb_imgs'],
            'build_id'=>implode(',',$_GPC['build_id']),
			'status'=>1
        );
        if($_GPC['showindex']==1){
            pdo_update('ymktv_sun_active',array('showindex'=>0),array('uniacid'=>$_W['uniacid'],'showindex'=>1));
        }
        if (!empty($id)) {
            unset($data['createtime']);
            pdo_update('ymktv_sun_active', $data, array('id' => $id));
        } else {
            pdo_insert('ymktv_sun_active', $data);
            $id = pdo_insertid();
        }
        message('更新成功！', $this->createWebUrl('active'), 'success');
        }
include $this->template('web/addactive');