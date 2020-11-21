<?php

namespace app\model;

use think\Db;
use think\Model;

class Order extends Model
{


    protected $autoWriteTimestamp = true;
    protected $createTime = 'add_time';
    protected $updateTime = 'update_time';
    protected $pk = 'order_sn';

    public function getStatusAbcAttr($value)
    {
        $statusArr = [1 => '已支付', 0 => '未支付'];
        return $statusArr[$value];
    }


    public static function updateOrder($orderSn, $price)
    {
        $order = self::get($orderSn);

        if (!$order) return ['result' => 1, 'msg' => '订单不存在'];
        if ($order->status === 1) return ['result' => 2, 'msg' => '订单已完成支付，无需再进行支付'];
        if ($price < $order->real_pay_price) return ['result' => 3, 'msg' => '支付金额小于实际支付金额'];
        Db::startTrans();
        try {
            $order->status = 1;
            $order->pay_time = time();
            $order->real_pay_price = $price;
            $order->save();

            $memberModel = model('member');
            $member = $memberModel::get($order->user_id);
            if (!$member) throw new \Exception('对应的充值会员信息不存在!');

            //购买类型，1:金币，2:vip
            if ($order->buy_type == 1) {
                $member->money += $order->buy_glod_num;
                $member->save();
                //写入金币记录表
                Db::name('gold_log')->insert(['user_id' => $order->from_agent_id, 'gold' =>$order->buy_glod_num, 'add_time' => time(), 'module' => 'Order', 'explain' => '充值金币']);
            } elseif ($order->buy_type == 2) {
                //解析出购买的会员内容
                $buyVipInfo = \json_decode($order->buy_vip_info, true);
                if ($buyVipInfo['permanent'] != 1) {
                    //1.普通周期会员
                    if ($member->out_time > time()) {
                        $member->out_time = strtotime("+{$buyVipInfo['days']} days", $member->out_time);
                    } else {
                        $member->out_time = strtotime("+{$buyVipInfo['days']} days");
                    }
                    $member->save();
                } else {
                    //2.永久会员
                    $member->is_permanent = 1;
                    $member->save();
                }
            }
            #throw  new \think\Exception('no success');
            $gold_exchange_rate = get_config('gold_exchange_rate');
            $total_gold = $price * $gold_exchange_rate;
            //充值分销商分成处理

            distributor_divide(array('id'=>$order->user_id,'gold'=>$total_gold));
            //充值代理商有分成
            if ($order->from_agent_id > 0 && $order->user_id != $order->from_agent_id) {
                $agent_commission = get_config('agent_commission');   //代理商提成比例
                $agent_commission = $agent_commission > 0 ? $agent_commission : 0;
                $agent_commission = $agent_commission / 100;

                //分成转换为金币，向下取整
                $agent_money = $price * $agent_commission;
                $agent_gold = (int)($agent_money * $gold_exchange_rate);//金额*金额兑换金币的比率

                //为代理商增加分成金币
                Db::name('member')->where("id={$order->from_agent_id}")->setInc('money', $agent_gold);

                if ($agent_gold > 0) {
                    //金币记录写入代码分成的记录
                    Db::name('gold_log')->insert(['user_id' => $order->from_agent_id, 'gold' => $agent_gold, 'add_time' => time(), 'module' => 'Order', 'explain' => '代理分成']);
                }
            }


            Db::commit();
        } catch (\Exception $e) {
            echo "错误信息:$e";
            Db::rollback();
            return ['result' => 4, 'msg' => '更新订单数据时发生错误'];
        }

        return ['result' => 0, 'msg' => '订单更新成功'];
    }


}