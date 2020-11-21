<?php
namespace app\api\controller;
use app\model\Category;
use app\model\Collection;
use app\model\Config;
use app\model\Goods;
use app\model\Leadergoods;
use app\model\Ordergoods;
use app\model\Robot;
use app\model\Storeleader;
use app\model\System;
use app\model\Goodsattrgroup;
use app\model\Goodsattrsetting;
use qcloudcos\Conf;
use think\Db;
use app\base\controller\Api;
class Cgoods extends Api
{
    public $goods;
    public $system;
    public $goodsattrgroup;
    public $goodsattrsetting;
    public function __construct()
    {
        $this->goods=new Goods();
        $this->system=new System();
        $this->goodsattrgroup=new Goodsattrgroup();
        $this->goodsattrsetting=new Goodsattrsetting();
    }
    //获取商品详情
    public function getGoods(){
        $goods_id=input('request.goods_id');
        $user_id =input('request.user_id');

        $goods_model = new Goods();
        $goods = $goods_model
            ->with('attrgroups')
            ->field('id,name,state,unit,weight,mandatory,FROM_UNIXTIME(send_time,\'%m/%d\') as send_date,FROM_UNIXTIME(receive_time,\'%m/%d\') as receive_date,FROM_UNIXTIME(begin_time,\'%m/%d\') as begin_date,FROM_UNIXTIME(end_time,\'%m/%d\') as end_date,receive_time,store_id,pics,pic,price,original_price,stock,virtual_num,sales_num+virtual_num as sales_num,begin_time as begin_time2,end_time as end_time2,send_time as send_time2,receive_time as receive_time2,service,details,use_attr,delivery_single,delivery_fee,`limit`,delivery_fee_type,img_details,video')
            ->find($goods_id);

        //判断是否使用全局配送费
        $delivery_switch  =  $goods->delivery_fee_type;
        if($delivery_switch == 0){
            $global_delievery_fee = Config::get_value('global_delivery_fee',0);
            $goods->delivery_fee = $global_delievery_fee;
        }
        //已经购买数量
        $bought = Ordergoods::where('user_id',$user_id)
            ->where('goods_id',$goods_id)
            ->where('state',['in',[2,3,4,5]])
            ->sum('num');
        $goods['bought'] = $bought;
        if(!$goods){
            error_json('该商品不存在');
        }

        $goods->pics=json_decode($goods->pics);
        $goods->img_details=json_decode($goods->img_details);
        $goods->is_outtime = $goods->state != 1 || $goods->end_time2 <= time();

        $goods['users'] = Ordergoods::where('t1.goods_id',$goods_id)
            ->whereNotIn('t1.state',[1,6])
            ->alias('t1')
            ->join('user t2','t2.id = t1.user_id')
            ->field('t2.img')
            ->distinct('t2.img')
            ->order('t1.create_time desc')
            ->limit(17)
            ->select();
        //        如果存在虚拟销量，则添加机器人到用户列表
        if ($goods['virtual_num'] && count($goods['users']) < 17){
            $robots = Robot::getList(17 - count($goods['users']));
            $goods['users'] = array_merge($goods['users'],$robots);
        }

        $leader_has_goods = true;
        while (true){
            $leader_id = input('request.leader_id',0);
            if ($leader_id){
//                判断商家选择团长
                $storeleader_count = Storeleader::where('leader_id',$leader_id)
                    ->where('store_id',$goods->store_id)
                    ->count();
                if (!$storeleader_count){
                    $leader_has_goods = false;
                    break;
                }

//                判断团长主动选择开关
                $leader_choosegoods_switch = Config::get_value('leader_choosegoods_switch',0);
                if (!$leader_choosegoods_switch){
                    break;
                }

//                判断团长选择商品
                $leadergoods_count = Leadergoods::where('leader_id',$leader_id)
                    ->where('goods_id',$goods_id)
                    ->count();
                //商品是强制上架时不考虑
                if (!$leadergoods_count && !$goods['mandatory']){
                    $leader_has_goods = false;
                }
            }

            break;
        }
        $goods['leader_has'] = $leader_has_goods;
        if (!$goods['leader_has']){
            $goods->is_outtime = true;
        }
        $goods['delivery_single'] = (int)$goods['delivery_single'];
        success_withimg_json($goods);
    }
    public function getGoodsUsers(){
        $goods = Goods::get(input('request.goods_id'));

        $list = Ordergoods::where('t1.goods_id',$goods->id)
            ->whereNotIn('t1.state',[1,6])
            ->alias('t1')
            ->join('user t2','t2.id = t1.user_id')
            ->field('t2.img')
            ->distinct('t2.img')
            ->order('t1.create_time desc')
//            ->limit(17)
            ->select();

//        如果存在虚拟销量，则添加机器人到用户列表
        if ($goods->virtual_num){
            $robots = Robot::getList(max($goods->virtual_num/3,17));
            $list = array_merge($list,$robots);
        }

        success_json($list);
    }
//    获取分类商品
//    传入：
//          cat_id:分类id
//          page:第几页
//          limit:每页数据量
//          leader_id:团长id
    public function getGoodses(){
        //条件
        $query = function ($query){
            $store_ids = Storeleader::where('leader_id',input('request.leader_id'))->column('store_id');
            if (!count($store_ids)){
                $query->where('1=2');
                return;
            }

            $leader_choosegoods_switch = Config::get_value('leader_choosegoods_switch',0);
            if (!$leader_choosegoods_switch){
                $query->whereIn('store_id',$store_ids);
            }else{
                $goods_ids = Leadergoods::where('leader_id',input('request.leader_id'))
                    ->whereIn('store_id',$store_ids)
                    ->column('goods_id');
//                if (!count($goods_ids)){
//                    $query->where('1=2');
//                    return;
//                }
                $query->where(function($q)use($goods_ids){
                    $q->where('id','in',$goods_ids)->whereOr('mandatory',1);
                });
            }



            $query->where('state',1);
            $query->where('check_state = 2 or store_id = 0');

            $cat_id = input('request.cat_id',-1);
            switch ($cat_id){
                case 0:
                    break;
                case -1://热门推荐
                    $t = time();
                    $query->where("begin_time <= $t and end_time >= $t");

                    $query->where('is_hot',1);
                    break;
                case -2://今日上新
                    $t = time();
                    $query->where("begin_time <= $t and end_time >= $t");

                    $time1 = strtotime(date('Y-m-d',time()));//获取今天凌晨的时间戳
                    $time2 = strtotime(date("Y-m-d",strtotime("+1 day")));//获取明天凌晨的时间戳
                    $query->where("begin_time >= $time1 and begin_time < $time2");
                    break;
                case -3://明日上新
                    $time1 = strtotime(date("Y-m-d",strtotime("+1 day")));//获取明天凌晨的时间戳
                    $time2 = strtotime(date("Y-m-d",strtotime("+2 day")));//获取后天凌晨的时间戳
                    $query->where("begin_time >= $time1 and begin_time < $time2");
                    break;
                case -4://下期
                    $t = time();
                    $query->where("begin_time > $t");
                    break;
                default:
                    $t = time();
                    $query->where("begin_time <= $t and end_time >= $t");

                    $query->where('cat_id',$cat_id);
            }

        };

//        查询数据
        $goods_model = new Goods();
        $goods_model->order = 'store_id,index,id DESC';
        $goods_model->fill_order_limit();//分页，排序
        $list = $goods_model->with('attrgroups')->where($query)
            ->field('id,name,unit,store_id,price,original_price,stock,sales_num+virtual_num as sales_num,pic,end_time as end_time2,begin_time as begin_time2,use_attr,delivery_single,delivery_fee,customer_tag,home_pic,virtual_num,style_pic')
//            ->order()
            ->select();
        //加入购买人
        foreach($list as $key=>$val){
            $list[$key]['delivery_single']=(int)$val['delivery_single'];
            $list[$key]['users'] = Ordergoods::where('t1.goods_id',$val['id'])
                ->whereNotIn('t1.state',[1,6])
                ->alias('t1')
                ->join('user t2','t2.id = t1.user_id')
                ->field('t2.img')
                ->distinct('t2.img')
                ->order('t1.create_time desc')
                ->limit(2)
                ->select();
            //        如果存在虚拟销量，则添加机器人到用户列表
            if (count($list[$key]['users'])<2&&$val['virtual_num']){
                $robots = Robot::getList(2-count($list[$key]['users']));
                $list[$key]['users']= array_merge($list[$key]['users'],$robots);
            }

        }
        success_withimg_json($list);
    }
    //获取选完规格后商品信息
    public function getGoodsAttrs(){
        $goods_id=input('request.goods_id');
        $attr_ids=input('request.attr_ids');

        $list = Goodsattrsetting::where('goods_id',$goods_id)
            ->where('attr_ids',$attr_ids)
            ->select();

        success_withimg_json($list);
    }
    //检测商品条件
    public function checkGoods(){
        global $_W;
        $gid=input('request.gid');
        $num=input('request.num');
        $attr_ids=input('request.attr_ids');
        $goods=$this->goods->get($gid);
        if(empty($goods)){
            $this->ajaxError('商品不存在');
        }
        if($goods['use_attr']==0){
            if($num>$goods['stock']){
                $this->ajaxError('库存不足');
            }
        }else if($goods['use_attr']==1){
            $goodsattrsetting=$this->goodsattrsetting->where(array('goods_id'=>$gid,'attr_ids'=>$attr_ids))->find();
            if($num>$goodsattrsetting['stock']){
                $this->ajaxError('库存不足');
            }
        }
        $this->ajaxSuccess('成功');
    }

    //获取我的商品列表
    public function getStoreGoodses(Goods $goods){
        $check_state = input("request.check_state",0);
        $store_id = input("request.store_id",0);
        $cat_id = input('requset.cat_id',0);
        $query = function($query)use($store_id,$cat_id,$check_state){
            if($cat_id){
                $query->where('cate_id',$cat_id);
            }
            $query->where('store_id',$store_id);
            if($check_state){
                $query->where('check_state',$check_state);
            }
        };
        $goods->fill_order_limit();
        $list = $goods->where($query)->select();
        success_withimg_json($list,['count'=>$goods->where($query)->count()]);
    }
    //商品保存
    public function save(Goods $info){

        $id = input('post.id');
        if ($id) {
            $info = $info->get($id, 'category');
        }

        $data = input('post.');

        $data['check_state'] = 2;
//        判断是否需要重新审核
//        if ($data['store_id']){
        if($id){
            $config = Config::get_value('goods_update_check',0);
        }else{
            $config = Config::get_value('goods_insert_check',0);
        }
        if ($config){
            $data['check_state'] = 1;
            $data['fail_reason'] = '';
        }
//        }

        $data['pics'] = json_encode(explode(',',$data['pics']));
        $data['img_details'] = json_encode(explode(',',$data['img_details']));
        //如果是下架
        if(isset($data['state'])&&$data['state']==0){
            $data['check_state'] = 2;
        }
        $ret = $info->allowField(true)->save($data);

        if($ret!==false){
            success_json($info->id);
        }else{
            error_json('保存失败');
        }
    }
    //说的单个商品详情
    public function read(){
        $data = input('request.');
        if(!isset($data['goods_id'])){
            error_json('商品id错误');
        }
        $query = function($query) use($data){

            if($data['store_id']){
                $query->where('store_id',$data['store_id']);
            }
            $query->where('id',$data['goods_id']);
        };
        $info = Goods::with('category')->where($query)->find();
        $info['pics'] = json_decode($info['pics'],true);
        if($info){
            success_withimg_json($info);
        }else{
            error_json('商品不存在');
        }
    }
}
