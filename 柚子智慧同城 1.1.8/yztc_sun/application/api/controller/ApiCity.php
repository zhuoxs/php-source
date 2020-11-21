<?php
namespace app\api\controller;

use app\model\City;

class ApiCity extends Api
{
    //获取城市详情信息根据编码
    public function getCityByAdcode(){
        $adcode=input('request.adcode');
        $data=(new City())->where(['adcode'=>$adcode])->find();
        success_json($data);
    }
    //搜索城市信息
    public function getSearchCity(){
        $key=input('request.key');
        $data=(new City())->getSearchCity($key);
        success_json($data);
    }
    //获取市区列表
    public function getCityArea(){
        $parent_id=input('request.parent_id');
        $level=input('request.level')?input('request.level'):'city';
        $data=(new City())->where(['parent_id'=>$parent_id,'level'=>$level])->select();
        success_json($data);
    }
    //获取省列表
    public function getProvinceList(){
        $data=(new City())->where(['level'=>'province'])->select();
        success_json($data);
    }

    //根据市和区获取编码详情信息
    public function getAddressToAdcodeByCity(){
        $city=input('request.city');
        $area=input('request.area');
        $data=[
            'city'=>$city,
            'area'=>$area
        ];
        $data=$this->getCity($data);
        success_json($data);
    }

    //根据地址转换编码详情信息
    public function getAddressToAdcodeDetail(){
        $address=input('request.address');
        $data=getCity($address);
        $data=$this->getCity($data);
        success_json($data);
    }
    //根据地址匹配省市区
    public function getAddressToCity(){
        $address=input('request.address');
        $data=getCity($address);
        success_json($data);
    }
    //获取省市编码信息
    public function getCity($data){
        $city=City::get(['name'=>$data['city'],'level'=>'city']);
        if(!$city){
            return false;
        }
        $data=City::get(['citycode'=>$city['citycode'],'name'=>$data['area'],'level'=>'district']);
        if(!$data){
            return false;
        }
        return $data;
    }
}
