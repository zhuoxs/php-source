<?php
		global $_GPC, $_W;
		$status = 1;
		$rid = $_GPC['rid'];
		$from_user = $_GPC['from_user'];
		$reply = pdo_fetch("SELECT * FROM " . tablename('n1ce_mission_reply') . " WHERE rid = :rid AND uniacid = :uniacid ORDER BY `id` DESC", array(':rid' => $rid, ':uniacid' => $_W['uniacid']));
		if(empty($reply['area'])){
			$status = 1;
		}else{
			$loc="";
			if (!empty($_GPC['latitude']) && !empty($_GPC['longitude'])){
				$loc=$_GPC['latitude'].",".$_GPC['longitude'];
			}else{
				exit(json_encode(array('status' => 1, 'msg' => "获取位置失败,请重试！")));
			}
			$url="http://api.map.baidu.com/geocoder/v2/?ak=QzgbmMn6BtTtW4hwFI5NLYx2&location=".$loc."&output=json";
			$ret=json_decode(file_get_contents($url),true);
			if($reply['xzlx'] == 1){
				$clientcity=$ret['result']['addressComponent']['province'];
			}elseif($reply['xzlx'] == 2){
				$clientcity=$ret['result']['addressComponent']['district'];
			}else{
				$clientcity=$ret['result']['addressComponent']['city'];
			}
			$clientcity = str_replace('市','',$clientcity);
			$clientcity = str_replace('省','',$clientcity);
			if(strpos($reply['area'],$clientcity)===false){	
				$msg = "抱歉,您不符合我们活动地区,只允许".$reply['area']."区域的GPS参与活动,您的GPS所在区域为".$clientcity;
				exit(json_encode(array('status' => 2, 'msg' => $msg)));
			}
		}
		pdo_update('n1ce_mission_member',array('status'=>$status),array('uniacid' => $_W['uniacid'],'rid'=>$rid,'from_user'=>$from_user));
		exit(json_encode(array('status' => 3, 'msg' => "ok")));