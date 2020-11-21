<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/12/3
 * Time: 14:04
 */
namespace app\api\controller;

use app\model\Ad;
use app\model\Announcement;
use app\model\Car;
use app\model\Customize;
use app\model\System;
use app\model\User;
use app\model\Store;
use app\model\Info;
use app\model\Formid;


class ApiIndex extends Api
{
    //获取首页天气信息和时间
    public function getWeatherDetail(){
        $weekarray=array("日","一","二","三","四","五","六");
        $data=[
            'date'=>date('Y-m-d'),
            'icon'=>System::get_curr()['weather_icon'],
            'week'=>"星期".$weekarray[date("w")],
        ];
        success_json($data);
    }
    //获取统计信息(用户量、商户量、浏览量)
    public function getStatistics(){
        $data=[
            'user_num'=>(new User())->getUserNum(),
            'store_num'=>(new Store())->getStoreNum(),
            'browse_num'=>(new Info())->getPageviewsNum(),
            'info_num'=>(new Info())->getInfoNum(),
        ];
        success_json($data);
    }
    //TODO::首页
    public function index(){
        $ad=new Ad();
        /**广告位*/
        $data['ad20']=$ad->getBanner(20);
        $data['ad21']=$ad->getBanner(21);
        $data['ad22']=$ad->getBanner(22);
        $data['ad23']=$ad->getBanner(23);
        $data['ad24']=$ad->getBanner(24);
        success_withimg_json($data);
    }
    //TODO::底部导航图标
   public function navIcon(){
        global $_W;
        $model=new Customize();
        $list=$model->where(['uniacid'=>$_W['uniacid'],'state'=>1,'type'=>3])->order(['sort'=>'asc'])->select();
        success_withimg_json($list);
   }
    //TODO::系统设置
    public function systemSet(){
        $data=System::get_curr();
        success_withimg_json($data);
    }
    //TODO::公告
    public function notic(){
        global $_W;
        $model=new Announcement();
        $list=$model->where(['state'=>1])->select();
        success_json($list);
    }
    //TODO::菜单图标
    public function menuIcon(){
        global $_W;
        $system=System::get_curr();
        if($system['show_type']==1){
            $model=new Customize();
            $list=$model->where(['uniacid'=>$_W['uniacid'],'state'=>1,'type'=>2])->order(['sort'=>'asc'])->select();
        }else if($system['show_type']==2){
            $list=$this->getInfoAppUrl();
        }else if($system['show_type']==3){
            $list=$this->getStoreAppUrl();
        }
        success_withimg_json($list);
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
}