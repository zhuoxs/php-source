<?php
	$ops = array('display');
	$op = in_array($op, $ops) ? $op : 'display';
	if(TG_MERCHANTID)
			$data = Util::getCache('order', 'orderData'.$_SESSION['role_id']);
		else
			$data = Util::getCache('order', 'orderData');
	if($data){
		$seven_orders =  $data[0];
		$obligations =  $data[1];
		$undelivereds =  $data[2];
		$incomes =  $data[3];
		$wek_num = $data[4];/*折线图*/
		$wek_money = $data[5];
		$mon_num = $data[6];/*柱状图*/
		$mon_money = $data[7];
		$all1 = $data[8];/*饼状图*/
		$all2 = $data[9];
		$all3 = $data[10];
		$all4 = $data[11];
		$all5 = $data[12];
		$pv1 = $data[13];/*浏览量*/
		$pv2 = $data[14];
		$pv3 = $data[15];
		$pv4 = $data[16];
		$pu1 = $data[17];
		$pu2 = $data[18];
		$pu3 = $data[19];
		$pu4 = $data[20];
		$address_arr=$data[21];/*地图*/
		$time = $data[22];
	}
	include wl_template('data/home_data');