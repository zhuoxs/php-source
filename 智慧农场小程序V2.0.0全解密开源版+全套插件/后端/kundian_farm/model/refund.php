<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/1/10 0010
 * Time: 下午 1:54
 */
defined('IN_IA') or exit('Access Denied');
require_once ROOT_PATH.'model/notice.php';
class Refund_KundianFarmModel{
    protected $uniacid='';
    static $notice='';
    public function __construct($uniacid=0){
        global $_W;
        $this->uniacid=$_W['uniacid'];
        if(!empty($uniacid) && $uniacid!=0){
            $this->uniacid=$uniacid;
        }
        self::$notice=new Notice_KundianFarmModel($this->uniacid);
    }

    /** 普通商城订单退款 */
    public function refundShopOrder($order_id){
        global $_W;
        load()->model('refund');
        $orderData=pdo_get('cqkundian_farm_shop_order',array('uniacid'=>$this->uniacid,'id'=>$order_id));
        $refundid=refund_create_order($orderData['order_number'],'kundian_farm');
        $result=$this->refund($refundid);
        if($result['return_code']=="SUCCESS"){
            $res1=pdo_update('core_refundlog', array('status' => '-1'), array('id' => $refundid));
            $res2=pdo_update('cqkundian_farm_shop_order', array('apply_delete' => '2'), array('id' => $order_id));
            if($res1 || $res2){
                return ['code'=>0,'msg'=>'退款成功'];
            }
        }
        return ['code'=>-1,'msg'=>'退款失败'];
    }

    /** 组团商城订单退款 */
    public function refundGroupOrder($order_id){
        load()->model('refund');
        $orderData=pdo_get('cqkundian_farm_group_order',array('uniacid'=>$this->uniacid,'id'=>$order_id));
        $refundid=refund_create_order($orderData['order_number'],'kundian_farm');
        $result=$this->refund($refundid);
        if($result['return_code']=="SUCCESS"){
            $res1=pdo_update('core_refundlog', array('status' => '-1'), array('id' => $refundid));
            $res2=pdo_update('cqkundian_farm_group_order', array('apply_delete' => '2'), array('id' => $order_id));
            $this->updateGroupData($order_id,$this->uniacid);
            if($res1 || $res2){
                return ['code'=>0,'msg'=>'退款成功'];
            }
        }
        return ['code'=>-1,'msg'=>'退款失败'];
    }


    /** 拼团订单退款 【拼团插件】*/
    public function ptRefundOrder($order_id){
        load()->model('refund');
        $orderData=pdo_get('cqkundian_farm_pt_order',['uniacid'=>$this->uniacid,'id'=>$order_id]);
        $refundid=refund_create_order($orderData['order_number'],'kundian_farm_plugin_pt');
        $result=$this->refund($refundid);
        if($result['return_code']=="SUCCESS"){
            $res1=pdo_update('core_refundlog', array('status' => '-1'), array('id' => $refundid));
            $res2=pdo_update('cqkundian_farm_pt_order', array('apply_delete' => '2'), ['id' => $order_id]);
            if($res1 || $res2){
                return ['code'=>0,'msg'=>'退款成功'];
            }
        }
        return ['code'=>-1,'msg'=>'退款失败'];
    }

    /** 众筹订单退款 【众筹插件】*/
    public function refundFundOrder($order_id){
        load()->model('refund');
        $orderData=pdo_get('cqkundian_farm_plugin_funding_order',['uniacid'=>$this->uniacid,'id'=>$order_id]);
        $refundid=refund_create_order($orderData['order_number'],'kundian_farm');
        $result=$this->refund($refundid);
        if($result['message']=="OK"){
            $res1=pdo_update('core_refundlog', ['status' => '-1'], ['id' => $refundid]);
            $res2=pdo_update('cqkundian_farm_plugin_funding_order', ['apply_delete' => '2'], ['id' => $order_id]);
            $updateData=[
                'fund_money -='=>$orderData['pra_price'],
                'fund_person_count -'=>1,
            ];
            $res3=pdo_update('cqkundian_farm_plugin_funding_project',$updateData,['uniacid'=>$orderData['pid'],'uniacid'=>$this->uniacid]);
            if($res1 || $res2 || $res3){
                return ['code'=>0,'msg'=>'退款成功'];
            }
        }
        return ['code'=>-1,'msg'=>'退款失败'];
    }

    /** 农场乐园除草等信息退款 */
    public function refundPlayOperation($order_id){
        load()->model('refund');
        $orderData=pdo_get('cqkundian_farm_plugin_play_land_opeartion',['uniacid'=>$this->uniacid,'id'=>$order_id]);
        $refundid=refund_create_order($orderData['order_number'],'kundian_farm');
        $result=$this->refund($refundid);
        if($result['return_code']=="SUCCESS"){
            $res1=pdo_update('core_refundlog', ['status' => '-1'], ['id' => $refundid]);
            $res2=pdo_update('cqkundian_farm_plugin_play_land_opeartion', ['is_operation' => '2'], ['id' => $order_id]);
            if($res1 || $res2){
                require_once ROOT_PATH.'model/common.php';
                $common=new Common_KundianFarmModel('cqkundian_farm_set');
                $playSet=$common->getSetData(['task_template_id'],$this->uniacid);
                $user=pdo_get('cqkundian_farm_user',['uid'=>$orderData['uid'],'uniacid'=>$this->uniacid]);
                $send_res=self::$notice->sendTaskCompleteNotice($orderData,$playSet['task_template_id'],'已退款',$user['openid'],$this->uniacid);
                return ['code'=>0,'msg'=>'退款成功'];
            }
            return ['code'=>0,'msg'=>'退款成功'];
        }
        return ['code'=>-1,'msg'=>'退款失败'];
    }


    /** 执行退款操作 */
    public function refund($refund_id) {
        load()->classs('pay');
        global $_W;
        load()->model('refund');
        $refundlog = pdo_get('core_refundlog', array('id' => $refund_id,'uniacid'=>$_W['uniacid']));
        $paylog = pdo_get('core_paylog', array('uniacid' => $_W['uniacid'], 'uniontid' => $refundlog['uniontid']));
        if ($paylog['type'] == 'wxapp') {
            $refund_param = reufnd_wechat_build($refund_id);
            $wechat = Pay::create('wechat');
            $response = $wechat->refund($refund_param);
            unlink(ATTACHMENT_ROOT . $_W['uniacid'] . '_wechat_refund_all.pem');
            if (!is_error($response)) {
                pdo_update('core_refundlog', array('status' => '-1'), array('id' => $refund_id));
                return $response;
            } else {
                return $response;
            }
        }
        return error(1, '此订单退款方式不存在');
    }

    /** 退款成功后更新组团信息*/
    public function updateGroupData($order_id,$uniacid){
        $orderData=pdo_get('cqkundian_farm_group_order',array('id'=>$order_id,'uniacid'=>$uniacid));
        $order_detail=pdo_get('cqkundian_farm_group_order_detail',array('order_id'=>$order_id,'uniacid'=>$uniacid));
        if($order_detail['spec_id']){
            pdo_update('cqkundian_farm_group_goods_spec',array('count +='=>$order_detail['count']),array('id'=>$order_detail['spec_id'],'uniacid'=>$uniacid));
        }else{
            pdo_update('cqkundian_farm_group_goods',array('count +='=>$order_detail['count']),array('goods_id'=>$order_detail['goods_id'],'uniacid'=>$uniacid));
        }
        //删除组团信息
        pdo_delete('cqkundian_farm_group',array('order_id'=>$order_id,'uid'=>$orderData['uid'],'uniacid'=>$uniacid));
    }

}