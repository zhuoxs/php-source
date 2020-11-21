<?php
// +----------------------------------------------------------------------
// | 微擎模块
// +----------------------------------------------------------------------
// | Copyright (c) 柚子黑卡  All rights reserved.
// +----------------------------------------------------------------------
// | Author: 淡蓝海寓
// +----------------------------------------------------------------------


/**
 *
 * 产生随机字符串，不长于32位
 * @param int $length
 * @return 产生的随机字符串
 */
function getNonceStr($length = 32)
{
    $chars = "abcdefghijklmnopqrstuvwxyz0123456789";
    $str ="";
    for ( $i = 0; $i < $length; $i++ )  {
        $str .= substr($chars, mt_rand(0, strlen($chars)-1), 1);
    }
    return $str;
}

/**
 * 友好时间显示
 * @param $time
 * @return bool|string
 */
function friend_date($time)
{
    if (!$time)
        return false;
    $fdate = '';
    $d = time() - intval($time);
    $ld = $time - mktime(0, 0, 0, 0, 0, date('Y')); //得出年
    $md = $time - mktime(0, 0, 0, date('m'), 0, date('Y')); //得出月
    $byd = $time - mktime(0, 0, 0, date('m'), date('d') - 2, date('Y')); //前天
    $yd = $time - mktime(0, 0, 0, date('m'), date('d') - 1, date('Y')); //昨天
    $dd = $time - mktime(0, 0, 0, date('m'), date('d'), date('Y')); //今天
    $td = $time - mktime(0, 0, 0, date('m'), date('d') + 1, date('Y')); //明天
    $atd = $time - mktime(0, 0, 0, date('m'), date('d') + 2, date('Y')); //后天
    if ($d == 0) {
        $fdate = '刚刚';
    } else {
        switch ($d) {
            case $d < $atd:
                $fdate = date('Y年m月d日', $time);
                break;
            case $d < $td:
                $fdate = '后天' . date('H:i', $time);
                break;
            case $d < 0:
                $fdate = '明天' . date('H:i', $time);
                break;
            case $d < 60:
                $fdate = $d . '秒前';
                break;
            case $d < 3600:
                $fdate = floor($d / 60) . '分钟前';
                break;
            case $d < $dd:
                $fdate = floor($d / 3600) . '小时前';
                break;
            case $d < $yd:
                $fdate = '昨天' . date('H:i', $time);
                break;
            case $d < $byd:
                $fdate = '前天' . date('H:i', $time);
                break;
            case $d < $md:
                $fdate = date('m月d日 H:i', $time);
                break;
            case $d < $ld:
                $fdate = date('m月d日', $time);
                break;
            default:
                $fdate = date('Y年m月d日', $time);
                break;
        }
    }
    return $fdate;
}





/**
 * 获取数组中的某一列
 * @param type $arr 数组
 * @param type $key_name  列名
 * @return type  返回那一列的数组
 */
function get_arr_column($arr, $key_name)
{
    $arr2 = array();
    foreach($arr as $key => $val){
        if(!in_array($val[$key_name],$arr2))
            $arr2[] = $val[$key_name];
    }
    return $arr2;
}


/**
 * 获取url 中的各个参数  类似于 pay_code=alipay&bank_code=ICBC-DEBIT
 * @param type $str
 * @return type
 */
function parse_url_param($str){
    $data = array();
    $str = explode('?',$str);
    $str = end($str);
    $parameter = explode('&',$str);
    foreach($parameter as $val){
        $tmp = explode('=',$val);
        $data[$tmp[0]] = $tmp[1];
    }
    return $data;
}


/**
 * 二维数组排序
 * @param $arr
 * @param $keys
 * @param string $type
 * @return array
 */
function array_sort($arr, $keys, $type = 'desc')
{
    $key_value = $new_array = array();
    foreach ($arr as $k => $v) {
        $key_value[$k] = $v[$keys];
    }
    if ($type == 'asc') {
        asort($key_value);
    } else {
        arsort($key_value);
    }
    reset($key_value);
    foreach ($key_value as $k => $v) {
        $new_array[$k] = $arr[$k];
    }
    return $new_array;
}


/**
 * 多维数组转化为一维数组
 * @param 多维数组
 * @return array 一维数组
 */
function array_multi2single($array)
{
    static $result_array = array();
    foreach ($array as $value) {
        if (is_array($value)) {
            array_multi2single($value);
        } else
            $result_array [] = $value;
    }
    return $result_array;
}


/**
 * 二维数组合并并排序
 * @param $a 二维数组
 * @param $b 二维数组
 * @return array
 */
function array_to_combine($a,$b,$keys='',$type = 'desc')
{
    $result_array = array();
    if(is_array($a)){
        foreach ($a as $v) {
            $result_array[] = $v;
        }
    }
    if(is_array($a)){
        foreach ($b as $v) {
            $result_array[] = $v;

        }
    }
    if($keys&&count($result_array)>0){
        $result_array =  array_sort($result_array,$keys,$type);
    }

    return $result_array;
}

/**
 * 去除多维数组中最外层的key
 */
function  array_remove_key($array){
    $result_array = array();
    if(is_array($array)){
        foreach ($array as  $v) {
            $result_array[] = $v;
        }
    }
    return $result_array;
}


/**
 * 转换数组key
 */
function  array_set_key($array=array(),$key=''){
    $result_array = array();
    if(is_array($array)){
        foreach ($array as  $v) {
            $result_array[$v[$key]] = $v;
        }
    }
    return $result_array;
}







function https_request($url, $data = null)
{
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE);
    if (!empty($data)) {
        curl_setopt($curl, CURLOPT_POST, 1);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
    }
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($curl,CURLOPT_CONNECTTIMEOUT,60);
    curl_setopt($curl, CURLOPT_SSLVERSION, 4);
    $output = curl_exec($curl);
    curl_close($curl);
    return $output;
}



/**
 * 获取微信access_tokens
 * @param $appid
 * @param $appsecret
 * @param int $new
 * @return mixed
 */

function get_token($appid='',$appsecret='',$new=0){
    if(!$appid) $appid = config('appid');
    if(!$appsecret) $appsecret = config('appsecret');
    if(empty($appid)||empty($appsecret))  return array('status'=>-1,'msg'=>'appid或appsecret不能为空');

    $cache_name = 'yusq_sun_access_tokens'.$appid;
    $access_tokens = cache_load($cache_name);
    if($access_tokens && $new==0){
        if($access_tokens['active_time']>=time()){
            return array('status'=>1,'token'=>$access_tokens['data']);
        }
    }
    $url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=$appid&secret=$appsecret";
    $ret_json = curl_get_contents($url);
    $ret = json_decode($ret_json);
    if($ret -> access_token){
        $data = array(
            'active_time'=>time()+7000,
            'data'=>$ret -> access_token
        );
        cache_write($cache_name, $data);
        return array('status'=>1,'token'=>$ret -> access_token);
    }else{
        return array('status'=>$ret->errcode,'msg'=>$ret -> errmsg);
    }
}

//生成微信二维码
function get_wx_code($appid,$appsecret,$scene,$page,$new=0){

    $acctoken = get_token($appid, $appsecret,$new);
    if($acctoken['status']!=1) return $acctoken;
    $token = $acctoken['token'];
    $url ='https://api.weixin.qq.com/wxa/getwxacodeunlimit?access_token='.$token;
    $json = '{	
		    "scene":"'.$scene.'",	 	
			"page":"'.$page.'"
		 }';
    $re = curlp($url,$json);
    $res = json_decode($re,true);
    if($res['errcode']=='40001'){
        return  get_wx_code($appid,$appsecret,$scene,$page,1);
    }
    @require_once (IA_ROOT . '/framework/function/file.func.php');
    $destination_folder = ATTACHMENT_ROOT; //上传文件路径
    $destination = file_random_name($destination_folder, 'png');
    if(file_write($destination,$re)){
        $pinfo = pathinfo($destination);
        $fname = $pinfo['basename'];
        @$filename = $fname;
        @file_remote_upload($filename);
        return array('status'=>1,'url'=>toimage($destination));
    }else{
        return array('status'=>-1,'msg'=>'保存图片失败');
    }

}

function tocurl($url="",$data=""){
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


function curlp($post_url,$xjson){//php post
    $ch = curl_init($post_url);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); //ssl证书不检验
    curl_setopt($ch, CURLOPT_USERAGENT,useragent());
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
    curl_setopt($ch, CURLOPT_POSTFIELDS,$xjson);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER,true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
            'Content-Length: ' . strlen($xjson))
    );
    $respose_data = curl_exec($ch);
    return $respose_data;
}


function useragent($mobile=null){
    $ua1 = 'Mozilla/5.0 (Windows NT 5.1; rv:25.0) Gecko/20100101 Firefox/25.0';
    $ua2= 'Mozilla/5.0 (Windows NT 6.0) AppleWebKit/537.1 (KHTML, like Gecko) Chrome/21.0.1180.89 Safari/537.1';
    $ua3 = 'Mozilla/5.0 (Windows NT 6.1; rv:25.0) Gecko/20100101 Firefox/25.0';
    $ua4 = 'Mozilla/5.0 (Windows NT 6.2; rv:25.0) Gecko/20100101 Firefox/25.0';
    $ua5 = 'Mozilla/5.0 (Windows NT 5.1) AppleWebKit/537.1 (KHTML, like Gecko) Chrome/21.0.1180.89 Safari/537.1';
    $ua6 = 'Mozilla/5.0 (Windows NT 6.2) AppleWebKit/537.1 (KHTML, like Gecko) Chrome/21.0.1180.89 Safari/537.1';
    $ua7 = 'Mozilla/5.0 (Windows NT 5.1) AppleWebKit/534.57.2 (KHTML, like Gecko) Version/5.1.7 Safari/534.57.2';
    $ua8 = 'Mozilla/4.0 (compatible; MSIE 8.0; Windows NT 5.1; Trident/4.0; .NET CLR 2.0.50727; .NET CLR 1.1.4322; .NET4.0C; .NET CLR 3.0.04506.30; InfoPath.2; .NET4.0E; .NET CLR 3.0.4506.2152; .NET CLR 3.5.30729)';
    $ua9 = 'Mozilla/4.0 (compatible; MSIE 5.5; Windows NT 5.1; .NET CLR 2.0.50727; .NET CLR 1.1.4322; .NET4.0C; .NET CLR 3.0.04506.30; InfoPath.2; .NET4.0E; .NET CLR 3.0.4506.2152; .NET CLR 3.5.30729)';
    $ua10 = 'Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; .NET CLR 2.0.50727; .NET CLR 1.1.4322; .NET4.0C; .NET CLR 3.0.04506.30; InfoPath.2; .NET4.0E; .NET CLR 3.0.4506.2152; .NET CLR 3.5.30729)';
    $ua11 = 'Mozilla/4.0 (compatible; MSIE 7.0; Windows NT 5.1; .NET CLR 2.0.50727; .NET CLR 1.1.4322; .NET4.0C; .NET CLR 3.0.04506.30; InfoPath.2; .NET4.0E; .NET CLR 3.0.4506.2152; .NET CLR 3.5.30729)';
    $uaarr = array($ua1,$ua2,$ua3,$ua4,$ua5,$ua6,$ua7,$ua8,$ua9,$ua10,$ua11);
    if($mobile){
        return 'Mozilla/5.0 (Linux; Android 4.4.4; HM NOTE 1LTEW Build/KTU84P) AppleWebKit/537.36 (KHTML, like Gecko) Version/4.0 Chrome/33.0.0.0 Mobile Safari/537.36 MicroMessenger/6.0.2.56_r958800.520 NetType/3gnet';
        //Mozilla/5.0 (Linux; Android 4.4.4; HM NOTE 1LTEW Build/KTU84P) AppleWebKit/537.36 (KHTML, like Gecko) Version/4.0 Chrome/33.0.0.0 Mobile Safari/537.36 MicroMessenger/6.0.2.56_r958800.520 NetType/3gnet
        //Mozilla/5.0 (iPhone; CPU iPhone OS 7_0_4 like Mac OS X) AppleWebKit/537.51.1 (KHTML, like Gecko) Mobile/11B554a MicroMessenger/5.2
    }else{
        return $uaarr[rand(0,count($uaarr)-1)];
    }
}

function curl_get_contents($url){
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER,true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
    curl_setopt($ch, CURLOPT_TIMEOUT, 5);
    curl_setopt($ch, CURLOPT_USERAGENT, "IE 6.0");
    $r = curl_exec($ch);
    curl_close($ch);
    if($r===false) return file_get_contents($url);
    return $r;
}


/**
 * 保留后两位
 * @param 金额 $fee
 * @return string
 */
function fee_format($fee){
    $fee  = number_format($fee, 2, '.', '');
    if(floatval($fee)<0){
        $fee = "0.00";
    }
    return $fee;
}



function config($key=''){
    global $_W;
    $cache_name = C('modulename').'_config_'.$_W['uniacid'];
    if($data = cache_load($cache_name)){
        if($key) return $data[$key];
        return $data ;
    }
    $info = pdo_get(C('modulename').'_config', array('uniacid'=>$_W['uniacid']));
    if($info){
        cache_write($cache_name, $info);
        if($key) return $info[$key];
        return $info;
    }
    return $info;
}



function get_form_id($uid=0){
    global $_W;
    if(!$uid) return false;
    //删除无效formid
    pdo_delete(C('modulename').'_form_id_data',array('status'=>1,'uniacid'=>$_W['uniacid']));
    pdo_delete(C('modulename').'_form_id_data',array('time <='=> time()-6*86400,'uniacid'=>$_W['uniacid']));
    $where  = array(
        'user_id'=> $uid,
        'status' =>	0,
        'time >' => time()-6*86400,
        'uniacid'=>$_W['uniacid']
    );
    $info = pdo_get(C('modulename').'_form_id_data',$where,array('id','form_id','type','total_num','send_num'));

    return $info;
}



/**
 * 获取装修风格
 * @param string $style_id
 * @return array|bool|Memcache|mixed|Redis|string|void
 */
function cases_style($style_id=''){
    global $_W;
    $data = array();
    $cache_name = C('modulename').'_cases_style_'.$_W['uniacid'];
    if($data = cache_load($cache_name)){
        if($style_id){
            return isset($data[$style_id])?$data[$style_id]:'' ;
        }
        return $data ;
    }
    $list  = M('casesStyle')->where(array('status'=>1,'uniacid'=>$_W['uniacid']))->order('sort_order desc')->select();

    if($list){
        foreach ($list as $v){
            $data[$v['style_id']] = $v;
        }
    }
    if($data){
        cache_write($cache_name, $data);
        if($style_id){
            return isset($data[$style_id])?$data[$style_id]:'' ;
        }
        return $data;
    }
    return '';
}


/**
 * 删除风格缓存
 */
function del_cases_style_cache(){
    global $_W;
    $cache_name = C('modulename').'_cases_style_'.$_W['uniacid'];
    cache_delete($cache_name);
}



/**
 * 获取装修类型
 * @param string $cat_id
 * @return array|bool|Memcache|mixed|Redis|string|void
 */
function cases_category($cat_id=''){
    global $_W;
    $data = array();
    $cache_name = C('modulename').'_cases_category_'.$_W['uniacid'];
    if($data = cache_load($cache_name)){
        if($cat_id){
            return isset($data[$cat_id])?$data[$cat_id]:'';
        }
        return $data ;
    }
    $list  = M('casesCategory')->where(array('status'=>1,'uniacid'=>$_W['uniacid']))->order('sort_order desc')->select();
    if($list){
        foreach ($list as $v){
            $data[$v['cat_id']] = $v;
        }
    }
    if($data){
        cache_write($cache_name, $data);
        if($cat_id){
            return isset($data[$cat_id])?$data[$cat_id]:'';
        }
        return $data;
    }
    return '';
}

/**
 * 删除风格缓存
 */
function del_cases_category_cache(){
    global $_W;
    $cache_name = C('modulename').'_cases_category_'.$_W['uniacid'];
    cache_delete($cache_name);
}




/**
 * 获取攻略类型
 * @param string $cat_id
 * @return array|bool|Memcache|mixed|Redis|string|void
 */
function strategy_category($cat_id=''){
    global $_W;
    $data = array();
    $cache_name = C('modulename').'_strategy_category_'.$_W['uniacid'];
    if($data = cache_load($cache_name)){
        if($cat_id){
            return isset($data[$cat_id])?$data[$cat_id]:'';
        }
        return $data ;
    }
    $list  = M('strategyCategory')->where(array('status'=>1,'uniacid'=>$_W['uniacid']))->order('sort_order desc')->select();
    if($list){
        foreach ($list as $v){
            $data[$v['cat_id']] = $v;
        }
    }
    if($data){
        cache_write($cache_name, $data);
        if($cat_id){
            return isset($data[$cat_id])?$data[$cat_id]:'';
        }
        return $data;
    }
    return '';
}

/**
 * 删除攻略缓存
 */
function del_strategy_category_cache(){
    global $_W;
    $cache_name = C('modulename').'_strategy_category_'.$_W['uniacid'];
    cache_delete($cache_name);
}




/**
 * 获取房屋面积配置
 */
function acreage_config(){
    $acreage_config =  config('acreage');
    if($acreage_config){
        return  explode(',',$acreage_config);
    }else{
        return  C('DEFAULT_ACREAGE');
    }
}



/**
 * 获取卧室配置
 */
function room_config(){
    $room_config =  config('room');
    if($room_config){
        return  explode(',',$room_config);
    }else{
        return  C('DEFAULT_ROOM');
    }
}


/**
 * 获取客厅配置
 */
function parlour_config(){
    $parlour_config =  config('parlour');
    if($parlour_config){
        return  explode(',',$parlour_config);
    }else{
        return  C('DEFAULT_PARLOUR');
    }
}


/**
 * 获取厨房配置
 */
function kitchen_config(){
    $kitchen_config =  config('kitchen');
    if($kitchen_config){
        return  explode(',',$kitchen_config);
    }else{
        return  C('DEFAULT_KITCHEN');
    }
}

/**
 * 获取卫生间配置
 */
function toilet_config(){
    $toilet_config =  config('toilet');
    if($toilet_config){
        return  explode(',',$toilet_config);
    }else{
        return  C('DEFAULT_TOILET');
    }
}

/**
 * 获取阳台配置
 */
function balcony_config(){
    $balcony_config =  config('balcony');
    if($balcony_config){
        return  explode(',',$balcony_config);
    }else{
        return  C('DEFAULT_BALCONY');
    }
}


/**
 * 获取预算配置
 */
function budget_config(){
    $budget_config =  config('budget');
    if($budget_config){
        return  explode(PHP_EOL,$budget_config);
    }else{
        return  C('DEFAULT_BUDGET');
    }
}



function acreage_fee_config(){
    $acreage_fee_config =  config('acreage_fee');
    if(floatval($acreage_fee_config)){
        return  $acreage_fee_config;
    }else{
        return  C('DEFAULT_ACREAGE_FEE');
    }
}


function room_fee_config(){
    $room_fee_config =  config('room_fee');
    if(floatval($room_fee_config)){
        return  $room_fee_config;
    }else{
        return  C('DEFAULT_ROOM_FEE');
    }
}


function parlour_fee_config(){
    $parlour_fee_config =  config('parlour_fee');
    if(floatval($parlour_fee_config)){
        return  $parlour_fee_config;
    }else{
        return  C('DEFAULT_PARLOUR_FEE');
    }
}


function kitchen_fee_config(){
    $kitchen_fee_config =  config('kitchen_fee');
    if(floatval($kitchen_fee_config)){
        return  $kitchen_fee_config;
    }else{
        return  C('DEFAULT_KITCHEN_FEE');
    }
}

function toilet_fee_config(){
    $toilet_fee_config =  config('toilet_fee');
    if(floatval($toilet_fee_config)){
        return  $toilet_fee_config;
    }else{
        return  C('DEFAULT_TOILET_FEE');
    }
}

function balcony_fee_config(){
    $balcony_fee_config =  config('balcony_fee');
    if(floatval($balcony_fee_config)){
        return  $balcony_fee_config;
    }else{
        return  C('DEFAULT_BALCONY_FEE');
    }
}


function exceed_config(){
    $exceed_config =  config('exceed');
    if($exceed_config){
        return  explode(PHP_EOL,$exceed_config);
    }else{
        return  C('DEFAULT_EXCEED');
    }
//    if(floatval($exceed_config)){
//        return  $exceed_config;
//    }else{
//        return  C('DEFAULT_EXCEED');
//    }
}











/**
 * 获取房型
 * @param $room     卧室
 * @param $parlour  客厅
 * @param $kitchen  厨房
 * @param $toilet   卫生间
 * @param $balcony  阳台
 * @return string
 */
function house_layout($room,$parlour,$kitchen,$toilet,$balcony){
      $layout = '';
      if($room>0){
          $layout.=$room.'室';
      }
    if($parlour>0){
        $layout.=$parlour.'厅';
    }
    if($kitchen>0){
        $layout.=$kitchen.'厨';
    }
    if($toilet>0){
        $layout.=$toilet.'卫';
    }
    if($balcony>0){
        $layout.=$balcony.'阳';
    }

    return $layout;


}


/**
 * 获取内容图片
 * @param string $content 内容
 * @param int $num N张图片
 * @return string 图片URL
 */
 function getImage($content, $num = 3)
{
    if(!$content) return array();
    $img = array();
    $content = htmlspecialchars_decode($content);
    //$output = preg_match_all('/<img.+src=[\'"]([^\'"]+)[\'"].*>/i', $content, $matches);
    $output = preg_match_all("/<img.*?src=\"(.+?)\"/", $content, $matches);

    if($matches[1]){
        for ($i=0;$i<3;$i++){
            $img[] = $matches[1][$i];
        }
    }

    return $img;
}


/**
 * 检查手机号码格式
 * @param $mobile 手机号码
 */
function check_mobile($mobile){
    if(preg_match('/1[34578]\d{9}$/',$mobile))
        return true;
    return false;
}


/**
 * 抽奖记录标识
 */
function create_raffle_sign($user_id,$activity_id,$time,$uniacid){
    $time = date('Ymd',$time);
    $sign = md5('user_id_'.$user_id.'_activity_id_'.$activity_id.'_time_'.$time.'_uniacid_'.$uniacid);
    return $sign;
}



/**
 * 概率计算函数
 * @param $proArr
 * @return int|string
 */
function get_rand($proArr) {
    $result = '';

    //概率数组的总概率精度
    $proSum = array_sum($proArr);

    //概率数组循环
    foreach ($proArr as $key => $proCur) {
        $randNum = mt_rand(1, $proSum);
        if ($randNum <= $proCur) {
            $result = $key;
            break;
        } else {
            $proSum -= $proCur;
        }
    }
    unset ($proArr);

    return $result;
}

/**
 * 过滤手机号码
 * @param $mobile
 * @return mixed
 */
function filter_mobile($mobile){
    return substr_replace($mobile, '****', 3, 4);
}



//本页面调用发送短信
 function SendSms($design_id=0,$smstype=0){
    global $_W, $_GPC;
    $bid = $design_id;
    $uniacid = $_W['uniacid'];
    $smstype = $smstype;//0预约短信
    $res=pdo_get('yzzx_sun_designer',array('uniacid'=>$uniacid,'design_id'=>$bid),array("mobile"));
    $phone = $res["mobile"]?$res["mobile"]:0;

    $sms=pdo_get('yzzx_sun_sms',array('uniacid'=>$uniacid));
    if($sms){
        if($sms["is_open"]==1){
            if($sms["smstype"]==1){//253
                $msg = $smstype==1?$sms["ytx_orderrefund"]:$sms["ytx_order"];
                if($msg!=''){

                   SendYtxSms($msg,$sms,$phone);
                }
            }elseif($sms["smstype"]==2){//聚合
                $sendid = $smstype==1?$sms["order_refund_tplid"]:$sms["order_tplid"];
                if($sendid<=0){
                    return "短信模板id为空，不发送";
                }else{
                   SendJuheSms($phone,$sendid,$sms);
                }
            }elseif($sms["smstype"]==3){//阿里大鱼
                include_once IA_ROOT . '/addons/mzhk_sun/api/aliyun-dysms/sendSms.php';
                set_time_limit(0);
                header('Content-Type: text/plain; charset=utf-8');
                $sendid = $smstype==1?$sms["aly_orderrefund"]:$sms["aly_order"];
                if($sendid!=""){
                    $return = sendSms($sms["aly_accesskeyid"], $sms["aly_accesskeysecret"],$phone, $sms["aly_sign"],$sendid);
                    return json_encode($return);
                }
            }
        }
    }else{
        return "短信发送没开";
    }
}

//253云通信-变量
 function SendYtxSmsbl($sendid='',$sms=array(),$params=''){
    global $_W, $_GPC;
    $postArr = array (
        'account'  => $sms["ytx_apiaccount"],
        'password' => $sms["ytx_apipass"],
        'msg' => $sendid,
        'params' => $params,
        'report' => 'true'
    );
    //echo json_encode($sms["ytx_apiurl"]);exit;
    $url = "http://smssh1.253.com/msg/variable/json";
    $result = curlPost($url, $postArr);
     return $result;
}

//253云通信
 function SendYtxSms($sendid='',$sms=array(),$mobile=''){
    global $_W, $_GPC;
    $postArr = array (
        'account'  => $sms["ytx_apiaccount"],
        'password' => $sms["ytx_apipass"],
        'msg' => $sendid,
        'phone' => $mobile,
        'report' => 'true'
    );
    //echo json_encode($sms["ytx_apiurl"]);exit;
    $url = "http://smssh1.253.com/msg/send/json";
    $result = curlPost($url, $postArr);
     return $result;
}

//聚合短信
 function SendJuheSms($phone=0,$sendid=0,$sms=array()){
    global $_W, $_GPC;
    header('content-type:text/html;charset=utf-8');
    $sendUrl = 'http://v.juhe.cn/sms/send'; //短信接口的URL
    $smsConf = array(
        'key'   => $sms["appkey"], //您申请的APPKEY
        'mobile'    => $phone, //接受短信的用户手机号码
        'tpl_id'    => $sendid, //您申请的短信模板ID，根据实际情况修改
        'tpl_value' =>'#code#=1234&#company#=聚合数据' //您设置的模板变量，根据实际情况修改
    );
    $content = juhecurl($sendUrl,$smsConf,1); //请求发送短信
    if($content){
        $result = json_decode($content,true);
        $error_code = $result['error_code'];
        if($error_code == 0){
            //状态为0，说明短信发送成功
            return "短信发送成功,短信ID：".$result['result']['sid'];
        }else{
            //状态非0，说明失败
            $msg = $result['reason'];
            return "短信发送失败(".$error_code.")：".$msg;
        }
    }else{
        //返回内容异常，以下可根据业务逻辑自行修改
        return "请求发送短信失败";
    }
}

/**
 * 请求接口返回内容
 * @param  string $url [请求的URL地址]
 * @param  string $params [请求的参数]
 * @param  int $ipost [是否采用POST形式]
 * @return  string
 */
function juhecurl($url,$params=false,$ispost=0){
    $httpInfo = array();
    $ch = curl_init();
    curl_setopt( $ch, CURLOPT_HTTP_VERSION , CURL_HTTP_VERSION_1_1 );
    curl_setopt( $ch, CURLOPT_USERAGENT , 'Mozilla/5.0 (Windows NT 5.1) AppleWebKit/537.22 (KHTML, like Gecko) Chrome/25.0.1364.172 Safari/537.22' );
    curl_setopt( $ch, CURLOPT_CONNECTTIMEOUT , 30 );
    curl_setopt( $ch, CURLOPT_TIMEOUT , 30);
    curl_setopt( $ch, CURLOPT_RETURNTRANSFER , true );
    if( $ispost ){
        curl_setopt( $ch , CURLOPT_POST , true );
        curl_setopt( $ch , CURLOPT_POSTFIELDS , $params );
        curl_setopt( $ch , CURLOPT_URL , $url );
    }
    else
    {
        if($params){
            curl_setopt( $ch , CURLOPT_URL , $url.'?'.$params );
        }else{
            curl_setopt( $ch , CURLOPT_URL , $url);
        }
    }
    $response = curl_exec( $ch );
    if ($response === FALSE) {
        //echo "cURL Error: " . curl_error($ch);
        return false;
    }
    $httpCode = curl_getinfo( $ch , CURLINFO_HTTP_CODE );
    $httpInfo = array_merge( $httpInfo , curl_getinfo( $ch ) );
    curl_close( $ch );
    return $response;
}

 function curlPost($url,$postFields){
    $postFields = json_encode($postFields);

    $ch = curl_init ();
    curl_setopt( $ch, CURLOPT_URL, $url );
    curl_setopt( $ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json; charset=utf-8'   //json版本需要填写  Content-Type: application/json;
        )
    );
    curl_setopt($ch, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4);
    curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1 );
    curl_setopt( $ch, CURLOPT_POST, 1 );
    curl_setopt( $ch, CURLOPT_POSTFIELDS, $postFields);
    curl_setopt( $ch, CURLOPT_TIMEOUT,60);
    curl_setopt( $ch, CURLOPT_SSL_VERIFYHOST, 0);
    curl_setopt( $ch, CURLOPT_SSL_VERIFYPEER, 0);
    $ret = curl_exec ( $ch );
    if (false == $ret) {
        $result = curl_error(  $ch);
    } else {
        $rsp = curl_getinfo( $ch, CURLINFO_HTTP_CODE);
        if (200 != $rsp) {
            $result = "请求状态 ". $rsp . " " . curl_error($ch);
        } else {
            $result = $ret;
        }
    }
    curl_close ( $ch );
    return $result;
}




