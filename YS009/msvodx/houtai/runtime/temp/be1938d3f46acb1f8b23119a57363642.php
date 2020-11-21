<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:59:"/www/wwwroot/msvodx/houtai/app/admin/view/publics/index.php";i:1521858364;}*/ ?>
<!DOCTYPE html>
<html>
<head>
    <title>后台管理登陆</title>
    <meta http-equiv="Access-Control-Allow-Origin" content="*">
    <link rel="stylesheet" href="__ADMIN_JS__/layui/css/layui.css">
    <style type="text/css">
        /*body{background: url(http://attachments.gfan.com/forum/201501/13/142910wv4zzmhhml3rmzw3.jpg) no-repeat;}*/
         body{background: url(/static/admin/image/newyear_bg.webp) no-repeat;background-position: center;}
        .login-box{width: 400px;background-color: rgba(0, 0, 0, 0.42);padding: 15px 30px;float: right;position: absolute;top: 50%;right: 10%;margin-top: -200px;}
        .login-box legend{color:#e8e8e8;}
        .login-box .layui-form-pane .layui-form-label{border: 0;background-color: rgba(45, 45, 45, 0.36);color: #bfbfbf;}
        .login-box .layui-input{background: rgba(80, 77, 77, 0.46);border: 0;color: #ececec;}
        .login-box input[name="password"]{letter-spacing:5px;font-weight:800}
        .login-box .layui-btn{width: 100%;background-color: #bfa56c;font-size: 16px;letter-spacing: 2px;}
        .login-box .copyright{text-align:center;height:50px;line-height:50px;font-size:12px;color:#ccc}
        .login-box .copyright a{color:#ccc;}
    </style>
    <script>
        window.onload = function(){
            var div = document.getElementById("body");
            var height = document.documentElement.clientHeight;
            div.style.height = height + "px" ;
        }

           var bodyBgs = [];
                bodyBgs[0] = "/static/admin/image/newyear_bg.webp";
                bodyBgs[1] = "/static/admin/image/login_bg.jpg";
                bodyBgs[2] = "/static/admin/image/login_bg2.jpg";
                bodyBgs[3] = "/static/admin/image/login_bg3.jpg";
                bodyBgs[4] = "/static/admin/image/login_bg4.jpg";
                bodyBgs[5] = "/static/admin/image/newyear_bg.webp";
                bodyBgs[6] = "/static/admin/image/newyear_bg.webp";
                var randomBgIndex = Math.round( Math.random() * 6 );
            //输出随机的背景图
            console.log(randomBgIndex);
                document.write('<style>body{background:url(' + bodyBgs[randomBgIndex] + ') no-repeat;background-position: center;}</style>');
            //]]>

    </script>
</head>
<body id="body">

<div class="login-box">
    <form action="<?php echo url(); ?>" method="post" class="layui-form layui-form-pane">
        <fieldset class="layui-elem-field layui-field-title">
            <legend>管理后台登陆</legend>
        </fieldset>
        <div class="layui-form-item">
            <label class="layui-form-label">登陆账号</label>
            <div class="layui-input-block">
                <input type="text" name="username" class="layui-input" lay-verify="required" placeholder="请输入登陆账号" autofocus="autofocus" value="">
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">登陆密码</label>
            <div class="layui-input-block">
                <input type="password" name="password" class="layui-input" lay-verify="required" placeholder="******" value="">
            </div>
        </div>
<!--         <div class="layui-form-item">
            <label class="layui-form-label">安全验证</label>
            <div class="layui-input-inline">
                <input type="text" name="code" class="layui-input">
            </div>
        </div> -->
        <?php echo token('__token__', 'sha1'); ?>
        <input type="submit" value="登陆" lay-submit="" lay-filter="formSubmit" class="layui-btn">
    </form>
    <div class="copyright">
         <a>不开心，就算长生不老也没用，开心，就算只能活几天也足够！</a> 
    </div>
</div>
<script src="__ADMIN_JS__/layui/layui.js"></script>
<script>
layui.config({
  base: '__ADMIN_JS__/'
}).use('global');
</script>
</body>
</html>