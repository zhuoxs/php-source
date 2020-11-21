<?php

global $_GPC, $_W;
$uniacid = $_W['uniacid'];
$cateid = $_GPC['cateid'];
$chid = $_GPC['chid'];
$id = intval($_GPC['id']);

$item = pdo_fetch("SELECT * FROM ".tablename('sudu8_page_banner')." WHERE id = :id and uniacid = :uniacid ", array(':id' => $id ,':uniacid' => $uniacid));

if (checksubmit('submit')) {

    if(is_null($_GPC['flag'])){

        $_GPC['flag'] = 1;

    }

    $data = array(

        'uniacid' => $_W['uniacid'],

        'num' => intval($_GPC['num']),

        'type' =>$_GPC['type'],

        'flag' => $_GPC['flag'],

        'pic' => $_GPC['pic'],

        'url' => trim($_GPC['url']),

        'descp' => $_GPC['descp'],

    );

    if (empty($item['id'])) {

        pdo_insert('sudu8_page_banner', $data);

    } else {

        pdo_update('sudu8_page_banner', $data ,array('id' => $item['id']));

    }

    message('图片添加成功!', $this->createWebUrl('base', array('op'=>$_GPC['type'],"cateid"=>$cateid,"chid"=>$chid)), 'success');

 }
return include self::template('web/Base/bannerpost');