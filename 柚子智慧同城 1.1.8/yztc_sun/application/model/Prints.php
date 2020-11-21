<?php

namespace app\model;
use think\Loader;

class Prints extends Base
{
    //打印
    /**
     * @param $store_id
     * @param $print_type  1下单打印 2付款打印 3确认收货打印
     * @param $order_id    订单id
     * @param int $type  1普通订单 2抢购 3拼团 4会员卡
     * @return bool|string
     */
    public function prints($store_id,$print_type,$order_id,$type=1){
        global $_W;
        if($type==1){
            $content=$this->getOrderPrintContent($order_id);
        }else if($type==2){

        }
        $printsetModel=new Printset();
        $printsModel=new Prints();
        $printset=$printsetModel->where(array('store_id'=>0))->find();
        if($store_id==0){
            if(!$printset['prints_id']){
                return false;
            }
            $prints=$printsModel->find($printset['prints_id']);
            $type=$printset['print_type'];
        }else if($store_id>0){
            if($printset['print_merch']==0){
                return false;
            }
            $printset_mer=$printsetModel->where(array('store_id'=>$store_id))->find();
            if(!$printset_mer){
                return false;
            }
            if($printset_mer['print_merch']==0){
                return false;
            }
            $prints=$printsModel->find($printset_mer['prints_id']);
            $type=$printset_mer['print_type'];
        }
        if(strpos($type,strval($print_type))!==false){
            $param=array(
                'user'=>$prints['user'],
                'key'=>$prints['ukey'],
                'sn'=>$prints['sn'],
                'content'=>$content,
                'times'=>1,
            );
            $result=$this->setPrint($param);
            return $result;
        }else{
            return false;
        }
    }
    //获取订单打印内容
    public function getOrderPrintContent($order_id)
    {
        global $_W;
        $system = System::get_curr();
        $orderinfo = '<CB>' . $system['pt_name'] . '</CB><BR>';
        $orderinfo .= '序号    单价    数量    金额<BR>';
        $order = Order::get($order_id);
        $order_detail = (new Orderdetail())->where(array('order_id'=>$order_id))->select();
        $order_detail=objecttoarray($order_detail);
        foreach ($order_detail as $key => $val) {
            $orderinfo .= strval($key + 1) . "      " . $val['unit_price'] . "      " . $val['num'] . "      " . $val['total_price'] . '<BR>';
            $orderinfo .= $val['gname'] . " " . $val['attr_list'] . '<BR>';
        }
        $orderinfo .= '----------------------------------------------------------------<BR>';
        $orderinfo .= '商品总金额:' . "￥" . $order['goods_amount'] . '<BR>';
        if ($order['delivery_type'] == 2) {
            $orderinfo .= '自提手机号:' . "" . $order['phone'] . '<BR>';
        }
        $orderinfo.='备注:'."".$order['remark'].'<BR>';
        $orderinfo.= '----------------------------------------------------------------<BR>';
        $orderinfo.= '<C><L><BOLD>'.'合计:'."".$order['order_amount'].'</BOLD></L></C><BR>';
        $orderinfo.= '订单编号:'.$order['order_no'].'<BR>';
        $orderinfo.= '下单时间:'.$order['create_time'].'<BR>';
        if($order['pay_status']==1) {
            $orderinfo .= '付款时间:' . "" . date('Y-m-d H:i',$order['pay_time']) . '<BR>';
        }
        return $orderinfo;
    }

    //打印
    public function setPrint($param){
        Loader::import('httpclient.HttpClient');
        define('USER', $param['user']);	//*必填*：飞鹅云后台注册账号
        define('UKEY', $param['key']);	//*必填*: 飞鹅云注册账号后生成的UKEY
        define('SN', $param['sn']);	    //*必填*：打印机编号，必须要在管理后台里添加打印机或调用API接口添加之后，才能调用API
        //以下参数不需要修改
        define('IP','api.feieyun.cn');		//接口IP或域名
        define('PORT',80);					//接口IP端口
        define('PATH','/Api/Open/');		//接口路径
        define('STIME', time());			    //公共参数，请求时间
        define('SIG', sha1(USER.UKEY.STIME));   //公共参数，请求公钥
        $content = array(
            'user'=>USER,
            'stime'=>STIME,
            'sig'=>SIG,
            'apiname'=>'Open_printMsg',
            'sn'=>SN,
            'content'=>$param['content'],
            'times'=>$param['times']//打印次数
        );
        $client = new \HttpClient(IP,PORT);
        if(!$client->post(PATH,$content)){
            return 'error';
        }
        else{
            //服务器返回的JSON字符串，建议要当做日志记录起来
            return $client->getContent();
        }
    }

}
