<?php
//合作身份者id，以2088开头的16位纯数字
$alipay_config['partner'] = $setting['ALIPAY_PARTNER'];

//安全检验码，以数字和字母组成的32位字符
$alipay_config['key'] = $setting['ALIPAY_KEY'];

//卖家支付宝帐户
$seller_email = $setting['ALIPAY_SELLER_EMAIL'];
//收货人名称
$receive_name = $setting['ALIPAY_MAINNAME'];

$alipay_config['transport']    = 'http';

//收货人手机号码
$receive_mobile = '';

//订单名称 ,必填
$subject = '充值';

//支付类型,必填，不能修改
$payment_type = "1";
//签名方式 不需修改
$alipay_config['sign_type']    = strtoupper('MD5');

//字符编码格式 目前支持 gbk 或 utf-8
$alipay_config['input_charset']= strtolower('utf-8');

//ca证书路径地址，用于curl中ssl校验
//请保证cacert.pem文件在当前文件夹目录中
$alipay_config['cacert']    = getcwd().'/cacert.pem';

//商品数量,必填，建议默认为1，不改变值，把一次交易看成是一次下订单而非购买一件商品
$quantity = "1";
//物流费用,必填，即运费
$logistics_fee = "0.00";
//物流类型,必填，三个值可选：EXPRESS（快递）、POST（平邮）、EMS（EMS）
$logistics_type = "EXPRESS";
//物流支付方式,必填，两个值可选：SELLER_PAY（卖家承担运费）、BUYER_PAY（买家承担运费）
$logistics_payment = "SELLER_PAY";

$body = '自动充值';

//商品展示地址
$show_url = '';

//收货人地址
$receive_address = '';

//收货人邮编
$receive_zip = '';

//收货人电话号码
$receive_phone = '';
?>