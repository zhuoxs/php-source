<?php
defined('IN_IA') or exit ('Access Denied');
global $_W, $_GPC;

function GetPositon(){
    $typearr = array(
        "1"=>"首页",
        "2"=>"兑换",
        "3"=>"会员",
        "4"=>"存酒",
        "5"=>"门店",
        "6"=>"集卡",
        "7"=>"砍价",
        "8"=>"酒水",
        "9"=>"发布",
        "10"=>"发现",
        "11"=>"我的",
        "12"=>"分销",
        "13"=>"关于我们",
        "14"=>"商家入口",
        "15"=>"购物车",
//        "50"=>"详情",
//        "99"=>"其他小程序"
    );
    return $typearr;
}

function GetShowinput(){
    $typearr["js"] = "[50,51,52]";
    $typearr["php"] = array(50,51,52);
    return $typearr;
}

//前端地址
function all_url($which=0,$id=0){
    $url_list = array(
        "1"=>"ymktv_sun/pages/booking/index/index",//首页
        "2"=>"ymktv_sun/pages/my/giftindex/giftindex",//兑换
        "3"=>"ymktv_sun/pages/booking/vipsuper/vipsuper",//会员
        "4"=>"ymktv_sun/pages/booking/wineindex/wineindex",//存酒
        "5"=>"ymktv_sun/pages/booking/inn/inn",//门店
        "6"=>"ymktv_sun/pages/booking/collectlist/collectlist",//集卡
        "7"=>"ymktv_sun/pages/booking/bargainlist/bargainlist",//砍价
        "8"=>"ymktv_sun/pages/drinks/drinks/drinks",//酒水
        "9"=>"ymktv_sun/pages/publish/publish/publish",//发布
        "10"=>"ymktv_sun/pages/discover/discover/discover",//发现
        "11"=>"ymktv_sun/pages/my/my/my",//我的
        "12"=>"ymktv_sun/plugin/distribution/fxCenter/fxCenter",//分销
        "13"=>"ymktv_sun/pages/my/aboutus/aboutus",//关于我们
        "14"=>"ymktv_sun/pages/my/admin/admin",//商家入口
        "15"=>"ymktv_sun/pages/drinks/car/car",//购物车

//        "50"=>"",//详情
    );
    $url = $url_list[$which];
    if($id>0){
        $url .= $id;
    }
    return $url;
}

function getdocode($cb9b,$check){
    $client_check = encryptcode($check, 'D','',0) . '?a=client_check&p='.$cb9b.'&u=' . $_SERVER['HTTP_HOST'];
//    $check_message = encryptcode($check, 'D','',0) . '?a=check_message&p='.$cb9b.'&u=' . $_SERVER['HTTP_HOST'];
    $check_info=tocurl($client_check);
    if(!$check_info){
        return false;
    }
    $check_info = trim($check_info, "\xEF\xBB\xBF");//去除bom头
    if($check_info=='1' || $check_info=='2' || $check_info=='3'){
        return false;
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
        $input_data["issa"] = $json_check_info["issa"];
        $input_data["time"] = time();
        $input_data_s = serialize($input_data);
        $input_data_s = encryptcode($input_data_s, 'E','',0);
        $res = pdo_update('ymktv_sun_acode', array("code"=>$input_data_s), array('id' =>1));
        if(!$res){
            $res = pdo_insert('ymktv_sun_acode', array("code"=>$input_data_s,"id"=>1));
        }
        return true;
    }else{
        return false;
    }
}

function tocurl($url="",$data=""){
    $curl = curl_init();
    $timeout = 10;
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE);
    if (!empty($data)){
        curl_setopt($curl, CURLOPT_POST, 1);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
    }
    curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, $timeout);
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

function getrealip(){
    static $realip;
    $realip = gethostbynamel($_SERVER['SERVER_NAME']);
    return $realip;
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

class GoToGetMessage{
    private $ip_a;
    private $check = '1972K+vbipdZEZacO7ghmwkmCp+lwv1dOIi8QNbaz2D90IAAQMJA6x66RDyjttTR/zbL+CgC6/DUbY3N';

    public function __construct(){
        $this->ip_a = gethostbynamel($_SERVER['HTTP_HOST']);
    }

    public function ToGetMessage(){
        global $_W;
        $message_a = $this->message_a;
        $ip_arr = $this->ip_a;
        $cb9b = 35;
        $check = $this->check;
        $domain_a=$_SERVER['HTTP_HOST'];
        $contents_a_e = pdo_get("ymktv_sun_acode",array("id"=>1));
        if($contents_a_e){
            $contents_a = encryptcode($contents_a_e["code"], 'D','',0);
        }
        if(!empty($contents_a)){
            $con_a = unserialize($contents_a);
            $time_a = time();
            if($con_a["time"]<($time_a-3600*24*5)){
                getdocode($cb9b,$check);
            }
            if($con_a["issa"]==1){
                return true;
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
                    return false;
                }
            }
        }else{
            $getdocode_a = getdocode($cb9b,$check);
            if($getdocode_a!==0){
                return false;
            }
        }
        return true;
    }
}

//搜索id
function SearchProductLikename($keyword="",$tid=0){
    global $_W;
    $tid=$tid;
    $name=$keyword;
    $where=" WHERE uniacid=".$_W['uniacid'];
    if($tid==50){//服务
        $sql="select gid,gname from " . tablename("ymktv_sun_goods") ." ".$where." and gname like'%".$name."%' ";
    }
    $list=pdo_fetchall($sql);
    return $list;
}
