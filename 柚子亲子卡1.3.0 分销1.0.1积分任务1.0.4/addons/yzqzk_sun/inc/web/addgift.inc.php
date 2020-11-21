<?php
global $_GPC, $_W;
$GLOBALS['frames'] = $this->getMainMenu();
$sql = 'SELECT * FROM ' . tablename('yzqzk_sun_active') . ' WHERE `uniacid` = :uniacid ';

$activelist = pdo_fetchall($sql, array(':uniacid' => $_W['uniacid']));
$operation = !empty($_GPC['op']) ? $_GPC['op'] : 'display';
//
//$pid = 45;
//$uid = 'ojKX54teKGVjnu0IBoFb-KvdZO9g';
//$gift = pdo_getall('yzqzk_sun_gift',array('pid'=>$pid));
//$userActive = pdo_getall('yzqzk_sun_user_active',array('uid'=>$uid,'active_id'=>$pid));
//$a=[];
//
//foreach ($gift as $k=>$v){
//    foreach ($userActive as $kk=>$vv){
//        if($vv['kapian_id']==$v['id']){
//            $gift[$k]['num'] = $vv['num'];
//            $gift[$k]['uid'] = $vv['uid'];
//        }
//    }
//}
//
//p($gift);die;
//
$id = $_GPC['id'];
if (!empty($id)) {
    $item = pdo_fetch("SELECT *  FROM " . tablename('yzqzk_sun_gift') . " WHERE id = :id", array(':id' => $id));
}
if(checksubmit('submit')){
    if(is_array($_GPC['thumbs'])){
        $thumb_data['thumb_url'] = serialize($_GPC['thumbs']);
    }
    $data = array(
        'uniacid' => $_W['uniacid'],
        'title'=>$_GPC['title'],
        'content' => ihtmlspecialchars($_GPC['content']),
        'sort'=>$_GPC['sort'],
        'createtime' => TIMESTAMP,
        'pid'=>$_GPC['pid'],
        'rate'=>$_GPC['rate'],
        'thumb'=>$_GPC['thumb'],
        'thumb2'=>$_GPC['thumb2'],
    );

    if (!empty($id)) {
        unset($data['createtime']);
        pdo_update('yzqzk_sun_gift', $data, array('id' => $id));
    } else {
        pdo_insert('yzqzk_sun_gift', $data);
        $id = pdo_insertid();
    }
    message('更新成功！', $this->createWebUrl('gift', array('op' => 'display')), 'success');
}elseif ($operation = 'post'){
    $id = $_GPC['id'];

    if (!empty($id)) {
        $item = pdo_fetch("SELECT *  FROM " . tablename('yzqzk_sun_gift') . " WHERE id = :id", array(':id' => $id));
    }
}
include $this->template('web/addgift');