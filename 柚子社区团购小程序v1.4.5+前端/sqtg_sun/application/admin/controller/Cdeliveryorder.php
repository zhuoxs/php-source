<?php
namespace app\admin\controller;
use app\model\Deliveryorder;
use app\model\Deliveryordergoods;
use app\base\controller\Admin;
use app\model\Goods;

class Cdeliveryorder extends Admin
{
//    获取列表页数据
    public function get_list(){
        $getModel = function(){
            $key = input('get.key');
            $model = Deliveryorder::hasWhere('leader',['name'=>['like',"%$key%"]]);
            $model->where('store_id',$_SESSION['admin']['store_id']);

            $type = input('get.type',0);
            if ($type){
                $model->where('state',$type);
            }

            $begin_time = input('get.begin_time','');
            if ($begin_time){
                $model->where('Deliveryorder.create_time >= ' . strtotime($begin_time));
            }

            $end_time = input('get.end_time','');
            if ($end_time){
                $end_time = strtotime($end_time);
                $model->where('Deliveryorder.create_time <= ' . $end_time);
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
            $model->order($order,strtolower(input('request.ordertype')) == "desc"?"DESC":"");
        }else{
            $model->order('create_time desc');
        }

        $list = $model->with('Leader')->select();

        return [
            'code'=>0,
            'count'=>$getModel()->count(),
            'data'=>$list,
            'msg'=>'',
        ];
    }

    public function save(){
        $data = input('request.');

        $goodses = $data['goodses'];

//        配送商品详情
        $details = [];
        foreach ($goodses as $goods) {
            $detail = $goods['goods_name'];
            if ($goods['attr_names']){
                $detail.= '['.$goods['attr_names'].']';
            }
            $detail .= ' * '.$goods['num'];
            $details[] = $detail;
        }
        $data['detail'] = implode(';',$details);

        $order_model = new Deliveryorder($data);
        $order_model->startTrans();
        $order_model->allowField(true)->save();

        foreach ($goodses as &$goods) {
            $goods['order_id'] = $order_model->id;
            $goods['leader_id'] = $order_model->leader_id;
            $goods['store_id'] = $order_model->store_id;
        }

        $goods_model = new Deliveryordergoods();
        $ret = $goods_model->allowField(true)->saveAll($goodses);
        if (!$ret){
            $order_model->rollback();
            error_json('生成失败，请重新提交');
        }

        $order_model->commit();
        success_json();
    }
    public function detail(){
        $info=$this->model->get(input('get.id'),['goodses','leader']);

        switch ($info['state']){
            case 3:
                $info['state_z']= '待收货';
                break;
            case 4:
                $info['state_z']= '已完成';
                break;
        }
        $this->view->info=$info;
        return view('edit');
    }

    public function outCSV(){
        $model = $this->model;

        $model->where('t1.store_id',$_SESSION['admin']['store_id']);

        $type = input('get.type',0);
        if ($type){
            $model->where('t1.state',$type);
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

        //排序
        $model->order('t1.create_time desc');

        $key = input('get.key');
        if ($key){
            $model->where("t1.order_no like '%{$key}%' or t2.name like '%{$key}%'");
        }

        $list = $model
            ->alias('t1')
            ->join('Leader t2','t2.id = t1.leader_id')
            ->field('t1.order_no,t1.create_time,t2.name,t2.tel,t2.address,t1.state,t1.detail')
            ->select();

        foreach ($list as &$item) {
            $item->order_no = '\''.$item->order_no;
            $item->tel = '\''.$item->tel;
            switch ($item->state){
                case 3:
                    $item->state = '待收货';
                    break;
                case 4:
                    $item->state = '已完成';
                    break;
            }
        }

        $this->toCSV('配送单'.date('ymdhis').'.csv',['配送单号','配送时间','团长','联系电话','收货地址','配送状态','配送详情'],json_decode(json_encode($list),true));
    }
}
