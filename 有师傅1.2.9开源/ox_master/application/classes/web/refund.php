<?php
if (!(defined('IN_IA'))) {
    exit('Access Denied');
}

class Web_Refund extends Web_Base {


    /**
     * 退款到个人账户
     * @param rid int 退款id
     * @date 2019/3/21
     * @author cheng.liu
     *
     */
    public function index(){
        global $_GPC, $_W;

        $basis = new Basis();

        $rid = $_GPC['rid'];
        if(!$rid){
            return $this->result(-1, '退款id错误' );

        }
        $refund = pdo_get('ox_master_refund',array('uniacid'=> $_W['uniacid'],'id' => $rid));

        $detail = pdo_get('ox_master_order',['uniacid'=> $_W['uniacid'],'pay_status' => 1,'status' => 4,'id'=>$refund['order_id']]);

        $params = [
            "uniacid" => $_W['uniacid'],
            "uid"=> $detail['uid'],
            "id" => $detail['id']
        ];

        if($_GPC['status'] == 1){

            if($detail){

                if($detail['sure_price'] > 0 ){
                    $result = $this->refund($detail['sure_o_sn'],$refund['price'],'申请退款');
                }

                if($result['errno'] == 0){
                    pdo_update('ox_master_order',['status' => 5],$params);
                    pdo_update('ox_master_refund',['status' => 4],array('uniacid' => $_W['uniacid'],'id' => $rid));
                    //退款成功减去师傅冻结金额
                    $money = 0;    //变动可用资金
                    $lock_money = -1 * $detail['sure_price'];//变动冻结资金
                    $uid = $detail['repair_uid'];//师傅id
                    $parame = array(
                        'from_uid' => 4,  //来源用户-可不填写
                        'type' => 2, //类型 0接单 1完工 2提现 3到账(无实际作用,可不设置)
                        'from_id' => $refund['order_id'],   //来源id 订单id或提现表id(非小程序form_id)
                        'from_table' => 'ox_master_refund', //来源表名，不带ims_
                        'desc' => '雇主退款,退款id为' . $rid
                    );
                    $basis->money_change($money, $lock_money, $uid, $parame);
                    return $this->result(0,'申请退款成功');
                }else{
                    return $this->result(-1,$result['message']);
                }
            }else{
                return $this->result(-1, '订单不存在');
            }
        }else{
            pdo_update('ox_master_refund',['status' => 3],array('uniacid' => $_W['uniacid'],'id' => $rid));
            return $this->result(-1,'拒绝退款成功');
        }

        return $this->result(-1,'未知错误');
    }

    protected function refund($tid, $fee = 0, $reason = '') {
        load()->model('refund');
        $refund_id = refund_create_order($tid,'ox_master', $fee, $reason);
        if (is_error($refund_id)) {
            return $refund_id;
        }
        return refund($refund_id);
    }
}

