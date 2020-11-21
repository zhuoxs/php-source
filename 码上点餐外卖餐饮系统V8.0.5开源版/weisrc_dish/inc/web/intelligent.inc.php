<?php
global $_W, $_GPC;
$weid = $this->_weid;
$action = 'intelligent';
$title = $this->actions_titles[$action];
load()->func('tpl');

$storeid = intval($_GPC['storeid']);
$this->checkStore($storeid);
$returnid = $this->checkPermission($storeid);
$cur_store = $this->getStoreById($storeid);
$GLOBALS['frames'] = $this->getNaveMenu($storeid,$action);

$operation = !empty($_GPC['op']) ? $_GPC['op'] : 'display';
if ($operation == 'display') {
    if (!empty($_GPC['displayorder'])) {
        foreach ($_GPC['displayorder'] as $id => $displayorder) {
            pdo_update($this->table_intelligent, array('displayorder' => $displayorder), array('id' => $id));
        }
        message('分类排序更新成功！', $this->createWebUrl('intelligent', array('op' => 'display', 'storeid' => $storeid)), 'success');
    }
    $children = array();
    $intelligents = pdo_fetchall("SELECT * FROM " . tablename($this->table_intelligent) . " WHERE weid = '{$weid}'  AND storeid ={$storeid} ORDER BY displayorder DESC");

    $goods = pdo_fetchall("SELECT * FROM " . tablename($this->table_goods) . " WHERE weid = '{$weid}'  AND storeid={$storeid} AND deleted=0 ORDER BY
displayorder DESC");
    $goods_arr = array();
    foreach ($goods as $key => $value) {
        $goods_arr[$value['id']] = $value['title'];
    }
} elseif ($operation == 'post') {
    $id = intval($_GPC['id']);
    if (!empty($id)) {
        $intelligent = pdo_fetch("SELECT * FROM " . tablename($this->table_intelligent) . " WHERE id = '$id'");
        if (!empty($intelligent)) {
            $goodsstrs = iunserializer($intelligent['content']);
            $goodsids = array();
            $goodscount = array();
            foreach ($goodsstrs as $key => $value) {
                $goodsids[] = $value['id'];
                $goodscount[$value['id']] = $value['count'];
            }

//            message($intelligent['content']);
//            foreach ($goodsstrs)

//            $goodsids = explode(',', $intelligent['content']);
        }
    } else {
        $intelligent = array(
            'displayorder' => 0,
        );
    }

    $categorys = pdo_fetchall("SELECT * FROM " . tablename($this->table_category) . " WHERE weid = '{$weid}'  AND storeid ={$storeid} ORDER BY displayorder DESC");
    $goods = pdo_fetchall("SELECT * FROM " . tablename($this->table_goods) . " WHERE weid = '{$weid}'  AND storeid ={$storeid} AND deleted=0 ORDER BY
displayorder DESC");
    $goods_arr = array();
    foreach ($goods as $key => $value) {
        foreach ($categorys as $key2 => $value2) {
            if ($value['pcate'] == $value2['id']) {
                $goods_arr[$value['pcate']][] = array('id' => $value['id'], 'title' => $value['title']);
            }
        }
    }

//    $goods  = array(
//        '3' => array('count' => 1),
//        '4' => array('count' => 1),
//    );
//
//    $goodsser = serialize($goods);
//
//    $goodslist = unserialize($goodsser);
//
//    foreach ($goodslist as $key => $value) {
//        echo 'id:' . $key . ';count:' . $value['count'] .';';
//    }
//    exit;
    if (checksubmit('submit')) {
        if (empty($_GPC['title'])) {
            message('请输入活动名称！');
        }

//        http://yueqing.oss-cn-beijing.aliyuncs.com/%E5%AE%89%E5%BF%83%E8%94%AC%E8%8F%9C/%E7%99%BD%E8%8F%9C%E8%8B%94.jpg
        if(!empty($_GPC['goodsids']['id'])) {
            $thumbs = array();
            foreach($_GPC['goodsids']['id'] as $key => $image) {
                if(empty($image)) {
                    continue;
                }
                $thumbs[] = array(
                    'id' => $key,
                    'count' => trim($_GPC['goodsids']['count'][$key]),
                );
            }
            $goodsdata = iserializer($thumbs);
        }
        $data = array(
            'weid' => $weid,
            'storeid' => $storeid,
            'name' => intval($_GPC['catename']),
            'title' => trim($_GPC['title']),
            'thumb' => trim($_GPC['thumb']),
//            'content' => trim(implode(',', $_GPC['goodsids'][''])),
            'content' => $goodsdata,
            'displayorder' => intval($_GPC['displayorder']),
        );

        if (empty($data['storeid'])) {
            message('非法参数');
        }

        if (!empty($id)) {
            pdo_update($this->table_intelligent, $data, array('id' => $id));
        } else {
            pdo_insert($this->table_intelligent, $data);
            $id = pdo_insertid();
        }
        message('更新成功！', $this->createWebUrl('intelligent', array('op' => 'display', 'storeid' => $storeid)), 'success');
    }

} elseif ($operation == 'delete') {
    $id = intval($_GPC['id']);
    $category = pdo_fetch("SELECT id FROM " . tablename($this->table_intelligent) . " WHERE id = '$id'");
    if (empty($category)) {
        message('抱歉，分类不存在或是已经被删除！', $this->createWebUrl('intelligent', array('op' => 'display', 'storeid' => $storeid)), 'error');
    }
    pdo_delete($this->table_intelligent, array('id' => $id, 'weid' => $weid));
    message('分类删除成功！', $this->createWebUrl('intelligent', array('op' => 'display', 'storeid' => $storeid)), 'success');
}
include $this->template('web/intelligent');