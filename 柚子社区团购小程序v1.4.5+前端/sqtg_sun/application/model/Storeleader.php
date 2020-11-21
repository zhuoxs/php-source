<?php

namespace app\model;

use app\base\model\Base;
use \think\Db;

class Storeleader extends Base
{
    public function leader(){
        return $this->hasOne('Leader','id','leader_id')->bind(array(
            'name',
            'openid'=>'openid',
            'pic'=>'img',
        ));
    }
    public function leaders(){
        return $this->hasMany('Leader','id','leader_id')->with('user');
    }
    public function onStoreChecked($info){
        global $_W;
        $longitude = $info['longitude'];
        $latitude = $info['latitude'];
        $distance = $info['distance']*1000;

        $list = Db::query("
            select t1.id 
            from ".tablename('sqtg_sun_leader')." t1
            where t1.check_state = 2
            and convert(acos(cos($latitude*pi()/180 )*cos(t1.latitude*pi()/180)*cos($longitude*pi()/180 -t1.longitude*pi()/180)+sin($latitude*pi()/180 )*sin(t1.latitude*pi()/180))*6370996.81,decimal) <= {$distance}
            and t1.uniacid = {$_W['uniacid']}
        ");

        foreach ($list as $item) {
            $data = [
                'store_id'=>$info['id'],
                'leader_id'=>$item['id'],
            ];

            $storeleader = Storeleader::get($data);
            if ($storeleader){
                continue;
            }
            $model = new Storeleader($data);
            $model->save();
        }
    }
    public function onLeaderChecked($info){
        global $_W;
        $longitude = $info['longitude'];
        $latitude = $info['latitude'];

        $list = Db::query("
            select t1.id 
            from ".tablename('sqtg_sun_store')." t1
            where t1.check_state = 2
            and convert(acos(cos($latitude*pi()/180 )*cos(t1.latitude*pi()/180)*cos($longitude*pi()/180 -t1.longitude*pi()/180)+sin($latitude*pi()/180 )*sin(t1.latitude*pi()/180))*6370996.81,decimal) <= t1.distance
            and t1.uniacid = {$_W['uniacid']}
        ");

        foreach ($list as $item) {
            $data = [
                'store_id'=>$item['id'],
                'leader_id'=>$info['id'],
            ];

            $storeleader = Storeleader::get($data);
            if ($storeleader){
                continue;
            }
            $model = new Storeleader($data);
            $model->save();
        }
    }

    /**
     * @param Leader $info 团长
     */
    public function onLeaderDeleted(Leader $info){
        Storeleader::where('leader_id',$info->id)->delete();
    }
    public function onStoreDeleted(Store $info){
        Storeleader::where('store_id',$info->id)->delete();
    }
}
