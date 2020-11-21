<?php

namespace app\model;

use app\base\model\Base;

class Task extends Base
{
    protected static function init()
    {
        self::beforeInsert(function ($model){
            startTask();
            if (!isset($model->execute_time) || !$model->execute_time){
                $model->execute_time = time();
            }
        });
        parent::init();
    }
//    获取器
    public function getExecuteTimeAttr($value)
    {
        if ($value){
            return date('Y-m-d H:i:s',$value);
        }
        return "";
    }
    public function onOrderPay($order){
        $tem = Template::get([]);
        if($tem['tid1']){
            $data = [
                'type'=>'sendOrderPayTemplate',
                'value'=>$order->id,
            ];
            self::save($data);
        }

    }
    public function onPinorderPay($model){
        $tem = Template::get([]);
        if($tem['tid1']){
            $data = [
                'type'=>'sendPinorderPayTemplate',
                'value'=>$model->id,
            ];
            self::save($data);
        }
    }
    public function onOrdergoodsReceive($ordergoods){
        $tem = Template::get([]);
        if($tem['tid2']){
            $data = [
                'type'=>'sendOrdergoodsReceiveTemplate',
                'value'=>$ordergoods->id,
            ];
            self::save($data);
        }
    }
    public function onPinorderReceive($ordergoods){
        $tem = Template::get([]);
        if($tem['tid2']){
            $data = [
                'type'=>'sendPinorderReceiveTemplate',
                'value'=>$ordergoods->id,
            ];
            self::save($data);
        }
    }
    public function onDistributionrecordFinish($record){
        $task_model = new Task();
        $time = Config::get_value('distribution_withdraw_time',0);
        $task_model->save([
            'type'=>'distribution_convert_money',
            'value'=>$record->id,
            'execute_time'=>time() + $time*60*60,
        ]);
    }
    public function onOrdergoodsRefund($ordergoods){
        $tem = Template::get([]);
        if($tem['tid3']){
            $data = [
                'type'=>'sendOrdergoodsRefundTemplate',
                'value'=>$ordergoods->id,
            ];
            self::save($data);
        }
    }
    public function onOrdergoodsRefunderror($ordergoods){
        $tem = Template::get([]);
        if($tem['tid3']){
            $data = [
                'type'=>'sendOrdergoodsRefundTemplate2',
                'value'=>$ordergoods->id,
            ];
            self::save($data);
        }
    }
}
