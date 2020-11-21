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
use app\api\model\Category;
use app\api\model\Product;
use app\api\model\AttrValue;
use app\boguan\model\Content;
use app\api\service\Express as ExpressService;
use app\api\model\UserShareMoney;
// 应用公共文件

function getUserShareMoney($userId,$uniacid,$orderId){
    $share= UserShareMoney::with('user')->with('parent')->where(['uniacid'=> $uniacid,'user_id'=> $userId,'order_id'=> $orderId])->select();

    return $share;
}

//合并一维数组元素,返回下标0开始，没有重复和空的值
function MergeArrayElements($data){
    if (!is_array($data)){
        $data= explode(',',$data);
    }
    return array_values(array_unique(array_filter($data)));
}
//
function ImageAddHttps($data){
    if (strpos($data,'//',0) == 0){
        $data= str_replace('//','https://',$data);
    }

    return $data;
}

function checkData($data,$type= ''){
    if ($data != '' || !empty($data)){
        if ($type == 'time'){
            $data= date('Y-m-d H:i:s',$data);
        }elseif ($type == 'image'){
            $data= str_replace(WE7_PATH,'',$data);
            if (file_exists($data)){
                return true;
            }else{return false;}
        }
        return $data;
    }else{
        return '-';
    }
}

/**
 * 权限检测
 * @param $rule
 */
function authCheck($rule)
{
    $control = explode('/', $rule)['0'];
    if(in_array($control, ['login', 'Platform.index','index'])){
        return true;
    }

    if(in_array($rule, session('action')) || in_array($rule,['Platform.setting/edit','Base/cache']) || session('action') == 'super'){
        return true;
    }

    return false;
}

/**
 * 整理菜单住方法
 * @param $param
 * @return array
 */
function prepareMenu($param)
{
    $param = objToArray($param);
    $parent = []; //父类
    $child = [];  //子类

    foreach($param as $key=>$vo) {
        $vo['url'] = url($vo['control_name'] . '/' . $vo['action_name']); //跳转地址
        if (0 == $vo['parent_id']) {
            /*$vo['href'] = '#';

        }else{*/

            $parent[] = $vo;

        } else {
            $child[] = $vo;

        }
    }

    foreach($parent as $key=>$vo){
        foreach($child as $k=>$v){

            if($v['parent_id'] == $vo['id']){
                $parent[$key]['child'][] = $v;
            }
        }
    }
    unset($child);

    return $parent;
}
/**
 * 对象转换成数组
 * @param $obj
 */
function objToArray($obj)
{
    return json_decode(json_encode($obj), true);
}


function checkImage($data){
    if ($data != ''){
        $data= str_replace(WE7_PATH,'',$data);
        $data= str_replace('http:','',$data);
        $data= str_replace('https:','',$data);

        if (file_exists($data)){

            return true;
        }

    }
    return false;
}

/** * 获取某月所有时间 *
 * @param string $time 某天时间戳 *
 * @param string $format 转换的时间格式
 * @return array
 */
function getMonth($time = '', $format='Y-m-d'){
    $time = $time != '' ? $time : time();
    //获取当前周几
    $week = date('d', $time);
    $date = [];
    for ($i=1; $i<= date('t', $time); $i++){

       $date[$i-1] = date($format ,strtotime( '+' . $i-$week .' days', $time));
    }

    return $date;
}


/** * 获取指定时间戳起的多少天内的所有时间 *
 * @param string $time 某天时间戳 *
 * @param int $day 周期（多少天内） *
 * @param string $format 转换的时间格式
 * @return array
 */
function getDay($time = '', $day= 7,$format='Y-m-d'){
    $time = $time != '' ? $time : time();

    $date = [];
    for ($i=0; $i<= $day - 1; $i++){

        $date[] = date($format ,strtotime( '+' . $i .' days', $time));

    }

    return $date;
}

/**
 * 判断是周几
*/
function whichWeek($time= ''){
    $time = $time != '' ? $time : time();
    $week = date("w",$time);
    if($week == '1'){
        return "周一";
    }elseif($week == '2'){
        return '周二';
    }elseif($week == '3'){
        return '周三';
    }elseif($week == '4'){
        return '周四';
    }elseif($week == '5'){
        return '周五';
    }elseif($week == '6'){
        return '周六';
    }elseif($week == '0'){
        return '周日';
    }else{
        return '错误';
    }
}

//获取物流信息
function getExpress($express,$express_no){
    $data['expressName']= $express;
    $data['expressNumber']= $express_no;

    $expressService= new ExpressService();

    $express= $expressService->kdniao($data);

    return $express;
}


//获取指定id的商品的库存
function getProductStock($productId){
    $product= Product::get($productId);
    if ($product['is_attr'] == 1){
        $stock= AttrValue::where('product_id','=',$productId)->sum('stock');
    }else{
        $stock= $product['stock'];
    }
    return $stock;
}


//获取指定id下的所有子id
function getChildCate($id){
    $child = Category::where('parent_id =' . $id)->select();

    $nid= [];
    foreach ($child as $key=> $value) {

        $nid[] = $value['id'];
        array_push($nid,$id);
        $childs = Category::where('parent_id =' . $value['id'])->select();

        if ($childs){
            foreach ($childs as $k => $v) {
                array_push($nid,$v['id']);
            }
        }
    }
    if (!empty($nid)){
        $nid= array_unique($nid);
        //把数组用,拼接成string
        $nid = implode(',', $nid);
    }else{
        $nid= $id;
    }

    return $nid;
}

//密码加密
function password($data){
    $password=md5(md5('boguan+').md5($data));
    return $password;
}

function arrayToUrlParam($array, $url_encode = true)
{
    $url_param = "";
    foreach ($array as $key => $value) {
        if (is_array($value)) {
            $list_url_param = "";
            foreach ($value as $list_key => $list_value) {
                if (!is_array($list_value))
                    $url_param .= $key . "[" . $list_key . "]=" . ($url_encode ? urlencode($list_value) : $list_value) . "&";
            }
            $url_param .= trim($list_url_param, "&") . "&";
        } else {
            $url_param .= $key . "=" . ($url_encode ? urlencode($value) : $value) . "&";
        }
    }
    return trim($url_param, "&");
}


/**
 * 数组分页函数  核心函数  array_slice
 * 用此函数之前要先将数据库里面的所有数据按一定的顺序查询出来存入数组中
 * @param $array 查询出来的所有数组
 * @param $size 每页多少条数据
 * @param $page 当前第几页
 * @param $order 0 - 不变     1- 反序
 * @return array
 */

function array_page($array,$size,$page,$order){
    //global $countpage; #定全局变量
    $page=(empty($page))?'1':$page; #判断当前页面是否为空 如果为空就表示为第一页面
    $start=($page-1) * $size; #计算每次分页的开始位置
    if($order==1){
        $array=array_reverse($array);  #函数返回翻转顺序的数组
    }
    //$totals=count($array);
    //$countpage=ceil($totals/$count); #计算总页面数

    $pageData=array_slice($array,$start,$size);
    return $pageData;  #返回查询数据
}

/**
 * 数组转xml
 * @param $array
 * @return null|string
 */
function arrayToXml($array)
{
    if (!is_array($array) || count($array) <= 0)
        return null;
    $xml = "<xml>\r\n";
    $xml .= arrayToXmlSub($array);
    $xml .= "</xml>";
    return $xml;
}

/**
 * @param $array
 * @return null|string
 */
function arrayToXmlSub($array)
{
    if (!is_array($array) || count($array) <= 0)
        return null;
    $xml = "";
    foreach ($array as $key => $val) {
        if (is_array($val)) {
            if (is_numeric($key))
                $xml .= arrayToXmlSub($val);
            else
                $xml .= "<" . $key . ">" . arrayToXmlSub($val) . "</" . $key . ">\r\n";
        } elseif (is_numeric($val)) {
            $xml .= "<" . $key . ">" . $val . "</" . $key . ">\r\n";
        } else {
            $xml .= "<" . $key . "><![CDATA[" . $val . "]]></" . $key . ">\r\n";
        }
    }
    return $xml;
}


/**
 * xml转数组
 * @param $xml
 * @return bool|mixed|null
 */
function xmlToArray($xml)
{
    try {
        if (!$xml) {
            return null;
        }
        //将XML转为array
        //禁止引用外部xml实体
        libxml_disable_entity_loader(true);
        @ $res = json_decode(json_encode(simplexml_load_string($xml, 'SimpleXMLElement', LIBXML_NOCDATA)), true);
        return $res;
    } catch (\Exception $e) {
        return false;
    }
}

/**
 * 计算两点地理坐标之间的距离
 * @param  float Decimal $longitude1 起点经度
 * @param  float Decimal $latitude1  起点纬度
 * @param  float Decimal $longitude2 终点经度
 * @param  float Decimal $latitude2  终点纬度
 * @param  Int     $unit       单位 1:米 2:公里
 * @param  Int     $decimal    精度 保留小数位数
 * @return float Decimal
 */
function getDistance($longitude1, $latitude1, $longitude2, $latitude2, $unit=2, $decimal=2){

    $EARTH_RADIUS = 6370.996; // 地球半径系数
    $PI = 3.1415926; //圆周率

    $radLat1 = $latitude1 * $PI / 180.0;
    $radLat2 = $latitude2 * $PI / 180.0;

    $radLng1 = $longitude1 * $PI / 180.0;
    $radLng2 = $longitude2 * $PI /180.0;

    $a = $radLat1 - $radLat2;
    $b = $radLng1 - $radLng2;

    $distance = 2 * asin(sqrt(pow(sin($a/2),2) + cos($radLat1) * cos($radLat2) * pow(sin($b/2),2)));
    $distance = $distance * $EARTH_RADIUS * 1000;

    if($unit==2){
        $distance = $distance / 1000;
    }

    return round($distance, $decimal);

}

/**
 *content: 根据数组某个字段进行排序
 * @param $arr array 需要排序的数组
 * @param $field string 数组里的某个字段
 * @param $sort 1为正序排序  2为倒序排序
 * @return mixed
 */
function array_sort($arr,$field,$sort){
    $order = array();
    foreach($arr as $kay => $value){
        $order[] = $value[$field];
    }
    if($sort == 1){
        array_multisort($order,SORT_ASC,$arr);
    }else{
        array_multisort($order,SORT_DESC,$arr);
    }
    return $arr;
}

/*
 * @param string $url get请求地址
 * @param int $httpCode 返回状态码
 * @return mixed
 * */
function curl_get($url, &$httpCode = 0){
    $ch= curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);

    //不做证书校验，部署在linux环境下请改为true
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER,false);
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
    $file_contents= curl_exec($ch);
    $httpCode= curl_getinfo($ch,CURLINFO_HTTP_CODE);
    curl_close($ch);
    return $file_contents;
}
/**
 * @param string $url post请求地址
 * @param array $params
 * @return mixed
 */
function curl_post($url, array $params = array())
{
    $data_string = json_encode($params);

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
    curl_setopt(
        $ch, CURLOPT_HTTPHEADER,
        array(
            'Content-Type: application/json;'
        )
    );
    $data = curl_exec($ch);
    curl_close($ch);
    return ($data);
}


function http_post($url, array $data_string = array())
{
    if (is_array($data_string) || is_object($data_string)) {
        $data_string = http_build_query($data_string);
    }
    //var_dump($data_string);die;
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
    curl_setopt(
        $ch, CURLOPT_HTTPHEADER,
        array(
            "Content-Type:application/x-www-form-urlencoded"
        )
    );
    $data = curl_exec($ch);
    curl_close($ch);
    return ($data);
}

function wx_curl_post($url, array $params = array())
{

    $data_string = json_encode($params,JSON_UNESCAPED_UNICODE);
    //$data_string = $params;
    //\think\Log::record($data_string);
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
    curl_setopt(
        $ch, CURLOPT_HTTPHEADER,
        array(
            'content-type: text'
        )
    );
    $data = curl_exec($ch);
    curl_close($ch);
    return ($data);
}

function getRandChar($length){
    $str= null;
    $strPol= "ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789abcdefghijklmnopqrstuvwxyz";
    $max= strlen($strPol - 1);

    for ($i=0;$i<$length;$i++){
        $str.=$strPol[rand(0, $max)];
    }

    return $str;
}

function curl_post_raw($url, $rawData, $type= '')
{
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $rawData);
    //请求携带证书
    if ($type == 'PEM'){
        $uniacid= session('uniacid');
        curl_setopt($ch, CURLOPT_SSLCERTTYPE, 'PEM');
        curl_setopt($ch, CURLOPT_SSLCERT, APP_PATH."/extra/weixinpem/apiclient_cert_{$uniacid}.pem");

        curl_setopt($ch, CURLOPT_SSLKEY, APP_PATH."/extra/weixinpem/apiclient_key_{$uniacid}.pem");

    }
    curl_setopt(
        $ch, CURLOPT_HTTPHEADER,
        array(
            'Content-Type : text',
        )
    );
    $data= curl_exec($ch);
    curl_close($ch);
    return $data;
}
//根据栏目统计内容总数
function countContent($cateId){

    if ($cateId){
        $count= Content::where([
            'uniacid'=> session('uniacid'),
            'cate_id'=> $cateId
        ])->count();
    }else{
        $count= 0;
    }

    return $count;
}

function diffTwoDays($second1,$second2){
    if ($second1 < $second2) {
        $tmp = $second2;
        $second2 = $second1;
        $second1 = $tmp;
    }

    return ($second1 - $second2) / 86400;

}

