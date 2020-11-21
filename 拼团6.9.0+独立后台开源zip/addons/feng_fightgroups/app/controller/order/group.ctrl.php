<?php
/**
 * [weliam] Copyright (c) 2016/3/23
 * goods.ctrl
 * 团详情控制器
 */
// model_group::doLottery('107','1054');
wl_load()->model('member');
defined('IN_IA') or exit('Access Denied');
$tuan_id = intval($_GPC['tuan_id']);

if(!empty($tuan_id)){
    //取得该团所有订单
    $ordersData=model_order::getNumOrder('*', array('#is_tuan#'=>'(1,3)','#status#'=>'(1,2,3,4,6,7)','tuan_id'=>$tuan_id), 'ptime asc', 0, 0, 0);
    $orders = $ordersData[0];
    foreach($orders as$key =>$value){
    	if($value['mobile']=='虚拟'){
    		$orders[$key]['avatar'] = $value['openid'];
			$orders[$key]['nickname'] =  $value['addname'];
    	}else{
			$fans = getMember($value['openid']);
			if (!empty($fans)) {
				$avatar = $fans['avatar'];
				$nickname=$fans['nickname'];
			}
    		$orders[$key]['avatar'] = $avatar;
			$orders[$key]['nickname'] = $nickname;
    	}
    }

    $order = pdo_fetch("select g_id from".tablename('tg_order')."where tuan_id = {$tuan_id} and tuan_first = 1 "); //取团长订单$order
    $myorder = pdo_fetch("select g_id,lottery_status from".tablename('tg_order')."where openid = '{$_W['openid']}' and tuan_id = {$tuan_id} and status in(1,2,3,4,6,7) ");
  	//团状态
  	$tuaninfo = model_group::getSingleGroup($tuan_id, '*');
  	if($tuaninfo['iflottery'] && $tuaninfo['lottery_id']>0) {
  		$lottery = pdo_fetch("select * from".tablename('tg_lottery')."where id = {$tuaninfo['lottery_id']}");
		if($lottery['pattern'] == 2){
			switch($myorder['lottery_status']){
					case 1: $myStatus = ($tuaninfo['groupstatus']==2)?'未中':'待抽奖';
		    				$myStatus2 = ($tuaninfo['groupstatus']==2)?'很遗憾您与大奖擦肩而过':'请耐心等待抽奖';break;
		    		case 2: $myStatus = '一等奖';$myStatus2 = '恭喜获得一等奖';break;
		    		case 3: $myStatus = '二等奖';$myStatus2 = '恭喜获得二等奖';break;
		    		case 4: $myStatus = '未中';$myStatus2 = '很遗憾您与大奖擦肩而过';break;
		    		case 5: $myStatus = ($tuaninfo['groupstatus']==2)?'一等奖':'待抽奖';$myStatus2 = ($tuaninfo['groupstatus']==2)?'恭喜获得一等奖':'';break;
		    		case 6: $myStatus = ($tuaninfo['groupstatus']==2)?'二等奖':'待抽奖';$myStatus2 = ($tuaninfo['groupstatus']==2)?'恭喜获得二等奖':'';break;
		    		case 7: $myStatus = ($tuaninfo['groupstatus']==2)?'未中':'待抽奖';$myStatus2 = ($tuaninfo['groupstatus']==2)?'很遗憾您与大奖擦肩而过':'';break;
					default:$myStatus = ($tuaninfo['groupstatus']==2)?'组团失败，未能抽奖':'抽奖团组团中';break;
		    	}
			$where['tuan_id'] = $tuaninfo['groupnumber'];
		}else {
			switch($myorder['lottery_status']){
					case -1: $myStatus = $lottery['dostatus']?'组团失败，未能抽奖':'抽奖团组团中';
							 $myStatus2 = $lottery['dostatus']?'谢谢您的参与！！':'快邀请好友参与抽奖团吧！！'; break;
		    		case 1: $myStatus = $lottery['dostatus']?'组团成功，未中奖':'组团成功，待抽奖';
		    				$myStatus2 = $lottery['dostatus']?'很遗憾您与大奖擦肩而过':'请耐心等待抽奖';break;
		    		case 2: $myStatus = '一等奖';$myStatus2 = '恭喜获得一等奖';break;
		    		case 3: $myStatus = '二等奖';$myStatus2 = '恭喜获得二等奖';break;
		    		case 4: $myStatus = '未中';$myStatus2 = '很遗憾您与大奖擦肩而过';break;
		    		case 5: $myStatus = $lottery['dostatus']?'一等奖':'待抽奖';$myStatus2 = $lottery['dostatus']?'恭喜获得一等奖':'';break;
		    		case 6: $myStatus = $lottery['dostatus']?'二等奖':'待抽奖';$myStatus2 = $lottery['dostatus']?'恭喜获得二等奖':'';break;
		    		case 7: $myStatus = $lottery['dostatus']?'未中':'待抽奖';$myStatus2 = $lottery['dostatus']?'很遗憾您与大奖擦肩而过':'';break;
		    	}
		}
			$where['lotteryid'] = $lottery['id'];
			$where['#is_tuan#'] = '(1,3)';
			$where['#status#'] = '(1,2,3,4,6,7)';
			$numb = $_GPC['numb']?$_GPC['numb']:1;
			if($_GPC['numb']==2 && !empty($lottery['dostatus'])){
					$where['#lottery_status#'] = '(2,3,4,5,6,7)';
			}elseif($_GPC['numb']==2 && empty($lottery['dostatus'])){
				$where['#lottery_status#'] = '(100)';
			}else{
				$where['#lottery_status#'] = '(-1,1,2,3,4,5,6,7)';
			}
			$pindex = max(1,$_GPC['pindex']);
			$ordersLotteryData=model_order::getNumOrder('openid,addname,mobile,addname,createtime,lottery_status', $where, 'lottery_status asc,ptime asc', $pindex, 10, 1);
		    $ordersLottery = $ordersLotteryData[0];
		    foreach($ordersLottery as$key =>&$value){
		    	$value['ctime'] = date('Y-m-d H:i:s',$value['createtime']);
				if($lottery['pattern'] == 2){
					switch($value['lottery_status']){
						case 1: $ordersLottery[$key]['lottery_status_name'] = ($tuaninfo['groupstatus']==2)?'未中':'待抽奖';break;
			    		case 2: $ordersLottery[$key]['lottery_status_name'] = '一等奖';break;
			    		case 3: $ordersLottery[$key]['lottery_status_name'] = '二等奖';break;
			    		case 4: $ordersLottery[$key]['lottery_status_name'] = '未中';break;
			    		case 5: $ordersLottery[$key]['lottery_status_name'] = ($tuaninfo['groupstatus']==2)?'一等奖':'待抽奖';break;
			    		case 6: $ordersLottery[$key]['lottery_status_name'] = ($tuaninfo['groupstatus']==2)?'二等奖':'待抽奖';break;
			    		case 7: $ordersLottery[$key]['lottery_status_name'] = ($tuaninfo['groupstatus']==2)?'未中':'待抽奖';break;
						default:$ordersLottery[$key]['lottery_status_name'] = ($tuaninfo['groupstatus']==2)?'组团失败':'组团中';break;
			    	}
				}else {
					switch($value['lottery_status']){
						case -1: $ordersLottery[$key]['lottery_status_name'] = $lottery['dostatus']?'未中':'组团中';break;
			    		case 1: $ordersLottery[$key]['lottery_status_name'] = $lottery['dostatus']?'未中':'待抽奖';break;
			    		case 2: $ordersLottery[$key]['lottery_status_name'] = '一等奖';break;
			    		case 3: $ordersLottery[$key]['lottery_status_name'] = '二等奖';break;
			    		case 4: $ordersLottery[$key]['lottery_status_name'] = '未中';break;
			    		case 5: $ordersLottery[$key]['lottery_status_name'] = $lottery['dostatus']?'一等奖':'待抽奖';break;
			    		case 6: $ordersLottery[$key]['lottery_status_name'] = $lottery['dostatus']?'二等奖':'待抽奖';break;
			    		case 7: $ordersLottery[$key]['lottery_status_name'] = $lottery['dostatus']?'未中':'待抽奖';break;
			    	}
				}
		    	if($value['mobile']=='虚拟'){
		    		$ordersLottery[$key]['avatar'] = $value['openid'];
					$ordersLottery[$key]['nickname'] =  $value['addname'];
		    	}else{
					$fans = member_get_by_params(" openid = '{$value['openid']}'");
					if (!empty($fans)) {
						$avatar = $fans['avatar'];
						$nickname=$fans['nickname'];
					}
		    		$ordersLottery[$key]['avatar'] = $avatar;
					$ordersLottery[$key]['nickname'] = $nickname;
		    	}
		    }
			if( $lottery['pattern'] == 2 && $tuaninfo['groupstatus']==2){
				$where['tuan_id'] = $tuaninfo['groupnumber'];
				$where['#lottery_status#'] = '(2,3,4)'; //qqm
				$ordersLotteryZD = model_order::getNumOrder('openid,addname,mobile,addname,createtime,lottery_status', $where, 'lottery_status asc', $pindex, 10, 1);
				$ordersLotteryZ = $ordersLotteryZD[0];
				foreach($ordersLotteryZ as$key =>&$value){
			    	$value['ctime'] = date('Y-m-d H:i:s',$value['createtime']);
//			    	$ordersLotteryZ[$key]['lottery_status_name'] = '中奖';
					switch($value['lottery_status']){//qqm
			    		case 1: $ordersLotteryZ[$key]['lottery_status_name'] = $lottery['dostatus']?'未中':'待抽奖';break;
			    		case 2: $ordersLotteryZ[$key]['lottery_status_name'] = '一等奖';break;
			    		case 3: $ordersLotteryZ[$key]['lottery_status_name'] = '二等奖';break;
			    		case 4: $ordersLotteryZ[$key]['lottery_status_name'] = '未中';break;
			    		case 5: $ordersLotteryZ[$key]['lottery_status_name'] = $lottery['dostatus']?'一等奖':'待抽奖';break;
			    		case 6: $ordersLotteryZ[$key]['lottery_status_name'] = $lottery['dostatus']?'二等奖':'待抽奖';break;
			    		case 7: $ordersLotteryZ[$key]['lottery_status_name'] = $lottery['dostatus']?'未中':'待抽奖';break;
						default:$ordersLotteryZ[$key]['lottery_status_name'] = '未组团成功';break;
			    	}
			    	if($value['mobile']=='虚拟'){
			    		$ordersLotteryZ[$key]['avatar'] = $value['openid'];
						$ordersLotteryZ[$key]['nickname'] =  $value['addname'];
			    	}else{
						$fans = member_get_by_params(" openid = '{$value['openid']}'");
						if (!empty($fans)) {
							$avatar = $fans['avatar'];
							$nickname=$fans['nickname'];
						}
			    		$ordersLotteryZ[$key]['avatar'] = $avatar;
						$ordersLotteryZ[$key]['nickname'] = $nickname;
			    	}
		    	}
			}
			if(!empty($lottery['dostatus'])){
				$where['#lottery_status#'] = '(2,3,4,5,6,7)';
				$ordersLotteryZD = model_order::getNumOrder('openid,addname,mobile,addname,createtime,lottery_status', $where, 'lottery_status asc', $pindex, 10, 1);
				$ordersLotteryZ = $ordersLotteryZD[0];
				foreach($ordersLotteryZ as$key =>&$value){
			    	$value['ctime'] = date('Y-m-d H:i:s',$value['createtime']);
			    	switch($value['lottery_status']){
			    		case 1: $ordersLotteryZ[$key]['lottery_status_name'] = $lottery['dostatus']?'未中':'待抽奖';break;
			    		case 2: $ordersLotteryZ[$key]['lottery_status_name'] = '一等奖';break;
			    		case 3: $ordersLotteryZ[$key]['lottery_status_name'] = '二等奖';break;
			    		case 4: $ordersLotteryZ[$key]['lottery_status_name'] = '未中';break;
			    		case 5: $ordersLotteryZ[$key]['lottery_status_name'] = $lottery['dostatus']?'一等奖':'待抽奖';break;
			    		case 6: $ordersLotteryZ[$key]['lottery_status_name'] = $lottery['dostatus']?'二等奖':'待抽奖';break;
			    		case 7: $ordersLotteryZ[$key]['lottery_status_name'] = $lottery['dostatus']?'未中':'待抽奖';break;
						default:$ordersLotteryZ[$key]['lottery_status_name'] = '未组团成功';break;
			    	}
					
			    	if($value['mobile']=='虚拟'){
			    		$ordersLotteryZ[$key]['avatar'] = $value['openid'];
						$ordersLotteryZ[$key]['nickname'] =  $value['addname'];
			    	}else{
						$fans = member_get_by_params(" openid = '{$value['openid']}'");
						if (!empty($fans)) {
							$avatar = $fans['avatar'];
							$nickname=$fans['nickname'];
						}
			    		$ordersLotteryZ[$key]['avatar'] = $avatar;
						$ordersLotteryZ[$key]['nickname'] = $nickname;
			    	}
		    	}
	    	}
  	}
  	$num_arr = array();
  	for($i=0;$i<$tuaninfo['lacknum'];$i++){
  		$num_arr[$i] = $i; 
  	}
  	if (empty($order['g_id'])) {
  		echo "<script>alert('组团信息不存在！');location.href='".app_url('home/index')."';</script>";
  		exit;
  	}else{
  		$goods = model_goods::getSingleGoods($order['g_id'], '*');
		$specsData = model_goods::getSingleGoodsOption($order['g_id']); // 规格
		$options = $specsData[2];
		$specs = $specsData[3];
		$params = $goods['params'];
		if($goods['group_level_status']==2){ //阶梯团
			$param_level = unserialize($goods['group_level']);
			for($i=0;$i<count($param_level)-1;$i++){
				for($j=0;$j<count($param_level)-$i-1;$j++){
					if($param_level[$j]['groupnum']<$param_level[$j+1]['groupnum']){
						$temp=$param_level[$j]; 
						$param_level[$j] = $param_level[$j+1];
						$param_level[$j+1]= $temp;
					}
				}
			}
			if($param_level){
				$num= round(((100-count($param_level)*2)/count($param_level)));
			}
			$goods['p'] = $param_level[0]['groupprice'];
		}
		
		if(empty($goods['unit']))$goods['unit'] = '件';
	    $endtime = $tuaninfo['endtime'];
	    $time = time(); /*当前时间*/
	    $lasttime2 = $endtime - $time;//剩余时间（秒数）
	    $lasttime = $goods['endtime'];
  	}
	
	$share_desc_group = !empty($goods['share_desc_group']) ? "【拼团仅剩".$tuaninfo['lacknum']."个名额】".$goods['share_desc_group'] : "【拼团仅剩".$tuaninfo['lacknum']."个名额】".$config['share']['share_desc'];
	$share_title_group = !empty($goods['share_title_group']) ? $goods['share_title_group'] : "我参加了".$goods['gname']."拼团，快来加入吧！";
	$share_image_group = !empty($goods['share_image_group']) ? tomedia($goods['share_image_group']) : $goods['gimg'];
	$config['share']['share_title'] = $share_title_group;
	$config['share']['share_desc'] = $share_desc_group;
	$config['share']['share_url'] = app_url('order/group', array('tuan_id'=>$tuan_id,'group_type'=>'share'));
	$config['share']['share_image'] = $share_image_group;
	$pagetitle = $goods['gname'];
	session_start();
	if($tuaninfo['groupstatus']==3){
		$_SESSION['goodsid'] = $goods['id'];
		$_SESSION['tuan_id'] = $tuan_id;
		$_SESSION['groupnum'] = $tuaninfo['neednum'];
	}
	/*查看更多订单*/
	if($_GPC['op'] == 'showMore'){
		$numbb = $_GPC['numbb'];
		if($_GPC['ajax']){
			if(empty($numbb) || $numbb == 1){
				die(json_encode(array('list'=>$ordersLottery)));
			}else {
				die(json_encode(array('list'=>$ordersLotteryZ)));
			}
		}
		include wl_template('order/lotteryOrderMore');exit;
	}
  	include wl_template('order/group');
}else{
	echo "<script>alert('参数错误');location.href='".app_url('home/index')."';</script>";
}
