<?php

namespace app\admin\controller;

use app\common\controller\Backend;
use think\Config;
use think\Db;
/**
 * 控制台
 *
 * @icon fa fa-dashboard
 * @remark 用于展示当前系统中的统计数据、统计报表及重要实时数据
 */
class Dashboard extends Backend
{

    /**
     * 查看
     */
    public function index()
    {


        $where = array('uniacid'=>$GLOBALS['fuid']);

        //用户统计 统计数量
        $totaluser = Db::name('users')->where($where)->count();

        //订单统计
        $totalorder         = Db::name('order')->where($where)->count();
        $totalOrderPay      = Db::name('order')->where(array_merge($where,['status'=> ['not in','6,7']]))->sum('real_price');
        $weekOrder          = Db::name('order')->whereTime('create_time', 'week')->count();


        //订单数据
        $paylist = $createlist = [];
        $n = 30;
        for ($i = 0; $i <= 30; $i++)
        {
            $day = date("m月d",strtotime('-'.($n-$i).' day'));
            $days = date("Y-m-d",strtotime('-'.($n-$i).' day'));

            $daymin = strtotime($days);
            $daymax = strtotime('+1 day',$daymin);

            //订单总数
            $createlist[$day] = Db::name('order')
                ->where($where)
                ->where('create_time','between time',[$daymin,$daymax])
                ->count();

            //付款订单数
            $paylist[$day] = Db::name('order')
                ->where(array_merge($where,['status'=>['not in',"6,7"] ]))
                ->where('create_time','between time',[$daymin,$daymax])
                ->count();

        }



        $this->view->assign([
            'totaluser'        => $totaluser,
            'totalOrderPay'    => $totalOrderPay,
            'totalorder'       => $totalorder,
            'weekOrder'        => $weekOrder,
            'paylist'          => $paylist,
            'createlist'       => $createlist,
        ]);

        return $this->view->fetch();
    }


}
