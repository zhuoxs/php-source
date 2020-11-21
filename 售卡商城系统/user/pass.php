<?php
require '../Mao/common.php';
if($_SESSION['Mao_login']==1){}else exit("<script language='javascript'>window.location.href='/login.php';</script>");
?>
<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0 user-scalable=no">
    <meta name="format-detection" content="telephone=no">
    <title>密码修改-<?php echo $mao['title']?></title>
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
    <div class="fui-page fui-page-current order-pay-page">
        <div class="fui-header jb">
            <div class="fui-header-left">
                <a onclick="goBack()" class="back" style="color: #f7f7f7;"></a>
            </div>
            <div class="title">密码修改</div>
            <div class="fui-header-right">
            </div>
        </div>
        <div class="fui-content navbar">
            <div class="fui-cell-group">
                <div class="fui-cell">
                    <div class="fui-cell-label">登陆密码</div>
                    <div class="fui-cell-info c000">
                        <input type="text" class="fui-input" id="pass" placeholder="请输入需要修改的密码">
                    </div>
                </div>
            </div>
            <div class="fui-cell-group fui-cell-click transparent">
                <a class="fui-cell external changepwd" onclick="set()">
                    <div class="fui-cell-text" style="text-align: center;">
                        <p>修改密码</p>
                    </div>
                </a>
                <a class="fui-cell external btn-logout" onclick="logout()">
                    <div class="fui-cell-text" style="text-align: center;">
                        <p>退出登录</p>
                    </div>
                </a>
            </div>
        </div>
    </div>
    <div class="fui-navbar">
        <a href="/user/index.php" class="external nav-item ">
            <span class="icon icon-daifukuan1"></span>
            <span class="label">我的订单</span>
        </a>
        <a href="/user/feedback.php" class="external nav-item ">
            <span class="icon icon-list"></span>
            <span class="label">我的工单</span>
        </a>
        <a href="/user/pass.php" class="external nav-item active">
            <span class="icon icon-shezhi"></span>
            <span class="label">密码修改</span>
        </a>
    </div>
</div>
<script>
    function set() {
        var loading = layer.load();
        $.ajax({
            url: '/api/api.php',
            type: 'POST',
            dataType: 'json',
            data: {mod: "set", pass: $('#pass').val()},
            success: function (a) {
                layer.close(loading);
                if (a.code == 0) {
                    layer.msg(a.msg);
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
