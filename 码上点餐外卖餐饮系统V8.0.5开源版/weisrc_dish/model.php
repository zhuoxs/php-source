<?php
defined('IN_IA') or exit('Access Denied');
function set_code($url = '' , $type = '')
{
    global $_W, $_GPC, $code;
    load()->func('communication');
    $domain = get_domain();
    $ip = gethostbyname($domain);
    $result = ihttp_post($url, array('type' => $type, 'ip' => $ip, 'code' => $code, 'domain' => $domain));
    echo $result['content'];
}

function getServerIP(){
    return gethostbyname($_SERVER["SERVER_NAME"]);
}

function wlog($name ,$result) {
    file_put_contents(IA_ROOT . "/addons/weisrc_dish/".$name.".log", var_export($result, true) . PHP_EOL,
        FILE_APPEND);
}

function get_domain()
{
    $host = $_SERVER['HTTP_HOST'];
    $host = strtolower($host);
    if (strpos($host, '/') !== false) {
        $parse = @parse_url($host);
        $host = $parse['host'];
    }
    $topleveldomaindb = array('com', 'edu', 'gov', 'int', 'mil', 'net', 'org', 'biz', 'info', 'pro', 'name', 'museum', 'coop', 'aero', 'xxx', 'idv', 'mobi', 'cc', 'me');
    $str = '';
    foreach ($topleveldomaindb as $v) {
        $str .= ($str ? '|' : '') . $v;
    }
    $matchstr = "[^\.]+\.(?:(" . $str . ")|\w{2}|((" . $str . ")\.\w{2}))$";
    if (preg_match("/" . $matchstr . "/ies", $host, $matchs)) {
        $domain = $matchs['0'];
    } else {
        $domain = $host;
    }
    return $domain;
}

function authorization()
{
    $host = get_domain();
    return base64_encode($host);
}

function code_compare($a, $b)
{
    if ($a != $b) {
        message(base64_decode("57O757uf5q2j5Zyo57u05oqk77yM6K+35oKo56iN5ZCO5YaN6K+V77yM5pyJ55aR6Zeu6K
        +36IGU57O757O757uf566h55CG5ZGYIQ=="));
    }
}

function findNum($str=''){
    $str=trim($str);
    if(empty($str)){return '';}
    $reg='/(\d{3}(\.\d+)?)/is';//匹配数字的正则表达式
    preg_match_all($reg,$str,$result); if(is_array($result)&&!empty($result)&&!empty($result[1])&&!empty($result[1][0])){
        return $result[1][0];
    }
    return '';
}


//GCJ-02(火星，高德) 坐标转换成 BD-09(百度) 坐标
//@param gg_lon 经度
//@param gg_lat 纬度
function bd_encrypt($gg_lon,$gg_lat) {
    $x_pi = 3.14159265358979324 * 3000.0 / 180.0;
    $x = $gg_lon;
    $y = $gg_lat;
    $z = sqrt($x * $x + $y * $y) - 0.00002 * sin($y * $x_pi);
    $theta = atan2($y, $x) - 0.000003 * cos($x * $x_pi);
    $data['bd_lon'] = $z * cos($theta) + 0.0065;
    $data['bd_lat'] = $z * sin($theta) + 0.006;
    return $data;
}

//BD-09(百度) 坐标转换成  GCJ-02(火星，高德) 坐标
//@param bd_lon 百度经度
//@param bd_lat 百度纬度
function bd_decrypt($bd_lon,$bd_lat) {
    $x_pi = 3.14159265358979324 * 3000.0 / 180.0;
    $x = $bd_lon - 0.0065;
    $y = $bd_lat - 0.006;
    $z = sqrt($x * $x + $y * $y) - 0.00002 * sin($y * $x_pi);
    $theta = atan2($y, $x) - 0.000003 * cos($x * $x_pi);
    $data['gg_lon'] = $z * cos($theta);
    $data['gg_lat'] = $z * sin($theta);
    return $data;
}

function getStr($param)
{
    $str = '';
    foreach ($param as $key => $value) {
        $str=$str.$key.'='.$value.'&';
    }
    $str = rtrim($str,'&');
    return $str;
}
