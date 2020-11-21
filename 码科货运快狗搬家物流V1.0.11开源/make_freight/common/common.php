<?php
function msg($code = 0, $msg = '', $data = '')
{
    $code = intval($code);
    $json = json_encode(["code" => $code, "msg" => $msg, "data" => $data]);
    return $json;
}
function upload_image($file)
{
    load()->func("file");
    $image = $file;
    if (empty($image)) {
		return msg(400, "请选择图片");
	}
    $ect = "jpg";
    $arr = explode(".", $file["name"]);
    empty($arr) || ($ect = end($arr));
    $file_name = "../addons/make_freight/core/public/uploads/" . date("Ymd") . "/" . md5(microtime(true)) . "." . $ect;
    $dir = dirname($file_name);
    if (!is_dir($dir)) {
		mkdir($dir, 0755, true);
	}
    if (is_file($file_name)) {
        return msg(400, "请重新上传");
    }
	$path = file_upload($image, "image", $file_name);
    if (!array_key_exists("path", $path)) {
        return msg(400, $path["message"]);
    }
    $newFile = stristr($file_name, "/uploads/");
    return msg(200, "上传成功", $newFile);
}
if (!function_exists("makeOrderNo")) {
    function makeOrderNo()
    {
        $yCode = array("A", "B", "C", "D", "E", "F", "G", "H", "I", "J", "K", "L", "M", "N", "O", "P", "Q", "R", "S", "T", "U", "V", "W", "X", "Y", "Z");
        $orderSn = $yCode[mt_rand(0, 25)] . date("Y") . strtoupper(dechex(date("m"))) . date("d") . substr(time(), -5) . substr(microtime(), 2, 5) . sprintf("%02d", rand(0, 99));
        return $orderSn;
    }
}
function intPrice($price)
{
    $int_price = substr($price, -2);
    if ($int_price == "00") {
        return intval($price);
    }
    return $price;
}
if (!function_exists("timediff")) {
    function timediff($begin_time, $end_time)
    {
        if ($begin_time < $end_time) {
            $starttime = $begin_time;
            $endtime = $end_time;
        }else{
        $starttime = $end_time;
        $endtime = $begin_time;
		}
        $timediff = $endtime - $starttime;
        $days = intval($timediff / 86400);
        $remain = $timediff % 86400;
        $hours = intval($remain / 3600);
        $remain = $remain % 3600;
        $mins = intval($remain / 60);
        $secs = $remain % 60;
        $res = array("day" => $days, "hour" => $hours, "min" => $mins, "sec" => $secs);
        return $res;
    }
}
if (!function_exists("GetRange")) {
    function GetRange($lat, $lon, $raidus)
    {
        $degree = 24901 * 1609 / 360.0;
        $dpmLat = 1 / $degree;
        $radiusLat = $dpmLat * $raidus;
        $minLat = $lat - $radiusLat;
        $maxLat = $lat + $radiusLat;
        $mpdLng = $degree * cos($lat * (PI / 180));
        $dpmLng = 1 / $mpdLng;
        $radiusLng = $dpmLng * $raidus;
        $minLng = $lon - $radiusLng;
        $maxLng = $lon + $radiusLng;
        $range = array("minLat" => $minLat, "maxLat" => $maxLat, "minLon" => $minLng, "maxLon" => $maxLng);
        return $range;
    }
}
if (!function_exists("SquarePoint")) {
    function SquarePoint($lng, $lat, $distance = 10)
    {
        define(EARTH_RADIUS, 6371);
        $dlng = 2 * asin(sin($distance / (2 * EARTH_RADIUS)) / cos(deg2rad($lat)));
        $dlng = rad2deg($dlng);
        $dlat = $distance / EARTH_RADIUS;
        $dlat = rad2deg($dlat);
        return array("minlat" => $lat - $dlat, "maxlat" => $lat + $dlat, "minlng" => $lng - $dlng, "maxlng" => $lng + $dlng);
    }
}
if (!function_exists("getDriverId")) {
    function getDriverId($order)
    {
        global $_W;
        if (empty($order)) {
			return '';
		}
        $config = pdo_get("freight_config", ["name" => "scope", "uniacid" => $_W["uniacid"]], ["value"]);
        $distance = !empty($config["value"]) ? intval($config["value"]) : 10;
        $scope = SquarePoint($order["start_lot"], $order["start_lat"], $distance);
        $where = array("i.latitude >=" => $scope["minlat"], "i.latitude <=" => $scope["maxlat"], "i.longitude >=" => $scope["minlng"], "i.longitude <=" => $scope["maxlng"]);
        $where["i.statef"] = 1;
        $where["i.uniacid"] = $_W["uniacid"];
        $where["d.car_id"] = $order["car_id"];
        $field = ["d.user_id"];
        $query = load()->object("query");
        $driver = $query->from("freight_driver", "d")->select($field)->leftjoin("freight_driver_info", "i")->on(["d.id" => "i.driver_id"])->where($where)->getall();
        if (!empty($driver)) {
            $ids = array_column($driver, "user_id");
            return $ids;
        }
        return '';
    }
}
function workermanLog($data)
{
    if (!is_string($data)) {
        return false;
    }
    $file = MODULE_ROOT . "/workman/stdout.log";
    if (!$data || !is_file($file)) {
        return false;
    }
    file_put_contents($file, date("Y-m-d H:i:s") . "{$data}\r\n", FILE_APPEND);
}
function is_hanzi($str)
{
    if (is_scalar($str)) {
        return preg_match("/^[\\x{4e00}-\\x{9fa5}]+\$/u", $str) ? true : false;
    } else {
        return false;
    }
}
function is_mobile($str)
{
    if (is_scalar($str)) {
        return preg_match('' . "/^(" . "((13([0-9]{1})|14([579])|15([012356789])|16([6])|17([0135678])|18([0-9]{1})|19([189]))" . "([0-9]{8}))|((170([059]))([0-9]{7}))" . ")\$/", $str) ? true : false;
    } else {
        return false;
    }
}
function getDistance($lat1, $lng1, $lat2, $lng2)
{
    $radLat1 = deg2rad($lat1);
    $radLat2 = deg2rad($lat2);
    $radLng1 = deg2rad($lng1);
    $radLng2 = deg2rad($lng2);
    $lat = $radLat1 - $radLat2;
    $lnt = $radLng1 - $radLng2;
    $distance = 2 * asin(sqrt(pow(sin($lat / 2), 2) + cos($radLat1) * cos($radLat2) * pow(sin($lnt / 2), 2))) * 6378.137;
    return $distance;
}
function sendOrderTpl($order, $user)
{
    global $_W;
    $formid = pdo_get("freight_user_formid", ["uniacid" => $_W["uniacid"], "user_id" => $user], ["id", "open_id", "form_id", "expire_time"]);
    $config = pdo_get("freight_config", ["name" => "driver_msg_tpl"], ["value"]);
    if (empty($formid)) {
        return false;
    }
    $token = get_access_token();
    $url = "https://api.weixin.qq.com/cgi-bin/message/wxopen/template/send?access_token=" . $token;
    $data = array("touser" => $formid["open_id"], "template_id" => $config["value"], "form_id" => $formid["form_id"], "page" => "make_freight/driver/home/home", "data" => array("keyword1" => array("value" => $order["order_number"]), "keyword2" => array("value" => $order["real_price"]), "keyword3" => array("value" => $order["shipper_name"]), "keyword4" => array("value" => empty($order["remark"]) ? "无" : $order["remark"]), "keyword5" => array("value" => $order["place_dispatch"] . $order["place_dispatch"])), "emphasis_keyword" => '');
    $data = json_encode($data);
    $list = ihttp_post($url, $data);
    if (empty($list)) {
        return false;
    }
    $list = @json_decode($list["content"], true);
    pdo_delete("freight_user_formid", array("id" => $formid["id"]));
    if ($list["errcode"] === 0) {
        return true;
    }
    sendOrderTpl($order, $user);
}
function send_aliyun_sms($mobile = '', $codeParam = array(), $config = array())
{
    if (empty($mobile)) {
        return false;
    }
    $params = array();
    $keyId = $config["ali_access"];
    $keySecret = $config["ali_secret"];
    $params["SignName"] = $config["sign_name"];
    $params["TemplateCode"] = $config["code_sms"];
    $params["PhoneNumbers"] = $mobile;
    $params["TemplateParam"] = $codeParam;
    if (!empty($params["TemplateParam"]) && is_array($params["TemplateParam"])) {
        $params["TemplateParam"] = json_encode($params["TemplateParam"], JSON_UNESCAPED_UNICODE);
    }
    require_once "lib/aliyun/SignatureHelper.php";
    $helper = new SignatureHelper();
    $result = $helper->request($keyId, $keySecret, $params);
    return !empty($result) ? json_decode($result, true) : array();
}
function weixinRefund($order_code, $amount)
{
    if (empty($order_code)) {
		return error(1, "订单号错误！请稍后重试");
	}
    if (empty($amount)) {
		return error(1, "请选择输入退款金额后重试！");
	}
    load()->model("refund");
    $refund_id = refund_create_order($order_code, "make_freight", sprintf("%.2f", $amount), "取消订单");
    if (is_error($refund_id)) {
        return $refund_id;
    }
	$data = reufnd_wechat_build($refund_id);
    $certPath = ATTACHMENT_ROOT . $GLOBALS["USER_ID"] . "_euermi4lbzd3qsm1mzhy.pem";
    $keyPath = ATTACHMENT_ROOT . $GLOBALS["USER_ID"] . "_bomvnjzyzdmzbthd.pem";
    $data["sign"] = generateDataSign($data, "md5", $certPath, $keyPath);
    if (is_error($data["sign"])) {
		return $data["sign"];
	}
    if (empty($data["sign"])) {
		return error(1, "数字签名生成失败！");
	}
    $data = setXMLData($data);
    $url = "https://api.mch.weixin.qq.com/secapi/pay/refund";
    $result = setRequest($url, $data, true, $certPath, $keyPath);
    is_file($certPath) && unlink($certPath);
    is_file($keyPath) && unlink($keyPath);
    $result = getXMLData($result);
    if (empty($result) || strtolower($result["return_code"]) !== "success") {
		return array(1, !empty($result["return_msg"]) ? $result["return_msg"] : '');
	}
    if (empty($result) || strtolower($result["result_code"]) !== "success") {
		is_array($result) && ($results = json_encode($result));
        load()->func("logging");
        logging_run(date("Y-m-d H:i") . "[Reufnd] Error: " . (string) $results, "trace", "make_freight");
        return error(1, !empty($result["err_code_des"]) ? $result["err_code_des"] : "退款失败！请联系管理员");
	}
    return true;
}
function generateDataSign($data, $type = "md5", $certPath = '', $keyPath = '')
{
    global $_W;
    $res = pdo_get("uni_settings", array("uniacid" => $_W["uniacid"]), array("payment"));
    $mcd = array();
    !empty($res) && !empty($res["payment"]) && ($mcd = unserialize($res["payment"]));
    if (empty($mcd) || empty($mcd["wechat"]["signkey"])) {
		return error(1, "未配置微信支付！");
	}
    if (empty($mcd["wechat_refund"]["cert"]) || empty($mcd["wechat_refund"]["key"])) {
		return error(1, "请开启微信退款,并配置上传证书！");
	}
    if (!empty($certPath) && !empty($keyPath)) {
		file_put_contents($certPath, authcode($mcd["wechat_refund"]["cert"], "DECODE"));
        file_put_contents($keyPath, authcode($mcd["wechat_refund"]["key"], "DECODE"));
	}
    $sign = array();
    $type = strtoupper($type);
    ksort($data);
    foreach ($data as $k => $v) {
        if (!($v === '' || $v === false || $v === null)) {
            $sign[] = $k . "=" . $v;
        }
    }
    $sign[] = "key=" . $mcd["wechat"]["signkey"];
    $sign = implode("&", $sign);
    $sign = $type == "MD5" ? md5($sign) : hash_hmac("sha256", $sign, $mcd["wechat"]["signkey"]);
    $sign = strtoupper($sign);
    return $sign;
}
function setXMLData($data)
{
    if (!is_array($data)) {
		return '';
	}
    $result = "<xml>";
    foreach ($data as $k => $v) {
        $result .= "<" . $k . "><![CDATA[" . $v . "]]></" . $k . ">";
    }
    $result .= "</xml>";
    return $result;
}
function getXMLData($xml)
{
    if (!function_exists("simplexml_load_string")) {
        return array();
    }
    $data = simplexml_load_string($xml);
    if ($data === false) {
		return array();
	}
    $results = array();
    foreach ($data as $k => $v) {
        $results[$k] = (string) $v;
    }
    return $results;
}
function setRequest($url, $post = false, $ssl = true, $certPath = '', $keyPath = '')
{
    $result = '';
    if (!function_exists("curl_init")) {
        return '';
    }
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_HEADER, false);
    curl_setopt($ch, CURLOPT_TIMEOUT, 30);
    curl_setopt($ch, CURLOPT_MAXREDIRS, 5);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
    if ($post) {
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
    }
    if ($ssl) {
        if (is_file($certPath)) {
            curl_setopt($ch, CURLOPT_SSLCERT, $certPath);
        }
        if (is_file($keyPath)) {
            curl_setopt($ch, CURLOPT_SSLKEY, $keyPath);
        }
    }
    $result = curl_exec($ch);
    curl_close($ch);
    return $result;
}
function get_access_token()
{
    global $_W;
    $config = pdo_getall("freight_config", ["name" => ["appid", "appsecret"]], ["name", "value"]);
    $config = array_column($config, "value", "name");
    $tokenUrl = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=" . $config["appid"] . "&secret=" . $config["appsecret"];
    $html = file_get_contents($tokenUrl);
    $arr = json_decode($html, true);
    return $arr["access_token"];
}