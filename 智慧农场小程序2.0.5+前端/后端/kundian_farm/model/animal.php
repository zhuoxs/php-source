<?php
/**
 * Created by PhpStorm.
 * User: 坤典科技
 * Date: 2018/10/10
 * Time: 11:33
 */
defined("IN_IA")or exit("Access Denied");
require_once ROOT_PATH.'model/user.php';
require_once ROOT_PATH.'model/animal.php';
class Animal_KundianFarmModel{
    public $animal='cqkundian_farm_animal';
    public $live='cqkundian_farm_live';
    public $user_table='cqkundian_farm_user';
    public $animal_order='cqkundian_farm_animal_order';
    public $animal_adopt='cqkundian_farm_animal_adopt';
    public $statusTable='cqkundian_farm_animal_adopt_status';  //认养状态跟踪信息表
    protected $uniacid='';

    static $user='';
    static $common='';
    public function __construct($uniacid=''){
        $this->uniacid=$uniacid;
        self::$user=new User_KundianFarmModel();
        self::$common=new Common_KundianFarmModel();
    }

    /**
     * 新增认养信息
     * @param $data
     * @param $is_install_play
     * @return bool
     */
    public function addAnimal($data,$is_install_play){
        $animal_slide=[];
        $x=0;
        while($data["animal_slide[$x"]) {
            $animal_slide[]=tomedia($data["animal_slide[$x"]);
            $x++;
        }
        $insertData=array(
            'animal_name'=>trim($data['animal_name']),
            'animal_desc'=>trim($data['animal_desc']),
            'animal_src'=>tomedia($data['animal_src']),
            'price'=>$data['price'],
            'rank'=>$data['rank'],
            'uniacid'=>$this->uniacid,
            'is_putaway'=>$data['is_putaway'],
            'is_recommend'=>$data['is_recommend'],
            'is_open_sku'=>$data['is_open_sku'],
            'gain_desc'=>$data['gain_desc'],
            'price_desc'=>$data['price_desc'],
            'mature_period'=>$data['mature_period'],
            'count'=>$data['count'],
            'animal_rule'=>serialize(explode("\n",$data['animal_rule'])),
            'animal_slide'=>serialize($animal_slide),
            'live_id'=>$data['live_id'],
            'detail_desc'=>$data['detail_desc'],
        );
        if($is_install_play){
            $sports_src=[];
            $p=0;
            while($data["sports_src[$p"]) {
                $sports_src[]=tomedia($data["sports_src[$p"]);
                $p++;
            }
            $insertData['sports_src']=serialize($sports_src);
        }
        if(empty($data['id'])) {
            return  pdo_insert($this->animal, $insertData);
        }
        return pdo_update($this->animal,$insertData,['id'=>$data['id'],'uniacid'=>$this->uniacid]);
    }

    /***
     * 新增状态信息跟踪
     * @param $formData
     * @return bool
     */
    public function addStatus($formData){
        $update_data=array(
            'txt'=>$formData['txt'],
            'uniacid'=>$this->uniacid,
            'adopt_id'=>$formData['adopt_id'],
        );
        $x=0;
        $src=[];
        while($formData["src[$x"]) {
            $src[]=tomedia($formData["src[$x"]);
            $x++;
        }
        $update_data['src']=serialize($src);
        if(empty($formData['id'])){
            $update_data['create_time']=time();
            return pdo_insert($this->statusTable,$update_data);
        }
        return pdo_update($this->statusTable,$update_data,array('id'=>$formData['id'],'uniacid'=>$this->uniacid));
    }

    /** 创建认养订单 */
    public function createAdoptOrder($request){
        $animalData=pdo_get($this->animal,['id'=>$request['aid'],'uniacid'=>$request['uniacid']]);
        $insertData=array(
            'order_number'=>self::$common->getUniqueOrderNumber(),
            'aid'=>$request['aid'],
            'count'=>$request['count'],
            'create_time'=>time(),
            'uniacid'=>$request['uniacid'],
            'status'=>0,        //未支付
            'uid'=>$request['uid'],
            'body'=>'领养'.$animalData['animal_name'],
            'coupon_id'=>$request['coupon_id'],
            'coupon_price'=>$request['coupon_price'],
            'username'=>$request['username'],
            'phone'=>$request['phone'],
            'total_price'=>$request['totalPrice'],
        );

        if(!empty($_GPC['order_id'])){  //当原先已经生成了订单
            $order_id=$_GPC['order_id'];
            $orderData=pdo_get($this->animal_order,['id'=>$order_id,'uniacid'=>$request['uniacid']]);
            if($orderData['total_price'] !=$insertData['total_price']) {
                pdo_update($this->animal_order, $insertData, ['id' => $order_id, 'uniacid' => $request['uniacid']]);
            }
            return $order_id;
        }


        $farmSetData=self::$common->getSetData(['is_open_distribution','distribution_one_price','distribution_two_price'],['uniacid'=>$this->uniacid]);
        //是否开启分销
        if($farmSetData['is_open_distribution']==1){
            $user=pdo_get('cqkundian_farm_user',array('uniacid'=>$request['uniacid'],'uid'=>$request['uid']));
            //当前下单用户的一级分销商
            if($user['one_distributor']!=0) {
                $insertData['is_price']=1;
                $one_sale = pdo_get('cqkundian_farm_user', array('uniacid' => $request['uniacid'], 'uid' => $user['one_distributor']));
                $insertData['one_price']=round($insertData['total_price']*($farmSetData['distribution_one_price']/100),2);
                if($one_sale['one_distributor']!=0){
                    $insertData['two_price']=round($insertData['total_price']*($farmSetData['distribution_two_price']/100),2);
                }
            }
        }
        pdo_begin();
        $animal_order_res = pdo_insert($this->animal_order, $insertData);
        $order_id=pdo_insertid();
        $coupon_res=true;
        if($request['coupon_id'] && $request['coupon_price']){
            //修改优惠券使用
            $coupon_res=pdo_update('cqkundian_farm_user_coupon',array('status'=>1),['uniacid'=>$request['uniacid'],'uid'=>$request['uid'],'cid'=>$request['coupon_id']]);
        }
        if($order_id && $coupon_res){
            pdo_commit();
            return $order_id;
        }
        pdo_rollback();
        return false;

    }

    /**
     * 获取认养订单信息
     * @param array $cond
     * @param string $pageIndex
     * @param string $pageSize
     * @return mixed
     */
    public function getAnimalOrder($cond=[],$pageIndex='',$pageSize=''){
        $cond['a.uniacid']=$this->uniacid;
        $cond['b.uniacid']=$this->uniacid;
        $cond['c.uniacid']=$this->uniacid;
        $query=load()->object('query');
        if(!empty($pageIndex) && !empty($pageSize)){
            return $query->from($this->animal_order, 'a')
                ->leftjoin($this->animal, 'b')->on('a.aid', 'b.id')
                ->leftjoin($this->user_table, 'c')->on('a.uid', 'c.uid')
                ->select('a.*','b.animal_name','b.animal_src','c.nickname','c.avatarurl')
                ->orderby('id desc')
                ->where($cond)->page($pageIndex,$pageSize)->getall();
        }
        return $query->from($this->animal_order, 'a')
            ->leftjoin($this->animal, 'b')->on('a.aid', 'b.id')
            ->leftjoin($this->user_table, 'c')->on('a.uid', 'c.uid')
            ->select('a.*','b.animal_name','b.animal_src','c.nickname','c.avatarurl')
            ->orderby('id desc')
            ->where($cond)->getall();

    }

    /** 根据条件查询认养信息，并对部分字段进行处理 */
    public function getAnimalByCond($cond,$mutil,$page='',$size=''){
        if(empty($cond['uniacid'])) $cond['uniacid']=$this->uniacid;

        if($mutil){
            $list=pdo_get($this->animal,$cond);
            $list['animal_slide']=unserialize($list['animal_slide']);
            $list['sports_src']=unserialize($list['sports_src']);
            $rule=unserialize($list['animal_rule']);
            $list['animal_rule']=implode("\n",$rule);
        }else{
            $list=pdo_getall($this->animal,$cond,'','','rank asc',[$page,$size]);
            for ($i=0;$i<count($list);$i++){
                $list[$i]['animal_slide']=unserialize($list[$i]['animal_slide']);
                $list[$i]['sports_src']=unserialize($list[$i]['sports_src']);
                $rule=unserialize($list[$i]['animal_rule']);
                $list[$i]['animal_rule']=implode("\n",$rule);
            }
        }
        return $list;
    }
    /**
     * 获取认养状态列表信息
     * @param $con
     * @param $pageIndex
     * @param $pageSize
     * @param string $order_by
     * @return array
     */
    public function getAdoptStatus($con,$pageIndex,$pageSize,$order_by='create_time desc'){
        if(empty($con['uniacid'])) $con['uniacid']=$this->uniacid;

        if(!empty($pageIndex) && !empty($pageSize)){
            $list=pdo_getall($this->statusTable,$con,'','',$order_by,array($pageIndex,$pageSize));
        }else{
            $list=pdo_getall($this->statusTable,$con,'','',$order_by);
        }
        $color=['#f9cb9c','#d9d2e9','#a4c2f4','#ead1dc','#b6d7a8'];
        for ($i=0;$i<count($list);$i++){
            $color_index=rand(0,4);
            $list[$i]['back_color']=$color[$color_index];
            $list[$i]['create_time']=date("m-d H:i",$list[$i]['create_time']);
            $list[$i]['src']=unserialize($list[$i]['src']);
        }
        return $list;
    }

    /**
     * 新增状态跟踪信息
     * @param $data
     * @return bool
     */
    public function insertStatus($title,$adopt_id,$uniacid,$src=''){
        $insertStatus=array(
            'txt'=>$title,
            'adopt_id'=>$adopt_id,
            'create_time'=>time(),
            'uniacid'=>$uniacid,
            'src'=>$src,
        );
        return pdo_insert($this->statusTable,$insertStatus);
    }

    /**
     * 插入认养信息
     * @param $orderData
     * @param $uniacid
     */
    public function adoptAnimal($orderData,$uniacid){
        $animalData=pdo_get($this->animal,['id'=>$orderData['aid'],'uniacid'=>$this->uniacid]);
        for ($i = 0; $i < $orderData['count']; $i++) {
            $insertAdopt = array(
                'uid' => $orderData['uid'],
                'aid' => $orderData['aid'],
                'create_time' => time(),
                'status' => 1,
                'adopt_day' => 0,
                'predict_ripe' => ($animalData['mature_period'] * 24 * 60 * 60) + time(),     //预计成熟期
                'uniacid' => $uniacid,
                'order_id' => $orderData['id'],
            );
            $res=pdo_insert('cqkundian_farm_animal_adopt', $insertAdopt);
            $adopt_id=pdo_insertid();
            //新增认养状态信息跟踪
            $this->insertStatus('领养成功,认养正在分配中~',$adopt_id,$uniacid);
        }
    }

    /**
     * 联合查询已认养表和认养表
     * @param $condition
     * @return mixed
     */
    public function selectAdoptAndAnimal($condition,$field,$mutilple=true){
        $query = load()->object('query');
        if($mutilple) {
            $row = $query->from('cqkundian_farm_animal_adopt', 'a')->leftjoin('cqkundian_farm_animal', 'b')
                ->on('a.aid', 'b.id')->select($field)->where($condition)->getall();
        }else{
            $row = $query->from('cqkundian_farm_animal_adopt', 'a')->leftjoin('cqkundian_farm_animal', 'b')
                ->on('a.aid', 'b.id')->select($field)->where($condition)->get();
        }
        return $row;
    }

    /**
     * TODO 整理认养状态
     * @param $status
     * @return string
     */
    public function neatAdoptStatus($status){
        $status_txt='';
        switch ($status){
            case '1':
                $status_txt='准备中';
                break;
            case '2':
                $status_txt='认养中';
                break;
            case '3':
                $status_txt='已死亡';
                break;
            case '4':
                $status_txt='已成熟';
                break;
            case '5':
                $status_txt='已收获并配送';
                break;
            case '6':
                $status_txt='已放入背包';
                break;
            case '7':
                $status_txt='已下单，待处理';
                break;
            case '8':
                $status_txt='已卖出';
                break;
        }
        return $status_txt;
    }
}