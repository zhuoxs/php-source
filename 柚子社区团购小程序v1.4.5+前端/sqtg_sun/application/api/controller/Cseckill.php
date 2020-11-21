<?php
namespace app\api\controller;
use app\base\controller\Api;
use \app\model\Ad;
use app\model\Comment;
use app\model\Seckillgoods;
use app\model\Seckillgoodsattrsetting;
use app\model\Seckillorder;
use app\model\Seckilltopic;
use app\model\Seckilltopicplan;
use think\Db;

class Cseckill extends Api
{
//    //////////////////////////////////////////////////公共接口
//    获取订单详情
    public function getOrder(){
        $order_id = input("request.order_id");
        $order = Seckillorder::get($order_id,'details');
        success_withimg_json($order);
    }
//    //////////////////////////////////////////////////用户接口
//    获取今日专题
    public function getTodayTopic(){
        $data = [];

        //        轮播图
        $ad = new Ad();
        $ad->fill_order_limit(true,false);
        $data['swipers'] = $ad->isUsed()
            ->where('type',7)->select();

        $plan = Seckilltopicplan::get(['year'=>date('Y'),'month'=>date('m'),'day'=>date('d')]);

        $data['topic'] = Seckilltopic::get($plan['seckilltopic_id'],['seckillmeetings']);

        foreach ($data['topic']['seckillmeetings'] as &$seckillmeeting) {
            $seckillmeeting['hours'] = $seckillmeeting['hours']?explode(',',$seckillmeeting['hours']):[];
        }

        success_withimg_json($data);
    }
//    获取会场某时间点商品
//    传入：
//          seckillmeeting_id:会场id
//          hour:小时
//          page:第几页
//          limit:每页数据量
    public function getMeetingGoodses(){
        //条件
        $query = function ($query){
            $query->where('state',1);
            $query->where('check_state = 2 or store_id = 0');
            //关键字搜索
            $seckillmeeting_id = input('request.seckillmeeting_id',0);
            if($seckillmeeting_id){
                $query->where('seckillmeeting_id',$seckillmeeting_id);
            }
            $store_id = input('request.store_id',0);
            if($store_id){
                $query->where('store_id',$store_id);
            }
            $hour = input('request.hour',0);
            $query->where('hour',$hour);
        };

//        查询数据
        $goods_model = new Seckillgoods();
        $goods_model->fill_order_limit();//分页，排序
        $list = $goods_model->field('*,sales_num+virtual_num as sales_num2')->where($query)->with('store')->select();
        foreach ($list as &$item) {
            if ($item->use_attr){
                $item->price = Db::name('seckillgoodsattrsetting')
                    ->where('seckillgoods_id',$item->id)
                    ->where('goods_id',$item->goods_id)
                    ->min('price');

                $item->stock = Db::name('seckillgoodsattrsetting')
                    ->where('seckillgoods_id',$item->id)
                    ->where('goods_id',$item->goods_id)
                    ->sum('stock');
            }

            $item->original_price = Db::name('goods')
                ->where('id',$item->goods_id)
                ->max('price');
        }

        success_withimg_json($list);
    }
//    获取秒杀商品详情
//    传入
//        seckillgoods_id: 秒杀商品id
    public function getGoods(){
        $id=input('request.seckillgoods_id');

        $cond=array(
            'id'=>$id,
        );
        $goods_model = new Seckillgoods();
        $goods=$goods_model->with(['attr_group_list','store'])->where($cond)->find();

        if ($goods->use_attr){
            $goods->price = Db::name('seckillgoodsattrsetting')
                ->where('seckillgoods_id',$goods->id)
                ->where('goods_id',$goods->goods_id)
                ->min('price');

            $goods->stock = Db::name('seckillgoodsattrsetting')
                ->where('seckillgoods_id',$goods->id)
                ->where('goods_id',$goods->goods_id)
                ->sum('stock');
        }

        $goods->original_price = Db::name('goods')
            ->where('id',$goods->goods_id)
            ->max('price');

        $goods['pics']=json_decode($goods['pics']);

        success_withimg_json($goods);
    }
    //获取选完规格后商品信息
    public function getAttrInfo(){
        $attr_ids = input('request.attr_ids');
        $data = Seckillgoodsattrsetting::get(['attr_ids'=>$attr_ids]);
        success_withimg_json($data);
    }

//    添加订单
    public function addOrder(){
        $data = input('request.');
        Db::startTrans();
        try{
            $id = Seckillorder::insertDb($data);
            Db::commit();
        }catch (\Exception $e){
            Db::rollback();
            error_json($e->getMessage());
        }

        $this->payOrder1($id,$data);

        success_json($id);
    }
    protected function payOrder1($order_id,$data){
        if (!$order_id){
            $order_id = input('request.order_id',0);
            $data = input("request.");
        }
        Db::startTrans();
        try{
            $ret = Seckillorder::pay($order_id,$data);
            if ($ret && $data['pay_type'] == 2){
                $this->payNotify([
                    'attach'=>json_encode([
                        'seckillorder_id'=>$order_id,
                    ])
                ],2);
            }
            Db::commit();
            if ($data['pay_type'] == 1){
                success_json(['paydata'=>$ret]);
            }else{
                success_json();
            }
        }catch (\Exception $e){
            Db::rollback();
            error_json($e->getMessage());
        }
    }
//    订单支付
    public function payOrder(){
        $order_id = input('request.order_id',0);
        $data = input("request.");
        $this->payOrder1($order_id,$data);
    }
//    支付回调
    public function payNotify($data,$pay_type = 1){
        $attach=json_decode($data['attach'],true);
        $seckillorder = Seckillorder::get($attach['seckillorder_id']);


        $ret = $seckillorder->save([
            'pay_type'=>$pay_type,
            'pay_status'=>1,
            'pay_time'=>time(),
            'order_status'=>$seckillorder['sincetype'] == 2 ? 2 : 1,//自提订单，自付后转待收货
        ]);
        if ($pay_type==2){
            return true;
        }
        if($ret){
            echo 'SUCCESS';
        }else{
            echo 'FAIL';
        }
    }
//    获取运费
    public function getDistribution(){
        $province = input('request.province');
        $city = input('request.city');
        $postagerules_id = input('request.postagerules_id');
        $number = input('request.num');
        $weight = input('request.weight');

        $distribution = Index::getDistribution($province,$city,$postagerules_id,$weight,$number);
        success_json($distribution?:0);
    }
    //    获取秒杀订单状态表
    public function getOrderStates(){
        $data = [
            [
                'state'=>0,
                'text'=>'全部',
            ],
            [
                'state'=>6,
                'text'=>'待支付',
            ],
            [
                'state'=>1,
                'text'=>'待发货',
            ],
            [
                'state'=>2,
                'text'=>'待收货',
            ],
            [
                'state'=>3,
                'text'=>'已完成',
            ],
            [
                'state'=>4,
                'text'=>'已取消',
            ],
//            [
//                'state'=>5,
//                'text'=>'售后',
//            ],
        ];
        success_json($data);
    }
//    获取秒杀订单
//    传入：
//        user_id:用户id
    public function getOrders(){
        //条件
        $query = function ($query){
            $user_id = input("request.user_id");
            $query->where('user_id',$user_id);
            $query->where('del_status',0);
            //关键字搜索
            $state = input('request.state',0);
            if ($state == 6){
                $query->where('order_status',0);
                $query->where('pay_status',0);
            }
            else if ($state){
                $query->where('order_status',$state)
                    ->where('pay_status',1);
            }
        };

//        查询数据
        $order_model = new Seckillorder();
        $order_model->fill_order_limit();//分页，排序
        $list = $order_model->where($query)->with('details')->order('create_time','desc')->select();

        success_withimg_json($list);
    }
//    订单取消
    public function cancelOrder(){
        $order_id = input("request.order_id");
        $ret = Seckillorder::cancel($order_id);
        if ($ret){
            success_json();
        }else{
            error_json('取消失败');
        }
    }
//    删除订单
    public function deleteOrder(){
        $order_id = input("request.order_id");
        $order = Seckillorder::get($order_id);

        $ret = $order->save(['del_status'=>1,'del_time'=>time()]);
        if ($ret){
            success_json();
        }else{
            error_json('删除失败');
        }
    }
//    确认收货
    public function confirmOrder(){
        $order_id = input("request.order_id");
        $ret = Seckillorder::confirm($order_id);
        if ($ret){
            success_json();
        }else{
            error_json('确认失败');
        }
    }

//    添加评论
    public function addComment(){
        $data = input('request.');
        $data['type']=3;

        $order = Seckillorder::get($data['order_id']);
        if ($order['order_status'] != 3){
            error_json('未完成订单不能评论');
        }

        $order->is_pingjia = 1;
        $order->save();

        $comment_model = new Comment();
        $ret = $comment_model->allowField(true)->save($data);
        if ($ret){
            success_json($comment_model->id);
        }else{
            error_json('评论失败，请重新提交');
        }
    }

//    //////////////////////////////////////////////////商家接口
    //    获取商家秒杀订单状态表
    public function getStoreOrderStates(){
        $data = [
            [
                'state'=>0,
                'text'=>'全部',
            ],
            [
                'state'=>6,
                'text'=>'待支付',
            ],
            [
                'state'=>1,
                'text'=>'待发货',
            ],
            [
                'state'=>2,
                'text'=>'待收货',
            ],
            [
                'state'=>3,
                'text'=>'已完成',
            ],
//            [
//                'state'=>4,
//                'text'=>'已取消',
//            ],
//            [
//                'state'=>5,
//                'text'=>'售后',
//            ],
        ];
        success_json($data);
    }
//    获取秒杀订单
//    传入：
//        store_id:商家id
    public function getStoreOrders(){
        //条件
        $query = function ($query){
            $store_id = input("request.store_id");
            $query->where('store_id',$store_id);
            //关键字搜索
            $state = input('request.state',0);
            if ($state == 6){
                $query->where('order_status',0);
                $query->where('pay_status',0);
            }
            else if ($state){
                $query->where('order_status',$state)
                    ->where('pay_status',1);
            }
        };

//        查询数据
        $order_model = new Seckillorder();
        $order_model->fill_order_limit();//分页，排序
        $list = $order_model->where($query)->with('details')->order('create_time','desc')->select();

        success_withimg_json($list);
    }
    //    核销订单
    public function verifyOrder(){
        $order_id = input("request.order_id");
        $store_id = input("request.store_id");

        $order = Seckillorder::get($order_id);

        if ($order['store_id'] != $store_id){
            error_json('您不能核销该订单');
        }

        if ($order['sincetype'] != 2){
            error_json('配送订单不能核销');
        }

        if ($order['order_status'] != 2){
            error_json('该订单状态不支持核销');
        }

        $ret = Seckillorder::confirm($order_id);
        if ($ret){
            success_json();
        }else{
            error_json('核销失败');
        }
    }
}
