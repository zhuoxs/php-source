<?php
namespace app\admin\controller;

use app\base\controller\Admin;
use app\model\Order;
use app\model\Ordergoods;
use app\model\Deliveryordergoods;
use app\model\Payrecord;

class Cordergoods extends Admin
{
//    团长明细
    public function index2()
    {
        global $_W,$_GPC;
        $this->view->_W = $_W;
        $this->view->_GPC = $_GPC;
        return view();
    }
    //    用户订单明细：获取列表页数据
    public function get_list(){
        $getModel = function (){
            $key = input('get.key','');
            $store_query=function($q){
                if($_SESSION['admin']['store_id']>0){
                    $q->where('t1.store_id',$_SESSION['admin']['store_id']);
                }else{
                    $store_id = input('request.store_id',-1);
                    if($store_id!=-1){
                        $q->where('store_id',$store_id);
                    }
                }
            };

            $model = Ordergoods::with('store')->where($store_query)
                ->alias('t1')
                ->join('order t2','t2.id = t1.order_id','left')
                ->join('user t3','t3.id = t1.user_id','left')
                ->join('leader t4','t4.id = t1.leader_id','left')
//                ->join('store t5','t5.id = t1.store_id')
                ->where('t1.goods_name|t1.attr_names|t2.order_no|t3.name|t4.name','like',"%$key%");

            $state = input('get.state',0);
            if($state){
                $model->where('t1.state',$state);
            }else{
                $model->whereNotIn('t1.state',[-10]);
            }

            $check_state = input('get.check_state',0);
            if($check_state){
                $model->where('t1.check_state',$check_state);
            }

            $user_id = input('get.user_id',0);
            if($user_id){
                $model->where('t1.user_id',$user_id);
            }

            $leader_id = input('get.leader_id',0);
            if($leader_id){
                $model->where('t1.leader_id',$leader_id);
            }

            $begin_time = input('get.begin_time','');
            if ($begin_time){
                $model->where('t1.create_time >= ' . strtotime($begin_time));
            }

            $end_time = input('get.end_time','');
            if ($end_time){
                $end_time = strtotime($end_time);
                $model->where('t1.create_time <= ' . $end_time);
            }

            //排除软删除
            $model->where('del',0);

            return $model;
        };

        $model = $getModel();
        //分页
        $page = input('request.page',1);
        $limit = input('request.limit',10);
        if($page){
            $model->limit($limit)->page($page);
        }
        //排序
        $order = input('request.orderfield');
        if($order){
            $model->order('t1.'.$order,strtolower(input('request.ordertype')) == "desc"?"DESC":"");
        }else{
            $model->order('t1.create_time desc');
        }

        $list = $model
            ->field('t1.*,t4.name as leader_name,t3.name,t3.img,t2.order_no as order_no,FROM_UNIXTIME(t2.create_time,\'%Y-%m-%d %T\') as order_time,t2.pay_amount as order_pay_amount,t2.coupon_money as order_coupon_money,t3.id as user_id,t3.tel,t2.id as order_id,t2.comment,t2.pay_type')
            ->select();
        $sql = $model->getLastSql();
        $mergeInfo = [
            0=>'否',
            1=>'是'
        ];
        foreach ($list as &$item) {
            $payrecords = Payrecord::where('source_id',$item['order_id'])
                ->where("source_type = 'Order'")
                ->order('callback_time desc,id desc')
                ->select();
            if(count($payrecords)){
                $item['pay_no'] = $payrecords[0]['no'];
            }
            $item['merge'] = $mergeInfo[$item['merge']];
        }

        return [
            'code'=>0,
            'count'=>$getModel()->count(),
            'data'=>$list,
            'msg'=>$sql,
        ];
    }
    public function outCSV(){
        $getModel = function (){
            $key = input('get.key','');
            $store_query=function($q){
                if($_SESSION['admin']['store_id']>0){
                    $q->where('t1.store_id',$_SESSION['admin']['store_id']);
                }else{
                    $store_id = input('request.store_id',-1);
                    if($store_id!=-1){
                        $q->where('store_id',$store_id);
                    }
                }
            };

            $model = Ordergoods::with('store')->where($store_query)
                ->alias('t1')
                ->join('order t2','t2.id = t1.order_id','left')
                ->join('user t3','t3.id = t1.user_id','left')
                ->join('leader t4','t4.id = t1.leader_id','left')
//                ->join('store t5','t5.id = t1.store_id')
                ->where('t1.goods_name|t1.attr_names|t2.order_no|t3.name|t4.name','like',"%$key%");

            $state = input('get.state',0);
            if($state){
                $model->where('t1.state',$state);
            }else{
                $model->whereNotIn('t1.state',[-10]);
            }

            $check_state = input('get.check_state',0);
            if($check_state){
                $model->where('t1.check_state',$check_state);
            }

            $user_id = input('get.user_id',0);
            if($user_id){
                $model->where('t1.user_id',$user_id);
            }

            $leader_id = input('get.leader_id',0);
            if($leader_id){
                $model->where('t1.leader_id',$leader_id);
            }

            $begin_time = input('get.begin_time','');
            if ($begin_time){
                $model->where('t1.create_time >= ' . strtotime($begin_time));
            }

            $end_time = input('get.end_time','');
            if ($end_time){
                $end_time = strtotime($end_time);
                $model->where('t1.create_time <= ' . $end_time);
            }

            //排除软删除
            $model->where('del',0);

            return $model;
        };
        $list = $getModel()
            ->field('t2.order_no as order_no,t3.id,t3.name,t3.tel,t2.receive_address,t1.goods_name,t4.name as leader_name,t2.pay_amount as order_pay_amount,t2.coupon_money as order_coupon_money,t1.pay_amount,t1.delivery_fee,t1.coupon_money,t1.attr_names,t1.state,t1.num,t2.create_time as order_time,t1.order_id')
            ->select();

        foreach ($list as &$item) {
            $item->order_time = date('Y-m-d H:i:s', $item->order_time);
            $item->order_no = '\''.$item->order_no;
            switch ($item->state){
                case 1:
                    $item->state = '待支付';
                    break;
                case 2:
                    $item->state = '待配送';
                    break;
                case 3:
                    $item->state = '配送中';
                    break;
                case 4:
                    $item->state = '待自提';
                    break;
                case 5:
                    $item->state = '已完成';
                    break;
                case 6:
                    $item->state = '已取消';
                    break;
            }

            $payrecords = Payrecord::where('source_id',$item['order_id'])
                ->where("source_type = 'Order'")
                ->order('callback_time desc,id desc')
                ->select();
            if(count($payrecords)){
                $item['pay_no'] = "'".$payrecords[0]['no'];
            }
            unset($item['order_id']);
        }

        $this->toCSV('用户订单明细表'.date('ymdhis').'.csv',['订单号','用户id','用户','电话','收货地址','商品名称','团长','订单支付金额','订单优惠金额','商品支付金额','配送费','商品优惠金额','规格','状态','数量','下单时间','商户支付单号'],json_decode(json_encode($list),true));
    }
    //    团长明细
    public function get_list2(){
        $getModel = function (){
            $key = input('get.key','');

            $storeQuery = function($query){
                if($_SESSION['admin']['store_id']>0){
                    $query->where('t1.store_id',$_SESSION['admin']['store_id']);
                }else{
                    $store_id = input("request.store_id",-1);
                    if($store_id!=-1){
                        $query->where('t1.store_id',$store_id);
                    }
                }
            };

            $model = Ordergoods::where($storeQuery)
                ->alias('t1')
                ->join('leader t2','t2.id = t1.leader_id','left') 
                ->where('t2.name','like',"%$key%");

            $model->whereNotIn('state',[1,-10,6]);
            // 不包含退款申请中
            $model->where("t1.check_state <> 1");
            $state = input('get.state');
            if($state){
                $model->where('state',$state);
            }

            $leader_id = input('get.leader_id',0);
            if($leader_id){
                $model->where('t1.leader_id',$leader_id);
            }

            $begin_time = input('get.begin_time','');
            if ($begin_time){
                $model->where('t1.create_time >= ' . strtotime($begin_time));
            }

            $end_time = input('get.end_time','');
            if ($end_time){
                $end_time = strtotime($end_time);
                $model->where('t1.create_time <= ' . $end_time);
            }

            return $model;
        };

        $model = $getModel();

        //分页
        $page = input('request.page',1);
        $limit = input('request.limit',10);
        if($page){
            $model->limit($limit)->page($page);
        }
        //排序
        $order = input('request.orderfield');
        if($order){
            $model->order('t1.'.$order,strtolower(input('request.ordertype')) == "desc"?"DESC":"");
        }else{
            $model->order('t1.create_time desc');
        }

        $list = $model
            ->group('leader_name,t1.goods_id,t1.goods_name,t1.attr_ids,t1.attr_names,t1.state')
            ->field('t2.name as leader_name,t1.goods_id,t1.goods_name,t1.attr_ids,t1.attr_names,t1.state,sum(t1.num)as num')
            ->select();

        $count = $getModel()
            ->group('leader_name,t1.goods_id,t1.goods_name,t1.attr_ids,t1.attr_names,t1.state')
            ->field('t2.name as leader_name,t1.goods_id,t1.goods_name,t1.attr_ids,t1.attr_names,t1.state,sum(t1.num)as num')
            ->count();

        return [
            'code'=>0,
            'count'=>$count,
            'data'=>$list,
            'msg'=>'',
            'sql'=>$model->getLastSql()
        ];
    }
    public function outCSV2(){
        $getModel = function (){
            $key = input('get.key','');

            $storeQuery = function($query){
                if($_SESSION['admin']['store_id']>0){
                    $query->where('t1.store_id',$_SESSION['admin']['store_id']);
                }else{
                    $store_id = input("request.store_id",-1);
                    if($store_id!=-1){
                        $query->where('t1.store_id',$store_id);
                    }
                }
            };

            $model = Ordergoods::where($storeQuery)
                ->alias('t1')
                ->join('leader t2','t2.id = t1.leader_id','left') 
                ->where('t2.name','like',"%$key%");

            $model->whereNotIn('state',[1,-10,6]);
            // 不包含退款申请中
            $model->where("t1.check_state <> 1");
            $state = input('get.state');
            if($state){
                $model->where('state',$state);
            }

            $leader_id = input('get.leader_id',0);
            if($leader_id){
                $model->where('t1.leader_id',$leader_id);
            }

            $begin_time = input('get.begin_time','');
            if ($begin_time){
                $model->where('t1.create_time >= ' . strtotime($begin_time));
            }

            $end_time = input('get.end_time','');
            if ($end_time){
                $end_time = strtotime($end_time);
                $model->where('t1.create_time <= ' . $end_time);
            }

            return $model;
        };

        $model = $getModel();


        //排序
        $order = input('request.orderfield');
        if($order){
            $model->order('t1.'.$order,strtolower(input('request.ordertype')) == "desc"?"DESC":"");
        }else{
            $model->order('t1.create_time desc');
        }

        $list = $model
            ->group('leader_name,t1.goods_id,t1.goods_name,t1.attr_ids,t1.attr_names,t1.state')
            ->field('t2.name as leader_name,t1.goods_id,t1.goods_name,t1.attr_ids,t1.attr_names,t1.state,sum(t1.num)as num')
            ->select();

        $count = $getModel()
            ->group('leader_name,t1.goods_id,t1.goods_name,t1.attr_ids,t1.attr_names,t1.state')
            ->field('t2.name as leader_name,t1.goods_id,t1.goods_name,t1.attr_ids,t1.attr_names,t1.state,sum(t1.num)as num')
            ->count();
        foreach ($list as &$item) {
            switch ($item->state){
                case 1:
                    $item->state = '待支付';
                    break;
                case 2:
                    $item->state = '待配送';
                    break;
                case 3:
                    $item->state = '配送中';
                    break;
                case 4:
                    $item->state = '待自提';
                    break;
                case 5:
                    $item->state = '已完成';
                    break;
                case 6:
                    $item->state = '已取消';
                    break;
            }

            unset($item->leader_id);
            unset($item->goods_id);
            unset($item->attr_ids);
        }

        $this->toCSV('团长订单明细表'.date('ymdhis').'.csv',['团长','商品名称','规格','状态','数量','电话','地址'],json_decode(json_encode($list),true));
    }
    //    获取choose页数据
    public function get_list3(){
        $getModel = function (){
            $model = new Ordergoods();
            $model->alias('t1')
                ->join('goods t2','t2.id = t1.goods_id and (t2.state = 0 || t2.end_time <= '.time().')');

            //关键字搜索
            $key = input('get.key');
            if ($key){
                $model->where('t1.goods_name','like',"%$key%");
            }
            $leader_id = input('request.leader_id');
            if ($leader_id){
                $model->where('t1.leader_id',$leader_id);
            }
            $model->where('t1.state',2);
            $model->where('t1.store_id',$_SESSION['admin']['store_id']);

            $model->group('t1.goods_id,t1.goods_name,t1.batch_no,t1.attr_ids,t1.attr_names')
                ->field('t1.goods_id,t1.goods_name,t1.batch_no,t1.attr_ids,t1.attr_names,sum(t1.num) as num');

            return $model;
        };

        $model = $getModel();

        //排序、分页
//        $model->fill_order_limit();
        //分页
        $page = input('request.page',1);
        $limit = input('request.limit',10);
        if($page){
            $model->limit($limit)->page($page);
        }
        //排序
        $order = input('request.orderfield');
        if($order){
            $model->orderby('t1.'.$order,strtolower(input('request.ordertype')) == "desc"?"DESC":"");
        }else{
            $model->orderby('t1.create_time desc');
        }

        $list = $model->select();

        $model = $getModel();
        return [
            'code'=>0,
            'count'=>$model->count(),
            'data'=>$list,
            'msg'=>'',
        ];
    }

    //    退款订单
    public function index4()
    {
        global $_W,$_GPC;
        $this->view->_W = $_W;
        $this->view->_GPC = $_GPC;
        return view();
    }
//    用户退款订单
    public function get_list4(){
        $getModel = function (){
            $key = input('get.key','');

            $storeQuery = function($query){
                if($_SESSION['admin']['store_id']>0){
                    $query->where('t1.store_id',$_SESSION['admin']['store_id']);
                }else{
                    $store_id = input("request.store_id",-1);
                    if($store_id!=-1){
                        $query->where('t1.store_id',$store_id);
                    }
                }
            };

            $model = Ordergoods::with('store')->where($storeQuery)
                ->where('t1.check_state <> 0')
                ->alias('t1')
                ->join('order t2','t2.id = t1.order_id')
                ->join('user t3','t3.id = t1.user_id')
                ->join('leader t4','t4.id = t1.leader_id')
                ->where('t1.goods_name|t1.attr_names|t2.order_no|t3.name|t4.name','like',"%$key%");

            $check_state = input('get.check_state',0);
            if($check_state){
                $model->where('t1.check_state',$check_state);
            }

            $user_id = input('get.user_id',0);
            if($user_id){
                $model->where('t1.user_id',$user_id);
            }

            $leader_id = input('get.leader_id',0);
            if($leader_id){
                $model->where('t1.leader_id',$leader_id);
            }

            return $model;
        };

        $model = $getModel();
        //分页
        $page = input('request.page',1);
        $limit = input('request.limit',10);
        if($page){
            $model->limit($limit)->page($page);
        }
        //排序
        $order = input('request.orderfield');
        if($order){
            $model->order('t1.'.$order,strtolower(input('request.ordertype')) == "desc"?"DESC":"");
        }else{
            $model->order('t1.create_time desc,t1.id desc');
        }

        $list = $model
            ->field('t1.*,t4.name as leader_name,t3.name,t3.img,t2.order_no as order_no,FROM_UNIXTIME(t2.create_time,\'%Y-%m-%d %T\') as order_time')
            ->select();

        return [
            'code'=>0,
            'count'=>$getModel()->count(),
            'data'=>$list,
            'msg'=>'',
            'store_id'=>input("request.store_id",-1)
        ];
    }
    public function batchprint(){
        $order_ids = input("post.order_ids");
        $order_ids = explode(',',$order_ids);
        $new_ids = [];
        foreach ($order_ids as $order_id) {
            if (!in_array($order_id,$new_ids)){
                $new_ids[] = $order_id;
            }
        }
        $order = new Order();
        $order->adminPrint($new_ids);
        return array(
            'code'=>0,
        );
    }
    public function batchleaderreceive(){
        $ids = input("post.ids");
        $list = Ordergoods::where('id',['in',$ids])
            ->where('state',3)
            ->select();

        $ret = 0;
        foreach ($list as $item) {
            $item->state = 4;
            $reti = $item->save();

            //            更新商家配送单商品状态
            $delivery_num = $item['num'];
            $where = [
                'goods_id'=>$item['goods_id'],
            ];
            if ($item['attr_ids']){
                $where['attr_ids'] = $item['attr_ids'];
            }

            $list_delivery = Deliveryordergoods::where('leader_id',$item['leader_id'])
                ->where($where)
                ->where('num > receive_num')
                ->limit($delivery_num)
                ->order('create_time')
                ->select();

            foreach ($list_delivery as $item_delivery) {
                if (!$delivery_num){
                    continue;
                }
                $n = $item_delivery->num - $item_delivery->receive_num;
                $min_num = min($n,$delivery_num);

                $item_delivery->receive_num += $min_num;
                $item_delivery->save();

                $delivery_num -= $min_num;
            }

            if ($reti) $ret ++;
        }

        if ($ret){
            return array(
                'code'=>0,
            );
        }else{
            return array(
                'code'=>1,
                '收货失败',
            );
        }

    }
    public function batchuserreceive(){
        $ids = input("post.ids");
        $list = Ordergoods::where('id',['in',$ids])
            ->where('state = 4 or (state = 3 and delivery_type = 2)')
            ->select();

        $ret = 0;
        foreach ($list as $item) {
            $item->state = 5;
            $reti = $item->save();
            if ($reti) $ret ++;
        }

        if ($ret){
            return array(
                'code'=>0,
            );
        }else{
            return array(
                'code'=>1,
                '收货失败',
            );
        }

    }
    public function batchsend(){
        $ids = input("post.ids");
        $list = Ordergoods::where('id',['in',$ids])
            ->where('state',2)
            ->select();

        $ret = 0;
        foreach ($list as $item) {
            $item->state = 3;
            $reti = $item->save();
            if ($reti) $ret ++;
        }

        if ($ret){
            return array(
                'code'=>0,
            );
        }else{
            return array(
                'code'=>1,
                '发货失败',
            );
        }

    }




//采购统计表
    public function index5()
    {
        global $_W,$_GPC;
        $this->view->_W = $_W;
        $this->view->_GPC = $_GPC;
        return view();
    }
    public function get_list5(){
        $getModel = function (){
            $key = input('get.key','');

            $storeQuery = function($query){
                if($_SESSION['admin']['store_id']>0){
                    $query->where('store_id',$_SESSION['admin']['store_id']);
                }else{
                    $store_id = input("request.store_id",-1);
                    if($store_id!=-1){
                        $query->where('store_id',$store_id);
                    }
                }
            };

            $model = Ordergoods::where($storeQuery)
                ->where('state',2)
                ->where('check_state <> 1')
                ->where('goods_name|attr_names','like',"%$key%");

            $begin_time = input('get.begin_time','');
            if ($begin_time){
                $model->where('create_time >= ' . strtotime($begin_time));
            }

            $end_time = input('get.end_time','');
            if ($end_time){
                $end_time = strtotime($end_time);
                $model->where('create_time <= ' . $end_time);
            }

            return $model;
        };

        $model = $getModel();
        $list = $model->field('goods_name,attr_names,sum(num) as num')
            ->group('goods_name,attr_names')
            ->order('goods_name,attr_names')
            ->select();

        return [
            'code'=>0,
            'count'=>0,
            'data'=>$list,
            'msg'=>'',
        ];
    }
    public function outCSV5(){
        $getModel = function (){
            $key = input('get.key','');

            $storeQuery = function($query){
                if($_SESSION['admin']['store_id']>0){
                    $query->where('store_id',$_SESSION['admin']['store_id']);
                }else{
                    $store_id = input("request.store_id",-1);
                    if($store_id!=-1){
                        $query->where('store_id',$store_id);
                    }
                }
            };

            $model = Ordergoods::where($storeQuery)
                ->alias('o')
                ->join('store','store.id = o.store_id','left')
                ->where('o.state',2)
                ->where('o.check_state <> 1')
                ->where('goods_name|attr_names','like',"%$key%");

            $begin_time = input('get.begin_time','');
            if ($begin_time){
                $model->where('o.create_time >= ' . strtotime($begin_time));
            }

            $end_time = input('get.end_time','');
            if ($end_time){
                $end_time = strtotime($end_time);
                $model->where('o.create_time <= ' . $end_time);
            }

            return $model;
        };

        $list = $getModel()
            ->field('goods_name,store.name as store_name,attr_names,sum(num) as num')
            ->group('goods_name,attr_names')
            ->order('goods_name,attr_names')
            ->select();
        $this->toCSV('采购统计表'.date('ymdhis').'.csv',['商品名称','商家名称','规格','数量'],json_decode(json_encode($list),true));
    }
    //配送统计表
    public function index6()
    {
        global $_W,$_GPC;
        $this->view->_W = $_W;
        $this->view->_GPC = $_GPC;
        return view();
    }
    public function get_list6(){
        $getModel = function (){
            $key = input('get.key','');
            $storeQuery = function($query){
                if($_SESSION['admin']['store_id']>0){
                    $query->where('t1.store_id',$_SESSION['admin']['store_id']);
                }else{
                    $store_id = input("request.store_id",-1);
                    if($store_id!=-1){
                        $query->where('t1.store_id',$store_id);
                    }
                }
            };

            $model = Ordergoods::where($storeQuery)
                ->alias('t1')
                ->join('user t3','t3.id = t1.user_id')
                ->join('leader t4','t4.id = t1.leader_id')
                ->where('t1.goods_name|t1.attr_names|t3.name|t4.name','like',"%$key%");

            $model->whereIn('t1.state',[3]);

            $delivery_type = input('get.delivery_type',0);
            if($delivery_type){
                $model->where('t1.delivery_type',$delivery_type);
            }

            $leader_id = input('get.leader_id',0);
            if($leader_id){
                $model->where('t1.leader_id',$leader_id);
            }
            $begin_time = input('get.begin_time','');
            if ($begin_time){
                $model->where('t1.create_time >= ' . strtotime($begin_time));
            }

            $end_time = input('get.end_time','');
            if ($end_time){
                $end_time = strtotime($end_time);
                $model->where('t1.create_time <= ' . $end_time);
            }

            return $model;
        };

        $list = $getModel()
            ->field('t1.delivery_type, coalesce(t1.receive_name,t4.name) as name222, coalesce(t1.receive_tel,t4.tel) as tel222, coalesce(t1.receive_address,t4.address) as address222,t1.goods_name,t1.attr_names,sum(num) as num ')
            ->group('delivery_type,name222,tel222,address222,t1.goods_name,t1.attr_names')
            ->order('delivery_type,name222,tel222,address222,t1.goods_name,t1.attr_names')
            ->select();

        return [
            'code'=>0,
            'count'=>0,
            'data'=>$list,
            'msg'=>'',
        ];
    }
    public function outCSV6(){
        $getModel = function (){
            $key = input('get.key','');

            $storeQuery = function($query){
                if($_SESSION['admin']['store_id']>0){
                    $query->where('t1.store_id',$_SESSION['admin']['store_id']);
                }else{
                    $store_id = input("request.store_id",-1);
                    if($store_id!=-1){
                        $query->where('t1.store_id',$store_id);
                    }
                }
            };

            $model = Ordergoods::where($$storeQuery)
                ->alias('t1')
                ->join('order t2','t2.id = t1.order_id')
                ->join('user t3','t3.id = t1.user_id')
                ->join('leader t4','t4.id = t1.leader_id')
                ->where('t1.goods_name|t1.attr_names|t2.order_no|t3.name|t4.name','like',"%$key%");

            $model->whereIn('t1.state',[3]);

            $delivery_type = input('get.delivery_type',0);
            if($delivery_type){
                $model->where('t1.delivery_type',$delivery_type);
            }

            $leader_id = input('get.leader_id',0);
            if($leader_id){
                $model->where('t1.leader_id',$leader_id);
            }

            $begin_time = input('get.begin_time','');
            if ($begin_time){
                $model->where('t1.create_time >= ' . strtotime($begin_time));
            }

            $end_time = input('get.end_time','');
            if ($end_time){
                $end_time = strtotime($end_time);
                $model->where('t1.create_time <= ' . $end_time);
            }

            return $model;
        };

        $list = $getModel()
            ->field('t1.delivery_type, coalesce(t1.receive_name,t4.name) as name222, coalesce(t1.receive_tel,t4.tel) as tel222, coalesce(t1.receive_address,t4.address) as address222,t1.goods_name,t1.attr_names,sum(num) as num ')
            ->group('delivery_type,name222,tel222,address222,t1.goods_name,t1.attr_names')
            ->order('delivery_type,name222,tel222,address222,t1.goods_name,t1.attr_names')
            ->select();

        foreach ($list as &$item) {
            $item->tel222 = "'".$item['tel222'];
            if ($item->delivery_type == 1){
                $item->delivery_type = '用户自提';
            }else{
                $item->delivery_type = '商家配送';
            }
        }

        $this->toCSV('配送统计表'.date('ymdhis').'.csv',['配送方式','收货人','联系电话','地址','商品名称','规格','数量'],json_decode(json_encode($list),true));
    }
    //    删除
    public function softdelete(){
        $ids = input('post.ids');
        $comfirm = input('post.comfirm',false);
        //获得订单表
        $idArr = explode(',',$ids);
        $order_id_array = [];
        $ids=[];
        foreach($idArr as $ordergoods_id){
            $ordergoods = Ordergoods::get($ordergoods_id);
            $ordergoodses = Ordergoods::where('order_id',$ordergoods->order_id)->select();
            $ordergoods_num = count($ordergoodses);
            if($ordergoods_num>1 && !$comfirm){
                return array(
                    'code'=>2,
                    'msg'=>'该订单还有其它商品，是否确认全部删除?'
                );
            }else if($comfirm){
                foreach($ordergoodses as $goods){
                    if($goods['check_state']>0){
                        return array(
                            'code'=>2,
                            'msg'=>'该订单中有退款的商品不能删除'
                        );
                    }
                }
            }
//            if(!in_array($ordergoods->id,$order_id_array)){
//                array_push($order_id_array,$ordergoods->id);
//            }
            foreach($ordergoodses as $v){
                if (!in_array($v->id, $order_id_array)) {
                    array_push($order_id_array, $v->id);
                }
                if (!in_array($v->order_id, $ids)) {
                    array_push($ids, $v->order_id);
                }
            }
        }
        $ids_str = join(',',$ids);
        $order_ids = join(',',$order_id_array);
        $ret = $this->model->where('id','in',$order_ids)->delete();
//        db('baowen')->insert(['xml'=>$this->model->getLastSql()]);
//        $ret = $this->model->destroy(function($query)use($order_ids){
//            $query->where('id','in',$order_ids);
//        });
        Order::where('id','in',$ids_str)->delete();
                db('baowen')->insert(['xml'=>Order::getLastSql()]);
        if($ret){
            return array(
                'code'=>0,
                'data'=>$ret
            );
        }else{
            return array(
                'code'=>1,
                'msg'=>'删除失败'
            );
        }
    }
}
