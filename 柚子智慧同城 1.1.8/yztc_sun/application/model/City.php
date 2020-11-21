<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/9/12
 * Time: 14:24
 */
namespace app\model;


class City extends Base{
    public $has_uniacid = false;
    //搜索信息
    public function getSearchCity($key){
        $city=$this->where(['name'=>['like',"%$key%"]])->find();
        $selectcity=[];
        $selectcode=[];
        if($city['level']=='province'){
            $city1 = $this->where(['parent_id'=>$city['id']])->select();
            foreach($city1 as $k=>$v){
                $district = $this->where(['parent_id'=>$v['id']])->select();
                foreach($district as $k2=>$v2){
                    $selectcity[] = $city['name'].$v['name'].$v2['name'];
                    $selectcode[] = $v2['adcode'];
                }
            }
        }else if($city['level']=='city'){
            $province = $this->where(['id'=>$city['parent_id']])->find();
            $district = $this->where(['parent_id'=>$city['id']])->select();
            foreach($district as $k=>$v){
                $selectcity[] = $province['name'].$city['name'].$v['name'];
                $selectcode[] = $v['adcode'];
            }
        }else if($city['level']=='district'){
            $city1 = $this->where(['id'=>$city['parent_id']])->find();
            $province = $this->where(['id'=>$city1['parent_id']])->find();
            $selectcity[] = $province['name'].$city1['name'].$city['name'];
            $selectcode[] = $city['adcode'];
        }
        $a = array('name'=>$selectcity);
        $b = array ('adcode'=>$selectcode);
        $test = array('a'=>'name','b'=>'adcode');
        $res = array();
        for($i=0;$i<count($a['name']);$i++){
            foreach($test as $key=>$value){
                $res[$i][$value] = ${$key}[$value][$i];
            }
        }
        return $res;
    }
}