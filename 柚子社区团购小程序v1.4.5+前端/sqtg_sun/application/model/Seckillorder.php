<?php

namespace app\model;
use app\api\controller\Cwx;
use think\Db;
use think\Exception;
use app\base\model\Base;

class Seckillorder extends Base
{
    //    新增订单：新增、生成分佣记录
    public static function insertDb($data){
        global $_W;
        $data['uniacid'] = $_W['uniacid'];

        $user = User::get($data['user_id']);
        $data['openid'] = $user['openid'];

        $data['orderformid'] = date("YmdHis") .rand(11111, 99999);
        $data['create_time'] = time();

        Db::name('seckillorder')->strict(false)->insert($data);
        $id = Db::name('seckillorder')->getLastInsID();
        $seckillgoods = Seckillgoods::get($data['gid']);
        //订单详情
        $detail=array(
            'uniacid'=>$data['uniacid'],
            'store_id'=>$seckillgoods['store_id'],
            'order_id'=>$id,
            'user_id'=>$data['user_id'],
            'openid'=>$data['openid'],
            'gid'=>$data['gid'],
            'gname'=>$seckillgoods['name'],
            'num'=>$data['num'],
            'unit_price'=>$seckillgoods['price'],
            'total_price'=>$seckillgoods['price'],
            'pic'=>$seckillgoods['pic'],
            'create_time'=>time(),
        );
        if ($seckillgoods['use_attr'] && $data['attr_ids']){
            $seckillgoodsattrsetting = Seckillgoodsattrsetting::get(['seckillgoods_id'=>$data['gid'],'attr_ids'=>$data['attr_ids']]);

            if ($seckillgoodsattrsetting['stock'] < $data['num']){
                throw new Exception('库存不足');
            }

            $numed = Db::name('seckillorderdetail')
                ->where('gid',$data['gid'])
                ->where('attr_ids',$data['attr_ids'])
                ->sum('num');
            if ($seckillgoodsattrsetting['limit'] < $data['num']+$numed){
                throw new Exception('您购买的数量超过限购量');
            }


            Db::name('seckillgoodsattrsetting')->where('id',$seckillgoodsattrsetting['id'])->setDec('stock',$data['num']);

            $detail['attr_ids'] = $data['attr_ids'];
            $detail['attr_list'] = $seckillgoodsattrsetting['key'];
            $detail['unit_price'] = $seckillgoodsattrsetting['price'];
            $detail['total_price'] = $seckillgoodsattrsetting['price'];
            $detail['pic'] = $seckillgoodsattrsetting['pic']?:$detail['pic'];
        }else{
            $numed = Db::name('seckillorderdetail')
                ->where('gid',$data['gid'])
                ->sum('num');
            if ($seckillgoods['limit'] < $data['num']+$numed){
                throw new Exception('您购买的数量超过限购量');
            }


            if ($seckillgoods['stock'] < $data['num']){
                throw new Exception('库存不足');
            }
        }

        Db::name('seckillgoods')->where('id',$seckillgoods['id'])->setDec('stock',$data['num']);
        Db::name('seckillgoods')->where('id',$seckillgoods['id'])->setInc('sales_num',$data['num']);

        Db::name('seckillorderdetail')->strict(false)->insert($detail);

        $outtime = 0;
        $meeting = Seckillmeeting::get($seckillgoods['seckillmeeting_id']);
        $topic = Seckilltopic::get($meeting['seckilltopic_id']);
        if ($topic['id']){
            $outtime = $topic['outtime'];
        }

        if (!!$outtime){
            $task_model = new Task();
            $task_data = array(
                'type'=>'seckillorder',
                'value'=>$id,
                'execute_time'=>time()+$outtime*60,
            );
            $task_model->allowField(true)->save($task_data);
            $order = Seckillorder::get($id);
            $order->pay_outtime = time()+$outtime*60;
            $order->save();
        }

        return $id;
    }

    public static function pay($id,$data){
        $order = Seckillorder::get($id);
        if (!$order['id']){
            throw new \Exception('找不到订单');
        }
        if ($order['order_status'] == 4){
            throw new \Exception('订单已过期');
        }

        $user = User::get($order['user_id']);
//        余额支付
        if ($data['pay_type'] == 2){
            if ($user['balance'] < $order['order_amount']){
                throw new \ZhyException('您的账户余额不足');
            }
            $userbalancerecord_model = new Userbalancerecord();
            $userbalancerecord_model->addBalanceRecord($order['user_id'],$order['uniacid'],5,0,-1*$order['order_amount'],0,0,'商品秒杀');
            $userbalancerecord_model->editBalance($order['user_id'],-1*$order['order_amount']);
            return true;
        }else if($data['pay_type'] == 1){
//            微信支付
            $wx= new Cwx();
            $attach=json_encode(array('type'=>'seckillorder','uniacid'=>$user['uniacid'],'seckillorder_id'=>$id));
            $wxinfo=$wx->pay($user['openid'],$order['order_amount'],$attach);
            return $wxinfo;
        }
    }

    public static function cancel($id){
        $order = Seckillorder::get($id,['details']);
        if ($order['pay_status']){
            return false;
        }
        Db::name('seckillorder')->where('id',$id)->update(['order_status'=>4]);
        foreach ($order['details'] as $detail) {
            if ($detail['attr_ids']){
                Db::name('seckillgoodsattrsetting')
                    ->where('seckillgoods_id',$detail['gid'])
                    ->where('attr_ids',$detail['attr_ids'])
                    ->setInc('stock',$order['details'][0]['num']);
            }else{
                Db::name('seckillgoods')
                    ->where('id',$detail['gid'])
                    ->setInc('stock',$order['details'][0]['num']);
            }

            Db::name('seckillgoods')
                ->where('id',$detail['gid'])
                ->setDec('sales_num',$order['details'][0]['num']);
        }
        return true;
    }

    public static function  confirm($id){
        $order = Seckillorder::get($id);

        $order_model = new Order();
        $order_model->confirmAddStoreMoney($order['store_id'],$order['order_amount'],3,$order['user_id'],$id,$order['orderformid'],$order['goods_total_num']);
        
        return Seckillorder::update(['order_status'=>3],['id'=>$id]);
//        $order = Seckillorder::get($id);
//        return $order->save(['order_status'=>3]);
    }

    public function details()
    {
        return $this->hasMany('Seckillorderdetail','order_id','id');
    }
}
