<?php
namespace app\api\controller;

use app\model\Activity;
use app\model\Store;
use app\model\Goods;
use app\model\Panic;
use app\model\Coupon;
use think\Db;
use think\Loader;


class ApiActivity extends Api
{
    //获取活动列表
    public function getActivityList(){
        global $_W;
        $activityModel=new Activity();
        $activityModel->fill_order_limit_length('id desc');//分页，排序
        $query = function ($query){
            $query->where('check_status',2);
            $query->where('state',1);
            $cat_id=input('request.cat_id');
            if($cat_id){
                $query->where('cat_id',$cat_id);
            }
            $is_status=input('request.is_status');
            if($is_status==1){
                $query->where('end_time','>=',time());
            }else if($is_status==2){
                $query->where('end_time','<',time());
            }
        };
        $lng=input('request.lng',0);
        $lat=input('request.lat',0);
        if($lng&&$lat){
            $pageindex = max(1, intval(input('request.page')));
            $pagesize=input('request.length')?input('request.length'):10;
            $limit=" limit " .($pageindex - 1) * $pagesize.",".$pagesize;
            $where=" where a1.uniacid={$_W['uniacid']}  and a1.check_status=2 and a1.state=1 and a2.end_time>".time()." ";
            $cat_id=input('request.cat_id');
            if($cat_id){
                $where.=" and a1.cat_id=$cat_id ";
            }
            $is_status=input('request.is_status');
            if($is_status==1){
                $where.=" and a1.end_time>=".time()." ";
            }else if($is_status==2){
                $where.=" and a1.end_time<".time()." ";
            }
            $sql="select a1.*,a2.name as store_name,a2.address,convert(acos(cos($lat*pi()/180 )*cos(a2.lat*pi()/180)*cos($lng*pi()/180 -a2.lng*pi()/180)+sin($lat*pi()/180 )*sin(a2.lat*pi()/180))*6370996.81,decimal)  as distance from ims_yztc_sun_activity a1 left join ims_yztc_sun_store a2 on a1.store_id=a2.id $where order by distance asc $limit";
            $data=Db::query($sql);
            foreach ($data as &$val){
                $val['store']=Store::get($val['store_id']);
                if($val['type']==3){
                    $coupon=Coupon::get($val['goods_id']);
                    $val['indexpic']=$coupon['indexpic'];
                }else{
                    $val['indexpic']=$val['pic'];
                }
            }
            success_withimg_json($data);
        }
        $data=$activityModel->where($query)->select();
        $data=objecttoarray($data);
        foreach ($data as &$val){
            $val['store']=Store::get($val['store_id']);
            if($val['type']==3){
                $coupon=Coupon::get($val['goods_id']);
                $val['indexpic']=$coupon['indexpic'];
            }else{
                $val['indexpic']=$val['pic'];
            }
        }
        success_withimg_json($data);
    }
}
