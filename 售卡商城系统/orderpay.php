<?php
require './Mao/common.php';
$cha_1 = $DB->get_row("select * from mao_dindan where M_id='{$mao['id']}' and ddh='{$_SESSION['ddh']}' limit 1");
if(!$cha_1 || $cha_1['zt'] != 1){
    sysmsg("订单不存在！");
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0 user-scalable=no">
    <meta name="format-detection" content="telephone=no">
    <title>收银台-<?php echo $mao['title']?></title>
    <link rel="stylesheet" type="text/css" href="/Mao_Public/css/Mao.min.css">
    <link rel="stylesheet" type="text/css" href="/Mao_Public/css/style.css">
    <link rel="stylesheet" type="text/css" href="/Mao_Public/css/Mao.diy.css">
    <link rel="stylesheet" type="text/css" href="/Mao_Public/css/iconfont.css">
    <script src="/Mao_Public/js/jquery-2.1.1.min.js"></script>
    <script src="/Mao_Public/layer/layer.js"></script>
    <script src="/Mao_Public/js/Mao.js"></script>
</head>
<body>
<div class="fui-page-group statusbar">
    <div class="fui-page  fui-page-current order-pay-page">
        <div class="fui-header jb">
            <div class="fui-header-left">
                <a onclick="goBack()" class="back" style="color: #f7f7f7;"></a>
            </div>
            <div class="title">收银台</div>
            <div class="fui-header-right">
            </div>
        </div>
        <div class="fui-content" style="bottom: 0rem;padding-bottom: 0rem;">
            <div class="fui-cell-group" style="margin-top: 0">
                <div class="fui-cell">
                    <div class="fui-cell-label">商品名称</div>
                    <div class="fui-cell-info"></div>
                    <div class="fui-cell-remark noremark" style="overflow: hidden;text-overflow:ellipsis;white-space: nowrap;"><?php echo $cha_1['name']?></div>
                </div>
                <div class="fui-cell">
                    <div class="fui-cell-label">订单编号</div>
                    <div class="fui-cell-info"></div>
                    <div class="fui-cell-remark noremark"><?php echo $cha_1['ddh']?></div>
                </div>
                <div class="fui-cell">
                    <div class="fui-cell-label">购买数量</div>
                    <div class="fui-cell-info"></div>
                    <div class="fui-cell-remark noremark"><?php echo $cha_1['sl']?></div>
                </div>
                <div class="fui-cell">
                    <div class="fui-cell-label">商品单价</div>
                    <div class="fui-cell-info"></div>
                    <div class="fui-cell-remark noremark"><span class="text-danger bigprice">￥<?php echo $cha_1['dj_price']?></span>
                    </div>
                </div>
                <div class="fui-cell">
                    <div class="fui-cell-label">商品运费</div>
                    <div class="fui-cell-info"></div>
                    <div class="fui-cell-remark noremark"><span class="text-danger bigprice">￥<?php echo $cha_1['yf_price']?></span>
                    </div>
                </div>
                <div class="fui-cell">
                    <div class="fui-cell-label">需支付</div>
                    <div class="fui-cell-info"></div>
                    <div class="fui-cell-remark noremark"><span class="text-danger bigprice" style="font-size: 1.4rem;">￥<?php echo $cha_1['price']?></span>
                    </div>
                </div>
            </div>
            ​<div class="fui-list-group" style="margin-top:-15px;">
                <?php
                if($mao['yzf_type'] == 1){//跟随系统
                    if($mao_zz['zfb_zf'] == 0){
                        ?>
                        <div class="fui-list pay-btn" onclick="pay(3)">
                            <div class="fui-list-media">
                                <img src="/Mao_Public/img/zfb.png" alt="">
                            </div>
                            <div class="fui-list-inner">
                                <div class="title">
                                    支付宝扫码支付
                                </div>
                                <div class="subtitle c999 f24">
                                    <img src="/Mao_Public/img/safe.png" alt="" style="height: .8rem;vertical-align: text-bottom">支付宝安全支付
                                </div>
                            </div>
                            <div class="fui-list-angle"><span class="angle"></span></div>
                        </div>
                        <?php
                    }
                    if($mao_zz['qq_zf'] == 0){
                        ?>
                        <div class="fui-list pay-btn" onclick="pay(1)">
                            <div class="fui-list-media">
                                <img src="/Mao_Public/img/qq.png" alt="">
                            </div>
                            <div class="fui-list-inner">
                                <div class="title">
                                    QQ扫码支付
                                </div>
                                <div class="subtitle c999 f24">
                                    <img src="/Mao_Public/img/safe.png" alt="" style="height: .8rem;vertical-align: text-bottom">QQ安全支付
                                </div>
                            </div>
                            <div class="fui-list-angle"><span class="angle"></span></div>
                        </div>
                        <?php
                    }
                    if($mao_zz['wx_zf'] == 0){
                        ?>
                        <div class="fui-list pay-btn" onclick="pay(2)">
                            <div class="fui-list-media">
                                <img src="/Mao_Public/img/wx.png" alt="">
                            </div>
                            <div class="fui-list-inner">
                                <div class="title">
                                    微信扫码支付
                                </div>
                                <div class="subtitle c999 f24">
                                    <img src="/Mao_Public/img/safe.png" alt="" style="height: .8rem;vertical-align: text-bottom">微信安全支付
                                </div>
                            </div>
                            <div class="fui-list-angle"><span class="angle"></span></div>
                        </div>
                        <?php
                    }
                }else{
                    if($mao['zfb_zf'] == 0){
                        ?>
                        <div class="fui-list pay-btn" onclick="pay(3)">
                            <div class="fui-list-media">
                                <img src="/Mao_Public/img/zfb.png" alt="">
                            </div>
                            <div class="fui-list-inner">
                                <div class="title">
                                    支付宝扫码支付
                                </div>
                                <div class="subtitle c999 f24">
                                    <img src="/Mao_Public/img/safe.png" alt="" style="height: .8rem;vertical-align: text-bottom">支付宝安全支付
                                </div>
                            </div>
                            <div class="fui-list-angle"><span class="angle"></span></div>
                        </div>
                        <?php
                    }
                    if($mao['qq_zf'] == 0){
                        ?>
                        <div class="fui-list pay-btn" onclick="pay(1)">
                            <div class="fui-list-media">
                                <img src="/Mao_Public/img/qq.png" alt="">
                            </div>
                            <div class="fui-list-inner">
                                <div class="title">
                                    QQ扫码支付
                                </div>
                                <div class="subtitle c999 f24">
                                    <img src="/Mao_Public/img/safe.png" alt="" style="height: .8rem;vertical-align: text-bottom">QQ安全支付
                                </div>
                            </div>
                            <div class="fui-list-angle"><span class="angle"></span></div>
                        </div>
                        <?php
                    }
                    if($mao['wx_zf'] == 0){
                        ?>
                        <div class="fui-list pay-btn" onclick="pay(2)">
                            <div class="fui-list-media">
                                <img src="/Mao_Public/img/wx.png" alt="">
                            </div>
                            <div class="fui-list-inner">
                                <div class="title">
                                    微信扫码支付
                                </div>
                                <div class="subtitle c999 f24">
                                    <img src="/Mao_Public/img/safe.png" alt="" style="height: .8rem;vertical-align: text-bottom">微信安全支付
                                </div>
                            </div>
                            <div class="fui-list-angle"><span class="angle"></span></div>
                        </div>
                        <?php
                    }
                }
                ?>
            </div>
        </div>
    </div>
</div>
<script>
    function pay(type) {
        var loading = layer.msg('正在转跳到支付.请稍后...', {icon: 16,shade: 0, time: 0});
        $.ajax({
            url: '../api/api.php',
            type: 'POST',
            dataType: 'json',
            data: {mod: "pay", type: type, ddh: "<?php echo $cha_1['ddh']?>"},
            success: function (a) {
                layer.close(loading);
                if (a.code == 0){
                    layer.msg(a.msg, {icon: 6}, function(){
                        window.location.href = "/index.php";
                    });
                } else if(a.code == 1){
                    window.location.href = "../api/pay_1.php?type=" + a.type + "&ddh=" + a.ddh + "";
                } else if(a.code == 2){
                    window.location.href = "../api/pay_2.php?type=" + a.type + "&ddh=" + a.ddh + "";
                } else {
                    layer.msg(a.msg);
                }
            },
            error: function() {
                layer.close(loading);
                layer.msg('~连接服务器失败！', {icon: 5});
            }
        });
    }
</script>
</body>
</html>
