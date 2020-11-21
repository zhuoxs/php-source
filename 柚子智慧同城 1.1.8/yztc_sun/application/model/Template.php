<?php

namespace app\model;


class Template extends Base
{
    static public function get_curr(){
        global $_W;
        $uniacid = $_W['uniacid'];
        $info = self::get(['uniacid'=>$uniacid]);
        return $info;
    }
    //TODO::支付成功通知
    public function tid1($orderinfo,$page){
        $template_id=Template::get(['uniacid'=>$orderinfo['uniacid']])['tid1'];
        $openid=User::get($orderinfo['user_id'])['openid'];
        $form_id=$orderinfo['prepay_id'];
        //订单号,物品名称,物品数量,支付金额,支付时间
        $datas['keyword1']['value']=$orderinfo['order_no'];
        $datas['keyword2']['value']=$orderinfo['name'];
        $datas['keyword3']['value']=$orderinfo['num'];
        $datas['keyword4']['value']=$orderinfo['order_amount'];
        $datas['keyword5']['value']=date('Y年m月d日 H:i',$orderinfo['pay_time']);
        sendTemplate($openid,$template_id,$page,$form_id,$datas);
    }
    /**发送模板消息
     * @param $type  1下单通知
     * @param $order  订单信息
     */
    public  function setTemplateContent($type,$order){
        if($type==1){
            $goods=Goods::get($order['gid']);
            if($order['order_lid']==1){
                $page="base/goodsorderinfo/goodsorderinfo?id={$order['id']}";
            }
            $data=array(
                'keyword1'=>array('value'=>$order['order_no'],'color'=>'173177'),
                'keyword2'=>array('value'=>$goods['name'],'color'=>'173177'),
                'keyword3'=>array('value'=>$order['num'],'color'=>'173177'),
                'keyword4'=>array('value'=>$order['order_amount'],'color'=>'173177'),
                'keyword5'=>array('value'=>date('Y-m-d H:i'),'color'=>'173177'),
            );
            sendTemplate($order['openid'],self::get_curr()['tid1'],$page,$order['prepay_id'],$data);
        }
    }

}
