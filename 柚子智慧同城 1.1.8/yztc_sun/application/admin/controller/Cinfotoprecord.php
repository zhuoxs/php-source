<?php
namespace app\admin\controller;
use Think\Db;
use app\model\User;

class Cinfotoprecord extends Base
{
    public function __construct()
    {
        parent::__construct();
    }

    //    获取列表页数据
    public function get_list(){
        $model = $this->model;
        //条件
        $query = function ($query){
            //关键字搜索
            $key = input('get.key');
            $type=input('get.type');
            $query->where('pay_status',1);
            if ($key){
                $query->where('order_no','like',"%$key%");
            }
            if($type){
                $query->where('check_status',$type);
            }
        };
        //排序、分页
        $model->fill_order_limit();
        $list = $model->where($query)->order('id desc')->select();
        foreach ($list as &$item) {
            $item['nickname']=User::get($item['user_id'])['nickname'];
            $item['pay_status_z']=$item['pay_status']?'已支付':'未支付';
            if($item['check_status']==1){
                $item['check_status_z']='未审核';
            }else if($item['check_status']==2){
                $item['check_status_z']='审核成功';
            }else if($item['check_status']==3){
                $item['check_status_z']='审核失败';
            }
            if($item['order_status']==1){
                $item['order_status_z']='已付款待审核';
            }else if($item['order_status']==2){
                $item['order_status_z']='已付款审核成功';
            }else if($item['order_status']==3){
                $item['order_status_z']='已付款审核失败(退款)';
                if($item['refund_status']==0){
                    $item['refund_status_z']='处理中';
                }else if($item['refund_status']==1){
                    $item['refund_status_z']='退款成功';
                }else if($item['refund_status']==2){
                    $item['refund_status_z']='退款失败';
                }
                $item['refund_time_d']=$item['refund_time']?date('Y-m-d H:i',$item['refund_time']):'';
            }
            $item['pay_time_d']=$item['pay_time']?date('Y-m-d H:i',$item['pay_time']):'';
        }
        return [
            'code'=>0,
            'count'=>$model->where($query)->count(),
            'data'=>$list,
            'msg'=>'',
        ];
    }

}
