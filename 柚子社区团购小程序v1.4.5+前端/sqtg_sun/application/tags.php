<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006~2018 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------

// 应用行为扩展定义文件
return [
    // 应用初始化
    'app_init'     => [],
    // 应用开始
    'app_begin'    => [],
    // 模块初始化
    'module_init'  => [],
    // 操作开始执行
    'action_begin' => [],
    // 视图内容过滤
    'view_filter'  => [],
    // 日志写入
    'log_write'    => [],
    // 应用结束
    'app_end'      => [],

//    订单
    'on_order_add'=>[//下单
        ['app\model\Usercoupon','onOrderAdd'],
        ['app\model\User','onOrderAdd'],
    ],
    'on_order_pay'=>[//支付
        'app\model\User',
        'app\model\Goods',
        'app\model\Ordergoods',
//        'app\model\Dingtalk',
//        'app\model\Sms',
        'app\model\Task',
        'app\model\Order',
    ],
    'on_order_pay_done'=>[
        ['app\model\Dingtalk','onOrderPay'],
        ['app\model\Sms','onOrderPay']
    ],
//    'on_order_finish'=>[
//        'app\model\Leaderbill',
//        'app\model\Mercapdetails',
//    ],
    'on_order_finish'=>[
//        ['app\model\Leaderbill','onOrderFinish'],
//        ['app\model\Mercapdetails','onOrderFinish'],
    ],
    'on_order_cancel'=>[//取消
        'app\model\Ordergoods',
    ],
//    订单商品
    'on_ordergoods_added'=>[//下单
        'app\model\Distributionrecord',
    ],
    'on_ordergoods_receive'=>[//团长收货
        ['app\model\Order','onOrdergoodsReceive'],
        ['app\model\Task','onOrdergoodsReceive'],
    ],
    'on_ordergoods_confirm'=>[//团长核销
        ['app\model\Order','onOrdergoodsConfirm'],
        ['app\model\Leaderbill','onOrdergoodsFinish'],
        ['app\model\Distributionrecord','onOrdergoodsFinish'],
        ['app\model\Mercapdetails','onOrdergoodsFinish'],
    ],
    'on_ordergoods_receive2'=>[//配送类订单，收货
        ['app\model\Order','onOrdergoodsReceive2'],
        ['app\model\Leaderbill','onOrdergoodsFinish'],
        ['app\model\Distributionrecord','onOrdergoodsFinish'],
        ['app\model\Mercapdetails','onOrdergoodsFinish'],
    ],
    'on_ordergoods_refund'=>[//退款
        ['app\model\Order','onOrdergoodsRefund'],
        ['app\model\Goods','onOrdergoodsRefund'],
        ['app\model\Task','onOrdergoodsRefund'],
    ],
    'on_ordergoods_refunderror'=>[//退款
        ['app\model\Task','onOrdergoodsRefunderror'],
    ],
//  拼团订单
    'on_pingorder_receive'=>[///配送类订单，收货
        ['app\model\Leaderbill','onPingorderReceive'],
        ['app\model\Mercapdetails','onPingoodsFinish'],
//        ['app\model\Task','onPinorderReceive']
    ],
    'on_pinorder_pay'=>[
        ['app\model\Sms','onPinorderPay'],
        ['app\model\Pinorder', 'onPinorderPay'],
        ['app\model\Dingtalk', 'onPinorderPay'],
        ['app\model\Task','onPinorderPay'],
    ],
    'on_leader_receive'=>[//团长收货
        ['app\model\Task','onPinorderReceive'],
    ],
//    优惠券
    'on_usercoupon_add'=>[//领取
        'app\model\Coupon',
    ],
//    商户
    'on_store_add'=>[//申请
        'app\model\Dingtalk',
    ],
    'on_store_checked'=>[//审核
        'app\model\Storeleader',
    ],
    'on_store_deleted'=>[//删除
        'app\model\Storeleader',
    ],
//    团长
    'on_leader_add'=>[//申请
        'app\model\Dingtalk',
    ],
    'on_leader_checked'=>[//审核
        'app\model\Storeleader',
    ],
    'on_leader_deleted'=>[//删除
        'app\model\Storeleader',
    ],
//    团长账单
    'on_leaderbill_add'=>[
        'app\model\Leader',
    ],
    'on_leaderbill_delete'=>[
        'app\model\Leader',
    ],
//    分佣明细
    'on_distributionrecord_finish'=>[
        ['app\model\Distribution','onDistributionrecordFinish'],
        ['app\model\Task','onDistributionrecordFinish'],
    ],
//    分销提现
    'on_distributionwithdraw_add'=>[//申请
        'app\model\Distribution'
    ],
    'on_distributionwithdraw_fail'=>[//提现失败
        'app\model\Distribution'
    ],
    'on_distributionwithdraw_success'=>[//提现成功
        'app\model\Distribution'
    ],
    'on_recharge_finish'=>[
        'app\model\Userbalancerecord'
    ]
];
