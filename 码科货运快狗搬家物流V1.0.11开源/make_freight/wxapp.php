<?php

defined("IN_IA") or exit("Access Denied");
require "workman/vendor/autoload.php";
require_once "common/common.php";
use GatewayWorker\Lib\Gateway;
class Make_freightModuleWxapp extends WeModuleWxapp
{
    public $GPC = null;
    public $uniacid = null;
    public $W = null;
    public $freightToken = "d5EcXsE742GQOvR7275r7ZFosTXsDOdd";
    public function __construct()
    {
        global $_W, $_GPC;
        $this->uniacid = $_W["uniacid"];
        $this->GPC = $_GPC;
        $this->W = $_W;
        if (!empty($_W["openid"]) && empty($GLOBALS["USER_ID"])) {
            $user = pdo_get("freight_users", ["open_id" => $_W["openid"], "uniacid" => $this->uniacid], ["id"]);
            if (!empty($user["id"])) {
                $GLOBALS["USER_ID"] = $user["id"];
            }
        }
    }
    public function doPagePay_order()
    {
        $orderNumber = $this->GPC["order_number"];
        $orderId = $this->GPC["id"];
        if (empty($orderNumber) || empty($orderId)) {
            return $this->result(0, "请求参数错误");
        }
        $order = $this->getOrder($orderNumber, $orderId);
        if (false == $order) {
            return $this->result(0, "未查询到该订单信息");
        }
        if (intval($order["status"]) !== 7) {
            return $this->result(0, "该订单不是待付款状态!");
        }
        $orderData = array("tid" => $order["order_number"], "user" => $this->W["openid"], "fee" => floatval($order["real_price"]), "title" => "同城货运订单");
        $pay_params = $this->pay($orderData);
        if (is_error($pay_params)) {
            return $this->result(1, $pay_params["message"]);
        }
        return $this->result(0, '', $pay_params);
    }
    public function getOrder($orderNumber = '', $orderId = '')
    {
        $order = pdo_get("freight_order", ["order_number" => $orderNumber, "uid" => $GLOBALS["USER_ID"], "id" => $orderId], ["id", "order_number", "real_price", "status"]);
        if (empty($order)) {
            return false;
        }
        return $order;
    }
    public function payResult($log)
    {
        $order = pdo_get("freight_order", ["order_number" => $log["tid"]], ["id", "real_price", "uid"]);
        if ($log["result"] == "success" && floatval($log["fee"]) == floatval($order["real_price"])) {
            pdo_update("freight_order", ["status" => 1], ["id" => $order["id"]]);
            pdo_update("freight_users", ["amount +=" => $order["real_price"]], ["id" => $order["uid"]]);
            $this->sendOrder($order);
        }
    }
    public function sendOrder($order)
    {
        $field = ["id", "real_price", "uid", "order_number", "car_id", "start_lot", "start_lat", "shipper_name", "remark", "place_dispatch", "place_dispatch_detail", "appointment_time", "place_receipt", "place_receipt_detail", "create_time", "price", "end_lat", "end_lot", "status", "distance", "car_name"];
        $order = pdo_get("freight_order", ["id" => $order["id"]], $field);
        $order["order_id"] = $order["id"];
        $driverIds = getDriverId($order);
        try {
            Gateway::$registerAddress = "127.0.0.1:1234";
            $data = ["data" => $order, "msg" => "推送订单", "type" => "sendOrder"];
            $data = json_encode($data);
            Gateway::sendToUid($driverIds, $data);
            if ($driverIds) {
                foreach ($driverIds as $k => $v) {
                    sendOrderTpl($order, $v);
                }
            }
            workermanLog($data);
        } catch (Exception $e) {
            return $this->result(1, $e->getMessage());
        }
    }
    public function doPageTest()
    {
        Gateway::$registerAddress = "127.0.0.1:1234";
        $list = Gateway::getAllUidList();
        var_dump($list);
        die;
        $order = pdo_get("freight_order", ["id" => 365]);
        $driverIds = getDriverId($order);
        try {
            Gateway::$registerAddress = "127.0.0.1:1234";
            $data = ["data" => $order, "msg" => "推送订单", "type" => "sendOrder"];
            $data = json_encode($data);
            Gateway::sendToUid($driverIds, $data);
        } catch (Exception $e) {
            return $this->result(1, $e->getMessage());
        }
    }
    public function sendOrderUser($order)
    {
        Gateway::$registerAddress = "127.0.0.1:1234";
        $data = ["data" => $order, "msg" => "司机已接单", "type" => "orderChange"];
        $data = json_encode($data);
        Gateway::sendToUid($order["uid"], $data);
        workermanLog($data);
    }
    public function doPageBindUid()
    {
        $uid = $GLOBALS["USER_ID"];
        $client = $this->GPC["client"];
        load()->func("logging");
        logging_run("用户ID" . $uid . "--------" . $client, '', "make_freight");
        if (!$uid || !$client) {
            return false;
        }
        Gateway::bindUid($client, $uid);
    }
    public function doPageGetUserId()
    {
        $userId = $GLOBALS["USER_ID"];
        if (!$userId) {
            return $this->result(0, '');
        }
        return $this->result(0, "ok", ["user_id" => $userId]);
    }
    public function sendCancelMsg($order)
    {
        $driverIds = getDriverId($order);
        Gateway::$registerAddress = "127.0.0.1:1234";
        $data = ["data" => $order, "msg" => "推送订单", "type" => "sendOrder"];
        $data = json_encode($data);
        Gateway::sendToUid($driverIds, $data);
        workermanLog($data);
    }
    public function checkSignn()
    {
        if (!empty($_GET) && !empty($this->GPC["sign"])) {
            foreach ($_GET as $key => $get_value) {
                if ($key != "sign") {
                    $sign_list[$key] = $get_value;
                }
            }
            ksort($sign_list);
            $sign = http_build_query($sign_list) . "&" . $this->freightToken;
            return md5($sign) == $this->GPC["sign"];
        } else {
            return false;
        }
    }
    public function doPageUploadImage()
    {
        $re = upload_image($_FILES["image"]);
        echo $re;
        die;
    }
    public function replaceUrl(&$array)
    {
        $array = str_replace("/uploads", MODULE_URL . "core/public/uploads", $array);
        if (is_array($array)) {
            foreach ($array as $key => $val) {
                if (is_array($val)) {
                    $this->replaceUrl($array[$key]);
                }
            }
        }
        return $array;
    }
    public function checkIDcard($IDcard)
    {
        require_once "IDValidator/IDValidator.php";
        $validator = IDValidator::getInstance();
        return $validator->isValid($IDcard);
    }
    public function checkParams($field)
    {
        if (!is_array($field)) {
            return false;
        }
        $data = $this->GPC;
        $params = array_intersect_key($data, array_flip($field));
        if (!$params) {
            return false;
        }
        $is_have = array_diff_key(array_flip($field), $params);
        if ($is_have) {
            return false;
        }
        foreach ($params as $k => &$v) {
            $v = preg_replace("# #", '', $v);
            if (empty($v)) {
                return false;
            }
        }
        return $params;
    }
    public function doPageGetTime()
    {
        $errno = 0;
        $message = "返回消息";
        $day = 7;
        $days = array();
        $i = 0;
        while ($i < $day) {
            if ($i === 0) {
                $days[] = "今天";
            } else {
                $days[] = date("m月d日", strtotime("+" . $i . " day"));
            }
            $i++;
        }
        $data = array("days" => $days, "hours" => date("H"), "minutes" => date("i"));
        return $this->result($errno, $message, $data);
    }
}