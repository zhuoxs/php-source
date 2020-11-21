<?php
defined('IN_IA') or exit ('Access Denied');

//error_reporting(0);
class Printer{
    public $order;
    public $ordertype=1;//1普通，2砍价，3拼团，4抢购，5预约

    public function __construct(){
        
    }

    public function wp_print($printer_user, $printer_ukey, $printer_sn, $orderInfo){
        $ip = "api.feieyun.cn";
        $port = 80;
        $stime = time();
        $sig = sha1($printer_user . $printer_ukey . $stime);
        $orderInfo = $this->getPrinterOrderInfo($orderInfo);
        $content = array(
            'user' => $printer_user,
            'stime' => $stime,
            'sig' => $sig,
            'apiname' => 'Open_printMsg',
            'sn' => $printer_sn,
            'content' => $orderInfo,
            'times' => 1//打印次数
        );

        $client = new \HttpClient($ip, $port);
        if (!$client->post("/Api/Open/", $content)) {
            return false;
        } else {
            //服务器返回的JSON字符串，建议要当做日志记录起来
            return true;
        }

    }

    public function strlen($string){
        return (strlen($string) + mb_strlen($string, 'UTF8')) / 2;
    }

    public function str_pad($input, $pad_length, $pad_string = " ", $pad_type = STR_PAD_RIGHT){
        $strlen = $this->strlen($input);
        if ($strlen < $pad_length) {
            $difference = $pad_length - $strlen;
            switch ($pad_type) {
                case STR_PAD_RIGHT:
                    return $input . str_repeat($pad_string, $difference);
                    break;
                case STR_PAD_LEFT:
                    return str_repeat($pad_string, $difference) . $input;
                    break;
                default:
                    $left = $difference / 2;
                    $right = $difference - $left;
                    return str_repeat($pad_string, $left) . $input . str_repeat($pad_string, $right);
                    break;
            }
        } else {
            return $input;
        }
    }

    private function getPrinterOrderInfo($order){

        $orderInfo = '<CB>'.$order['build_name'].'</CB><BR>';
        $orderInfo .= '服务名称:'.$order['pname'].'<BR>';
        $orderInfo .= '服务人员:'.$order['hair_name'].'<BR>';
        $orderInfo .= '预约时间:'.$order['appiontime'].'<BR>';
        $orderInfo .= '下单时间:'.$order['addtime'].'<BR>';
        $orderInfo .= '预约金额:'.$order['money'].'<BR>';
        $orderInfo .= '联系号码:'.$order['tel'].'<BR>';
        $orderInfo .= '联系人:'.$order['user_name'].'<BR>';
        $orderInfo .= '备注：'.$order['remark'].'<BR>';
        $orderInfo .= '--------------------------<BR>';
        $orderInfo .= '订单编号：'.$order['order_num'].'<BR>';

//        $orderInfo = '<CB>订单信息</CB><BR>';
//        $orderInfo .= '序号　  单价      数量   金额<BR>';
//        $orderInfo .= '--------------------------------<BR>';
//        $all_goods_price = $order["money"]-$order["deliveryfee"];
//        $info = sprintf("%s%s%s%s<BR>",
//                $this->str_pad(1, 8),
//                $this->str_pad(round(($all_goods_price/$order["num"]), 2), 10),
//                $this->str_pad($order["num"], 7),
//                round($all_goods_price, 2));
//        $orderInfo .= $info;
//        $orderInfo .= $order["gname"]."<BR>";
//
//        $orderInfo .= '<BR>';
//        if ($order["deliveryfee"] > 0) {
//            $orderInfo .= '运费：' . $order["deliveryfee"] . '元<BR>';
//        }
//        $orderInfo .= '备注：' . $order['uremark'] . '<BR>';
//        $orderInfo .= '--------------------------------<BR>';
//        $orderInfo .= '合计：' . $order['money'] . '元<BR>';
//        $orderInfo .= $order['sincetype'].'<BR>';
//        $address = $order["provinceName"] . $order["cityName"] . $order["countyName"] . $order["detailInfo"];
//        if(!empty($address)){
//            $orderInfo .= '送货地址：' . $address . '<BR>';
//			$orderInfo .= '收货人：' . $order['name'] . '<BR>';
//        }
//        $orderInfo .= '联系电话：' . $order['telNumber'] . '<BR>';
//        $orderInfo .= '下单时间：' . date("Y-m-d H:i:s",$order['addtime']) . '<BR>';
        // debug($orderInfo);
        return $orderInfo;

    }


}