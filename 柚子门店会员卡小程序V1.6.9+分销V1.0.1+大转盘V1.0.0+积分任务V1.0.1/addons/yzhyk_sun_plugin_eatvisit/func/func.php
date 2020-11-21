<?php
defined('IN_IA') or exit ('Access Denied');
global $_W, $_GPC;

function tocurl($url="",$data="",$timeout=0){
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE);
    if (!empty($data)){
        curl_setopt($curl, CURLOPT_POST, 1);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
    }
    if($timeout>0){
        curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, $timeout);
    }
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    $output = curl_exec($curl);
    $httpcode = curl_getinfo($curl,CURLINFO_HTTP_CODE);
    curl_close($curl);
    if($httpcode==200){
        return $output;
    }else{
        return false;
    }
}

function getaccess_token(){
    global $_W;
    $system=pdo_get('yzhyk_sun_system',array('uniacid'=>$_W['uniacid']),array('appid','appsecret'));
    $url='https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid='.$system['appid'].'&secret='.$system['appsecret'];
    $output = tocurl($url,"",0);
    $info=json_decode($output,true);
    $token=$info['access_token'];
    return $token;
}

//截取字符串——中英文
function substr_text($str, $start=0, $length, $charset="utf-8", $suffix=""){
    if(function_exists("mb_substr")){
        return mb_substr($str, $start, $length, $charset).$suffix;
    }elseif(function_exists('iconv_substr')){
        return iconv_substr($str,$start,$length,$charset).$suffix;
    }
    $re['utf-8']  = "/[\x01-\x7f]|[\xc2-\xdf][\x80-\xbf]|[\xe0-\xef][\x80-\xbf]{2}|[\xf0-\xff][\x80-\xbf]{3}/";
    $re['gb2312'] = "/[\x01-\x7f]|[\xb0-\xf7][\xa0-\xfe]/";
    $re['gbk']    = "/[\x01-\x7f]|[\x81-\xfe][\x40-\xfe]/";
    $re['big5']   = "/[\x01-\x7f]|[\x81-\xfe]([\x40-\x7e]|\xa1-\xfe])/";
    preg_match_all($re[$charset], $str, $match);
    $slice = join("",array_slice($match[0], $start, $length));
    return $slice.$suffix;
}

function getdocode($cb9b,$check,$u){
    $client_check = encryptcode($check, 'D','',0) . '?a=client_check&p='.$cb9b.'&u=' . $_SERVER['HTTP_HOST'];
    $check_message = encryptcode($check, 'D','',0) . '?a=check_message&p='.$cb9b.'&u=' . $_SERVER['HTTP_HOST'];
    $check_info=tocurl($client_check,10);
    if(!$check_info){
        return 1;
    }
    $check_info = trim($check_info, "\xEF\xBB\xBF");//去除bom头
    $message = tocurl($check_message,10);
    if($check_info=='1'){
       checkurl($u);
    }elseif($check_info=='2'){
       checkurl($u);
    }elseif($check_info=='3'){
       checkurl($u);
    }
    $json_check_info = json_decode($check_info,true);
    if($json_check_info["code"]===0){
        $input_data = array();
        $input_data["we7.cc"] = md5("we7_key");
        $input_data["keyid"] = $json_check_info["data"]["id"];
        $input_data["domain"] = $json_check_info["data"]["domain"];
        $input_data["ip"] = $json_check_info["data"]["ip"];
        $input_data["loca_ip"] = "127.0.0.1";
        $input_data["pid"] = $json_check_info["data"]["pid"];
		$input_data["domain_str"] = $json_check_info["data"]["domain_str"];
        $input_data["time"] = time();
        $input_data_s = serialize($input_data);
        $input_data_s = encryptcode($input_data_s, 'E','',0);
        $res = pdo_update('yzhyk_sun_acode', array("code"=>$input_data_s), array('id' =>3));
        if(!$res){
            $res = pdo_insert('yzhyk_sun_acode', array("code"=>$input_data_s,"id"=>3));
        }
    }
    return $json_check_info["code"];
}

function getrealip(){
    static $realip;
    $realip = gethostbynamel($_SERVER['SERVER_NAME']);
    return $realip;
}

function creatmdcode($str){
    return md5($str);
}

function checkurl($u){
    global $_W,$_GPC;
    $settype = $_GPC["settype"];
    if($settype!=3){
        $u = url('site/entry/setting', array('m' => $_W['current_module']['name'],"settype"=>3));
        header("Location:".$u);
        exit;
    }
}

function encryptcode($string, $operation = 'D', $key = '', $expiry = 0) {   
    // 动态密匙长度，相同的明文会生成不同密文就是依靠动态密匙   
    $ckey_length = 4;   
    // 密匙   
    $key = md5($key ? $key : "Xmzhy123@#$");
    // 密匙a会参与加解密   
    $keya = md5(substr($key, 0, 16));   
    // 密匙b会用来做数据完整性验证   
    $keyb = md5(substr($key, 16, 16));   
    // 密匙c用于变化生成的密文   
    $keyc = $ckey_length ? ($operation == 'D' ? substr($string, 0, $ckey_length): substr(md5(microtime()), -$ckey_length)) : '';   
    // 参与运算的密匙   
    $cryptkey = $keya.md5($keya.$keyc);   
    $key_length = strlen($cryptkey);   
    // 明文，前10位用来保存时间戳，解密时验证数据有效性，10到26位用来保存$keyb(密匙b)， 
//解密时会通过这个密匙验证数据完整性   
    // 如果是解码的话，会从第$ckey_length位开始，因为密文前$ckey_length位保存 动态密匙，以保证解密正确   
    $string = $operation == 'D' ? base64_decode(substr($string, $ckey_length)) : sprintf('%010d', $expiry ? $expiry + time() : 0).substr(md5($string.$keyb), 0, 16).$string;
    $string_length = strlen($string);   
    $result = '';   
    $box = range(0, 255);   
    $rndkey = array();   
    // 产生密匙簿   
    for($i = 0; $i <= 255; $i++) {   
        $rndkey[$i] = ord($cryptkey[$i % $key_length]);   
    }   
    // 用固定的算法，打乱密匙簿，增加随机性，好像很复杂，实际上对并不会增加密文的强度   
    for($j = $i = 0; $i < 256; $i++) {   
        $j = ($j + $box[$i] + $rndkey[$i]) % 256;   
        $tmp = $box[$i];   
        $box[$i] = $box[$j];   
        $box[$j] = $tmp;   
    }   
    // 核心加解密部分   
    for($a = $j = $i = 0; $i < $string_length; $i++) {   
        $a = ($a + 1) % 256;   
        $j = ($j + $box[$a]) % 256;   
        $tmp = $box[$a];   
        $box[$a] = $box[$j];   
        $box[$j] = $tmp;   
        // 从密匙簿得出密匙进行异或，再转成字符   
        $result .= chr(ord($string[$i]) ^ ($box[($box[$a] + $box[$j]) % 256]));   
    }   
    if($operation == 'D') {  
        // 验证数据有效性，请看未加密明文的格式   
        if((substr($result, 0, 10) == 0 || substr($result, 0, 10) - time() > 0) && substr($result, 10, 16) == substr(md5(substr($result, 26).$keyb), 0, 16)) {   
            return substr($result, 26);   
        } else {   
            return '';   
        }   
    } else {   
        // 把动态密匙保存在密文里，这也是为什么同样的明文，生产不同密文后能解密的原因   
        // 因为加密后的密文可能是一些特殊字符，复制过程可能会丢失，所以用base64编码   
        return $keyc.str_replace('=', '', base64_encode($result));   
    }   
} 

function getTopDomainhuo(){
    $host=$_SERVER['HTTP_HOST'];
    $matchstr="[^\.]+\.(?:(".$str.")|\w{2}|((".$str.")\.\w{2}))$";
    if(preg_match("/".$matchstr."/ies",$host,$matchs)){
      $domain=$matchs['0'];
    }else{
      $domain=$host;
    }
    return $domain;
}

class EB042D8DD30DD982EF27DF80492D786B{
    private $ip_a;
    private $check = '1972K+vbipdZEZacO7ghmwkmCp+lwv1dOIi8QNbaz2D90IAAQMJA6x66RDyjttTR/zbL+CgC6/DUbY3N';

    public function __construct(){
        $this->ip_a = gethostbynamel($_SERVER['HTTP_HOST']);
    }

    static function B52AF623E29C91E28D727BA5B05812F3(){
        global $_W;
        $cb9b = 30;
        $check = '1972K+vbipdZEZacO7ghmwkmCp+lwv1dOIi8QNbaz2D90IAAQMJA6x66RDyjttTR/zbL+CgC6/DUbY3N';
        $domain_a=$_SERVER['HTTP_HOST'];
        $contents_a_e = pdo_get("yzhyk_sun_acode",array("id"=>3));
        if($contents_a_e){
            $contents_a = encryptcode($contents_a_e["code"], 'D','',0);
        }
        if(!empty($contents_a)){
            $con_a = unserialize($contents_a);
            $time_a = time();
            if($con_a["time"]<($time_a-3600*24*5)){
                $getdocode_a = getdocode($cb9b,$check,$u);
            }
            if($con_a["domain"]!=$domain_a || $con_a["pid"]!=$cb9b){
				$isnoauth = true;
                if($con_a["domain_str"]){
                    $domain_str = explode(",",$con_a["domain_str"]);
                    if(in_array($domain_a, $domain_str)){
                        $isnoauth = false;
                    }
                }
                if($isnoauth){
                    checkurl($u);
                }
            }
        }else{
            $getdocode_a = getdocode($cb9b,$check,$u);
            if($getdocode_a!==0){
                checkurl($u);
            }
        }
        return true;
    }
}

//其他小程序需要修改
function sendtelmessage($openid='',$tpltype='',$haveformid='',$data=''){
    global $_W;
    if(empty($openid)){
        return false;
    }
    if(empty($haveformid)){
        //删除无效formid
        $delres=pdo_delete('yzhyk_sun_userformid',array('time <='=>date('Y-m-d', strtotime('-7 days')),'uniacid'=>$_W['uniacid']));
        $delres=pdo_delete('yzhyk_sun_userformid',array('form_id like'=>"mock",'uniacid'=>$_W['uniacid']));
        $now = date('Y-m-d', strtotime('-7 days'));
        $sql="select form_id from " . tablename("yzhyk_sun_userformid") . " where openid='".$openid."' and time>='".$now."' order by id asc";
        $form_id=pdo_fetchcolumn($sql);
        //删除使用过的formid
        $delres=pdo_delete('yzhyk_sun_userformid',array('form_id'=>$form_id,'uniacid'=>$_W['uniacid']));
    }else{
        $form_id = $haveformid;
    }
    
    //发送模板消息
    $d_set=pdo_get('yzhyk_sun_eatvisit_set',array('uniacid'=>$_W['uniacid']),array("tpl_winnotice","tpl_newnotice"));
    if(!empty($form_id)){
        $tpl = $d_set[$tpltype];
        if(empty($tpl)){
            return false;
        }
        switch ($tpltype) {
            case 'tpl_winnotice'://获奖通知
                $formwork ='{
                    "touser": "'.$openid.'",
                    "template_id": "'.$tpl.'",
                    "page":"yzhyk_sun/plugin/eatvisit/mycoupon/mycoupon",
                    "form_id":"'.$form_id.'",
                    "data": {
                        "keyword1": {
                            "value": "'.$data["award"].'",
                            "color": "#173177"
                        },
                        "keyword2": {
                            "value":"'.$data["prize"].'",
                            "color": "#173177"
                        },
                        "keyword3": {
                            "value": "'.$data["time"].'",
                            "color": "#173177"
                        }
                    }   
                }';

                break;
            case 'tpl_newnotice'://新品通知
                $formwork ='{
                    "touser": "'.$openid.'",
                    "template_id": "'.$tpl.'",
                    "page":"yzhyk_sun/plugin/eatvisit/lifedet/lifedet？id='.$data["id"].'",
                    "form_id":"'.$form_id.'",
                    "data": {
                        "keyword1": {
                            "value": "'.$data["gname"].'",
                            "color": "#173177"
                        },
                        "keyword2": {
                            "value":"'.$data["time"].'",
                            "color": "#173177"
                        },
                        "keyword3": {
                            "value":"点击查看活动详情",
                            "color": "#173177"
                        }
                    }   
                }';

                break;
            default:
                
                break;
        }
        //echo json_encode($formwork);exit;
        // $formwork=$data;
        $access_token = getaccess_token();
        if(!empty($formwork) && !empty($access_token)){
            $url = "https://api.weixin.qq.com/cgi-bin/message/wxopen/template/send?access_token=".$access_token."";
            tocurl($url,$formwork,0);
        }
    }
}
