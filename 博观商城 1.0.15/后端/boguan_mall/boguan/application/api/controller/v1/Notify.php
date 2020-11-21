<?php
/**
 * Created by Boguan.
 * User: leo
 * WebSite: http://www.boguanweb.com
 * Date: 2018-11-27
 * Time: 15:51
 */

namespace app\api\controller\v1;


use think\Controller;
use think\Log;
use app\api\model\Order as OrderModel;
use think\Db;
use think\Exception;
use app\boguan\service\SmsMessage;
use app\boguan\model\SmsSet;
use app\boguan\service\EmailMessage;
use app\api\model\Message;
use app\api\model\Printer as PrinterModel;
use app\boguan\service\Official as OfficialService;
use app\api\service\Printer as PrinterService;

class Notify extends Controller
{
    //接收微信返回的结果
    public function receiveNotify(){
        //微信访问服务端通知频率15/15/30/180/1800/1800/1800/1800/3600,单位 秒
        //1,检查库存量，
        //2，更新这个订单的status状态
        //3，减库存
        //如果成功处理，返回微信成功处理的信息，否则，需要返回失败的信息
        //特点，post, xml格式, 不会携带参数
        //Log::record('执行回调');
        $xmlData= file_get_contents('php://input');
        $data= xmlToArray($xmlData);

        if ($data['result_code'] == 'SUCCESS'){
            $orderNo= $data['out_trade_no'];
            Db::startTrans();
            try{
                $order= OrderModel::where('order_no', '=', $orderNo)->find();
                if ($order && $order->status == 0){

                    $this->updateOrderStatus($order->id,1);

                    //短信
                    $this->sendSmsMessage($order->uniacid,$orderNo);
                    //邮箱通知
                    $sendEmailMessage= new EmailMessage();
                    $sendEmailMessage->sendEmail(['uniacid'=> $order->uniacid,'title'=> '用户下单提醒','content'=> '您有一条新订单，订单号：'.$order->old_order_no.'，请登录商城后台（'.SITE_URL.'）查看。']);

                    //message
                    $message= new Message();
                    $messageData= [
                        'uniacid'=> $order->uniacid,
                        'user_id'=> $order->user_id,
                        'order_id'=> $order->id,
                        'type'=> 1,
                    ];
                    $message->saveMessage($messageData);

                    //小票打印
                    $printer= new PrinterService($order['uniacid']);
                    $printer->printReceiptAtPaid($order['id'],'paid');

                    //公众号模板消息
                    $tplData= [
                        'uniacid'=> $order['uniacid'],
                        'type'=> 'paid',
                        'keyword1'=> $order['snap_name'],
                        'keyword2'=> $order['o_amount'],
                        'remark'=> '',

                    ];;
                    $Official= new OfficialService();
                    $res= $Official->setTemplateData($tplData);
                    Log::record($res);

                }

                Db::commit();
                return true;

            }catch (Exception $e){
                Log::record($e);
                return false;

            }
        }else{
            Log::record($data);
            Db::rollback();
            return true;
        }


    }

    private function updateOrderStatus($orderID, $status){

        OrderModel::where('id','=', $orderID)->update(['status'=> $status,'pay_time'=> time()]);
    }

    private function sendSmsMessage($uniacid,$orderNo){
        $sendSmsMessage = new SmsMessage();
        $sms = SmsSet::where('uniacid', $uniacid)->find();
        Log::record($sms['number']);

        $phone = explode(',', $sms['number']);
        $result= true;
        if (is_array($phone)) {
            foreach ($phone as $key => $value) {
                //模板变量
                $result= $sendSmsMessage->smsMessage($uniacid,$value,$orderNo);
            }

        }

        return $result;
    }
}