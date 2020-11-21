<?php
defined('IN_IA') or exit('Access Denied');

class Paidapp_WeliamController{
		
	function paiddetail(){
		global $_W,$_GPC;
		$id = $_GPC['id'];
		$paid = pdo_get('wlmerchant_paidrecord',array('id' => $id));
		if($paid['couponid']){
			$couponname = pdo_getcolumn(PDO_NAME.'couponlist',array('id'=>$paid['couponid']),'title');
		}
		if($paid['codeid']){
			$code = pdo_get(PDO_NAME.'token',array('id'=>$paid['codeid']),array('number','status'));
		}
		
		include wl_template('paidhtml/paiddetail');
	}

    /**
     * Comment: 用户领取支付有礼赠送的卡卷
     * Author: zzw
     */
	function getcoupon(){
		global $_W,$_GPC;
		#1、接收基本参数
        $id = $_GPC['id'];
        #2、获取赠送的卡卷id列表
        $paid = pdo_get(PDO_NAME.'paidrecord',array('id' => $id));
        if($paid['getcouflag']){
            //die(json_encode(array('status'=>0,'result'=>'您已成功领取')));
        }
        $pactivity = pdo_get(PDO_NAME.'payactive', array('id' => $paid['activeid']));
        $couponIdList = explode(',',$pactivity['giftcouponid']);
        #3、通过循环判断信息
        if(is_array($couponIdList)){
            $acresult = '';//优惠卷领取状态
            foreach ($couponIdList as $k => $v){
                $coupons = wlCoupon::getSingleCoupons($v, '*');
                $num = wlCoupon::getCouponNum($v, 1);
                //判断卡卷是否能够被领取
                if ($coupons['time_type'] == 1 && $coupons['endtime'] < time()) {
                    $acresult = '[失败]已停止发放';
                }
                if ($coupons['status'] == 0) {
                    $acresult = '[失败]已被禁用';
                }
                if ($coupons['status'] == 3) {
                    $acresult = '[失败]已失效';
                }
                if ($coupons['surplus'] > ($coupons['quantity'] - 1)) {
                    $acresult = '[失败]已被领光';
                }
                if ($num) {
                    if (($num > $coupons['get_limit'] || $num == $coupons['get_limit']) && $coupons['get_limit'] > 0) {
                        $acresult = '[失败]只能领取'.$coupons['get_limit'].'张';
                    }
                }
                //领取状态为空  无异常 开始正常的领取操作
                if(empty($acresult)){
                    //用户领取卡卷的操作
                    if ($coupons['time_type'] == 1) {
                        $starttime = $coupons['starttime'];
                        $endtime = $coupons['endtime'];
                    } else {
                        $starttime = time();
                        $endtime = time() + ($coupons['deadline'] * 24 * 3600);
                    }
                    $data = array(
                        'mid' => $_W['mid'],
                        'aid' => $_W['aid'],
                        'parentid' => $coupons['id'],
                        'status' => 1,
                        'type' => $coupons['type'],
                        'title' => $coupons['title'],
                        'sub_title' => $coupons['sub_title'],
                        'content' => $coupons['goodsdetail'],
                        'description' => $coupons['description'],
                        'color' => $coupons['color'],
                        'starttime' => $starttime,
                        'endtime' => $endtime,
                        'createtime' => time(),
                        'usetimes' => $coupons['usetimes'],
                        'concode' => Util::createConcode(4),
                        'uniacid' => $_W['uniacid']
                    );
                    $res = pdo_insert(PDO_NAME . 'member_coupons', $data);
                    $couponUserId = pdo_insertid();
                    if($res){
                        //修改卡卷的已售数量
                        $newsurplus = $coupons['surplus'] + 1;
                        wlCoupon::updateCoupons(array('surplus' => $newsurplus), array('id' => $v));
                        $url = app_url('wlcoupon/coupon_app/coupondetail',array('id'=>$couponUserId));
                        $acresult = '[成功]领取成功';
                    }else{
                        $acresult = '[失败]领取失败';
                    }
                }
                //发送当前卡卷领取结果的通知
                $storeadminopenid = pdo_getcolumn(PDO_NAME.'member',array('id'=>$_W['mid']),'openid');
                $first = '“'.$coupons['title'].'”领取结果通知';
                $acname = '支付有礼-卡卷领取';
                $remark = '';
                Message::jobNotice($storeadminopenid,$first,$acname,$acresult,$remark,$url);
                $acresult = '';//清除领取状态
            }
        }
        pdo_update(PDO_NAME.'paidrecord',array('getcouflag' => 1,'getcoutime'=>time()),array('id' => $id));
        die(json_encode(array('status'=>1,'result'=>'领取成功')));
	}
}
?>