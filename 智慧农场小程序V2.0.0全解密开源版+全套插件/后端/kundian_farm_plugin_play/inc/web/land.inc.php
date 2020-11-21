<?php
/**
 * Created by PhpStorm.
 * User: 坤典科技
 * Date: 2018/11/9
 * Time: 16:38
 */
defined("IN_IA") or exit("Access Denied");
require_once ROOT_PATH_PLAY.'model/land.php';
require_once ROOT_PATH.'model/common.php';
require_once ROOT_PATH.'model/refund.php';
require_once ROOT_PATH.'model/notice.php';
require_once ROOT_PATH.'model/public.php';
class Play_Land{
    protected $that='';
    protected $uniacid='';
    static $common='';
    static $playLand='';
    static $notice='';
    public function __construct($that){
        global $_W;
        checklogin();
        $this->that=$that;
        $this->uniacid=$_W['uniacid'];
        self::$common=new Common_KundianFarmModel('cqkundian_farm_plugin_play_set');
        self::$playLand=new Land_Model($this->uniacid);
        self::$notice=new Notice_KundianFarmModel($this->uniacid);
    }

    /** 任务订单列表 */
    public function operation_list($get){
        $pageIndex=$get['page'] ? $get['page'] : '1';
        $public=new Public_KundianFarmModel(self::$playLand->operationTable,$this->uniacid);
        $data=$public->getTableList([],$pageIndex,15,'create_time desc',true);
        for ($i=0;$i<count($data['list']);$i++){
            $user=pdo_get('cqkundian_farm_user',['uid'=>$data['list'][$i]['uid'],'uniacid'=>$this->uniacid]);
            $data['list'][$i]['nickname']=$user['nickname'];
        }
        $this->that->doWebCommon("web/land/operation_list",$data);
    }

    /** 删除任务订单 */
    public function delOperation($get){
        $id=$get['id'];
        $res=self::$playLand->deleteOperation($id);
        echo $res ? json_encode(['status'=>0,'msg'=>'删除成功']) :json_encode(['status'=>-1,'msg'=>'删除失败']);die;
    }

    /** 操作信息  */
    public function operation_land($get){
        $orderData=pdo_get(self::$playLand->operationTable,['id'=>$get['id'],'uniacid'=>$this->uniacid]);
        $user=pdo_get('cqkundian_farm_user',['uid'=>$orderData['uid'],'uniacid'=>$this->uniacid]);
        $res=pdo_update(self::$playLand->operationTable,['is_operation'=>1,'operation_time'=>time()],['id'=>$get['id'],'uniacid'=>$this->uniacid]);
        if(!$res){
            echo json_encode(['status'=>-1,'msg'=>'操作失败']);die;
        }
        $playSet=self::$common->getSetData(['task_template_id'],$this->uniacid);
        $send_res=self::$notice->sendTaskCompleteNotice($orderData,$playSet['task_template_id'],'已完成',$user['openid']);
        echo json_encode(['status'=>0,'msg'=>'操作成功']);die;
    }

    /** 退款 */
    public function playOperationRefund($get){
        $refund=new Refund_KundianFarmModel($this->uniacid);
        $result=$refund->refundPlayOperation($get['id']);
        echo json_encode($result);die;
    }
}