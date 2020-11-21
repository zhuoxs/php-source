<?php
defined('IN_IA') or exit ('Access Denied');

//error_reporting(0);
class Printer{
    public $order;
    public $ordertype=1;//1普通，2砍价，3拼团，4抢购，5预约

    public function __construct(){
        
    }

    public function wp_print($printer_user, $printer_ukey, $printer_sn,$orderInfo,$type=0){
        $ip = "api.feieyun.cn";
        $port = 80;
        $stime = time();
        $sig = sha1($printer_user . $printer_ukey . $stime);
        // load()->func('logging');
                //记录文本日志
            // logging_run($orderInfo, 'trace','test23' );
            // logging_run($type, 'trace','test23' );
        $orderInfo = $this->getPrinterOrderInfo($orderInfo,$type);
        $content = array(
            'user' => $printer_user,
            'stime' => $stime,
            'sig' => $sig,
            'apiname' => 'Open_printMsg',
            'sn' => $printer_sn,
            'content' => $orderInfo,
            'times' => 1//打印次数
        );
        // logging_run($orderInfo, 'trace','test23' );

        $client = new \HttpClient($ip, $port);
        // logging_run($client, 'trace','test23' );
        // logging_run(!$client->post("/Api/Open/", $content), 'trace','test23' );
        
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

    private function getPrinterOrderInfo($order,$type){

        $orderInfo = '<CB>订单信息</CB><BR>';
        $orderInfo .= '序号　  单价      数量   金额<BR>';
        $orderInfo .= '--------------------------------<BR>';
        $all_goods_price = $order["money"]-$order["deliveryfee"];
        // 载入日志函数
            // load()->func('logging');
                //记录文本日志
            // logging_run($type, 'trace','test23' );
            // logging_run($order['orderNum'], 'trace','test23' );
            // exit;

        if($type==14){
            // logging_run('2222222', 'trace','test23' );


            $goodsInfo = pdo_getall('mzhk_sun_deliveryorderdetail',array('uniacid'=>$order['uniacid'],'orderNum'=>$order['orderNum']));
            // logging_run($order['orderNum'], 'trace','test23' );
            // logging_run($goodsInfo, 'trace','test23' );

            foreach ($goodsInfo as $key => $value) {
                $money = $value['vipprice']==0?$value['price']:$value['vipprice'];
                $info = sprintf("%s%s%s%s<BR>",
                        $this->str_pad(1, 8),
                        $this->str_pad(round(($money), 2), 10),
                        $this->str_pad($value["num"], 7),
                round($all_goods_price, 2));
                $orderInfo .= $info;

                $orderInfo .= $value["gname"]."<BR>";
            }
        }else{
            $info = sprintf("%s%s%s%s<BR>",
                    $this->str_pad(1, 8),
                    $this->str_pad(round(($all_goods_price/$order["num"]), 2), 10),
                    $this->str_pad($order["num"], 7),
                    round($all_goods_price, 2));
            $orderInfo .= $info;

            $orderInfo .= $order["gname"]."<BR>";
        }
        

        $orderInfo .= '<BR>';
        if ($order["deliveryfee"] > 0) {
            $orderInfo .= '运费：' . $order["deliveryfee"] . '元<BR>';
        }
        $orderInfo .= '备注：' . $order['uremark'] . '<BR>';
        $orderInfo .= '--------------------------------<BR>';
        $orderInfo .= '合计：' . $order['money'] . '元<BR>';
        $orderInfo .= $order['sincetype'].'<BR>';
        if($order["detailInfo"]!=undefined){
            $detailInfo=$order["detailInfo"];
        }else{
            $detailInfo='';
        }
		if($order['bname']){
			$orderInfo .= '商家名称：' . $order['bname'] . '<BR>';
		}
        $address = $order["provinceName"] . $order["cityName"] . $order["countyName"] . $detailInfo;
        if(!empty($address)){
            $orderInfo .= '送货地址：' . $address . '<BR>';
			$orderInfo .= '收货人：' . $order['name'] . '<BR>';
        }
        $orderInfo .= '联系电话：' . $order['telNumber'] . '<BR>';
        $orderInfo .= '下单时间：' . date("Y-m-d H:i:s",$order['addtime']) . '<BR>';
        // debug($orderInfo);
        return $orderInfo;

    }


}