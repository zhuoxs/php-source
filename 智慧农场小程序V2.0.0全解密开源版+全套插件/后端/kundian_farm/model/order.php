<?php
/**
 * Created by PhpStorm.
 * User: 坤典科技
 * Date: 2018/10/11
 * Time: 16:13
 */
defined('IN_IA') or exit('Access Denied');
require_once ROOT_PATH.'model/spec.php';
require_once ROOT_PATH.'model/common.php';
require_once ROOT_PATH.'model/notice.php';

class Order_KundianFarmModel{
    public $tableName='cqkundian_farm_shop_order';
    public $shop_order_detail='cqkundian_farm_shop_order_detail';
    public $land_order='cqkundian_farm_land_order';
    public $send_order='cqkundian_farm_send_order';
    public $integral_order='cqkundian_farm_integral_order';
    public $integral_order_detail='cqkundian_farm_integral_order_detail';
    public $group_order='cqkundian_farm_group_order';
    public $group_order_detail='cqkundian_farm_group_order_detail';
    public $user='cqkundian_farm_user';
    protected $uniacid='';
    static $common='';
    static $notice='';

    public function __construct($uniacid=''){
        global $_W;
        $this->uniacid=$uniacid ? $uniacid : $_W['uniacid'];
        self::$common=new Common_KundianFarmModel();
        self::$notice=new Notice_KundianFarmModel($this->uniacid);
    }


    /**
     *  新增土地租赁订单
     * @param $data
     * @return bool
     */
    public function updateLandOrder($data){
        $insertOrder=array(
            'order_number'=>self::$common->getUniqueOrderNumber(),
            'uid'=>$data['uid'],
            'total_price'=>$data['total_price'],
            'create_time'=>time(),
            'status'=>0,
            'uniacid'=>$this->uniacid,
            'body'=>$data['is_renew']==2 ? '土地续费' : '土地租赁',
            'username'=>$data['username'],
            'phone'=>$data['phone'],
            'coupon_id'=>$data['coupon_id'],
            'coupon_price'=>$data['coupon_price'],
            'order_type'=>$data['is_renew']==2 ? 1 : 0,
        );

        $farmSetData=self::$common->getSetData(['is_open_distribution','distribution_one_price','distribution_two_price'],$this->uniacid);
        //是否开启分销
        if($farmSetData['is_open_distribution']==1){
            $user=pdo_get('cqkundian_farm_user',['uniacid'=>$this->uniacid,'uid'=>$data['uid']]);
            //当前下单用户的一级分销商
            if($user['one_distributor']!=0) {
                $insertOrder['is_price']=1;
                $one_sale = pdo_get($this->user, ['uniacid' => $this->uniacid, 'uid' => $user['one_distributor']]);
                $insertOrder['one_price']=round($insertOrder['total_price']*($farmSetData['distribution_one_price']/100),2);
                if($one_sale['one_distributor']!=0){
                    $insertOrder['two_price']=round($insertOrder['total_price']*($farmSetData['distribution_two_price']/100),2);
                }
            }
        }

        //当原先已经生成了订单
        if( !empty($data['order_id']) || $data['order_id'] != 0 ){
            $orderData=pdo_get($this->land_order,['id'=>$data['order_id']]);
            if($orderData['total_price'] !=$insertOrder['total_price']) {
                pdo_update($this->land_order, $insertOrder, ['id' => $data['order_id'], 'uniacid' => $this->uniacid]);
            }
            return $data['order_id'];
        }
        pdo_begin();
        $order_res = pdo_insert($this->land_order, $insertOrder);
        $order_id = pdo_insertid();
        $limitData=pdo_get('cqkundian_farm_land_buy_limit',array('id'=>$data['limit_id'],'uniacid'=>$this->uniacid));
        $landData=pdo_get('cqkundian_farm_land',array('id'=>$data['lid'],'uniacid'=>$this->uniacid));

        $selectLand=json_decode(htmlspecialchars_decode($data['selectLand']));
        //插入订单详情页
        $orderDetail = array(
            'order_id' => $order_id,
            'land_price' => $selectLand[0]->price,
            'land_count' => $selectLand[0]->area,
            'day' => $limitData['day'],
            'lid' => $data['lid'],
            'land_name' => $landData['land_name'],
            'cover' => $landData['cover'],
            'uniacid' => $this->uniacid,
            'spec_id' => $selectLand[0]->id,
            'mine_id'=>$data['land_id'],
        );
        $detail_res = pdo_insert('cqkundian_farm_land_order_detail', $orderDetail);

        //修改优惠券使用情况
        $coupon_res=true;
        if($data['coupon_id'] && $data['coupon_price']){
            $coupon_res=pdo_update('cqkundian_farm_user_coupon',array('status'=>1),array('uniacid'=>$this->uniacid,'uid'=>$data['uid'],'cid'=>$data['coupon_id']));
        }

        if($order_res && $detail_res && $coupon_res){
            pdo_commit();
            return $order_id;
        }
        pdo_rollback();
        return false;
    }


    public function updateSeedOrder($data){
        global $_W;

        $total_price=$data['total_price'];
        $lid=$data['lid'];
        $coupon_id=$data['coupon_id'];
        $coupon_price=$data['coupon_price'];
        if($data['formid']){
            self::$common->insertFormIdData($data['formid'],$data['uid'],$_W['openid'],1,$data['uniacid']);
        }
        $inserSendOrder=array(
            'order_number'=>self::$common->getUniqueOrderNumber(),
            'uid'=>$data['uid'],
            'uniacid'=>$this->uniacid,
            'total_price'=>$total_price,
            'create_time'=>time(),
            'status'=>0,
            'body'=>'购买种子',
            'coupon_id'=>$coupon_id,
            'coupon_price'=>$coupon_price,
            'mine_land_id'=>$lid,
        );
        if(!empty($data['order_id'])){
            $order_id=$data['order_id'];
            $orderData=pdo_get($this->send_order,['id'=>$order_id,'uniacid'=>$this->uniacid]);
            if($orderData['total_price']!=$inserSendOrder['total_price']){
                pdo_update($this->send_order,$inserSendOrder,['id'=>$order_id,'uniacid'=>$this->uniacid]);
            }
            return $data['order_id'];
        }
        pdo_begin();
        $order_send_res = pdo_insert($this->send_order, $inserSendOrder);
        $order_id = pdo_insertid();
        $res_detail = 0;
        $seedList=json_decode(htmlspecialchars_decode($data['seedList']));
        foreach ($seedList as $key=>$value){
            $insertSendDetail = array(
                'sid' => $value->id,
                'count' => $value->selectCount ? $value->selectCount : $value->num,
                'order_id' => $order_id,
                'send_name' => $value->send_name,
                'cover' => $value->cover,
                'price' => $value->price,
                'uniacid' => $this->uniacid,
            );
            $res_detail += pdo_insert('cqkundian_farm_send_order_detail', $insertSendDetail);
        }
        //修改优惠券使用
        $coupon_res=true;
        if($coupon_id && $coupon_price){
            $coupon_res=pdo_update('cqkundian_farm_user_coupon',array('status'=>1),array('uniacid'=>$this->uniacid,'uid'=>$data['uid'],'cid'=>$coupon_id));
        }
        if($order_send_res && $res_detail && $coupon_res){
            pdo_commit();
            return $order_id;
        }
        pdo_rollback();
        return false;
    }

    /**
     * 获取普通商城订单信息
     * @param array $cond
     * @param string $pageIndex
     * @param string $pageSize
     * @return mixed
     */
    public function getShopOrder($cond=[],$pageIndex='',$pageSize=''){
        $query = load()->object('query');
        if(empty($cond['uniacid'])){
            $cond['a.uniacid']=$this->uniacid;
            $cond['b.uniacid']=$this->uniacid;
        }

        $setData = pdo_get('cqkundian_farm_set', ['ikey' => 'expire_order_time', 'uniacid' => $this->uniacid]);
        $times=$setData['value'];
        $list = $query->from($this->tableName, 'a')->leftjoin($this->user, 'b')->on('a.uid', 'b.uid')
            ->select('a.*', 'b.nickname')
            ->where($cond)->orderby('create_time desc')->page($pageIndex, $pageSize)->getall();
        for ($i=0;$i<count($list);$i++){
            //判断该订单是否过期
            if(empty($setData) || $setData['value']==0 || $setData['value']==''){
                $times=1800;
            }
            if ($list[$i]['status'] == 0 && ($list[$i]['create_time'] + $times ) <= time() && $list[$i]['apply_delete']==0) {
                $this->updateOrder(['apply_delete' =>2],['uniacid' => $this->uniacid, 'id' => $list[$i]['id']]);

                $body=[
                    'body'=>$list[$i]['body'],
                    'order_number'=>$list[$i]['order_number'],
                    'total_price'=>$list[$i]['total_price'],
                    'reason'=>'由于订单逾期未支付，已为您自动取消，欢迎下次购买',
                ];
                self::$notice->cancelOrderMsg($body,$list[$i]['uid'],'/kundian_farm/pages/shop/orderList/index');
            }

            $orderDetail=pdo_getall($this->shop_order_detail,['order_id'=>$list[$i]['id'],'uniacid'=>$this->uniacid]);
            for ($j=0;$j<count($orderDetail);$j++){
                if($orderDetail[$j]['spec_id']!=0){
                    $orderDetail[$j]['skuName']=$this->getSkuBySpecId($orderDetail[$j]['spec_id']);
                }
            }
            $list[$i]=$this->neatenOrderStatus($list[$i]);
            $list[$i]['orderDetail']=$orderDetail;
            $list[$i]['create_time']=date("Y-m-d H:i:s",$list[$i]['create_time']);
        }
        return $list;
    }


    /**
     * 普通商品规格信息查询
     * @param $spec_id  规格id
     * @param bool $returnArr   返回字符串还是数组
     * @return array|string
     */
    public function getSkuBySpecId($spec_id,$returnArr=false){
        $goodsSpec=pdo_get('cqkundian_farm_goods_spec',['id'=>$spec_id,'uniacid'=>$this->uniacid]);
        $sku_spec=explode(',',$goodsSpec['sku_name']);
        $specValue=pdo_getall('cqkundian_farm_spec_value',['id in'=>$sku_spec,'uniacid'=>$this->uniacid]);
        $specItem = pdo_getall('cqkundian_farm_spec', array('goods_id' => $goodsSpec['goods_id'], 'uniacid' => $this->uniacid));
        $skuName='';
        for ($j = 0; $j < count($specItem); $j++) {
            for ($m = 0; $m < count($specValue); $m++) {
                if ($specItem[$j]['id'] == $specValue[$m]['spec_id']) {
                    $specItem[$j]['spec_value'] = $specValue[$m]['spec_value'];
                }
            }
            $skuName .= $specItem[$j]['name'] . ':' . $specItem[$j]['spec_value'].'  ';
        }
        return $returnArr ? $specItem : $skuName;
    }
    /**
     * 获取种植摘取订单信息
     * @param array $cond
     * @param string $pageIndex
     * @param string $pageSize
     * @return mixed
     */
    public function getSeedOrderList($cond=[],$pageIndex='', $pageSize=''){
        $query = load()->object('query');
        if(empty($cond['uniacid'])){
            $cond['a.uniacid']=$this->uniacid;
            $cond['b.uniacid']=$this->uniacid;
        }
        if(empty($cond['order_type'])){
            $cond['order_type']=4;
        }
        $setData = pdo_get('cqkundian_farm_set', ['ikey' => 'expire_order_time', 'uniacid' => $this->uniacid]);
        $times=$setData['value'];
        $list = $query->from($this->tableName, 'a')->leftjoin($this->user, 'b')->on('a.uid', 'b.uid')
            ->select('a.*', 'b.nickname')
            ->where($cond)->orderby('create_time desc')->page($pageIndex, $pageSize)->getall();

        for ($i=0;$i<count($list);$i++){
            //判断该订单是否过期
            if(empty($setData) || $setData['value']==0 || $setData['value']==''){
                $times=1800;
            }
            if ($list[$i]['status'] == 0 && ($list[$i]['create_time'] + $times) <= time() && $list[$i]['send_method']==0) {
                $this->updateOrder(array('apply_delete' =>2),['uniacid' => $this->uniacid, 'id' => $list[$i]['id']]);
            }
            $order_detail=pdo_getall($this->shop_order_detail,['order_id'=>$list[$i]['id'],'uniacid'=>$this->uniacid]);
            for ($j=0;$j<count($order_detail);$j++){
                $mine_land = pdo_get('cqkundian_farm_land_mine', array('id' => $order_detail[$j]['spec_id'], 'uniacid' => $this->uniacid), array('spec_id'));
                $land_spec = pdo_get('cqkundian_farm_land_spec', array('uniacid' => $this->uniacid, 'id' => $mine_land['spec_id']), array('land_num'));
                $order_detail[$j]['land_num'] = $land_spec['land_num'];
                $seedData=pdo_get('cqkundian_farm_send_mine',['id'=>$order_detail[$j]['goods_id'],'uniacid'=>$this->uniacid]);
                $seedBag=pdo_get('cqkundian_farm_seed_bag',['seed_id'=>$seedData['id'],'uniacid'=>$this->uniacid]);
                $order_detail[$j]['seedBag']=$seedBag;
            }
            $list[$i]=$this->neatenOrderStatus($list[$i]);
            $list[$i]['orderDetail']=$order_detail;
            $list[$i]['create_time']=date("Y-m-d H:i:s",$list[$i]['create_time']);
        }
        return $list;
    }

    /**
     *  获取宰杀订单信息
     * @param array $cond
     * @param string $pageIndex
     * @param string $pageSize
     * @return mixed
     */
    public function getAnimalOrderList($cond=[],$pageIndex='',$pageSize=''){
        $query = load()->object('query');
        if(empty($cond['uniacid'])){
            $cond['a.uniacid']=$this->uniacid;
            $cond['b.uniacid']=$this->uniacid;
        }
        if(empty($cond['order_type'])){
            $cond['order_type']=3;
        }
        $setData = pdo_get('cqkundian_farm_set', ['ikey' => 'expire_order_time', 'uniacid' => $this->uniacid]);
        $times=$setData['value'];
        $list = $query->from($this->tableName, 'a')->leftjoin($this->user, 'b')->on('a.uid', 'b.uid')
            ->select('a.*', 'b.nickname')
            ->where($cond)->orderby('create_time desc')->page($pageIndex, $pageSize)->getall();
        for ($i=0;$i<count($list);$i++){
            //判断该订单是否过期
            if(empty($setData) || $setData['value']==0 || $setData['value']==''){
                $times=1800;
            }
            if ($list[$i]['status'] == 0 && ($list[$i]['create_time'] + $times) <= time() && $list[$i]['send_method']==0) {
                $this->updateOrder(array('apply_delete' =>2),['uniacid' => $this->uniacid, 'id' => $list[$i]['id']]);
            }
            $orderDetail=pdo_getall($this->shop_order_detail,['order_id'=>$list[$i]['id'],'uniacid'=>$this->uniacid]);
            for ($j=0;$j<count($orderDetail);$j++){
                $orderDetail[$j]['add_info']=unserialize($orderDetail[$j]['add_info']);
            }
            $list[$i]=$this->neatenOrderStatus($list[$i]);
            $list[$i]['orderDetail']=$orderDetail;
            $list[$i]['create_time']=date("Y-m-d H:i:s",$list[$i]['create_time']);
        }
        return $list;
    }

    /***
     * 获取组团订单信息
     * @param $cond
     * @param string $pageIndex
     * @param string $pageSize
     * @param string $order_by
     * @return mixed
     */
    public function getGroupOrderList($cond,$pageIndex='',$pageSize='',$order_by='create_time desc'){
        $query = load()->object('query');
        if(empty($cond['uniacid'])){
            $cond['a.uniacid']=$this->uniacid;
            $cond['b.uniacid']=$this->uniacid;
        }
        $setData = pdo_get('cqkundian_farm_set', array('ikey' => 'expire_order_time', 'uniacid' => $this->uniacid));
        $times=$setData['value'];
        $list = $query->from($this->group_order, 'a')->leftjoin($this->user,'b')->on('a.uid', 'b.uid')
            ->select('a.*','b.nickname')
            ->where($cond)->orderby($order_by)->page($pageIndex,$pageSize)->getall();

        for ($i=0;$i<count($list);$i++){
            if(empty($setData) || $setData['value']==0 || $setData['value']==''){
                $times=1800;
            }
            if ($list[$i]['status'] == 0 && ($list[$i]['create_time'] + $times) <= time() && $list[$i]['apply_delete']==0) {
                pdo_update($this->group_order,['apply_delete'=>2],['uniacid'=>$this->uniacid,'id'=>$list[$i]['id']]);
            }

            $orderDetail=pdo_getall($this->group_order_detail,['order_id'=>$list[$i]['id'],'uniacid'=>$this->uniacid]);
            for ($j=0;$j<count($orderDetail);$j++){
                if($orderDetail[$j]['spec_id'] != 0 ){
                    $orderDetail[$j]['skuName']=$this->getGroupSkuBySpecId($orderDetail[$j]['spec_id']);
                }
            }
            $list[$i]['create_time']=date("Y-m-d H:i:s",$list[$i]['create_time']);
            $list[$i]=$this->neatenOrderStatus($list[$i]);
            $list[$i]['orderDetail']=$orderDetail;
        }
        return $list;
    }

    /**
     *  获取组团订单sku组合信息
     * @param $spec_id
     * @param bool $returnArr
     * @return array|string
     */
    public function getGroupSkuBySpecId($spec_id,$returnArr=false){
        $goodsSpec=pdo_get('cqkundian_farm_group_goods_spec',['id'=>$spec_id,'uniacid'=>$this->uniacid]);
        $sku_spec=explode(',',$goodsSpec['sku_name']);
        $specValue=pdo_getall('cqkundian_farm_group_spec_value',['id in'=>$sku_spec,'uniacid'=>$this->uniacid]);
        $specItem = pdo_getall('cqkundian_farm_group_spec', array('goods_id' => $goodsSpec['goods_id'], 'uniacid' => $this->uniacid));
        $skuName='';
        for ($j = 0; $j < count($specItem); $j++) {
            for ($m = 0; $m < count($specValue); $m++) {
                if ($specItem[$j]['id'] == $specValue[$m]['spec_id']) {
                    $specItem[$j]['spec_value'] = $specValue[$m]['spec_value'];
                }
            }
            $skuName .= $specItem[$j]['name'] . ':' . $specItem[$j]['spec_value'].'  ';
        }
        return $returnArr ? $specItem : $skuName;
    }


    /***
     * 获取积分订单信息
     * @param $cond
     * @param string $pageIndex
     * @param string $pageSize
     * @param string $order_by
     * @return mixed
     */
    public function getIntegralOrderList($cond,$pageIndex='',$pageSize='',$order_by='create_time desc'){
        $query = load()->object('query');
        if(empty($cond['uniacid'])) {
            $cond['a.uniacid']=$this->uniacid;
            $cond['b.uniacid']=$this->uniacid;
        }
        $setData = pdo_get('cqkundian_farm_set', array('ikey' => 'expire_order_time', 'uniacid' => $this->uniacid));
        $times=$setData['value'];
        $list = $query->from($this->integral_order, 'a')->leftjoin($this->user,'b')->on('a.uid', 'b.uid')
            ->select('a.*','b.nickname')
            ->where($cond)->orderby($order_by)->page($pageIndex,$pageSize)->getall();

        for ($i=0;$i<count($list);$i++){
            if(empty($setData) || $setData['value']==0 || $setData['value']==''){
                $times=1800;
            }
            if ($list[$i]['status'] == 0 && ($list[$i]['create_time'] + $times) <= time() ) {
                pdo_update($this->integral_order,['apply_delete'=>2],['uniacid'=>$this->uniacid,'id'=>$list[$i]['id']]);
            }
            $orderDetail=pdo_getall($this->integral_order_detail,['order_id'=>$list[$i]['id'],'uniacid'=>$this->uniacid]);
            $list[$i]['create_time']=date("Y-m-d H:i:s",$list[$i]['create_time']);
            $list[$i]=$this->neatenOrderStatus($list[$i]);
            for ($j=0;$j<count($orderDetail);$j++){
                if($orderDetail[$j]['spec_id'] != 0 ){
                    $orderDetail[$j]['skuName']=$this->getIntegralSkuBySpecId($orderDetail[$j]['spec_id']);
                }
            }
            $list[$i]['orderDetail']=$orderDetail;

            if($list[$i]['remark']=='undefined'){
                $list[$i]['remark']='';
            }
        }
        return $list;
    }

    /***
     * 获取积分商城商品sku信息
     * @param $spec_id
     * @param $returnArr
     * @return array|string
     */
    public function getIntegralSkuBySpecId($spec_id,$returnArr=false){
        $goodsSpec=pdo_get('cqkundian_farm_integral_goods_spec',['id'=>$spec_id,'uniacid'=>$this->uniacid]);
        $sku_spec=explode(',',$goodsSpec['sku_name']);
        $specValue=pdo_getall('cqkundian_farm_integral_spec_value',['id in'=>$sku_spec,'uniacid'=>$this->uniacid]);
        $specItem = pdo_getall('cqkundian_farm_integral_spec', array('goods_id' => $goodsSpec['goods_id'], 'uniacid' => $this->uniacid));
        $skuName='';
        for ($j = 0; $j < count($specItem); $j++) {
            for ($m = 0; $m < count($specValue); $m++) {
                if ($specItem[$j]['id'] == $specValue[$m]['spec_id']) {
                    $specItem[$j]['spec_value'] = $specValue[$m]['spec_value'];
                }
            }
            $skuName .= $specItem[$j]['name'] . ':' . $specItem[$j]['spec_value'].'  ';
        }
        return $returnArr ? $specItem : $skuName;
    }

    public function getOrderById($id,$uniacid){
        $list=pdo_get($this->tableName,array('id'=>$id,'uniacid'=>$uniacid));
        return $list;
    }

    public function getGroupOrderById($id,$uniacid){
        $list=pdo_get('cqkundian_farm_group_order',array('id'=>$id,'uniacid'=>$uniacid));
        return $list;
    }

    /**
     * 更新订单信息
     * @param $updateOrder
     * @param $con
     * @return bool
     */
    public function updateOrder($updateOrder,$con){
        $res=pdo_update($this->tableName, $updateOrder, $con);
        return $res;
    }
    public function updateGroupOrder($updateOrder,$con){
        $res=pdo_update('cqkundian_farm_group_order', $updateOrder, $con);
        return $res;
    }
    public function updateIntegralOrder($updateOrder,$con){
        $res=pdo_update('cqkundian_farm_integral_order', $updateOrder, $con);
        return $res;
    }


    /**
     * 获取订单详细信息
     * @param $order_id
     * @param $uniacid
     * @return array
     */
    public function getOrderDetail($order_id,$uniacid){
        $list=pdo_getall('cqkundian_farm_shop_order_detail',array('order_id'=>$order_id,'uniacid'=>$uniacid));
        return $list;
    }
    public function getGroupOrderDetail($order_id,$uniacid){
        $list=pdo_getall('cqkundian_farm_group_order_detail',array('order_id'=>$order_id,'uniacid'=>$uniacid));
        return $list;
    }
    public function getIntegralOrderDetail($order_id,$uniacid,$mutliple=true){
        if($mutliple){
            $list=pdo_getall('cqkundian_farm_integral_order_detail',array('order_id'=>$order_id,'uniacid'=>$uniacid));
        }else{
            $list=pdo_get('cqkundian_farm_integral_order_detail',array('order_id'=>$order_id,'uniacid'=>$uniacid));
        }

        return $list;
    }

    public function neatOrderDetail($order_detail,$uniacid,$model){
        switch ($model){
            case 'shop':
                $specModel=new Spec_KundianFarmModel('goods');
                for($i=0;$i<count($order_detail);$i++){
                    $specVal=pdo_get('cqkundian_farm_goods_spec',array('id'=>$order_detail[$i]['spec_id'],'goods_id'=>$order_detail[$i]['goods_id'],'uniacid'=>$uniacid));
                    $spec_id=explode(",", $specVal['sku_name']);
                    $spec_val=pdo_getall('cqkundian_farm_spec_value',array('id in'=>$spec_id));
                    $specItem=pdo_getall('cqkundian_farm_spec',array('goods_id'=>$order_detail[$i]['goods_id'],'uniacid'=>$uniacid));
                    $specItem=$specModel->neatenSpecData($specItem,$spec_val);
                    $order_detail[$i]['specItem']=$specItem;
                    $order_detail[$i]['total_price']=$order_detail[$i]['price']*$order_detail['count'];
                }
                break;

            case 'group':
                $specModel=new Spec_KundianFarmModel('group');
                for($i=0;$i<count($order_detail);$i++){
                    $specVal=pdo_get('cqkundian_farm_group_goods_spec',array('goods_id'=>$order_detail[$i]['goods_id'],'id'=>$order_detail[$i]['spec_id'],'uniacid'=>$uniacid));
                    $spec_id=explode(",", $specVal['sku_name']);
                    $spec_val=pdo_getall('cqkundian_farm_group_spec_value',array('id in'=>$spec_id));
                    $specItem=pdo_getall('cqkundian_farm_group_spec',array('goods_id'=>$order_detail[$i]['goods_id'],'uniacid'=>$uniacid));
                    $specItem=$specModel->neatenSpecData($specItem,$spec_val);
                    $order_detail[$i]['specItem']=$specItem;
                }
                break;

            case 'integral':
                $specModel=new Spec_KundianFarmModel('integral');
                for($i=0;$i<count($order_detail);$i++){
                    $specVal=pdo_get('cqkundian_farm_integral_goods_spec',array('goods_id'=>$order_detail[$i]['goods_id'],'id'=>$order_detail[$i]['spec_id'],'uniacid'=>$uniacid));
                    $spec_id=explode(",", $specVal['sku_name']);
                    $spec_val=pdo_getall('cqkundian_farm_integral_spec_value',array('id in'=>$spec_id));
                    $specItem=pdo_getall('cqkundian_farm_integral_spec',array('goods_id'=>$order_detail[$i]['goods_id'],'uniacid'=>$uniacid));
                    $specItem=$specModel->neatenSpecData($specItem,$spec_val);
                    $order_detail[$i]['specItem']=$specItem;
                }
                break;
        }

        return $order_detail;
    }

    public function neatenOrderStatus($orderData){
        if($orderData['apply_delete']==0) {
            if ($orderData['status'] == 0) {
                $orderData['status_txt'] = '等待买家付款';
                $orderData['status_code']=0;

                if($orderData['order_type']==3 || $orderData['order_type']==4){
                    if($orderData['send_method']==1 && $orderData['is_confirm']==0){
                        $orderData['status_txt'] = '待自提';
                    }
                    if($orderData['send_method']==1 && $orderData['is_confirm']==1){
                        $orderData['status_txt'] = '交易成功';
                    }
                }

            } elseif ($orderData['status'] == 1 && $orderData['is_send'] == 0 && $orderData['is_confirm']==0) {
                $orderData['status_txt'] = '等待商家发货';
                $orderData['status_code']=1;
                if($orderData['send_method']==1){
                    $orderData['status_txt'] = '待自提';
                }
            } elseif ($orderData['status'] == 1 && $orderData['is_send'] == 1 && $orderData['is_confirm'] == 0) {
                $orderData['status_txt'] = '商家已发货';
                $orderData['status_code']=2;
            } elseif ($orderData['status'] == 1 && $orderData['is_confirm'] == 1) {
                $orderData['status_txt'] = '交易成功';
                $orderData['status_code']=3;
            }elseif ($orderData['status']==6) {
                $orderData['status_txt']='组团中';
                $orderData['status_code']=6;
            }
        }elseif($orderData['apply_delete']==1){
            $orderData['status_txt'] = '申请退款中';
            $orderData['status_code']=4;
        }elseif ($orderData['apply_delete']==2){
            if($orderData['status']==1){
                $orderData['status_txt'] = '成功取消已退款';
            }else{
                $orderData['status_txt'] = '订单已取消';
            }
            $orderData['status_code']=5;
        }
        return $orderData;
    }

    public function getOrderStatusCond($status){
        if($status==0){
            return ['status'=>0,'apply_delete'=>0];
        }
        if($status==1){
            return ['status'=>1,'is_send'=>0,'is_confirm'=>0,'apply_delete'=>0];
        }
        if($status==2){
            return['status'=>1,'is_send'=>1,'is_confirm'=>0,'apply_delete'=>0];
        }
        if($status==3){
            return ['status'=>1,'is_send'=>1,'is_confirm'=>1,'apply_delete'=>0];
        }
        if($status==4){
            return ['apply_delete'=>1];
        }
        if($status==5){
            return ['apply_delete'=>2];
        }
        if($status==6){
            return ['status'=>6,'apply_delete'=>0];
        }
    }
}