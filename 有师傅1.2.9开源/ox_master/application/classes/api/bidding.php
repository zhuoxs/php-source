<?php
if (!(defined('IN_IA'))) {
    exit('Access Denied');
}

class Api_Bidding extends WeModuleWxapp
{
    /**
     * 师傅竞标
     * @author cheng.liu
     * @date 2019/3/16
     */
    public function index()
    {
        global $_GPC, $_W;
        $price = trim($_GPC['price']);
        if (is_numeric($price) == false) {
            return $this->result(-1, '请填写正确价格');
        }
        $uniacid = $_W['uniacid'];
        $order_id = $_GPC['order_id'];

        $full_sum = pdo_getcolumn('ox_master', array('uniacid'=>$uniacid), 'full_num');
        $sql = "select count(id) as num from  " . tablename('ox_master_bidding') . " where uniacid = {$uniacid} and order_id = {$order_id} and status !=0 ";
        $num = pdo_fetch($sql);
        if ($num['num'] >= $full_sum) {
            return $this->result(-1, "已满标不可参与此竞标");
        }

        if (empty($_GPC['order_id']) || empty($_GPC['uid']) || empty($price)) {
            return $this->result(-1, '请填写正确价格');
        }
        $exist = pdo_getcolumn('ox_master_bidding', array('order_id' => $_GPC['order_id'], 'reapir_uid' => $_GPC['uid']), 'id');
        if (!empty($exist)) {
            $result = pdo_update('ox_master_bidding', array('price' => $price), array('order_id' => $_GPC['order_id'], 'reapir_uid' => $_GPC['uid']));
            $msg = $result ? '修改价格成功' : '修改价格失败';
        } else {
            $data = [
                "uniacid" => $_W['uniacid'],
                "reapir_uid" => $_GPC['uid'],
                "order_id" => $_GPC['order_id'],
                "price" => $price,
                "status" => 1,
                "create_time" => time(),
            ];
            //添加竞标人数
            $result = pdo_insert('ox_master_bidding', $data);
            $msg = $result ? '竞标成功' : '竞标失败';
        }

        if ($result) {

            //发送模板消息
            $order_info = pdo_get('ox_master_order',array('uniacid'=>$uniacid,'id'=>$order_id));
            $num = $order_info['bid_num'] + 1;
            pdo_update('ox_master_order',array('bid_num' => $num),array('uniacid'=>$uniacid,'id'=>$order_id));
            $store_info = pdo_get('ox_master_store',array('uniacid'=>$uniacid,'uid'=>$_GPC['uid']));

            $data = [
                'uid' => $order_info['uid'],   //uid
                'mes_id' => 3,
                'page' => '/pages/order/index',
                'keyword' => [$order_info['o_sn'],$store_info['name'],$_GPC['price'].'元',$store_info['detail']]
            ];
            Message::Instance()->send($data);

            return $this->result(0, $msg, '');
        } else {
            return $this->result(-1, $msg, '');
        }
    }

    /**
     * 竞标列表
     * @author cheng.liu
     * @date 2019/3/16
     */
    public function selectReapir()
    {

        global $_GPC, $_W;
        if (empty($_GPC['orderid'])) {
            return $this->result(-1, '订单错误');
        }

        $base = new Basis();
        $base->add_form_id($_GPC['uid'], $_GPC['formid']);

        $filed = 'order.id as order_id,order.uid,order.o_sn,order.status,order.pay_status,bid.id as bid,bid.reapir_uid,bid.order_id,bid.price,bid.status as bid_status,bid.create_time,store.cover,store.name,store.phone,store.address,store.address_detail';
        $where = ' order.uid = ' . $_GPC['uid'] . ' and order.uniacid = ' . $_W['uniacid'] . ' and bid.uniacid = ' . $_W['uniacid'] . ' and order.id = ' . $_GPC['orderid'] . ' and bid.order_id = ' . $_GPC['orderid'] . '  and bid.status = 1 ';
        $sql = 'select ' . $filed . ' from ' . tablename('ox_master_order') . ' as `order`
         left join ' . tablename('ox_master_bidding') . ' as `bid` on order.id = bid.order_id
         left join ' . tablename('ox_master_store') . ' as `store` on store.uid = bid.reapir_uid
         where ' . $where . ' order by bid.create_time asc';

        $list = pdo_fetchall($sql);

        if ($list) {
            return $this->result(0, '查询成功', $list);
        } else {
            return $this->result(-1, '暂无记录', '');
        }
    }

    /**
     * 选择竞标
     * @author cheng.liu
     * @date 2019/3/16
     */
    public function sureReapir()
    {

        global $_GPC, $_W;
        if (empty($_GPC['rid'])) { //判断是否存在师傅
            return $this->result(-1, '订单错误');
        }

        $order_sn = order_sn();
        $moduleid = empty($this->module['mid']) ? '000000' : sprintf("%06d", $this->module['mid']);
        $uniontid = date('YmdHis') . $moduleid . random(8, 1);

        $openid = pdo_getcolumn('mc_mapping_fans', ['uid' => $_GPC['uid'], "uniacid" => $_W['uniacid']], 'openid');

        $paylog = array(
            'uniacid' => $_W['uniacid'],
            'acid' => $_W['acid'],
            'type' => 'wechat',
            'openid' => $openid,
            'module' => $this->module['name'],
            'tid' => $order_sn,
            'uniontid' => $uniontid,
            'fee' => floatval($_GPC['price']),
            'card_fee' => floatval($_GPC['price']),
            'status' => '0',
            'is_usecard' => '0',
            'tag' => iserializer(array('acid' => $_W['acid'], 'uid' => $_W['member']['uid']))
        );
        pdo_insert('core_paylog', $paylog);
        //构造支付参数
        $order = array(
            'tid' => $order_sn,
            'user' => $openid, //用户OPENID
            'fee' => floatval($_GPC['price']), //金额
            'title' => '选择竞标师傅',
            'paytype' => 'wechat'
        );
        //生成支付参数，返回给小程序端
        $pay_params = $this->pay($order);
        if (is_error($pay_params)) {
            return $this->result(1, '支付失败，检查支付配置');
        }
    }

    /**
     * 修改订单
     * @author cheng.liu
     * @date 2019/3/16
     */
    public function upOrder()
    {
        global $_GPC, $_W;

        $basis = new Basis();
        //修改状态
        $where = array(
            'id' => $_GPC['bid'],
            'uniacid' => $_W['uniacid'],
        );
        $info = pdo_update('ox_master_bidding', array('status' => 2), $where);//竞标成功


        if ($info) {
            $money = 0;    //变动可用资金
            $lock_money = $_GPC['price'];//变动冻结资金
            $uid = $_GPC['rid'];//师傅id
            $parame = array(
                'from_uid' => 0,  //来源用户-可不填写
                'type' => 0, //类型 0接单 1完工 2提现 3到账(无实际作用,可不设置)
                'from_id' => $_GPC['orderid'],   //来源id 订单id或提现表id(非小程序form_id)
                'from_table' => 'ox_master_bidding', //来源表名，不带ims_
                'desc' => '用户选择竞标师傅成功,竞标id为' . $_GPC['rid']
            );
            $result = $basis->money_change($money, $lock_money, $uid, $parame);
            pdo_update('ox_master_order', array('status' => 1, 'pay_status' => 1, 'repair_uid' => $uid, 'sure_price' => $_GPC['price']), array('uniacid' => $_W['uniacid'], 'id' => $_GPC['orderid']));//修改订单状态
        }

        if ($result) {
            //发送模板消息
            $info = pdo_get('ox_master_bidding', $where);
            $bidding_arr = pdo_getall('ox_master_bidding',array('uniacid'=>$_W['uniacid'],'order_id'=>$info['order_id']));
            $order_info = pdo_get('ox_master_order',['uniacid' => $_W['uniacid'], 'id' => $_GPC['orderid']]);
            foreach ($bidding_arr as $k => $v){
                if($v['reapir_uid'] == $_GPC['rid']){
                    $data = [
                        'uid' => $v['reapir_uid'],   //uid
                        'mes_id' => 4,
                        'page' => '/pages/store/pages/manage/index',
                        'keyword' => ['恭喜你已中标',$order_info['o_sn'],'请及时联系发布者']
                    ];
                }else{
                    $data = [
                        'uid' => $v['reapir_uid'],   //uid
                        'mes_id' => 4,
                        'page' => '/pages/store/pages/manage/index',
                        'keyword' => ['未中标',$order_info['o_sn'],'你还可以查看更多竞标信息']
                    ];
                }
                $result = Message::Instance()->send($data);
            }
            return $this->result(0, '已选择请耐心等待师傅联系');
        } else {
            return $this->result(-1, '选择失败');
        }
    }

    /**
     * 订单流拍
     * @author cheng.liu
     * @date 2019/3/16
     */
    public function flowShot()
    {
        global $_GPC, $_W;

        //添加formid
        $base = new Basis();
        $base->add_form_id($_GPC['uid'], $_GPC['formid']);

        $order_id = $_GPC['orderid'];
        $uniacid = $_W['uniacid'];

        $full_sum = pdo_getcolumn('ox_master', array(), 'full_num');

        $sql = "select count(id) as num from  " . tablename('ox_master_bidding') . " where uniacid = {$uniacid} and order_id = {$order_id}";
        $num = pdo_fetch($sql);
        if ($num['num'] < $full_sum) {
            return $this->result(-1, "满{$full_sum}位师傅竞标可流拍");
        }
        $result = pdo_update('ox_master_bidding', array('status' => 0), array('uniacid' => $uniacid, 'order_id' => $order_id));
        if ($result) {
            //发送模板消息
            $bidding_arr = pdo_getall('ox_master_bidding',array('uniacid'=>$_W['uniacid'],'order_id'=>$order_id));
            $order_info = pdo_get('ox_master_order',['uniacid' => $_W['uniacid'], 'id' => $_GPC['orderid']]);
            foreach ($bidding_arr as $k => $v){
                $data = [
                    'uid' => $v['reapir_uid'],   //uid
                    'mes_id' => 4,
                    'page' => '/pages/store/pages/manage/index',
                    'keyword' => ['订单已流拍',$order_info['o_sn'],'你还可以查看更多竞标信息']
                ];
                $result = Message::Instance()->send($data);
            }

            return $this->result(0, "流拍成功等待其他师傅重新竞标,被流拍的师傅不可在竞此标");
        } else {
            return $this->result(-1, "流拍失败");
        }
    }

    /**
     * 申请退款
     * @author cheng.liu
     * @date 2019/3/16
     */
    public function refund(){
        global $_GPC, $_W;
        //添加formid
        $base = new Basis();
        $base->add_form_id($_GPC['uid'], $_GPC['formid']);
        $order_id = $_GPC['orderid'];
        $uid = $_GPC['uid'];
        $uniacid = $_W['uniacid'];
        $reason = $_GPC['reason'];

        $order_detail = pdo_get('ox_master_order',array('uniacid' => $uniacid, 'id' => $order_id));
        if(!empty($order_detail)){
            $params = array(
                'uniacid' => $uniacid,
                'uid' => $uid,
                'order_id' => $order_id,
                'rid' => $order_detail['repair_uid'],
                'status' => 1,
                'price' => $order_detail['sure_price'],
                'reason' => $reason,
                'create_time' => time()

            );
            $result = pdo_insert('ox_master_refund',$params);
            if($result){
                pdo_update('ox_master_order',array('status' => 4),array('uniacid' => $uniacid, 'id' => $order_id));
                return $this->result(0, "申请成功,已进入后台审核,2-3个工作日处理退款");
            }else{
                return $this->result(-1, "申请退款失败");
            }

        }else{
            return $this->result(-1, "申请退款失败");
        }

    }
}