<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/12/26
 * Time: 15:05
 */
namespace app\model;


use think\Db;

class Openvip extends Base
{
    public function userinfo(){
        return $this->hasOne('User','id','user_id')->bind(array(
            'nickname'=>'nickname',
            'avatar'=>'avatar'
        ));
    }
    //TODO::添加开卡记录
    public function addLog($type,$setid=0,$name='',$code='',$user_id,$day,$uniacid,$money=0,$out_trade_no='',$transaction_id='',$share_user_id=0){
        $data['type']=$type;
        $data['setid']=$setid;
        $data['name']=$name;
        $data['code']=$code;
        $data['user_id']=$user_id;
        $data['day']=$day;
        $data['create_time']=time();
        $data['uniacid']=$uniacid;
        $data['money']=$money;
        $data['out_trade_no']=$out_trade_no;
        $data['transaction_id']=$transaction_id;
        $data['share_user_id']=$share_user_id;
        Db::name('openvip')->insert($data);
        $id=Db::name('openvip')->getLastInsID();
        return $id;
    }
}