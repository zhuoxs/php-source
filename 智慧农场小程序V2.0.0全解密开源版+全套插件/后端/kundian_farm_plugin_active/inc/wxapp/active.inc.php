<?php
/**
 * Created by PhpStorm.
 * User: 坤典科技
 * Date: 2018/9/29
 * Time: 11:18
 * line 187
 */
defined("IN_IA")or exit("Access Denied");
!defined('ROOT_PATH_ACTIVE') && define('ROOT_PATH_ACTIVE', IA_ROOT . '/addons/kundian_farm_plugin_active/');
!defined('ROOT_PATH') && define('ROOT_PATH', IA_ROOT . '/addons/kundian_farm/');
include ROOT_PATH_ACTIVE.'inc/common/common.func.php';
require_once ROOT_PATH_ACTIVE.'model/active.php';
require_once ROOT_PATH.'model/common.php';
require_once ROOT_PATH.'model/notice.php';
class ActiveController{
    protected $uniacid='';
    protected $uid='';
    static $active='';
    static $common='';
    static $notice='';
    public function __construct(){
        global $_GPC;
        $this->uniacid=$_GPC['uniacid'];
        $this->uid=$_GPC['uid'];
        self::$active=new Active_KundianFarmPluginActive($this->uniacid);
        self::$common=new Common_KundianFarmModel('cqkundian_farm_plugin_active_set');
        self::$notice=new Notice_KundianFarmModel($this->uniacid);
    }

    /** 活动列表*/
    public function getActiveList($get){
        global $_W;
        $page=empty($get['page']) ? 1 : $get['page'];
        if($get['current']==2){
            $cond['end_time >']=time();
        }
        if($get['current'] == 3){
            $cond['end_time <']=time();
        }
        $cond['uniacid']=$this->uniacid;
        $active=pdo_getall('cqkundian_farm_plugin_active',$cond,'','','rank asc',[$page,10]);
        for ($i=0;$i<count($active);$i++){
            $spec=pdo_getall('cqkundian_farm_plugin_active_spec',['uniacid'=>$this->uniacid,'active_id'=>$active[$i]['id']],'price','','price asc');
            $active[$i]['low_price']=$spec[0]['price'];
            $active[$i]['finish']=false;
            if($active[$i]['end_time'] < time()){
                $active[$i]['finish']=true;
            }
            if($active['count'] > 0) {
                if ($active[$i]['person_count'] >= $active[$i]['count']) {
                    $active[$i]['finish'] = true;
                }
            }
            $active[$i]['begin_time']=date("m/d",$active[$i]['begin_time']);
            $active[$i]['end_time']=date("m/d",$active[$i]['end_time']);
        }
        $setData=self::$common->getSetData(['is_open_active','active_desc'],$this->uniacid);
        if($setData['active_desc']){
            $setData['active_desc']=explode("\n",$setData['active_desc']);
        }
        $request=['activeList'=>$active,'activeSetData'=>$setData,'openid'=>$_W];

        echo json_encode($request);die;
    }

    public function getActiveDetail($get){
        $active_id=$get['active_id'];
        $active=pdo_get(self::$active->active,['uniacid'=>$this->uniacid,'id'=>$active_id]);
        $spec=pdo_getall('cqkundian_farm_plugin_active_spec',['uniacid'=>$this->uniacid,'active_id'=>$active_id],'','','price asc');
        $sign_where=['uniacid'=>$this->uniacid,'active_id'=>$active_id,'is_pay'=>1];
        $sql="SELECT COUNT(*) FROM ".tablename(self::$active->active_order)." WHERE uniacid=:uniacid AND active_id=:active_id AND is_pay=:is_pay";
        $order_total = pdo_fetchcolumn($sql,[":uniacid"=>$this->uniacid,":active_id"=>$active_id,'is_pay'=>1]);
        $signOrder=pdo_getall(self::$active->active_order,$sign_where,['uid'],'',['create_time desc'],[0,5]);
        $sign_user=[];
        for ($i=0;$i<count($signOrder);$i++){
            $sign_user[$i]=pdo_get('cqkundian_farm_user',['uid'=>$signOrder[$i]['uid']],['nickname','avatarurl']);
        }
        if($active['end_time'] < time()){
            $active['is_sign']=1;  //活动已过期
        }else {
            if($active['times_enroll']==1){
                $active['is_sign'] = 2;
            }else{
                $is_sign = pdo_get(self::$active->active_order, ['active_id' => $active_id, 'uid' => $this->uid, 'uniacid' => $this->uniacid, 'is_pay' => 1]);
                $active['is_sign'] = 3;
                if (empty($is_sign)) {
                    $active['is_sign'] = 2; //未报名
                }
            }
        }
        $active['begin_time']=date("Y/m/d",$active['begin_time']);
        $active['end_time']=date("Y/m/d",$active['end_time']);
        $request=[
            'active'=>$active,
            'spec'=>$spec,
            'sign_user'=>$sign_user,
            'sign_count'=>$order_total,
            'sign_order'=>$is_sign,
        ];
        echo json_encode($request);die;
    }

    public function getActiveConfirm($get){
        global $_W;
        $active=pdo_get('cqkundian_farm_plugin_active',array('uniacid'=>$this->uniacid,'id'=>$get['active_id']));
        $active['begin_time']=date("Y/m/d",$active['begin_time']);
        $active['end_time']=date("Y/m/d",$active['end_time']);
        $active['add_info']=unserialize($active['add_info']);
        $request['active']=$active;
        $request['openid']=$_W;
        echo json_encode($request);die;
    }

    public function addOrder($get){
        $request_body = file_get_contents('php://input');
        $data = json_decode($request_body, true);
        $data['spec']=json_decode($data['spec']);
        $active=pdo_get(self::$active->active,['uniacid'=>$data['uniacid'],'id'=>$data['activeid']]);

        if(!empty($data['formid'])){
            self::$common->insertFormIdData($data['formid'],$data['uid'],'',1,$this->uniacid);
        }

        if($active['count']>0) {
            if ($active['count'] - $active['person_count'] < $data['selectNum']) {
                echo json_encode(['code' => 3, 'msg' => '当前余票不足!剩余' . ($active['count'] - $active['person_count'] . '张')]);die;
            }
        }
        $insertData=[
            'order_number'=>self::$common->getUniqueOrderNumber(),
            'uid'=>$data['uid'],
            'active_id'=>$data['activeid'],
            'count'=>$data['selectNum'],
            'total_price'=>$data['total'],
            'sign_up'=>$data['sign'],
            'create_time'=>time(),
            'uniacid'=>$data['uniacid'],
            'spec_id'=>$data['spec']->id,
        ];
        $active['is_check']==1 ? $insertData['is_check']=0 : $insertData['is_check']=1;
        if($data['total']==0){
            $insertData['is_pay']=1;
            $insertData['pay_time']=time();
            $insertData['pay_method']="免费";
        }

        $res=pdo_insert(self::$active->active_order,$insertData);
        $order_id=pdo_insertid();
        if($res){
            echo json_encode(['code'=>1,'msg'=>'订单生成成功','order_id'=>$order_id]);die;
        }
        echo json_encode(['code'=>2,'msg'=>'订单生成失败']);die;
    }

    public function notify($get){
        $order_id=$get['orderid'];
        $prepay_id_str=$get['prepay_id'];
        $orderData=pdo_get('cqkundian_farm_plugin_active_order',['id'=>$order_id,'uniacid'=>$this->uniacid]);
        if($orderData['is_pay']==1){
            $qrcode=self::$active->getQrCode($orderData['order_number']);
            $res1=pdo_update(self::$active->active,['person_count +='=>$orderData['count']],['uniacid'=>$this->uniacid,'id'=>$orderData['active_id']]);
            $res2=pdo_update(self::$active->active_order,['qrcode'=>$qrcode],['uniacid'=>$this->uniacid,'id'=>$orderData['id']]);
            if($res1 && $res2) {
                $active=pdo_get(self::$active->active,['id'=>$orderData['active_id']]);
                $orderData['body']=$active['title'];
                $prepay_id = explode('=', $prepay_id_str);
                $page = '/kundian_farm/pages/funding/orderList/index';
                $user=pdo_get('cqkundian_farm_user',['uid'=>$orderData['uid'],'uniacid'=>$this->uniacid]);
                self::$notice->isPaySendNotice($orderData,$prepay_id[1],$user['openid'],$this->uniacid,$page);
                self::$common->insertFormIdData($prepay_id[1],$orderData['uid'],$user['openid'],2,$this->uniacid);
                echo json_encode(['code' => 1, 'msg' => 'success']);die;
            }
            echo json_encode(['code' => 1, 'msg' => '订单信息更新失败']);die;
        }
        echo json_encode(['code'=>2,'msg'=>'订单未支付']);die;
    }

    public function getSignInfo($get){
        $sign_where=['uniacid'=>$this->uniacid,'active_id'=>$get['active_id'],'is_pay'=>1];
        $signOrder=pdo_getall('cqkundian_farm_plugin_active_order',$sign_where,['uid'],'',['create_time desc']);
        $sign_user=[];
        for ($i=0;$i<count($signOrder);$i++){
            $sign_user[$i]=pdo_get('cqkundian_farm_user',['uid'=>$signOrder[$i]['uid']],['nickname','avatarurl']);
        }
        $request['signInfo']=$sign_user;
        echo json_encode($request);die;
    }
}
