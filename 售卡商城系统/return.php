<?php
require './Mao/common.php';
ksort($_GET); //排序post参数
reset($_GET); //内部指针指向数组中的第一个元素

if($mao['yzf_type'] == 1){
    $key = $mao_zz['mzf_key'];
}else{
    $key = $mao['mzf_key'];
}

$codepay_key = $key; //这是您的密钥
$sign = '';//初始化
foreach ($_GET AS $key => $val) { //遍历POST参数
    if ($val == '' || $key == 'sign') continue; //跳过这些不签名
    if ($sign) $sign .= '&'; //第一个字符串签名不加& 其他加&连接起来参数
    $sign .= "$key=$val"; //拼接为url参数形式
}
if (!$_GET['pay_no'] || md5($sign . $codepay_key) != $_GET['sign']) { //不合法的数据
    sysmsg('[fail]支付异常！<a href="/index.php">返回</a>');
} else { //合法的数据
    $pay_id = $_GET['pay_id']; //需要充值的ID 或订单号 或用户名
    $money = (float)$_GET['money']; //实际付款金额
    $price = (float)$_GET['price']; //订单的原价
    $param = $_GET['param']; //自定义参数
    $pay_no = $_GET['pay_no']; //流水号
    $shop = $DB->get_row("SELECT * FROM mao_dindan WHERE M_id='{$mao['id']}' and ddh='{$pay_id}' limit 1");
    $cha_1 = $DB->get_row("select * from mao_shop where M_id='{$mao['id']}' and id='{$shop['M_sp']}' limit 1");
    if($pay_no != "" || $pay_no != null){
        if(!$shop){
            sysmsg('订单号不存在.请返回重新发起支付！<a href="/index.php">返回</a>');
        }elseif($shop['zt'] == 0 || $shop['zt'] == 2 || $shop['zt'] == 3){
            sysmsg('该订单号已完成交易！<a href="/index.php">返回</a>');
        }elseif($cha_1['kucun'] < 1){
            sysmsg('商品库存不足,请联系客服解决！<a href="/index.php">返回</a>');
        }elseif($shop['zt'] == 1){
            $js_1 = ($cha_1['kucun'] - $shop['sl']);
            $js_2 = ($cha_1['xiaoliang'] + $shop['sl']);
            $DB->query("update mao_dindan set zt='0' where M_id='{$mao['id']}' and id='{$shop['id']}'");
            $DB->query("update mao_shop set kucun='{$js_1}',xiaoliang='{$js_2}' where M_id='{$mao['id']}' and id='{$cha_1['id']}'");
            if($mao['dx_1'] == 0){
                $js_1 = ($mao['price'] - 0.01);
                if($mao['price'] >= 0.01 || $mao['sj'] != "" || $mao['sj'] != null){
                    $msg = dx("{$mao['sj']}","3");
                    if($msg == "0"){
                        $DB->query("update mao_data set price='{$js_1}' where id='{$mao['id']}'");
                    }
                }
            }
            if($mao['yzf_type'] == 1){
                $js_3 = ($mao['price'] + $shop['price']);
                $DB->query("update mao_data set price='{$js_3}' where id='{$mao['id']}'");
            }
            sysmsg('[success]交易成功！<a href="/index.php">返回</a>');
        }else{
            sysmsg('订单出错！<a href="/index.php">返回</a>');
        }
    }else{
        sysmsg('[fail]支付异常,请联系网站客服！<a href="/index.php">返回</a>');
    }
}