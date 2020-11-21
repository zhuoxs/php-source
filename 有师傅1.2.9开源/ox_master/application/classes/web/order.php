<?php
if (!(defined('IN_IA'))) {
    exit('Access Denied');
}

class Web_Order extends Web_Base {
    /**
     * 订单列表
     */
    public function orderList()
    {
        global $_GPC, $_W;
        $uniacid = $_W['uniacid'];
        $price = pdo_getcolumn('ox_master',["uniacid" => $_W['uniacid']],'price');
        $pageSize = $_GPC['limit'] ?: 20;
        $pageCur = $_GPC['page'] ?: 1;
        $query="";
        if($price > 0){
            $query = ' and pay_status = 1';
        }else{
            //$query = ' and pay_status = 0';
        }
        if($_GPC['o_sn']){
            $query .= " and o_sn like '%{$_GPC['o_sn']}%'  ";
        }
        if($_GPC['status'] || $_GPC['status'] === '0'){
            $query .= " and status ={$_GPC['status']} ";
        }
        if($_GPC['date']) {
            $begin = $_GPC['date'][0] / 1000;
            $end = $_GPC['date'][1] / 1000;
            $query .= " and create_time >{$begin} and create_time < {$end} ";
        }

        $list=pdo_fetchall("select * from ".tablename('ox_master_order')."  where `uniacid`= {$_W['uniacid']} {$query} order by id desc LIMIT " . ($pageCur - 1) * $pageSize . ",{$pageSize}");
        $total = pdo_fetchcolumn("select count(*) from ".tablename('ox_master_order')."  where `uniacid`= {$_W['uniacid']} {$query}  ");

        $total = intval($total);
        $full_sum = pdo_getcolumn('ox_master', array('uniacid'=>$uniacid), 'full_num');
        foreach ($list as $k => $v){
            $imgs = pdo_getall('ox_master_image',['order_id'=>$v['id']],['id','img_patch']);
            foreach ($imgs as $z => $y){
                $imgs[$z]['img_patch'] = tomedia($y['img_patch']);
            }
            $list[$k]['imgs'] = $imgs;
            //师傅名称
            if ($v['repair_uid'])
            {
                $shifu_name = pdo_fetch("select * from ".tablename('ox_master_store')." where uid={$v['repair_uid']}");
                $list[$k]['shifu_name'] = $shifu_name['name'];
                $list[$k]['shifu_phone'] = $shifu_name['phone'];
            }
            else
            {
                $list[$k]['shifu_name'] = "";
            }
            //验证当前订单人数是否已满
            $order_id = $v['id'];
            $sql = "select count(id) as num from  " . tablename('ox_master_bidding') . " where uniacid = {$uniacid} and order_id = {$order_id}";
            $num = pdo_fetch($sql);
            $list[$k]['bid_num'] = 0;
            $list[$k]['bid_num'] = $num['num'];
            $list[$k]['full_sum'] = intval($full_sum);
            if ($num['num'] >= $full_sum) {
                $list[$k]['bid_num_status'] = 1;
            }
            else{
                $list[$k]['bid_num_status'] = 0;
            }
        }
        $result = [
            'list' => $list,
            'total' => $total
        ];
        return $this->result('0','sufcc',$result);

    }
    /**
     * 分配列表
     */
    public function fenpeiList(){
        global $_GPC, $_W;
        $params = [
            "uniacid" => $_W['uniacid'],
            'status' => 0,
            'pay_status' => 1
        ];
        $list = pdo_getall('ox_master_order',$params,['id','o_sn','remark','type_name','phone','address']);
        return $this->result('0','sufcc',$list);
    }
    /**
     *  取消订单
     */
    public function cancelOrder(){
        global $_GPC, $_W;
        pdo_update('ox_master_order',['status' => 2],['id'=>$_GPC['id']]);
        return $this->result('0','取消成功','');
    }

    /**
     * 评价详情
     */
    public function appraise(){
        global $_GPC, $_W;
        $params = [
            "uniacid" => $_W['uniacid'],
            "order_id" => $_GPC['order_id']
        ];
        $detail = pdo_get('ox_master_appraise',$params);
        return $this->result('0','sufcc',$detail);
    }

    /**
     * 分配列表
     */
    public function orderChart(){
        global $_GPC, $_W;
        $sql = "select count(*) `value` , `type_name` as `name`  from ".tablename('ox_master_order')."  where `uniacid`= {$_W['uniacid']} group by type_name order by id desc";
        $list=pdo_fetchall($sql);
        return $this->result('0','sufcc',$list);
    }

    /**
     * 分配
     */
    public function fenPei(){
        global $_GPC, $_W;
        $params = [
          'id' => $_GPC['order_id'],
          'uniacid' => $_W['uniacid']
        ];
        $detail = pdo_get('ox_master_order',$params);
        if(!$detail){
            return $this->result('0','订单不存在',$detail);
        }
        $data = [
            'repair_uid' => $_GPC['repair_uid'],
            'status' => 1,
            'taking_time' => $_SERVER['REQUEST_TIME']
        ];
        $result = pdo_update('ox_master_order',$data,$params);
        $openid = pdo_getcolumn('mc_mapping_fans',['uid' => $detail['uid'],"uniacid" => $_W['uniacid']],'openid');
        $template_id = pdo_getcolumn('ox_master_message',["uniacid" => $_W['uniacid'],'type' => 2],'content');
        $repair = pdo_get('ox_master_store',["uniacid" => $_W['uniacid'],'uid' => $_GPC['repair_uid']]);
        if($template_id){
            $date = date('Y-m-d H:i',$_SERVER['REQUEST_TIME']);
            $data = [
                'touser' => $openid,
                'template_id' => $template_id,
                'page' => '/pages/order/index',
                'form_id' => $detail['formid'],
                'keyword' => [$detail['o_sn'],$detail['type_name'],$date,$repair['phone'],$repair['name']]
            ];
            $result = Message::Instance()->send($data);
        }
        return $this->result('0','sufcc',$result);
    }
    /*
     * 提醒师傅
     */
    public function sendmessage(){
        global $_GPC, $_W;
        $order_id = $_GPC['order_id'];
        $uid = $_GPC['uid'];
        $uniacid = $_W['uniacid'];

        //验证当前订单人数是否已满
        $full_sum = pdo_getcolumn('ox_master', array('uniacid'=>$uniacid), 'full_num');
        $sql = "select count(id) as num from  " . tablename('ox_master_bidding') . " where uniacid = {$uniacid} and order_id = {$order_id}";
        $num = pdo_fetch($sql);
        if ($num['num'] >= $full_sum) {
            return $this->result(-1, "已满标无效发送");
        }
        $bidding_info = pdo_get('ox_master_bidding',array('uniacid'=>$uniacid,'reapir_uid'=>$uid,'order_id'=>$order_id));
        if(!empty($bidding_info)){
            return $this->result(-1, "该用户已经竞标过了");
        }
        //发送模板消息
        $detail = pdo_get('ox_master_order',array('uniacid'=>$uniacid,'id'=>$order_id));
        $data = [
            'uid' => $uid,   //uid
            'mes_id' => 2,
            'page' => '/pages/store/pages/manage/index',
            'keyword' => [$detail['o_sn'],$detail['type_name'],'竞标池中有新的订单请及时查看']
        ];
        $result = Message::Instance()->send($data);
        return $this->result(0, "发送成功");
    }
    /*
     * 后台帮师傅竞标
     * http://www.v7.com/web/index.php?c=site&a=entry&m=ox_master&do=web&r=order.masterbid&order_id=9&repair_uid=8&price=1
     */
    public function masterbid(){
        global $_GPC, $_W;
        $order_id = $_GPC['order_id'];
        $uid = $_GPC['repair_uid'];
        $uniacid = $_W['uniacid'];
        $price = $_GPC['price'];

        //验证当前订单人数是否已满
        $full_sum = pdo_getcolumn('ox_master', array('uniacid'=>$uniacid), 'full_num');
        $sql = "select count(id) as num from  " . tablename('ox_master_bidding') . " where uniacid = {$uniacid} and order_id = {$order_id}";
        $num = pdo_fetch($sql);
        if ($num['num'] >= $full_sum) {
            return $this->result(-1, "已满标无效发送");
        }
        $bidding_info = pdo_get('ox_master_bidding',array('uniacid'=>$uniacid,'reapir_uid'=>$uid,'order_id'=>$order_id));
        if(!empty($bidding_info)){
            return $this->result(-1, "该用户已经竞标过了");
        }
        if (empty($order_id) || empty($uid) || empty($price)) {
            return $this->result(-1, '请填写正确价格');
        }
        $exist = pdo_getcolumn('ox_master_bidding', array('order_id' => $order_id, 'reapir_uid' => $uid), 'id');
        if (!empty($exist)) {
            $result = pdo_update('ox_master_bidding', array('price' => $price), array('order_id' => $order_id, 'reapir_uid' => $uid));
            $msg = $result ? '修改价格成功' : '修改价格失败';
        } else {
            $data = [
                "uniacid" => $_W['uniacid'],
                "reapir_uid" => $uid,
                "order_id" => $order_id,
                "price" => $price,
                "status" => 1,
                "create_time" => time(),
            ];
            $result = pdo_insert('ox_master_bidding', $data);
            if($result){
                //发送模板消息---给雇主发送新报价
                $order_info = pdo_get('ox_master_order',array('uniacid'=>$uniacid,'id'=>$order_id));
                $store_info = pdo_get('ox_master_store',array('uniacid'=>$uniacid,'uid'=>$uid));

                $data = [
                    'uid' => $order_info['uid'],   //uid
                    'mes_id' => 3,
                    'page' => '/pages/order/index',
                    'keyword' => [$order_info['o_sn'],$store_info['name'],$price.'元',$store_info['detail']]
                ];
                Message::Instance()->send($data);
            }
            $msg = $result ? '竞标成功' : '竞标失败';

        }
        if($result){
            //发送模板消息---给师傅发送
            $detail = pdo_get('ox_master_order',array('uniacid'=>$uniacid,'id'=>$order_id));
            $data = [
                'uid' => $uid,   //uid
                'mes_id' => 2,
                'page' => '/pages/store/pages/manage/index',
                'keyword' => [$detail['o_sn'],$detail['type_name'],'管理员已为你竞标请及时查看']
            ];
            Message::Instance()->send($data);
            return $this->result(0, $msg, '');
        } else {
            return $this->result(-1, $msg, '');
        }

    }

    //竞标列表
    public function jingbiaoList(){
        global $_GPC, $_W;
        $order_id = $_GPC['order_id'];

        $bing = pdo_getall('ox_master_bidding',['uniacid'=>$_W['uniacid'],'order_id'=>$order_id]);
        foreach ($bing as &$value){
            $shifu_name = pdo_fetch("select * from ".tablename('ox_master_store')." where uid={$value['reapir_uid']}");
            $value['shifu_name'] = $shifu_name['name'];
            $value['shifu_phone'] = $shifu_name['phone'];
        }
        return $this->result('0','sufcc',$bing);
    }



}

