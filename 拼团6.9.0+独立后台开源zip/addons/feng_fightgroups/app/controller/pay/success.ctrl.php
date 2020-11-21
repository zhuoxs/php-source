<?php
/**
 * [weliam] Copyright (c) 2016/3/23
 * success.ctrl
 * 支付成功控制器
 */
defined('IN_IA') or exit('Access Denied');
$op = !empty($_GPC['op']) ? $_GPC['op'] : 'display';

$pagetitle = '支付结果';
if($op =='display'){
	if($_GPC['money']){
		
	}else{
		$orderid = $_GPC['orderid'];
		$errno = $_GPC['errno'];
		$order = model_order::getSingleOrder($orderid, '*');
		if($order['getcouponid']){
			$coupon = model_coupon::coupon_template($order['getcouponid']);
			$order['couponname'] = $coupon['name'];
		}
		if($order['giftid']){
			$gift = model_goods::getSingleGoods($order['giftid'], '*');
			$order['giftname'] = $gift['gname'];
		}
	}
	include wl_template('pay/success');
}
if($op =='activity'){
	wl_load()->model('credit');
	wl_load()->model('member');
	wl_load()->model('setting');
	checkMember($_W['openid']);
	$member = getMember($_W['openid']);
	$setting=setting_get_by_name("member");
	$credit_type = $setting['credit_type']?$setting['credit_type']:1;
	
	$get = 'success';
	$winning_rate = rand(0, 100);
	$all_num = 0;
	$con='';
	if(!empty($_GPC['id'])){
		$con .= "  and id = {$_GPC['id']} " ;
	}
	$scratch = pdo_fetch("select * from".tablename('tg_scratch')."where status=1 $con ");
	if(!empty($scratch['use_credits'])){
		$result=credit_get_by_uid($member['uid'],$credit_type);
		if($scratch['use_credits']>$result['credit1']){
			message("您的积分不够!");
		}
	}
	if(empty($scratch)){
		message("该活动已关闭");
	}
	if($scratch['join_times']==1){
		$yes = pdo_fetch("select id from". tablename('tg_scratch_record') ."where openid='{$_W['openid']}' and activity_id={$scratch['id']}");
		if($yes){
			$get = '次数限制';
		}
	}
	if($scratch['join_times']==2){
		$today = strtotime(date('Y-m-d'));
		$yd = strtotime(date('Y-m-d')) + 24*60*60;
		$yes = pdo_fetch("select id from". tablename('tg_scratch_record') ."where openid='{$_W['openid']}' and activity_id={$scratch['id']} and createtime>'{$today}' and createtime<'{$yd}' ");
		if($yes){
			$get = '次数限制';
		}
	}
	if($scratch['join_times']==3){
		$today = strtotime(date('Y-m-d'));
		$yd = strtotime(date('Y-m-d')) + 24*60*60;
		$yes = pdo_fetchall("select id from". tablename('tg_scratch_record') ."where openid='{$_W['openid']}' and activity_id={$scratch['id']} and createtime>'{$today}' and createtime<'{$yd}' ");
		$num = count($yes);
//		if( $num>= 2){
//			$get = '次数限制';
//		}
	}
	$prize = unserialize($scratch['prize']);
	if($winning_rate > $scratch['winning_rate']){
		//中奖了
		$get = 'fail';
	}
	foreach($prize as $key=>$value){
		$all_num += $value['num'];
	}
	foreach($prize as $key=>&$value){
		if($value['radio']==1){
			$value['p']='积分：'.$value['credits']; 
		}elseif($value['radio']==2){
			$sql = "select * from".tablename('tg_coupon_template')." WHERE uniacid = {$_W['uniacid']} and id={$value['coupon_id']}";
			$tg_coupon_templates = pdo_fetch($sql);
			$value['p']='优惠券：'.$tg_coupon_templates['name']; 
		}elseif($value['radio']==3){
			$time = time();
			$sql = "select * from".tablename('tg_gift')." WHERE uniacid = {$_W['uniacid']} and starttime<'{$time}' and endtime>'{$time}' and id={$value['gift_id']}";
			$gift = pdo_fetch($sql);
			$value['p']='赠品：'.$gift['name']; 
		}
		if($key == 'first'){
			$first_rate = $value['num'];
		}
		if($key == 'second'){
			$second_rate = $value['num'];
		}
		if($key == 'third'){
			$third_rate = $value['num'];
		}
		if($key == 'forth'){
			$forth_rate = $value['num'];
		}
	}
	include wl_template('common/activity');
}
if($op =='activity_ajax'){
	wl_load()->model('credit');
	wl_load()->model('member');
	wl_load()->model('setting');
	checkMember($_W['openid']);
	$member = getMember($_W['openid']);
	$setting=setting_get_by_name("member");
	$credit_type = $setting['credit_type']?$setting['credit_type']:1;
	$zj= $_GPC['zj'];
	$con='';
	if(!empty($_GPC['id'])){
		$con .= " and id = {$_GPC['id']} " ;
	}
	$scratch = pdo_fetch("select * from".tablename('tg_scratch')."where status=1 $con ");
	$prize = unserialize($scratch['prize']);
	if(!empty($scratch['use_credits'])){
		$s=credit_update_credit1($member['uid'],0-$scratch['use_credits'],$credit_type,"刮刮卡消耗积分");
	}
	
	foreach($prize as $key=>$value){
		if($zj == $key){
			if($value['radio']==1){
				$prize1='积分：'.$value['credits']; 
				credit_update_credit1($member['uid'],$value['credits'],$credit_type,"刮刮卡中奖获得积分");
				$status = 3;
			}elseif($value['radio']==2){
				$sql = "select * from".tablename('tg_coupon_template')." WHERE uniacid = {$_W['uniacid']} and id={$value['coupon_id']}";
				$tg_coupon_templates = pdo_fetch($sql);
				$prize1='优惠券：'.$tg_coupon_templates['name']; 
				wl_load()->model('activity');
				$coupon = coupon_grant($_W['openid'],$value['coupon_id']);
				$status = 3;
			}elseif($value['radio']==3){
				$time = time();
				$sql = "select * from".tablename('tg_gift')." WHERE uniacid = {$_W['uniacid']} and starttime<'{$time}' and endtime>'{$time}' and id={$value['gift_id']}";
				$gift = pdo_fetch($sql);
				$prize1='赠品：'.$gift['name']; 
				$status = 2;
			}
		}
	}
	$data = array(
		'uniacid'=>$_W['uniacid'],
		'openid'=>$_W['openid'],
		'activity_id'=>$scratch['id'],
		'type'=>'scratch',
		'status'=>$status,
		'createtime'=>TIMESTAMP,
		'prize'=>$prize1
	);
	pdo_insert('tg_scratch_record',$data);
	$url = app_url('member/home/activity');
	activity_result($_W['openid'], $scratch['name'], $prize1, $url);
	die(json_encode(array('errno'=>0,'prize'=>$prize1)));
}