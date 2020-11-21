<?php
namespace app\admin\controller;

use app\base\controller\Admin;
use app\model\Seckilltopicplan;

class Cseckilltopic extends Admin
{

//    获取列表页数据
    public function get_list(){
        $model = $this->model;

        //条件
        $query = function ($query){
            //关键字搜索
            $key = input('get.key');
            if ($key){
                $query->where('name','like',"%$key%");
            }
        };

        //排序、分页
        $model->fill_order_limit();

        $list = $model->with('seckilltopicclass')->where($query)->select();

        return [
            'code'=>0,
            'count'=>$model->where($query)->count(),
            'data'=>$list,
            'msg'=>'',
        ];
    }

    public function plan(){
        return view();
    }

    public function plansave(){
        $year = input('request.year');
        $month = input('request.month');
        $days = input('request.days');
        $seckilltopic_id = input('request.seckilltopic_id');

        $plan = new Seckilltopicplan();
        $plan->destroy(['year'=>$year,'month'=>$month,'day'=>['in',$days]]);

        if ($seckilltopic_id){
            $days = explode(',',$days);
            foreach ($days as $day) {
                $plan = new Seckilltopicplan();
                $plan->isUpdate(false)->allowField(true)->save([
                    'year'=>$year,
                    'month'=>$month,
                    'day'=>$day,
                    'seckilltopic_id'=>$seckilltopic_id,
                ]);
            }
        }
    }

    public function getplans(){
        $year = input('request.year');
        $month = input('request.month');

        $plan = new Seckilltopicplan();
        $list = $plan
            ->with('seckilltopic')
            ->where('year',$year)
            ->where('month',$month)
            ->select();
        $new_list = [];
        foreach ($list as $item) {
            $new_list['d_'.$item['day']] = [
                'name'=>$item['seckilltopic_name'],
                'id'=>$item['seckilltopic_id'],
            ];
        }
        return $new_list;
    }
}
