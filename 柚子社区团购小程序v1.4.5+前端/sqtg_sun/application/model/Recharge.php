<?php
namespace app\model;

use app\base\model\Base;

class Recharge extends Base
{
    static public function get_curr(){
        global $_W;
        $uniacid = $_W['uniacid'];
        $info = self::get(['uniacid'=>$uniacid]);
        return $info;
    }
    public function rechargeNotify($model){
        $recharge = Rechargerecord::get($model->source_id);
        $attach = json_decode($model->callback_xml,true);
        $recharge->out_trade_no = $attach['out_trade_no'];
        $recharge->transaction_id = $attach['transaction_id'];
        $recharge->state = 1;
        $recharge->save();
    }
}