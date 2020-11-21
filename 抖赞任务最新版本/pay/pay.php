<?php
/**
 * ---------------------参数生成页-------------------------------
 * Author:Leo
 * Project:PaysApi.com
 * 
 * 在您自己的服务器上生成新订单，并把计算好的订单信息传给您的前端网页。
 * 注意：
 * 1.key一定要在服务端计算，不要在网页中计算。
 * 2.token只能存放在服务端，不可以以任何形式存放在网页代码中（可逆加密也不行），也不可以通过url参数方式传入网页。
 * 3.接口跑通后，如果发现收款二维码是我们官方的，请检查APP是否正在运行。为保障您收款功能正常，如果您的收款手机APP掉线超过一分钟，就会触发代收款机制，详情请看网站帮助。
 * --------------------------------------------------------------
 */

    //从网页传入price:支付价格， istype:支付渠道：1-支付宝；2-微信支付
    $price = $_POST["price"];
    $istype = $_POST["istype"];
    
    $orderuid = "username";       //此处传入您网站用户的用户名，方便在paysapi后台查看是谁付的款，强烈建议加上。可忽略。

    //校验传入的表单，确保价格为正常价格（整数，1位小数，2位小数都可以），支付渠道只能是1或者2，orderuid长度不要超过33个中英文字。

    //此处就在您服务器生成新订单，并把创建的订单号传入到下面的orderid中。
    $goodsname = "请叫我商品名称，不要超过33个中英文字";
    $orderid = time();    //每次有任何参数变化，订单号就变一个吧。
    $uid = "1117840af25688cca2048996";//"此处填写PaysApi的uid";
    $token = "e9c2b257477c09b47661d41aa9b51d6d";//"此处填写PaysApi的Token";
    $return_url = 'http://zzbang168.com/pay/payreturn.php';
    $notify_url = 'http://zzbang168.com/pay/paynotify.php';
    
    $key = md5($goodsname. $istype . $notify_url . $orderid . $orderuid . $price . $return_url . $token . $uid);
    //经常遇到有研发问为啥key值返回错误，大多数原因：1.参数的排列顺序不对；2.上面的参数少传了，但是这里的key值又带进去计算了，导致服务端key算出来和你的不一样。

    $returndata['goodsname'] = $goodsname;
    $returndata['istype'] = $istype;
    $returndata['key'] = $key;
    $returndata['notify_url'] = $notify_url;
    $returndata['orderid'] = $orderid;
    $returndata['orderuid'] =$orderuid;
    $returndata['price'] = $price;
    $returndata['return_url'] = $return_url;
    $returndata['uid'] = $uid;
    echo jsonSuccess("OK",$returndata,"");


    //返回错误
    function jsonError($message = '',$url=null) 
    {
        $return['msg'] = $message;
        $return['data'] = '';
        $return['code'] = -1;
        $return['url'] = $url;
        return json_encode($return);
    }

    //返回正确
    function jsonSuccess($message = '',$data = '',$url=null) 
    {
        $return['msg']  = $message;
        $return['data'] = $data;
        $return['code'] = 1;
        $return['url'] = $url;
        return json_encode($return);
    }

?>