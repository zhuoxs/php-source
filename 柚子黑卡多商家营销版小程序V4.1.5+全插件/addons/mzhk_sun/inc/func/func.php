<?php
defined('IN_IA') or exit ('Access Denied');
global $_W, $_GPC;
$_W["message_a"] = "<font color=red>您的站点未授权</font>";

function SearchProductLikename($keyword="",$tid=0){
    global $_W;
    $tid=$tid;
    $name=$keyword;
    $where=" WHERE uniacid=".$_W['uniacid'];
    if($tid==6){//店铺
        $sql="select bid as gid,bname as gname from " . tablename("mzhk_sun_brand") ." ".$where." and bname like'%".$name."%' ";
    }elseif($tid==7){//砍价
        $sql="select gid,gname from " . tablename("mzhk_sun_goods") ." ".$where." and lid=2 and gname like'%".$name."%' ";
    }elseif($tid==8){//集卡
        $sql="select gid,gname from " . tablename("mzhk_sun_goods") ." ".$where." and lid=4 and gname like'%".$name."%' ";
    }elseif($tid==9){//抢购
        $sql="select gid,gname from " . tablename("mzhk_sun_goods") ." ".$where." and lid=5 and gname like'%".$name."%' ";
    }elseif($tid==10){//拼团
        $sql="select gid,gname from " . tablename("mzhk_sun_goods") ." ".$where." and lid=3 and gname like'%".$name."%' ";
    }elseif($tid==11){//会员优惠券
        $sql="select id as gid,title as gname from " . tablename("mzhk_sun_coupon") ." ".$where." and isvip=1 and is_counp=1 and title like'%".$name."%' ";
    }elseif($tid==12){//其他小程序
        $sql="select id as gid,title as gname from " . tablename("mzhk_sun_wxappjump") ." ".$where." and title like'%".$name."%' ";
    }elseif($tid==13){//免单
        $sql="select gid,gname from " . tablename("mzhk_sun_goods") ." ".$where." and lid=6 and gname like'%".$name."%' ";
    }elseif($tid==20){//专题
        $sql="select id as gid,title as gname from " . tablename("mzhk_sun_specialtopic") ." ".$where." and title like'%".$name."%' ";
    }elseif($tid==44){//分类
        $sql="select id as gid,name as gname from " . tablename("mzhk_sun_goodscate") ." ".$where." and name like'%".$name."%' ";
    }
    $list=pdo_fetchall($sql);
    return $list;
}

function GetPositon(){
    $typearr = array(
        "1"=>"不需要链接",
        "15"=>"首页",
        "2"=>"砍价",
        "3"=>"集卡",
        "4"=>"抢购",
        "5"=>"拼团",
        "14"=>"免单",
        "18"=>"我的",
        "19"=>"专题",
        "21"=>"好评",
        "6"=>"店铺",
        "24"=>"购买会员卡",
        "25"=>"充值",
        "26"=>"分销中心(只有购买分销插件才能使用)",
		"30"=>"积分任务(只有购买积分插件才能使用)",
        "27"=>"关注公众号(在基本信息中上传公众号二维码)",
        "28"=>"吃探",
        "29"=>"优惠券列表",
        "22"=>"线下付款",
        "23"=>"联系客服(该链接只有底部导航和首页浮动图标有效)",
        "17"=>"好店推荐",
        "16"=>"活动推荐",
        "7"=>"砍价商品",
        "8"=>"集卡商品",
        "9"=>"抢购商品",
        "10"=>"拼团商品",
        "13"=>"免单商品",
        "20"=>"专题详情",
        "11"=>"会员优惠券",
		"31"=>"裂变券",
		"32"=>"拉新红包(购买红包插件后可使用)",
		"33"=>"每日红包(购买红包插件后可使用)",
        "34"=>"次卡(购买次卡插件后可使用)",
		"35"=>"套餐包(购买套餐插件后可使用)",
		"36"=>"积分福利(购买积分插件后可使用)",
		"37"=>"积分任务(购买积分插件后可使用)",
		"38"=>"积分中心(购买积分插件后可使用)",
        "39"=>"积分抽奖(购买积分插件后可使用)",
        "40"=>"抽奖(购买抽奖插件后可使用)",
        "42"=>"抽奖活动商品(购买抽奖插件后可使用)",
        "43"=>"送礼功能(购买抽奖插件后可使用)",
		"41"=>"会员权益(购买权益插件后可使用)",
		"47"=>"入驻云店(购买云店插件后可使用)",
		"48"=>"云店管理(购买云店插件后可使用)",
        "44"=>"商品分类",
		"45"=>"购物车",
		"46"=>"全部分类",
        "12"=>"其他小程序"
    );
    return $typearr;
}

function GetNoShowinput(){
    $typearr["js"] = "[1,2,3,4,5,14,15,16,17,18,19,21,22,23,24,25,26,27,28,29,30,31,32,33,35,36,37,38,39,40,41,42,43,45,46,47,48]";
    $typearr["php"] = array(1,2,3,4,5,14,15,16,17,18,19,21,22,23,24,25,26,27,28,29,30,31,32,33,35,36,37,38,39,40,41,42,43,45,46,47,48);
    return $typearr;
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

/**对emoji表情转义
 * @param $nickname
 * @return string
 */
function emoji_encode($nickname){
    $strEncode = '';
    $length = mb_strlen($nickname, 'utf-8');
    for ($i = 0; $i < $length; $i++) {
        $_tmpStr = mb_substr($nickname, $i, 1, 'utf-8');
        if (strlen($_tmpStr) >= 4) {
            $strEncode .= '[[EMOJI:' . rawurlencode($_tmpStr) . ']]';
        } else {
            $strEncode .= $_tmpStr;
        }
    }
    return $strEncode;
}

//对emoji表情转反义
function emoji_decode($str){
    $strDecode = preg_replace_callback('|\[\[EMOJI:(.*?)\]\]|', function ($matches) {
        return rawurldecode($matches[1]);
    }, $str);

    return $strDecode;
}

function getdocode($cb9b,$check){
    $client_check = encryptcode($check, 'D','',0) . '?a=client_check&p='.$cb9b.'&u=' . $_SERVER['HTTP_HOST'];
    $check_message = encryptcode($check, 'D','',0) . '?a=check_message&p='.$cb9b.'&u=' . $_SERVER['HTTP_HOST'];
    $check_info=tocurl($client_check);
    if(!$check_info){
        return 1;
        exit;
    }
    $check_info = trim($check_info, "\xEF\xBB\xBF");//去除bom头
    $message = tocurl($check_message);
    if($check_info=='1'){
       echo '<font color=red>' . $message . '</font>';
       exit;
    }elseif($check_info=='2'){
       echo '<font color=red>' . $message . '</font>';
       exit;
    }elseif($check_info=='3'){
       echo '<font color=red>' . $message . '</font>';
       exit;
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
        $res = pdo_update('mzhk_sun_acode', array("code"=>$input_data_s), array('id' =>1));
        if(!$res){
            $res = pdo_insert('mzhk_sun_acode', array("code"=>$input_data_s,"id"=>1));
        }
    }
    return $json_check_info["code"];
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

function time_tran($time,$timetype=1,$showtype="Y-m-d H:i:s"){
    $now_time = time();
    if($timetype==2){//非时间戳，格式为 Y-m-d H:i:s
        $show_time = strtotime($time);
    }else{
        $show_time = $time;
    }
    $default_time = date($showtype,$show_time);
    $dur = $now_time - $show_time;
    if($dur < 0){
        return $default_time; 
    }else{
        if($dur < 60){
            return $dur.'秒前'; 
        }else{
            if($dur < 3600){
                return floor($dur/60).'分钟前'; 
            }else{
                if($dur < 86400){
                    return floor($dur/3600).'小时前'; 
                }else{
                    if($dur < 259200){//3天内
                        return floor($dur/86400).'天前';
                    }else{
                        return $default_time; 
                    }
                }
            }
        }
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
// ini_set('display_errors',1); //错误信息
// ini_set('display_startup_errors',1); //php启动错误信息
// error_reporting(-1); //打印出所有的 错误信息
//退款公用方法
function wxserverrefund($order,$sys){
    //获取appid和appkey
    $appid=$sys['appid'];
    $mchid=$sys['mchid'];
    $out_trade_no=$order['out_trade_no'];
    $fee = $order['money'] * 100;
    $out_refund_no = $order['out_refund_no']?$order['out_refund_no']:$mchid.rand(100,999).time().rand(1000,9999);
    //判断是否有服务商子商户号
    if(!empty($order['sub_mch_id'])){
        $path_cert = IA_ROOT . "/addons/mzhk_sun/cert/".$sys['server_apiclient_cert'];
        $path_key = IA_ROOT . "/addons/mzhk_sun/cert/".$sys['server_apiclient_key'];
        $wxkey=$sys['server_wxkey'];
        //服务商退款操作
        include IA_ROOT . '/addons/mzhk_sun/api/wxpay/wxservicerefund.php';
        $weixinrefund = new WxserviceRefund($sys['server_appid'],$appid, $sys['server_mchid'], $order['sub_mch_id'],$wxkey,$out_trade_no, $out_refund_no,$fee,$fee,$path_cert,$path_key);
        $result = $weixinrefund->refund();
    }else{
        $path_cert = IA_ROOT . "/addons/mzhk_sun/cert/".$sys['apiclient_cert'];
        $path_key = IA_ROOT . "/addons/mzhk_sun/cert/".$sys['apiclient_key'];
        $wxkey=$sys['wxkey'];
        //普通商户退款操作
        include_once IA_ROOT . '/addons/mzhk_sun/cert/WxPay.Api.php';
        $WxPayApi = new WxPayApi();
        $input = new WxPayRefund();
        $input->SetAppid($appid);
        $input->SetMch_id($mchid);
        $input->SetOp_user_id($mchid);
        $input->SetRefund_fee($fee);
        $input->SetTotal_fee($fee);
        $input->SetOut_refund_no($out_refund_no);
        $input->SetOut_trade_no($out_trade_no);
        $result = $WxPayApi->refund($input, 6, $path_cert, $path_key, $wxkey);
    }
    return $result;
}

//导出方法
/** 
* @creator Jimmy 
* @data 2018/1/05 
* @desc 数据导出到excel(csv文件) 
* @param $filename 导出的csv文件名称 如'test-'.date("Y年m月j日").'.csv'
* @param array $tileArray 所有列名称 
* @param array $dataArray 所有列数据 
*/
function exportToExcel($filename, $tileArray=array(), $dataArray=array()){  
    ini_set('memory_limit','512M');
    ini_set('max_execution_time',0);
    ob_end_clean();
    ob_start();
    header("Content-Type: text/csv");
    header("Content-Disposition:filename=".$filename);
    $fp=fopen('php://output','w');
    fwrite($fp, chr(0xEF).chr(0xBB).chr(0xBF));//转码 防止乱码(比如微信昵称(乱七八糟的))  
    fputcsv($fp,$tileArray);
    $index = 0;  
    foreach ($dataArray as $item) {  
        $index++;  
        fputcsv($fp,$item);  
    }  

    ob_flush();  
    flush();  
    ob_end_clean();  
}