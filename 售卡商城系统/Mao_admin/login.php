<?php
require '../Mao/common.php';
$mod = isset($_POST['mod']) ? $_POST['mod'] : 0;
if($mod){
    if($mod == "login"){
        $user=daddslashes($_POST['user']);
        $pass=daddslashes($_POST['pass']);

        $AppSecretKey = $tx_app_key;
        $appid = $tx_app_id;
        $Ticket = daddslashes($_POST['ticket']);
        $Randstr = daddslashes($_POST['randstr']);
        $UserIP = GetClientIP();
        $url = "https://ssl.captcha.qq.com/ticket/verify";
        $params = array(
            "aid" => $appid,
            "AppSecretKey" => $AppSecretKey,
            "Ticket" => $Ticket,
            "Randstr" => $Randstr,
            "UserIP" => $UserIP
        );
        $paramstring = http_build_query($params);
        $content = get_curl($url,"aid={$appid}&AppSecretKey={$AppSecretKey}&Ticket={$Ticket}&Randstr={$Randstr}&UserIP={$UserIP}");
        $results = json_decode($content,true);

        if($results){
            if($results['response'] == 1) {
                if($user == "" || $pass == ""){
                    $result=array("code"=>-1,"msg"=>"帐号或密码不能为空！");
                }elseif($pass != $mao['pass']){
                    $result=array("code"=>-2,"msg"=>"密码错误！");
                }elseif($user == $mao['user'] && $pass == $mao['pass']){
                    $session=md5($user.$pass.$password_hash);
                    $token=authcode("{$user}\t{$session}", 'ENCODE', SYS_KEY);
                    setcookie("Mao_token", $token, time() + 604800);
                    $result=array("code"=>0,"msg"=>"登陆成功.正在转跳到后台中心！");
                }
            }else{
                $result=array("code"=>-2000,"msg"=>"[{$results['response']}],{$results['err_msg']}");
            }
        }else{
            $result=array("code"=>-2000,"msg"=>"验证失败！");
        }

        exit(json_encode($result));
    }elseif($mod == "logout"){
        setcookie("Mao_token", "", time() - 604800);
        $result=array("code"=>0,"msg"=>"注销成功！");
        exit(json_encode($result));
    }
}elseif($islogin == 1){
    exit("<script language='javascript'>window.location.href='/Mao_admin/';</script>");
}
?>
<html lang="zh-cn">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
    <meta name="renderer" content="webkit">
    <title>后台登录-<?php echo $mao['title']?></title>
    <link rel="stylesheet" href="css/base.css">
    <link rel="stylesheet" href="css/style.css">
    <script src="/Mao_Public/js/jquery-2.1.1.min.js"></script>
    <script src="/Mao_Public/layer/layer.js"></script>
    <script src="https://ssl.captcha.qq.com/TCaptcha.js"></script>
</head>
<body>
    <div class="bg"></div>
    <div class="container">
        <div class="line bouncein">
            <div class="xs6 xm4 xs3-move xm4-move">
                <div style="height:150px;"></div>
                <div class="media media-y margin-big-bottom">
                </div>
                <form action="index.html" method="post">
                    <div class="panel loginbox">
                        <div class="text-center margin-big padding-big-top">
                            <h1>后台管理中心</h1>
                        </div>
                        <div class="panel-body" style="padding:30px; padding-bottom:10px; padding-top:10px;">
                            <div class="form-group">
                                <div class="field field-icon-right">
                                    <input type="text" class="input input-big" id="username" placeholder="登录账号" />
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="field field-icon-right">
                                    <input type="password" class="input input-big" id="password"  placeholder="登录密码" />
                                </div>
                            </div>
                        </div>
                        <div style="padding:30px;">
                            <input type="button" class="button button-block bg-main text-big input-big" value="登录" id="TencentCaptcha" data-appid="<?php echo $tx_app_id?>" data-cbfn="login">
                        </div>
						<div>&#25042;&#20154;&#28304;&#30721;&#119;&#119;&#119;&#46;&#108;&#97;&#110;&#114;&#101;&#110;&#122;&#104;&#105;&#106;&#105;&#97;&#46;&#99;&#111;&#109;&#32;&#20840;&#31449;&#36164;&#28304;&#50;&#48;&#22359;&#20219;&#24847;&#19979;&#36733;</div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script>
        window.login = function(res){
            if(res.ret === 0){
                var loading = layer.load();
                $.ajax({
                    url: 'login.php',
                    type: 'POST',
                    dataType: 'json',
                    data: {mod: "login", user: $('#username').val(), pass: $('#password').val(), ticket: res.ticket, randstr: res.randstr},
                    success: function (a) {
                        layer.close(loading);
                        if(a.code == 0){
                            layer.msg(a.msg, function() {window.open("/Mao_admin/", "_self");});
                        } else {
                            layer.msg(a.msg, function() {});
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
</body>
</html>


