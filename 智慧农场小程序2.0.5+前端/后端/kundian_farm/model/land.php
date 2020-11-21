<?php
/**
 * Created by PhpStorm.
 * User: 坤典科技
 * Date: 2018/10/11
 * Time: 11:29
 */
defined("IN_IA")or exit("Access Denied");
require_once ROOT_PATH.'model/user.php';
require_once ROOT_PATH.'model/control.php';
class Land_KundianFarmModel{
    public $tableName='cqkundian_farm_land';
    public $land_type='cqkundian_farm_land_type';
    public $land_mine='cqkundian_farm_land_mine';
    public $statusName='cqkundian_farm_send_status';
    public $seedBagTable='cqkundian_farm_seed_bag';
    public $seed_mine='cqkundian_farm_seed_mine';
    public $land_spec='cqkundian_farm_land_spec';
    public $land_limit='cqkundian_farm_land_buy_limit';
    public $live='cqkundian_farm_live';
    public $seed='cqkundian_farm_send';
    public $land_operation_record='cqkundian_farm_land_operation_record';

    protected $uniacid='';
    static $user='';
    static $control='';
    public function __construct($tableName='',$uniacid=''){
        if(!empty($tableName)){
            $this->tableName=$tableName;
        }
        if($uniacid){
           $this->uniacid=$uniacid;
        }
        self::$user=new User_KundianFarmModel();
        self::$control=new Control_KundianFarmModel($this->uniacid);
    }

    /**
     * 添加土地分类信息
     * @param $formData
     * @return bool
     */
    public function addLandType($formData){
        $data=array(
            'name'=>$formData['name'],
            'rank'=>$formData['rank'],
            'uniacid'=>$this->uniacid,
        );
        if(empty($formData['id'])){  //新增
            $request=pdo_insert($this->land_type,$data);
        }else{
            $condition=array(
                'id'=>$formData['id'],
                'uniacid'=>$this->uniacid,
            );
            $request=pdo_update($this->land_type,$data,$condition);
        }
        return $request;
    }

    /**
     * 获取土地列表信息 和 土地的最低价格
     * @param array $cond
     * @param string $pageIndex
     * @param string $pageSize
     * @return array
     */
    public function getLandAndSpec($cond=[],$pageIndex='',$pageSize=''){
        $cond['uniacid']=$this->uniacid;
        if(!empty($pageSize) && !empty($pageIndex)){
            $list=pdo_getall($this->tableName,$cond,'','','rank asc',[$pageIndex,$pageSize]);
        }else{
            $list=pdo_getall($this->tableName,$cond,'','','rank asc');
        }
        for ($i=0;$i<count($list);$i++){
            $price=pdo_getall($this->land_spec,['uniacid'=>$this->uniacid,'land_id'=>$list[$i]['id']],['price','area'],'','price asc');
            $list[$i]['spec_price']=$price[0]['price'];
            $list[$i]['spec_area']=$price[0]['area'];
        }
        return $list;
    }

    /***
     * 获取土地信息和相关联的分类信息
     * @param array $cond
     * @param string $pageIndex
     * @param string $pageSize
     * @return mixed
     */
    public function getLandAndType($cond=[],$pageIndex='',$pageSize=''){
        $query = load()->object('query');
        $cond['uniacid']=$this->uniacid;
        $list = $query->from($this->tableName, 'a')
            ->leftjoin($this->land_type, 'b')->on('a.type_id', 'b.id')
            ->select('a.*','b.name')
            ->where($cond)->orderby('rank asc')->page($pageIndex,$pageSize)->getall();
        for($i=0;$i<count($list);$i++){
            //判断该土地是否存在用户租赁
            $land_mine=pdo_get($this->land_mine,['uniacid'=>$this->uniacid,'lid'=>$list[$i]['id']]);
            if(empty($land_mine)){
                $list[$i]['is_delete']=true;
            }else{
                $list[$i]['is_delete']=false;
            }
        }
        return $list;
    }

    /** 获取土地操作记录*/
    public function getLandOpeartion($cond=[]){
        $query = load()->object('query');
        $cond['uniacid']=$this->uniacid;
        $list=$query->from($this->land_operation_record, 'a')
            ->leftjoin('cqkundian_farm_user', 'b')->on('a.uid', 'b.uid')
            ->select('a.*','b.nickname')
            ->where($cond)->getall();
        for ($i=0; $i < count($list); $i++) {
            $list[$i]['create_time']=date("Y-m-d H:i:s",$list[$i]['create_time']);
        }
        return $list;
    }

    public function getLandMineSpec($cond,$mutil=true){
        $query = load()->object('query');
        $cond['uniacid']=$this->uniacid;
        if($mutil){
          return $query->from($this->land_mine, 'a')
                ->leftjoin($this->land_spec, 'b')->on('a.spec_id', 'b.id')
                ->select('a.*','b.land_num')
                ->where($cond)->getall();
        }

        return $query->from($this->land_mine, 'a')
            ->leftjoin($this->land_spec, 'b')->on('a.spec_id', 'b.id')
            ->select('a.*','b.land_num')
            ->where($cond)->get();
    }

    public function getUserLandMineSpec($cond,$pageIndex='',$pageSize=''){
        $query = load()->object('query');
        $cond['uniacid']=$this->uniacid;
        if(!empty($pageIndex) && !empty($pageSize)){
            return $query->from($this->land_mine, 'a')
                ->leftjoin($this->land_spec, 'b')->on('a.spec_id', 'b.id')
                ->leftjoin('cqkundian_farm_user', 'c')->on('a.uid', 'c.uid')
                ->select('a.*','b.land_num','c.nickname')
                ->where($cond)->page($pageIndex,$pageSize)->getall();
        }
        return $query->from($this->land_mine, 'a')
            ->leftjoin($this->land_spec, 'b')->on('a.spec_id', 'b.id')
            ->leftjoin('cqkundian_farm_user', 'c')->on('a.uid', 'c.uid')
            ->select('a.*','b.land_num','b.device_id','c.nickname')
            ->where($cond)->getall();
    }

    /**
     * 获取土地详情、规格 、种植年限 等信息
     * @param $lid
     * @return array
     */
    public function getLandDetail($lid,$setData=[]){
        $landDetail =$this->getLandAndLive(['id'=>$lid,'uniacid'=>$this->uniacid]);
        //查询可种植的种子
        $seedid=explode(',', $landDetail['seed']);
        $seedData=pdo_getall($this->seed,['id in'=>$seedid,'uniacid'=>$this->uniacid],'','','rank asc');
        //获取规格信息 、获取土地年限
        $landSpec=pdo_getall($this->land_spec,['land_id'=>$landDetail['id'],'uniacid'=>$this->uniacid],'','','status asc');
        $landDataLimit=pdo_getall($this->land_limit,['uniacid'=>$this->uniacid,'lid'=>$landDetail['id']],'','','rank asc');
        if(!empty($setData)){
            //获取物联网设备信息
            $landDetail['landDeviceInfo']=false;
            if($setData['is_open_webthing']==1) {
                if ($landDetail['device_id'] != 0 && $landDetail['device_id'] != '') {
                    $device_id = pdo_get('cqkundian_farm_device',['uniacid' => $this->uniacid, 'id' => $landDetail['device_id']], ['did']);
                    $landDetail['landDeviceInfo'] = self::$control->getControlInfo($device_id['did']);
                }
            }elseif ($setData['is_open_webthing']==2){
                if($landDetail['yun_device_id']){

                    $landDetail['yun_device_id']=unserialize($landDetail['yun_device_id']);
                    $landDetail['landDeviceInfo']['temp']=self::$control->getYunDeviceInfo($this->uniacid,$landDetail['yun_device_id']['temp_device_id']);
                    $landDetail['landDeviceInfo']['co2']=self::$control->getYunDeviceInfo($this->uniacid,$landDetail['yun_device_id']['co2_device_id']);
                    $landDetail['landDeviceInfo']['light']=self::$control->getYunDeviceInfo($this->uniacid,$landDetail['yun_device_id']['light_device_id']);
                }
            }
        }
        return [
            'landDetail'=>$landDetail,
            'landSpec'=>$landSpec,
            'landDataLimit'=>$landDataLimit,
            'seedData'=>$seedData
        ];
    }


    /***
     * 获取我的种植详情信息
     * @param $request  传递的数据
     * @param $cond     查询条件
     * @param bool $is_device   是否查询设备信息
     * @param array $setData    设备配置信息
     * @return array
     */
    public function getMineLandDetail($request,$cond,$is_device=true,$setData=[]){
        $query = load()->object('query');
        $cond['uniacid']=$this->uniacid;
        $mineLand = $query->from($this->land_mine, 'a')
            ->leftjoin($this->tableName, 'b')->on('a.lid', 'b.id')
            ->leftjoin($this->land_spec, 'c')->on('a.spec_id', 'c.id')
            ->select('a.*','b.land_name', 'c.land_num','b.seed','c.live_id as spec_live_id','b.cover','b.yun_device_id','b.live_id as land_live_id','c.device_id')
            ->where($cond)->get();

        $mineLand['exprie_time']=date("Y-m-d H:i",$mineLand['exprie_time']);
        $mineLand['create_time']=date("Y-m-d H:i",$mineLand['create_time']);
        $landSeed=pdo_getall('cqkundian_farm_send_mine',['lid'=>$request['lid'],'uniacid'=>$this->uniacid],'','','id desc');
        $mineLand['use_area']=0;  //已种植面积
        $mineLand['wait_area']=0;  //待播种面积
        if(!empty($landSeed)) {
            for ($i = 0; $i < count($landSeed); $i++) {
                if (in_array($landSeed[$i]['status'], [1, 2, 5])) {
                    $mineLand['use_area'] += $landSeed[$i]['count'];
                    $landSeed[$i]['backColor']='#b6d7a8';
                }

                if ($landSeed[$i]['status'] == 0) {
                    $mineLand['wait_area'] += $landSeed[$i]['count'];
                    $landSeed[$i]['backColor']='#d9d9d9';
                }

                if(in_array($landSeed[$i]['status'],[4,3,6,7])){
                    $landSeed[$i]['backColor']='#fbc791';
                }

                if($landSeed[$i]['seed_time'] > 0){
                    $landSeed[$i]['seedDay'] = ceil((time() - $landSeed[$i]['seed_time']) / 84600);
                    $landSeed[$i]['seed_time'] = date("Y-m-d H:i", $landSeed[$i]['seed_time']);
                }else{
                    $landSeed[$i]['seedDay'] = 0;
                    $landSeed[$i]['seed_time'] = '--';
                }
                $landSeed[$i]['status_txt'] = $this->neatSeedStatus($landSeed[$i]['status']);
            }
        }
        $mineLand['residue_area'] = $mineLand['count'] - $mineLand['use_area']-$mineLand['wait_area'];
        if($is_device){
            $live_cond=[
                'uniacid'=>$this->uniacid,
                'id'=>$mineLand['spec_live_id'] ? $mineLand['spec_live_id'] :$mineLand['land_live_id']
            ];
            $liveData=pdo_get($this->live,$live_cond);
            $mineLand['live_src']=$liveData['src'];
            //获取设备信息
            if($mineLand['spec_id']){
                $request['spec']=$mineLand['spec_id'];
                //设备号
                $mineLand['deviceData']=[];
                if($mineLand['device_id']){
                    $device=pdo_get('cqkundian_farm_device',['uniacid'=>$this->uniacid,'id'=>$mineLand['device_id']]);
                    $mineLand['deviceInfo']=$device;
                    $mineLand['deviceData'] = self::$control->getControlInfo($device['did']);
                }
            }

            $mineLand['device']=false;
            if ($setData['is_open_webthing']==2){
                if($mineLand['yun_device_id']) {
                    $mineLand['yun_device_id'] = unserialize($mineLand['yun_device_id']);
                    $mineLand['device']['temp'] = self::$control->getYunDeviceInfo($this->uniacid, $mineLand['yun_device_id']['temp_device_id']);
                    $mineLand['device']['co2'] = self::$control->getYunDeviceInfo($this->uniacid, $mineLand['yun_device_id']['co2_device_id']);
                    $mineLand['device']['light'] = self::$control->getYunDeviceInfo($this->uniacid, $mineLand['yun_device_id']['light_device_id']);
                }
            }
        }

        $return=[
            'mineLand'=>$mineLand,
            'landSeed'=>$landSeed,
            'spec'=>$mineLand['spec_id'],
        ];
        return $return;

    }

    /**
     * 获取土地信息和监控地址
     * @param $cond
     * @return mixed
     */
    public function getLandAndLive($cond){
        if(empty($cond['uniacid'])){
            $cond['uniacid']=$this->uniacid;
        }
        $query = load()->object('query');
        $row = $query->from('cqkundian_farm_land', 'a')->leftjoin('cqkundian_farm_live', 'b')->on('a.live_id', 'b.id')
            ->select('a.*','b.src','b.cover as live_cover,b.src as live_src')->where($cond)->get();
        return $row;
    }


    /***
     * 计算土地规格的价格
     * @param $selectLand  选择的土地规格信息
     * @param $lid         土地id
     * @return array
     */
    public function calculateLandPrice($selectLand,$lid){
        $landLimit=pdo_getall($this->land_limit,['uniacid'=>$this->uniacid,'lid'=>$lid],'','','rank asc');
        $landDetail=pdo_get($this->tableName,['uniacid'=>$this->uniacid,'id'=>$lid]);
        $total_price=0;
        foreach ($selectLand as $key => $value) {
            $total_price+=$value->price* floatval($landLimit[0]['day']);
        }
        for($j=0;$j<count($landLimit);$j++){
            $day[]=$landLimit[$j]['day'];

            if($landLimit[$j]['alias_name']){
                $alias_day[]=$landLimit[$j]['alias_name'];
            }else{
                $alias_day[]=$landLimit[$j]['day'].'天';
            }
        }
        return [
            'landLimit'=>$landLimit,
            'landDetail'=>$landDetail,
            'total_price'=>$total_price,
            'day'=>$day,
            'alias_day'=>$alias_day,
        ];
    }

    /** 购买土地支付成功后 插入土地信息 */
    public function insertBuyMineLand($orderData){
        $orderDetail=pdo_get('cqkundian_farm_land_order_detail',array('order_id'=>$orderData['id'],'uniacid'=>$orderData['uniacid']));
        $insertMine=array(
            'uid'=>$orderData['uid'],
            'lid'=>$orderDetail['lid'],
            'count'=>$orderDetail['land_count'],
            'exprie_time'=>$orderDetail['day']*24*60*60+time(),
            'day'=>$orderDetail['day'],
            'create_time'=>time(),
            'status'=>0,
            'send_day'=>0,
            'order_id'=>$orderData['id'],
            'uniacid'=>$orderData['uniacid'],
            'spec_id'=>$orderDetail['spec_id'],
            'can_seed_count'=>0,
        );
        $res1=pdo_insert($this->land_mine,$insertMine);
        $update_where=array(
            'area +='=>$orderDetail['land_count'],
            'residue_area -='=>$orderDetail['land_count'],
        );
        $res2=pdo_update($this->tableName,$update_where,array('id'=>$orderDetail['lid'],'uniacid'=>$orderData['uniacid']));
        $res3=pdo_update('cqkundian_farm_land_spec',array('status'=>1),array('uniacid'=>$orderData['uniacid'],'id'=>$orderDetail['spec_id']));
        if($res1 && $res2 && $res3){
            return true;
        }
        return false;
    }

    /**
     * 获取已种植的信息
     * @param $cond
     * @param string $pageIndex
     * @param string $pageSize
     * @return mixed
     */
    public function getUserLandList($cond,$pageIndex='',$pageSize=''){
        $cond['uniacid']=$this->uniacid;
        $query = load()->object('query');
        if(!empty($pageSize) && !empty($pageIndex)){
            $landData = $query->from($this->land_mine, 'a')->leftjoin($this->tableName, 'b')->on('a.lid', 'b.id')
                ->leftjoin($this->land_spec, 'c')->on('a.spec_id', 'c.id')
                ->leftjoin($this->live, 'd')->on('b.live_id', 'd.id')
                ->select('a.*','b.land_name','c.land_num','b.seed','d.src','c.device_id','c.live_id','b.yun_device_id')
                ->where($cond)->page($pageIndex, $pageSize)->orderby('a.create_time', 'DESC')->getall();
        }else{
            $landData = $query->from($this->land_mine, 'a')->leftjoin($this->tableName, 'b')->on('a.lid', 'b.id')
                ->leftjoin($this->land_spec, 'c')->on('a.spec_id', 'c.id')
                ->leftjoin($this->live, 'd')->on('b.live_id', 'd.id')
                ->select('a.*','b.land_name','c.land_num','b.seed','d.src','c.device_id','c.live_id','b.yun_device_id')
                ->where($cond)->orderby('a.create_time', 'DESC')->getall();
        }


        for($i=0;$i<count($landData);$i++){
            $landData[$i]['use_area']=0;  //已种植面积
            $landData[$i]['wait_area']=0;  //待播种面积
            $landData[$i]['exprie_time']=date("Y-m-d",$landData[$i]['exprie_time']);
            $landData[$i]['create_time']=date("Y-m-d",$landData[$i]['create_time']);
            if($landData[$i]['status']==1){
                //查询该土地已种植种植
                $landData[$i]['is_seed']=$this->getSeedMine(['lid'=>$landData[$i]['id'],'uniacid'=>$this->uniacid,'status in'=>[1,2,3,4,5,6,7]]);
                $landData[$i]['none_seed']=$this->getSeedMine(['lid'=>$landData[$i]['id'],'uniacid'=>$this->uniacid,'status'=>0]);

                $yibozhong=$this->getSeedMine(['lid'=>$landData[$i]['id'],'uniacid'=>$this->uniacid,'status in'=>[1,2,5]]);
                foreach ($yibozhong as $item) {
                    $landData[$i]['use_area']+=$item['count'];
                }
                foreach ($landData[$i]['none_seed'] as $noSeed){
                    $landData[$i]['wait_area']+=$noSeed['count'];
                }
//                $landData[$i]['wait_area']=count($landData[$i]['none_seed']);
            }else{
                $seed_id=explode(',',$landData[$i]['seed']);
                $landData[$i]['ke_seed']=pdo_getall($this->seed,['id in'=>$seed_id,'uniacid'=>$this->uniacid],'','','rank asc');
            }

            $landData[$i]['residue_area'] = $landData[$i]['count'] - $landData[$i]['use_area']-$landData[$i]['wait_area'];
            if($landData[$i]['device_id']){
                $device=pdo_get('cqkundian_farm_device',['id'=>$landData[$i]['device_id']]);
                $landData[$i]['did']=$device['did'];
            }
        }
        return $landData;
    }

    /**
     * 新增背包信息
     * @param $data
     * @return bool
     */
    public function addSeedBag($data){
        $seedData=pdo_get('cqkundian_farm_send_mine',['id'=>$data['seed_id'],'uniacid'=>$data['uniacid']]);
        $seed=pdo_get($this->seed,['id'=>$seedData['sid'],'uniacid'=>$data['uniacid']]);
        $insertBag=array(
            'uid'=>$seedData['uid'],
            'seed_name'=>$seedData['send_name'],
            'cover'=>$seed['cover'],
            'weight'=>$seedData['weight'],
            'sale_price'=>$seedData['sale_price'],
            'count'=>$seedData['count'],
            'uniacid'=>$data['uniacid'],
            'create_time'=>time(),
            'status'=>-1,  //状态为正在收获中....
            'seed_id'=>$data['seed_id'],
        );
        $res1=$this->insertSeedStatus('当前种植正在收获中~请等待管理员进行收获中，收获成功后讲放入您的背包中~',$seedData['lid'],$data['seed_id'],$data['uniacid']);
        $res2=pdo_insert($this->seedBagTable,$insertBag);
        if($res1 && $res2 ){
            return true;
        }
        return false;
    }

    /**
     * 卖出背包中的种植
     * @param $selectBag  要卖出的背包数据
     * @param $weight     要卖出的数量
     * @return array
     */
    public function saleSeed($selectBag,$weight){
        pdo_begin();
        if($weight==$selectBag->weight){  //全部卖出
            $update['status']=2;
            $res1=$this->updateSeedMine(['status'=>7],['id'=>$selectBag->seed_id,'uniacid'=>$this->uniacid]);
        }elseif($weight>0 && $weight < $selectBag->weight ){    //部分卖出
            $update['weight -=']=$weight;
            $res1=1;
        }else{
            return ['code'=>-1,'msg'=>'输入重量不合法'];
        }
        $res=pdo_update($this->seedBagTable,$update,['id'=>$selectBag->id,'uniacid'=>$this->uniacid]);

        //向用户钱包中加钱
        $totalMoney=round($weight*$selectBag->sale_price,2);
        $res2=self::$user->updateUser(['money +='=>$totalMoney],['uid'=>$selectBag->uid,'uniacid'=>$this->uniacid]);
        $body='卖出'.$selectBag->seed_name.' '.$weight.' kg获得';
        $res3=self::$user->insertRecordMoney($selectBag->uid,$totalMoney,1,$body,$this->uniacid);

        //插入状态信息跟踪
        $seedData=$this->getSeedMine(['id'=>$selectBag->seed_id,'uniacid'=>$this->uniacid],false);
        $res4=$this->insertSeedStatus('卖出'.$weight.' kg，获得'.$totalMoney.' 元，已发放至钱包~',$seedData['lid'],$selectBag->seed_id,$this->uniacid);

        if($res && $res1 && $res2 && $res3 && $res4){
            pdo_commit();
            return ['code'=>0,'msg'=>'卖出成功'];
        }
        pdo_rollback();
        return ['code'=>-1,'msg'=>'网络错误，请稍后重试'];
    }

    /** 添加种子信息*/
    public function addSeed($formData){
        $data=array(
            'send_name'=>$formData['send_name'],
            'rank'=>$formData['rank'],
            'cover'=>tomedia($formData['cover']),
            'price'=>$formData['price'],
            'output'=>$formData['output'],
            'effect'=>$formData['effect'],
            'send_time'=>$formData['send_time'],
            'cycle'=>$formData['cycle'],
            'is_putaway'=>$formData['is_putaway'],
            'low_count'=>$formData['low_count'],
            'uniacid'=>$this->uniacid,
        );
        if(empty($formData['is_putaway'])){
            $data['is_putaway']=0;
        }
        $x=0;
        while($formData["send_slide[$x"]) {
            $slide[]=tomedia($formData["send_slide[$x"]);
            $x++;
        }
        $data['send_slide']=serialize($slide);
        if(empty($formData['id'])){  //新增
            return pdo_insert($this->seed,$data);
        }
        return pdo_update($this->seed,$data,['id'=>$formData['id'],'uniacid'=>$this->uniacid]);
    }

    /** 根据条件获取我的种植列表信息*/
    public function getMineLand($cond,$page=1,$size=15,$isCount=false,$keyword=''){
        $query = load()->object('query');
//        if(empty($cond['uniacid'])) $cond['uniacid']=$this->uniacid;
        if($keyword){
            $cond['c.nickname LIKE']=$keyword;
            $landData = $query->from($this->land_mine, 'a')->leftjoin($this->tableName, 'b')->on('a.lid', 'b.id')
                ->leftjoin('cqkundian_farm_user', 'c')->on('a.uid', 'c.uid')
                ->leftjoin('cqkundian_farm_land_order', 'd')->on('a.order_id', 'd.id')
                ->select('a.*','b.land_name','b.cover','d.username','d.total_price','d.phone','c.avatarurl','c.nickname')
                ->where($cond)->whereor('b.land_name LIKE',$keyword)
                ->whereor('d.username LIKE',$keyword)->whereor('d.phone LIKE',$keyword)
                ->page($page, $size)->orderby('a.create_time', 'DESC')->getall();
        }else{
            $landData = $query->from($this->land_mine, 'a')->leftjoin($this->tableName, 'b')->on('a.lid', 'b.id')
                ->leftjoin('cqkundian_farm_user', 'c')->on('a.uid', 'c.uid')
                ->leftjoin('cqkundian_farm_land_order', 'd')->on('a.order_id', 'd.id')
                ->select('a.*','b.land_name','b.cover','d.username','d.total_price','d.phone','c.avatarurl','c.nickname')
                ->where($cond)->page($page, $size)->orderby('a.create_time', 'DESC')->getall();
        }

        for ($i=0;$i<count($landData);$i++){
            $landData[$i]=$this->judgeLandIsExpire($landData[$i],$this->uniacid);
            $landData[$i]['create_time']=date("Y-m-d",$landData[$i]['create_time']);
            $landData[$i]['exprie_time']=date("Y-m-d",$landData[$i]['exprie_time']);
        }
        if($isCount){
            $total = $query->getLastQueryTotal();
            return ['landData'=>$landData,'count'=>$total];
        }
        return $landData;
    }

    /**
     * 根据id查询土地信息
     * @param $id
     * @param $uniacid
     * @return bool
     */
    public function getLandById($id,$uniacid){
        $list=pdo_get($this->tableName,array('id'=>$id,'uniacid'=>$uniacid));
        return $list;
    }

    /**
     *  获取种植列表信息
     * @param $con
     * @param string $pageIndex
     * @param string $pageSize
     * @param string $order_by
     * @return array
     */
    public function getLandMineList($con,$pageIndex='',$pageSize='',$order_by='create_time desc'){
        if(!empty($pageIndex) && !empty($pageSize)){
            $list=pdo_getall('cqkundian_farm_land_mine', $con,'','',$order_by,array($pageIndex,$pageSize));
        }else{
            $list=pdo_getall('cqkundian_farm_land_mine', $con,'','',$order_by);
        }
        return $list;
    }

    /**
     * 获取土地规格信息
     * @param $con
     * @return array
     */
    public function getLandSpec($con,$mutilple=true){
        if($mutilple){
            $list=pdo_getall('cqkundian_farm_land_spec',$con);
        }else{
            $list=pdo_get('cqkundian_farm_land_spec',$con);
        }

        return $list;
    }

    /**
     * 获取租地年限信息
     * @param $con
     * @return array
     */
    public function getLandBuyLimit($con,$mutliple=true){
        if($mutliple){
            $list=pdo_getall('cqkundian_farm_land_buy_limit',$con,'','','rank asc');
        }else{
            $list=pdo_get('cqkundian_farm_land_buy_limit',$con,'','','rank asc');
        }

        return $list;
    }


    /**
     * 根据id获取土地订单信息
     * @param $id
     * @param $uniacid
     * @return bool
     */
    public function getLandOrderById($id,$uniacid){
        $list=pdo_get('cqkundian_farm_land_order',array('id'=>$id,'uniacid'=>$uniacid));
        return $list;
    }

    /**
     * 获取种子信息
     * @param $con
     * @param bool $mutilple
     * @return array|bool
     */
    public function getSeedMine($con,$mutilple=true){
        if($mutilple){
            $list=pdo_getall('cqkundian_farm_send_mine',$con);
        }else{
            $list=pdo_get('cqkundian_farm_send_mine',$con);
        }
        return $list;
    }

    /**
     * 更新种植信息
     * @param $updateData
     * @param $con
     * @return bool
     */
    public function updateSeedMine($updateData,$con){
        $res=pdo_update('cqkundian_farm_send_mine',$updateData,$con);
        return $res;
    }

    /**
     * 获取种植状态列表
     * @param $con
     * @param string $pageIndex
     * @param string $pageSize
     * @param string $order_by
     * @return array
     */
    public function getSeedStatus($con,$pageIndex='',$pageSize='',$order_by='create_time desc'){
        if(!empty($pageIndex) && !empty($pageSize)){
            $list=pdo_getall('cqkundian_farm_send_status',$con,'','',$order_by,array($pageIndex,$pageSize));
        }else{
            $list=pdo_getall('cqkundian_farm_send_status',$con,'','',$order_by);
        }

        $color=['#f9cb9c','#d9d2e9','#a4c2f4','#ead1dc','#b6d7a8'];
        for ($i=0;$i<count($list);$i++){
            $list[$i]['src']=unserialize($list[$i]['src']);
            $list[$i]['create_time']=date("m-d H:i",$list[$i]['create_time']);
            $color_index=rand(0,4);
            $list[$i]['back_color']=$color[$color_index];
        }
        return $list;
    }

    public function updateLandMine($updateData,$con){
        $res=pdo_update('cqkundian_farm_land_mine',$updateData,$con);
        return $res;
    }

    /**
     * @param  $type
     * @param  $land_id
     * @param  $uid
     * @param  $uniacid
     * @return
     */
    public function insertLandOpeartionRecord($type,$land_id,$uid,$uniacid){
        $data=array(
            'type'=>$type,
            'land_id'=>$land_id,
            'uniacid'=>$uniacid,
            'create_time'=>time(),
            'uid'=>$uid,
        );
        if($type==1){
            $data['remark']='浇水';
        }elseif($type==2){
            $data['remark']='施肥';
        }elseif($type==3){
            $data['remark']='除草';
        }elseif($type==4){
            $data['remark']='杀虫';
        }
        $res=pdo_insert('cqkundian_farm_land_operation_record',$data);
        return $res;
    }

    /**
     * 土地到期时间计算
     * @param $landMine
     * @return mixed
     */
    public function judgeLandIsExpire($landMine,$uniacid){
        if($landMine['exprie_time']<time()){
            //当土地到期时间小于当前系统时间时，表示该土地已经过期
            $landMine['is_expire_txt']='已过期';
            $landMine['is_expire_code']=2;
            $this->updateLandMine(array('status'=>2),array('uniacid'=>$uniacid,'id'=>$landMine['id']));
        }else{
            if($landMine['status']==2){
                $landMine['is_expire_txt']='已过期';
                $landMine['is_expire_code']=2;
            }else{
                //计算土地距离到期时间还有多少天，如果到时时间小于30天，就要求提示用户
                $distance_now=floor(($landMine['exprie_time']-time())/86400);
                if($distance_now>=30){
                    $landMine['is_expire_txt']='未到期';
                    $landMine['is_expire_code']=1;
                }else{
                    $hour=floor(($landMine['exprie_time']-time())%86400/3600);
                    $landMine['is_expire_txt']=$distance_now."天".$hour."小时后到期";
                    $landMine['is_expire_code']=3;
                }
            }
        }
        return $landMine;
    }

    /**
     * 获取土地种植中的已种植的种子和待种植种子
     * @param $landMine
     * @param $uniacid
     * @return mixed
     */
    public function getLandSeed($landMine,$uniacid){
        $land_mine = pdo_getall('cqkundian_farm_send_mine', array('lid' => $landMine['id'], 'uniacid' => $uniacid));
        for ($j = 0; $j < count($land_mine); $j++) {
            $landMine['seed_area'] += $land_mine[$j]['count'];
            if ($land_mine[$j]['status'] == 0) {
                $landMine['is_plant'] = 1;
                $landMine['seedData'][]=$land_mine[$j];
            }elseif ($land_mine[$j]['status']==3){
                $landMine['ripeSeedData'][]=$land_mine[$j];
            }else{
                $landMine['seed'][]=$land_mine[$j];
            }
        }
        return $landMine;
    }

    public function neatSeedStatus($status){
        $status_txt='';
        switch ($status){
            case 0:
                $status_txt='待播种';
                break;
            case 1:
                $status_txt='种植中';
                break;
            case 2:
                $status_txt='已成熟';
                break;
            case 3:
                $status_txt='已摘取';
                break;
            case 4:
                $status_txt='已配送';
                break;
            case 5:
                $status_txt='收获中';
                break;
            case 6:
                $status_txt='待配送';
                break;
            case 7:
                $status_txt='已卖出';
                break;
        }

        return $status_txt;
    }

    /**
     * 购买种子之后更新种植状态信息
     * @param $order_id
     * @param $uniacid
     */
    public function updateSend($orderData,$uniacid){
        $aboutData=pdo_get('cqkundian_farm_about',array('uniacid'=>$uniacid));
        $orderDetail=pdo_getall('cqkundian_farm_send_order_detail',array('order_id'=>$orderData['id'],'uniacid'=>$uniacid));
        $score=floor($orderData['total_price']/$aboutData['pay_integral']);
        if($score>0){
            pdo_update('cqkundian_farm_user',['score +='=>$score],['uid'=>$orderData['uid'],'uniacid'=>$uniacid]);
        }

        for($i=0;$i<count($orderDetail);$i++){
            $insertSend=array(
                'uid'=>$orderData['uid'],
                'order_id'=>$orderData['id'],
                'sid'=>$orderDetail[$i]['sid'],
                'status'=>0,
                'day'=>0,
                'send_name'=>$orderDetail[$i]['send_name'],
                'count'=>$orderDetail[$i]['count'],
                'uniacid'=>$uniacid,
                'lid'=>$orderData['mine_land_id'],
            );

            $res=pdo_insert('cqkundian_farm_send_mine',$insertSend);
            $seed_id=pdo_insertid();
            $this->insertSeedStatus('种子购买成功啦,请等待管理人员进行种植~',$orderData['mine_land_id'],$seed_id,$uniacid);
            pdo_update('cqkundian_farm_land_mine',['can_seed_count +='=>$orderDetail[$i]['count']],['id'=>$orderData['mine_land_id']]);  //减去可种植数量
        }
        //更新土地种植信息
        pdo_update('cqkundian_farm_land_mine',['status'=>1],['id'=>$orderData['mine_land_id'],'uniacid'=>$uniacid]);
    }

    /**
     * 新增状态信息跟踪
     * @param $txt
     * @param $lid
     * @param $seed_id
     * @param $uniacid
     */
    public function insertSeedStatus($txt,$lid,$seed_id,$uniacid,$src=''){
        $insertData=array(
            'txt'=>$txt,
            'seed_id'=>$seed_id,
            'uniacid'=>$uniacid,
            'lid'=>$lid,
            'create_time'=>time(),
            'src'=>$src,
        );
        return pdo_insert($this->statusName,$insertData);
    }


    /**
     * 小程序后台种植详情和小程序前端商家端管理种植详情公共方法
     * @param $id  种植id
     * @param $uniacid  小程序唯一id
     * @return array
     */
    public function getSeedDetail($id,$uniacid){
        $list=pdo_getall('cqkundian_farm_send_mine',['lid'=>$id,'uniacid'=>$uniacid]);
        $mineLand=pdo_get($this->land_mine,['id'=>$id,'uniacid'=>$uniacid]);
        $landSpec=$this->getLandSpec(['id'=>$mineLand['spec_id'],'uniacid'=>$uniacid],false);
        $landData=pdo_get($this->tableName,['id'=>$mineLand['lid'],'uniacid'=>$uniacid]);
        for ($i=0;$i<count($list);$i++){
            $list[$i]['status_txt']=$this->neatSeedStatus($list[$i]['status']);
            if($list[$i]['seed_time'] > 0){
                $list[$i]['seedDay']=ceil((time()-$list[$i]['seed_time'])/86400);
                $list[$i]['seed_time']=date("Y-m-d H:i",$list[$i]['seed_time']);
            }else{
                $list[$i]['seedDay']=0;
                $list[$i]['seed_time']='--';
            }
            if($list[$i]['expect_time'] > 0){
                $list[$i]['expect_time']=date("Y-m-d",$list[$i]['expect_time']);
            }else{
                $list[$i]['expect_time']=date("Y-m-d",time());
            }

        }

        return ['mineLand'=>$mineLand,'landSpec'=>$landSpec,'landData'=>$landData,'seedList'=>$list];
    }
}