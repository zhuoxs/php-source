<?php
/**
 * 深蓝网络 Copyright (c) www.zhshenlan.com
 */

defined('IN_IA') or exit('Access Denied');

global $_GPC, $_W;
load()->func('tpl');
$operation = ($_GPC['op']) ? $_GPC['op'] : 'display';

if ($operation == 'display') {
    $condition = ' AND uniacid=:uniacid ';
    $params = array(':uniacid' => $_W['uniacid']);
    $pindex = max(1, intval($_GPC['page']));
    $psize = 10;
    $sql = "SELECT * FROM " . tablename('slwl_aicard_store_brand'). ' WHERE 1 ' . $condition . " ORDER BY displayorder DESC, id DESC LIMIT " . ($pindex - 1) * $psize .',' .$psize;

    $list = pdo_fetchall($sql, $params);
    $total = pdo_fetchcolumn('SELECT COUNT(*) FROM ' . tablename('slwl_aicard_store_brand') . ' WHERE 1 ' . $condition, $params);
    $pager = pagination($total, $pindex, $psize);

} elseif ($operation == 'post') {
    $id = intval($_GPC['id']);

    if ($_W['ispost']) {
        $data = array(
            'uniacid' => $_W['uniacid'],
            'displayorder' => $_GPC['displayorder'],
            'title' => $_GPC['title'],
            'enabled' => intval($_GPC['enabled']),
            'thumb' => $_GPC['thumb'],
            'thumb_brand' => $_GPC['thumb_brand'],
            'intro' => $_GPC['intro'],
        );
        if ($id) {
            pdo_update('slwl_aicard_store_brand', $data, array('id' => $id));
        } else {
            $data['addtime'] = $_W['slwl']['datetime']['now'];
            pdo_insert('slwl_aicard_store_brand', $data);
            $id = pdo_insertid();
        }
        iajax(0, '保存成功！');
    }
    $condition = " AND uniacid=:uniacid AND id=:id ";
    $params = array(':uniacid' => $_W['uniacid'], ':id' => $id);
    $one = pdo_fetch('SELECT * FROM ' . tablename('slwl_aicard_store_brand') . ' WHERE 1 ' . $condition, $params);


} elseif ($operation == 'delete') {
    $id = intval($_GPC['id']);

    $rst = pdo_delete('slwl_aicard_store_brand', array('id' => $id));
    if ($rst !== false) {
        iajax(0, '成功');
    } else {
        iajax(1, '不存在或已删除');
    }


} elseif ($operation == 'money_show') {
    $brandid = intval($_GPC['brandid']);
    $condition = ' AND uniacid=:uniacid AND brandid=:brandid ';
    $params = array(':uniacid' => $_W['uniacid'], ':brandid' => $brandid);
    $total = pdo_fetchcolumn('SELECT COUNT(*) FROM ' . tablename('slwl_aicard_store_order_goods') . ' WHERE 1 ' . $condition, $params);

    $res = array(
        'total' => $total,
    );

    if (empty($total)) {
        $res = array(
            'total' => '0',
        );
    }
    iajax(0, $res);


} elseif ($operation == 'goods') {
    $brandid = intval($_GPC['brandid']);

    $condition = " AND uniacid=:uniacid AND deleted='0' AND brandid=:brandid ";
    $params = array(':uniacid' => $_W['uniacid'], ':brandid'=>$brandid);
    $pindex = max(1, intval($_GPC['page']));
    $psize = 10;
    $sql = "SELECT * FROM " . tablename('slwl_aicard_store_goods'). ' WHERE 1 '
        . $condition . " ORDER BY displayorder DESC, id DESC LIMIT " . ($pindex - 1) * $psize .',' .$psize;

    $list = pdo_fetchall($sql, $params);
    $total = pdo_fetchcolumn('SELECT COUNT(*) FROM ' . tablename('slwl_aicard_store_goods') . ' WHERE 1 ' . $condition, $params);
    $pager = pagination($total, $pindex, $psize);


} elseif ($operation == 'goods_post') {
    $id = intval($_GPC['id']);
    $brandid = intval($_GPC['brandid']);

    $sql = 'SELECT * FROM ' . tablename('slwl_aicard_store_category') . ' WHERE `uniacid` = :uniacid ORDER BY `parentid`, `displayorder` DESC';
    $category = pdo_fetchall($sql, array(':uniacid' => $_W['uniacid']), 'id');

    if ($category) {
        $parent = $children = array();
        foreach ($category as $key => $value) {
            if ($value['parentid'] == '0') {
                $parent[] = $value;
            } else {
                $children[] = $value;
            }
        }
    }

    if ($_W['ispost']) {

        $data = array(
            'uniacid' => intval($_W['uniacid']),
            'brandid' => $brandid,
            'displayorder' => intval($_GPC['displayorder']),
            'title' => $_GPC['goodsname'],
            'intro' => $_GPC['intro'],
            'pcate' => intval($_GPC['category']['parentid']),
            'ccate' => intval($_GPC['category']['childid']),
            'thumb'=> $_GPC['pic'],
            'type' => intval($_GPC['type']),
            'isrecommand' => intval($_GPC['isrecommand']),
            'ishot' => intval($_GPC['ishot']),
            'isnew' => intval($_GPC['isnew']),
            'isdiscount' => intval($_GPC['isdiscount']),
            'istime' => intval($_GPC['istime']),
            'timestart' => strtotime($_GPC['timestart']),
            'timeend' => strtotime($_GPC['timeend']),
            'description' => $_GPC['description'],
            'content' => htmlspecialchars_decode($_GPC['content']),
            'goodssn' => $_GPC['goodssn'],
            'unit' => $_GPC['unit'],
            'createtime' => time(),
            'total' => intval($_GPC['total']),
            'totalcnf' => intval($_GPC['totalcnf']),
            'price' => $_GPC['price'],
            'weight' => $_GPC['weight'],
            'costprice' => $_GPC['costprice'],
            'originalprice' => $_GPC['originalprice'],
            'original_price' => $_GPC['original_price'],
            'productsn' => $_GPC['productsn'],
            'credit' => sprintf('%.2f', $_GPC['credit']),
            'maxbuy' => intval($_GPC['maxbuy']),
            'usermaxbuy' => intval($_GPC['usermaxbuy']),
            'hasoption' => intval($_GPC['hasoption']),
            'sales' => intval($_GPC['sales']),
            'status' => intval($_GPC['status']),
            'isfreeshopping' => intval($_GPC['isfreeshopping']),
        );

        $thumbs = array();
        if ($_GPC['thumbs']) {
            foreach ($_GPC['thumbs'] as $k => $v) {
                $thumbs[] = $v;
            }
            $data['thumb_url'] = json_encode($thumbs);
        }

        // 处理，自定义参数
        if ($_GPC['param_tv']) {
            $options = $_GPC['param_tv'];

            foreach ($options['title'] as $k => $v) {
                $tmp_param[$k]['title'] = $v;
            }

            foreach ($options['value'] as $k => $v) {
                $tmp_param[$k]['value'] = $v;
            }

            foreach ($tmp_param as $k=>$v){
                $param_items[] = $v;
            }

            $data['param'] = json_encode($param_items); // 压缩
        }

        if ($id) {
            pdo_update('slwl_aicard_store_goods', $data, array('id' => $id));
        } else {
            $data['addtime'] = $_W['slwl']['datetime']['now'];
            pdo_insert('slwl_aicard_store_goods', $data);
            $id_good = pdo_insertid();
        }

        // 处理规格
        $data_spec = array();
        $data_spec['uniacid'] = intval($_W['uniacid']);
        $data_spec['goodsid'] = $id;
        $data_spec['content'] = '';

        if ($_GPC['spec']) {
            $spec = $_GPC['spec'];

            foreach ($spec['spec'] as $k => $v) {
                $tm = $v;

                $v_items = array();
                foreach ($tm['items'] as $key => $value) {
                    $v_items[] = $value;
                }
                $tm['items'] = $v_items;

                $spec_items[] = $tm;
            }

            $data_spec['content'] = json_encode($spec_items); // 压缩
        }

        $check_condition_spec = ' AND uniacid=:uniacid AND goodsid=:goodsid';
        $check_params_spec = array(':uniacid' => $_W['uniacid'], ':goodsid'=>$id);
        $check_one_spec = pdo_fetch("SELECT * FROM " . tablename('slwl_aicard_store_spec') . ' WHERE 1 '
            . $check_condition_spec, $check_params_spec);

        if ($check_one_spec) {
            pdo_update('slwl_aicard_store_spec', $data_spec, array('goodsid' => $id));
        } else {
            $data_spec['addtime'] = $_W['slwl']['datetime']['now'];
            pdo_insert('slwl_aicard_store_spec', $data_spec);
            $id_spec = pdo_insertid();
        }

        // 处理，规格项目表
        if ($_GPC['specop']) {
            $specop = $_GPC['specop'];

            foreach ($specop['option_title'] as $k => $v) {
                $tmp_specop[$k]['option_title'] = $v;
            }

            foreach ($specop['option_stock'] as $k => $v) {
                $tmp_specop[$k]['option_stock'] = $v;
            }

            foreach ($specop['option_price'] as $k => $v) {
                $tmp_specop[$k]['option_price'] = $v;
            }

            foreach ($specop['option_original_price'] as $k => $v) {
                $tmp_specop[$k]['option_original_price'] = $v;
            }

            foreach ($specop['option_costprice'] as $k => $v) {
                $tmp_specop[$k]['option_costprice'] = $v;
            }

            foreach ($specop['option_weight'] as $k => $v) {
                $tmp_specop[$k]['option_weight'] = $v;
            }

            $data_option = array();
            foreach ($tmp_specop as $k=>$v){
                // $specop_items[] = $v;

                $data_option[] = array(
                    'goodsid' => $id,
                    'title' => $v['option_title'],
                    'original_price' => $v['option_original_price'],
                    'price' => $v['option_price'],
                    'costprice' => $v['option_costprice'],
                    'stock' => $v['option_stock'],
                    'weight' => $v['option_weight'],
                );
            }

            pdo_query("DELETE FROM " . tablename('slwl_aicard_store_goods_option') . " WHERE goodsid=$id");

            foreach ($data_option as $k => $v) {
                pdo_insert('slwl_aicard_store_goods_option', $v);
            }

        }
        iajax(0, '保存成功！');
    }

    $condition = " AND uniacid=:uniacid AND id=:id ";
    $params = array(':uniacid' => $_W['uniacid'], ':id' => $id);
    $one = pdo_fetch('SELECT * FROM ' . tablename('slwl_aicard_store_goods') . ' WHERE 1 ' . $condition, $params);
    $piclist = array();
    if ($one) {
        $pl = json_decode($one['thumb_url'], true);
        if ($pl) {
            foreach ($pl as $k => $v) {
                $piclist[] = $v;
            }
        }
    }

    // 处理，自定义参数
    if ($one['param']) {
        $one_param = json_decode($one['param'], true);
    }

    // 处理，多规格
    $one_spec = pdo_fetch("SELECT * FROM " . tablename('slwl_aicard_store_spec') . " WHERE goodsid=:goodsid and uniacid=:uniacid", array(":goodsid" => $id, ":uniacid" => $_W['uniacid']));
    if ($one_spec['content']) {
        $spec_items = json_decode($one_spec['content'], true);
    }

    // 处理，规格项目表
    $one_option = pdo_fetchall("SELECT * FROM " . tablename('slwl_aicard_store_goods_option') . " WHERE goodsid=:goodsid ORDER BY id ASC ", array(":goodsid" => $id));

    $html = '';
    if ($one_option && $spec_items) {
        $html .= '<table class="layui-table">';
        $html .= '<thead>';
        $html .= '<tr>';
        $len = count($spec_items);
        $newlen = 1; //多少种组合
        $h = array(); //显示表格二维数组
        $rowspans = array(); //每个列的rowspan

        for ($i = 0; $i < $len; $i++) {
            //表头
            $html .= "<th style='width:80px;'>" . $spec_items[$i]['title'] . "</th>";
            //计算多种组合
            $itemlen = count($spec_items[$i]['items']);
            if ($itemlen <= 0) {
                $itemlen = 1;
            }
            $newlen *= $itemlen;
            //初始化 二维数组
            $h = array();
            for ($j = 0; $j < $newlen; $j++) {
                $h[$i][$j] = array();
            }
            //计算rowspan
            $l = count($spec_items[$i]['items']);
            $rowspans[$i] = 1;
            for ($j = $i + 1; $j < $len; $j++) {
                $rowspans[$i]*= count($spec_items[$j]['items']);
            }
        }
        $html .= '<th class="info"><div><div class="top-title">库存</div><div class="input-group form-group"><input type="text" class="form-control option_stock_all" value=""/><span class="input-group-btn"><a href="javascript:;" class="btn btn-double-down" title="批量设置" onclick="setCol(\'option_stock\');"><i class="icon iconfont icon-down"></i></a></span></div></div></th>';
        $html .= '<th class="success"><div><div class="top-title">销售价格</div><div class="input-group form-group"><input type="text" class="form-control option_price_all" value=""/><span class="input-group-btn"><a href="javascript:;" class="btn btn-double-down" title="批量设置" onclick="setCol(\'option_price\');"><i class="icon iconfont icon-down"></i></a></span></div></div></th>';
        $html .= '<th class="warning"><div><div class="top-title">市场价格</div><div class="input-group form-group"><input type="text" class="form-control option_original_price_all" value=""/><span class="input-group-btn"><a href="javascript:;" class="btn btn-double-down" title="批量设置" onclick="setCol(\'option_original_price\');"><i class="icon iconfont icon-down"></i></a></span></div></div></th>';
        $html .= '<th class="danger"><div><div class="top-title">成本价格</div><div class="input-group form-group"><input type="text" class="form-control option_costprice_all" value=""/><span class="input-group-btn"><a href="javascript:;" class="btn btn-double-down" title="批量设置" onclick="setCol(\'option_costprice\');"><i class="icon iconfont icon-down"></i></a></span></div></div></th>';
        $html .= '<th class="info"><div><div class="top-title">重量（克）</div><div class="input-group form-group"><input type="text" class="form-control option_weight_all" value=""/><span class="input-group-btn"><a href="javascript:;" class="btn btn-double-down" title="批量设置" onclick="setCol(\'option_weight\');"><i class="icon iconfont icon-down"></i></a></span></div></div></th>';
        $html .= '</tr></thead>';
        for ($m = 0; $m < $len; $m++) {
            $k = 0;
            $kid = 0;
            $n = 0;
            for ($j = 0; $j < $newlen; $j++) {
                $rowspan = $rowspans[$m];
                if ($j % $rowspan == 0) {
                    $h[$m][$j] = array("html" => "<td rowspan='" . $rowspan . "'>" . $spec_items[$m]['items'][$kid]['gditemname'] . "</td>", "id" => $spec_items[$m]['items'][$kid]['id']);
                } else {
                    $h[$m][$j] = array("html" => "", "id" => $spec_items[$m]['items'][$kid]['id']);
                }
                $n++;
                if ($n == $rowspan) {
                    $kid++;
                    if ($kid > count($spec_items[$m]['items']) - 1) {
                        $kid = 0;
                    }
                    $n = 0;
                }
            }
        }
        $hh = "";
        for ($i = 0; $i < $newlen; $i++) {
            $hh.="<tr>";
            $ids = array();
            for ($j = 0; $j < $len; $j++) {
                $hh.=$h[$j][$i]['html'];
                $ids[] = $h[$j][$i]['id'];
            }

            $hh .= '<td class="info">';
            $hh .= '<input name="specop[option_stock][' . $i . ']" type="text" class="form-control option_stock option_stock_' . $i . '" value="' . $one_option[$i]['stock'] . '"/></td>';
            $hh .= '<input name="specop[option_title][' . $i . ']" type="hidden" class="form-control option_title option_title_' . $i . '" value="' . $one_option[$i]['title'] . '"/>';
            $hh .= '</td>';
            $hh .= '<td class="success"><input name="specop[option_price][' . $i . ']" type="text" class="form-control option_price option_price_' . $i . '" value="' . $one_option[$i]['price'] . '"/></td>';
            $hh .= '<td class="warning"><input name="specop[option_original_price][' . $i . ']" type="text" class="form-control option_original_price option_original_price_' . $i . '" " value="' . $one_option[$i]['original_price'] . '"/></td>';
            $hh .= '<td class="danger"><input name="specop[option_costprice][' . $i . ']" type="text" class="form-control option_costprice option_costprice_' . $i . '" " value="' . $one_option[$i]['costprice'] . '"/></td>';
            $hh .= '<td class="info"><input name="specop[option_weight][' . $i . ']" type="text" class="form-control option_weight option_weight_' . $i . '" " value="' . $one_option[$i]['weight'] . '"/></td>';
            $hh .= '</tr>';
        }
        $html .= $hh;
        $html .= "</table>";
    }
    // dump($spec_items);


} elseif ($operation == 'goods_property') {
    global $_GPC, $_W;
    $id = intval($_GPC['id']);
    $type = $_GPC['type'];
    $data = intval($_GPC['data']);

    if (in_array($type, array('new', 'hot', 'recommand', 'discount'))) {
        $data = ($data==1?'0':'1');
        pdo_update("slwl_aicard_store_goods", array("is" . $type => $data), array("id" => $id, "uniacid" => $_W['uniacid']));
        die(json_encode(array("result" => 0, "data" => $data)));
    }
    if (in_array($type, array('status'))) {
        $data = ($data==1?'0':'1');
        pdo_update("slwl_aicard_store_goods", array($type => $data), array("id" => $id, "uniacid" => $_W['uniacid']));
        die(json_encode(array("result" => 0, "data" => $data)));
    }
    if (in_array($type, array('type'))) {
        $data = ($data==1?'2':'1');
        pdo_update("slwl_aicard_store_goods", array($type => $data), array("id" => $id, "uniacid" => $_W['uniacid']));
        die(json_encode(array("result" => 0, "data" => $data)));
    }
    die(json_encode(array("result" => 2)));

} elseif ($operation == 'goods_delete') {
    $id = intval($_GPC['id']);
    $one = pdo_fetch("SELECT id  FROM " . tablename('slwl_aicard_store_goods') . " WHERE id = '{$id}' AND uniacid=" . $_W['uniacid'] . "");

    if (empty($one)) {
        iajax(1, '抱歉，不存在或是已经被删除！');
        exit;
    }
    pdo_delete('slwl_aicard_store_goods', array('id' => $id));
    pdo_delete('slwl_aicard_store_goods_option', array('goodsid' => $id));

    iajax(0, '删除成功！');
    exit;

} else {
    message('请求方式不存在');
}

include $this->template('web/store-brand');

?>