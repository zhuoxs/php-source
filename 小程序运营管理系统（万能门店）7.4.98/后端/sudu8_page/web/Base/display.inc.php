<?php

	global $_GPC, $_W;
    $uniacid = $_W['uniacid'];
    $cateid = $_GPC['cateid'];
    $chid = $_GPC['chid'];

	$_W['page']['title'] = '产品基础信息添加';

    $item = pdo_fetch("SELECT * FROM ".tablename('sudu8_page_base') ." WHERE uniacid = :uniacid", array(':uniacid' => $uniacid));

    $item['slide'] = unserialize($item['slide']);

    if (checksubmit('submit')) {

        if (empty($_GPC['name'])) {

            message('请输入门店名称！');

        }

        $data = array(

            'uniacid' => $_W['uniacid'],

            'banner' => $_GPC['banner'],

            'slide' => serialize($_GPC['slide']),

            'name' => $_GPC['name'],

            'logo' => $_GPC['logo'],

            'logo2' => $_GPC['logo2'],

            'video' => $_GPC['video'],

            'v_img' => $_GPC['v_img'],

            'desc' => $_GPC['desc'],

            'address' => $_GPC['address'],

            'time' => $_GPC['time'],

            'tel' => $_GPC['tel'],

            'longitude' => $_GPC['longitude'],

            'latitude' => $_GPC['latitude'],

            'about' => $_GPC['about'],

        );

        if (empty($item['name'])) {

            pdo_insert('sudu8_page_base', $data);

        } else {

            pdo_update('sudu8_page_base', $data ,array('uniacid' => $uniacid));

        }

        message('基础信息更新成功!', $this->createWebUrl('base', array('op'=>'display',"cateid"=>$cateid,"chid"=>$chid)), 'success');

    }










return include self::template('web/Base/display');
