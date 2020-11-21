<?php

namespace app\model;
use think\Db;
class User extends Base
{
    //统计用户人数
    public function getUserNum(){
        $data=$this->count();
        return $data;
    }
//      判断是不是分销商
//      如果是分销商，则返回对应id
//      否则，返回 false
    public static function isDistribution($id)
    {
        if (!pdo_tableexists('yztc_sun_distribution')) {
            return false;
        }
        $distribution = Distribution::get(['user_id' => $id, 'check_status' => 2]);
        return !!$distribution ? $distribution['id'] : false;
    }

    //TODO::修改会员时间
    public function editVip($user_id, $tel, $day)
    {
        $userinfo = User::get($user_id);
        if (empty($userinfo['tel'])) {
            $data['tel'] = $tel;
        }
        if (empty($userinfo['vip_cardnum'])) {
            $data['vip_cardnum'] = 10000000 + $user_id;
        }
        if (empty($userinfo['vip_endtime'])||($userinfo['vip_endtime']<time())) {
            $data['vip_endtime'] = time() + $day * 3600 * 24;
        } else {
            $data['vip_endtime'] = $userinfo['vip_endtime'] + $day * 3600 * 24;
        }
        User::update($data, ['id' => $user_id]);
    }
    //判断是否vip
    public static function isVip($user_id){
        $userinfo=User::get($user_id);
        if($userinfo['vip_endtime']>time()){
            return 1;
        }else{
            return 0;
        }
    }
    public function check_version(){
        $config=getSystemConfig()['system'];
        if(StrCode($config['version'],'DECODE')!='advanced'){
            if(StrCode($config['version'],'DECODE')=='free'){
                $this->check_store_num(intval(StrCode($config['member_num'],'DECODE')));
            }else{
                throw new \ZhyException(getErrorConfig('genuine'));
            }
        }
    }
    //获取数量
    private function check_store_num($num){
        $total_store_num=Db::name('user')->where(array('is_member'=>1))->count();
        if($num>0&&$num<=100){
            if($total_store_num>=$num){
                throw new \ZhyException(getErrorConfig('member_num'));
            }
        }else if($num>100){

        }else{
            throw new \ZhyException(getErrorConfig('genuine'));
        }
    }
}
