<?php
namespace app\model;
use think\Loader;
use think\Db;
use app\base\model\Base;

class Dingtalk extends Base
{
    public function onLeaderAdd($leader){
        $dingtalk = Dingtalk::get(['store_id'=>0]);
        if ($dingtalk && $dingtalk['is_open']){
            $this->sendDingtalk($dingtalk['token'],$leader['name'].' 申请成为团长，请及时处理');
        }
    }
    public function onStoreAdd($store){
        $dingtalk = Dingtalk::get(['store_id'=>0]);
        if ($dingtalk && $dingtalk['is_open']) {
            $this->sendDingtalk($dingtalk['token'], $store['name'] . ' 商家申请入驻，请及时处理');
        }
    }
    public function onOrderPay($order){
        $store_ids = Ordergoods::where('order_id',$order->id)
            ->distinct('store_id')
            ->field('store_id')
            ->select();

        foreach ($store_ids as $store_id) {
            $this->sendtalk($store_id->store_id,0);
        }

//        发送消息给团长
        $leader = Leader::get($order->leader_id);
        if ($leader && $leader->dingtalk_token){
            $ordergoodses = Ordergoods::where('order_id',$order->id)->select();
            $user = User::get($order->user_id);

            foreach ($ordergoodses as $ordergoods) {
                $this->sendDingtalk(
                    $leader->dingtalk_token
                    ,"{$user->getData('name')} 购买了[ {$ordergoods->goods_name} * {$ordergoods->num} ] 总价 ￥{$ordergoods->pay_amount}"
                );
            }
        }
    }

    public function onPinorderPay($model){
        $store_ids = Pinorder::where('id', $model->id)
            ->field('store_id')
            ->select();

        foreach ($store_ids as $store_id) {
            $this->sendtalk($store_id->store_id, 1);
        }

        //发送消息给团长
        $leader = Leader::get($model->leader_id);
        if ($leader && $leader->dingtalk_token) {
            $ordergoodses = Pinorder::with('goods2')->where('id', $model->id)->select();
            $user = User::get($model->user_id);

            foreach ($ordergoodses as $ordergoods) {
                $this->sendDingtalk(
                    $leader->dingtalk_token
                    , "{$user->getData('name')} 购买了拼团商品[ {$ordergoods->goods_name} * {$ordergoods->num} ] 总价 ￥{$ordergoods->order_amount}"
                );
            }
        }
    }

    /*
     * 发送消息
     * @param  int  $type [发送类型0 下订单 1申请退款]
     */
    public function sendtalk($store_id,$type) {
        global $_W;
        $dingtalk = Db::name('dingtalk')->where(['uniacid' => $_W['uniacid'], 'store_id' => $store_id])->find();
        if ($type == 0) {
            $content = $dingtalk['content'];
        } else if ($type=1) {
            $content = $dingtalk['pincontent'];
        } else {
            $content = $dingtalk['contentrefund'];
        }
        if ($dingtalk['is_open'] == 1) {
            $this->sendDingtalk($dingtalk['token'], $content);
        }
    }
    //钉钉机器人发送消息
    public function sendDingtalk($token,$content){
        Loader::import('dingtalks.DingTalk');
        Loader::import('dingtalks.MsgText');
        $msg = new \MsgText($content);
        $ding = new \DingTalk();
        $ding->send($token,$msg);
    }


}
