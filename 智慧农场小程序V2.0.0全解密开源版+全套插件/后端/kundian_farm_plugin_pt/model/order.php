<?php
/**
 * Created by PhpStorm.
 * User: 坤典科技
 * Date: 2019/1/31 0031
 * Time: 下午 4:20
 */
defined("IN_IA") or exit('Access Denied');
require_once ROOT_PATH.'model/common.php';
require_once ROOT_PATH.'model/notice.php';
class Pt_OrderModel{
    public $uniacid='';
    public $order='cqkundian_farm_pt_order';
    public $order_detail='cqkundian_farm_pt_order_detail';
    static $common='';
    static $notice='';
    public function __construct($uniacid=''){
        global $_W;
        $this->uniacid=$_W['uniacid'];
        if(!empty($uniacid)){
            $this->uniacid;
        }
        self::$common=new Common_KundianFarmModel();
        self::$notice=new Notice_KundianFarmModel($this->uniacid);
    }

    /** 新增订单 */
    public function addOrder($request,$selectSpec,$address){
        global $_W;
        $relation_id=$request['relation_id'];
        $goods=pdo_get('cqkundian_farm_pt_goods',['id'=>$request['goods_id'],'uniacid'=>$this->uniacid]);
        if(!empty($request['form_id'])){
            self::$common->insertFormIdData($request['form_id'],$request['uid'],$_W['openid'],1,$this->uniacid);
        }
        if($request['buy_types']==2) {
            $relationList=pdo_get('cqkundian_farm_pt_relation',['id'=>$relation_id,'uniacid'=>$this->uniacid]);
            if (empty($relation_id) || $relationList['status']==2 || $relationList['end_time'] < time() ) {
                $relationData = [
                    'uid' => $request['uid'],
                    'goods_id' => $request['goods_id'],
                    'create_time' => time(),
                    'uniacid' => $this->uniacid,
                    'ptnumber' => $goods['pt_count'],
                    'end_time' => time() + $goods['pt_time'] * 3600,
                    'status' => 0,
                ];
                pdo_insert('cqkundian_farm_pt_relation', $relationData);
                $relation_id = pdo_insertid();
            }
        }
        $updateData=[
            'order_number'=>self::$common->getUniqueOrderNumber(),
            'uid'=>$request['uid'],
            'total_price'=>$request['total_price'],
            'express_price'=>$request['send_price'],
            'name'=>$address->name,
            'phone'=>$address->phone,
            'address'=>$address->address,
            'is_pay'=>0,
            'is_group'=>$request['buy_types'],
            'relation_id'=>$relation_id,
            'is_header'=> $request['relation_id'] ? 0 : 1,
            'uniacid'=>$this->uniacid,
            'create_time'=>time(),
            'body'=>'拼团购买'.$goods['goods_name'],
        ];
        pdo_insert($this->order,$updateData);
        $order_id=pdo_insertid();
        if($request['buy_types']==1){
            $price=$selectSpec->price ? $selectSpec->price : $goods['price'];
        }else{
            $price=$selectSpec->pt_price ? $selectSpec->pt_price : $goods['pt_price'];
        }
        $orderDetail=[
            'order_id'=>$order_id,
            'goods_id'=>$request['goods_id'],
            'num'=>$request['selectNum'],
            'price'=>$price,
            'sku'=>serialize(self::$common->objectToArray($selectSpec)),
            'cover'=>$selectSpec->spec_src ? $selectSpec->spec_src : $goods['cover'],
            'sku_name'=>$request['sku_name'],
            'uniacid'=>$this->uniacid,
            'goods_name'=>$goods['goods_name'],
        ];

        pdo_insert($this->order_detail,$orderDetail);
        if($order_id){
            return ['code'=>0,'order_id'=>$order_id,'msg'=>'订单生成成功'];
        }
        return ['code'=>-1,'msg'=>'订单生成失败'];
    }

    /** 支付成功后发送模板消息 */
    public function sendOrderMsg($order_id,$prepay_id){
        global $_W;
        $orderData=pdo_get($this->order,['id'=>$order_id,'uniacid'=>$this->uniacid]);
        $relation=pdo_get('cqkundian_farm_pt_relation',['id'=>$orderData['relation_id'],'uniacid'=>$this->uniacid]);
        $orderDetail=pdo_get($this->order_detail,['order_id'=>$orderData['id'],'uniacid'=>$this->uniacid]);
        if($orderData['is_pay']==1) {
            $prepay_id = explode('=', $prepay_id);
            self::$notice->isPaySendNotice($orderData,$prepay_id[1],$_W['openid'],$this->uniacid);
            self::$common->insertFormIdData($prepay_id[1],$orderData['uid'],$_W['openid'],1,$this->uniacid);
        }

        if($orderData['is_group']==2){
            $ptTotal=pdo_getall($this->order,['relation_id'=>$orderData['relation_id'],'is_pay'=>1,'uniacid'=>$this->uniacid]);
            //拼团成功 发送模板消息通知
            if (count($ptTotal)== $relation['ptnumber']) {
                $order=[
                    'goods_name'=>$orderDetail['goods_name'],
                    'price'=>$orderDetail['price'].'元',
                    'ptnumber'=>$relation['ptnumber'].'人团',
                    'end_time'=>$relation['end_time'],
                ];
                for ($i=0;$i<count($ptTotal);$i++){
                    self::$notice->sendPtSuccessMsg($order,$ptTotal[$i]['uid'],'/kundian_pt/pages/orderLists/index');
                }
            }
            die;
        }

    }

    /** 发货通知 */
    public function deliverGoodsSendMsg($order_id,$formid){
        $orderData=pdo_get($this->order,['id'=>$order_id,'uniacid'=>$this->uniacid]);
        $user=pdo_get('cqkundian_farm_user',['uid'=>$orderData['uid']]);
        $order=[
            'goods_name'=>$orderData['body'],
            'order_number'=>$orderData['order_number'],
            'express'=>$orderData['express'],
            'express_no'=>$orderData['express_no'],
            'send_time'=>$orderData['send_time'],
        ];
        $res=self::$notice->deliveryGoodsMsg($order,$user['openid'],$formid);;
        return $res;
    }

    /** 获取拼团订单信息 */
    public function getOrderList($cond=[],$page='',$size='',$order_by='create_time desc'){
        if(empty($cond['uniacid'])){
            $cond['uniacid']=$this->uniacid;
        }
        $query = load()->object('query');

        if(!empty($page) && !empty($size) ){
            $orderList = $query->from($this->order, 'a')->leftjoin($this->order_detail, 'b')
                ->on('a.id', 'b.order_id')->leftjoin('cqkundian_farm_user', 'c')->on('a.uid', 'c.uid')
                ->select('a.*', 'b.cover','b.goods_name','b.goods_id','b.sku_name','b.num','b.price','c.nickname','c.avatarurl')
                ->where($cond)->orderby('create_time','desc')->page($page,$size)->getall();
        }else{
            $orderList = $query->from($this->order, 'a')->leftjoin($this->order_detail, 'b')
                ->on('a.id', 'b.order_id')->leftjoin('cqkundian_farm_user', 'c')->on('a.uid', 'c.uid')
                ->select('a.*', 'b.cover','b.goods_name','b.sku_name','b.num','b.price','c.nickname','c.avatarurl')
                ->where($cond)->orderby($order_by)->getall();
        }
        $setData=self::$common->getSetData(['expire_order_time'],$this->uniacid);
        for ($i=0;$i<count($orderList);$i++){
            $orderList[$i]=$this->neatenOrderStatus($orderList[$i]);
            //订单逾期未支付自动取消
            if ($orderList[$i]['is_pay'] == 0 && ($orderList[$i]['create_time'] + $setData['expire_order_time']) <= time() && $orderList[$i]['apply_delete']==0 ) {
                pdo_update($this->order,['apply_delete' =>2],['uniacid' => $this->uniacid, 'id' => $orderList[$i]['id']]);
                $body=[
                    'body'=>$orderList[$i]['goods_name'],
                    'order_number'=>$orderList[$i]['order_number'],
                    'total_price'=>$orderList[$i]['total_price'],
                    'reason'=>'由于订单逾期未支付，已为您自动取消，欢迎下次购买',
                ];
                $res=self::$notice->cancelOrderMsg($body,$orderList[$i]['uid'],'/kundian_pt/pages/orderLists/index');
            }

            //已支付，但是拼单未完成
            $relation=pdo_get('cqkundian_farm_pt_relation',['id'=>$orderList[$i]['relation_id'],'uniacid'=>$this->uniacid]);
            if($relation['status']==1 && $orderList[$i]['is_pay']==1 && $orderList[$i]['is_success']==0){
                if( $relation['end_time'] < time() ){  //超过拼单订单时间，拼单失败
                    pdo_update('cqkundian_farm_pt_relation',['status'=>3],['id'=>$orderList[$i]['relation_id'],'uniacid'=>$this->uniacid]);
                    pdo_update($this->order,['apply_delete'=>1],['relation_id'=>$relation['id'],'uniacid'=>$this->uniacid]);
                    $orderList[$i]['status_code']=7;
                    $orderList[$i]['status_txt']='拼单失败';
                }
            }

            if($relation['status']==3){
                $orderList[$i]['status_code']=7;
                $orderList[$i]['status_txt']='拼单失败';
            }

            $orderList[$i]['create_time']=date("Y-m-d H:i:s");
        }
        return $orderList;
    }

    /** 获取一条订单信息 */
    public function getOrderListById($cond){
        $query = load()->object('query');
        if(empty($cond['uniacid'])){
            $cond['uniacid']=$this->uniacid;
        }
        $orderList = $query->from($this->order, 'a')->leftjoin($this->order_detail, 'b')
            ->on('a.id', 'b.order_id')->leftjoin('cqkundian_farm_user', 'c')->on('a.uid', 'c.uid')
            ->select('a.*', 'b.cover','b.goods_name','b.sku_name','b.num','b.price','b.goods_id','c.nickname')
            ->where($cond)->get();
        return $orderList;
    }

    public function neatenOrderStatus($orderData){
        if($orderData['apply_delete']==0) {
            if ($orderData['is_pay'] == 0) {
                $orderData['status_txt'] = '等待买家付款';
                $orderData['status_code']=0;
            } elseif ($orderData['is_pay'] == 1 && $orderData['is_send'] == 0 && $orderData['is_success']==1) {
                $orderData['status_txt'] = '等待商家发货';
                $orderData['status_code']=1;
            } elseif ($orderData['is_pay'] == 1 && $orderData['is_send'] == 1 && $orderData['is_confirm'] == 0) {
                $orderData['status_txt'] = '商家已发货';
                $orderData['status_code']=2;
            } elseif ($orderData['is_pay'] == 1 && $orderData['is_send'] == 1 && $orderData['is_confirm'] == 1) {
                $orderData['status_txt'] = '交易成功';
                $orderData['status_code']=3;
            }elseif ($orderData['is_pay']==1 && $orderData['is_success']!=1&& $orderData['is_group']!=1) {
                $orderData['status_txt']='拼单中';
                $orderData['status_code']=6;
            }elseif ($orderData['is_pay']==1 && $orderData['is_success']!=1&& $orderData['is_group']==1){
                $orderData['status_txt'] = '等待商家发货';
                $orderData['status_code']=1;
            }
        }elseif($orderData['apply_delete']==1){
            $orderData['status_txt'] = '申请退款中';
            $orderData['status_code']=4;
        }elseif ($orderData['apply_delete']==2){
            if($orderData['is_pay']==1){
                $orderData['status_txt']='成功取消已退款';
            }else{
                $orderData['status_txt'] = '订单已取消';
            }
            $orderData['status_code']=5;
        }
        return $orderData;
    }

    public function getOrderStatusCond($status){
        if($status==0){
            return ['is_pay'=>0,'apply_delete'=>0];
        }
        if($status==1){
            return ['is_pay'=>1,'is_send'=>0,'is_confirm'=>0,'apply_delete'=>0];
        }
        if($status==2){
            return['is_pay'=>1,'is_send'=>1,'is_confirm'=>0];
        }
        if($status==3){
            return ['is_pay'=>1,'is_send'=>1,'is_confirm'=>1];
        }
        if($status==4){
            return ['apply_delete'=>1];
        }
        if($status==5){
            return ['apply_delete'=>2];
        }
        if($status==6){
            return ['is_pay'=>6];
        }
    }

    /** 获取拼团商品评论信息 */
    public function getCommentList($cond=[],$pageIndex='',$pageSize='',$order_by='create_time desc'){
        $query=load()->object('query');
        if(empty($pageIndex) || empty($pageSize)){
            $list= $query->from('cqkundian_farm_pt_comment', 'a')
                ->leftjoin('cqkundian_farm_user', 'b')->on('a.uid', 'b.uid')
                ->leftjoin($this->order_detail, 'c')->on('a.order_id', 'c.order_id')
                ->select('a.*','b.nickname','b.avatarurl','c.goods_name','c.sku_name')
                ->where($cond)->orderby($order_by)->getall();
        }else{
            $list= $query->from('cqkundian_farm_pt_comment', 'a')
                ->leftjoin('cqkundian_farm_user', 'b')->on('a.uid', 'b.uid')
                ->leftjoin($this->order_detail, 'c')->on('a.order_id', 'c.order_id')
                    ->select('a.*','b.nickname','b.avatarurl','c.goods_name','c.sku_name')
                ->where($cond)->page($pageIndex,$pageSize)->orderby($order_by)->getall();
        }
        if($list){
            for ($i=0;$i<count($list);$i++){
                $list[$i]['create_time']=date("Y-m-d",$list[$i]['create_time']);
                $list[$i]['src']=unserialize($list[$i]['src']);
                $list[$i]['wx_nickname']=self::$common->substr_cut($list[$i]['nickname']);
            }
        }
        return $list;
    }

    /** 获取拼团信息 */
    public function getRelation($cond=[],$pageIndex='',$pageSize=''){
        $query=load()->object('query');
        if(!empty($pageIndex) && !empty($pageSize)){
            $list= $query->from('cqkundian_farm_pt_relation', 'a')
                ->leftjoin($this->order,'b')->on('a.id','b.relation_id')
                ->leftjoin($this->order_detail, 'c')->on('b.id', 'c.order_id')
                ->leftjoin('cqkundian_farm_user','d')->on('b.uid','d.uid')
                ->select('a.*','b.order_number','b.is_success','b.is_pay','b.is_send','b.is_confirm','b.is_header','c.goods_name','c.cover','c.price','c.num','c.sku_name','d.nickname')
                ->where($cond)->orderby('create_time','desc')->page($pageIndex,$pageSize)->getall();

        }else{
            $list= $query->from('cqkundian_farm_pt_relation', 'a')
                ->leftjoin($this->order,'b')->on('a.id','b.relation_id')
                ->leftjoin($this->order_detail, 'c')->on('b.id', 'c.order_id')
                ->leftjoin('cqkundian_farm_user','d')->on('b.uid','d.uid')
                ->select('a.*','b.order_number','b.is_success','b.is_pay','b.is_send','b.is_confirm','b.is_header','c.goods_name','c.cover','c.price','c.num','c.sku_name','d.nickname')
                ->where($cond)->orderby('create_time','desc')->getall();
        }

        for ($i=0;$i<count($list);$i++){
            $list[$i]=$this->neatenOrderStatus($list[$i]);
            $list[$i]['create_time']=date("Y-m-d H:i:s",$list[$i]['create_time']);

            //查询当前下单人数
            $user_total = pdo_fetchcolumn("SELECT COUNT(*) FROM " . tablename($this->order) . " WHERE relation_id=:relation_id AND is_pay=:is_pay AND uniacid=:uniacid",
                [':relation_id' => $list[$i]['id'], ':is_pay' => 1, 'uniacid' => $this->uniacid]);
            $list[$i]['currentPerson']=$user_total;
        }
        return $list;
    }

    /** 订单发货 */
    public function sendOrder($request){
        $orderData=pdo_get($this->order,['id'=>$request['order_id'],'uniacid'=>$this->uniacid]);
        $save_date=array(
            'express_no'=>$request['send_number'],
            'express'=>$request['express_company'],
            'is_send'=>1,
            'send_time'=>time()
        );
        $res=pdo_update($this->order,$save_date,['id'=>$request['order_id'],'uniacid'=>$this->uniacid]);
        if($res){
            $body=[
                'body'=>$orderData['goods_name'],
                'order_number'=>$orderData['order_number'],
                'express'=>$save_date['express'],
                'express_no'=>$save_date['express_no'],
                'send_time'=>time()
            ];
            $page='/kundian_pt/pages/orderLists/index';
            self::$notice->deliveryGoodsMsg($body,$orderData['uid'],$page);
            return ['code'=>0,'msg'=>'发货成功'];
        }
        return ['code'=>-1,'msg'=>'发货失败'];
    }
}