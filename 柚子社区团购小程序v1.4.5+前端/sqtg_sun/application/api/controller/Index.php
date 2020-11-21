<?php
namespace app\api\controller;
use app\base\controller\Api;
use app\model\Category;
use app\model\Pinclassify;
use app\model\Config;
use app\model\Formid;
use app\model\Postagerules;
use app\model\System;
use think\Controller;
use app\model\Ad;
use app\model\Announcement;
use think\Db;

class Index extends Api
{
//    获取首页数据
//1、轮播图-all
//2、公告-1
//3、分类列表-all
//4、优惠券开关
    public function getIndexData(){
        $data = array();

//        轮播图
        $ad = new Ad();
        $ad->fill_order_limit(true,false);
        $data['swipers'] = $ad->isUsed()
            ->where('type',1)->select();
        foreach ($data['swipers'] as &$swiper) {
            if ($swiper['param']){
                $swiper['url'] .= '?'.$swiper['param'];
            }
        }

//        公告
        $announcement = new Announcement();
        $announcements = $announcement->isUsed()->order('update_time desc')->field('id,name as title')->select();
//        $an_title = "";
        $an_title=[];
        $index = 1;
        foreach ($announcements as $announcement) {
//            $an_title .= $index."、{$announcement->title}；";
            $an_title[]= $index."、{$announcement->title}；";
            $index ++;
        }
        $data['announcement']['title'] = $an_title;

//        推荐分类
        $cat = new Category();
        $cats = [];
        if (Config::get_value('index_hot_switch',0)){
            $cats[] = [
                'id'=>'-1',
                'name'=>'热门推荐',
            ];
        }
        if (Config::get_value('index_today_switch',0)){
            $cats[] = [
                'id'=>'-2',
                'name'=>'今日上新',
            ];
        }
        /*switch (Config::get_value('index_yesterday_switch',0)){
            case 1:
                $cats[] = [
                    'id'=>'-3',
                    'name'=>'明日预售',
                ];
                break;
            case 2:
                $cats[] = [
                    'id'=>'-4',
                    'name'=>'下期预告',
                ];
                break;
        }*/
        $cats2 = $cat->where('state',1)->order('index')->field('id,name')->select();
        $data['categorys'] = array_merge($cats,$cats2);

        $data['coupon']=[
            'window'=>Config::get_value('coupon_window_switch'),
            'index'=>Config::get_value('coupon_index_switch'),
        ];

        success_withimg_json($data);
    }

//    获得拼团首页数据
    public function getPinIndexData(){
        $data = array();

//        轮播图
        $ad = new Ad();
        $ad->fill_order_limit(true,false);
        $data['swipers'] = $ad->isUsed()
            ->where('type',1)->select();

//        公告
        $announcement = new Announcement();
        $announcements = $announcement->isUsed()->limit(1)->order('update_time desc')->field('id,name as title')->select();
        $data['announcement'] = $announcements[0];//todo 判断是否有公告

//        推荐分类
        $cat = new Pinclassify();
        $cats = [];
        if (Config::get_value('index_hot_switch',0)){
            $cats[] = [
                'id'=>'-1',
                'name'=>'热门推荐',
            ];
        }
        if (Config::get_value('index_today_switch',0)){
            $cats[] = [
                'id'=>'-2',
                'name'=>'今日上新',
            ];
        }
        $cats2 = $cat->where('state',1)->field('id,name')->select();
        $data['categorys'] = array_merge($cats,$cats2);

        $data['coupon']=[
            'window'=>Config::get_value('coupon_window_switch'),
            'index'=>Config::get_value('coupon_index_switch'),
        ];

        success_withimg_json($data);
    }

//前端接口默认调用
    public function index(){
        error_json('接口调用错误，请改为[Index|getIndexData]，[控制器|方法]');
    }
    //获取插件信息
    public function getpluginkey(){
        $pluginkey=Db::name('pluginkey')->select();
        $data=array();
        foreach($pluginkey as $val){
            $data['plugin_'.$val['plugin_id']]=$val['name'];
        }

        //        判断多商户是否开启
        $config = \app\model\Config::get(['key'=>'mstore_switch']);
        if (!$config['value']){
            unset($data['plugin_2']);
        }

        success_json($data);
    }

//    添加 formid
//    传入
//        user_id:用户id
//        form_id:formid
    public function addFormid(){
        $data = input("request.");
        if ($data['form_id'] == 'the formId is a mock one'){
            error_json('请用真机调试');
        }
        $data['time'] = time() + 6*24*60*60;
        $formid_model = new Formid();
        $formid_model->allowField(true)->save($data);
        if ($formid_model->id){
            success_json($formid_model->id);
        }
    }
    /**
     * 通用查询运费
     */
    public static function getDistribution($province,$city,$postagerules_id,$weight,$number){
        global $_W;

//        运费规则
        $postagerules = Postagerules::get($postagerules_id);
//        2、运费规则被禁用 ： 运费为0
        if (!$postagerules->state){
            $data['distribution']=0;
            success_json($data);
        }

//        运费规则条目
        $postage_items = json_decode($postagerules->detail);

//        注：省、市都没有重复的，区县有重复
//        当前运费只是根据省市来计算，可以先用文本匹配，
//        todo 如果以后要根据区计算运费，需要改为根据 id 匹配运费

//        匹配规则条目
        $item = null;
        foreach ($postage_items as $postage_item) {
            if(strstr($postage_item->detail,$province) !== false){
                $item = $postage_item;
                break;
            }
            if(strstr($postage_item->detail,$city) !== false){
                $item = $postage_item;
                break;
            }
        }
//        3、找不到符合的规则条目 : 运费为0
        if (!$item){
            $data['distribution']=0;
            success_json($data);
        }

        $count = $number;
//        如果以重量计算运费，则在数量上乘以商品重量
        if($postagerules->type == 2){
            $count = $count*$weight;
        }

        $data['distribution'] = $item->first_price;
        if ($count > $item->first_count){
            $data['distribution'] += ceil(($count - $item->first_count)/$item->next_count)*$item->next_price;
        }

        success_json($data);
    }
    public function getQTData(){
        $setting = System::get_curr();
        $data = [
            'qt_appkey'=>$setting['qt_appkey'],
	        'qt_isopen'=>$setting['qt_isopen'],
        ];

        success_json($data);
    }
}
