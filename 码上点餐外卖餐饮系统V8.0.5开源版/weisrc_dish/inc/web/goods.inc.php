<?php
global $_GPC, $_W;
$weid = $this->_weid;
$action = 'goods';
$storeid = intval($_GPC['storeid']);
//检查门店
$this->checkStore($storeid);
$title = $this->actions_titles[$action];
$returnid = $this->checkPermission($storeid);
$deleted = intval($_GPC['deleted']);
//当前门店
$cur_store = $this->getStoreById($storeid);
//设置菜单
$GLOBALS['frames'] = $this->getNaveMenu($storeid,$action);

$category = pdo_fetchall("SELECT * FROM " . tablename($this->table_category) . " WHERE weid = :weid And storeid=:storeid ORDER BY parentid ASC, displayorder DESC", array(':weid' => $weid, ':storeid' => $storeid), 'id');
if (!empty($category)) {
    $children = '';
    foreach ($category as $cid => $cate) {
        if (!empty($cate['parentid'])) {
            $children[$cate['parentid']][$cate['id']] = array($cate['id'], $cate['name']);
        }
    }
}

$label = pdo_fetchall("SELECT * FROM " . tablename($this->table_print_label) . " WHERE weid = :weid And storeid=:storeid ORDER BY displayorder DESC", array(':weid' => $weid, ':storeid' => $storeid), 'id');

$nowtime = mktime(0, 0, 0);
pdo_query("UPDATE " . tablename($this->table_goods) . " SET today_counts=0,lasttime=:time WHERE storeid=:storeid AND lasttime<:nowtime", array(':storeid' => $storeid, ':time' => TIMESTAMP, ':nowtime' => $nowtime));

$operation = !empty($_GPC['op']) ? $_GPC['op'] : 'display';
if ($operation == 'post') {
    load()->func('tpl');
    $id = intval($_GPC['id']);
    if (!empty($id)) {
        $item = pdo_fetch("SELECT * FROM " . tablename($this->table_goods) . " WHERE id = :id", array(':id' => $id));
        if (empty($item)) {
            message('抱歉，商品不存在或是已经删除！', '', 'error');
        } else {
            if (!empty($item['thumb_url'])) {
                $item['thumbArr'] = explode('|', $item['thumb_url']);
            }
            if (!empty($item['week'])) {
                $weeks = explode(',', $item['week']);
            }
        }
    }
    if (empty($item)) {
        $item = array(
            'isshow_sales' => 1,
            'status' => 1,
            'week' => '0,1,2,3,4,5,6',
            'istime' => 0,
            'begintime' => "00:00",
            'endtime' => "23:59",
            'startcount' => 1,
        );
        $weeks = explode(',', $item['week']);
        $starttime = date('Y-m-d H:i');
        $endtime = date('Y-m-d H:i', TIMESTAMP + 86400 * 30);
    } else {
        if ($item['startdate'] == 0) {
            $starttime = date('Y-m-d H:i');
        } else {
            $starttime = date('Y-m-d H:i', $item['startdate']);
        }
        if ($item['enddate'] == 0) {
            $endtime = date('Y-m-d H:i', TIMESTAMP + 86400 * 30);
        } else {
            $endtime = date('Y-m-d H:i', $item['enddate']);
        }
    }

    $optionlist = pdo_fetchall("SELECT * FROM " . tablename('weisrc_dish_goods_option') . " WHERE goodsid=:goodsid order by id", array(':goodsid' => $id));
    if (checksubmit('submit')) {
        $data = array(
            'weid' => intval($weid),
            'storeid' => $storeid,
            'title' => trim($_GPC['goodsname']),
            'labelid' => intval($_GPC['labelid']),
            'pcate' => intval($_GPC['pcate']),
            'ccate' => intval($_GPC['ccate']),
            'thumb' => trim($_GPC['thumb']),
            'week' => trim(implode(',', $_GPC['week'])),
            'credit' => intval($_GPC['credit']),
            'unitname' => trim($_GPC['unitname']),
            'description' => trim($_GPC['description']),
            'content' => trim($_GPC['content']),
            'taste' => trim($_GPC['taste']),
            'istime' => intval($_GPC['istime']),
            'begintime' => trim($_GPC['begintime']),
            'endtime' => trim($_GPC['endtime']),
            'startdate' => strtotime($_GPC['datelimit']['start']),
            'enddate' => strtotime($_GPC['datelimit']['end']),
            'counts' => intval($_GPC['counts']),
            'today_counts' => intval($_GPC['today_counts']),
            'sales' => intval($_GPC['sales']),
            'isspecial' => empty($_GPC['marketprice']) ? 1 : 2,
            'isoptions' => intval($_GPC['isoptions']),
            'marketprice' => floatval($_GPC['marketprice']),
            'commission_money1' => floatval($_GPC['commission_money1']),
            'commission_money2' => floatval($_GPC['commission_money2']),
            'memberprice' => !empty($_GPC['memberprice']) ? floatval($_GPC['memberprice']) : '',
            'productprice' => !empty($_GPC['productprice']) ? floatval($_GPC['productprice']) : '',
            'packvalue' => floatval($_GPC['packvalue']),
            'delivery_commission_money' => floatval($_GPC['delivery_commission_money']),
            'subcount' => intval($_GPC['subcount']),
            'status' => intval($_GPC['status']),
            'recommend' => intval($_GPC['recommend']),
            'isshow_sales' => intval($_GPC['isshow_sales']),
            'displayorder' => intval($_GPC['displayorder']),
            'dateline' => TIMESTAMP,
            'startcount' => intval($_GPC['startcount']),
            'endcount' => intval($_GPC['endcount']),
            'freecount' => intval($_GPC['freecount']),

        );

        if ($data['startcount'] < 1) {
            message('起售份数不能小于1!');
        }

        if ($_W['role'] == 'operator') {
            unset($data['credit']);
        }

        if (empty($data['title'])) {
            message('请输入商品名称！');
        }
        if (empty($data['pcate'])) {
            message('请选择商品分类！');
        }

        if (!empty($_FILES['thumb']['tmp_name'])) {
            load()->func('file');
            file_delete($_GPC['thumb_old']);
            $upload = file_upload($_FILES['thumb']);
            if (is_error($upload)) {
                message($upload['message'], '', 'error');
            }
            $data['thumb'] = $upload['path'];
        }
        if (empty($id)) {
            pdo_insert($this->table_goods, $data);
            $id = pdo_insertid();
        } else {
            unset($data['dateline']);
            pdo_update($this->table_goods, $data, array('id' => $id));
        }

        //增加
        if (is_array($_GPC['optiontitle'])) {
            foreach ($_GPC['optiontitle'] as $nid => $val) {
                $optiontitle = trim($_GPC['optiontitle'][$nid]);
                $optionprice = floatval($_GPC['optionprice'][$nid]);
                $optionstart = trim($_GPC['optionstart'][$nid]);
                $optiontype = trim($_GPC['optiontype'][$nid]);
                $optiondisplayorder = intval($_GPC['optiondisplayorder'][$nid]);

                if (empty($optiontitle)) {
                    continue;
                }

                $data = array(
                    'goodsid' => $id,
                    'type' => $optiontype,
                    'start' => $optionstart,
                    'title' => $optiontitle,
                    'price' => $optionprice,
                    'displayorder' => $optiondisplayorder
                );
                pdo_insert('weisrc_dish_goods_option', $data);
                $did = pdo_insertid();
                $optionids[] = $did;
            }
        }
        $optionids = implode(',', array_unique($optionids));
        if (!empty($optionids)) {
            pdo_query('delete from ' . tablename('weisrc_dish_goods_option') . " where goodsid = :goodsid and id not in ({$optionids})", array(':goodsid' => $id));
        }

        message('商品更新成功！', $this->createWebUrl('goods', array('op' => 'display', 'storeid' => $storeid)), 'success');
    }
} elseif ($operation == 'display') {
    if (!empty($_GPC['displayorder'])) {
        foreach ($_GPC['displayorder'] as $id => $displayorder) {
            pdo_update($this->table_goods, array('displayorder' => $displayorder), array('id' => $id));
        }
        message('排序更新成功！', $this->createWebUrl('goods', array('op' => 'display', 'storeid' => $storeid)), 'success');
    }

    $pindex = max(1, intval($_GPC['page']));
    $psize = 8;
    $condition = "  weid = '{$weid}' AND storeid ={$storeid} AND deleted={$deleted} ";
    if (!empty($_GPC['keyword'])) {
        $condition .= " AND title LIKE '%{$_GPC['keyword']}%'";
    }

    if (!empty($_GPC['category_id'])) {
        $cid = intval($_GPC['category_id']);
        $condition .= " AND pcate = '{$cid}'";
    }

    if (isset($_GPC['status'])) {
        $condition .= " AND status = '" . intval($_GPC['status']) . "'";
    }

    $list = pdo_fetchall("SELECT * FROM " . tablename($this->table_goods) . " WHERE $condition ORDER BY status DESC, displayorder DESC, id DESC LIMIT " . ($pindex - 1) * $psize . ',' . $psize);

    $total = pdo_fetchcolumn('SELECT COUNT(1) FROM ' . tablename($this->table_goods) . " WHERE $condition");

    $pager = pagination($total, $pindex, $psize);
} elseif ($operation == 'delete') {
    $id = intval($_GPC['id']);
    $row = pdo_fetch("SELECT id, thumb FROM " . tablename($this->table_goods) . " WHERE id = :id", array(':id' => $id));
    if (empty($row)) {
        message('抱歉，商品 不存在或是已经被删除！');
    }
    pdo_update($this->table_goods, array('deleted' => 1), array('id' => $id, 'weid' => $weid));
    message('删除成功！', referer(), 'success');
}  elseif ($operation == 'restore') {
    $id = intval($_GPC['id']);
    $row = pdo_fetch("SELECT id, thumb FROM " . tablename($this->table_goods) . " WHERE id = :id", array(':id' => $id));
    if (empty($row)) {
        message('抱歉，商品 不存在或是已经被删除！');
    }
    pdo_update($this->table_goods, array('deleted' => 0), array('id' => $id, 'weid' => $weid));
    message('操作成功！', referer(), 'success');
} elseif ($operation == 'deleteall') {
    $rowcount = 0;
    $notrowcount = 0;
    foreach ($_GPC['idArr'] as $k => $id) {
        $id = intval($id);
        if (!empty($id)) {
            $goods = pdo_fetch("SELECT * FROM " . tablename($this->table_goods) . " WHERE id = :id", array(':id' => $id));
            if (empty($goods)) {
                $notrowcount++;
                continue;
            }
            pdo_update($this->table_goods, array('deleted' => 1), array('id' => $id, 'weid' => $weid));
            $rowcount++;
        }
    }
    $this->message("操作成功！共删除{$rowcount}条数据,{$notrowcount}条数据不能删除!", '', 0);
} elseif ($operation == 'upall') {
    $rowcount = 0;
    $notrowcount = 0;
    foreach ($_GPC['idArr'] as $k => $id) {
        $id = intval($id);
        if (!empty($id)) {
            $goods = pdo_fetch("SELECT * FROM " . tablename($this->table_goods) . " WHERE id = :id", array(':id' => $id));
            if (empty($goods)) {
                $notrowcount++;
                continue;
            }
            pdo_update($this->table_goods, array('status' => 1), array('id' => $id, 'weid' => $weid));
            $rowcount++;
        }
    }
    $this->message("操作成功！共操作{$rowcount}条数据,{$notrowcount}条数据操作失败!", '', 0);
}  elseif ($operation == 'downall') {
    $rowcount = 0;
    $notrowcount = 0;
    foreach ($_GPC['idArr'] as $k => $id) {
        $id = intval($id);
        if (!empty($id)) {
            $goods = pdo_fetch("SELECT * FROM " . tablename($this->table_goods) . " WHERE id = :id", array(':id' => $id));
            if (empty($goods)) {
                $notrowcount++;
                continue;
            }
            pdo_update($this->table_goods, array('status' => 0), array('id' => $id, 'weid' => $weid));
            $rowcount++;
        }
    }
    $this->message("操作成功！共操作{$rowcount}条数据,{$notrowcount}条数据操作失败!", '', 0);
} elseif ($operation == 'opengoods') {
    pdo_update($this->table_goods, array('status' => 1), array('weid' => $weid, 'storeid' => $storeid));
    message('商品上架成功！', $this->createWebUrl('goods', array('op' => 'display', 'storeid' => $storeid)), 'success');
} elseif ($operation == 'closegoods') {
    pdo_update($this->table_goods, array('status' => 0), array('weid' => $weid, 'storeid' => $storeid));
    message('商品下架成功！', $this->createWebUrl('goods', array('op' => 'display', 'storeid' => $storeid)), 'success');
} elseif ($operation == 'deletetrue') {
    if ($_W['role'] == 'manager' || $_W['isfounder']) {
        $id = intval($_GPC['id']);
        $row = pdo_fetch("SELECT id FROM " . tablename($this->table_goods) . " WHERE id = :id", array(':id' => $id));
        if (empty($row)) {
            message('抱歉，商品 不存在或是已经被删除！');
        }
        pdo_delete($this->table_goods, array('deleted' => 1), array('id' => $id, 'weid' => $weid));
        message('删除成功！', referer(), 'success');
    } else {
        message('您没有删除权限！', $this->createWebUrl('goods', array('op' => 'display', 'storeid' => $storeid)), 'success');
    }
}
include $this->template('web/goods');