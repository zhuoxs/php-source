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
    <title>我的订单-<?php echo $mao['title']?></title>
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
    <div class="fui-page order-list-page fui-page-current">
        <div class="fui-header jb">
            <div class="fui-header-left">
                <a href="/index.php" class="back" style="color: #f7f7f7;"></a>
            </div>
            <div class="title">我的订单</div>
            <div class="fui-header-right" onclick="search()">
                <i class="icon icon-search" style="color: #f7f7f7;"></i>
            </div>
        </div>
        <div class="fui-tab fui-tab-danger">
            <a href="index.php?mod=1" class="external <?php if($mod == "" || $mod == null || $mod == "1"){echo'active';}?>">全部订单</a>
            <a href="index.php?mod=2" class="external <?php if($mod == "2"){echo'active';}?>">等待处理</a>
            <a href="index.php?mod=3" class="external <?php if($mod == "3"){echo'active';}?>">处理完成</a>
            <a href="index.php?mod=4" class="external <?php if($mod == "4"){echo'active';}?>">处理失败</a>
        </div>
        <div class="fui-content navbar order-list">
            <div id="list">
            </div>
            <div class="fui-content-inner" id="page">
            </div>
        </div>
    </div>
    <div class="fui-navbar">
        <a href="/user/index.php" class="external nav-item active">
            <span class="icon icon-daifukuan1"></span>
            <span class="label">我的订单</span>
        </a>
        <a href="/user/feedback.php" class="external nav-item ">
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
        list(<?php echo $mod?>);
    });
    function list(id) {
        $("#list").html(loading);
        Mao.postData('../api/data.php?mod=dd_list&lx=1&type='+id, '', function(d) {
            $("#list").html(d);
            return false
        });
    }
    function page(lx,id,page,search) {
        var loading = layer.load();
        Mao.postData('../api/data.php?mod=dd_list&lx='+lx+'&type='+id+'&page='+page+'&search='+search, '', function(d) {
            layer.close(loading);
            $("#list").append(d);
            return false
        });
    }
    function search() {
        layer.prompt({title: '搜索订单号', formType: 0}, function(ddh, index){
            var loading = layer.load();
            Mao.postData('../api/data.php?mod=dd_list&lx=2&search='+ddh+'', '', function(d) {
                layer["closeAll"]();
                $("#list").html(d);
                return false
            });
        });
    }
</script>
</body>
</html>
