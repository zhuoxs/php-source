<?php
namespace app\admin\controller;
use app\model\Order;
use app\model\Panic;
use app\model\Panicorder;
use app\model\Panicrefund;
use app\model\Store;
use Think\Db;
use app\model\Userbalancerecord;
use app\model\Commonorder;
use app\model\Integralrecord;
use app\model\Distributionorder;


class Corder extends Base
{
    public function __construct()
    {
        parent::__construct();
    }

    public function save(){
        $info = $this->model;
        $id = input('post.id');
        $post=input('post.');
        if ($id){
            $info = $info->get($id);
        }
        $post['start_time']=strtotime($post['start_time']);
        $post['end_time']=strtotime($post['end_time']);
        $ret = $info->allowField(true)->save($post);
        if($ret){
            return array(
                'code'=>0,
                'data'=>$info->id,
            );
        }else{
            return array(
                'code'=>1,
                'msg'=>'保存失败',
            );
        }
    }
    //    获取列表页数据
    public function get_list(){
        $model = $this->model;
        //条件
        $query = function ($query){
            //关键字搜索
            $key = input('get.key');
            $type= input('get.type');
            if($_SESSION['admin']['store_id']>0){
                $query->where('store_id',$_SESSION['admin']['store_id']);
            }
            if ($key){
                $query->where('name','like',"%$key%");
            }
            $query->where('is_del',0);
            $query->where('order_lid',1);
            if($type==1){
                $query->where('after_sale',0);
                $query->where('order_status','=',10);
            }else if($type==2){
                $query->where('after_sale',0);
                $query->where('order_status','=',20);
            }else if($type==3){
                $query->where('after_sale',0);
                $query->where('order_status','=',30);
            }else if($type==4){
                $query->where('after_sale',0);
                $query->where('order_status','=',60);
            }else if($type==5){
                $query->where('after_sale',1);
            }else if($type==6){
                $query->where('after_sale',0);
                $query->where('order_status','=',40);
            }
        };

        //排序、分页
        $model->fill_order_limit();

        $list = $model->where($query)->order('id desc')->select();
        foreach ($list as &$item) {
            $store=Db::name('store')->find($item['store_id']);
            $item['store_name']=$store['name'];
            $item['pay_time_d']=$item['pay_time']?date('Y-m-d H:i',$item['pay_time']):'';
            $item['pay_type_z']=$item['pay_type']==1?'微信支付':'余额支付';
            $item['pay_status_z']=$item['pay_status']==1?'已支付':'未支付';
            $item['write_off_time_d']=$item['write_off_time']?date('Y-m-d H:i',$item['write_off_time']):'';

            if($item['after_sale']==1){
                $item['order_status_z']='售后退款';
            }else if($item['order_status']==10){
                $item['order_status_z']='待支付';
            }else  if($item['order_status']==20){
                $item['order_status_z']='待发货(待使用)';
            }else  if($item['order_status']==30){
                $item['order_status_z']='待收货';
            }else  if($item['order_status']>=40){
                $item['order_status_z']='已完成';
            }else  if($item['order_status']==5){
                $item['order_status_z']='已取消';
            }
            $order_detail=Db::name('orderdetail')->where(array('order_id'=>$item['id']))->select();
            $goods='';
            foreach($order_detail as $val){
                $goods.=$val['gname']." ".$val['attr_list']." ".$val['num']."|";
            }
            $item['goods']=$goods;
            if($item['delivery_type']==1){
                $item['delivery_type_z']='快递配送';
            }else if($item['delivery_type']==2){
                $item['delivery_type_z']='到店消费';
            }
        }
        return [
            'code'=>0,
            'count'=>$model->where($query)->count(),
            'data'=>$list,
            'msg'=>'',
        ];
    }
    public function fahuo(){
        $info=$this->model->get(input('get.id'));
      //  $info['address_z']=$info['province'].$info['city'].$info['zip'].$info['address'];
        $order_detail=Db::name('orderdetail')->where(array('order_id'=>input('get.id')))->select();
      /*  $goods='商品名称                      规格                         数量    '."\r\n";
        foreach($order_detail as $val){
            $goods.=$val['gname'].'                       '.$val['attr_list'].'                     '.$val['num']."\r\n";
        }
        $info['goods']=$goods;*/
        $info['detail']=$order_detail;
        if($info['after_sale']==1){
            $info['order_status_z']='售后退款';
        }else if($info['order_status']==10){
            $info['order_status_z']='待支付';
        }else  if($info['order_status']==20){
            $info['order_status_z']='待发货(待使用)';
        }else  if($info['order_status']==30){
            $info['order_status_z']='待收货';
        }else  if($info['order_status']>=40){
            $info['order_status_z']='已完成';
        }else  if($info['order_status']==5){
            $info['order_status_z']='已取消';
        }
        $info['pay_type_z']=$info['pay_type']==1?'微信支付':'余额支付';
        $info['pay_time_d']=date('Y-m-d H:i:s',$info['pay_time']);
        if($info['remark']=='undefined'||$info['remark']==''){
            $info['remark']='暂无留言';
        }
        if($info['delivery_type']==1){
            $info['delivery_type_z']='快递配送';
        }else if($info['delivery_type']==2){
            $info['delivery_type_z']='到店自提';
        }
        $this->view->info=$info;
        return view('fahuo');
    }
    public function fahuo1(){
        $ids=input('request.ids');
        $order=Db::name('order')->find($ids);
        if($order['order_status']!=1){
            return array(
                'code'=>1,
                'msg'=>'发货失败',
            );
        }else{
            $res=Db::name('order')->update(array('id'=>$ids,'order_status'=>2,'fahuo_time'=>time()));
            return array(
                'code'=>0,
                'data'=>$res,
            );

        }
    }
    public function edit(){
        global $_W,$_GPC;
        $this->view->_W = $_W;
        $this->view->_GPC = $_GPC;
        $id = input('get.id');
        $info = $this->model->get($id);
        if($info['remark']=='undefined'||$info['remark']==''){
            $info['remark']='暂无留言';
        }
        $this->view->info = $info;
        return view('edit');
    }
    public function save_fahuo(){
        $info = $this->model;
        $id = input('post.id');
        if ($id){
            $info = $info->get($id);
        }
        if($info['order_status']!=20){
            return array(
                'code'=>1,
                'msg'=>'发货失败',
            );
        }
        $post=input('post.');
        $post['order_status']=30;
        $post['fahuo_time']=time();
        //修改总订单状态
        (new Commonorder())->editCommonOrderStatus(1,$id,30);
        if($info['delivery_type']==2){
            $ret = $info->allowField(true)->save($post);
            //到店消费为确认收货 增加商家金额和商家明细
            $info->confirmOrder($id);
        }else{
            $ret = $info->allowField(true)->save($post);
        }

        if($ret){
            return array(
                'code'=>0,
                'data'=>$info->id,
            );
        }else{
            return array(
                'code'=>1,
                'msg'=>'保存失败',
            );
        }
    }
    //普通订单立即完成
    public function save_finish(){
        $oid=input('post.id');
        $ord=new Order();
        $order=$ord::get($oid);
        if(in_array($order['order_status'],array(10,60))){
            return array(
                'code'=>1,
                'msg'=>'操作失败,订单未支付或已完成不能完成订单',
            );
        }
        //修改订单核销状态和核销数量
        $ret=$ord->allowField(true)->save(['order_status'=>60,'finish_time'=>time(),'write_off_status'=>2,'write_off_num'=>$order['num'],'confirm_time'=>time(),'write_off_time'=>time()],['id'=>$oid]);
        if($order['order_status']==20||$order['order_status']==30){
            //核销完成对商家操作
            $num=$order['num']-$order['write_off_num'];
            $money=sprintf("%.2f",$order['order_amount']/$order['num']*$num);
            (new Store())->setConfirmAfter($order['store_id'],$money,1,$order['id'],$order['order_no'],$order['user_id'],$num);
            //完成订单进行佣金结算
            (new Distributionorder())->setSettlecommission(1,$order['id'],$order['order_no'],$order['store_id']);

            //增加积分
            $Integralrecord=new Integralrecord();
            $score=$Integralrecord->getScore($order['order_amount']);
            if($score>0) {
                $Integralrecord->scoreAct($order['user_id'], 1, $score, $order['id']);
            }
        }
        //修改公共订单
        $comord=new Commonorder();
        $comord->editCommonOrderStatus(1,$oid,60);
        if($ret){
            return array(
                'code'=>0,
            );
        }else{
            return array(
                'code'=>1,
                'msg'=>'操作失败',
            );
        }
    }

    //增加模板消息数据和任务
    private function setTemplateContentAndTask($order,$tid,$page,$form_id,$data){
        $template=Db::name('template')->where(array('uniacid'=>$order['uniacid']))->find();
        $content=array(
            'uniacid'=>$order['uniacid'],
            'touser'=>$order['openid'],
            'template_id'=>$template[$tid],
            'page'=>$page,
            'form_id'=>$form_id,
            'data'=>json_encode($data),
            'create_time'=>time(),
        );
        Db::name('templatecontent')->insert($content);
        $content_id=Db::name('templatecontent')->getLastInsID();
        $task=array(
            'uniacid'=>$order['uniacid'],
            'type'=>'template',
            'state'=>0,
            'level'=>1,
            'value'=>$content_id,
            'create_time'=>time(),
        );
        Db::name('task')->insert($task);
        $task_id=Db::name('task')->getLastInsID();
        Db::name('templatecontent')->update(array('id'=>$content_id,'task_id'=>$task_id));
    }

    public function detail(){
        $info=$this->model->get(input('get.id'));
       // $info['address_z']=$info['province'].$info['city'].$info['zip'].$info['address'];
        $order_detail=Db::name('orderdetail')->where(array('order_id'=>input('get.id')))->select();
      /*  $goods='商品名称                      规格                         数量    '."\r\n";
        foreach($order_detail as $val){
            $goods.=$val['gname'].'                       '.$val['attr_list'].'                     '.$val['num']."\r\n";
        }
        $info['goods']=$goods;*/
        $info['detail']=$order_detail;
        if($info['after_sale']==1){
            $info['order_status_z']='售后退款';
        }else if($info['order_status']==10){
            $info['order_status_z']='待支付';
        }else  if($info['order_status']==20){
            $info['order_status_z']='待发货(待使用)';
        }else  if($info['order_status']==30){
            $info['order_status_z']='待收货';
        }else  if($info['order_status']>=40){
            $info['order_status_z']='已完成';
        }else  if($info['order_status']==5){
            $info['order_status_z']='已取消';
        }
        $info['pay_type_z']=$info['pay_type']==1?'微信支付':'余额支付';
        $info['pay_time_d']=$info['pay_time']?date('Y-m-d H:i:s',$info['pay_time']):'';
        if($info['remark']=='undefined'||$info['remark']==''){
            $info['remark']='暂无留言';
        }
        if($info['delivery_type']==1){
            $info['delivery_type_z']='快递配送';
        }else if($info['delivery_type']==2){
            $info['delivery_type_z']='到店自提';
        }
        $this->view->info=$info;
        return view('edit');
    }
    public function refund(){
        $info=$this->model->get(input('get.id'));
       // $info['address_z']=$info['province'].$info['city'].$info['zip'].$info['address'];
        $order_detail=Db::name('orderdetail')->where(array('order_id'=>input('get.id')))->select();
       /* $goods='商品名称                      规格                         数量    '."\r\n";
        foreach($order_detail as $val){
            $goods.=$val['gname'].'                       '.$val['attr_list'].'                     '.$val['num']."\r\n";
        }
        $info['goods']=$goods;*/
        $info['detail']=$order_detail;
        if($info['after_sale']==1){
            $info['order_status_z']='售后退款';
        }else if($info['order_status']==10){
            $info['order_status_z']='待支付';
        }else  if($info['order_status']==20){
            $info['order_status_z']='待发货(待使用)';
        }else  if($info['order_status']==30){
            $info['order_status_z']='待收货';
        }else  if($info['order_status']>=40){
            $info['order_status_z']='已完成';
        }else  if($info['order_status']==5){
            $info['order_status_z']='已取消';
        }
        $info['pay_type_z']=$info['pay_type']==1?'微信支付':'余额支付';
        $info['pay_time_d']=$info['pay_time']?date('Y-m-d H:i:s',$info['pay_time']):'';
        if($info['remark']=='undefined'||$info['remark']==''){
            $info['remark']='暂无留言';
        }
        if($info['delivery_type']==1){
            $info['delivery_type_z']='快递配送';
        }else if($info['delivery_type']==2){
            $info['delivery_type_z']='到店自提';
        }
        $this->view->info=$info;
        return view('refund');
    }
    //退款
    public function save_refund(){
        $post=input('post.');
        $order=Db::name('order')->find($post['id']);
        if($order['after_sale']!=1||$order['refund_status']==1){
            return array(
                'code'=>1,
                'msg'=>'保存失败',
            );
        }
        if($post['review_status']==1){
            Db::name('order')->update(array('id'=>$post['id'],'review_status'=>1,'review_time'=>time()));
            $order=Db::name('order')->find($post['id']);
            if($order['order_amount']<=0){
                //退款金额0直接退
                Db::name('order')->update(array('id'=>$order['id'],'refund_status'=>1,'refund_time'=>time()));
                //退款成功增加商品和商品规格库存减少商品和商家销量
                (new Order())->afterRefund($order['id']);
                return array(
                    'code'=>0,
                    'data'=>'微信退款成功',
                );
                exit;
            }
            if($order['pay_type']==1){
                $res=$this->wxRefund($order);
                if($res['code']==0){
                    return array(
                        'code'=>0,
                        'data'=>'微信退款成功',
                    );
                }else if($res['code']==1){
                    return array(
                        'code'=>0,
                        'data'=>'微信退款失败,原因:'.$res['msg'],
                    );
                }

            }else if($order['pay_type']==2){
                $this->balanceRefund($order);
                return array(
                    'code'=>0,
                    'data'=>'余额退款成功',
                );
            }

        }else if($post['review_status']==2){
            $res=Db::name('order')->update(array('id'=>$post['id'],'review_status'=>2,'review_time'=>time(),'review_reason'=>$post['review_reason']));
            (new Commonorder())->editCommonOrderStatus(1,$post['id'],53);
            return array(
                'code'=>0,
                'data'=>$res,
            );
        }

    }
    //余额退款
    private function  balanceRefund($order){
        //增加退款记录、修改用户金额和增加用户余额变动记录
        if($order['order_status']==20&&$order['review_status']==1&&$order['refund_status']==0&&$order['after_sale']==1){
            $refund=array(
                'uniacid'=>$order['uniacid'],
                'store_id'=>$order['store_id'],
                'order_id'=>$order['id'],
                'refund_type'=>2,
                'order_refund_no'=>date("YmdHis") .rand(11111, 99999),
                'type'=>1,
                'refund_price'=>$order['order_amount'],
                'create_time'=>time(),
                'refund_status'=>1,
                'refund_time'=>time()
            );
            Db::name('orderrefund')->insert($refund);
            $remark="订单退款增加￥".$order['order_amount'];
            $Userbalancerecord=new Userbalancerecord();
            $Userbalancerecord->editBalance($order['user_id'],$order['order_amount']);
            $Userbalancerecord->addBalanceRecord($order['user_id'],$order['uniacid'],3,0,$order['order_amount'],$order['id'],$order['order_no'],$remark);
            Db::name('order')->update(array('id'=>$order['id'],'refund_status'=>1,'refund_time'=>time(),'tuikuanformid'=>$refund['order_refund_no']));
            //退款成功增加商品和商品规格库存减少商品和商家销量
            (new Order())->afterRefund($order['id']);
            (new Commonorder())->editCommonOrderStatus(1,$order['id'],51);

        }
    }
    //微信退款
    private function wxRefund($order){
         if($order['after_sale']==1&&$order['pay_type']==1&&$order['refund_status']!=1){
              //增加退款记录
             $refund=array(
                 'uniacid'=>$order['uniacid'],
                 'store_id'=>$order['store_id'],
                 'order_id'=>$order['id'],
                 'refund_type'=>1,
                 'order_refund_no'=>date("YmdHis") .rand(11111, 99999),
                 'type'=>1,
                 'refund_price'=>$order['order_amount'],
                 'create_time'=>time(),
                 'refund_status'=>0,
             );
             Db::name('orderrefund')->insert($refund);
             $refund_id=Db::name('orderrefund')->getLastInsID();
             if($order['order_union_id']>0){
                 $orderunion=Db::name('orderunion')->find($order['order_union_id']);
                 $order['order_no']=$orderunion['order_no'];
                 $order['money']=$orderunion['money'];
             }else{
                 $order['money']=$order['order_amount'];
             }
             $xml=$this->getRefundXml($order,$refund['order_refund_no']);
             $data=xml2array($xml);
             if($data['return_code']=='SUCCESS'&&$data['result_code']=='SUCCESS'){
                 Db::name('orderrefund')->update(array('id'=>$refund_id,'refund_status'=>1,'refund_time'=>time(),'xml'=>$xml));
                 Db::name('order')->update(array('id'=>$order['id'],'refund_status'=>1,'refund_time'=>time()));
                 //退款成功增加商品和商品规格库存减少商品和商家销量
                 (new Order())->afterRefund($order['id']);
                 (new Commonorder())->editCommonOrderStatus(1,$order['id'],51);
                 return array('code'=>0);
             }else{
                 Db::name('orderrefund')->update(array('id'=>$refund_id,'refund_status'=>2,'err_code'=>$data['err_code'],'err_code_dec'=>$data['err_code_des'],'xml'=>$xml));
                 Db::name('order')->update(array('id'=>$order['id'],'refund_status'=>2));
                 (new Commonorder())->editCommonOrderStatus(1,$order['id'],52);
                 return array('code'=>1,'msg'=>$data['err_code_des']);
             }
         }
    }
    //获取微信退款报文信息
    private function getRefundXml($order,$out_refund_no){
        $system=Db::name('system')->where(array('uniacid'=>$order['uniacid']))->find();
        $data['appid'] =$system['appid'];
        $data['mch_id'] =$system['mchid'];
        $data['nonce_str']=createNoncestr();
        $data['out_trade_no']=$order['order_no'];
        $data['out_refund_no']=$out_refund_no;
        $data['total_fee']=sprintf("%.0f",$order['money']*100);
        $data['refund_fee']=sprintf("%.0f",$order['order_amount']*100);
        $data['sign']=getSign($data,$system['wxkey']);
        $xml=postXmlCurl($data,$order['uniacid']);
        return $xml;
    }

    //TODO::抢购订单
    public function panicorder(){
        global $_W,$_GPC;
        $this->view->_W = $_W;
        $this->view->_GPC = $_GPC;
        return view();
    }
    public  function allpanicgoods(){
        $model = new Panic();
        $model->where(['is_del'=>0])->field("id,name as text");
        if($_SESSION['admin']['store_id']>0){
            $model->where(['store_id'=>$_SESSION['admin']['store_id']]);
        }
        $list = $model->select();
        return $list;
    }
    public function get_panic_list(){
        $model = new Panicorder();
        //条件
        $query = function ($query){
            //关键字搜索
            $key = input('get.key');
            $type= input('get.type');
            if($_SESSION['admin']['store_id']>0){
                $query->where('store_id',$_SESSION['admin']['store_id']);
            }
            if ($key){
                $query->where('order_no','like',"%$key%");
            }
            $goods_id=input('get.goods_id');
            if ($goods_id){
                $query->where('pid',$goods_id);
            }
            $query->where('is_del',0);

            if($type==1){
                $query->where('after_sale',0);
                $query->where('order_status','=',10);
            }else if($type==2){
                $query->where('after_sale',0);
                $query->where('order_status','=',20);
            }else if($type==3){
                $query->where('after_sale',0);
                $query->where('order_status','=',30);
            }else if($type==4){
                $query->where('after_sale',0);
                $query->where('order_status','=',40);
            }else if($type==5){
                $query->where('after_sale',0);
                $query->where('order_status','=',60);
            }else if($type==6){
                $query->where('after_sale','>', 0);
            }
        };

        //排序、分页
        $model->fill_order_limit();

        $list = $model->where($query)->order('id desc')->select();
        foreach ($list as $key=>$value) {
            $list[$key]['gname']=Panic::get($value['pid'])['name'];
            $list[$key]['attr_list'] =$value['attr_list']?substr($value['attr_list'],1,-1):'单规格';
        }
        return [
            'code'=>0,
            'count'=>$model->where($query)->count(),
            'data'=>$list,
            'msg'=>'',
        ];
    }
    public function seepanic(){
        global $_W,$_GPC;
        $this->view->_W = $_W;
        $this->view->_GPC = $_GPC;
        $id=input('get.id');
        $info=Panicorder::get($id);
        $info['gname']=Panic::get($info['pid'])['name'];
        $info['username']=\app\model\User::get($info['user_id'])['nickname'];
        $info['attr_list'] =$info['attr_list']?substr($info['attr_list'],1,-1):'单规格';
        $info['pay_time']=$info['pay_time']?date('Y-m-d H:i:s',$info['pay_time']):'';
        $info['write_off_time']= $info['write_off_time']?date('Y-m-d H:i:s',$info['write_off_time']):'';
        $info['refund_time']=$info['refund_time']?date('Y-m-d H:i:s',$info['refund_time']):'';
        $info['finish_time']=$info['finish_time']?date('Y-m-d H:i:s',$info['finish_time']):'';
        $this->view->info = $info;
        return view();
    }

    //TODO::立即完成
    public function panicFinish(){
        $oid=input('post.id');
        $ord=new Panicorder();
        $orderinfo=Panicorder::get($oid);
        if($orderinfo['order_status']==20){
            $data=['order_status'=>60,'finish_time'=>time(),'write_off_status'=>3,'write_off_num'=>$orderinfo['num'],'write_off_time'=>time()];
        }else{
            $data=['order_status'=>60,'finish_time'=>time()];
        }
        $ret=$ord->allowField(true)->save($data,['id' => $oid]);
        //修改公共订单
        $comord=new Commonorder();
        $comord->editCommonOrderStatus(2,$oid,60);
        //商家费用结算
        if ($orderinfo['order_status']==20){
            if($orderinfo['write_off_num']==0){
                (new Store())->setConfirmAfter($orderinfo['store_id'],sprintf("%.2f", ($orderinfo['order_amount'])),2,$orderinfo['id'],$orderinfo['order_no'],$orderinfo['user_id'],$orderinfo['num']);
            }else{
                $num=$orderinfo['num']-$orderinfo['write_off_num'];
                (new Store())->setConfirmAfter($orderinfo['store_id'],sprintf("%.2f", ($orderinfo['order_amount']/$orderinfo['num']*$num)),2,$orderinfo['id'],$orderinfo['order_no'],$orderinfo['user_id'],$num);
            }
            //完成订单进行佣金结算
            (new Distributionorder())->setSettlecommission(2,$orderinfo['id'],$orderinfo['order_no'],$orderinfo['store_id']);

            //增加积分
            $Integralrecord=new Integralrecord();
            $score=$Integralrecord->getScore($orderinfo['order_amount']);
            if($score>0) {
                $Integralrecord->scoreAct($orderinfo['user_id'], 1, $score, $orderinfo['id']);
            }
        }
        if($ret){
            return array(
                'code'=>0,
            );
        }else{
            return array(
                'code'=>1,
                'msg'=>'操作失败',
            );
        }
    }
    //TODO::退款
    public function panicRefund(){
        $oid=input('post.id');
        $ord=new Panicorder();
        $orderinfo=Panicorder::get($oid);
        $refundinfo=Panicrefund::get(['order_id'=>$oid]);
        $ref=new Panicrefund();
        if($orderinfo['pay_type']==1){
            if($refundinfo['refund_status']==1){
                if($refundinfo['refund_price']>0){
                    //退款至微信
                    $ref->refundWechat($orderinfo);
                }else{
                    //免费直接退款成功
                    $ref->refundSuccess($oid);
                    return array('code'=>0, 'msg'=>'退款成功',);
                }
            }else{
                return array('code'=>1, 'msg'=>'当前订单无法退款',);
            }
        }else if($orderinfo['pay_type']==2){
            //余额退款
            if($refundinfo['refund_price']<=0){
                $ref->refundSuccess($oid);
            }else{
                $ref->refundSuccess($oid,'',2);
            }
            return array('code'=>0, 'msg'=>'退款成功');
        }

    }
    //TODO::拒绝退款
    public function panicRefuseRefund(){
        $oid=input('post.id');
        $fail_reason=input('post.fail_reason');
//        var_dump($oid,$fail_reason);exit;
        $ord=new Panicorder();
        $ret=$ord->allowField(true)->save(['refund_status'=>4,'refund_time'=>time(),'fail_reason'=>$fail_reason,'after_sale'=>0],['id' => $oid]);
        //修改退款订单
        Panicrefund::update(['refund_status'=>4,'refund_time'=>time(),'fail_reason'=>$fail_reason],['order_id'=>$oid]);
        //修改公共订单 50申请售后 51 已退款 52 退款失败 53 拒绝退款
        $comord=new Commonorder();
        $comord->editCommonOrderStatus(2,$oid,53);
        if($ret){
            return array(
                'code'=>0,
            );
        }else{
            return array(
                'code'=>1,
                'msg'=>'操作失败',
            );
        }
    }
}
