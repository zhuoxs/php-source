<?php
namespace app\api\controller;
use app\model\Freesheet;
use app\model\Goods;
use app\model\Category;
use app\model\Order;
use app\model\Store;
use app\model\User;
use app\model\Goodsattrgroup;
use app\model\Goodsattrsetting;
use app\model\Browserecord;
use app\model\Panic;
use app\model\Pingoods;
use think\Db;

class ApiGoods extends Api
{
    //获取所有类型商品
    public function getAllTypeGoods(){
         $type=input('request.type');
         if($type==1){
             $goodsModel=new Goods();
             $goodsModel->fill_order_limit_length();//分页，排序
             $query = function ($query){
                 $keywords=input('request.keywords');
                 $query->where('a1.state',1);
                 $query->where('a1.check_status',2);
                 $query->where('a1.end_time','>=',time());
                 $query->where('a1.name','like',"%$keywords%");
                 $query->where('a2.end_time','>=',time());
                 $query->where('a2.check_status',2);
             };
             $field='a1.id,a1.name,a1.pic,a1.price';
             $data=$goodsModel->alias('a1')->join('store a2','a1.store_id=a2.id')->where($query)->field($field)->order('a1.id desc')->select();
         }else if($type==2){
             $panicModel=new Panic();
             $panicModel->fill_order_limit_length();//分页，排序
             $query = function ($query){
                 $keywords=input('request.keywords');
                 $query->where('a1.state',1);
                 $query->where('a1.is_del',0);
                 $query->where('a1.end_time','>=',time());
                 $query->where('a1.name','like',"%$keywords%");
                 $query->where('a2.end_time','>=',time());
                 $query->where('a2.check_status',2);
             };
             $field='a1.id,a1.name,a1.pic,a1.panic_price';
             $data=$panicModel->alias('a1')->join('store a2','a1.store_id=a2.id')->where($query)->field($field)->order('a1.id desc')->select();
             $data=objecttoarray($data);
             foreach ($data as &$val){
                 $val['price']=$val['panic_price'];
             }
         }else if($type==3){
             $pingoodsModel=new Pingoods();
             $pingoodsModel->fill_order_limit_length();
             $query = function ($query){
                 $keywords=input('request.keywords');

                 $query->where('a1.check_status',2);
                 $query->where('a1.state',1);
                 $query->where('a1.is_del',0);
                 $query->where('a1.end_time','>=',time());
                 $query->where('a1.name','like',"%$keywords%");
                 $query->where('a2.end_time','>=',time());
                 $query->where('a2.check_status',2);
             };
             $field='a1.id,a1.name,a1.pic,a1.pin_price';
             $data=$pingoodsModel->alias('a1')->join('store a2','a1.store_id=a2.id')->where($query)->field($field)->order('a1.id desc')->select();
             $data=objecttoarray($data);
             foreach ($data as &$val){
                 $val['price']=$val['pin_price'];
             }
         }else if($type==4){
             $freesheetModel=new Freesheet();
             $freesheetModel->fill_order_limit_length();
             $query = function ($query){
                 $keywords=input('request.keywords');
                 $query->where('a1.check_status',2);
                 $query->where('a1.state',1);
                 $query->where('a1.is_del',0);
                 $query->where('a1.end_time','>=',time());
                 $query->where('a1.name','like',"%$keywords%");
                 $query->where('a2.end_time','>=',time());
                 $query->where('a2.check_status',2);
             };
             $field='a1.id,a1.name,a1.pic,a1.end_time as md_end_time';
             $data=$freesheetModel->alias('a1')->join('store a2','a1.store_id=a2.id')->where($query)->field($field)->order('a1.id desc')->select();
             $data=objecttoarray($data);
             foreach ($data as &$val){
                 $val['price']=$val['pin_price'];
             }
         }
         success_withimg_json($data);
    }

    //检测商品条件(包含库存、活动结束时间、仅vip购买、会员免单数、限购单数)
    public function checkGoods()
    {
        global $_W;
        $gid = input('request.gid');
        $num = input('request.num');
        $attr_ids = input('request.attr_ids');
        $user_id=input('request.user_id');
        $goods = Goods::get($gid);
        if (empty($goods)) {
            error_json('商品不存在');
        }
        if(strtotime($goods['end_time'])<time()){
            error_json('活动已结束');
        }
        if($goods['only_vip']==1){
            $vip=(new User())->isVip($user_id);
            if($vip==0){
                error_json('该活动仅限vip购买');
            }
        }
        if($goods['limit_num']>0){
            //获取当前已经购买该活动单数
            $current_num=(new Order())->getOrderNumByGid($user_id,$gid);
            $total_num=$current_num+$num;
            $show_num=$goods['limit_num']-$current_num;
            if($total_num>$goods['limit_num']){
                error_json('你已超过该活动购买最大数量限制,您目前还能购买'.$show_num.'个');
            }
        }
        //会员免单
      /*  if($goods['only_num']>0){
            $vip = (new User())->isVip($user_id);
            if ($vip == 0) {
                error_json('该会员免单活动仅限会员购买');
            }
            //获取当前已经免费活动单数
            $current_num=(new Order())->getOrderFreeNumByGid($user_id,$gid);
            $total_num=$current_num+$num;
            $show_num=$goods['only_num']-$current_num;
            if($total_num>$goods['only_num']){
                error_json('你已超过该活动购买最大数量限制,您目前还能购买'.$show_num.'个');
            }
        }*/
        if ($goods['use_attr'] == 0) {
            if ($num > $goods['stock']) {
                error_json('库存不足');
            }
        } else if ($goods['use_attr'] == 1) {
            $goodsattrsetting = (new Goodsattrsetting())->where(array('goods_id'=>$gid,'attr_ids'=>$attr_ids))->find();
            if ($num > $goodsattrsetting['stock']) {
                error_json('库存不足');
            }
        }
        success_json('检测成功');
    }


    //获取选则完规格后的商品信息
    public function getGoodsAttrInfo(){
        global $_W;
        $gid=input('request.gid');
        $attr_ids=input('request.attr_ids');
        $data=(new Goodsattrsetting())->getGoodsAttrInfo($gid,$attr_ids);
        success_withimg_json($data);
    }
   //获取商品详情信息
   public function getGoodsDetail(){
      $gid=input('request.gid');
      $user_id=input('request.user_id');
      $goods=new Goods();
      $data=$goods::get($gid);
      $data['store']=Store::get($data['store_id']);
      $data['is_vip']=(new User())->isVip($user_id);
      $data['cy_num']=(new Order())->getOrderCyNumByGid($gid);
      $data['ck_num']=(new Browserecord())->getBrowserecordGoodsByGid($gid);
      $data['stock_num']=$goods->getGoodsSaleNumByGid($gid);
      $data['yg_num']=(new Order())->getOrderNumByGid($user_id,$gid);
      $data['ygfree_num']=(new Order())->getOrderFreeNumByGid($user_id,$gid);
      $data['pics']=json_decode($data['pics']);
      if($data['use_attr']==1){
        //多规格
        $data['attr_group_list']=(new Goodsattrgroup())->getAttrGroupList($gid);
      }
      //增加浏览记录
      (new Browserecord())->allowField(true)->save(['type'=>1,'user_id'=>$user_id,'gid'=>$gid,'store_id'=>$data['store_id']]);
      success_withimg_json($data);
   }
   //获取商品分类信息
   public function getCategoryList(){
       $category=new Category();
       $data=$category->where(['state'=>1,'is_del'=>0])->order('index desc')->select();
       success_withimg_json($data);
   }
   //获取商品列表信息
   public function getGoodsList(){
       global $_W;
       $goods=new Goods();
       $goods->fill_order_limit_length();//分页，排序
       $query = function ($query){
           $goods_type=input('request.goods_type')?input('request.goods_type'):1;
           $query->where('a1.goods_type',$goods_type);
           $query->where('a1.state',1);
           $query->where('a1.check_status',2);
           $is_recommend=input('request.is_recommend')?input('request.is_recommend'):input('request.hot');
           if($is_recommend){
               $query->where('a1.is_recommend',1);
           }
           $cat_id=input('request.cat_id');
           if($cat_id){
               $query->where('a1.cat_id',$cat_id);
           }
           $is_status=input('request.is_status');
           if($is_status==1){
               $query->where('a1.end_time','>=',time());
           }else if($is_status==2){
               $query->where('a1.end_time','<',time());
           }
           $query->where('a2.end_time','>=',time());
       };
       $sort=input('request.sort')?input('request.sort'):0;
       $goods_type=input('request.goods_type')?input('request.goods_type'):1;
       $order="a1.index asc,a1.id desc";
       if($sort==1){
            $order="a1.id desc";
       }else if($sort==2){
            $order_type=input('request.order_type');
            if($order_type==1){
                $order="a1.price asc";
            }else if($order_type==2){
                $order="a1.price desc";
            }
       }else if($sort==3){
            $order="sales_num desc";
       }
       $lng=input('request.lng',0);
       $lat=input('request.lat',0);
       if($lng&&$lat){
           $pageindex = max(1, intval(input('request.page')));
           $pagesize=input('request.length')?input('request.length'):10;
           $limit=" limit " .($pageindex - 1) * $pagesize.",".$pagesize;
           $where=" where a1.uniacid={$_W['uniacid']}  and a1.check_status=2 and a1.state=1 and a2.end_time>".time()." ";
           $where.=" and goods_type=$goods_type ";
           $is_recommend=input('request.is_recommend')?input('request.is_recommend'):input('request.hot');
           if($is_recommend){
               $where.=" and a1.is_recommend=1 ";
           }
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
           $sql="select a1.id,a1.name,a1.price,a1.original_price,a1.index,a1.store_id,a1.indexpic,a1.pic,convert(acos(cos($lat*pi()/180 )*cos(a2.lat*pi()/180)*cos($lng*pi()/180 -a2.lng*pi()/180)+sin($lat*pi()/180 )*sin(a2.lat*pi()/180))*6370996.81,decimal)  as distance from ims_yztc_sun_goods a1 left join ims_yztc_sun_store a2 on a1.store_id=a2.id $where order by distance asc,a1.index asc $limit";
           $data=Db::query($sql);
           foreach ($data as &$val){
               $val['store']=Store::get($val['store_id']);
           }
           success_withimg_json($data);
       }
       $filed='a1.id,a1.name,a1.price,a1.indexpic,a1.pic,a1.store_id,a1.original_price';
       $data=$goods->alias('a1')->join('store a2','a1.store_id=a2.id')->field($filed)->where($query)->order($order)->select();
       $data=objecttoarray($data);
       foreach ($data as &$val){
           $val['store']=Store::get($val['store_id']);
       }
       success_withimg_json($data);
   }

    //获取商品列表信息
    public function getBookGoodsList(){
        global $_W;
        $goods=new Goods();
        $goods->fill_order_limit_length();//分页，排序
        $query = function ($query){
            $goods_type=input('request.goods_type')?input('request.goods_type'):1;
            $query->where('a1.goods_type',$goods_type);
            $query->where('a1.state',1);
            $query->where('a1.check_status',2);
            $is_recommend=input('request.is_recommend')?input('request.is_recommend'):input('request.hot');
            if($is_recommend){
                $query->where('a1.is_recommend',1);
            }
            $cat_id=input('request.cat_id');
            if($cat_id){
                $query->where('a1.cat_id',$cat_id);
            }
            $is_status=input('request.is_status');
            if($is_status==1){
                $query->where('a1.end_time','>=',time());
            }else if($is_status==2){
                $query->where('a1.end_time','<',time());
            }
            $query->where('a2.end_time','>=',time());
        };
        $sort=input('request.sort')?input('request.sort'):0;
        $goods_type=input('request.goods_type')?input('request.goods_type'):1;
        $order="a1.index asc,a1.id desc";
        if($sort==1){
            $order="a1.id desc";
        }else if($sort==2){
            $order_type=input('request.order_type');
            if($order_type==1){
                $order="a1.price asc";
            }else if($order_type==2){
                $order="a1.price desc";
            }
        }else if($sort==3){
            $order="sales_num desc";
        }
        $lng=input('request.lng',0);
        $lat=input('request.lat',0);
        if($lng&&$lat){
            $pageindex = max(1, intval(input('request.page')));
            $pagesize=input('request.length')?input('request.length'):10;
            $limit=" limit " .($pageindex - 1) * $pagesize.",".$pagesize;
            $where=" where a1.uniacid={$_W['uniacid']}  and a1.check_status=2 and a1.state=1 and a2.end_time>".time()." ";
            $where.=" and goods_type=$goods_type ";
            $is_recommend=input('request.is_recommend')?input('request.is_recommend'):input('request.hot');
            if($is_recommend){
                $where.=" and a1.is_recommend=1 ";
            }
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
            $sql="select a1.id,a1.name,a1.price,a1.original_price,a1.index,a1.store_id,a1.indexpic,a1.pic,convert(acos(cos($lat*pi()/180 )*cos(a2.lat*pi()/180)*cos($lng*pi()/180 -a2.lng*pi()/180)+sin($lat*pi()/180 )*sin(a2.lat*pi()/180))*6370996.81,decimal)  as distance from ims_yztc_sun_goods a1 left join ims_yztc_sun_store a2 on a1.store_id=a2.id $where order by distance asc,a1.index asc $limit";
            $data=Db::query($sql);
            foreach ($data as &$val){
                $val['store']=Store::get($val['store_id']);
            }
            success_withimg_json($data);
        }
        $filed='a1.id,a1.name,a1.price,a1.indexpic,a1.pic,a1.store_id,a1.original_price';
        $data=$goods->alias('a1')->join('store a2','a1.store_id=a2.id')->field($filed)->where($query)->order($order)->select();
        $data=objecttoarray($data);
        foreach ($data as &$val){
            $val['store']=Store::get($val['store_id']);
        }
        success_withimg_json($data);
    }
}
