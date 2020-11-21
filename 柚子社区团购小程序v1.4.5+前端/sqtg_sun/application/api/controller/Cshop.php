<?php
namespace app\api\controller;
use app\model\Goods;
use app\model\Shop;
use app\model\System;
use app\model\Goodsattrgroup;
use app\model\Goodsattrsetting;
use think\Db;
use app\base\controller\Api;
class Cshop extends Api
{
    //获取门店详情
    public function getShop(){
        global $_W;
        $id=input('request.id');
        $data = Shop::get($id);
        $data['pics'] = json_decode($data['pics']);
        success_json($data,array('img_root'=>$_W['attachurl']));
    }
//    获取门店列表
//    传入：
//          longitude:经度
//          latitude:纬度
//          page:第几页
//          limit:每页数据量
    public function getNearShops(){
        $store_id = input('request.store_id',0);
        $longitude = input('request.longitude',0);
        $latitude = input('request.latitude',0);
        $page = input('request.page',1);
        $limit = input('request.limit',10);
        $start = ($page-1)*$limit;
//        所有需要返回的分类id
        $store_list = Db::query("
            select id,name,address,pic
            ,convert(acos(cos($latitude*pi()/180 )*cos(latitude*pi()/180)*cos($longitude*pi()/180 -longitude*pi()/180)+sin($latitude*pi()/180 )*sin(latitude*pi()/180))*6370996.81,decimal)  as distance 
            from ".tablename('sqtg_sun_shop')."
            where store_id = $store_id
            order by distance
            limit $start,$limit
        ");
        success_withimg_json($store_list);
    }
    //    获取门店列表
//    传入：

//          store_id:门店id
    public function getShops(){
        $store_id = input('request.store_id',0);
        $shop_model = new Shop();
        $list = $shop_model->where('store_id',$store_id)->select();
        success_withimg_json($list);
    }
}
