<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/9/10
 * Time: 11:03
 */
defined('IN_IA') or exit('Access Denied');
/**
 * 更新土地面积信息
 * @param $land
 * @param $uniacid
 * @return mixed
 */
function updateLandArea($land,$uniacid){
    $land_spec=pdo_getall('cqkundian_farm_land_spec',array('uniacid'=>$uniacid,'land_id'=>$list[$i]['id']));
    $all_area=0;
    $is_rent=0;
    for ($j=0;$j<count($land_spec);$j++){
        $all_area+=$land_spec[$j]['area'];
        if($land_spec[$j]['status']){
            $is_rent+=$land_spec[$j]['area'];
        }
    }
    $updateCon=array('all_area'=>$all_area,'area'=>$is_rent,'residue_area'=>$all_area-$is_rent);
    pdo_update('cqkundian_farm_land',$updateCon,array('uniacid'=>$uniacid,'id'=>$list[$i]['id']));
    return $land;
}