<?php
/**
 * Created by PhpStorm.
 * User: 坤典科技
 * Date: 2018/11/29
 * Time: 15:39
 */
defined("IN_IA")or exit("Access Denied");
require_once ROOT_PATH.'model/animal.php';
require_once ROOT_PATH.'model/common.php';
require_once ROOT_PATH.'model/notice.php';
class AdoptController{
    protected $uid='';
    protected $uniacid='';
    static $notice='';
    static $animal='';

    public function __construct(){
        global $_GPC;
        $this->uniacid=$_GPC['uniacid'];
        $this->uid=$_GPC['uid'];
        self::$notice=new Notice_KundianFarmModel($this->uniacid);
        self::$animal=new Animal_KundianFarmModel($this->uniacid);
    }

    //获取认养列表信息  根据订单查询
    public function getAnimal($request){
        $page=empty($request['page']) ? 1 : $request['page']+1 ;
        $sel_con['status >']=0;
        if($request['current']!=6){
            $sel_con=['status'=>$request['current']];
        }

        $list=self::$animal->getAnimalOrder($sel_con,$page,10);
        for ($i=0;$i<count($list);$i++){
            $list[$i]['create_time']=date("Y-m-d",$list[$i]['create_time']);
        }
        $return['animalData']=$list;
        echo json_encode($return);die;
    }

    //获取认养详细认养信息
    public function getAnimalDetail($request){
        $order_id=$request['adoptid'];
        $orderData=pdo_get('cqkundian_farm_animal_order',['id'=>$order_id,'uniacid'=>$this->uniacid]);
        $orderData['create_time']=date("Y-m-d",$orderData['create_time']);
        $adoptData=pdo_getall('cqkundian_farm_animal_adopt',['order_id'=>$order_id,'uniacid'=>$this->uniacid],'','','create_time desc');
        for ($i=0;$i<count($adoptData);$i++){
            $animalData=pdo_get('cqkundian_farm_animal',['uniacid'=>$this->uniacid,'id'=>$adoptData[$i]['aid']]);
            $adoptData[$i]['animalData']=$animalData;
            $adoptData[$i]['predict_ripe']=date("Y-m-d",$adoptData[$i]['predict_ripe']);
            $adoptData[$i]['adopt_time']=date("Y-m-d",$adoptData[$i]['create_time']);
            $adoptData[$i]['status_txt']=self::$animal->neatAdoptStatus($adoptData[$i]['status']);
            $adoptData[$i]['adopt_day']=ceil((time()-$adoptData[$i]['create_time'])/86400);
            pdo_update('cqkundian_farm_animal_adopt',['adopt_day'=>$adoptData[$i]['adopt_day']],['id'=>$adoptData[$i]['id'],'uniacid'=>$this->uniacid]);
        }
        $user=pdo_get('cqkundian_farm_user',['uniacid'=>$this->uniacid,'uid'=>$orderData['uid']]);
        echo json_encode(['adoptData'=>$adoptData,'user'=>$user,'orderData'=>$orderData]);
    }

    //保存认养状态更新
    public function statusSave($request){
        $src=json_decode($_POST['src']);
        $update_data['src']=serialize($src);
        $res=self::$animal->insertStatus($request['txt'],$request['adoptid'],$this->uniacid,serialize($src));
        if($res){
            echo json_encode(array('code'=>1,'msg'=>'发布成功'));die;
        }
        echo json_encode(array('code'=>2,'msg'=>'发布失败'));die;
    }

    //发送模板消息通知用户当前认养状态
    public function sendTemplateToUser($request){
        $currentStatus=$request['currentStatus'];
        $adoptData=pdo_get('cqkundian_farm_animal_adopt',['uniacid'=>$this->uniacid,'id'=>$request['id']]);
        $animalData=pdo_get('cqkundian_farm_animal',['uniacid'=>$this->uniacid,'id'=>$adoptData['aid']]);
        $orderData=array(
            'body'=>'认养'.$animalData['animal_name'],
            'status'=>$currentStatus,
        );
        $send_res=self::$notice->sendFarmStatusTemplate($orderData,$adoptData['uid'],'/kundian_farm/pages/user/Animal/index');
        if($send_res->errcode==0){
            echo json_encode(['code'=>0,'msg'=>'消息发送成功','res'=>$send_res]);die;
        }
        echo json_encode(['code'=>-1,'msg'=>$send_res->errmsg,'res'=>$send_res]);die;
    }

    //改变认养状态信息
    public function changeAdoptStatus($request){
        $status=$request['status'];
        $update_data['status']=$status;
        if($status==2){
            $update_data['adopt_day']=1;
            $update_data['today_time']=time();
        }
        $res=pdo_update('cqkundian_farm_animal_adopt',$update_data,['id'=>$request['adopt_id'],'uniacid'=>$this->uniacid]);
        if($res){
            $title='认养状态更新咯~，当前状态为'.self::$animal->neatAdoptStatus($status).'~';
            self::$animal->insertStatus($title,$request['adopt_id'],$this->uniacid);
        }
        echo $res ? json_encode(array('code'=>0,'msg'=>'认养状态更新成功')) : json_encode(array('code'=>-1,'msg'=>'认养状态更新失败'));die;
    }

    //更新认养编号
    public function udpateAdoptNumber($request){
        $data['adopt_number']=$request['adopt_number'];
        $is_exist=pdo_get('cqkundian_farm_animal_adopt',['adopt_number'=>$request['adopt_number'],'uniacid'=>$this->uniacid]);
        if(!empty($is_exist)){
            echo json_encode(['code'=>-1,'msg'=>'认养编号已存在，请重新填写']);die;
        }
        $res=pdo_update('cqkundian_farm_animal_adopt',$data,['id'=>$request['adopt_id'],'uniacid'=>$this->uniacid]);
        if($res){
            //新增状态跟踪信息
            $title='已分配认养编号，编号：'.$data['adopt_number'];
            self::$animal->insertStatus($title,$request['adopt_id'],$this->uniacid);
        }
        echo $res ? json_encode(['code'=>0,'msg'=>'更新成功']) : json_encode(['code'=>-1,'msg'=>'更新失败']);die;
    }
}