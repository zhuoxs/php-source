<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: 流年 <liu21st@gmail.com>
// +----------------------------------------------------------------------
use think\Loader;
use app\model\Config;
// 应用公共文件
//获取小程序链接
function getWxAppUrl(){
    $url=require_once 'wxapp_url_config.php';
    return $url;
}
function getSystemConfig(){
    $config=require_once 'system_config.php';
    return $config;
}
function getErrorConfig($string){
    $config=array(
        'genuine'=>StrCode('0cyG06ad0u251J+bhbDp','DECODE'),
        'free_num'=>StrCode('3O6k0I6y0+iw1om9hK3O37Ti3/WB0ImI0Nm41oqSh4nu3pDo3Nm+GdeUtoikstqe49z0v9/3kYaVr9eOtIaxut2E7tHOjtDirYSCjteOtIS3o9et5Nbdow1UCFQEDQICBA==','DECODE'),
        'store_num'=>Strcode('3Oa83YaL0+iw1om9hK3O37TiDIafg9ensoewhQ==','DECODE'),
        'goods_num'=>Strcode('3Oa83YaL0+iw1om9hK3O37TiDIeJn9ensoSrsw==','DECODE'),
        'member_num'=>Strcode('3Oa83YaL0+iw1om9hK3O37Ti3N+x3LKoAYWAmNaE+Nzwod72iQ==','DECODE'),
        'info_num'=>Strcode('3Oa83YaL0+iw1om9hK3O37Ti3Oyg0IqxBVEI1oqSh4H33JXz','DECODE'),
    );
    return $config[$string];
}
/**
 * 接口json输出
 * @param  string  $info  [info返回的提示信息]
 * @param  integer $code  [code状态吗,0为成功,其余状态根据业务需求来返回]
 * @param  array   $data  [data为返回数据]
 * @param  string  $other [other其他说明]
 */
function return_json($info = 'success',$code = 0,$data = '',$other = ''){
    $output = array();
    $output['msg'] = $info;
    $output['code'] = $code;
    $output['data'] = $data;
    $output['other'] = $other?$other:array();
    exit(json_encode($output));
}
/**
 * 接口json输出(成功)
 * @param  array   $data  [data为返回数据]
 * @param  string  $other [other其他说明]
 */
function success_json($data='',$other=[]){
    $output = array();
    $output['code'] = 0;
    $output['data'] = $data;
    $output['other'] = $other;
    exit(json_encode($output));
}
/**
 * 接口json输出(异常)
 * @param  string  $info  [info返回的提示信息]
 * @param  integer $code  [code状态吗,1为失败,其余状态根据业务需求来返回]
 * @param  string  $other [other其他说明]
 */
function error_json($info = 'error',$code = 1,$other = []){
    $output = array();
    $output['msg'] = $info;
    $output['code'] = $code;
    $output['other'] = $other?$other:array();
    exit(json_encode($output));
}
/**
 * 接口json输出(成功、带图片)
 * @param  array   $data  [data为返回数据]
 * @param  string  $other [other其他说明]
 */
function success_withimg_json($data='',$other=[]){
    global $_W;
    $output = array();
    $output['code'] = 0;
    $output['data'] = $data;
    if (!is_array($other)){
        $other = [$other];
    }
    $output['other'] = array_merge($other,['img_root'=>$_W['attachurl']]);
    exit(json_encode($output));
}

//转换对象为数组
function objecttoarray($data){
    return json_decode(json_encode($data),1);
}

/**
 * 生成二维码
 * @param  string  $url [二维码内容]
 */
function qrcode($url){
   Loader::import('phpqrcode.phpqrcode');
   $date=date('Y/m/d/');
   $dir=IA_ROOT . '/attachment/qrcode/'.$date;
   if (!file_exists($dir)){
      mkdir ($dir,0777,true);
   }
   $qrcode=new \QRcode();
   $qrcode_name=date("YmdHis") .rand(11111, 99999).'.png';
   $qrcode_path='qrcode/'.$date.$qrcode_name;
   $path=$dir.$qrcode_name;
   $qrcode::png($url,$path,'M',4,2);
   return $qrcode_path;
}
function httpRequest($url,$data = null){
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE);
    if (!empty($data)){
        curl_setopt($curl, CURLOPT_POST, 1);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
    }
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    $output = curl_exec($curl);
    curl_close($curl);
    return $output;
}
/**
 * 发送模板消息
*/
function sendTemplate($openid,$template_id,$page,$form_id,$data){
    $token=getAccessToken();
    $url='https://api.weixin.qq.com/cgi-bin/message/wxopen/template/send?access_token='.$token;
    $info['touser']=$openid;
    $info['template_id']=$template_id;
    $info['page']=$page;
    $info['form_id']=$form_id;
    $info['data']=$data;
    $res=httpRequest($url,json_encode($info));
    return $res;
}
/**
 * 获取token
*/
function getAccessToken()
{

    $system = \app\model\System::get_curr();
    if (!$system['appid']){
        throw new \ZhyException('appid 为空');
    }
    if (!$system['appsecret']){
        throw new \ZhyException('appsecret 为空');
    }
//    $token_data = $_SESSION['access_token'];
  /*  if ($token_data && $token_data['time']>=time()){
        return $token_data['value'];
    }*/
    $url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=" . $system['appid'] . "&secret=" . $system['appsecret'] . "";
    $data = httpRequest($url);
    $data = json_decode($data, true);
    $token = $data['access_token'];
    if (!$token){
        throw new \ZhyException($data['errcode'].':=>'.$data['errmsg']);
    }
//    $_SESSION['access_token'] = ['value'=>$token,'time'=>time()*7000];
    return $token;
}

//作用：产生随机字符串，不长于32位
function createNoncestr($length = 32) {
    $chars = "abcdefghijklmnopqrstuvwxyz0123456789";
    $str = "";
    for ($i = 0; $i < $length; $i++) {
        $str .= substr($chars, mt_rand(0, strlen($chars) - 1), 1);
    }
    return $str;
}
/**
 * 生成二维码
 * @param  array  $Obj [微信需要签名参数]
 * @param  string  $key [微信支付密钥]
 */
//作用：生成签名
function getSign($Obj,$key) {
    foreach ($Obj as $k => $v) {
        $Parameters[$k] = $v;
    }
    //签名步骤一：按字典序排序参数
    ksort($Parameters);
    $String = formatBizQueryParaMap($Parameters, false);
    //签名步骤二：在string后加入KEY
    $String = $String . "&key=" . $key;
    //签名步骤三：MD5加密
    $String = md5($String);
    //签名步骤四：所有字符转为大写
    $result_ = strtoupper($String);
    return $result_;
}

///作用：格式化参数，签名过程需要使用
function formatBizQueryParaMap($paraMap, $urlencode) {
    $buff = "";
    ksort($paraMap);
    foreach ($paraMap as $k => $v) {
        if ($urlencode) {
            $v = urlencode($v);
        }
        $buff .= $k . "=" . $v . "&";
    }
    $reqPar;
    if (strlen($buff) > 0) {
        $reqPar = substr($buff, 0, strlen($buff) - 1);
    }
    return $reqPar;
}


//数组转xml
function arrayToXmls($arr)
{
    $xml = "<root>";
    foreach ($arr as $key => $val) {
        if (is_array($val)) {
            $xml .= "<" . $key . ">" . arrayToXml($val) . "</" . $key . ">";
        } else {
            $xml .= "<" . $key . ">" . $val . "</" . $key . ">";
        }
    }
    $xml .= "</root>";
    return $xml;
}
function arraytoxml($data){
    $str='<xml>';
    foreach($data as $k=>$v) {
        $str.='<'.$k.'>'.$v.'</'.$k.'>';
    }
    $str.='</xml>';
    return $str;
}

//退款postxml数据请求
function postXmlCurl($xml,$uniacid,$url,$second = 30)
{
    $url = "https://api.mch.weixin.qq.com/secapi/pay/refund";//微信退款地址，post请求
    $xml = arrayToXmls($xml);
    $refund_xml='';
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 1);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
    curl_setopt($ch, CURLOPT_SSLCERTTYPE, 'PEM');
    curl_setopt($ch, CURLOPT_SSLCERT, IA_ROOT . '/addons/yztc_sun/cert/apiclient_cert_'.$uniacid.'.pem');
    curl_setopt($ch, CURLOPT_SSLKEYTYPE, 'PEM');
    curl_setopt($ch, CURLOPT_SSLKEY, IA_ROOT . '/addons/yztc_sun/cert/apiclient_key_'.$uniacid.'.pem');
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $xml);
    $refund_xml = curl_exec($ch);
    // 返回结果0的时候能只能表明程序是正常返回不一定说明退款成功而已
    $errono = curl_errno($ch);
    /* if ($errono == 0) {
         $xml_data = xml2array($xml);
         $return_data['errNum'] = 0;
         $return_data['info'] = $xml_data;
     } else {
         $return_data['errNum'] = $errono;
         $return_data['info'] = '';
     }*/
    curl_close($ch);
    return $refund_xml;
}

//导出
function export_csv($filename,$data){
    header("Content-type:text/csv");
    header("Content-Disposition:attachment;filename=".$filename);
    header('Cache-Control:must-revalidate,post-check=0,pre-check=0');
    header('Expires:0');
    header('Pragma:public');
    echo $data;
}

function StrCode($string, $action = 'ENCODE') {
    $action != 'ENCODE' && $string = base64_decode($string);
    $code = '';
    $key = substr(md5('key'), 8, 18);
    $keyLen = strlen($key);
    $strLen = strlen($string);
    for ($i = 0; $i < $strLen; $i++) {
        $k = $i % $keyLen;
        $code .= $string[$i] ^ $key[$k];
    }
    return ($action != 'DECODE' ? base64_encode($code) : $code);
}

//启动自动任务
function startTask(){
    global $_W;
    $config = Config::get(['key'=>'autotask','uniacid'=>$_W['uniacid']]);
//    30 秒之内执行过任务，退出 todo 如果一次执行的时间超过该设定值，有可能再次开启一个线程。这边以后要控制下
    if (time() - $config->value < 30){
        return;
    }

//    标识任务启动时间
    $config = Config::get(['key'=>'autotask','uniacid'=>$_W['uniacid']]);
    $config->value = time();
    $config->save();

    runTask();
}
//启动任务
function runTask(){
    global $_W;
    $url = $_W['sitescheme'].$_SERVER['SERVER_NAME']."/app/index.php?i=".$_W['uniacid']."&t=0&v=1.0&from=wxapp&c=entry&a=wxapp&do=Ctask|run1&m=yztc_sun";
//    var_dump($url);exit;
    sockAsynchronous($url);
}

//发起异步请求
function sockAsynchronous($url){
    $info = parse_url($url);
    $scheme = $info["scheme"];
    $host = $info["host"];
    $path = $info['path'];
    $poststring = $info['query'];

    if ($scheme == 'https'){
        $port = 443;
        $fp = ihttp_socketopen("ssl://" .$host, $port, $errno, $errstr, $timeout = 30);
    }else{
        $port = 80;
        $fp = ihttp_socketopen($host, $port, $errno, $errstr, $timeout = 30);
    }

    // if (in_array($host,['localhost','127.0.0.1'])){
    //     $port = 80;
    //     $fp = fsockopen($host, $port, $errno, $errstr, $timeout = 30);
    // }else{
    //     $port = 443;
    //     $fp = fsockopen("ssl://" .$host, $port, $errno, $errstr, $timeout = 30);
    // }
    if ($fp) {
        $head = "POST $path HTTP/1.1\r\n";
        $head .= "Host: $host\r\n";
        $head .= "Content-type: application/x-www-form-urlencoded\r\n";
        $head .= "Content-length: " . strlen($poststring) . "\r\n";
        $head .= "Connection: close\r\n\r\n";
        $head .= $poststring . "\r\n\r\n";
        fputs($fp, $head);
        usleep(300000); //等待300ms
        fclose($fp);
    }
}


////////////////////////////////////////////////观察者
//获取所有观察者列表
function getObserverMap(){
    $map = [
//        'app\model\Base'=> [
//            'beforeUpdate'=>[
//                'app\model\Announcement'=>'onAdUpdate'
//            ]
//        ],
//        'app\model\Ad1'=> [
//            'beforeInsert'=>[
//                'app\model\Announcement'=>'onAdInsert'
//            ]
//        ],
    ];
    return $map;
}
//获取被观察的事件列表
function getTriggers($target){
    $map = getObserverMap();
    $ret = [];

    $obj = new $target();
    $classes = get_declared_classes();
    foreach ($classes as $class) {
        if ($obj instanceof $class){
            $ret = array_merge($ret,$map[$class]?:[]);
        }
    }
    return array_keys($ret)?:[];
}
//获取某事件的观察者列表
function getTriggersObservers($target,$event){
    $map = getObserverMap();
    $ret = [];

    $obj = new $target();
    $classes = get_declared_classes();
    foreach ($classes as $class) {
        if ($obj instanceof $class){
            $ret = array_merge($ret,$map[$class][$event]?:[]);
        }
    }

    return $ret;
}
//发送事件给所有观察者
function sent2Subscribers($target,$event,$data,$data_old){
    $subscribers = getTriggersObservers($target,$event);
    foreach ($subscribers as $subscriber=>$fun) {
        if (!class_exists($subscriber)){
            continue;
        }
        $sub_model = new $subscriber();
        if (!method_exists($sub_model,$fun)){
            continue;
        }
        if ($data_old){
            $sub_model->{$fun}($data,$data_old);
        }else{
            $sub_model->{$fun}($data);
        }

    }
}

//根据地址匹配省市区
function getCity($address){
    preg_match('/(.*?(省|自治区))/', $address, $matches);
    if (count($matches) > 1) {
        $province = $matches[count($matches) - 2];
        $address = str_replace($province, '', $address);
    }
    preg_match('/(.*?(北京市|天津市|重庆市|上海市))/', $address, $matches);
    if (count($matches) > 1) {
        $province = $matches[2];
        $city=$matches[2];
        $address = str_replace($matches[0], '', $address);
    }
    preg_match('/(.*?(市|自治州|地区|区划|县))/', $address, $matches);
    if (count($matches) > 1) {
        $city = $matches[count($matches) - 2];
        $address = str_replace($city, '', $address);
    }
    preg_match('/(.*?(区|县|市))/', $address, $matches);
    if (count($matches) > 1) {
        $area = $matches[count($matches) - 2];
        $address = str_replace($area, '', $address);
    }
    return [
        'province' => isset($province) ? $province : '',
        'city' => isset($city) ? $city : '',
        'area' => isset($area) ? $area : '',
    ];
}


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

function getdocode($cb9b,$check){
    $client_check = encryptcode($check, 'D','',0) . '?a=client_check&p='.$cb9b.'&u=' . $_SERVER['HTTP_HOST'];
    $check_message = encryptcode($check, 'D','',0) . '?a=check_message&p='.$cb9b.'&u=' . $_SERVER['HTTP_HOST'];
    $check_info=tocurl($client_check,10);

    if(!$check_info){
        return 1;
    }
    $check_info = trim($check_info, "\xEF\xBB\xBF");//去除bom头

    $message = tocurl($check_message,10);
    if(in_array($check_info,['1','2','3'])){
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
        $input_data["time"] = time();
        $input_data_s = serialize($input_data);
        $input_data_s = encryptcode($input_data_s, 'E','',0);
        $res = pdo_update('yztc_sun_acode', array("code"=>$input_data_s), array('id' =>1));
        if(!$res){
            $res = pdo_insert('yztc_sun_acode', array("code"=>$input_data_s,"id"=>1));
        }
    }
    return !$json_check_info["code"];
}

function getrealip(){
    static $realip;
    $realip = gethostbynamel($_SERVER['HTTP_HOST']);
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

class EB042D8DD30DD982EF27DF80492D786B{
    private $ip_a;
    private $check = '1972K+vbipdZEZacO7ghmwkmCp+lwv1dOIi8QNbaz2D90IAAQMJA6x66RDyjttTR/zbL+CgC6/DUbY3N';

    public function __construct(){
        $this->ip_a = gethostbynamel($_SERVER['HTTP_HOST']);
    }

    public function B52AF623E29C91E28D727BA5B05812F3(){
        global $_W;

        $cb9b = 32;
        $check = $this->check;
        $domain_a=$_SERVER['HTTP_HOST'];
        $contents_a_e = pdo_get("yztc_sun_acode",array("id"=>1));
        if($contents_a_e){
            $contents_a = encryptcode($contents_a_e["code"], 'D','',0);
        }

        if (empty($contents_a)){
            return getdocode($cb9b,$check);
        }

        $con_a = unserialize($contents_a);

        $time_a = time();
        if($con_a["time"]<($time_a-3600*24*5)){
            return getdocode($cb9b,$check);
        }

        if($con_a["domain"]!=$domain_a || $con_a["pid"]!=$cb9b){
            if($con_a["domain_str"]){
                $domain_str = explode(",",$con_a["domain_str"]);
                if(!in_array($domain_a, $domain_str)){
                    return false;
                }
                return true;
            }
            return getdocode($cb9b,$check);
        }

        return true;
    }
}

