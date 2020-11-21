<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/12/1
 * Time: 16:57
 */

namespace app\extensions;


use app\models\Goods;
use app\models\MsGoods;
use app\models\MsOrder;
use app\models\MsSetting;
use app\models\Order;
use app\models\OrderDetail;
use app\models\Printer;
use app\models\PrinterSetting;
use app\models\PtGoods;
use app\models\PtOrder;
use app\models\PtOrderDetail;
use app\models\PtSetting;
use app\models\Store;
use app\models\YyGoods;
use app\models\YyOrder;

class PinterOrder
{
    public $store_id;
    public $store;
    public $order_id;
    public $setting; //打印设置
    public $printer; //打印机型号
    public $printer_setting;//打印机配置
    public $order_type;//订单类型 0--商城订单 1--秒杀订单 2--拼团订单 3--预约订单
    public $order;//订单详情
    public $goods_list;//订单商品详情
    public $print_type;//订单打印方式


    public function __construct($store_id, $order_id, $print_type, $order_type = 0)
    {
        $this->store_id = $store_id;
        $this->store = Store::findOne($store_id);
        $this->order_id = $order_id;
        $this->print_type = $print_type;
        $this->order_type = $order_type;
    }

    public function print_order()
    {
        $this->setting = PrinterSetting::findOne(['store_id' => $this->store_id]);//打印设置
        if (!$this->setting) {
            return false;
        }
        $type = json_decode($this->setting->type, true);
        if (!($type[$this->print_type] && $type[$this->print_type] == 1)) {
            return false;
        }
        $this->printer = Printer::findOne(['id' => $this->setting->printer_id]);
        if (!$this->printer) {//打印机参数
            return false;
        }
        $this->printer_setting = json_decode($this->printer->printer_setting, true);//打印机配置
        if ($this->order_type == 0) {//商城订单打印
            $this->order = Order::find()->where(['id' => $this->order_id, 'is_delete' => 0])->asArray()->one();
            $this->goods_list = $this->getOrderGoodsList($this->order['id']);
        } elseif ($this->order_type == 1) {//秒杀打印
            if (in_array($this->print_type, ['order', 'confirm'])) {
                $ms_setting = MsSetting::findOne(['store_id' => $this->store_id]);
                if (!$ms_setting || $ms_setting->is_print == 0) {
                    return false;
                }
            }
            $this->order = MsOrder::find()->where(['id' => $this->order_id, 'is_delete' => 0])->asArray()->one();
            $this->goods_list = $this->getMsOrderGoodsList();
        } elseif ($this->order_type == 2) {//拼团订单打印
            if (in_array($this->print_type, ['order', 'confirm'])) {
                $pt_setting = PtSetting::findOne(['store_id' => $this->store_id]);
                if (!$pt_setting || $pt_setting->is_print == 0) {
                    return false;
                }
            }
            $this->order = PtOrder::find()->where(['id' => $this->order_id, 'is_delete' => 0])->asArray()->one();
            $this->goods_list = $this->getPtOrderGoodsList();
        } elseif ($this->order_type == 3) {//预约订单打印
            return false;
            $this->order = YyOrder::find()->where(['id' => $this->order_id, 'is_delete' => 0])->one();
            $this->goods_list = $this->getYyOrderGoodsList();
        } else {
            return false;
        }
        try {
            if ($this->printer->printer_type == 'kdt2') {
                return $this->printer_1();
            }
            if ($this->printer->printer_type == 'yilianyun-k4') {
                return $this->printer_2();
            }
            if ($this->printer->printer_type == 'feie') {
                return $this->printer_3();
            }

        } catch (\Exception $e) {
            return false;
        }
    }

    /**
     * 365打印机
     */
    private function printer_1()
    {
        date_default_timezone_set("Asia/Shanghai");
//        $order = Order::findOne(['id' => $this->order_id, 'is_delete' => 0]);
        $order = $this->order;
        $addtime = date('Y-m-d H:i:s', $order['addtime']);
//        $goods_list = $this->getOrderGoodsList($order->id);
        $goods_list = $this->goods_list;
        header("Content-Type: text/html;charset=utf-8");
        $DEVICE_NO = $this->printer_setting['name'];
        $key = $this->printer_setting['key'];
        $time = $this->printer_setting['time'];//打印联数
        $content = "";
        $content .= "<CB>{$this->store->name}</CB><BR>";
        $content .= "订单号：{$order['order_no']}<BR>";
        $content .= "下单时间：{$addtime}<BR>";
        if ($this->setting->is_attr == 0) {
            $content .= "--------------------------------<BR>";
            $content .= "名称　　　　　 单价  数量   金额<BR>";
            $content .= "--------------------------------<BR>";
//        foreach ($goods_list as $k => $v) {
//            $price = round($v['total_price'] / $v['num'], 2);
//            $content .= $this->r_str_pad($v['name']) . " " . str_pad($price, 5) . " " . str_pad($v['num'], 4) . " " . round($v['total_price'], 2) . '<BR>';
//        }
            foreach ($goods_list as $k => $v) {
                $price = round($v['total_price'] / $v['num'], 2);
                $arr = $this->r_str_pad_1($v['name'], 7);
                foreach ($arr as $index => $value) {
                    if ($index == 0) {
                        $content .= $value . " " . str_pad($price, 5) . " " . str_pad($v['num'], 6) . " " . round($v['total_price'], 2) . '<BR>';
                    } else {
                        $content .= $value . '<BR>';
                    }
                }
            }

        } else {
            /**
             * $content .= "--------------------------------<BR>";
             * $content .= "名称　　 规格　  单价  数量 金额<BR>";
             * $content .= "--------------------------------<BR>";
             * foreach ($goods_list as $k => $v) {
             * $attr = json_decode($v['attr'], true);
             * $attr_arr = [];
             * foreach ($attr as $i => $j) {
             * $attr_arr[] = $j['attr_group_name'] . $j['attr_name'];
             * }
             * $attr_str = implode('，', $attr_arr);
             * $attr_arr_1 = $this->r_str_pad_1($attr_str, 4);
             * $price = round($v['total_price'] / $v['num'], 2);
             * $arr = $this->r_str_pad_1($v['name'], 4);
             * $a = count($attr_arr_1) >= count($arr) ? $attr_arr_1 : $arr;
             * foreach ($a as $index => $value) {
             * $string = "";
             * $string_1 = "";
             * if (isset($arr[$index])) {
             * $string = $arr[$index];
             * }
             * if (isset($attr_arr_1[$index])) {
             * if (!$string) {
             * $string = str_pad($string, 8);
             * }
             * $string_1 = $attr_arr_1[$index];
             * }
             * if ($index == 0) {
             * $content .= $string . " " . $string_1 . str_pad($price, 5) . " " . str_pad($v['num'], 3) . " " . round($v['total_price'], 2) . '<BR>';
             * } else {
             * $content .= $string . " " . $string_1 . '<BR>';
             * }
             * }
             * }
             * */
            $content .= "--------------------------------<BR>";
            $content .= "名称            数量    金额    <BR>";
            $content .= "--------------------------------<BR>";
            foreach ($goods_list as $k => $v) {
                $attr = json_decode($v['attr'], true);
                $attr_arr = [];
                foreach ($attr as $i => $j) {
                    $attr_arr[] = $j['attr_group_name'] . $j['attr_name'];
                }
                $attr_str = implode(',', $attr_arr);
                $name = $v['name'] . '（' . $attr_str . ')';
                $name_arr = $this->r_str_pad_1($name, 8);
                foreach ($name_arr as $index => $value) {
                    if ($index == count($name_arr) - 1) {
                        $content .= $name_arr[$index] . " " . str_pad('×' . $v['num'], 7) . " " . round($v['total_price'], 2) . "<BR>";
                    } else {
                        $content .= $name_arr[$index] . '<BR>';
                    }
                }

            }
        }
        if ($order['content']) {
            $content .= "备注：{$order['content']}<BR>";
        }
        $content .= "--------------------------------<BR>";
        if ($order['express_price']) {
            $content .= "运费：{$order['express_price']}元<BR>";
        }
        $content .= "总计：{$order['total_price']}元<BR>";
        if ($order['user_coupon_id']) {
            $content .= "优惠券优惠：{$order['coupon_sub_price']}元<BR>";
        }
        $integral = json_decode($order['integral'], true);
        if ($integral['forehead'] != 0) {
            $content .= "积分抵扣：{$integral['forehead']}元<BR>";
        }
        if ($order['discount'] < 10) {
            $content .= "会员折扣：{$order['discount']}折<BR>";
        }
        $content .= "实付：{$order['pay_price']}元<BR>";
        if ($this->order_type != 3) {
            if ($order['is_offline'] != 1) {
                $content .= "收货人：{$order['name']}<BR>";
                $content .= "收货地址：{$order['address']}<BR>";
                $content .= "收货人电话：{$order['mobile']}<BR>";
            } else {
                $content .= "收货人：{$order['name']}<BR>";
                $content .= "收货人电话：{$order['mobile']}<BR>";
            }
        }
//        $content .= "<QR>http://open.printcenter.cn</QR><BR>";
        $result = $this->sendSelfFormatOrderInfo($DEVICE_NO, $key, $time, $content);
        \Yii::warning('==>>' . $result);
        return $result;
    }

    /**
     * 365打印机
     */
    private function sendSelfFormatOrderInfo($device_no, $key, $times, $orderInfo)
    { // $times打印次数
        $selfMessage = array(
            'deviceNo' => $device_no,
            'printContent' => $orderInfo,
            'key' => $key,
            'times' => $times
        );
        $url = "http://open.printcenter.cn:8080/addOrder";
        $options = array(
            'http' => array(
                'header' => "Content-type: application/x-www-form-urlencoded ",
                'method' => 'POST',
                'content' => http_build_query($selfMessage),
            ),
        );
        $context = stream_context_create($options);
        $result = file_get_contents($url, false, $context);

        return $result;
    }

    /**
     * @param $order_id
     * @return mixed
     * 订单商品详情
     */
    public function getOrderGoodsList($order_id)
    {
        $order_detail_list = OrderDetail::find()->alias('od')
            ->leftJoin(['g' => Goods::tableName()], 'od.goods_id=g.id')
            ->where([
                'od.is_delete' => 0,
                'od.order_id' => $order_id,
            ])->select('od.*,g.name')->asArray()->all();
        return $order_detail_list;
    }

    /**
     * 补齐空格
     * 截取七个中文字符长度
     */
    private function r_str_pad($input, $n = 7)
    {
        $string = "";
        $count = 0;
        $c_count = 0;
        for ($i = 0; $i < mb_strlen($input, 'UTF-8'); $i++) {
            $char = mb_substr($input, $i, 1, 'UTF-8');
            $string .= $char;
            if (strlen($char) == 3) {
                $count += 2;
                $c_count++;
            } else {
                $count += 1;
            }
            if ($count >= $n * 2) {
                break;
            }
        }
        if ($count < $n * 2) {
            $string = str_pad($string, $n * 2 + $c_count);
        }
        return $string;
    }

    /**
     * 补齐空格
     * 每n个中文字符长度为一个数组元素
     */
    private function r_str_pad_1($input, $n = 7)
    {
        $string = "";
        $count = 0;
        $c_count = 0;
        $arr = array();
        for ($i = 0; $i < mb_strlen($input, 'UTF-8'); $i++) {
            $char = mb_substr($input, $i, 1, 'UTF-8');
            $string .= $char;
            if (strlen($char) == 3) {
                $count += 2;
                $c_count++;
            } else {
                $count += 1;
            }
            if ($count >= $n * 2) {
                $arr[] = $string;
                $string = '';
                $count = 0;
                $c_count = 0;
            }
        }
        if ($count < $n * 2) {
            $string = str_pad($string, $n * 2 + $c_count);
            $arr[] = $string;
        }
        return $arr;
    }

    /**
     * 易联云打印机-k4
     */
    private function printer_2()
    {
        date_default_timezone_set("Asia/Shanghai");
        $machine_code = $this->printer_setting['machine_code'];//终端编号
        $key = $this->printer_setting['key'];//终端密钥
        $client_id = $this->printer_setting['client_id'];//用户ID
        $client_key = $this->printer_setting['client_key'];//用户密钥
        $time = $this->printer_setting['time'];//打印联数

//        $order = Order::findOne(['id' => $this->order_id, 'is_delete' => 0]);
        $order = $this->order;
        $addtime = date('Y-m-d H:i:s', $order['addtime']);
//        $goods_list = $this->getOrderGoodsList($order->id);
        $goods_list = $this->goods_list;
        $print = new Yprint();
        $content = "<MN>{$time}</MN>";
        $content .= "<FB><center>{$this->store->name}</center></FB>\n";
        $content .= "订单号：{$order['order_no']}\n";
        $content .= "下单时间：{$addtime}\n";
        $content .= "--------------------------------\n";
        if ($this->setting->is_attr == 0) {
            $content .= "<table><tr><td>名称</td><td>数量</td><td>单价</td></tr>";
            foreach ($goods_list as $k => $v) {
                $price = round($v['total_price'] / $v['num'], 2);
                $v['name'] = str_replace('，', ',', $v['name']);
                $arr = $this->r_str_pad_1($v['name'], 8);
                foreach ($arr as $index => $value) {
                    if ($index == 0) {
                        $content .= "<tr><td>" . $value . "</td><td>" . $v['num'] . "</td><td>" . $price . "</td></tr>";
                    } else {
                        $content .= "<tr><td>" . $value . "</td></tr>";
                    }
                }
            }
            $content .= "</table>";

        } else {
            /**
             * $content .= "<table><tr><td>名称</td><td>规格</td><td>数量</td><td>单价</td></tr>";
             * foreach ($goods_list as $k => $v) {
             * $attr = json_decode($v['attr'], true);
             * $attr_arr = [];
             * foreach ($attr as $i => $j) {
             * $attr_arr[] = $j['attr_group_name'] . $j['attr_name'];
             * }
             * $attr_str = implode('，', $attr_arr);
             * $attr_arr_1 = $this->r_str_pad_1($attr_str, 4);
             * $price = round($v['total_price'] / $v['num'], 2);
             * $v['name'] = str_replace('，', ',', $v['name']);
             * $arr = $this->r_str_pad_1($v['name'], 4);
             * $a = count($attr_arr_1) >= count($arr) ? $attr_arr_1 : $arr;
             * foreach ($a as $index => $value) {
             * $string = "";
             * $string_1 = "";
             * if (isset($arr[$index])) {
             * $string = $arr[$index];
             * }
             * if (isset($attr_arr_1[$index])) {
             * if (!$string) {
             * $string = str_pad($string, 8);
             * }
             * $string_1 = $attr_arr_1[$index];
             * }
             * if ($index == 0) {
             * $content .= "<tr><td>" . $string . "</td><td>" . $string_1 . "</td><td>" . $v['num'] . "</td><td>" . $price . "</td></tr>";
             * } else {
             * $content .= "<tr><td>" . $string . "</td><td>" . $string_1 . "</td></tr>";
             * }
             * }
             * }
             * $content .= "</table>";
             * */
            $content .= "<table><tr><td>名称</td><td>数量</td><td>总价</td></tr>";
            foreach ($goods_list as $k => $v) {
                $attr = json_decode($v['attr'], true);
                $attr_arr = [];
                foreach ($attr as $i => $j) {
                    $attr_arr[] = $j['attr_group_name'] . $j['attr_name'];
                }
                $attr_str = implode(',', $attr_arr);
                $name = $v['name'] . '（' . $attr_str . ')';
                $name_arr = $this->r_str_pad_1($name, 6);
                foreach ($name_arr as $index => $value) {
                    if ($index == count($name_arr) - 1) {
                        $content .= "<tr><td>" . $name_arr[$index] . "</td><td>" . '×' . $v['num'] . "</td><td>" . round($v['total_price'], 2) . "</td></tr>";
                    } else {
                        $content .= "<tr><td>" . $name_arr[$index] . "</td><td></td><td></td></tr>";
                    }
                }

            }
            $content .= "</table>";
        }
        if ($order['content']) {
            $content .= "备注：{$order['content']}\n";
        }
        $content .= "--------------------------------\n";
        if ($order['express_price']) {
            $content .= "运费：{$order['express_price']}元\n";
        }
        $content .= "总计：{$order['total_price']}元\n";
        if ($order['user_coupon_id']) {
            $content .= "优惠券优惠：{$order['coupon_sub_price']}元\n";
        }
        $integral = json_decode($order['integral'], true);
        if ($integral['forehead'] != 0) {
            $content .= "积分抵扣：{$integral['forehead']}元\n";
        }
        if ($order['discount'] < 10) {
            $content .= "会员折扣：{$order['discount']}折\n";
        }
        $content .= "实付：{$order['pay_price']}元\n";
        if ($this->order_type != 3) {
            if ($order['is_offline'] != 1) {
                $content .= "收货人：{$order['name']}\n";
                $content .= "收货地址：{$order['address']}\n";
                $content .= "收货人电话：{$order['mobile']}\n";
            } else {
                $content .= "收货人：{$order['name']}\n";
                $content .= "收货人电话：{$order['mobile']}\n";
            }

        }


        return $print->action_print($client_id, $machine_code, $content, $client_key, $key);
    }

    /**
     * 补齐空格
     * 截取$n个中文字符长度
     */
    private function r_mb_str($input, $n)
    {
        $string = "";
        $count = 0;
        $c_count = 0;
        for ($i = 0; $i < mb_strlen($input, 'UTF-8'); $i++) {
            $char = mb_substr($input, $i, 1, 'UTF-8');
            $string .= $char;
            if (strlen($char) == 3) {
                $count += 2;
                $c_count++;
            } else {
                $count += 1;
            }
            if ($count >= 2 * $n) {
                break;
            }
        }
        if ($count < 2 * $n) {
            $string = str_pad($string, 2 * $n + $c_count);
        }
        return $string;
    }

    //飞鹅打印机
    public function printer_3()
    {
        date_default_timezone_set("Asia/Shanghai");
//        $order = Order::findOne(['id' => $this->order_id, 'is_delete' => 0]);
        $order = $this->order;
        $addtime = date('Y-m-d H:i:s', $order['addtime']);
//        $goods_list = $this->getOrderGoodsList($order->id);
        $goods_list = $this->goods_list;
        $time = $this->printer_setting['time'];//打印联数
        $content = "";
        $content .= "<CB>{$this->store->name}</CB><BR>";
        $content .= "订单号：{$order['order_no']}<BR>";
        $content .= "下单时间：{$addtime}<BR>";
        if ($this->setting->is_attr == 0) {
            $content .= "--------------------------------<BR>";
            $content .= "名称　　　　　 单价  数量   金额<BR>";
            $content .= "--------------------------------<BR>";
//            foreach ($goods_list as $k => $v) {
//                $price = round($v['total_price'] / $v['num'], 2);
//                $content .= $this->r_str_pad($v['name']) . " " . str_pad($price, 5) . " " . str_pad($v['num'], 4) . " " . round($v['total_price'], 2) . '<BR>';
//            }
            foreach ($goods_list as $k => $v) {
                $price = round($v['total_price'] / $v['num'], 2);
                $arr = $this->r_str_pad_1($v['name'], 7);
                foreach ($arr as $index => $value) {
                    if ($index == 0) {
                        $content .= $value . " " . str_pad($price, 5) . " " . str_pad($v['num'], 6) . " " . round($v['total_price'], 2) . '<BR>';
                    } else {
                        $content .= $value . '<BR>';
                    }
                }
            }

        } else {
            /**
             * $content .= "--------------------------------<BR>";
             * $content .= "名称　　 规格　  单价  数量 金额<BR>";
             * $content .= "--------------------------------<BR>";
             * foreach ($goods_list as $k => $v) {
             * $attr = json_decode($v['attr'], true);
             * $attr_arr = [];
             * foreach ($attr as $i => $j) {
             * $attr_arr[] = $j['attr_group_name'] . $j['attr_name'];
             * }
             * $attr_str = implode('，', $attr_arr);
             * $attr_arr_1 = $this->r_str_pad_1($attr_str, 4);
             * $price = round($v['total_price'] / $v['num'], 2);
             * $arr = $this->r_str_pad_1($v['name'], 4);
             * $a = count($attr_arr_1) >= count($arr) ? $attr_arr_1 : $arr;
             * foreach ($a as $index => $value) {
             * $string = "";
             * $string_1 = "";
             * if (isset($arr[$index])) {
             * $string = $arr[$index];
             * }
             * if (isset($attr_arr_1[$index])) {
             * if (!$string) {
             * $string = str_pad($string, 8);
             * }
             * $string_1 = $attr_arr_1[$index];
             * }
             * if ($index == 0) {
             * $content .= $string . " " . $string_1 . str_pad($price, 5) . " " . str_pad($v['num'], 3) . " " . round($v['total_price'], 2) . '<BR>';
             * } else {
             * $content .= $string . " " . $string_1 . '<BR>';
             * }
             * }
             * }
             * */
            $content .= "--------------------------------<BR>";
            $content .= "名称            数量    金额    <BR>";
            $content .= "--------------------------------<BR>";
            foreach ($goods_list as $k => $v) {
                $attr = json_decode($v['attr'], true);
                $attr_arr = [];
                foreach ($attr as $i => $j) {
                    $attr_arr[] = $j['attr_group_name'] . $j['attr_name'];
                }
                $attr_str = implode(',', $attr_arr);
                $name = $v['name'] . '（' . $attr_str . ')';
                $name_arr = $this->r_str_pad_1($name, 8);
                foreach ($name_arr as $index => $value) {
                    if ($index == count($name_arr) - 1) {
                        $content .= $name_arr[$index] . " " . str_pad('×' . $v['num'], 7) . " " . round($v['total_price'], 2) . "<BR>";
                    } else {
                        $content .= $name_arr[$index] . '<BR>';
                    }
                }

            }
        }
        if ($order['content']) {
            $content .= "备注：{$order['content']}<BR>";
        }
        $content .= "--------------------------------<BR>";
        if ($order['express_price']) {
            $content .= "运费：{$order['express_price']}元<BR>";
        }
        $content .= "总计：{$order['total_price']}元<BR>";
        if ($order['user_coupon_id']) {
            $content .= "优惠券优惠：{$order['coupon_sub_price']}元<BR>";
        }
        $integral = json_decode($order['integral'], true);
        if ($integral['forehead'] != 0) {
            $content .= "积分抵扣：{$integral['forehead']}元<BR>";
        }
        if ($order['discount'] < 10) {
            $content .= "会员折扣：{$order['discount']}折<BR>";
        }
        $content .= "实付：{$order['pay_price']}元<BR>";
        if ($this->order_type != 3) {
            if ($order['is_offline'] != 1) {
                $content .= "收货人：{$order['name']}<BR>";
                $content .= "收货地址：{$order['address']}<BR>";
                $content .= "收货人电话：{$order['mobile']}<BR>";
            } else {
                $content .= "收货人：{$order['name']}<BR>";
                $content .= "收货人电话：{$order['mobile']}<BR>";
            }
        }\Yii::warning('飞鹅打印');
        return $this->wp_print($this->printer_setting['sn'], $content, $time);
    }/*
 *  方法1
	拼凑订单内容时可参考如下格式
	根据打印纸张的宽度，自行调整内容的格式，可参考下面的样例格式
*/
    private function wp_print($printer_sn, $orderInfo, $times)
    {
        $user = $this->printer_setting['user'];
        $ukey = $this->printer_setting['ukey'];
        $time = time();
        $ip = 'api.feieyun.cn';
        $path = '/Api/Open/';
        $content = array(
            'user' => $user,
            'stime' => $time,
            'sig' => sha1($user . $ukey . $time),
            'apiname' => 'Open_printMsg',

            'sn' => $printer_sn,
            'content' => $orderInfo,
            'times' => $times//打印次数
        );

        $client = new FeieYun($ip, 80);
        if (!$client->post($path, $content)) {
            return 'error';
        } else {
            //服务器返回的JSON字符串，建议要当做日志记录起来
            return $client->getContent();
        }

    }

    //秒杀商品详情
    public function getMsOrderGoodsList()
    {
        $ms_goods = MsGoods::findOne(['id' => $this->order['goods_id']]);
        $list['name'] = $ms_goods->name;
        $list['total_price'] = $this->order['pay_price'];
        $list['num'] = $this->order['num'];
        $list['attr'] = $this->order['attr'];
        $new_list = [];
        array_push($new_list, $list);
        return $new_list;
    }

    //拼团商品详情
    public function getPtOrderGoodsList()
    {
        $order_detail_list = PtOrderDetail::find()->alias('od')
            ->leftJoin(['g' => PtGoods::tableName()], 'od.goods_id=g.id')
            ->where(['od.is_delete' => 0, 'od.order_id' => $this->order['id']])
            ->select(['od.*', 'g.name'])->asArray()->all();
        return $order_detail_list;
    }

    //预约商品详情
    public function getYyOrderGoodsList()
    {
        $order_detail_list = YyOrder::find()->alias('od')
            ->leftJoin(['g' => YyGoods::tableName()], 'od.goods_id = g.id')
            ->where(['od.is_delete' => 0, 'od.order_id' => $this->order['id']])
            ->select(['od.*', 'g.name'])->asArray()->one();
        $order_detail_list['num'] = 1;
        return [$order_detail_list];
    }
}