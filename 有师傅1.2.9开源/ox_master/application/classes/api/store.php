<?php
if (!(defined('IN_IA'))) {
    exit('Access Denied');
}

class Api_Store extends WeModuleWxapp
{
    /**
     * 创建店铺
     */
    public function create()
    {
        global $_GPC, $_W;
        $params = [
            "formid" => $_GPC['formid'],
            "address" => $_GPC['address'],
            "uid" => $_GPC['uid'],
            "address_detail" => $_GPC['address_detail'],
            "name" => $_GPC['name'],
            "age" => $_GPC['age'],
            "sex" => $_GPC['sex'],
            "detail" => $_GPC['detail'],
            "mapy" => $_GPC['mapy'],
            "mapx" => $_GPC['mapx'],
            "phone" => $_GPC['phone'],
            "type_name" => $_GPC['type_name'],
            "type_id" => $_GPC['type_id'],
            "uniacid" => $_W['uniacid'],
            "status" => 0,
            "province" => $_GPC['province'],
            "city" => $_GPC['city'],
            "district" => $_GPC['district'],
            "isoff"=>1,
        ];
        if ($_GPC['id'] && $_GPC['id'] != 'undefined') {

            pdo_update('ox_master_store', $params, ['id' => $_GPC['id']]);
            if ($_GPC['imgs']) {
                pdo_delete('ox_master_image', ['store_id' => $_GPC['id'],'uniacid' => $_W['uniacid']]);
                $imgs = json_decode(htmlspecialchars_decode($_GPC['imgs']), 1);
                $data = [
                    'store_id' => $_GPC['id'],
                    'uniacid' => $_W['uniacid'],
                    'type' => 2,
                    'create_time' => $_SERVER['REQUEST_TIME']
                ];
                foreach ($imgs as $k => $v) {
                    $data['img_patch'] = $v['short'];
                    pdo_insert('ox_master_image', $data);
                }
            }
        } else {
            $params['create_time'] = $_SERVER['REQUEST_TIME'];
            pdo_insert('ox_master_store', $params);
            $store_id = pdo_insertid();
            if ($_GPC['imgs']) {
                $imgs = json_decode(htmlspecialchars_decode($_GPC['imgs']), 1);
                $data = [
                    'store_id' => $store_id,
                    'uniacid' => $_W['uniacid'],
                    'type' => 2,
                    'create_time' => $_SERVER['REQUEST_TIME']
                ];
                foreach ($imgs as $k => $v) {
                    $data['img_patch'] = $v['short'];
                    pdo_insert('ox_master_image', $data);
                }
            }
        }
        return $this->result(0, '', '');
    }

    /**
     * 师傅详情
     */
    public function storeDetail()
    {
        global $_GPC, $_W;
        $params = [
            "uniacid" => $_W['uniacid'],
        ];
        $detail = pdo_get('ox_master_store', ["uniacid" => $_W['uniacid'], 'id' => $_GPC['order_id'], 'uid' => $_GPC['uid']]);
        $imgs = pdo_getall('ox_master_image', ['store_id' => $_GPC['store_id']], ['id', 'img_patch']);
        $detail['create_time'] = date('Y-m-d H:i', $detail['create_time']);
        foreach ($imgs as $k => $v) {
            $imgs[$k]['img_patch'] = tomedia($v['img_patch']);
        }

        $result = [
            'detail' => $detail,
            'imgs' => $imgs
        ];
        return $this->result(0, '', $result);
    }
    /**
     * 师傅详情
     */
    public function storeDetail2()
    {
        global $_GPC, $_W;
        $params = [
            "uniacid" => $_W['uniacid'],
        ];
        $detail = pdo_get('ox_master_store', ["uniacid" => $_W['uniacid'], 'uid' => $_GPC['master_uid']]);
        $imgs = pdo_getall('ox_master_image', ['store_id' => $detail['id']], ['id', 'img_patch']);
        $orderTotal = pdo_getcolumn('ox_master_order', array('repair_uid' => $_GPC['master_uid'],'status'=> 3), 'count(*)');
        $appraiseTotal = pdo_getcolumn('ox_master_appraise', array('reapir_uid' => $_GPC['master_uid'],'level'=> ['4','3','5']), 'count(*)');
        $appraiseList = pdo_fetchall("SELECT oma.*,mmf.`nickname` FROM  ".tablename("ox_master_appraise")." oma LEFT JOIN ".tablename("mc_mapping_fans")." mmf ON oma.uid=mmf.uid
WHERE oma.`reapir_uid` = ".$_GPC['master_uid']);
        foreach ($appraiseList as $k => $v) {
            $appraiseList[$k]['create_time'] = date('Y年m月d日', $v['create_time']);;
        }
        $detail['create_time'] = date('Y年m月d日', $detail['create_time']);
        foreach ($imgs as $k => $v) {
            $imgs[$k]['img_patch'] = tomedia($v['img_patch']);
        }
        $detail['orderTotal'] = $orderTotal ?: 0;
        $detail['appraiseTotal'] = $appraiseTotal ?: 0;
        $result = [
            'detail' => $detail,
            'imgs' => $imgs,
            'appraiseList' => $appraiseList
        ];
        return $this->result(0, '', $result);
    }

    /**
     * 订单列表
     */
    public function orderList2()
    {
        global $_GPC, $_W;
        $params = [
            "uniacid" => $_W['uniacid'],
        ];

        if ($_GPC['status'] && $_GPC['status'] == 1 ) {
            $params['status'] = array(1,4);
            $params['repair_uid'] = $_GPC['uid'];
        }elseif($_GPC['status'] == 3){
            $params['status'] = array(3,5);
            $params['repair_uid'] = $_GPC['uid'];
        }else{
            $where = " b.reapir_uid = {$_GPC['uid']} and o.pay_status = 0 and o.status = 0 and o.bid_num >0 ";
        }

        $pageSize = 4;
        $pageCur = $_GPC['page'] ?: 1;

        if( $_GPC['status'] == 3 || $_GPC['status'] == 1){
            $list = pdo_getall('ox_master_order', $params, '', '', ['id desc'], [$pageCur, $pageSize]);
        }else{
            $join = " left join " . tablename('ox_master_bidding') . " as b on b.order_id = o.id ";
            $sql = "select o.* from " . tablename('ox_master_order') . " as o $join where $where order by o.id desc LIMIT " . ($pageCur - 1) * $pageSize . ",{$pageSize}";
            $list = pdo_fetchall($sql);

        }

        foreach ($list as $k => $v) {
            $list[$k]['create_time'] = date('Y-m-d H:i', $v['create_time']);
            //判断是有参与竞标的师傅
            if($_GPC['status'] == 2){
                $id = pdo_getcolumn("ox_master_bidding",['uniacid' => $_W['uniacid'],'reapir_uid' => $_GPC['uid'],'status' => 1, 'order_id' => $v['id']],'id');
                if($id){
                    $list[$k]['bidding_status'] = '1';
                }
            }
        }

        return $this->result(0, '', $list);
    }

    /**
     * 店铺订单列表
     */
    public function orderList()
    {
        global $_GPC, $_W;
        $params = [
            "uniacid" => $_W['uniacid'],
            "repair_uid" => $_GPC['uid'],
        ];
        $master = pdo_get('ox_master', ["uniacid" => $_W['uniacid']]);
        $detail = pdo_get('ox_master_store', ["uniacid" => $_W['uniacid'], 'uid' => $_GPC['uid']]);
        $type_ar = explode(',',$detail['type_name']);
        $type_ar = implode("','",$type_ar);
        $auto = 1;
        $pageSize = 4;
        $pageCur = ($_GPC['page']-1) * $pageSize;
        $distance = $master['distance'] * 1000;
        $qurey = "";
        if($master['notify_rule'] == 1){
            $qurey = " and type_name in ('{$type_ar}') ";
        }elseif ($master['notify_rule'] == 2){
            $qurey = " having juli <={$distance} ";
        }elseif($master['notify_rule'] == 3){
            $qurey = " and type_name in ('{$type_ar}') having juli <={$distance} ";
        }
       $sql =  "SELECT * , ROUND(6378.138 * 2 * ASIN(SQRT(POW(SIN(({$detail['mapx']} * PI() / 180- mapx * PI() / 180) / 2), 2) 
                    + COS({$detail['mapx']}* PI() / 180) * COS(mapx * PI() / 180) * POW(SIN(({$detail['mapy']} * PI() / 180- mapy * PI() / 180) / 2), 2))) * 10) AS juli 
                    FROM ".tablename('ox_master_order')."
                    WHERE uniacid= {$_W['uniacid']} AND city='{$detail['city']}' AND STATUS =0 AND pay_status=0 {$qurey} order by id desc limit {$pageCur},{$pageSize}";
        $list = pdo_fetchall($sql);
        $full_sum = pdo_getcolumn('ox_master', array(), 'full_num');
        foreach ($list as $k => $v) {
            $list[$k]['create_time'] = date('Y-m-d H:i', $v['create_time']);
            //判断是否是否参与竞标
            $price = pdo_getcolumn("ox_master_bidding", ['uniacid' => $_W['uniacid'], 'reapir_uid' => $_GPC['uid'], 'order_id' => $v['id']], 'price');
            $status = pdo_getcolumn("ox_master_bidding", ['uniacid' => $_W['uniacid'], 'reapir_uid' => $_GPC['uid'], 'order_id' => $v['id']], 'status');
            $sql = "select count(id) as num from  " . tablename('ox_master_bidding') . " where uniacid = {$_W['uniacid']} and order_id = {$v['id']}";
            $num = pdo_fetch($sql);
            if ($num['num'] >= $full_sum) {
                $list[$k]['count'] = 'true';
            } else {
                $list[$k]['count'] = 'false';
            }
            $list[$k]['bidding_status'] = $status;
            $list[$k]['price'] = $price;
            if ($auto == 1 && empty($status)) {
                $list[$k]['phone'] = preg_replace("/(\d{3})\d{4}(\d{4})/", "\$1****\$2", $v['phone']);
            }
        }

        $result = [
            'list' => $list,
            'auto' => 1,
            'detail' => $detail
        ];
        return $this->result(0, '', $result);
    }

    /**
     * 自主接单
     */
    public function orderTakers()
    {
        global $_GPC, $_W;
        $params = [
            "uniacid" => $_W['uniacid'],
            "id" => $_GPC['order_id'],
            "status" => 0
        ];
        $detail = pdo_get('ox_master_order', $params);
        if (!$detail) {
            return $this->result(1, '订单已经被别人抢走啦', []);
        }
        $data = [
            'repair_uid' => $_GPC['repair_uid'],
            'status' => 1,
            'taking_time' => $_SERVER['REQUEST_TIME']
        ];
        $result = pdo_update('ox_master_order', $data, $params);
        $openid = pdo_getcolumn('mc_mapping_fans', ['uid' => $detail['uid'], "uniacid" => $_W['uniacid']], 'openid');
        $template_id = pdo_getcolumn('ox_master_message', ["uniacid" => $_W['uniacid'], 'type' => 2], 'content');
        $repair = pdo_get('ox_master_store', ["uniacid" => $_W['uniacid'], 'uid' => $_GPC['repair_uid']]);
        if ($template_id) {
            $date = date('Y-m-d H:i', $_SERVER['REQUEST_TIME']);
            $data = [
                'touser' => $openid,
                'template_id' => $template_id,
                'page' => '/pages/order/index',
                'form_id' => $detail['formid'],
                'keyword' => [$detail['o_sn'], $detail['type_name'], $date, $repair['phone'], $repair['name']]
            ];
            $results = Message::Instance()->send($data);
        }
        return $this->result(0, '', $result);
    }

    /**
     * 订单详情
     */
    public function orderDetail()
    {
        global $_GPC, $_W;
        $params = [
            "uniacid" => $_W['uniacid'],
        ];
        $detail = pdo_get('ox_master_order', ["uniacid" => $_W['uniacid'], 'id' => $_GPC['order_id']]);
        $imgs = pdo_getall('ox_master_image', ['order_id' => $_GPC['order_id']], ['id', 'img_patch']);
        $detail['create_time'] = date('Y-m-d H:i', $detail['create_time']);
        $detail['go_time'] = date('Y-m-d H:i',$detail['go_time']);
        foreach ($imgs as $k => $v) {
            $imgs[$k]['img_patch'] = tomedia($v['img_patch']);
        }
        $id = pdo_getcolumn("ox_master_bidding", ['uniacid' => $_W['uniacid'], 'reapir_uid' => $_GPC['uid'], 'order_id' => $_GPC['order_id']], 'id');

        if($detail['status'] == '0' && empty($id)){
            $detail['phone'] = preg_replace("/(\d{3})\d{4}(\d{4})/", "\$1****\$2", $detail['phone']);
        }
        $result = [
            'detail' => $detail,
            'imgs' => $imgs,
            'prevImgs' => array_column($imgs, 'img_patch')
        ];
        return $this->result(0, '', $result);
    }

    /**
     * 是否休息
     */
    public function isoff()
    {
        global $_GPC, $_W;
        $params = [
            "uniacid" => $_W['uniacid'],
            'uid' => $_GPC['uid']
        ];
        $isoff = $_GPC['isoff'] == 'true' ? 1 : 0;

        pdo_update('ox_master_store', ['isoff' => $isoff], $params);
        return $this->result(0, '', '');
    }
}