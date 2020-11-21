<?php
/**
 * Created by Boguan.
 * User: leo
 * WebSite: http://www.boguanweb.com
 * Date: 2018-3-29
 * Time: 14:57
 */

namespace app\lib\enum;


class OrderStatusEnum
{
    //支付状态（0待支付1已支付2待收货3已完成4退款

    //待支付
    const UNPAID= 0;

    //已支付
    const PAID= 1;

    //已发货,待收货
    const DELIVERED = 2;

    //已完成
    const COMPLETED = 3;

    //退款
    const REFUND = 4;

}