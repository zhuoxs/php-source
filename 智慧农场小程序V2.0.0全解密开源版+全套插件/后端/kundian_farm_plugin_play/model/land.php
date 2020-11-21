<?php
/**
 * Created by PhpStorm.
 * User: zyl
 * Date: 2018/11/3
 * Time: 14:13
 */
defined("IN_IA")or exit("Access Denied");
require_once ROOT_PATH.'model/land.php';
class Land_Model{
    protected $farmLand='cqkundian_farm_land';
    protected $seed_bag='cqkundian_farm_seed_bag';
    protected $farmLandMine='cqkundian_farm_land_mine';
    protected $farmSendMine='cqkundian_farm_send_mine';
    protected $seed='cqkundian_farm_send';
    public $operationTable='cqkundian_farm_plugin_play_land_opeartion';
    protected $uniacid='';
    static $land='';
    public function __construct($uniacid){
        $this->uniacid=$uniacid;
        self::$land=new Land_KundianFarmModel('',$this->uniacid);
    }

    /**
     * 获取某块土地当前的种植状态
     * 已购买种子，只要种植作物中有一种作物成熟则就显示成熟状态，否则都为种植中的状态
     * 未购买种子，当前状态为 未种植
     * @param $landMine 当前用户的土地信息
     * @param $sendMine 当前土地种植的作物信息
     * @return array    返回值
     */
    public function getLandStatus($landMine){
        $process=0;
        if($landMine['status']==0){
            $process=0;//未种植
            return array('process'=>$process,'sendName'=>[]);
        }
        $sendName=array();
        $sendMine=pdo_getall($this->farmSendMine,['lid'=>$landMine['id'],'uniacid'=>$landMine['uniacid']]);
        foreach ($sendMine as $key => $value){
            if($value['status'] <=2) {
                $process = 1;   //种植中
                if ($value['status'] == 2) {
                    $process = 2;//已有作物成熟，显示可收获状态
                    break;
                }

            }else{
                if($value['status']==5){
                    $process=3;  //收获中;
                    break;
                }
            }
        }

        foreach ($sendMine as $key => $value){
            $sendName[]=$value;
        }
        return array('process'=>$process,'sendName'=>$sendName);
    }

    /** 摘取全部的已成熟的种子*/
    public function gainSeedAll($request){
        // 状态为2 表示已成熟
        $query = load()->object('query');
        $mineSeed = $query->from($this->farmSendMine, 'a')
            ->leftjoin($this->seed, 'b')->on('a.sid', 'b.id')->select('a.*','b.cover')
            ->where(['uniacid'=>$this->uniacid,'uid'=>$request['uid'],'lid'=>$request['mine_land_id'],'status'=>2])->getall();
        $result=0;
        //先将作物放入背包
        foreach ($mineSeed as $key=>$value){
            if($value['status']==2){
                // status =5 收获中
                $res=pdo_update($this->farmSendMine,['status'=>5],['uniacid'=>$this->uniacid,'id'=>$value['id']]);
                if($res){
                    $result+=$res;
                    $insertBag=array(
                        'uid'=>$value['uid'],
                        'seed_name'=>$value['send_name'],
                        'cover'=>$value['cover'],
                        'weight'=>$value['weight'],
                        'sale_price'=>$value['sale_price'],
                        'count'=>$value['count'],
                        'uniacid'=>$this->uniacid,
                        'create_time'=>time(),
                        'status'=>-1,   //收获中
                        'seed_id'=>$value['id'],
                    );
                    $result+=pdo_insert('cqkundian_farm_seed_bag',$insertBag);
                    $result+=self::$land->insertSeedStatus('种植已放入背包，请耐心等待管理员进行收获~',$value['lid'],$value['id'],$this->uniacid);
                }
            }
        }
        return $result;
    }


    /** 获取背包中的详细信息 */
    public function getBagList($uid){
        $query = load()->object('query');
        $depotData = $query->from($this->seed_bag, 'a')
            ->leftjoin($this->farmSendMine, 'b')->on('a.seed_id', 'b.id')->select('a.*','b.seed_time')
            ->where(['uid'=>$uid,'status in'=>[-1,0],'uniacid'=>$this->uniacid])->getall();
        for ($i=0;$i<count($depotData);$i++){
            $depotData[$i]['animation']=false;
            if($depotData[$i]['status']==-1){
                $depotData[$i]['animation']=true;
            }
            $depotData[$i]['seedDay']=ceil(($depotData[$i]['create_time']-$depotData[$i]['seed_time'])/86400);  //种植天数
            $depotData[$i]['seed_time']=date("Y-m-d H:i",$depotData[$i]['seed_time']);   //播种时间
            $depotData[$i]['create_time']=date("Y-m-d H:i",$depotData[$i]['create_time']);  //成熟时间
        }
        return $depotData;
    }

    /**
     * 插入操作信息
     * @param $insertData
     * @return bool
     */
    public function insertOperation($insertData){
        $res=pdo_insert($this->operationTable,$insertData);
        return pdo_insertid();
    }

    /**
     * 根据id查询施肥、除草、捉虫操作订单信息
     * @param $id
     * @param $uniacid
     * @return bool
     */
    public function selectOperationData($id){
        return pdo_get($this->operationTable,['id'=>$id,'uniacid'=>$this->uniacid]);
    }

    /**
     * 获取施肥、除草、捉虫多条订单信息
     * @param $cond
     * @param string $pageSize
     * @param string $pageIndex
     * @param string $order_by
     * @return array
     */
    public function selectOperationAll($cond,$pageSize='',$pageIndex='',$order_by='create_time desc'){
        if(!empty($pageSize) && !empty($pageIndex)){
            return pdo_getall($this->operationTable,$cond,'','',$order_by,[$pageIndex,$pageSize]);
        }else{
            return pdo_getall($this->operationTable,$cond,'','',$order_by);
        }
    }

    public function getOperationCount($cond){
        $query = load()->object('query');
        return $query->from($this->operationTable, 'u')->where($cond)->count();
    }

    /**
     * 删除信息
     * @param $id
     * @return bool
     */
    public function deleteOperation($id){
        if(!$id){
            return false;
        }
        return pdo_delete($this->operationTable,['id'=>$id,'uniacid'=>$this->uniacid]);
    }

    /**
     * 更新施肥、除草、捉虫订单信息
     * @param $update
     * @param $id
     * @return bool
     */
    public function updateOperation($update,$id){
        if(!$id){
            return false;
        }
        return pdo_update($this->operationTable,$update,['id'=>$id,'uniacid'=>$this->uniacid]);
    }
}