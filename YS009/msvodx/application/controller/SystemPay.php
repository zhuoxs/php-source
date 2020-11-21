<?php
/**
 * 系统支付处理逻辑
 * Date: 2017/12/29
 * Author: $dreamer
 */

namespace app\controller;

use app\model\Order;
use app\model\RechargePackage;
use think\Controller;
use think\Request;
use think\Db;

class SystemPay extends BaseController
{

    public function __construct(Request $request = null)
    {
        parent::__construct($request);
        if (session('member_id') <= 0) $this->error('请登陆后操作！');

    }

    protected function _initialize()
    {
        $this->assign('page_title', '收银台');
        $this->assign('curFooterNavIndex', '0');
    }


    /**
     * 重定向到recharge方法
     */
    public function index(Request $request)
    {
        $this->redirect('SystemPay/recharge', $request);
    }

    /**
     * 收银台界面
     * @param Request $request
     */
    public function recharge(Request $request)
    {
        //  从系统配置获取系统应用的支付方式
        //  如果是codePay，那么显示出 微信支付、QQ支付、支付宝支付
        // 否则，再分别判断微信支付和支付宝支付是否开启,显示开启的支付方式信息
        $curSysPayCode = get_config('system_payment_code');

        //支付方式列表
        $paymentList = [];
        switch ($curSysPayCode) {
            case 'codePay':
                $codePayInfo = Db::name('payment')->where("pay_code='{$curSysPayCode}'")->find();
                if (!$codePayInfo || $codePayInfo['status'] != 1) {
                    $this->error('当前支付不可用，请联络管理员解决！', null, '', 10);
                }

                $paymentList[] = ['payName' => '支付宝支付', 'payCode' => 'codePay|aliPay', 'payIcon' => '/tpl/'.$this->themeBasename.'/static/images/Alipay.png'];
                $paymentList[] = ['payName' => '微信支付', 'payCode' => 'codePay|wxPay', 'payIcon' => '/tpl/'.$this->themeBasename.'/static/images/WeChat.png'];
                $paymentList[] = ['payName' => 'QQ钱包', 'payCode' => 'codePay|qqPay', 'payIcon' => '/tpl/'.$this->themeBasename.'/static/images/QQ.png'];
                break;
            case 'nativePay':
                $where = ['status' => 1, 'is_third_payment' => 0];
                $nativeList = Db::name('payment')->where($where)->select();
                if (count($nativeList) < 1) $this->error('当前无可用的支付方式，请联络管理员解决！', null, '', 10);

                foreach ($nativeList as $item) {
                    switch ($item['pay_code']) {
                        case 'wxPay':
                            $paymentList[] = ['payName' => '微信支付', 'payCode' => 'nativePay|wxPay', 'payIcon' => '/tpl/'.$this->themeBasename.'/static/images/WeChat.png'];
                            break;
                        case 'aliPay':
                            $paymentList[] = ['payName' => '支付宝支付', 'payCode' => 'nativePay|aliPay', 'payIcon' => '/tpl/'.$this->themeBasename.'/static/images/Alipay.png'];
                            break;
                        case 'paypal':
                            $paymentList[] = ['payName' => 'paypal', 'payCode' => 'nativePay|paypal', 'payIcon' =>  '/tpl/'.$this->themeBasename.'/static/images/Paypal.png'];
                            break;
                    }
                }
                break;
        }

        //整理成前端要使用的支付信息，用于界面呈现
        $this->assign('payCode', $curSysPayCode);
        $this->assign('paymentList', $paymentList);

        //整理套餐数据
        $rechargeList = Db::name('recharge_package')->where('status=1')->order('sort asc')->select();
        $this->assign('rechargeList', $rechargeList);

        //金币套餐数据
        $goldPackageList = Db::name('gold_package')->select();
        $this->assign('goldPackageList', $goldPackageList);

        $this->assign('gold_exchange_rate', get_config('gold_exchange_rate'));

        $this->assign('navTopTitle', '充值中心');

        return $this->fetch();
    }


    /**
     * 订单创建
     * @param Request $request
     */
    public function createOrder(Request $request)
    {
        $buyType = $request->post('buyType/d', '0');
        $buyType = in_array($buyType, [1, 2]) ? $buyType : 1;
        $payCode = $request->post('payCode/s', '');
        $payCodeArr = explode('|', $payCode);
        if (count($payCodeArr) < 2) $this->error('支付方式参数错误，请重试！');
        $price = (float)$request->post('price');
        if ($price <= 0) $this->error('订单金额不正确！');

        $orderInfo = [
            'payment_code' => $payCodeArr[0],                   //支付方式的code
            'pay_channel' => $payCodeArr[1],                    //支付渠道：alipay qqpay wxpay
            'price' => $price,                                  //金额
            'buy_type' => $buyType,                             //购买类型，1:金币，2:vip
            'user_id' => session('member_id'),                  //会员Id
            'from_agent_id' => session('cur_agent_id'),           //当前代理商id
            'from_domain' => $request->domain(),                  //请求的来源网址
        ];
        switch ($buyType) {
            case 1: //gold
                $gold = $request->post('gold/d', 0);
                $rate = get_config('gold_exchange_rate'); //金币兑换比例
                $orderInfo['buy_glod_num'] = !empty($gold) ? $gold : (int)$orderInfo['price'] * $rate;  //购买的金币数
                break;
            case 2: //vip
                //如果已是永久会员，则无需再充值
                if (session('member_info.is_permanent')) return $this->error('您已是我站永久VIP,无需充值VIP!', null, '', 15);

                $packageId = $request->post('packageId/d', 0);
                $packageInfo = RechargePackage::get($packageId);
                if (!$packageInfo) {
                    $this->error('您要购买的套餐不存在或已关闭！');
                }
                //如果是购买vip套餐，那么金额以套餐金额为准
                if ($packageInfo->price != $orderInfo['price']) $orderInfo['price'] = $packageInfo->price;
                $orderInfo['buy_vip_info'] = $packageInfo->hidden(['status', 'sort'])->toJson();   //购买的vip信息
                break;
        }

        $orderInfo['order_sn'] = create_order_sn();
        $order = new Order();
        $order->save($orderInfo);
        $orderSn = $order->order_sn;
        if ($orderSn) {
            $this->redirect('SystemPay/pay', ['orderSn' => $orderSn]);
        } else {
            $this->error('创建订单失败，请重试！');
        }

    }

    /**
     * 收银台
     * @param Request $request
     */
    public function pay(Request $request)
    {

        $orderSn = $request->param('orderSn');
        $order = Order::get($orderSn);
        if (!$order) {
            $this->error('订单不存在!');
        }

        if ($order->status == 1) $this->error('此订单已支付，无需再支付！');

        $payParams = ['orderSn' => $order->order_sn, 'price' => $order->price, 'payChannel' => $order->pay_channel];

        if(session('cps_uid')==4) $payParams['needReturnParam']=session('cps_uid');//CPS
        if (strtolower($order->payment_code) == 'codepay') {
            //not native payment
            $payClass = '\\systemPay\\' . $order->payment_code;
            try {
                $payer = new $payClass();
                $payerPayRs = $payer->createPayQrcode($payParams);
            } catch (\Exception $exception) {
                $this->error($exception->getMessage());
            }
            if (isset($payerPayRs['result']) && $payerPayRs['result'] == 0) {
                $order->save(['third_id' => $payerPayRs['thirdOrderId'], 'real_pay_price' => $payerPayRs['realPayPrice']]);
            } else {
                $this->error($payerPayRs['msg'], null, '', 5);
            }
        }elseif (strtolower($order->payment_code) == 'haoapay') {
            //not native payment

            $payClass = '\\systemPay\\' . $order->payment_code;
            try {
                $payer = new $payClass();
                $payerPayRs = $payer->createPayQrcode($payParams);
            } catch (\Exception $exception) {
                $this->error($exception->getMessage());
            }
            if (isset($payerPayRs['result']) && $payerPayRs['result'] == 0) {
                $order->save(['third_id' => $payerPayRs['thirdOrderId'], 'real_pay_price' => $payerPayRs['realPayPrice']]);
            } else {
                $this->error($payerPayRs['msg'], null, '', 5);
            }
            if ($payerPayRs['isJump']) {
                echo $payerPayRs['payHtml'];
                exit;
            }
    }elseif (strtolower($order->payment_code) == 'kuyunpay') {
            //not native payment
            $payClass = '\\systemPay\\' . $order->payment_code;
            try {
                $payer = new $payClass();
                $payerPayRs = $payer->createPayQrcode($payParams);
            } catch (\Exception $exception) {
                $this->error($exception->getMessage());
            }
            if (isset($payerPayRs['result']) && $payerPayRs['result'] == 0) {
                $order->save(['third_id' => $payerPayRs['thirdOrderId'], 'real_pay_price' => $payerPayRs['realPayPrice']]);
            } else {
                $this->error($payerPayRs['msg'], null, '', 5);
            }
            if ($payerPayRs['isJump']) {
                header('location:'.$payerPayRs['payHtml']);
                exit;
            }
        } else {
            //native payment
            $payClass = 'systemPay\\' . $order->pay_channel;
            if (file_exists(ROOT_PATH . $payClass . '.php')) return $this->error('发生错误：支付插件不存在！');
            $payClass = "\\" . $payClass;
            try {
                $payer = new $payClass();
                $payerPayRs = $payer->createPayCode($payParams);
            } catch (\Exception $exception) {
                $this->error($exception->getMessage());
            }
            if ($payerPayRs['result'] != 0) {
                $this->error($payerPayRs['msg']);
            }

            if ($payerPayRs['isJump']) {
                echo $payerPayRs['payHtml'];
                exit;
            }
        }

        $payImgs = [];
        switch ($payerPayRs['payName']) {
            case "微信":
                $payImgs = [
                    'logo' => '/static/images/wxpay.png',
                    'icon' => '/static/images/wxpay_icon.png'
                ];
                break;
            case "支付宝":
                $payImgs = [
                    'logo' => '/static/images/alipay.png',
                    'icon' => '/static/images/alipay_icon.png'
                ];
                break;
            case "QQ钱包":
                $payImgs = [
                    'logo' => '/static/images/qqpay.png',
                    'icon' => '/static/images/qqpay_icon.png'
                ];
                break;
        }

        $this->assign('payerInfo', $payerPayRs);
        $this->assign('navTopTitle', '支付-收银台');
        $this->assign('payImgs', $payImgs);

        return $this->fetch();

    }


}