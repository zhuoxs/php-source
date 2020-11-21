<?php
require '../Mao/common.php';
if($_SESSION['Mao_login']==1){}else exit("<script language='javascript'>window.location.href='/login.php';</script>");
$mod = isset($_GET['mod']) ? $_GET['mod'] :1;
?>
<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0 user-scalable=no">
    <meta name="format-detection" content="telephone=no">
    <title>我的工单-<?php echo $mao['title']?></title>
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
    <style>
        .fui-list-inner .text {
            color: #999;
            font-size: .6rem;
        }
        .fui-list {
            background: #fff;
        }
    </style>
    <div class="fui-page  fui-page-current member-log-page">

        <div class="fui-header jb">
            <div class="fui-header-left">
                <a href="/index.php" class="back" style="color: #f7f7f7;"></a>
            </div>
            <div class="title">我的工单</div>
            <div class="fui-header-right">
            </div>
        </div>
        <div class="fui-content navbar">
            <div class="fui-list-group container" style="background: rgb(243, 243, 243); display: block; margin-top: 0rem;" id="list">
            </div>
            <br><div id="page"></div>
        </div>
    </div>
    <div class="fui-navbar">
        <a href="/user/index.php" class="external nav-item ">
            <span class="icon icon-daifukuan1"></span>
            <span class="label">我的订单</span>
        </a>
        <a href="/user/feedback.php" class="external nav-item active">
            <span class="icon icon-list"></span>
            <span class="label">我的工单</span>
        </a>
        <a href="/user/pass.php" class="external nav-item ">
            <span class="icon icon-shezhi"></span>
            <span class="label">密码修改</span>
        </a>
    </div>
</div>
<script>
    var loading = '<div class="infinite-loading"><span class="fui-preloader"></span><span class="text"> 正在加载...</span></div>';
    $(function() {
        list();
    });
    function list() {
        $("#list").html(loading);
        Mao.postData('../api/data.php?mod=gd_list', '', function(d) {
            $("#list").html(d);
            return false
        });
    }
    function page(page) {
        var loading = layer.load();
        Mao.postData('../api/data.php?mod=gd_list&page='+page, '', function(d) {
            layer.close(loading);
            $("#list").append(d);
            return false
        });
    }
</script>
</body>
</html>
