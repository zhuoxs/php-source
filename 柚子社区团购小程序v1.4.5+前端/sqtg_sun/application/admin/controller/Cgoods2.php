<?php
namespace app\admin\controller;

use app\base\controller\Admin;
use app\model\Goods;
use app\model\Seckillgoods;
use app\model\Seckillmeeting;
use app\model\Seckilltopic;

class Cgoods2 extends Admin
{

    public function get_list(){
        $model = new Goods();

        //条件
        $query = function ($query){
            $query->where('store_id',$_SESSION['admin']['store_id']);
            $query->where('lid',1);
            //关键字搜索
            $key = input('get.key');
            if ($key){
                $query->where('name','like',"%$key%");
            }
            $cat_id = input('get.cat_id');
            if ($cat_id){
                $query->where('cat_id',"$cat_id");
            }

            $meeting_id = input('get.meeting_id');
            if ($meeting_id){
                $meeting = Seckillmeeting::get($meeting_id);
                $topic = Seckilltopic::get($meeting['seckilltopic_id']);
                $meeting_model = new Seckillmeeting();
                $meetings = $meeting_model->where('seckilltopic_id',$topic->id)->select();
                $ids = [];
                foreach ($meetings as $meeting) {
                    if ($meeting->id == $meeting_id){
                        continue;
                    }
                    $ids[] = $meeting->id;
                }

                $seckillgoods_model = new Seckillgoods();
                $seckillgoodses = $seckillgoods_model->where('seckillmeeting_id',['in',$ids])->select();
                $g_ids = [];
                foreach ($seckillgoodses as $seckillgoods) {
                    $g_ids[] = $seckillgoods->goods_id;
                }
                $query->where('id',['not in',$g_ids]);
            }
//            if ($cat_id){
//                $query->where('cat_id',"$cat_id");
//            }
        };

        //排序、分页
        $model->fill_order_limit();

        $list = $model->with(['category','attrgroups'])->where($query)->select();

        return [
            'code'=>0,
            'count'=>$model->where($query)->count(),
            'data'=>$list,
            'msg'=>'',
        ];
    }
}
