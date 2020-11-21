<?php
namespace app\admin\controller;

use app\base\controller\Admin;
use app\model\Config;
use app\model\Leaderbill;
use app\model\Ordergoods;
use app\model\Storeleader;
use app\model\System;
use think\Db;

class Cleaderbill extends Admin
{

//    获取列表页数据
    public function get_list(){
        $getModel = function (){
            $model = new Leaderbill();
            $model->alias('t1')
                ->join('leader t2','t1.leader_id = t2.id')
                ->join('ordergoods t3','t3.id = t1.order_id')
                ->join('user t4','t4.id = t3.user_id')
                ->join('order t5','t5.id = t3.order_id');

            $key = input('request.key','');
            if ($key){
                $model->where('t2.name|t4.name|t3.goods_name|t5.order_no',['like',"%$key%"]);
            }
            $leader_id = input('request.leader_id',0);
            if ($leader_id){
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

            $model->order('t1.create_time desc,t1.id desc');

            return $model;
        };

        $model = $getModel();

        $repeat = input('request.repeat','');
        if ($repeat){
            $sql = "select order_id from ".tablename('sqtg_sun_leaderbill') ;
            $leader_id = input('request.leader_id',0);
            if ($leader_id){
                $sql .= " where leader_id = $leader_id ";
            }
            $sql .= "group by order_id
                having count(1)>1";

            $list2 =Db::query($sql);

            $order_ids = array_column($list2,'order_id');
            $model->whereIn('t1.order_id',$order_ids);
        }

        //分页
        $page = input('request.page',1);
        if($page){
            $limit = input('request.limit',10);
            $model->limit($limit)->page($page);
        }
        $model->field('t2.name as leader_name,t4.name as user_name,t1.*,t3.goods_name,t3.attr_names,t3.amount,t3.pay_amount,t5.order_no');
        $list = $model->select();

        $model = $getModel();
        if ($repeat){
            $model->whereIn('t1.order_id',$order_ids);
        }
        return [
            'code'=>0,
            'count'=>$model->count(),
            'data'=>$list,
            'msg'=>'',
        ];
    }
    public function outCSV(){
        $getModel = function (){
            $model = new Leaderbill();
            $model->alias('t1')
                ->join('leader t2','t1.leader_id = t2.id')
                ->join('ordergoods t3','t3.id = t1.order_id')
                ->join('user t4','t4.id = t3.user_id')
                ->join('order t5','t5.id = t3.order_id');

            $key = input('request.key','');
            if ($key){
                $model->where('t2.name|t4.name|t3.goods_name|t5.order_no',['like',"%$key%"]);
            }
            $leader_id = input('request.leader_id',0);
            if ($leader_id){
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

            $model->order('t1.create_time desc,t1.id desc');

            return $model;
        };

        $model = $getModel();

        $repeat = input('request.repeat','');
        if ($repeat){
            $sql = "select order_id from ".tablename('sqtg_sun_leaderbill') ;
            $leader_id = input('request.leader_id',0);
            if ($leader_id){
                $sql .= " where leader_id = $leader_id ";
            }
            $sql .= "group by order_id
                having count(1)>1";

            $list2 =Db::query($sql);

            $order_ids = array_column($list2,'order_id');
            $model->whereIn('t1.order_id',$order_ids);
        }

        $model->field('t2.name as leader_name,t1.money,t1.create_time,t4.name as user_name,t5.order_no,t3.goods_name,t3.attr_names,t3.amount,t3.pay_amount');
        $list = $model->select();

        foreach ($list as &$item) {
            $item->order_no = "'".$item['order_no'];
        }

        $this->toCSV('团长账单明细'.date('ymdhis').'.csv',['团长','抽成金额','时间','下单用户','订单号','商品','规格','商品金额','支付金额'],json_decode(json_encode($list),true));
    }

//    列表页
    public function indexpin()
    {
        global $_W,$_GPC;
        $this->view->_W = $_W;
        $this->view->_GPC = $_GPC;
        return view();
    }
    public function get_pinlist(){
        $getModel = function (){
            $model = new Leaderbill();
            $model->alias('t1')
                ->join('leader t2','t1.leader_id = t2.id')
                ->join('pinorder t3','t3.id = t1.order_id')
                ->join('user t4','t4.id = t3.user_id')
                ->join('pingoods t5','t5.id = t3.goods_id');

            $key = input('request.key','');
            if ($key){
                $model->where('t2.name|t4.name|t5.name|t3.order_num',['like',"%$key%"]);
            }
            $leader_id = input('request.leader_id',0);
            if ($leader_id){
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

            $model->order('t1.create_time desc,t1.id desc');

            return $model;
        };

        $model = $getModel();

        $repeat = input('request.repeat','');
        if ($repeat){
            $sql = "select order_id from ".tablename('sqtg_sun_leaderbill') ;
            $leader_id = input('request.leader_id',0);
            if ($leader_id){
                $sql .= " where leader_id = $leader_id ";
            }
            $sql .= "group by order_id
                having count(1)>1";

            $list2 =Db::query($sql);

            $order_ids = array_column($list2,'order_id');
            $model->whereIn('t1.order_id',$order_ids);
        }

        //分页
        $page = input('request.page',1);
        if($page){
            $limit = input('request.limit',10);
            $model->limit($limit)->page($page);
        }
//        $model->field('t2.name as leader_name,t4.name as user_name,t1.*,t5.name as  goods_name,t3.attr_list as attr_names,t3.order_amount,t3.pay_amount,t3.order_num');
        $model->field('t2.name as leader_name,t4.name as user_name,t1.*,t5.name as  goods_name,t3.attr_list as attr_names,t3.order_amount as pay_amount,t3.order_amount-t3.distribution as amount,t3.order_num as order_no');
        $list = $model->select();

        $model = $getModel();
        if ($repeat){
            $model->whereIn('t1.order_id',$order_ids);
        }
        return [
            'code'=>0,
            'count'=>$model->count(),
            'data'=>$list,
            'msg'=>'',
        ];
    }
    public function outpinCSV(){
        $getModel = function (){
            $model = new Leaderbill();
            $model->alias('t1')
                ->join('leader t2','t1.leader_id = t2.id')
                ->join('pinorder t3','t3.id = t1.order_id')
                ->join('user t4','t4.id = t3.user_id')
                ->join('pingoods t5','t5.id = t3.goods_id');

            $key = input('request.key','');
            if ($key){
                $model->where('t2.name|t4.name|t5.name|t3.order_num',['like',"%$key%"]);
            }
            $leader_id = input('request.leader_id',0);
            if ($leader_id){
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
            $data =input('get.data');
            if($data){
                $model->where('t1.id','in',$data);
            }
            $model->order('t1.create_time desc,t1.id desc');

            return $model;
        };

        $model = $getModel();

        $repeat = input('request.repeat','');
        if ($repeat){
            $sql = "select order_id from ".tablename('sqtg_sun_leaderbill') ;
            $leader_id = input('request.leader_id',0);
            if ($leader_id){
                $sql .= " where leader_id = $leader_id ";
            }
            $sql .= "group by order_id
                having count(1)>1";

            $list2 =Db::query($sql);

            $order_ids = array_column($list2,'order_id');
            $model->whereIn('t1.order_id',$order_ids);
        }

//        $model->field('t2.name as leader_name,t4.name as user_name,t1.*,t5.name as  goods_name,t3.attr_list as attr_names,t3.order_amount as amount,t3.order_amount-t3.distribution as pay_amount,t3.order_num as order_no');
        $model->field('t2.name as leader_name,t1.money,t1.create_time,t4.name as user_name,t3.order_num as order_no,t5.name,t3.attr_list,t3.order_amount-t3.distribution,t3.order_amount');
        $list = $model->select();

        foreach ($list as &$item) {
            $item->order_no = "'".$item['order_no'];
        }

        $this->toCSV('团长账单明细'.date('ymdhis').'.csv',['团长','抽成金额','时间','下单用户','订单号','商品','规格','商品金额','支付金额'],json_decode(json_encode($list),true));
    }
}
