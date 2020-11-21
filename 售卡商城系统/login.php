<?php
require './Mao/common.php';
$mod = isset($_GET['mod']) ? $_GET['mod'] :1;
?>
<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0 user-scalable=no">
    <meta name="format-detection" content="telephone=no">
    <title>手机验证-<?php echo $mao['title']?></title>
    <link rel="stylesheet" type="text/css" href="/Mao_Public/css/Mao.min.css">
    <link rel="stylesheet" type="text/css" href="/Mao_Public/css/style.css">
    <link rel="stylesheet" type="text/css" href="/Mao_Public/css/Mao.diy.css">
    <link rel="stylesheet" type="text/css" href="/Mao_Public/css/iconfont.css">
    <link rel="stylesheet" href="/Mao_Public/layui/css/layui.css">
    <script src="/Mao_Public/js/jquery-2.1.1.min.js"></script>
    <script src="/Mao_Public/layer/layer.js"></script>
    <script src="/Mao_Public/js/Mao.js"></script>
    <script src="https://ssl.captcha.qq.com/TCaptcha.js"></script>
</head>
<body>
<div class="fui-page-group statusbar">
    <div class="fui-page fui-page-current order-list-page">
        <div class="fui-header jb">
            <div class="fui-header-left">
                <a href="/index.php" class="back" style="color: #f7f7f7;"></a>
            </div>
            <div class="title">手机验证</div>
            <div class="fui-header-right"></div>
        </div>
        <div class="fui-tab fui-tab-danger">
            <a href="/login.php?mod=1" class="external <?php if($mod == "" || $mod == null || $mod == "1"){echo'active';}?>">短信验证</a>
            <a href="/login.php?mod=2" class="external <?php if($mod == "2"){echo'active';}?>">密码验证</a>
        </div>
        <div class="fui-content navbar" style="bottom: 0rem;padding-bottom: 0rem;">
            <?php
            if($mod == "1"){
                ?>
                <div class="fui-cell-group" style="margin-top: 0.05rem;">
                    <div class="fui-cell">
                        <div class="fui-cell-label">手机号</div>
                        <div class="fui-cell-info c000">
                            <input type="text" class="fui-input" id="sjh" placeholder="请输入手机号">
                        </div>
                    </div>
                    <div class="fui-cell">
                        <div class="fui-cell-label">验证码</div>
                        <div class="fui-cell-info c000">
                            <input type="text" class="fui-input" id="code" placeholder="请输入短信验证码">
                        </div>
                        <div class="fui-cell-remark noremark" id="yzm">
                            <a type="button" class="layui-btn layui-btn-xs jb" id="TencentCaptcha" data-appid="<?php echo $tx_app_id?>" data-cbfn="getcode">发送验证码</a>
                        </div>
                    </div>
                </div>
                <div class="fui-cell-group fui-cell-click transparent">
                    <a class="fui-cell external btn-mao" id="login" data-appid="<?php echo $tx_app_id?>" data-cbfn="login">
                        <div class="fui-cell-text jb" style="text-align: center;">
                            <p>登 陆</p>
                        </div>
                    </a>
                </div>
                <script>
                    $(function(){
                        new TencentCaptcha(document.getElementById('login'));
                    });
                    window.getcode = function(res){
                        if(res.ret === 0){
                            var loading = layer.load();
                            $.ajax({
                                url: '/api/api.php',
                                type: 'POST',
                                dataType: 'json',
                                data: {mod: "getcode", shouji: $('#sjh').val(), ticket: res.ticket, randstr: res.randstr},
                                success: function (a) {
                                    layer.close(loading);
                                    if (a.code == 0) {
                                        var validCode=true;
                                        var time=60;
                                        if (validCode) {
                                            validCode=false;
                                            var t=setInterval(function  () {
                                                time--;
                                                $('#yzm').html('<a type="button" class="layui-btn layui-btn-xs layui-btn-disabled jb">'+time+"秒"+'</a>');
                                                if (time==0) {
                                                    clearInterval(t);
                                                    $('#yzm').html('<a type="button" class="layui-btn layui-btn-xs jb" id="TencentCaptcha" data-appid="<?php echo $tx_app_id?>" data-cbfn="getcode">发送验证码</a>');
                                                    validCode=true;
                                                }
                                            },1000)
                                        }

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
                    }
                    window.login = function(res){
                        if(res.ret === 0){
                            var loading = layer.load();
                            $.ajax({
                                url: '/api/api.php',
                                type: 'POST',
                                dataType: 'json',
                                data: {mod: "login", type: 1, shouji: $('#sjh').val(), code: $('#code').val(), ticket: res.ticket, randstr: res.randstr},
                                success: function (a) {
                                    layer.close(loading);
                                    if (a.code == 0) {
                                        layer.msg(a.msg, {icon: 1}, function(){window.open("/user/index.php", "_self");});
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
                    }
                </script>
                <?php
            }elseif($mod == "2"){
                ?>
                <div class="fui-cell-group" style="margin-top: 0.05rem;">
                    <div class="fui-cell">
                        <div class="fui-cell-label">手机号</div>
                        <div class="fui-cell-info c000">
                            <input type="text" class="fui-input" id="sjh" placeholder="请输入手机号">
                        </div>
                    </div>
                    <div class="fui-cell">
                        <div class="fui-cell-label">登陆密码</div>
                        <div class="fui-cell-info c000">
                            <input type="password" class="fui-input" id="pass" placeholder="请输入登陆密码">
                        </div>
                    </div>
                </div>
                <div class="fui-cell-group fui-cell-click transparent">
                    <a class="fui-cell external btn-mao" id="login" data-appid="<?php echo $tx_app_id?>" data-cbfn="login">
                        <div class="fui-cell-text jb" style="text-align: center;">
                            <p>登 陆</p>
                        </div>
                    </a>
                </div>
                <script>
                    $(function(){
                        new TencentCaptcha(document.getElementById('login'));
                    });
                    window.login = function(res){
                        if(res.ret === 0){
                            var loading = layer.load();
                            $.ajax({
                                url: '/api/api.php',
                                type: 'POST',
                                dataType: 'json',
                                data: {mod: "login", type: 2, shouji: $('#sjh').val(), pass: $('#pass').val(), ticket: res.ticket, randstr: res.randstr},
                                success: function (a) {
                                    layer.close(loading);
                                    if (a.code == 0) {
                                        layer.msg(a.msg, {icon: 1}, function(){window.open("/user/index.php", "_self");});
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
                    }
                </script>
                <?php
            }else{
                sysmsg("非法请求！<a href='/login.php'>返回</a>");
            }
            ?>
        </div>
    </div>
</div>
</body>
</html>