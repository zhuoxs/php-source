<?php
global $_GPC, $_W;
$GLOBALS['frames'] = $this->getMainMenu();
$info=pdo_get('yzqzk_sun_active',array('uniacid'=>$_W['uniacid'],'id'=>$_GPC['id']));
$id = $_GPC['id'];
if (!empty($id)) {
    $item = pdo_fetch("SELECT *  FROM " . tablename('yzqzk_sun_active') . " WHERE id = :id", array(':id' => $id));
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
            'thumb_url'=>$thumb_data['thumb_url'],
        );
        if (!empty($id)) {
            unset($data['createtime']);
            pdo_update('yzqzk_sun_active', $data, array('id' => $id));
        } else {
            pdo_insert('yzqzk_sun_active', $data);
            $id = pdo_insertid();
        }
        message('更新成功！', $this->createWebUrl('active'), 'success');
        }
include $this->template('web/addactive');