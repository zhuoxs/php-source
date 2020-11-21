<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/11/29
 * Time: 15:18
 */
defined("IN_IA")or exit("Access Denied");
require_once ROOT_PATH.'model/common.php';
require_once ROOT_PATH.'model/land.php';
require_once ROOT_PATH.'model/user.php';
require_once ROOT_PATH.'model/notice.php';
class LandController{
    protected $uid='';
    protected $uniacid='';
    static $notice='';
    static $common='';
    static $land='';
    public function __construct(){
        global $_GPC;
        $this->uniacid=$_GPC['uniacid'];
        $this->uid=$_GPC['uid'];
        self::$notice=new Notice_KundianFarmModel($this->uniacid);
        self::$common=new Common_KundianFarmModel();
        self::$land=new Land_KundianFarmModel();
    }

    //获取种植列表信息
    public function getLand($get){
        $current=$get['current'];
        $page=empty($get['page']) ? 1 : $get['page']+1;

        $condition['a.uniacid']=$this->uniacid;
        $condition['c.uniacid']=$this->uniacid;
        $condition['b.uniacid']=$this->uniacid;
        $condition['d.uniacid']=$this->uniacid;
        if($current==4){
            $query = load()->object('query');
            $lidData = $query->from('cqkundian_farm_send_mine', 's')->leftjoin('cqkundian_farm_land_mine', 'l')->select('l.id')
                ->on('l.id', 's.lid')->where(['s.status'=>0,'l.status <'=>2])->getall();
            $lidArr=[];
            foreach ($lidData as $item) {
                $lidArr[]=$item['id'];
            }
            $condition['id in']=array_unique($lidArr);
        }else{
            if($current!=6){
                $condition['status']=$current;
            }

        }
        $landData=self::$land->getMineLand($condition,$page,15);
        $request['landData']=$landData;
        $farmSetData=self::$common->getSetData(['is_open_webthing'],$this->uniacid);
        $request['farmSetData']=$farmSetData;
        echo json_encode($request);die;
    }

    //除草
    public function weeding($get){
        $lid=$get['lid'];
        $mineLand=pdo_get('cqkundian_farm_land_mine',array('uniacid'=>$this->uniacid,'id'=>$lid));
        //查找formid
        $formId='';
        $openid='';
        $formIdData=pdo_getall('cqkundian_farm_form_id',array('uniacid'=>$this->uniacid,'uid'=>$mineLand['uid']),'','','id asc');
        for ($i=0;$i<count($formIdData);$i++){
            if($formIdData[$i]['create_time']+(7*86400) > time()){
                $formId=$formIdData[$i]['formid'];
                $openid=$formIdData[$i]['openid'];
                pdo_delete('cqkundian_farm_form_id',array('uniacid'=>$this->uniacid,'id'=>$formIdData[$i]['id']));
                break;
            }else{
                pdo_delete('cqkundian_farm_form_id',array('uniacid'=>$this->uniacid,'id'=>$formIdData[$i]['id']));
            }
        }
        $res=pdo_update('cqkundian_farm_land_mine',array('weeding_update'=>time(),'weeding_tag'=>0),array('uniacid'=>$this->uniacid,'id'=>$lid));
        if($res){
            $page="/kundian_farm/pages/user/land/index/index?lid=".$lid;
            self::$notice->sendServiceInfoToUser('除草','今日已除草！',$openid,$page,$formId);
            echo json_encode(array('code'=>200,'msg'=>'除草信息已更新！'));die;
        }
        echo json_encode(array('code'=>200,'msg'=>'除草信息更新失败!'));die;
    }

    //杀虫操作
    public function killVer($get){
        $lid=$get['lid'];
        $mineLand=pdo_get('cqkundian_farm_land_mine',array('uniacid'=>$this->uniacid,'id'=>$lid));
        //查找formid
        $formId='';
        $openid='';
        $formIdData=pdo_getall('cqkundian_farm_form_id',array('uniacid'=>$this->uniacid,'uid'=>$mineLand['uid']),'','','id asc');
        for ($i=0;$i<count($formIdData);$i++){
            if($formIdData[$i]['create_time']+(7*86400) > time()){
                $formId=$formIdData[$i]['formid'];
                $openid=$formIdData[$i]['openid'];
                pdo_delete('cqkundian_farm_form_id',array('uniacid'=>$this->uniacid,'id'=>$formIdData[$i]['id']));
                break;
            }else{
                pdo_delete('cqkundian_farm_form_id',array('uniacid'=>$this->uniacid,'id'=>$formIdData[$i]['id']));
            }
        }
        $res=pdo_update('cqkundian_farm_land_mine',array('insecticide_update'=>time(),'insecticide_tag'=>0),array('uniacid'=>$this->uniacid,'id'=>$lid));
        if($res){
            $page="/kundian_farm/pages/user/land/index/index?lid=".$lid;
            $res=self::$notice->sendServiceInfoToUser('除草','今日已杀虫！',$openid,$page,$formId);
            echo json_encode(array('code'=>200,'msg'=>'杀虫信息已更新！'));die;
        }else{
            echo json_encode(array('code'=>200,'msg'=>'杀虫信息更新失败!'));die;
        }
    }

    //获取种植详情
    public function getLandDetail($get){
        $seedDetail=self::$land->getSeedDetail($get['mineid'],$this->uniacid);
        $landDetail=$seedDetail['mineLand'];
        $landOrder=pdo_get('cqkundian_farm_land_order',array('uniacid'=>$this->uniacid,'id'=>$landDetail['order_id']));
        $landDetail['username']=$landOrder['username'];
        $landDetail['phone']=$landOrder['phone'];
        $landDetail['order_number']=$landOrder['order_number'];
        $landDetail['exprie_time']=date("Y-m-d",$landDetail['exprie_time']);
        $request=array(
            'landDetail'=>$landDetail,
            'seedData'=>$seedDetail['seedList'],
            'landData'=>$seedDetail['landData'],
            'landSpec'=>$seedDetail['landSpec'],
        );
        echo json_encode($request);die;
    }

    //保存状态跟踪信息
    public function statusSave($get){
        $src=json_decode($_POST['src']);
        $res=self::$land->insertSeedStatus($get['txt'],$get['lid'],$get['seed_id'],$this->uniacid,serialize($src));
        if($res){
            echo json_encode(array('code'=>1,'msg'=>'发布成功'));die;
        }
        echo json_encode(array('code'=>2,'msg'=>'发布失败'));die;
    }

    //保存种植产量预估信息
    public function seedEstimate($get){
        $seed_id=$get['id'];
        $weight=$get['weight'];
        $sale_price=$get['sale_price'];
        $update_data=array(
            'weight'=>$weight,
            'sale_price'=>$sale_price,
            'status'=>$get['status'],
        );
        $res=self::$land->updateSeedMine($update_data,['id'=>$seed_id,'uniacid'=>$this->uniacid]);
        if($res){
            $seedData=self::$land->getSeedMine(['id'=>$seed_id,'uniacid'=>$this->uniacid],false);
            $status_txt=self::$land->neatSeedStatus($get['status']);
            self::$land->insertSeedStatus('种子状态'.$status_txt.',预计产量'.$weight.'kg,预计售出单价为'.$sale_price.'元/kg',$seedData['lid'],$seed_id,$this->uniacid);
        }
        echo $res ? json_encode(['code'=>'0','msg'=>'保存成功']) : json_encode(['code'=>-1,'msg'=>'保存失败']);die;
    }


    //给用户发送模板消息通知用户当前种植状态信息
    public function sendTemplateToUser($get){
        $seedData=self::$land->getSeedMine(['id'=>$get['id'],'uniacid'=>$this->uniacid],false);
        $currentStatus=self::$land->neatSeedStatus($seedData['status']);
        $orderData=array(
            'body'=>'种植'.$seedData['send_name'],
            'status'=>$currentStatus,
        );
        $send_res=self::$notice->sendFarmStatusTemplate($orderData,$seedData['uid'],'/kundian_farm/pages/user/land/personLand/index');
        if($send_res->errcode==0){
            echo json_encode(['code'=>0,'msg'=>'消息发送成功','res'=>$send_res]);die;
        }else{
            echo json_encode(['code'=>-1,'msg'=>$send_res->errmsg,'res'=>$send_res]);die;
        }

    }

    //保存确认产量信息
    public function gainSeed($get){
        $update_data=array(
            'weight'=>$get['weight'],
            'sale_price'=>$get['sale_price'],
            'status'=>$get['status'],
        );

        $seed_id=$get['id'];
        $res=self::$land->updateSeedMine($update_data,['id'=>$seed_id,'uniacid'=>$this->uniacid]);
        if($res){
            $seedData=self::$land->getSeedMine(['id'=>$seed_id,'uniacid'=>$this->uniacid],false);
            $seed=pdo_get('cqkundian_farm_send',array('id'=>$seedData['sid'],'uniacid'=>$this->uniacid));
            //放入背包
            $insertBag=array(
                'uid'=>$seedData['uid'],
                'seed_name'=>$seedData['send_name'],
                'cover'=>$seed['cover'],
                'weight'=>$get['weight'],
                'sale_price'=>$get['sale_price'],
                'count'=>$seedData['count'],
                'uniacid'=>$this->uniacid,
                'create_time'=>time(),
                'status'=>0,
                'seed_id'=>$seed_id,
            );
            self::$land->addSeedBag($insertBag);
            self::$land->insertSeedStatus('种植已放入背包，可以去下单配送了哦~',$seedData['lid'],$seed_id,$this->uniacid);
            echo json_encode(['code'=>0,'msg'=>'操作成功']);die;
        }
        echo json_encode(['code'=>-1,'msg'=>'操作失败']);die;
    }

    //改变种植的其他状态信息
    public function changeSeedStstua($get){
        $update_data=['status'=>$get['status']];
        if($get['status']==1){
            $update_data['seed_time']=time();
        }
        $res=pdo_update('cqkundian_farm_send_mine',$update_data,['id'=>$get['id']]);
        if($res){
            $status_txt=self::$land->neatSeedStatus($get['status']);
            $seedData=self::$land->getSeedMine(['id'=>$get['id'],'uniacid'=>$this->uniacid],false);
            self::$land->insertSeedStatus('种子状态更新啦,当前状态：'.$status_txt,$seedData['lid'],$get['id'],$this->uniacid);
            echo json_encode(['code'=>0,'msg'=>'操作成功']);die;
        }
        echo json_encode(['code'=>-1,'msg'=>'操作失败']);die;
    }
}