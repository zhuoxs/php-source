<?php
global $_W, $_GPC;
$weid = $this->_weid;
$action = 'setting';
$title = '系统设置';
$GLOBALS['frames'] = $this->getMainMenu();
$config = $this->module['config']['weisrc_dish'];
load()->func('tpl');

$stores = pdo_fetchall("SELECT * FROM " . tablename($this->table_stores) . " WHERE weid = :weid ORDER BY `id` DESC", array(':weid' => $_W['uniacid']));
if (empty($stores)) {
    $url = $this->createWebUrl('stores', array('op' => 'display'));
}

$setting = $this->getSetting();

$fans = $this->getFansByOpenid($setting['tpluser']);
$styles = pdo_fetchall("SELECT * FROM " . tablename('weisrc_dish_style') . " WHERE weid = :weid ORDER BY `displayorder` DESC, id DESC", array(':weid' => $weid));

$operation = !empty($_GPC['op']) ? $_GPC['op'] : 'display';

if ($operation == 'display') {
    if (empty($styles)) {
        pdo_insert(
            'weisrc_dish_style',
            array(
                'title' => '轮播图',
                'weid' => $weid,
                'type' => 'home_banner',
                'status' => 1,
                'displayorder' => 4,
            )
        );
        pdo_insert(
            'weisrc_dish_style',
            array(
                'title' => '门店分类',
                'weid' => $weid,
                'type' => 'home_type',
                'status' => 1,
                'displayorder' => 3,
            )
        );
        pdo_insert(
            'weisrc_dish_style',
            array(
                'title' => '平台广告',
                'weid' => $weid,
                'type' => 'home_ad',
                'status' => 1,
                'displayorder' => 2,
            )
        );
        pdo_insert(
            'weisrc_dish_style',
            array(
                'title' => '商家列表',
                'weid' => $weid,
                'type' => 'home_list',
                'status' => 1,
                'displayorder' => 1,
            )
        );
    }

//    $styles = pdo_fetchall("SELECT * FROM " .tablename('weisrc_dish_style') . " WHERE weid=:weid", array(':weid' =>
//        $weid));
//    print_r($styles);
//    exit;

    if (checksubmit('submit')) {
        $mcount = count($_GPC['mtype']);
        foreach ($_GPC['mtype'] as $key => $value) {
            pdo_update('weisrc_dish_style', array('displayorder' => $mcount), array('id' => $key));
//            $style = pdo_fetch("SELECT * FROM " .tablename('weisrc_dish_style') . " WHERE id=:id", array(':id' => $key));
//            if (!empty($style)) {
//
//            } else {
//
//            }
            $mcount--;
        }
        foreach ($_GPC['newmtype'] as $key => $value) {
            pdo_insert(
                'weisrc_dish_style',
                array(
                    'title' => '图片组',
                    'weid' => $weid,
                    'type' => 'home_slide',
                    'status' => 1,
                    'displayorder' => $mcount,
                )
            );
        }

        message('操作成功', $this->createWebUrl('style'), 'success');
    }
} elseif ($operation == 'post') {
    $id = intval($_GPC['id']);


    $item = pdo_fetch("select * from " . tablename('weisrc_dish_style') . " where id=:id and weid =:weid", array(':id'
    => $id, ':weid' => $weid));

    $prize = pdo_fetchall("SELECT * FROM " . tablename('weisrc_dish_pic') . " WHERE styleid = :styleid ORDER BY `id` asc", array(':styleid' => $id));

    if (checksubmit('submit')) {
        $data = array(
            'title' => trim($_GPC['title']),
            'slidetype' => intval($_GPC['slidetype']),
        );
        pdo_update('weisrc_dish_style', $data, array('id' => $id, 'weid' => $weid));
        
        if (!empty($_GPC['pictitle'])) {
            foreach ($_GPC['pictitle'] as $index => $pictitle) {
                if (empty($pictitle)) {
                    continue;
                }
                $insertprize = array(
                    'styleid' => $id,
                    'weid' => $weid,
                    'pictitle' => $_GPC['pictitle'][$index],
                    'picurl' => $_GPC['picurl'][$index],
                    'picimage' => $_GPC['picimage'][$index],
                    'nowprice' => $_GPC['picnowprice'][$index],
                    'oldprice' => $_GPC['picoldprice'][$index],
                    'dateline' => TIMESTAMP
                );
                pdo_update('weisrc_dish_pic', $insertprize, array('id' => $index));
            }
        }
        if (!empty($_GPC['pictitle_new'])&&count($_GPC['pictitle_new'])>=1) {
            foreach ($_GPC['pictitle_new'] as $index => $credit_type) {
                if (empty($credit_type)) {
                    continue;
                }
                $insertprize = array(
                    'styleid' => $id,
                    'weid' => $weid,
                    'picurl' => $_GPC['picurl_new'][$index],
                    'pictitle' => $_GPC['pictitle_new'][$index],
                    'picimage' => $_GPC['picimage_new'][$index],
                    'nowprice' => $_GPC['picnowprice_new'][$index],
                    'oldprice' => $_GPC['picoldprice_new'][$index],
                );
                pdo_insert('weisrc_dish_pic', $insertprize);
            }
        }
        message('操作成功', $this->createWebUrl('style', array('op' => 'post', 'id' => $id)), 'success');
    }
} elseif ($operation == 'delete') {
    $id = intval($_GPC['id']);
    pdo_delete('weisrc_dish_style', array('id' => $id, 'weid' => $weid));
    message('操作成功', $this->createWebUrl('style'), 'success');
} elseif ($operation == 'deletepic') {
    $id = intval($_GPC['picid']);
    pdo_delete('weisrc_dish_pic', array('id' => $id, 'weid' => $weid));
} elseif ($operation == 'default') {

    $item = pdo_fetch("select * from " . tablename('weisrc_dish_style') . " where weid ={$weid} AND type = 'home_banner'");
    if (empty($item)) {
        pdo_insert(
            'weisrc_dish_style',
            array(
                'title' => '轮播图',
                'weid' => $weid,
                'type' => 'home_banner',
                'status' => 1,
                'displayorder' => 4,
            )
        );
    }
    $item = pdo_fetch("select * from " . tablename('weisrc_dish_style') . " where weid ={$weid} AND type = 'home_type'");
    if (empty($item)) {
        pdo_insert(
            'weisrc_dish_style',
            array(
                'title' => '门店分类',
                'weid' => $weid,
                'type' => 'home_type',
                'status' => 1,
                'displayorder' => 3,
            )
        );
    }
    $item = pdo_fetch("select * from " . tablename('weisrc_dish_style') . " where weid ={$weid} AND type = 'home_ad'");
    if (empty($item)) {
        pdo_insert(
            'weisrc_dish_style',
            array(
                'title' => '平台广告',
                'weid' => $weid,
                'type' => 'home_ad',
                'status' => 1,
                'displayorder' => 2,
            )
        );
    }
    $item = pdo_fetch("select * from " . tablename('weisrc_dish_style') . " where weid ={$weid} AND type = 'home_list'");
    if (empty($item)) {
        pdo_insert(
            'weisrc_dish_style',
            array(
                'title' => '商家列表',
                'weid' => $weid,
                'type' => 'home_list',
                'status' => 1,
                'displayorder' => 1,
            )
        );
    }
    message('操作成功', $this->createWebUrl('style', array('op' => 'display')), 'success');
}

include $this->template('web/style');
