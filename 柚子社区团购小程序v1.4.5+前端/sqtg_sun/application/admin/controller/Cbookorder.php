<?php
namespace app\admin\controller;

use app\base\controller\Admin;
use Think\Db;
use app\model\Userbalancerecord;
use app\model\Order;


class Cbookorder extends Admin
{
    public function __construct()
    {
        parent::__construct();
    }


    public function save(){
        $info = new order();
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
        $model = new Order();
        //条件
        $query = function ($query){
            //关键字搜索
            $key = input('get.key');
            $type= input('get.type');
            $query->where('store_id',$_SESSION['admin']['store_id']);
            if ($key){
                $query->where('name','like',"%$key%");
            }
            $query->where('order_lid',2);
            if($type==1){
                $query->where('order_status','=',0);
            }else if($type==2){
                $query->where('order_status','=',1);
            }else if($type==3){
                $query->where('order_status','=',2);
            }else if($type==4){
                $query->where('order_status','=',3);
            }else if($type==5){
                $query->where('order_status','=',5);
            }
        };

        //排序、分页
        $model->fill_order_limit();

        $list = $model->where($query)->order('id desc')->select();
        foreach ($list as &$item) {
            $item['pay_time_d']=$item['pay_time']?date('Y-m-d H:i',$item['pay_time']):'';
            $item['pay_type_z']=$item['pay_type']==1?'微信支付':'余额支付';
            $item['pay_status_z']=$item['pay_status']==1?'已支付':'未支付';
            if($item['order_status']==0){
                $item['order_status_z']='待支付';
            }else  if($item['order_status']==1){
                $item['order_status_z']='待发货';
            }else  if($item['order_status']==2){
                $item['order_status_z']='待收货';
            }else  if($item['order_status']==3){
                $item['order_status_z']='已完成';
            }else  if($item['order_status']==4){
                $item['order_status_z']='已取消';
            }else if($item['order_status']==5){
                $item['order_status_z']='售后退款';
            }
            $order_detail=Db::name('orderdetail')->where(array('order_id'=>$item['id']))->select();
            $goods='';
            foreach($order_detail as $val){
                $goods.=$val['gname']." ".$val['attr_list']." ".$val['num']."|";
            }
            $item['goods']=$goods;
            if($item['sincetype']==1){
                $item['sincetype_z']='快递配送';
            }else if($item['sincetype']==2){
                $item['sincetype_z']='到店自提';
            }
            $shop=Db::name('shop')->find($item['shop_id']);
            $item['book_shop']=$shop['name'];
        }
        return [
            'code'=>0,
            'count'=>$model->where($query)->count(),
            'data'=>$list,
            'msg'=>'',
        ];
    }
    public function fahuo(){
        $model=new Order();
        $info=$model->get(input('get.id'));
        $info['address_z']=$info['province'].$info['city'].$info['zip'].$info['address'];
        $order_detail=Db::name('orderdetail')->where(array('order_id'=>input('get.id')))->select();
      /*  $goods='商品名称                      规格                         数量    '."\r\n";
        foreach($order_detail as $val){
            $goods.=$val['gname'].'                       '.$val['attr_list'].'                     '.$val['num']."\r\n";
        }
        $info['goods']=$goods;*/
        $info['detail']=$order_detail;
        if($info['order_status']==0){
            $info['order_status_z']='待支付';
        }else  if($info['order_status']==1){
            $info['order_status_z']='待发货';
        }else  if($info['order_status']==2){
            $info['order_status_z']='待收货';
        }else  if($info['order_status']==3){
            $info['order_status_z']='已完成';
        }else  if($info['order_status']==4){
            $info['order_status_z']='已取消';
        }else if($info['order_status']==5){
            $info['order_status_z']='售后退款';
        }
        $info['pay_type_z']=$info['pay_type']==1?'微信支付':'余额支付';
        $info['pay_time_d']=date('Y-m-d H:i:s',$info['pay_time']);
        if($info['remark']=='undefined'||$info['remark']==''){
            $info['remark']='暂无留言';
        }
        if($info['sincetype']==1){
            $info['sincetype_z']='快递配送';
        }else if($info['sincetype']==2){
            $info['sincetype_z']='到店自提';
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
        $model=new Order();
        $info = $model->get($id);
        if($info['remark']=='undefined'||$info['remark']==''){
            $info['remark']='暂无留言';
        }
        $this->view->info = $info;
        return view('edit');
    }
    public function save_fahuo(){
        $info =new Order();
        $id = input('post.id');
        if ($id){
            $info = $info->get($id);
        }
        if($info['order_status']!=1){
            return array(
                'code'=>1,
                'msg'=>'发货失败',
            );
        }
        $post=input('post.');
        $post['order_status']=2;
        $post['fahuo_time']=time();
        $ret = $info->allowField(true)->save($post);
/*
        $order=Db::name('order')->find($id);
        $page="/sqtg_sun/pages/hqs/pages/orderdetail/orderdetail?id={$order['id']}";
        $address=$order['province'].$order['city'].$order['zip'].$order['address'];
        $data1=array(
            'keyword1'=>array('value'=>$order['orderformid'],'color'=>'173177'),
            'keyword2'=>array('value'=>$post['express_delivery'],'color'=>'173177'),
            'keyword3'=>array('value'=>$post['express_no'],'color'=>'173177'),
            'keyword4'=>array('value'=>$address,'color'=>'173177'),
            'keyword5'=>array('value'=>'已发货','color'=>'173177'),
        );
        $this->setTemplateContentAndTask($order,'tid3',$page,$order['prepay_id'],$data1);*/
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
        $model=new Order();
        $info=$model->get(input('get.id'));
        $info['address_z']=$info['province'].$info['city'].$info['zip'].$info['address'];
        $order_detail=Db::name('orderdetail')->where(array('order_id'=>input('get.id')))->select();
      /*  $goods='商品名称                      规格                         数量    '."\r\n";
        foreach($order_detail as $val){
            $goods.=$val['gname'].'                       '.$val['attr_list'].'                     '.$val['num']."\r\n";
        }
        $info['goods']=$goods;*/
        $info['detail']=$order_detail;
        if($info['order_status']==0){
            $info['order_status_z']='待支付';
        }else  if($info['order_status']==1){
            $info['order_status_z']='待发货';
        }else  if($info['order_status']==2){
            $info['order_status_z']='待收货';
        }else  if($info['order_status']==3){
            $info['order_status_z']='已完成';
        }else  if($info['order_status']==4){
            $info['order_status_z']='已取消';
        }else if($info['order_status']==5){
            $info['order_status_z']='售后退款';
        }
        $info['pay_type_z']=$info['pay_type']==1?'微信支付':'余额支付';
        $info['pay_time_d']=$info['pay_time']?date('Y-m-d H:i:s',$info['pay_time']):'';
        if($info['remark']=='undefined'||$info['remark']==''){
            $info['remark']='暂无留言';
        }
        if($info['sincetype']==1){
            $info['sincetype_z']='快递配送';
        }else if($info['sincetype']==2){
            $info['sincetype_z']='到店自提';
        }
        $info['shop']=Db::name('shop')->find($info['shop_id']);
        $this->view->info=$info;
        return view('edit');
    }
    public function refund(){
        $model=new Order();
        $info=$model->get(input('get.id'));
        $info['address_z']=$info['province'].$info['city'].$info['zip'].$info['address'];
        $order_detail=Db::name('orderdetail')->where(array('order_id'=>input('get.id')))->select();
       /* $goods='商品名称                      规格                         数量    '."\r\n";
        foreach($order_detail as $val){
            $goods.=$val['gname'].'                       '.$val['attr_list'].'                     '.$val['num']."\r\n";
        }
        $info['goods']=$goods;*/
        $info['detail']=$order_detail;
        if($info['order_status']==0){
            $info['order_status_z']='待支付';
        }else  if($info['order_status']==1){
            $info['order_status_z']='待发货';
        }else  if($info['order_status']==2){
            $info['order_status_z']='待收货';
        }else  if($info['order_status']==3){
            $info['order_status_z']='已完成';
        }else  if($info['order_status']==4){
            $info['order_status_z']='已取消';
        }else if($info['order_status']==5){
            $info['order_status_z']='售后退款';
        }
        $info['pay_type_z']=$info['pay_type']==1?'微信支付':'余额支付';
        $info['pay_time_d']=$info['pay_time']?date('Y-m-d H:i:s',$info['pay_time']):'';
        if($info['remark']=='undefined'||$info['remark']==''){
            $info['remark']='暂无留言';
        }
        if($info['sincetype']==1){
            $info['sincetype_z']='快递配送';
        }else if($info['sincetype']==2){
            $info['sincetype_z']='到店自提';
        }
        $info['shop']=Db::name('shop')->find($info['shop_id']);
        $this->view->info=$info;
        return view('refund');
    }
    //退款
    public function save_refund(){
        $post=input('post.');
        $order=Db::name('order')->find($post['id']);
        if($order['order_status']!=5||$order['refund_status']==1){
            return array(
                'code'=>1,
                'msg'=>'保存失败',
            );
        }
        if($post['review_status']==1){
            Db::name('order')->update(array('id'=>$post['id'],'review_status'=>1,'review_time'=>time()));
            $order=Db::name('order')->find($post['id']);
            if($order['pay_type']==1){
                $this->wxRefund($order);
                return array(
                    'code'=>0,
                    'data'=>'微信退款成功',
                );
            }else if($order['pay_type']==2){
                $this->balanceRefund($order);
                return array(
                    'code'=>0,
                    'data'=>'余额退款成功',
                );
            }

        }else if($post['review_status']==2){
            $res=Db::name('order')->update(array('id'=>$post['id'],'review_status'=>2,'review_time'=>time(),'review_reason'=>$post['review_reason']));
            return array(
                'code'=>0,
                'data'=>$res,
            );
        }

    }
    //余额退款
    private function balanceRefund($order){
        //增加退款记录、修改用户金额和增加用户余额变动记录
        if($order['order_status']==5&&$order['review_status']==1&&$order['refund_status']==0){
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
            $Userbalancerecord->addBalanceRecord($order['user_id'],$order['uniacid'],3,0,$order['order_amount'],$order['order_id'],$order['orderformid'],$remark);
            Db::name('order')->update(array('id'=>$order['id'],'refund_status'=>1,'refund_time'=>time(),'tuikuanformid'=>$refund['order_refund_no']));
       }
    }
    //微信退款
    private function wxRefund($order){
         if($order['order_status']==5&&$order['pay_type']==1&&$order['refund_status']!=1){
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
                 $order['orderformid']=$orderunion['order_no'];
                 $order['money']=$orderunion['money'];
             }else{
                 $order['money']=$order['order_amount'];
             }
             $xml=$this->getRefundXml($order,$refund['order_refund_no']);
             $data=xml2array($xml);
             if($data['return_code']=='SUCCESS'&&$data['result_code']=='SUCCESS'){
                 Db::name('orderrefund')->update(array('id'=>$refund_id,'refund_status'=>1,'refund_time'=>time(),'xml'=>$xml));
                 Db::name('order')->update(array('id'=>$order['id'],'refund_status'=>1,'refund_time'=>time()));
             }else{
                 Db::name('orderrefund')->update(array('id'=>$refund_id,'refund_status'=>2,'err_code'=>$data['err_code'],'err_code_dec'=>$data['err_code_des'],'xml'=>$xml));
                 Db::name('order')->update(array('id'=>$order['id'],'refund_status'=>2));
             }
         }
    }
    //获取微信退款报文信息
    private function getRefundXml($order,$out_refund_no){
        $system=Db::name('system')->where(array('uniacid'=>$order['uniacid']))->find();
        $data['appid'] =$system['appid'];
        $data['mch_id'] =$system['mchid'];
        $data['nonce_str']=createNoncestr();
        $data['out_trade_no']=$order['orderformid'];
        $data['out_refund_no']=$out_refund_no;
        $data['total_fee']=intval($order['money']*100);
        $data['refund_fee']=intval($order['order_amount']*100);
        $data['sign']=getSign($data,$system['wxkey']);
        $xml=postXmlCurl($data,$order['uniacid']);
        return $xml;
    }

}
