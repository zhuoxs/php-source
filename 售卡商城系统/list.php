<?php
require './Mao/common.php';
$mod = isset($_GET['mod']) ? $_GET['mod'] : 0;
if($mod == 0){
    $title = '全部商品';
}
elseif($mod == 1){
    $title = '中国电信';
}
elseif($mod == 2){
    $title = '中国移动';
}
elseif($mod == 3){
    $title = '中国联通';
}
elseif($mod == 4){
    $title = '站长推荐';
}
else{
    sysmsg("分类不存在！");
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0 user-scalable=no">
    <meta name="format-detection" content="telephone=no">
    <title><?php echo $mao['title']?></title>
    <link rel="stylesheet" type="text/css" href="/Mao_Public/css/Mao.min.css">
    <link rel="stylesheet" type="text/css" href="/Mao_Public/css/style.css">
    <link rel="stylesheet" type="text/css" href="/Mao_Public/css/Mao.diy.css">
    <link rel="stylesheet" type="text/css" href="/Mao_Public/css/iconfont.css">
    <script src="/Mao_Public/js/jquery-2.1.1.min.js"></script>
    <script src="/Mao_Public/layer/layer.js"></script>
    <script src="/Mao_Public/js/Mao.js"></script>
</head>
<body>
<div class="fui-page-group">
    <div class="fui-page  fui-page-current " style="top: 0; background-color: #fafafa;">
        <div class="fui-header jb">
            <div class="fui-header-left">
                <a onclick="goBack()" class="back" style="color: #f7f7f7;"></a>
            </div>
            <div class="title"><?php echo $title?></div>
            <div class="fui-header-right" onclick="search()">
                <i class="icon icon-search" style="color: #f7f7f7;"></i>
            </div>
        </div>
        <div class="fui-content navbar" style="background-color: #f3f3f3; padding-bottom: 0;">
            <div class="fui-notice" style="background: #ffffff; border-color: ; margin-bottom: 0px;" data-speed="4">
                <div class="icon">
                    <i class="icon icon-notification1" style="font-size: 0.7rem; color: #fd5454;"></i>
                </div>
                <div class="text" style="color: #666666;">
                    <ul>
                        <li>
                            <a href="javascript:;" style="color: #666666;" data-nocache="true">
                                <marquee behavior="scroll" scrolldelay="100" scrollamount="5">
                                    <?php echo $mao['gd_gg']?>
                                </marquee>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="fui-cell-group">
                <div class="fui-cell">
                    <div class="fui-cell-info" style="border-left: 5px solid #00beda;padding-left: 5px;">
                        商品列表
                        <span style="float:right" id="ts"></span>
                    </div>
                </div>
                <hr>
                <div class="fui-goods-group block three" style="background: ;" id="shop_list">
                </div>
                <div id="page"></div>
            </div>
        </div>
    </div>
    <div class="fui-navbar">
        <a href="index.php" class="external nav-item ">
            <span class="icon icon-home"></span>
            <span class="label">首页</span>
        </a>
        <a href="list.php" class="external nav-item active">
            <span class="icon icon-list"></span>
            <span class="label">全部商品</span>
        </a>
        <a onclick="kefu()" class="external nav-item ">
            <span class="icon icon-person2"></span>
            <span class="label">联系客服</span>
        </a>
        <a href="/user/index.php" class="external nav-item ">
            <span class="icon icon-daifukuan1"></span>
            <span class="label">订单查询</span>
        </a>
    </div>
</div>
<script>
    var loading = '<div class="infinite-loading"><span class="fui-preloader"></span><span class="text"> 正在加载...</span></div>';
    $(function() {
        list(<?php echo $mod?>);
    });
    function list(id) {
        $("#shop_list").html(loading);
        Mao.postData('../api/data.php?mod=list&lx=1&type='+id, '', function(d) {
            $("#shop_list").html(d);
            return false
        });
    }
    function page(lx,id,page,search) {
        var loading = layer.load();
        Mao.postData('../api/data.php?mod=list&lx='+lx+'&type='+id+'&page='+page+'&search='+search, '', function(d) {
            layer.close(loading);
            $("#shop_list").append(d);
            return false
        });
    }
    function search() {
        layer.prompt({title: '搜索商品', formType: 0}, function(name, index){
            var loading = layer.load();
            Mao.postData('../api/data.php?mod=list&lx=2&search='+name+'', '', function(d) {
                layer["closeAll"]();
                $("#shop_list").html(d);
                return false
            });
        });
    }
</script>
</body>
</html>