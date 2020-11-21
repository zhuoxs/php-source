<?php
global $_W, $_GPC;
$weid = $this->_weid;
load()->func('tpl');
$GLOBALS['frames'] = $this->getMainMenu();
$action = 'goodssalemx';
$title = $this->actions_titles[$action];
$storeid = intval($_GPC['storeid']);
$returnid = $this->checkPermission($storeid);
$operation = !empty($_GPC['op']) ? $_GPC['op'] : 'display';
if ($operation == 'display') {

    $commoncondition = " a.weid = '{$_W['uniacid']}' ";
    if ($storeid != 0) {
        $commoncondition .= " AND c.storeid={$storeid} ";
    }

    $commonconditioncount = " a.weid = '{$_W['uniacid']}' ";
    if ($storeid != 0) {
        $commonconditioncount .= " AND c.storeid={$storeid} ";
    }

    if (!empty($_GPC['time'])) {
        $starttime = strtotime($_GPC['time']['start']);
        $endtime = strtotime($_GPC['time']['end']) + 86399;
        $commoncondition .= " AND c.dateline >= ".$starttime." AND c.dateline <= ".$endtime." ";
        //$paras[':starttime'] = $starttime;
        //$paras[':endtime'] = $endtime;
    }

    if (empty($starttime) || empty($endtime)) {
        $starttime = strtotime('-1 month');
        $endtime = time();
    }

    $pindex = max(1, intval($_GPC['page']));
    $psize = 10;

    if (!empty($_GPC['ordersn'])) {
        $commoncondition .= " AND ordersn LIKE '%{$_GPC['ordersn']}%' ";
    }
    if (!empty($_GPC['dining_mode'])) {
        $commoncondition .= " AND dining_mode = '" . intval($_GPC['dining_mode']) . "' ";
    }
    $tablesid = $_GPC['tableid'];
    $table = pdo_fetch("SELECT * FROM " . tablename($this->table_tables) . " where weid = :weid AND title=:title LIMIT 1", array(':weid' => $weid, ':title' => $tablesid));
    if (!empty($table)) {
        $commoncondition .= " AND tables = '" . $table['id'] . "' ";
    }

    if (isset($_GPC['status']) && $_GPC['status'] != '') {
        $commoncondition .= " AND c.status = '" . intval($_GPC['status']) . "'";
    }

    if (isset($_GPC['paytype']) && $_GPC['paytype'] != '') {
        $commoncondition .= " AND c.paytype = '" . intval($_GPC['paytype']) . "'";
    }

     if (isset($_GPC['selgoodsid']) && $_GPC['selgoodsid'] != '') {
        $selgoodsid = $_GPC['selgoodsid'];
        $commoncondition .= " AND a.goodsid = '" . intval($selgoodsid) . "'";
    }

    if ($_GPC['out_put'] == 'output') {
       // $sql = "select * from " . tablename($this->table_order)
         $list = pdo_fetchall("SELECT c.ordersn,b.title,a.price,a.total,c.dining_mode,c.status,c.paytype,c.ispay,c.dateline,d.title tabletitle,c
.from_user FROM " . tablename($this->table_order_goods) . " as a left join " . tablename($this->table_goods) . " as b on a
.goodsid=b.id , ". tablename($this->table_order)." c left join ".tablename($this->table_tables)." d on c.tables = d.id WHERE $commoncondition and a.orderid=c.id AND c.ispay=1 AND c.ismerge = 0 order by orderid desc ",$paras);
        $orderstatus = array(
            '-1' => array('css' => 'default', 'name' => '已取消'),
            '0' => array('css' => 'danger', 'name' => '待处理'),
            '1' => array('css' => 'info', 'name' => '已确认'),
            '2' => array('css' => 'warning', 'name' => '已付款'),
            '3' => array('css' => 'success', 'name' => '已完成')
        );
		//zzh20160709
        /**$paytypes = array(
            '0' => array('css' => 'danger', 'name' => '未支付'),
            '1' => array('css' => 'info', 'name' => '余额支付'),
            '2' => array('css' => 'warning', 'name' => '在线支付'),
            '3' => array('css' => 'success', 'name' => '现金支付')
        );**/
		$paytypes = array(
            '0' => array('css' => 'danger', 'name' => '未支付'),
            '1' => array('css' => 'info', 'name' => '余额支付'),
            '2' => array('css' => 'warning', 'name' => '微信支付'),
            '3' => array('css' => 'success', 'name' => '现金支付'),
            '4' => array('css' => 'warning', 'name' => '支付宝')
        );

        $i = 0;
        foreach ($list as $key => $value) {
            $arr[$i]['ordersn'] = $value['ordersn'];            
            $arr[$i]['paytype'] = $paytypes[$value['paytype']]['name'];
            $arr[$i]['status'] = $orderstatus[$value['status']]['name'];			
                $arr[$i]['price'] = $value['price']*$value['total'];
            $arr[$i]['sl'] = $value['total'];
            $arr[$i]['goodsname'] = $value['title']; 
            $arr[$i]['tabletitle'] = $value['tabletitle'];                
            $arr[$i]['username'] = $value['username'];
            $arr[$i]['tel'] = $value['tel'];
            $arr[$i]['address'] = $value['address'];
			
            $arr[$i]['dateline'] = date('Y-m-d H:i:s', $value['dateline']);
            $i++;
        }

        $this->exportexcel($arr, array('订单号',  '支付方式', '状态', '金额','数量','商品','桌号', '真实姓名', '电话号码', '地址', '时间'), time());
        exit();
    }

    $list = pdo_fetchall("SELECT c.ordersn,b.title,a.price,a.total,c.dining_mode,c.status,c.paytype,c.ispay,c.dateline,d.title tabletitle FROM " . tablename($this->table_order_goods) . " as a left join " . tablename($this->table_goods) . " as b on a.goodsid=b.id , ". tablename($this->table_order)." c left join ".tablename($this->table_tables)." d on c.tables = d.id WHERE $commoncondition and a.orderid=c.id AND c.ispay=1 AND c.ismerge = 0 order by orderid desc LIMIT ".($pindex - 1) * $psize . ',' . $psize,$paras);

    $sql = "SELECT COUNT(a.id)  FROM " . tablename($this->table_order_goods) . " as a  , ". tablename($this->table_order)." c left join ".tablename($this->table_tables)." d on c.tables = d.id WHERE $commoncondition and a.orderid=c.id AND c.ispay=1 AND c.ismerge = 0 ";

    $total = pdo_fetchcolumn($sql);
    $pager = pagination($total, $pindex, $psize);

    if (!empty($list)) {
        foreach ($list as $row) {
            $userids[$row['from_user']] = $row['from_user'];
        }
    }

    //打印数量
    $print_order_count = pdo_fetchall("SELECT orderid,COUNT(1) as count FROM " . tablename($this->table_print_order) . "  GROUP BY orderid,weid having weid = :weid", array(':weid' => $_W['uniacid']), 'orderid');

    //门店列表
    $storelist = pdo_fetchall("SELECT * FROM " . tablename($this->table_stores) . " WHERE weid = :weid", array(':weid' => $_W['uniacid']), 'id');

    $goodslist = pdo_fetchall("SELECT * FROM " . tablename($this->table_goods) . " WHERE weid = :weid", array(':weid' => $_W['uniacid']), 'id');

}
include $this->template('web/goodssalemx');