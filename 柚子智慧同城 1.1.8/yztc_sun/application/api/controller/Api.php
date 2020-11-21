<?php
namespace app\api\controller;

use app\model\Postagerules;
use think\Controller;
use think\Db;
use think\Loader;
use app\model\Store;
use app\model\Infocategory;
use app\model\Storecategory;

class Api extends Controller
{
    //获取分类信息链接
    public function getInfoAppUrl(){
        $infocategory=(new Infocategory())->where(['type'=>1,'parent_id'=>0,'state'=>1])->limit(24)->select();
        $shop_url=array();
        foreach($infocategory as $k=>$val){
            $shop_url[$k]['title']=$val['name'];
            $shop_url[$k]['url']='/pages/circle/circle?cat_id='.$val['id'];
            $shop_url[$k]['pic']=$val['icon'];
            $shop_url[$k]['link_type']=4;

        }
        return $shop_url;
    }
    //获取商户信息链接
    public function getStoreAppUrl(){
        $store=(new Storecategory())->where(['state'=>1])->select();
        $store_url=array();
        foreach($store as $k=>$val){
            $store_url[$k]['title']=$val['name'];
            $store_url[$k]['url']='/pages/merchants/merchants?cat_id='.$val['id'];
            $store_url[$k]['pic']=$val['icon'];
            $store_url[$k]['link_type']=5;
        }
        return $store_url;
    }
}
