<?php
/**
 * Created by PhpStorm.
 * User: 坤典科技
 * Date: 2018/10/10
 * Time: 17:06
 */
defined("IN_IA")or exit("Access Denied");
class User_KundianFarmModel{
    public $tableName='cqkundian_farm_user';
    public $goldTableName='cqkundian_farm_plugin_play_gold_record';
    public $integral_record='cqkundian_farm_integral_record';
    public $money_withdraw='cqkundian_farm_money_withdraw';
    public $money_record='cqkundian_farm_money_record';
    public $sign='cqkundian_farm_sign';
    public function __construct($tableName='cqkundian_farm_user'){
        if($tableName){
            $this->tableName=$tableName;
        }

    }

    public function getUserByUid($uid,$uniacid){
        $list=pdo_get($this->tableName,array('uniacid'=>$uniacid,'uid'=>$uid));
        return $list;
    }

    public function getUserByCon($con,$mutilple=true,$filed=array()){
        if($mutilple){
            $list=pdo_getall($this->tableName,$con,$filed);
        }else{
            $list=pdo_get($this->tableName,$con,$filed);
        }
        return $list;
    }

    public function updateUser($updateData,$con){
        $res=pdo_update($this->tableName,$updateData,$con);
        return $res;
    }

    /**
     * 获取用户优惠券
     * @param $con
     * @return array
     */
    public function getUserCoupon($con,$pageIndex='',$pageSize='',$order_by='create_time desc'){
        if(!empty($pageIndex) && !empty($pageSize)){
            $list=pdo_getall('cqkundian_farm_user_coupon',$con,'','',$order_by,array($pageIndex,$pageSize));
        }else{
            $list=pdo_getall('cqkundian_farm_user_coupon',$con,'','',$order_by);
        }
        return $list;
    }

    /**
     * 根据优惠券id获取数据
     * @param $id
     * @param $uniacid
     * @return bool
     */
    public function getCouponById($id,$uniacid,$type=''){
        if(!empty($type)){
            $list=pdo_get('cqkundian_farm_shop_coupon', array('uniacid' => $uniacid, 'id' => $id,'type'=>$type));    
        }else{
            $list=pdo_get('cqkundian_farm_shop_coupon', array('uniacid' => $uniacid, 'id' => $id));    
        }
        
        return $list;
    }


    /**
     * 整理优惠券信息
     * @param $userCoupon
     * @param $uniacid
     * @return mixed
     */
    public function neatenCoupon($userCoupon,$uniacid){
        for ($i=0;$i<count($userCoupon);$i++){
            $coupon=$this->getCouponById($userCoupon[$i]['cid'],$uniacid);
            if($userCoupon[$i]['status']==1){
                $userCoupon[$i]['state']=1;  //已使用
            }else{
                //优惠券是否过期
                if ($coupon['expiry_date'] == 1) {
                    $coupon['expiry_time']=date("Y-m-d", ($userCoupon[$i]['create_time'] + ($coupon['expiry_day'] * 86400)));
                    if (($userCoupon[$i]['create_time'] + ($coupon['expiry_day'] * 86400)) > time()) { //未过期
                        $userCoupon[$i]['state']=0;
                    }else{
                        $userCoupon[$i]['state']=2;  //已过期
                    }
                } else {
                    if (time() < $coupon['end_time']) {
                        $userCoupon[$i]['state']=0;
                    }else{
                        $userCoupon[$i]['state']=2;
                    }
                }
            }
            if($coupon['expiry_date']==2){
                $coupon['begin_time'] = date("Y-m-d", $coupon['begin_time']);
                $coupon['end_time'] = date("Y-m-d", $coupon['end_time']);
            }else{
                $coupon['expiry_time']=date("Y-m-d", ($userCoupon[$i]['create_time'] + ($coupon['expiry_day'] * 86400)));
            }
            if($coupon['type']==1){
                $coupon['type_chinese_name']='普通商城可用';
            }elseif ($coupon['type']==2){
                $coupon['type_chinese_name']='组团商城可用';
            }elseif ($coupon['type']==3){
                $coupon['type_chinese_name']='畜牧领养可用';
            }elseif ($coupon['type']==4){
                $coupon['type_chinese_name']='租地可用';
            }elseif ($coupon['type']==5){
                $coupon['type_chinese_name']='种子购买可用';
            }
            $userCoupon[$i]['coupon']=$coupon;
            $userCoupon[$i]['create_time']=date("Y-m-d",$userCoupon[$i]['create_time']);
        }

        return $userCoupon;
    }

    /**
     * 判断当前用户是否有可用的优惠券
     * @param $uid          用户uid
     * @param $totalPrice   订单总价
     * @param $uniacid      小程序唯一id
     * @param $type         1普通商城 2组团商城 3认养 4土地 5种子
     * @return array        返回值
     */
    public function jugdeUserCoupon($uid,$totalPrice,$uniacid,$type){
        $couponCount=0;
        $arr=array();
        $userCoupon=$this->getUserCoupon(array('uniacid'=>$uniacid,'uid'=>$uid,'status'=>0));

        if(!empty($userCoupon)) {
            for ($i = 0; $i < count($userCoupon); $i++) {
                //$coupon = pdo_get('cqkundian_farm_shop_coupon', array('uniacid' => $uniacid, 'id' => $userCoupon[$i]['cid'], 'type' => 1));
                $coupon=$this->getCouponById($userCoupon[$i]['cid'],$uniacid,$type);
                //优惠券是否过期
                if ($coupon['expiry_date'] == 1) {
                    if (($userCoupon[$i]['create_time'] + ($coupon['expiry_day'] * 86400)) > time()) {
                        if ($coupon['low_cash_price'] < $totalPrice) {  //判断订单金额是否大于优惠消费最低金额
                            $couponCount += 1;
                            $arr[]=$userCoupon[$i];
                        }
                    }
                } else {
                    if (time() > $coupon['begin_time'] && time() < $coupon['end_time']) {
                        if ($coupon['low_cash_price'] < $totalPrice) {  //判断订单金额是否大于优惠消费最低金额
                            $couponCount += 1;
                            $arr[]=$userCoupon[$i];
                        }
                    }
                }
            }
        }
        return array('arr'=>$arr,'couponCount'=>$couponCount);
    }


    /**
     * 更新提现记录
     * @param $updateData
     * @param $con
     * @return bool
     */
    public function updateUserWithdraw($updateData,$con){
        $res=pdo_update('cqkundian_farm_money_withdraw',$updateData,$con);
        return $res;
    }

    public function getUserWithdrawById($id,$uniacid){
        $list=pdo_get('cqkundian_farm_money_withdraw',array('id'=>$id,'uniacid'=>$uniacid));
        return $list;
    }


    public function insertRecordMoney($uid,$money,$do_type,$body,$uniacid){
        $user=$this->getUserByUid($uid,$uniacid);
        $data=array(
            'uid'=>$uid,
            'money'=>$money,
            'do_type'=>$do_type,
            'body'=>$body,
            'uniacid'=>$uniacid,
            'create_time'=>time(),
            'balance_money'=>$user['money'],
        );
        $res=pdo_insert('cqkundian_farm_money_record',$data);
        return $res ? true : false;
    }

    /**
     * 获取用户uid
     * @param $con
     * @return array
     */
    public function getUidArr($con){
        $userData=$this->getUserByCon($con);
        $uid_arr=array();
        for($i=0;$i<count($userData);$i++){
            $uid_arr[]=$userData[$i]['uid'];
        }
        return $uid_arr;
    }

    /**
     * 记录积分信息
     * @param $orderData
     * @param $uid
     * @param $uniacid
     * @param $score_type 1加 2减
     * @return bool
     */
    public function insertScoreRecord($orderData,$uid,$uniacid,$score_type){
        $aboutData=pdo_get('cqkundian_farm_about',['uniacid'=>$uniacid]);
        if($score_type==2){
            $score=(int)$orderData['total_price'];
            $update['score -=']=$score;
        }else{
            $score=round(floatval($orderData['total_price'])/floatval($aboutData['pay_integral']));
            $update['score +=']=$score;
        }

        if($score > 0) {
            pdo_update($this->tableName,$update,['uid'=>$orderData['uid'],'uniacid'=>$uniacid]);
            $userData=pdo_get('cqkundian_farm_user',['uid'=>$orderData['uid'],'uniacid'=>$uniacid]);
            $insertData = [
                'uid' => $orderData['uid'],
                'uniacid' => $uniacid,
                'create_time' => time(),
                'score_type' => $score_type,
                'score' => $score,
                'body' => $orderData['body'],
                'now_score' => $userData['score'],
            ];
            $res = pdo_insert('cqkundian_farm_integral_record', $insertData);
            return $res ? true : false;
        }
        return true;
    }

    /** 查询签到记录 */
    public function getSignList($cond,$pageIndex,$pageSize=15){
        $query = load()->object('query');
        $list = $query->from($this->sign, 'a')->leftjoin($this->tableName, 'b')->on('a.uid', 'b.uid')
            ->select('a.*','b.nickname','b.continue_day')->where($cond)->orderby('id desc')->page($pageIndex,$pageSize)->getall();
        for($i=0;$i<count($list);$i++){
            $list[$i]['sign_time']=date('Y-m-d H:i:s',$list[$i]['sign_time']);
        }
        return $list;
    }

    /** Save the shipping address */
    public function editAddress($data){
        $insertData=[
            'uid'=>$data['uid'],
            'region'=>$data['region'],
            'uniacid'=>$data['uniacid'],
            'address'=>$data['address'],
            'name'=>$data['name'],
            'phone'=>$data['phone']
        ];
        if(empty($data['id'])){
            return pdo_insert('cqkundian_farm_address',$insertData);
        }
        return pdo_update('cqkundian_farm_address',$insertData,['id'=>$data['id']]);
    }
}