<?php
require '../Mao/common.php';
header('Content-Type: text/html;charset=utf-8');
session_start();
$mod = isset($_REQUEST['mod']) ? $_REQUEST['mod'] :0;

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

if($mod){
    if($mod == "kefu"){
        if($mao['qq'] == "" || $mao['qq'] == null){
            $qq = '站长未设置联系QQ';
        }else{
            $qq = $mao['qq'];
        }
        if($mao['wx'] == "" || $mao['wx'] == null){
            $wx = '站长未设置微信号';
        }else{
            $wx = $mao['wx'];
        }
        $result=array("code"=>0,"qq"=>$qq,"wx"=>$wx);
        exit(json_encode($result));
    }
    elseif($mod == "create"){
        $id = daddslashes($_POST['id']);
        $num = daddslashes($_POST['num']);
        $shouji = daddslashes($_POST['shouji']);
        $cha_1 = $DB->get_row("select * from mao_shop where M_id='{$mao['id']}' and id='{$id}' limit 1");
        if($id == "" || $num == "" || $shouji == ""){
            $result=array("code"=>-1,"msg"=>"订单参数不完整！");
        }elseif(floor($num) != $num){
            $result=array("code"=>-2,"msg"=>"非法操作已记录信息！");
        }elseif($num < 1){
            $result=array("code"=>-2,"msg"=>"非法操作已记录信息！");
        }elseif($num > $cha_1['kucun']){
            $result=array("code"=>-2,"msg"=>"购买数量不能超过当前库存数量！");
        }elseif(!preg_match("/^1[34578]{1}\d{9}$/",$shouji)){
            $result=array("code"=>-3,"msg"=>"错误的手机号！");
        }elseif(!$cha_1){
            $result=array("code"=>-4,"msg"=>"商品不存在！");
        }elseif($cha_1['kucun'] < 1){
            $result=array("code"=>-5,"msg"=>"库存不足！");
        }elseif($cha_1['zt'] != 0){
            $result=array("code"=>-6,"msg"=>"该商品已下架！");
        }else{
            if($cha_1['type'] == 1){
                $bt = "中国电信";
            }elseif ($cha_1['type'] == 2){
                $bt = "中国移动";
            }elseif ($cha_1['type'] == 3){
                $bt = "中国联通";
            }
            if($cha_1['slxd_zt'] == 0){
                $sl = $num;
            }else{
                $sl = 1;
            }
            if($cha_1['youhui_zhang'] == 0){//无优惠
                $price = ($cha_1['price'] * $sl);
            }else{
                if($sl >= $cha_1['youhui_zhang']){
                    $price = ($cha_1['youhui_price'] * $sl);//优惠价
                }else{
                    $price = ($cha_1['price'] * $sl);//未达到优惠条件
                }
            }
            $zf_price = ($price + $cha_1['yf_price']);//需支付
            $ddh = date("YmdHis").rand(111,999);//订单号
            $name = "【{$bt}】{$cha_1['name']}";
            $DB->query("insert into `mao_dindan` (`M_id`,`M_sp`,`ddh`,`sjh`,`name`,`sl`,`dj_price`,`yf_price`,`price`,`time`,`zt`) values ('{$mao['id']}','{$cha_1['id']}','{$ddh}','{$shouji}','{$name}','{$sl}','{$cha_1['price']}','{$cha_1['yf_price']}','{$zf_price}','{$times}','1')");
            $result=array("code"=>0,"msg"=>"订单生成成功！","ddh"=>$ddh);
            $_SESSION['ddh'] = $ddh;
            $_SESSION['shouji'] = $shouji;
        }
        exit(json_encode($result));
    }//创建订单
    elseif($mod == "repair"){
        $ddh = daddslashes($_POST['ddh']);//订单号
        $xm = daddslashes($_POST['xm']);//收件人姓名
        $dz = daddslashes($_POST['dz']);//地址
        $xxdz = daddslashes($_POST['xxdz']);//详细地址
        $ly = daddslashes($_POST['ly']);//买家留言
        $jzxm = daddslashes($_POST['jzxm']);
        $sfzh = daddslashes($_POST['sfzh']);
        $mgz = daddslashes($_POST['mgz']);
        $sfz1 = daddslashes($_POST['sfz1']);
        $sfz2 = daddslashes($_POST['sfz2']);
        $cha_1 = $DB->get_row("select * from mao_dindan where M_id='{$mao['id']}' and ddh='{$ddh}' limit 1");
        $cha_2 = $DB->get_row("select * from mao_shop where M_id='{$mao['id']}' and id='{$cha_1['M_sp']}' limit 1");
        if($ddh == "" || $xm == "" || $dz == "" || $xxdz == ""){
            $result=array("code"=>-1,"msg"=>"提交参数不完整！");
        }elseif(!$cha_1 || !$cha_2){
            $result=array("code"=>-2,"msg"=>"商品或订单不存在！");
        }elseif($cha_1['zt'] == 0){
            $result=array("code"=>-3,"msg"=>"该订单已交易完成,请等待处理！");
        }elseif($cha_1['zt'] == 2){
            $result=array("code"=>-4,"msg"=>"该订单已处理,请自行查看物流信息！");
        }elseif($cha_1['zt'] == 3){
            $result=array("code"=>-5,"msg"=>"该订单状态异常,请前往订单列表查询原因！");
        }elseif($cha_2['zt'] != 0){
            $result=array("code"=>-7,"msg"=>"该商品已下架！");
        }elseif($cha_2['dqpb'] != "" || $cha_2['dqpb'] != null) {
            $var1 = explode("|", $cha_2['dqpb']);
            $var2 = explode(" ", $dz);
            if(check($var1,$var2) == 1){
                $result=array("code"=>-7,"msg"=>"该地区暂不支持下单！");
            }else{
                if($cha_1['zt'] == 1) {
                    if ($cha_2['rwzl_zt'] == 0) {//入网资料
                        if ($jzxm == "" || $sfzh == "" || $mgz == "" || $sfz1 == "" || $sfz2 == "") {
                            $result = array("code" => -6, "msg" => "入网资料不完整！");
                        } else {
                            $DB->query("update mao_dindan set xm='{$xm}',dz='{$dz}',xxdz='{$xxdz}',ly='{$ly}',jzxm='{$jzxm}',sfzh='{$sfzh}',mgz='{$mgz}',sfz1='{$sfz1}',sfz2='{$sfz2}' where M_id='{$mao['id']}' and id='{$cha_1['id']}'");
                            $result = array("code" => 0);
                            $_SESSION['ddh'] = $cha_1['ddh'];
                            $_SESSION['shouji'] = $cha_1['sjh'];
                        }
                    } else {
                        $DB->query("update mao_dindan set xm='{$xm}',dz='{$dz}',xxdz='{$xxdz}',ly='{$ly}' where M_id='{$mao['id']}' and id='{$cha_1['id']}'");
                        $result = array("code" => 0);
                        $_SESSION['ddh'] = $cha_1['ddh'];
                        $_SESSION['shouji'] = $cha_1['sjh'];
                    }
                }
            }
        }elseif($cha_1['zt'] == 1){
            if($cha_2['rwzl_zt'] == 0){//入网资料
                if($jzxm == "" || $sfzh == "" || $mgz == "" || $sfz1 == "" || $sfz2 == ""){
                    $result=array("code"=>-6,"msg"=>"入网资料不完整！");
                }else{
                    $DB->query("update mao_dindan set xm='{$xm}',dz='{$dz}',xxdz='{$xxdz}',ly='{$ly}',jzxm='{$jzxm}',sfzh='{$sfzh}',mgz='{$mgz}',sfz1='{$sfz1}',sfz2='{$sfz2}' where M_id='{$mao['id']}' and id='{$cha_1['id']}'");
                    $result=array("code"=>0);
                    $_SESSION['ddh'] = $cha_1['ddh'];
                    $_SESSION['shouji'] = $cha_1['sjh'];
                }
            }else{
                $DB->query("update mao_dindan set xm='{$xm}',dz='{$dz}',xxdz='{$xxdz}',ly='{$ly}' where M_id='{$mao['id']}' and id='{$cha_1['id']}'");
                $result=array("code"=>0);
                $_SESSION['ddh'] = $cha_1['ddh'];
                $_SESSION['shouji'] = $cha_1['sjh'];
            }
        }else{
            $result=array("code"=>-2000,"msg"=>"该订单状态异常！");
        }
        exit(json_encode($result));
    }//补齐订单信息
    elseif($mod == "pay"){
        $ddh = daddslashes($_POST['ddh']);
        $type = daddslashes($_POST['type']);
        $cha_1 = $DB->get_row("select * from mao_dindan where M_id='{$mao['id']}' and ddh='{$ddh}' limit 1");
        $cha_2 = $DB->get_row("select * from mao_shop where M_id='{$mao['id']}' and id='{$cha_1['M_sp']}' limit 1");
        if($ddh == "" || $type == ""){
            $result=array("code"=>-1,"msg"=>"参数不完整！");
        }elseif($type < 1 || $type >3){
            $result=array("code"=>-2,"msg"=>"支付方式不存在！");
        }elseif(!$cha_1){
            $result=array("code"=>-2,"msg"=>"订单不存在！");
        }elseif($cha_1['zt'] == 0){
            $result=array("code"=>-3,"msg"=>"该订单已交易完成,请等待处理！");
        }elseif($cha_1['zt'] == 2){
            $result=array("code"=>-4,"msg"=>"该订单已处理,请自行查看物流信息！");
        }elseif($cha_1['zt'] == 3){
            $result=array("code"=>-5,"msg"=>"该订单状态异常,请前往订单列表查询原因！");
        }elseif($cha_2['kucun'] < 1){
            $result=array("code"=>-6,"msg"=>"库存不足！");
        }elseif($cha_2['zt'] != 0){
            $result=array("code"=>-7,"msg"=>"该商品已下架！");
        }elseif($cha_1['zt'] == 1){
            if($cha_1['price'] == 0.00 || $cha_1['price'] <= 0.00 || $cha_1['price'] <= 0){
                $js_1 = ($cha_2['kucun'] - $cha_1['sl']);
                $js_2 = ($cha_2['xiaoliang'] + $cha_1['sl']);
                $DB->query("update mao_dindan set zt='0' where M_id='{$mao['id']}' and id='{$cha_1['id']}'");
                $DB->query("update mao_shop set kucun='{$js_1}',xiaoliang='{$js_2}' where M_id='{$mao['id']}' and id='{$cha_2['id']}'");
                $result=array("code"=>0,"msg"=>"购买成功！");
                if($mao['dx_1'] == 0){
                    $js_1 = ($mao['price'] - 0.01);
                    if($mao['price'] >= 0.01 || $mao['sj'] != "" || $mao['sj'] != null){
                        $msg = dx("{$mao['sj']}","3");
                        if($msg == "0"){
                            $DB->query("update mao_data set price='{$js_1}' where id='{$mao['id']}'");
                        }
                    }
                }
            }else{
                if($mao['yzf_type'] == 1){//跟随系统
                    if($type == 1){
                        if($mao_zz['qq_zf'] != 0){
                            $result=array("code"=>-8,"msg"=>"该支付方式未开启！");
                            exit(json_encode($result));
                        }
                    }elseif($type == 2){
                        if($mao_zz['wx_zf'] != 0){
                            $result=array("code"=>-8,"msg"=>"该支付方式未开启！");
                            exit(json_encode($result));
                        }
                    }elseif($type == 3){
                        if($mao_zz['zfb_zf'] != 0){
                            $result=array("code"=>-8,"msg"=>"该支付方式未开启！");
                            exit(json_encode($result));
                        }
                    }
                    if($mao_zz['yzf_type'] != 2){
                        if($type == 1){
                            $result=array("code"=>1,"ddh"=>$cha_1['ddh'],"type"=>"qqpay");
                        }elseif($type == 2){
                            $result=array("code"=>1,"ddh"=>$cha_1['ddh'],"type"=>"wxpay");
                        }elseif($type == 3){
                            $result=array("code"=>1,"ddh"=>$cha_1['ddh'],"type"=>"alipay");
                        }else{
                            $result=array("code"=>-3000,"msg"=>"支付方式错误！");
                        }
                    }else{
                        if($type == 1){
                            $result=array("code"=>2,"ddh"=>$cha_1['ddh'],"type"=>"2");
                        }elseif($type == 2){
                            $result=array("code"=>2,"ddh"=>$cha_1['ddh'],"type"=>"3");
                        }elseif($type == 3){
                            $result=array("code"=>2,"ddh"=>$cha_1['ddh'],"type"=>"1");
                        }else{
                            $result=array("code"=>-3000,"msg"=>"支付方式错误！");
                        }
                    }
                }elseif($mao['yzf_type'] == 0 || $mao['yzf_type'] == 2){//自定义//码支付
                    if($type == 1){
                        if($mao['qq_zf'] != 0){
                            $result=array("code"=>-8,"msg"=>"该支付方式未开启！");
                            exit(json_encode($result));
                        }
                    }elseif($type == 2){
                        if($mao['wx_zf'] != 0){
                            $result=array("code"=>-8,"msg"=>"该支付方式未开启！");
                            exit(json_encode($result));
                        }
                    }elseif($type == 3) {
                        if($mao['zfb_zf'] != 0) {
                            $result = array("code" => -8, "msg" => "该支付方式未开启！");
                            exit(json_encode($result));
                        }
                    }
                    if($mao['yzf_type'] != 2){
                        if($type == 1){
                            $result=array("code"=>1,"ddh"=>$cha_1['ddh'],"type"=>"qqpay");
                        }elseif($type == 2){
                            $result=array("code"=>1,"ddh"=>$cha_1['ddh'],"type"=>"wxpay");
                        }elseif($type == 3){
                            $result=array("code"=>1,"ddh"=>$cha_1['ddh'],"type"=>"alipay");
                        }else{
                            $result=array("code"=>-3000,"msg"=>"支付方式错误！");
                        }
                    }else{
                        if($type == 1){
                            $result=array("code"=>2,"ddh"=>$cha_1['ddh'],"type"=>"2");
                        }elseif($type == 2){
                            $result=array("code"=>2,"ddh"=>$cha_1['ddh'],"type"=>"3");
                        }elseif($type == 3){
                            $result=array("code"=>2,"ddh"=>$cha_1['ddh'],"type"=>"1");
                        }else{
                            $result=array("code"=>-3000,"msg"=>"支付方式错误！");
                        }
                    }
                }
            }
        }else{
            $result=array("code"=>-2000,"msg"=>"该订单状态异常！");
        }
        exit(json_encode($result));
    }//开始支付
    elseif($mod == "upload"){
        $type = daddslashes($_REQUEST['type']);
        if($type == 1){
            if ((($_FILES["file"]["type"] == "image/gif") || ($_FILES["file"]["type"] == "image/jpeg") || ($_FILES["file"]["type"] == "image/png") || ($_FILES["file"]["type"] == "image/pjpeg")) && ($_FILES["file"]["size"] < 5242880)){
                if ($_FILES["file"]["error"] > 0){
                    $result=array("code"=>-2,"msg"=>"上传出错！");
                    exit(json_encode($result));
                }else{
                    $cmm = date("YmdHis").rand(111,999);
                    $name = explode('.',$_FILES["file"]["name"]);
                    $newPath = $cmm.'.'.$name[1];
                    if (preg_match("/[\x7f-\xff]/", $newPath)) {
                        $result=array("code"=>-3,"msg"=>"文件名称不能为中文！");
                        exit(json_encode($result));
                    }
                    if (file_exists("../upload/" . $newPath)){
                        $result=array("code"=>-2,"msg"=>"上传出错！");
                        exit(json_encode($result));
                    }else{
                        move_uploaded_file($_FILES["file"]["tmp_name"],"../upload/" . $newPath);
                        $lj=array("src"=>"/upload/{$newPath}","title"=>"图片");
                        $result=array("code"=>0,"msg"=>"上传成功！","data"=>$lj,"name"=>"/upload/{$newPath}");
                        exit(json_encode($result));
                    }
                }
            }else{
                $result=array("code"=>-3,"msg"=>"图片大小不能超过5M！{$_FILES["file"]["size"]}");
                exit(json_encode($result));
            }
        }
        else{
            $result=array("code"=>-1,"msg"=>"上传类型不存在！");
        }
        exit(json_encode($result));
    }//图片上传接口
    elseif($mod == "wuliu"){
        $ddh = daddslashes($_POST['ddh']);
        $cha_1 = $DB->get_row("select * from mao_dindan where M_id='{$mao['id']}' and (sjh='{$_SESSION['user']}' && ddh='{$ddh}') limit 1");
        if(!$cha_1 || $cha_1['zt'] != 2){
            $result=array("code"=>-1,"msg"=>"订单不存在！");
        }elseif($_SESSION['Mao_login'] != 1){
            $result=array("code"=>-2,"msg"=>"请先登陆！");
        }else{
            $host = "http://goexpress.market.alicloudapi.com";
            $path = "/goexpress";
            $method = "GET";
            $appcode = $AppSecret;
            $headers = array();
            array_push($headers, "Authorization:APPCODE " . $appcode);
            $querys = "no={$cha_1['ydh']}&type=";
            $bodys = "";
            $url = $host . $path . "?" . $querys;
            $curl = curl_init();
            curl_setopt($curl, CURLOPT_CUSTOMREQUEST, $method);
            curl_setopt($curl, CURLOPT_URL, $url);
            curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($curl, CURLOPT_FAILONERROR, false);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl, CURLOPT_HEADER, false);
            //curl_setopt($curl, CURLOPT_HEADER, true); 如不输出json, 请打开这行代码，打印调试头部状态码。
            if (1 == strpos("$".$host, "https://")) {
                curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
                curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
            }
            $msg = curl_exec($curl);
            $data = json_decode($msg,true);
            if($data['code'] == 'OK'){
                $cha_2 = $DB->get_row("select * from mao_wuliu where M_id='{$mao['id']}' and (users='{$_SESSION['user']}' && ddh='{$cha_1['ddh']}') limit 1");
                if($cha_2){//更新
                    $DB->query("update mao_wuliu set msg='{$msg}',time='{$times}' where id='{$cha_2['id']}'");
                }else{
                    $DB->query("insert into `mao_wuliu` (`M_id`,`users`,`ddh`,`msg`,`time`) values ('{$mao['id']}','{$_SESSION['user']}','{$cha_1['ddh']}','{$msg}','{$times}')");
                }
                $result=array("code"=>0,"msg"=>"更新成功！");
            }else{
                $result=array("code"=>-3,"msg"=>"更新失败！");
            }
            exit(json_encode($result));
        }
        exit(json_encode($result));
    }//物流信息更新
    elseif($mod == "cxwuliu"){
        $ddh = daddslashes($_POST['ddh']);
        $cha_1 = $DB->get_row("select * from mao_dindan where M_id='{$mao['id']}' and (sjh='{$_SESSION['user']}' && ddh='{$ddh}') limit 1");
        if(!$cha_1 || $cha_1['zt'] != 2){
            $result=array("code"=>-1,"msg"=>"订单不存在！");
        }elseif($_SESSION['Mao_login'] != 1){
            $result=array("code"=>-2,"msg"=>"请先登陆！");
        }else{
            $cha_2 = $DB->get_row("select * from mao_wuliu where M_id='{$mao['id']}' and (users='{$_SESSION['user']}' && ddh='{$cha_1['ddh']}') limit 1");
            if($cha_2){
                exit($cha_2['msg']);
            }else{
                $result=array("code"=>-3,"msg"=>"请手动更新一次物流信息！");
            }
        }
        exit(json_encode($result));
    }//查询物流
    elseif($mod == "getcode"){
        $shouji = daddslashes($_POST['shouji']);
        if($shouji == "" || $shouji == null || !preg_match("/^1[34578]{1}\d{9}$/",$shouji)){
            $result = array("code"=>-1,"msg"=>"手机号不合法！");
            exit(json_encode($result));
        }
        if($results){
            if($results['response'] == 1){
                $_SESSION['code_time'];
                $yzm = randString();//6位数验证码
                if($_SESSION['code_time'] == ""){//发送短信
                    $msg = dx("{$shouji}","1","{$yzm}");
                    if($msg == "0"){
                        $result=array("code"=>0,"msg"=>"验证码发送成功！");
                        $_SESSION['code'] = $yzm;
                        $_SESSION['code_time'] = $times;
                    }else{
                        $result=array("code"=>-2,"msg"=>"验证码发送失败,原因：{$msg}");
                    }
                }else{
                    $second = floor((strtotime($times)-strtotime($_SESSION['code_time']))%86400%86400);
                    if($second > 60){//发送短信
                        $msg = dx("{$shouji}","1","{$yzm}");
                        if($msg == "0"){
                            $result=array("code"=>0,"msg"=>"验证码发送成功！");
                            $_SESSION['code'] = $yzm;
                            $_SESSION['code_time'] = $times;
                        }else{
                            $result=array("code"=>-2,"msg"=>"验证码发送失败,原因：{$msg}");
                        }
                    }else{
                        $js_1 = (60 - $second);
                        $result=array("code"=>-2,"msg"=>"请{$js_1}秒后再获取验证码！");
                    }
                }
            }else{
                $result=array("code"=>-2000,"msg"=>"[{$results['response']}],{$results['err_msg']}");
            }
        }else{
            $result=array("code"=>-2000,"msg"=>"验证失败！");
        }
        exit(json_encode($result));
    }//获取手机短信验证码
    elseif($mod == "login"){
        $type = daddslashes($_POST['type']);
        $shouji = daddslashes($_POST['shouji']);
        $pass = daddslashes($_POST['pass']);
        $code = daddslashes($_POST['code']);
        if($results){
            if($results['response'] == 1){
                if($type == 1){
                    if($shouji == "" || $code == ""){
                        $result = array("code"=>-1,"msg"=>"手机号或验证码不能为空！");
                    }elseif(!preg_match("/^1[34578]{1}\d{9}$/",$shouji)){
                        $result = array("code"=>-2,"msg"=>"手机号不合法！");
                    }elseif($code != $_SESSION['code']){
                        $result = array("code"=>-3,"msg"=>"验证码错误！");
                    }else{
                        $result = array("code"=>0,"msg"=>"验证成功,请稍后...");
                        $_SESSION['Mao_login'] = 1;
                        $_SESSION['user'] = $shouji;
                        unset($_SESSION['code']);
                    }
                }elseif($type == 2){
                    $cha_1 = $DB->get_row("select * from mao_user where M_id='{$mao['id']}' and users='{$shouji}' limit 1");
                    if($shouji == "" || $pass == ""){
                        $result = array("code"=>-1,"msg"=>"手机号或密码不能为空！");
                    }elseif(!preg_match("/^1[34578]{1}\d{9}$/",$shouji)){
                        $result = array("code"=>-2,"msg"=>"手机号不合法！");
                    }elseif(!$cha_1){
                        $result = array("code"=>-3,"msg"=>"未设置登陆密码,请使用短信验证码登陆！");
                    }else{
                        if($cha_1['pass'] == $pass){
                            $result = array("code"=>0,"msg"=>"验证成功,请稍后...");
                            $_SESSION['Mao_login'] = 1;
                            $_SESSION['user'] = $cha_1['users'];
                            unset($_SESSION['code']);
                        }else{
                            $result = array("code"=>-4,"msg"=>"登陆密码错误！");
                        }
                    }
                }else{
                    $result=array("code"=>-2000,"msg"=>"非法操作已记录信息！");
                }
            }else{
                $result=array("code"=>-2000,"msg"=>"[{$results['response']}],{$results['err_msg']}");
            }
        }else{
            $result=array("code"=>-2000,"msg"=>"验证失败！");
        }
        exit(json_encode($result));
    }//登陆验证
    elseif($mod == "add_gd"){
        $ddh = daddslashes($_POST['ddh']);
        $kh = daddslashes($_POST['kh']);
        $type = daddslashes($_POST['type']);
        $wt = daddslashes($_POST['wt']);
        $img_url = daddslashes($_POST['img_url']);
        $cha_1 = $DB->get_row("select * from mao_dindan where M_id='{$mao['id']}' and (sjh='{$_SESSION['user']}' && ddh='{$ddh}') limit 1");
        if(!$cha_1 || $cha_1['zt'] == 0 || $cha_1['zt'] == 1){
            $result=array("code"=>-1,"msg"=>"订单不存在！");
        }elseif($_SESSION['Mao_login'] != 1){
            $result=array("code"=>-2,"msg"=>"请先登陆！");
        }elseif($kh == "" || $type == "" || $wt == ""){
            $result=array("code"=>-3,"msg"=>"参数不完整！");
        }elseif(mb_strlen($wt,'UTF8') > 100){
            $result=array("code"=>-4,"msg"=>"问题描述不能超过100个字符！");
        }elseif($type < 1 || $type > 2){
            $result=array("code"=>-5,"msg"=>"问题类型错误！");
        }else{
            if($mao['dx_3'] == 0){
                $js_1 = ($mao['price'] - 0.01);
                if($mao['price'] >= 0.01 || $mao['sj'] != "" || $mao['sj'] != null){
                    $msg = dx("{$mao['sj']}","4");
                    if($msg == "0"){
                        $DB->query("update mao_data set price='{$js_1}' where id='{$mao['id']}'");
                    }
                }
            }
            $DB->query("insert into `mao_gd` (`M_id`,`users`,`type`,`ddh`,`kh`,`wt`,`img`,`time`,`zt`) values ('{$mao['id']}','{$_SESSION['user']}','{$type}','{$cha_1['ddh']}','{$kh}','{$wt}','{$img_url}','{$times}','1')");
            $result=array("code"=>0,"msg"=>"提交成功！");
        }
        exit(json_encode($result));
    }//工单提交
    elseif($mod == "gd"){
        $id = daddslashes($_POST['id']);
        $cha_1 = $DB->get_row("select * from mao_gd where M_id='{$mao['id']}' and (users='{$_SESSION['user']}' && id='{$id}' && zt='0') limit 1");
        if($id == "" || !$cha_1){
            $result=array("code"=>-1,"msg"=>"工单不存在！");
        }elseif($_SESSION['Mao_login'] != 1){
            $result=array("code"=>-2,"msg"=>"请先登陆！");
        }else{
            $result=array("code"=>0,"msg"=>$cha_1['msg']);
        }
        exit(json_encode($result));
    }//工单处理结果
    elseif($mod == "xq"){
        $id = daddslashes($_POST['id']);
        $cha_1 = $DB->get_row("select * from mao_dindan where M_id='{$mao['id']}' and (sjh='{$_SESSION['user']}' && id='{$id}' && zt='3') limit 1");
        if($id == "" || !$cha_1){
            $result=array("code"=>-1,"msg"=>"订单不存在！");
        }elseif($_SESSION['Mao_login'] != 1){
            $result=array("code"=>-2,"msg"=>"请先登陆！");
        }else{
            $result=array("code"=>0,"msg"=>$cha_1['msg']);
        }
        exit(json_encode($result));
    }
    elseif($mod == "set"){
        $pass = daddslashes($_POST['pass']);
        if($pass == ""){
            $result=array("code"=>-3,"msg"=>"参数不完整！");
        }elseif($_SESSION['Mao_login'] != 1){
            $result=array("code"=>-2,"msg"=>"请先登陆！");
        }elseif(mb_strlen($pass,'UTF8') < 6 || mb_strlen($pass,'UTF8') > 15){
            $result=array("code"=>-3,"msg"=>"密码只能是6-15位的字母和数字！");
        }elseif(preg_match("/[\x7f-\xff]/", $pass)){
            $result=array("code"=>-4,"msg"=>"密码不能带有中文！");
        }else{
            $cha_1 = $DB->get_row("select * from mao_user where M_id='{$mao['id']}' and users='{$_SESSION['user']}' limit 1");
            if($cha_1){
                $DB->query("update mao_user set pass='{$pass}' where id='{$cha_1['id']}'");
                $result=array("code"=>0,"msg"=>"修改成功！");
            }else{
                $DB->query("insert into `mao_user` (`M_id`,`users`,`pass`) values ('{$mao['id']}','{$_SESSION['user']}','{$pass}')");
                $result=array("code"=>0,"msg"=>"修改成功！");
            }
        }
        exit(json_encode($result));
    }//设置/修改/密码
    elseif($mod == "logout"){
        $_SESSION['Mao_login'] = 0;
        $result=array("code"=>0,"msg"=>"注销成功！");
        exit(json_encode($result));
    }
}else{
    $result=array("code"=>-3000,"msg"=>"非法请求！");
    exit(json_encode($result));
}