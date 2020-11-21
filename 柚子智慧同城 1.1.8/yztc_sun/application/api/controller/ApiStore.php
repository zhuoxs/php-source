<?php
namespace app\api\controller;

use app\model\Accessrecord;
use app\model\Ad;
use app\model\Baowen;
use app\model\Collection;
use app\model\Coupon;
use app\model\Couponget;
use app\model\Freesheetorder;
use app\model\Panic;
use app\model\Panicorder;
use app\model\Pinorder;
use app\model\Store;
use app\model\Order;
use app\model\Storecategory;
use app\model\Storedistrict;
use app\model\Storerecharge;
use app\model\Storeuser;
use app\model\Storeopen;
use app\model\Userbalancerecord;
use app\model\Goods;
use app\model\Pingoods;
use app\model\Config;
use think\Db;

class ApiStore extends Api
{
    //获取所有banner
    public function getBannerAll(){
        $adModel=new Ad();
        $data=[
            'index'=>$adModel->where(['type'=>1,'state'=>1])->order('sort asc')->select(),
            'index_middle1'=>$adModel->where(['type'=>9,'state'=>1])->order('sort asc')->select(),
            'index_middle2'=>$adModel->where(['type'=>10,'state'=>1])->order('sort asc')->select(),
            'info'=>$adModel->where(['type'=>2,'state'=>1])->order('sort asc')->select(),
            'store'=>$adModel->where(['type'=>4,'state'=>1])->order('sort asc')->select(),
            'goods'=>$adModel->where(['type'=>5,'state'=>1])->order('sort asc')->select(),
            'book'=>$adModel->where(['type'=>11,'state'=>1])->order('sort asc')->select(),

        ];
        success_withimg_json($data);
    }
    //管理后台核销所有订单
    public function confirmAllOrder(){
        $order_no=input('request.order_no');
        $type=input('request.type');
        $num=input('request.num');
        $user_id=input('request.user_id');
        if($type==1){
            //核销普通订单
            (new Order())->confirmCommonOrder($order_no,$num,$user_id);
        }elseif ($type==2){
            //核销抢购订单
            (new Panicorder())->checkOrd($order_no,$num,$user_id);
        }elseif ($type==3){
            //优惠券核销订单
            (new Couponget())->checkOrd($order_no,$user_id);
        }elseif ($type==4){
            //拼团核销
            (new Pinorder())->checkOrd($order_no,$num,$user_id);
        }elseif ($type==5){
            //免单
            (new Freesheetorder())->checkOrd($order_no,$user_id);
        }

    }

    //检测进入商家后台权限
    public function checkStoreUserPermission(){
        $user_id=input('request.user_id');
        $store=new Store();
        $data=$store->where(['user_id'=>$user_id,'check_status'=>2])->find();
        $type=0;
        if($data){
            $type=1;
        }else{
            $storeuser=new Storeuser();
            $storeuser_data=$storeuser->where(['user_id'=>$user_id,'state'=>1])->find();
            if($storeuser_data){
                $type=2;
                $data=$store::get($storeuser_data['store_id']);
            }
        }
        if($data){
            $statistics=(new Store())->getStatistics($data['id']);
        }
        //统计订单
        $data=array(
            'type'=>$type,
            'store'=>$data,
            'statistics'=>$statistics,
            'entering_switch'=>Config::get_value('entering_switch',0),
        );
        success_withimg_json($data);
    }


    //我的收藏
    public function getMyCollectionList(){
        $user_id=input('request.user_id');
        $collection=new Collection();
        $collection->fill_order_limit_length();
        $data=$collection->where(['user_id'=>$user_id,'type'=>1])->select();
        $data=objecttoarray($data);
        foreach ($data as &$val){
            $val['store']=Store::get($val['store_id']);
            $val['category_name']=Storecategory::get($val['store']['cat_id'])['name'];
        }
        success_withimg_json($data);
    }
    //收藏和取消收藏商家
    public function setcancelCollection(){
        $user_id=input('request.user_id');
        $store_id=input('request.store_id');
        $collection=new Collection();
        $data=$collection->where(['user_id'=>$user_id,'type'=>1,'store_id'=>$store_id])->find();
        if($data['is_collection']==1){
            //取消收藏
            $collection->cancelCollection($user_id,$store_id);
            success_withimg_json('取消成功');
        }else{
            //收藏
            $collection->setCollection($user_id,$store_id);
            success_withimg_json('收藏成功');
        }

    }
    //获取商家详情信息
    public function getStoreDetail(){
        $id=input('request.id');
        $user_id=input('request.user_id');
        $lat=input('request.lat')?input('request.lat'):118.19728;
        $lng=input('request.lng')?input('request.lng'):24.17591;
        $field="*,convert(acos(cos($lat*pi()/180 )*cos(lat*pi()/180)*cos($lng*pi()/180 -lng*pi()/180)+sin($lat*pi()/180 )*sin(lat*pi()/180))*6370996.81,decimal) as distance ";
        $store=new Store();
        $data=$store->field($field)->find($id);
        $data=objecttoarray($data);
        $data['is_collection']=(new Collection())->getUserCollection($user_id,$id);
        $data['coupon']=(new Coupon())->getCouponListByStoreId($id);
        $data['goodslist']=(new Goods())->getGoodsListByStoreId($id);
        $data['bookgoodslist']=(new Goods())->getBookGoodsListByStoreId($id);
        $data['paniclist']=(new Panic())->getGoodsListByStoreId($id);
        $data['pinlist']=(new Pingoods())->getGoodsListByStoreId($id);
        $data['banner']=json_decode($data['banner']);
        //增加人气
        $store->where(['id'=>$id])->setInc('popularity',1);
        success_withimg_json($data);
    }
    //获取最新10条商家名称列表
    public function getNewsestStore(){
        $store=new Store();
        $data=$store->field('name')->where(['check_status'=>2,'end_time'=>['egt',time()]])->order('rz_time desc')->limit(10)->select();
        success_withimg_json($data);
    }

    //获取商家信息
    public function getStoreList(){
        global $_W;
        $store=new Store();
        $store->fill_order_limit_length();//分页，排序
        $query = function ($query){
            $query->where('is_del',0);
            $query->where('check_status',2);
            $query->where('end_time','>=',time());
            $is_recommend=input('request.is_recommend');
            if($is_recommend){
                $query->where('is_recommend',$is_recommend);
            }
            $district_id=input('request.district_id')?input('request.district_id'):0;
            if($district_id){
                $query->where('district_id',$district_id);
            }
            $category_id=input('request.category_id');
            if($category_id){
                $query->where('cat_id',$category_id);
            }
            $key=input('request.key');
            if($key){
                $query->where('name','like',"%$key%");
            }
            $quality_status=input('request.quality_status');
            if($quality_status==1){
                $query->where('quality_status',1);
            }else if($quality_status==2){
                $query->where('quality_status',0);
            }
        };
        $sort=input('request.sort');
        if($sort){
            if($sort==1){
                $order='popularity desc';
            }else  if($sort==2){
                $order='id desc';
            }else if($sort==3){
                $pageindex = max(1, intval(input('request.page')));
                $pagesize=input('request.length')?input('request.length'):10;
                $limit=" limit " .($pageindex - 1) * $pagesize.",".$pagesize;
                $where=" uniacid={$_W['uniacid']} and is_del=0 and check_status=2 and end_time>=".time()." ";
                if(input('request.district_id')>0){
                    $where.=" and district_id=".input('request.district_id')." ";
                }
                if(input('request.category_id')>0){
                    $where.=" and cat_id=".input('request.category_id')." ";
                }
                if(input('request.key')){
                    $where.=" and name like '%".input('request.key')."%' ";
                }
                $lat=input('request.lat');
                $lng=input('request.lng');
                $sql = "select *,convert(acos(cos($lat*pi()/180 )*cos(lat*pi()/180)*cos($lng*pi()/180 -lng*pi()/180)+sin($lat*pi()/180 )*sin(lat*pi()/180))*6370996.81,decimal)  as distance from ims_yztc_sun_store where  $where order by distance asc $limit";
                $data=Db::query($sql);
                foreach ($data as &$val){
                    $val['category_name']=Storecategory::get($val['category_id'])['name'];
                    $title=(new Coupon())->getGetType3CouponTitle($val['id']);
                    if($title){
                        $val['coupon_title']=$title;
                    }

                }
                success_withimg_json($data);
            }
        }
        $lat=input('request.lat')?input('request.lat'):118.19728;
        $lng=input('request.lng')?input('request.lng'):24.17591;
        $field="*,convert(acos(cos($lat*pi()/180 )*cos(lat*pi()/180)*cos($lng*pi()/180 -lng*pi()/180)+sin($lat*pi()/180 )*sin(lat*pi()/180))*6370996.81,decimal) as distance ";
        $data=$store->where($query)->field($field)->order($order)->select();
        $data=objecttoarray($data);
        foreach ($data as &$val){
            $val['category_name']=Storecategory::get($val['category_id'])['name'];
            $val['coupon_title']=(new Coupon())->getGetType3CouponTitle($val['id']);
        }
        success_withimg_json($data);
    }
    //获取商圈信息
    public function getStoreDistrictList(){
        global $_W;
        $storedistrict=new Storedistrict();
        $query = function ($query){
            $query->where('state',1);
        };
        $data=$storedistrict->where($query)->order('sort asc')->select();
        success_withimg_json($data);
    }

    //获取商家分类信息
    public function getStoreCategoryList(){
        global $_W;
        $storecategory=new Storecategory();
        $query = function ($query){
            $query->where('is_del',0);
            $query->where('state',1);
        };
        $data=$storecategory->where($query)->order('sort desc')->select();
        success_withimg_json($data);
    }
    //获取轮播图
    public function getBanner(){
        global $_W;
        $query = function ($query){
            $type = input('request.type');
            $query->where('type',$type);
            $query->where('state',1);
        };
        $ad=new Ad();
        $list=$ad->where($query)->order(['sort'=>'asc'])->select();
        success_withimg_json($list);
    }

//    获取商户列表
//    传入：
//          key:搜索关键字
//          page:第几页
//          limit:每页数据量
    public function getStores(){
        global $_W;

        //条件
        $query = function ($query){
            $query->where('check_status',2);
            $query->where('end_time',['>',time()]);
            //关键字搜索
            $key = input('request.key');
            if ($key){
                $query->where('name','like',"%$key%");
            }
        };

//        查询数据
        $store_model = new Store();
        $store_model->fill_order_limit();//分页，排序
        $list = $store_model->where($query)->field('id,name,goods_count,sale_count,pic')->with('hotgoodses')->select();
        $goods_model = new \app\model\Goods();
        foreach ($list as &$item) {
            $item['goods_count'] = $goods_model
                ->where('store_id',$item['id'])
                ->where('state',1)
                ->where('check_status',2)
                ->count();
        }
        $count = $store_model->where($query)->count();

//        获取商户轮播图
        $ad = new Ad();
        $ad->fill_order_limit(true,false);
        $store_swipers = $ad->where('state',1)->where('type',3)->select();
        success_withimg_json($list,['count'=>$count,'store_swipers'=>$store_swipers]);
    }
    //商户续费
    public function renewalfeeStore(){
        global $_W;
        $store_id=input('request.store_id');
        $user_id=input('request.user_id');
        $cid=input('request.cid');
        $store=Store::get($store_id);
        $storeModel=new Store();
        if(!$store){
            error_json('商户不存在');
        }
        if($store['check_status']!=2){
            error_json('审核通过商户才可以续费');
        }
        if($store['user_id']!=$user_id){
            error_json('商户管理员才可以续费');
        }
        $storerecharge=Storerecharge::get($cid);
        if(!$storerecharge){
            error_json('充值卡不存在');
        }
        $data['days']=$storerecharge['days'];
        if($storerecharge['price']=='0.00'||$storerecharge['price']==0.00){
            $storerecharge['price']=0;
        }
        $data['price']=$storerecharge['price'];
        //续费信息
        $open=[
            'user_id'=>$user_id,
            'store_id'=>$store_id,
            'type'=>2,
            'pay_type'=>1,
            'pay_status'=>0,
            'cid'=>$cid,
            'day_num'=>$data['days'],
            'price'=>$data['price'],
        ];
        (new Storeopen())->allowField(true)->save($open);
        $storeopen_id=Db::name('storeopen')->getLastInsID();
        if($data['price']==0){
            $end_time = max(time(),intval(strtotime($store['end_time']))?:0);
            $end_time += $data['days']*24*60*60;
            $data['end_time']=$end_time;
            $storeModel->allowField(true)->save(['end_time'=>$end_time],['id'=>$store_id]);
            //保存订单storeopen_id信息
            $storeModel->allowField(true)->save(['storeopen_id'=>$storeopen_id],['id'=>$store_id]);
            (new Storeopen())->allowField(true)->save(['pay_status'=>1,'pay_type'=>3],['id'=>$storeopen_id]);
            success_json('续费成功');
        }
        if($data['price']>0){
            //微信支付
            $wx=new ApiWx();
            $attach=json_encode(array('type'=>'storerecharge','uniacid'=>$_W['uniacid'],'days'=>$data['days'],'store_id'=>$store_id,'storeopen_id'=>$storeopen_id));
            $user=\app\model\User::get($user_id);
            $wxinfo=$wx->pay($user['openid'],$data['price'],$attach,'商户续费');
            $store_model['paydata'] = $wxinfo;
        }
        success_json($store_model);

    }

//    商户入驻申请
    public function applyStore(){
        global $_W;
        $data = input('request.');
        $data['check_status'] = 1;
        $data['fail_reason'] = '';
        $id = input('request.id');
        $cid=input('request.cid');
        if($id){
            $store_model = Store::get($id);
        }else{
            $store_model = new Store();
        }
        $store_model->check_version();
        $storerecharge=Storerecharge::get($cid);
        $data['days']=$storerecharge['days'];
        if($storerecharge['price']=='0.00'||$storerecharge['price']==0.00){
            $storerecharge['price']=0;
        }
        $data['price']=$storerecharge['price'];
      //  $store_model = $id?Store::get($id):new Store();
        if($data['price']==0){
            $store = Store::get($id);
            $end_time = max(time(),intval(strtotime($store['end_time']))?:0);
            $end_time += $data['days']*24*60*60;
            $data['end_time']=$end_time;
        }
        $banner= explode(',',$data['banner']);
        $data['banner']=json_encode($banner);
        $store_model->allowField(true)->save($data);
        if($id>0){
        }else{
            $id=Db::name('store')->getLastInsID();
        }
        //        支付
        $days = $data['days'];
        $price =  $data['price'];

        $pay_type = input('request.pay_type');
        $user_id = input('request.user_id');
        $user = \app\model\User::get($user_id);

        //申请入驻信息
        $open=[
            'user_id'=>$user_id,
            'store_id'=>$id,
            'type'=>1,
            'name'=>$data['name'],
            'contact'=>$data['contact'],
            'tel'=>$data['tel'],
            'phone'=>$data['phone'],
            'pay_type'=>1,
            'lng'=>$data['lng'],
            'lat'=>$data['lat'],
            'logo'=>$data['logo'],
            'pay_status'=>0,
            'cid'=>$cid,
            'day_num'=>$data['days'],
            'price'=>$data['price'],
        ];
        (new Storeopen())->allowField(true)->save($open);
        $storeopen_id=Db::name('storeopen')->getLastInsID();
        if($data['price']==0){
            (new Storeopen())->allowField(true)->save(['pay_status'=>1,'pay_type'=>3],['id'=>$storeopen_id]);
        }

        //保存订单storeopen_id信息
        Db::name('store')->where(array('id'=>$id))->update(array('storeopen_id'=>$storeopen_id));

        //        余额支付
        if ($price && $pay_type == 2){
            if ($user['balance'] < $price){
                throw new \ZhyException('您的账户余额不足');
            }
            $userbalancerecord_model = new Userbalancerecord();
            $userbalancerecord_model->addBalanceRecord($user_id,$_W['uniacid'],5,0,-1*$price,0,0,'商家入驻费用');
            $userbalancerecord_model->editBalance($user_id,-1*$price);
            $this->payNotify([
                'attach'=>json_encode([
                    'store_id'=>$store_model->id,
                    'days'=>$days
                ])
            ],2);
        }else if($price && $pay_type == 1){
//            微信支付
            $wx=new ApiWx();
            $attach=json_encode(array('type'=>'storerecharge','uniacid'=>$_W['uniacid'],'days'=>$days,'store_id'=>$id,'storeopen_id'=>$storeopen_id));
            $wxinfo=$wx->pay($user['openid'],$price,$attach,'商户申请入驻');
            $store_model['paydata'] = $wxinfo;
        }
        success_json($store_model);
    }
//    获取我的商家
    public function getMyStore(){
        $user_id = input('request.user_id');
        $store = Store::get(['user_id'=>$user_id]);
        $end_time=strtotime($store['end_time']);
        if(empty($end_time)||$end_time<time()){
            $store['state']=0;
        }else{
            $store['state']=1;
        }
        /*
        if($store['check_status']==2&&$end_time>=time()){
            $store['state']=1;
        }else if($store['check_status']==2&&$end_time<time()){
            $store['state']=0;
        }else if($store['check_status']==1&&$end_time<time()){
            $store['state']=0;
        }else if($store['check_status']==1&&$end_time>=time()){
            $store['state']=0;
        }else if($store['check_status']==3){
            $store['state']=0;
        }else{
            $store['state']=0;
        }*/
        $store['entering_switch']=Config::get_value('entering_switch',0);
        $store['merchants_settled_in']=Config::get_value('merchants_settled_in','');
        success_withimg_json($store);
    }
//    增加访问记录
    public function addAccressRecord(){
        $data = input('request.');
        $accressrecord_model = new Accessrecord();
        $ret = $accressrecord_model->allowField(true)->save($data);
        if($ret){
            success_json($accressrecord_model->id);
        }
//        error_json('保存失败');
    }
//    获取商户报表
    public function getStoreReport(){
        $ret = [];
        $store_id = input('request.store_id');
        $store_data = Store::get($store_id);
        if (!$store_id){
            $store_data = [
                'id'=>$store_id,
                'name'=>'平台',
            ];
        }
        $ret['storeinfo'] = $store_data;

        $begin_today = strtotime(date('Y-m-d',time()));//获取今天凌晨的时间戳
        $begin_yesterday=strtotime(date("Y-m-d",strtotime("-1 day")));//获取昨天凌晨的时间戳

        $order_model = new Order();
        $accessrecord_model = new Accessrecord();

//        今日订单
        $todayOrderCount = $order_model->where('store_id',$store_id)
            ->where('order_status',3)
            ->where('pay_time',['>=',$begin_today])
            ->count();

//        今日收入
        $todayAmountSum = $order_model->where('store_id',$store_id)
            ->where('order_status',3)
            ->where('pay_time',['>=',$begin_today])
            ->sum('goods_total_price');

//        昨日收入
        $yesterdayAmountSum = $order_model->where('store_id',$store_id)
            ->where('order_status',3)
            ->where('pay_time',[['>=',$begin_yesterday],['<',$begin_today]])
            ->sum('goods_total_price');
//        累计收入
        $amountSum = $order_model->where('store_id',$store_id)
            ->where('order_status',3)
            ->sum('goods_total_price');

//        今日访问量
        $todayAccessCount = $accessrecord_model->where('store_id',$store_id)
            ->where('create_time',['>=',$begin_today])
            ->count();

        $ret['report'] = [
            'todayOrderCount'=>$todayOrderCount,
            'todayAmountSum'=>$todayAmountSum,
            'todayAccessCount'=>$todayAccessCount,
            'yesterdayAmountSum'=>$yesterdayAmountSum,
            'amountSum'=>$amountSum,
            'money'=>$store_data['money'],
        ];

        success_withimg_json($ret);
    }
//    获取商户订单
    public function getStoreOrders(){
        //条件
        $query = function ($query){
            $query->where('store_id',input('request.store_id'));
            $state = input("request.state");
            if ($state){
                $query->where('order_status',$state)
                    ->where('pay_status',1);
            }
        };

//        查询数据
        $order_model = new Order();
        $order_model->fill_order_limit();//分页，排序
        $list = $order_model->where($query)->with('orderdetails')->order('create_time','desc')->select();
        $count = $order_model->where($query)->count();

        success_withimg_json($list,['count'=>$count]);
    }
//    获取商户充值卡
    public function getStoreRecharges(){
        $storerecharge_model = new Storerecharge();
        $storerecharge_list = $storerecharge_model->isUsed()->select();
        success_json($storerecharge_list);
    }
    /**
     * 支付回调
     */
    public function payNotify($data,$pay_type = 1){
        global $_W;
        $attach=json_decode($data['attach'],1);
        $_W['uniacid']=$attach['uniacid'];
        $storeopen=Storeopen::get($attach['storeopen_id']);
       if(!$storeopen||$storeopen['pay_status']==1){
            echo 'FAIL';
            exit;
        }
        $store = Store::get($attach['store_id']);
        $end_time = max(time(),intval(strtotime($store['end_time']))?:0);
        $end_time += $attach['days']*24*60*60;
        $ret = $store->save(['end_time'=>$end_time,'storeopen_id'=>$attach['storeopen_id']]);
        //保存订单状态
        (new Storeopen())->allowField(true)->save(['pay_time'=>time(),'pay_status'=>1,'order_no'=>$data['out_trade_no'],'transaction_id'=>$data['transaction_id']],['id'=>$attach['storeopen_id']]);
        if ($pay_type==2){
            return true;
        }
        if($ret){
            echo 'SUCCESS';
        }else{
            echo 'FAIL';
        }
    }

}
