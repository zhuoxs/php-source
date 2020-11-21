<?php
defined('IN_IA') or exit('Access Denied');
define('MODEL_NAME','ox_master');
require_once IA_ROOT . '/addons/'.MODEL_NAME.'/application/bootstrap.php';

class Ox_masterModuleWxapp extends WeModuleWxapp
{
    public function doPageApi()
    {
        Application::api();
    }

    /**
     * 预约支付345345678
     */
    public function doPagePayRepair()
    {
        global $_GPC, $_W;
        $order_sn = order_sn();
        $params = [
            "formid" => $_GPC['formid'],
            "o_sn" => $order_sn,
            "address"=> $_GPC['address'],
            "uid"=> $_GPC['uid'],
            "address_detail"=> $_GPC['address_detail'],
            "mapy"=> $_GPC['mapy'],
            "mapx"=> $_GPC['mapx'],
            "province"=> $_GPC['province'],
            "city"=> $_GPC['city'],
            "district"=> $_GPC['district'],
            "phone"=> $_GPC['phone'],
            "name"=> $_GPC['name'],
            "type_name"=> $_GPC['type_name'],
            "remark"=> $_GPC['remark'],
            "uniacid" => $_W['uniacid'],
            "status" => 0,
            "create_time" => $_SERVER['REQUEST_TIME'],
            "go_time" => strtotime($_GPC['time'])
        ];
        pdo_insert('ox_master_order',$params);
        $order_id = pdo_insertid();
        if(!$order_id){
            return $this->result(1, '请不要重复预约');
        }
        $base = new Basis();
        $base->add_form_id($_GPC['uid'],$_GPC['formid']);
        
        if($_GPC['imgs']){
            $imgs = json_decode(htmlspecialchars_decode($_GPC['imgs']),1);
            $data = [
                'order_id' => $order_id,
                'uniacid'=> $_W['uniacid'],
                'type' => 1,
                'create_time' => $_SERVER['REQUEST_TIME']
            ];
            foreach ($imgs as $k => $v){
                $data['img_patch'] = $v['short'];
                pdo_insert('ox_master_image',$data);
            }

        }
        $openid = pdo_getcolumn('mc_mapping_fans',['uid' => $_GPC['uid'],"uniacid" => $_W['uniacid']],'openid');
        $price = pdo_getcolumn('ox_master',["uniacid" => $_W['uniacid']],'price');
        $moduleid = empty($this->module['mid']) ? '000000' : sprintf("%06d", $this->module['mid']);
        $uniontid = date('YmdHis') . $moduleid . random(8, 1);
        if($price <= 0){
            $basis = new Basis();
            $basis->orderNotify($order_id);
            //pdo_update('ox_master_order',['status' => 1,'money' => 0],['uniacid'=>$_W['uniacid'],'id' =>$order_id ]);
            return $this->result(0, '1',$params );
        }
        $paylog = array(
            'uniacid' => $_W['uniacid'],
            'acid' => $_W['acid'],
            'type' => 'wechat',
            'openid' => $openid,
            'module' => $this->module['name'],
            'tid' => $order_sn,
            'uniontid' => $uniontid,
            'fee' => floatval($price),
            'card_fee' => floatval($price),
            'status' => '0',
            'is_usecard' => '0',
            'tag' => iserializer(array('acid' => $_W['acid'], 'uid' => $_W['member']['uid']))
        );
        pdo_insert('core_paylog', $paylog);
        //构造支付参数
        $order = array(
            'tid' => $order_sn,
            'user' => $openid, //用户OPENID
            'fee' => floatval($price), //金额
            'title' => '服务预约',
            'paytype' => 'wechat'
        );
        //生成支付参数，返回给小程序端
        $pay_params = $this->pay($order);
        if (is_error($pay_params)) {
            return $this->result(1, '支付失败，检查支付配置');
        }
        $logs = [
            'type' => 1,
            'pay_sn' => $order_sn,
            'order_id' => $order_id,
            'pay_type' => 1,
            'title' => '服务预约',
            'account' => $price,
            'create_time' => $_SERVER['REQUEST_TIME'],
            'uniacid'=>$_W['uniacid'],
            'uid'=>$_GPC['uid'],
            'status' => 0,
        ];
        pdo_insert('ox_master_finance',$logs);
        $pay_params['orderid'] = $order_id;
        $pay_params['paytype'] = 1;
        //短信通知
        $basis = new Basis();
        $basis->orderNotify($order_id);
        return $this->result(0, '',$pay_params );
        }
    //支付回调

    public function doPagePaySel()
    {
        global $_GPC, $_W;
        $order_sn = order_sn();

        $price = $_GPC['price'];
        $order_id = $_GPC['orderid'];
        $openid = pdo_getcolumn('mc_mapping_fans', ['uid' => $_GPC['uid'], "uniacid" => $_W['uniacid']], 'openid');
        $moduleid = empty($this->module['mid']) ? '000000' : sprintf("%06d", $this->module['mid']);
        $uniontid = date('YmdHis') . $moduleid . random(8, 1);

        $paylog = array(
            'uniacid' => $_W['uniacid'],
            'acid' => $_W['acid'],
            'type' => 'wechat',
            'openid' => $openid,
            'module' => $this->module['name'],
            'tid' => $order_sn,
            'uniontid' => $uniontid,
            'fee' => floatval($price),
            'card_fee' => floatval($price),
            'status' => '0',
            'is_usecard' => '0',
            'tag' => iserializer(array('acid' => $_W['acid'], 'uid' => $_W['member']['uid']))
        );

        pdo_update('ox_master_order',array('sure_o_sn' => $order_sn),array('id' => $order_id,"uniacid" => $_W['uniacid']));
        pdo_insert('core_paylog', $paylog);
        //构造支付参数
        $order = array(
            'tid' => $order_sn,
            'user' => $openid, //用户OPENID
            'fee' => floatval($price), //金额
            'title' => '选择竞标师傅',
            'paytype' => 'wechat'
        );

        //生成支付参数，返回给小程序端
        $pay_params = $this->pay($order);

        if (is_error($pay_params)) {
            return $this->result(1, $pay_params['message']);
        }
        $logs = [
            'type' => 1,
            'pay_sn' => $order_sn,
            'order_id' => $_GPC['orderid'],
            'pay_type' => 1,
            'title' => '竞标选择师傅',
            'account' => $price,
            'create_time' => $_SERVER['REQUEST_TIME'],
            'uniacid' => $_W['uniacid'],
            'uid' => $_GPC['uid'],
            'status' => 0,
        ];
        pdo_insert('ox_master_finance', $logs);
        $pay_params['orderid'] = $_GPC['orderid'];
        $pay_params['paytype'] = 1;
        return $this->result(0, '', $pay_params);
    }
    /**
     * 回调参数
     * @param $log
     * {
     *  "weid": null,
     *  "uniacid": "7",
     *  "acid": "7",
     *  "result": "success",
     *  "type": "wxapp",
     *  "from": "notify",
     *  "tid": "2019030710010098",
     *  "uniontid": "2019030717185300001843593274",
     *  "transaction_id": null,
     *  "trade_type": "JSAPI",
     *  "follow": 0,
     *  "user": "o9JDE5IxQqj9mBxgcLJNxS1trf9s",
     *  "fee": "0.01",
     *  "tag": {
     *  "acid": "7",
     *  "uid": "5",
     *  "transaction_id": "4200000264201903074385716681"
     *  },
     *  "is_usecard": "0",
     *  "card_type": "0",
     *  "card_fee": "0.01",
     *  "card_id": "",
     *  "paytime": 1551950338
     *  }
     */
//    public function payResult($log) {
//        pdo_insert('oxiang_test',['content' => json_encode($log)]);
//        if($log['success'] == "success"){
//            pdo_update('musen_repair_order',['pay_status' => 1,'money' => $log['fee']],['uniacid'=>$log['uniacid'],'o_sn' =>$log['tid'] ]);
//            pdo_update('musen_repair_finance',['status' => 1,'account' => $log['fee']],['uniacid'=>$log['uniacid'],'pay_sn' =>$log['tid'] ]);
//        }
//    }

    public function doPageRefund(){
        global $_GPC, $_W;

        //添加formid
        $base = new Basis();
        $base->add_form_id($_GPC['uid'],$_GPC['formid']);

        $detail = pdo_get('ox_master_order',['uniacid'=> $_W['uniacid'],'pay_status' => 0,'status' => 0,'id'=>$_GPC['orderid']]);
        if($detail){
            if($detail['money'] > 0 ){
                $result = $this->refund($detail['o_sn'],$detail['money'],'取消订单');
            }
            $params = [
                "uniacid" => $_W['uniacid'],
                "uid"=> $_GPC['uid'],
                "id" => $_GPC['orderid']
            ];
            pdo_update('ox_master_order',['status' => 2],$params);
        }else{
            return $this->result(1, '订单不存在',[] );
        }
        $data = [
            "uniacid" => $_W['uniacid'],
            "uid"=> $_GPC['uid'],
        ];
        $data['status'] = $_GPC['status'];
        $pageSize = 4;
        $pageCur = $_GPC['page'] ?: 1;
        $list = pdo_getall('ox_master_order',$data,'','',['id desc'],[$pageCur,$pageSize]);
        foreach ($list as $k => $v){
            $list[$k]['create_time'] = date('Y-m-d H:i',$v['create_time']);
        }
        return $this->result(0, $result, $list);
        //return $this->result(0, '',$result );

    }

    protected function refund($tid, $fee = 0, $reason = '') {
        load()->model('refund');
        $refund_id = refund_create_order($tid, $this->module['name'], $fee, $reason);
        if (is_error($refund_id)) {
            return $refund_id;
        }
        return refund($refund_id);
    }
}