<?php
/**
 * Created by PhpStorm.
 * User: 坤典科技
 * Date: 2019/2/15 0015
 * Time: 上午 10:14
 * 拼团订单
 */
defined('IN_IA') or exit('Access Denied');
require_once ROOT_PATH.'model/public.php';
require_once ROOT_PATH.'model/common.php';
require_once ROOT_PATH.'model/notice.php';
require_once ROOT_PATH_FARM_PT.'model/order.php';
class Pt_Order{
    protected $that='';
    protected $uniacid='';
    static $common='';
    static $order='';
    static $notice='';
    public function __construct($that){
        global $_W,$_GPC;
        checklogin();
        $this->that=$that;
        $this->uniacid=$_W['uniacid'];
        self::$common=new Common_KundianFarmModel();
        self::$order=new Pt_OrderModel($this->uniacid);
        self::$notice=new Notice_KundianFarmModel($this->uniacid);
    }

    /** 拼团订单列表 */
    public function ptOrderList($request){
        $flag=$request['flag'];
        $data['old_time'] = array(
            'start' => date("Y-m-d", strtotime('-30 days')),
            'end' => date('Y-m-d', strtotime('+1 days'))
        );

        //订单状态  0 全部 1/已支付 2 已发货 3/已完成 4/申请取消 5 已取消
        if(isset($request['status'])){
            $condition=self::$order->getOrderStatusCond($request['status']);
        }
        if (!empty($request['order_number'])) {
            $data['order_number'] = trim($request['order_number']);
            $condition['order_number LIKE'] = '%' . $data['order_number'] . '%';
        }
        if(!empty($request['name'])){
            $data['name'] = trim($request['name']);
            $condition['name LIKE'] = '%' . $data['name'] . '%';
        }
        $condition['is_recycle']=0;
        if($request['is_recycle']){
            $condition['is_recycle']=$request['is_recycle'];
        }
        if ($request['start'] && $request['end']) {
            $condition['create_time >'] = strtotime($request['start']);
            $condition['create_time <'] = strtotime($request['end']);
            $data['old_time'] = ['start'=>$request['start'],'end'=>$request['end']];
        }

        //导出订单
        if($flag=='true'){
            $this->outFiledOrder($condition);
        }else {//查看订单信息
            $public=new Public_KundianFarmModel(self::$order->order,$this->uniacid);
            $count=$public->getCount($condition);
            $page=empty($request['page']) ? 1 : $request['page'];
            $data['pager']=pagination($count,$page,10);
            $orderList=self::$order->getOrderList($condition,$page,10);
            $data['list']=$orderList;
            $this->that->doWebCommon("web/order/orderList",$data);
        }
    }

    /** 订单退款 */
    public function ptRefundOrder($request){
        require_once ROOT_PATH.'model/refund.php';
        $refund=new Refund_KundianFarmModel($this->uniacid);
        $result=$refund->ptRefundOrder($request['order_id']);
        echo json_encode($result);die;
    }

    /** 拒绝退款 */
    public function ptDenyRefundOrder($request){
        $public=new Public_KundianFarmModel(self::$order->order,$this->uniacid);
        $orderData=$public->getTableById($request['order_id']);
        if($orderData['is_pay']==1 && $orderData['pra_price']) {
            $res=$public->updateTable(['apply_delete' => 0],['id'=>$request['order_id']]);
            echo $res ? json_encode(['code'=>0,'msg'=>'操作成功']) : json_encode(['code'=>-1,'msg'=>'操作失败']);die;
        }
        echo json_encode(['code'=>-1,'msg'=>'系统错误']);die;
    }

    /** 订单移入移除回收站 */
    public function ptRemoveOrderRecycle($request){
        $update_order=['is_recycle'=>0];
        if($request['type']==1) {
            $update_order=['is_recycle'=>1];
        }
        $res=pdo_update(self::$order->order,$update_order,['id'=>$request['order_id'],'uniacid'=>$this->uniacid]);
        echo $res ? json_encode(['code'=>0,'msg'=>'操作成功']) : json_encode(['code'=>-1,'msg'=>'操作失败']);
    }

    /** 删除已完成的拼团订单 */
    public function ptDeleteOrder($request){
        $orderData=pdo_get(self::$order->order,array('uniacid'=>$this->uniacid,'id'=>$request['order_id']));
        if($orderData['is_pay']==0 || $orderData['apply_delete']==2){
            $res=pdo_delete(self::$order->order,['id'=>$request['order_id'],'uniacid'=>$this->uniacid]);
            pdo_delete(self::$order->order_detail,['order_id'=>$request['order_id'],'uniacid'=>$this->uniacid]);
            echo $res ? json_encode(['code'=>0,'msg'=>'删除成功']) : json_encode(['code'=>-1,'msg'=>'删除失败']);die;
        }

        echo json_encode(['code'=>-1,'msg'=>'该订单未完成，不能删除']);die;
    }

    /** 拼团订单发货*/
    public function ptSendOrder($request){
        $return = self::$order->sendOrder($request);
        echo json_encode($return);die;
    }

    /** 拼团订单收货*/
    public function ptConfirmOrder($request){
        $public=new Public_KundianFarmModel(self::$order->order,$this->uniacid);
        $update_order=array(
            'is_confirm'=>1,
            'confirm_time'=>time()
        );
        $res=$public->updateTable($update_order,['id'=>$request['order_id'],'uniacid'=>$this->uniacid]);
        echo $res ? json_encode(['code'=>0,'msg'=>'收货成功']) : json_encode(['code'=>-1,'msg'=>'收货失败']);die;
    }

    /** 保存商家备注*/
    public function ptSaveMerchentRemark($request){
        $update_order=['manager_remark'=>$request['manager_remark']];
        $res=pdo_update(self::$order->order,$update_order,['id'=>$request['order_id'],'uniacid'=>$this->uniacid]);
        echo $res ? json_encode(['code'=>0,'msg'=>'保存成功']): json_encode(['code'=>-1,'msg'=>'保存失败']);die;
    }

    /** 拼团订单详情*/
    public function ptOrderDetail($request){
        $orderData=pdo_get(self::$order->order,['id'=>$request['id'],'uniacid'=>$this->uniacid]);
        $orderData=self::$order->neatenOrderStatus($orderData);
        $orderDetail=pdo_get(self::$order->order_detail,['order_id'=>$request['id'],'uniacid'=>$this->uniacid]);
        $data['orderData']=$orderData;
        $data['orderDetail']=$orderDetail;
        $this->that->doWebCommon("web/order/orderDetail",$data);
    }

    /** 修改拼团订单总价 */
    public function ptChangeOrderPrice($request){
        global $_GPC;
        $public=new Public_KundianFarmModel(self::$order->order,$this->uniacid);
        $discount_price=floatval($request['discount_price']);
        $order_number = self::$common->getUniqueOrderNumber();
        $orderData = $public->getTableById($request['order_id']);
        $total_price = number_format($orderData['total_price'] - $discount_price, 2);
        if ($total_price > 0 && $orderData['total_price'] != $total_price) {
            $res = $public->updateTable(['total_price' => $total_price, 'order_number' => $order_number, 'manager_discount +=' => $discount_price], ['id' => $request['order_id'], 'uniacid' => $this->uniacid]);
        } else {
            echo json_encode(['code' => -1, 'msg' => '订单价格必须大于零或没有修改订单价格！']);
            die;
        }
        echo $res ? json_encode(['code' => 0, 'msg' => '价格修改成功']) : json_encode(['code' => -1, 'msg' => '价格修改失败']);
        die;
    }

    /** 导出订单 */
    public function outFiledOrder($condition){
        global $_GPC;
        $field=$_GPC['field'];
        $filed_name=[];
        $filed_english=[];
        foreach ($field as $key => $value){
            $filedKey=explode(',',$value);
            array_push($filed_english,$filedKey[0]);
            array_push($filed_name,$filedKey[1]);
        }
        $data[][0]=$filed_name;
        $listCount=self::$order->getOrderList($condition);
        $orderData=array();
        for ($i=0;$i<count($listCount);$i++){
            $orderData[$i]['order_number']=' '.$listCount[$i]['order_number'];                          //订单编号
            $orderData[$i]['total_price']=$listCount[$i]['total_price'];                                //订单总价
            $orderData[$i]=self::$order->neatenOrderStatus($listCount[$i]);               //订单状态
            $orderData[$i]['create_time']=' '.date("Y-m-d H:i:s",$listCount[$i]['create_time']); //下单时间
            $orderData[$i]['send_time']=$listCount[$i]['send_time']? ' '.date("Y-m-d H:i:s",$listCount[$i]['send_time']):"--:--";     //发货时间
            $orderData[$i]['confirm_time']=$listCount[$i]['confirm_time']?' '.date("Y-m-d H:i:s",$listCount[$i]['confirm_time']):"--:--"; //收货时间
            $orderData[$i]['pay_method']=$listCount[$i]['pay_method'];                                  //支付方式
            $orderData[$i]['name']='  '.$listCount[$i]['name'];                                         //收件人姓名
            $orderData[$i]['phone']='  '.$listCount[$i]['phone'];                                       //收件人电话
            $orderData[$i]['express_no']='  '.$listCount[$i]['send_number'];                           //快递单号
            $orderData[$i]['express']='  '.$listCount[$i]['express_company'];                   //快递公司
            $orderData[$i]['express_price']='  '.$listCount[$i]['send_price'];                             //运费
            $orderData[$i]['address']='  '.$listCount[$i]['address'];                                   //收货地址
            $orderData[$i]['pra_price']='  '.$listCount[$i]['pra_price'];                                   //实际付款

            //查询订单详细信息
            $str = '商品名称'.$listCount[$i]['goods_name'].' 价格：'.$listCount[$i]['price'].' 规格：'.$listCount[$i]['sku_name'];
            $orderData[$i]['goods_info']=$str;
        }
        $fieldOrder=[];
        for ($i=0;$i<count($orderData);$i++){
            for ($j=0;$j<count($filed_english);$j++){
                $fieldOrder[$i][$filed_english[$j]]=$orderData[$i][$filed_english[$j]];
            }
        }

        $data[]=$fieldOrder;
        require_once ROOT_PATH."inc/web/Org/PHPExcel.class.php";
        require_once ROOT_PATH."inc/web/Org/PHPExcel/Writer/Excel5.php";
        require_once ROOT_PATH."inc/web/Org/PHPExcel/IOFactory.php";
        require_once ROOT_PATH."inc/web/Org/function.php";
        $filename="订单";
        getExcel($filename,$data);
    }

    /** 拼团商品评论列表 */
    public function ptOrderComment($request){
        $public=new Public_KundianFarmModel('cqkundian_farm_comment',$this->uniacid);
        $count=$public->getCount(['uniacid'=>$this->uniacid]);
        $page=$request['page'] ? $request['page'] : 1 ;
        $data['pager']=pagination($count,$page,10);
        $data['list']=self::$order->getCommentList(['uniacid'=>$this->uniacid],$page,10);
        $this->that->doWebCommon("web/order/orderComment",$data);
    }

    /** 编辑评论信息 */
    public function editComment(){
        global $_GPC;
        $public=new Public_KundianFarmModel('cqkundian_farm_pt_comment',$this->uniacid);
        if(!empty($_GPC['id'])){
            $data['list']=$public->getTableById($_GPC['id']);
            $data['list']['src']=unserialize($data['list']['src']);
            $data['goods']=pdo_get('cqkundian_farm_pt_goods',['id'=>$data['list']['goods_id'],'uniacid'=>$this->uniacid]);
        }

        if($_SERVER['REQUEST_METHOD'] && !strcasecmp($_SERVER['REQUEST_METHOD'],'post')){
            $data=$_GPC['formData'];
            $x=0;
            $src=[];
            while($data["src[$x"]) {
                $src[]=tomedia($data["src[$x"]);
                $x++;
            }
            $updateData=[
                'content'=>$data['content'],
                'src'=>serialize($src),
                'status'=>$data['status'],
                'score'=>$data['score'],
            ];
            $res=$public->updateTable($updateData,['id'=>$data['id']]);
            $redirect=url('site/entry/admin',['action'=>'order','m'=>$_GPC['m'],'op'=>'ptOrderComment']);
            echo $res ? json_encode(['code'=>0,'msg'=>'保存成功','redirect'=>$redirect]) : json_encode(['code'=>-1,'msg'=>'保存失败']);die;
        }

        $this->that->doWebCommon("web/order/editComment",$data);
    }

    /** 改变评论状态*/
    public function changeCommentStatus(){
        global $_GPC;
        $public=new Public_KundianFarmModel('cqkundian_farm_pt_comment',$this->uniacid);
        $res=$public->updateTable(['status'=>$_GPC['status']],['id'=>$_GPC['id'],'uniacid'=>$this->uniacid]);
        echo $res ? json_encode(['code'=>0,'msg'=>'更新成功']) : json_encode(['code'=>-1,'msg'=>'更新失败']);die;
    }

    /** 删除评论*/
    public function deleteComment(){
        global $_GPC;
        $public=new Public_KundianFarmModel('cqkundian_farm_pt_comment',$this->uniacid);
        $res=$public->deleteTable(['id'=>$_GPC['id'],'uniacid'=>$this->uniacid]);
        echo $res ? json_encode(['code'=>0,'msg'=>'删除成功']) : json_encode(['code'=>-1,'msg'=>'删除失败']);die;
    }

    /** 拼团管理 */
    public function ptManager($request){
        if(!empty($request['status'])){
            $cond['status']=$request['status'];
        }else{
            $cond['status >']=0;
        }
        $public=new Public_KundianFarmModel('cqkundian_farm_pt_relation',$this->uniacid);
        $count=$public->getCount($cond);
        $page=empty($request['page']) ? 1 : $request['page'];
        $data['pager']=pagination($count,$page,10);
        $cond['b.is_pay']=1;
        $cond['b.is_header']=1;
        $data['list']=self::$order->getRelation($cond,$page,10);
        $this->that->doWebCommon("web/order/ptManager",$data);
    }

    /** 团信息*/
    public function ptInfo($request){
        $data['relation']=pdo_get('cqkundian_farm_pt_relation',['id'=>$request['id'],'uniacid'=>$this->uniacid]);
        $data['list']=self::$order->getOrderList(['relation_id'=>$request['id'],'is_pay'=>1],'','','is_header desc');
        $this->that->doWebCommon("web/order/ptInfo",$data);
    }
}