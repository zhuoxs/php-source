<?php
namespace app\model;

use app\base\model\Base;

class Payrecord extends Base{
    protected static function init()
    {
        parent::init();

        self::beforeUpdate(function ($model){
            $old_info = self::get($model->id);
//            支付回调
            if (!$old_info['callback_time'] && $model['callback_time'] && $model['source_type']=='Order'){
                $order = new Order();
                $order->onPaycallback($model);
            }
            if (!$old_info['callback_time'] && $model['callback_time'] && $model['source_type']=='pinbuy'){
                $pin=new Pinorder();
                $data = json_decode($model['callback_xml'],true);
                $data['attach']=json_encode(['oid'=>$model['source_id']]);
                $pin->notify($data);
            }
            if (!$old_info['callback_time'] && $model['callback_time'] && $model['source_type']=='pinjoinbuy'){
                $pin=new Pinorder();
                $data = json_decode($model['callback_xml'],true);
                $data['attach']=json_encode(['oid'=>$model['source_id']]);
                $pin->joinNotify($data);
            }
            if (!$old_info['callback_time'] && $model['callback_time'] && $model['source_type']=='recharge'){
                $rec=new Recharge();
                $rec->rechargeNotify($model);
            }
        });
    }
}