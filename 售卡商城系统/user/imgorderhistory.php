<?php
require '../Mao/common.php';
if($_SESSION['Mao_login']==1){}else exit("<script language='javascript'>window.location.href='/login.php';</script>");
$ddh = isset($_GET['ddh']) ? $_GET['ddh'] :null;
$cha_1 = $DB->get_row("select * from mao_dindan where M_id='{$mao['id']}' and (sjh='{$_SESSION['user']}' && ddh='{$ddh}') limit 1");
//$cha_2 = $DB->get_row("select * from mao_shop where M_id='{$mao['id']}' and id='{$cha_1['M_sp']}' limit 1");
if(!$cha_1 || $cha_1['zt'] != 2){
    sysmsg("订单不存在！");
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0 user-scalable=no">
    <meta name="format-detection" content="telephone=no">
    <title><?php echo $cha_1['name']?>-<?php echo $mao['title']?></title>
    <link rel="stylesheet" type="text/css" href="/Mao_Public/css/Mao.min.css">
    <link rel="stylesheet" type="text/css" href="/Mao_Public/css/style.css">
    <link rel="stylesheet" type="text/css" href="/Mao_Public/css/Mao.diy.css">
    <link rel="stylesheet" type="text/css" href="/Mao_Public/css/iconfont.css">
    <link rel="stylesheet" type="text/css" href="/Mao_Public/css/orderdetail.css">
    <link rel="stylesheet" href="/Mao_Public/layui/css/layui.css">
    <script src="/Mao_Public/js/jquery-2.1.1.min.js"></script>
    <script src="/Mao_Public/layer/layer.js"></script>
    <script src="/Mao_Public/js/Mao.js"></script>
</head>
<body>
<div class="fui-page cav order_detail fui-page-current">
    <div class="fui-header jb">
        <div class="fui-header-left">
            <a onclick="goBack()" class="back" style="color: #f7f7f7;"></a>
        </div>
        <div class="title">物流信息</div>
        <div class="fui-header-right">
        </div>
    </div>
    <div class="fui-content navbar" style="bottom: 0rem;padding-bottom: 0rem;">
        <div class="order_detail_header">
            <div class="order_detail_ststus">
                <div style="font-size: 0.85rem;">
                    交易快照
                </div>
                <div>订单金额： ¥ <?php echo $cha_1['price']?></div>
            </div>
        </div>
        <div class="fui-cell-group noborder order-info">
            <div class="fui-cell">
                <div class="fui-cell-info">
                    <span style="margin-right: 0.7rem;">订单名称</span>
                </div>
                <div class="fui-cell-remark noremark">
                    <?php echo $cha_1['name']?>
                </div>
            </div>
            <div class="fui-cell">
                <div class="fui-cell-info">
                    <span style="margin-right:0.7rem;">创建时间</span>
                </div>
                <div class="fui-cell-remark noremark">
                    <?php echo $cha_1['time']?>
                </div>
            </div>
            <div class="fui-cell">
                <div class="fui-cell-info">
                    <span style="margin-right:0.7rem;">收件人</span>
                </div>
                <div class="fui-cell-remark noremark">
                    <?php echo $cha_1['xm']?>
                </div>
            </div>
            <div class="fui-cell">
                <div class="fui-cell-info">
                    <span style="margin-right:0.7rem;">联系电话</span>
                </div>
                <div class="fui-cell-remark noremark">
                    <?php echo $cha_1['sjh']?>
                </div>
            </div>
            <div class="fui-cell">
                <div class="fui-cell-info">
                    <span style="margin-right:0.7rem;">收货地址</span>
                </div>
                <div class="fui-cell-remark noremark">
                    <?php echo $cha_1['dz']?>,<?php echo $cha_1['xxdz']?>
                </div>
            </div>
        </div>
        <div class="fui-cell-group noborder order-info">
            <div class="fui-cell">
                <div class="fui-cell-info">
                    <span style="margin-right: 0.7rem;">物流公司</span>
                </div>
                <div class="fui-cell-remark noremark">
                    <?php echo $cha_1['kdgs']?>
                </div>
            </div>
            <div class="fui-cell">
                <div class="fui-cell-info">
                    <span style="margin-right:0.7rem;">运单号</span>
                </div>
                <div class="fui-cell-remark noremark">
                    <?php echo $cha_1['ydh']?>
                </div>
            </div>
        </div>
        <div class="fui-cell-group noborder order-info">
            <div class="fui-cell">
                <div class="fui-cell-info">
                    <span style="margin-right:0.7rem;">物流信息</span>
                </div>
                <div class="fui-cell-remark noremark">
                    <span onclick="wl()">更新</span>
                </div>
            </div>
            <hr>
            <div class="fui-cell">
                <ul class="layui-timeline" id="wl">
                </ul>
            </div>
        </div>
    </div>
</div>
<script>
    $(function() {
        $.ajax({
            url: '../api/api.php',
            type: 'POST',
            dataType: 'json',
            data: {mod: "cxwuliu", ddh: "<?php echo $cha_1['ddh']?>"},
            success: function (a) {
                if (a.code == 'OK') {
                    $.each(a.list, function(i, item) {
                        $('#wl').append('<li class="layui-timeline-item">\n' +
                            '                        <i class="layui-icon layui-timeline-axis">&#xe63f;</i>\n' +
                            '                        <div class="layui-timeline-content layui-text">\n' +
                            '                            <h3 class="layui-timeline-title">'+item.time+'</h3>\n' +
                            '                            <p>\n' +
                            '                                '+item.content+'\n' +
                            '                            </p>\n' +
                            '                        </div>\n' +
                            '                    </li>');
                    });
                } else if(a.code == -3){
                    wl();
                } else {
                    $('#wl').html('<div class="infinite-loading"><span class="text">物流信息更新失败！</span></div>');
                }
            },
            error: function() {
                layer.msg('~获取物流信息失败！', {icon: 5});
            }
        });
    });
    function wl() {
        var loading = layer.load();
        $.ajax({
            url: '../api/api.php',
            type: 'POST',
            dataType: 'json',
            data: {mod: "wuliu", ddh: "<?php echo $cha_1['ddh']?>"},
            success: function (a) {
                layer.close(loading);
                if (a.code == 0){
                    layer.msg(a.msg, {icon: 6}, function(){
                        location.reload();
                    });
                } else if(a.code == -3){
                    $('#wl').html('<span class="text">物流信息更新失败！</span>');
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