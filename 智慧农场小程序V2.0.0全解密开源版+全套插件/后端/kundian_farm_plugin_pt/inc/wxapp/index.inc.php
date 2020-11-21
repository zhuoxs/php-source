<?php
/**
 * Created by PhpStorm.
 * User: 坤典科技
 * Date: 2019/1/29 0029
 * Time: 下午 3:03
 */
defined("IN_IA") or exit("Access Denied");
require_once ROOT_PATH_FARM_PT.'model/goods.php';
require_once ROOT_PATH.'model/public.php';
require_once ROOT_PATH.'model/notice.php';
require_once ROOT_PATH_FARM_PT.'model/order.php';
class IndexController{
    protected $uniacid='';
    protected $uid='';
    static $pt_goods='';
    static $order='';
    static $notice='';
    public function __construct(){
        global $_GPC;
        $this->uniacid=$_GPC['uniacid'];
        $this->uid=$_GPC['uid'];
        self::$pt_goods=new Pt_GoodsModel($this->uniacid);
        self::$order=new Pt_OrderModel($this->uniacid);
        self::$notice=new Notice_KundianFarmModel($this->uniacid);
    }

    /** 获取组团商城首页轮播图、分类、商品信息 */
    public function getPtIndex($request){
        global $_W;
        $return['slideData']=pdo_getall('cqkundian_farm_slide',['uniacid'=>$this->uniacid,'slide_type'=>4],'','','rank asc');
        $return['typeData']=pdo_getall(self::$pt_goods->pt_type,['uniacid'=>$this->uniacid,'status'=>1],'','','rank asc');
        $return['goodsData']=self::$pt_goods->getGoodsList(['is_put_away'=>1,'limit_time >'=>time()],1,10);
        $return['time']=time()-7*86400;
        $return['openid']=$_W;
        echo json_encode($return);die;
    }

    /** 获取组团商品列表信息 */
    public function getPtList($request){
        $cond=['is_put_away'=>1];
        if(!empty($request['type_id']) && $request['type_id']!=0){
            $cond['type_id']=$request['type_id'];
        }
        $return['goodsData']=self::$pt_goods->getGoodsList($cond,$request['page'],10);
        echo json_encode($return);die;
    }

    /** 查看组团商品详情页面信息  */
    public function getPtDetail($request){
        $public=new Public_KundianFarmModel(self::$pt_goods->pt_goods,$this->uniacid);
        $goods=$public->getTableById($request['goods_id']);
        $goods['slide_src']=unserialize($goods['slide_src']);
        $goods['sku']=unserialize($goods['sku']);
        $goods['diff_price']=number_format($goods['price'] - $goods['pt_price']);
        $goods['limit_time']=date("Y/m/d H:i:s",$goods['limit_time']);
        //规格
        $spec=pdo_getall('cqkundian_farm_pt_spec',['goods_id'=>$request['goods_id'],'uniacid'=>$this->uniacid]);
        for ($i=0;$i<count($spec);$i++){
            $spec_val=pdo_getall('cqkundian_farm_pt_spec_value',['spec_id'=>$spec[$i]['id']]);
            $spec[$i]['specVal']=$spec_val;
        }

        //当前商品拼单列表
        $ptOrder=pdo_getall('cqkundian_farm_pt_relation',['goods_id'=>$request['goods_id'],'uniacid'=>$this->uniacid,'status'=>1,'end_time >'=>time()]);
        for ($i=0;$i<count($ptOrder);$i++){
            $pttotal = pdo_fetchcolumn("SELECT COUNT(*) FROM " . tablename(self::$order->order) . " WHERE relation_id=:relation_id AND is_pay=:is_pay AND uniacid=:uniacid",
                [':relation_id' => $ptOrder[$i]['id'], ':is_pay' => 1, 'uniacid' => $this->uniacid]);
            $ptOrder[$i]['differ']=$ptOrder[$i]['ptnumber']-$pttotal;
            $user=pdo_get('cqkundian_farm_user',['uid'=>$ptOrder[$i]['uid']]);
            $ptOrder[$i]['avatarurl']=$user['avatarurl'];
            $ptOrder[$i]['nickname']=$user['nickname'];
            $ptOrder[$i]['endTime']=date("Y/m/d H:i:s",$ptOrder[$i]['end_time']);
            $ptOrder[$i]['finised']=false;
        }

        //获取当前商品评价信息
        $page=empty($request['page']) ? 1 : $request['page'];
        $commentList=self::$order->getCommentList(['goods_id'=>$request['goods_id'],'status'=>0],$page,10);

        //获取当前拼这个商品 的用户
        $oldWhere=[
            'b.goods_id'=>$request['goods_id'],
            'uniacid'=>$this->uniacid,
            'is_pay'=>1,
            'apply_delete'=>0,
        ];
        $ptIng=self::$order->getOrderList($oldWhere,0,10);
        $return=[
            'goods'=>$goods,
            'spec'=>$spec,
            'ptOrder'=>$ptOrder,
            'commentList'=>$commentList,
            'ptIng'=>$ptIng
        ];
        echo json_encode($return);die;
    }


    /** 确认订单 */
    public function getSurePtOrder($request){
        $selectSpec=json_decode(htmlspecialchars_decode($request['selectSpec']));
        $public=new Public_KundianFarmModel(self::$pt_goods->pt_goods,$this->uniacid);
        $goods=$public->getTableById($request['goods_id']);
        if($goods['is_open_sku']==1){  //存在规格值
            if(!empty($selectSpec)){
                $totalPrice=$selectSpec->pt_price*$request['selectNum'];
                if($request['buy_types']==1){
                    $totalPrice=$selectSpec->price*$request['selectNum'];
                }
            }else{
                $totalPrice=$goods['pt_price']*$request['selectNum'];
            }
        }else{
            $totalPrice=$goods['pt_price'] * $request['selectNum'];
            if($request['buy_types']==1){
                $totalPrice=$goods['price'] * $request['selectNum'];
            }
        }
        require_once ROOT_PATH.'model/goods.php';
        $goodsModel=new Goods_KundianFarmModel('','');
        $send_price =$goodsModel->calculationShipping($goods,$totalPrice,$request['selectNum'],$this->uniacid);
        $total_price=$totalPrice + $send_price;
        echo json_encode(['goods'=>$goods,'totalPrice'=>number_format($totalPrice,2),'send_price'=>$send_price,'total_price'=>$total_price]);die;
    }

    /** 下订单 */
    public function addPtOrder($request){
        global $_W;
        $address=json_decode(htmlspecialchars_decode($request['address']));
        $selectSpec=json_decode(htmlspecialchars_decode($request['selectSpec']));
        $res=self::$order->addOrder($request,$selectSpec,$address);
        echo json_encode($res);die;
    }

    /** 发送模板消息通知 */
    public function sendMsg($request){
        self::$order->sendOrderMsg($request['order_id'],$request['prepay_id']);
    }

    public function sendSuccessMsg($request){
        self::$order->sendOrderMsg($request['order_id'],$request['prepay_id']);
    }

    /** 获取拼团订单列表信息*/
    public function getOrderList($request){
        $page=empty($request['page']) ? 1 : $request['page'];
        //currentId ==1 全部  2 待付款 3 待收货 4 已收货
        if($request['currentId']==2){
            $cond=['is_pay'=>0,'is_send'=>0,'is_confirm'=>0];
        }elseif ($request['currentId']==3){
            $cond=['is_pay'=>1,'is_send'=>1,'is_confirm'=>0];
        }elseif ($request['currentId']==4){
            $cond=['is_pay'=>1,'is_send'=>1,'is_confirm'=>1];
        }
        $cond['uid']=$this->uid;
        $cond['is_delete']=0;
        $orderList=self::$order->getOrderList($cond,$page,10);
        echo json_encode(['orderList'=>$orderList]);die;
    }

    /** 删除拼团订单 */
    public function deletePtOrder($request){
        $res=pdo_update(self::$order->order,['is_delete'=>1],['id'=>$request['order_id'],'uniacid'=>$this->uniacid,'uid'=>$this->uid]);
        echo $res ? json_encode(['code'=>0,'msg'=>'删除成功']): json_encode(['code'=>-1,'msg'=>'删除失败']);die;
    }

    /** 取消组团订单 */
    public function cancelPtOrder($request){
        $res=pdo_update(self::$order->order,['apply_delete'=>2],['id'=>$request['order_id'],'uniacid'=>$this->uniacid,'uid'=>$this->uid]);
        $orderData=self::$order->getOrderListById(['id'=>$request['order_id']]);
        $body=[
            'body'=>$orderData['goods_name'],
            'order_number'=>$orderData['order_number'],
            'total_price'=>$orderData['total_price'],
            'reason'=>'用户自己取消',
        ];
        self::$notice->cancelOrderMsg($body,$orderData['uid'],'');
        echo $res ? json_encode(['code'=>0,'msg'=>'取消成功']): json_encode(['code'=>-1,'msg'=>'取消失败']);die;
    }

    /** 申请退款 */
    public function applyRefundOrder($request){
        $res=pdo_update(self::$order->order,['apply_delete'=>1],['id'=>$request['order_id'],'uniacid'=>$this->uniacid,'uid'=>$this->uid]);
        if($res){
            $orderData=pdo_get(self::$order->order,['id'=>$request['order_id'],'uniacid'=>$this->uniacid]);
            self::$notice->cancelOrderNotice($orderData);
        }
        echo $res ? json_encode(['code'=>0,'msg'=>'退款申请已提交']): json_encode(['code'=>-1,'msg'=>'退款申请提交失败']);die;
    }

    /** 确认收货 */
    public function confirmGoods($request){
        $res=pdo_update(self::$order->order,['is_confirm'=>1,'confirm_time'=>time()],['id'=>$request['order_id'],'uniacid'=>$this->uniacid,'uid'=>$this->uid]);
        echo $res ? json_encode(['code'=>0,'msg'=>'收货成功']): json_encode(['code'=>-1,'msg'=>'收货失败']);die;
    }

    /** 查看订单详情*/
    public function getPtOrderDetail($request){
        $orderDetail=self::$order->getOrderListById(['id'=>$request['order_id']]);
        $orderDetail=self::$order->neatenOrderStatus($orderDetail);
        $orderDetail['create_time']=date("Y-m-d H:i:s",$orderDetail['create_time']);
        $orderDetail['pay_time']=date("Y-m-d H:i:s",$orderDetail['pay_time']);
        $relation=pdo_get('cqkundian_farm_pt_relation',['id'=>$orderDetail['relation_id'],'uniacid'=>$this->uniacid]);
        $relation['end_time']=date("Y/m/d H:i:s",$relation['end_time']);

        $relationOrder=self::$order->getOrderList(['relation_id'=>$orderDetail['relation_id'],'uniacid'=>$this->uniacid,'is_pay'=>1],'','','create_time asc');
        $differ=$relation['ptnumber']-count($relationOrder);

        $about=pdo_get('cqkundian_farm_about',['uniacid'=>$this->uniacid]);
        $return=[
            'orderDetail'=>$orderDetail,
            'relation'=>$relation,
            'differ'=>$differ,
            'relationOrder'=>$relationOrder,
            'about'=>$about,
        ];
        echo json_encode($return);die;
    }

    /** 更新订单收获地址 */
    public function ptUpdateAddress($request){
        $updateData=[
            'name'=>$request['name'],
            'address'=>$request['address'],
            'phone'=>$request['phone'],
        ];
        $res=pdo_update(self::$order->order,$updateData,['id'=>$request['order_id'],'uniacid'=>$this->uniacid]);
        echo $res ? json_encode(['code'=>0,'msg'=>'操作成功']) : json_encode(['code'=>-1,'msg'=>'操作失败']);die;
    }

    /** 获取评价订单*/
    public function getCommentOrder($request){
        $orderData=pdo_get(self::$order->order,['id'=>$request['order_id'],'uniacid'=>$this->uniacid]);
        $orderDetail=pdo_getall(self::$order->order_detail,['order_id'=>$request['order_id'],'uniacid'=>$this->uniacid]);
        echo json_encode(['orderData'=>$orderData,'orderDetail'=>$orderDetail]);die;
    }

    /** 获取商品评论信息 */
    public function getPtCommentList($request){
        $page=empty($request['page']) ? 1 : $request['page'];
        $commentList=self::$order->getCommentList(['goods_id'=>$request['goods_id']],$page,10);
        echo json_encode(['commentList'=>$commentList]);die;
    }
}