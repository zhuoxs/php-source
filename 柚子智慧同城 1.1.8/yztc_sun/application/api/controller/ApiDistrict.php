<?php
namespace app\api\controller;

use app\model\District;


class ApiDistrict extends Api
{
    //获取省市区
    public function getProvinceCityZip(){
        $type=input('request.type');;
        $district=new District();
        $data=$district->getProvinceCityZip($type);
        success_json($data);
    }
}
