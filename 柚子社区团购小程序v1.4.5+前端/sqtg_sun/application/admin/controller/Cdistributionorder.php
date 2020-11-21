<?php
namespace app\admin\controller;
use app\model\Config;
use app\model\Order;
use app\model\Ordergoods;
use app\model\User;
use app\base\controller\Admin;

class Cdistributionorder extends Admin
{
    //    列表页
    public function index()
    {
        global $_W,$_GPC;
        $this->view->_W = $_W;
        $this->view->_GPC = $_GPC;
        $this->view->level = Config::get_value('distribution_level',0);
        return view();
    }
//    获取列表页数据
    public function get_list(){
        $model = new Ordergoods();
        //条件
        $query = function ($query){
            //关键字搜索
            $key = input('get.key');
            if ($key){
                $order_ids = Order::where('order_no','like',"%$key%")
                    ->column('id');

                if (count($order_ids)){
                    $query->where(function ($query){
                        $key = input('get.key');
                        $order_ids = Order::where('order_no','like',"%$key%")
                            ->column('id');

                        $query->whereOr('order_id',['in',$order_ids]);
                        $query->whereOr('goods_name','like',"%$key%");
                    });
                }else{
                    $query->where('goods_name','like',"%$key%");
                }


            }
            $type = input('get.type');
            if($type){
                $query->where('state',$type);
            }
            $query->where('distribution_money',['<>',0]);
        };

        //排序、分页
        $model->fill_order_limit();
        $model->orderby('create_time desc');

        $list = $model->with('distributionrecords,order,user')->where($query)->select();
        foreach ($list as &$item) {
            foreach ($item['distributionrecords'] as $index=>$record) {
                $user = User::get($record['user_id']);
                $item['distribution'.$index] = $user['name'];
                $item['distribution_money'.$index] = $record['money'];
            }
            unset($item['distributionrecords']);
        }

        return [
            'code'=>0,
            'count'=>$model->where($query)->count(),
            'data'=>$list,
            'msg'=>'',
        ];
    }
}
