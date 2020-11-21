<?php
global $_GPC, $_W;
$uniacid = $_W['uniacid'];
$opt = $_GPC['opt'];
$ops = array('display');
$opt = in_array($opt, $ops) ? $opt : 'display';

if($opt == 'display'){
	$base = pdo_fetch("SELECT * FROM ".tablename('sudu8_page_base') ." WHERE uniacid = :uniacid", array(':uniacid' => $uniacid));
	if(!$base['base_color'] || !$base['base_tcolor'] || !$base['base_color2'] || !$base['homepage'] || !$base['name']){
        $basedata=array('uniacid'=>$uniacid,'base_color' => "#336fe8",'base_tcolor' => "#ffffff",'base_color2' =>"#faae17",'base_color_t' =>"#ffcf3d",'homepage' =>2,'name' =>"小程序名称");
        pdo_insert('sudu8_page_base', $basedata);
    }
    
    if(!$base['tabbar_new'] && !$base['tabbar_bg']){
    	$fooferdata1 = array(
    		"tabbar_bg" => '#ffffff',
    		"color_bar" => '#cccccc',
    		"tabbar_tc" => '#222222',
    		"tabbar_tca" => '#336fe8',
    		"tabnum_new" => '2'
    	);
    	$fooferdata2 = array('tabbar_new'=>'a:2:{i:0;s:185:"a:5:{s:11:"tabbar_name";s:6:"首页";s:10:"tabbar_url";s:23:"/sudu8_page/index/index";s:15:"tabbar_linktype";s:4:"page";s:6:"tabbar";s:1:"2";s:13:"tabimginput_1";s:14:"icon-x-shouye6";}";i:1;s:201:"a:5:{s:11:"tabbar_name";s:12:"个人中心";s:10:"tabbar_url";s:33:"/sudu8_page/usercenter/usercenter";s:15:"tabbar_linktype";s:4:"page";s:6:"tabbar";s:1:"2";s:13:"tabimginput_1";s:13:"icon-x-geren2";}";}');
    	$footercon = array_merge($fooferdata1,$fooferdata2);
    	pdo_update('sudu8_page_base',$footercon,array('uniacid' => $uniacid));
    }

	//总访问量
//	$visitNum = pdo_fetchcolumn("SELECT sum(`visit_pv`) FROM ".tablename("wxapp_general_analysis")." WHERE uniacid = :uniacid",array(":uniacid"=>$uniacid));
//	if(!$visitNum) $visitNum = 0;
    $visitNum=$base['visitnum'];

	//客户数量
	$userNum = pdo_fetchcolumn("SELECT count(*) FROM ".tablename('sudu8_page_user')." WHERE uniacid = :uniacid",array(":uniacid"=>$uniacid));
	//会员数量
	$vipNum = pdo_fetchcolumn("SELECT count(*) FROM ".tablename('sudu8_page_user')." WHERE uniacid = :uniacid and vipid is not null",array(":uniacid"=>$uniacid));

	$firstDay = strtotime(date('Y-m-01 00:00:00', strtotime(date("Y-m-d"))));
	$lastDay = strtotime(date('Y-m-d 23:59:59', strtotime("$firstDay +1 month -1 day")));
	//当月生日人数
	$birthNum = pdo_fetchcolumn("SELECT count(*) FROM ".tablename("sudu8_page_user")." WHERE uniacid = :uniacid and birth is not null and birth >= :firstDay and birth <= :lastDay",
					array(':uniacid'=>$uniacid, ':firstDay'=>$firstDay, ':lastDay'=>$lastDay));
	//充值总额
	$yue = pdo_fetchcolumn("SELECT sum(`money`) FROM ".tablename('sudu8_page_user') . " WHERE uniacid = :uniacid", array(':uniacid'=>$uniacid));
	$yue = sprintf("%.2f", $yue);

	$now = time();
	$tod = date("Y-m-d",time());
	$thirtyDayBefore = strtotime("$tod -30 days");
	
	//多规格-总平台最近30天成交量
	$duo_platform_num = pdo_fetchcolumn("SELECT count(*) FROM ".tablename('sudu8_page_duo_products_order')." WHERE sid = 0 and creattime >= :thirtyDayBefore and creattime <= :now and uniacid = :uniacid and flag in (1,2,4,7,9)", array(':uniacid'=>$uniacid, ':thirtyDayBefore'=>$thirtyDayBefore, ':now'=>$now));
	//多规格-总平台最近30天成交额
	$duo_platform_money = pdo_fetchcolumn("SELECT sum(`price`) FROM ".tablename('sudu8_page_duo_products_order')." WHERE sid = 0 and creattime >= :thirtyDayBefore and creattime <= :now and uniacid = :uniacid and flag in (1,2,4,7,9)", array(":uniacid"=>$uniacid, ':thirtyDayBefore'=>$thirtyDayBefore, ':now'=>$now));
	$duo_platform_money = sprintf("%.2f", $duo_platform_money);

	//折线图多规格-总平台最近1周成交量和成交额
	for($i = 6; $i >= 0; $i--){
		$stt = "$tod -".$i." days";
		$btime = strtotime(date("Y-m-d 00:00:00", strtotime($stt)));
		$etime = strtotime(date("Y-m-d 23:59:59", strtotime($stt)));
		$duo_chart_num[6-$i] = pdo_fetchcolumn("SELECT count(*) FROM ".tablename('sudu8_page_duo_products_order')." WHERE sid = 0 and creattime >= :btime and creattime <= :etime and uniacid = :uniacid and flag in (1,2,4,7,9)", array(':uniacid'=>$uniacid, ':btime'=>$btime, ':etime'=>$etime));
		$duo_chart_num[6-$i] = $duo_chart_num[6-$i]?$duo_chart_num[6-$i]:0;
		$duo_chart_money[6-$i] = pdo_fetchcolumn("SELECT sum(`price`) FROM ".tablename('sudu8_page_duo_products_order')." WHERE sid = 0 and creattime >= :btime and creattime <= :etime and uniacid = :uniacid and flag in (1,2,4,7,9)", array(":uniacid"=>$uniacid, ':btime'=>$btime, ':etime'=>$etime));
		$duo_chart_money[6-$i] = sprintf("%.2f", $duo_chart_money[6-$i]);
		$last_week_date[6-$i] = date("Ymd",$btime);
	}
	$duo_chart_num_max = max($duo_chart_num)?max($duo_chart_num)+intval(max($duo_chart_num)/3):50;
	$duo_chart_money_max = max($duo_chart_money) != 0.00?max($duo_chart_money)+intval(max($duo_chart_money)/10):500;
	$duo_chart_num_interval = $duo_chart_num_max/5;
	$duo_chart_money_interval = $duo_chart_money_max/5;
	$duo_chart_num = '[' .implode(',', $duo_chart_num). ']';
	$duo_chart_money = '[' . implode(',', $duo_chart_money) . ']';
	$last_week_date = '[' . implode(',', $last_week_date) . ']';


	//今天的成交量、成交额、订单平均消费、待发货订单数量、待核销订单数量、维权订单数量
	$today = strtotime(date("Y-m-d 00:00:00", time()));
	$today_num = pdo_fetchcolumn("SELECT count(*) FROM ".tablename('sudu8_page_duo_products_order')." WHERE sid = 0 and uniacid = :uniacid and flag in (1,2,4,7,9) and creattime >= :start and creattime <= :now",
		array(':uniacid'=>$uniacid, ':start'=>$today, ':now'=>$now));
	$today_num=$today_num?$today_num:0;
	$today_money = pdo_fetchcolumn("SELECT sum(`price`) FROM ".tablename('sudu8_page_duo_products_order')." WHERE sid = 0 and uniacid = :uniacid and flag in (1,2,4,7,9) and creattime >= :start and creattime <= :now",
		array(':uniacid'=>$uniacid, ':start'=>$today, ':now'=>$now));
	$today_money = sprintf("%.2f", $today_money);
	if(empty($today_money) || $today_money == '0.00') $today_money = 0;
	$today_avg = pdo_fetchcolumn("SELECT avg(`price`) FROM ".tablename('sudu8_page_duo_products_order')." WHERE sid = 0 and uniacid = :uniacid and flag in (1,2,4,7,9) and creattime >= :start and creattime <= :now",
		array(':uniacid'=>$uniacid, ':start'=>$today, ':now'=>$now));
	$today_avg = sprintf("%.2f", $today_avg);
	if(empty($today_avg) || $today_avg == '0.00') $today_avg = 0;
	$today_flag0 = pdo_fetchcolumn("SELECT count(*) FROM ".tablename('sudu8_page_duo_products_order')." WHERE sid = 0 and uniacid = :uniacid and flag = 0 and creattime >= :start and creattime <= :now",
		array(':uniacid'=>$uniacid, ':start'=>$today, ':now'=>$now));
	$today_flag0=$today_flag0?$today_flag0:0;
	$today_flag1 = pdo_fetchcolumn("SELECT count(*) FROM ".tablename('sudu8_page_duo_products_order')." WHERE sid = 0 and uniacid = :uniacid and flag = 1 and creattime >= :start and creattime <= :now",
		array(':uniacid'=>$uniacid, ':start'=>$today, ':now'=>$now));
	$today_flag1=$today_flag1?$today_flag1:0;
	$today_flag4 = pdo_fetchcolumn("SELECT count(*) FROM ".tablename('sudu8_page_duo_products_order')." WHERE sid = 0 and uniacid = :uniacid and flag in (5,6,7,8,9) and creattime >= :start and creattime <= :now",
		array(':uniacid'=>$uniacid, ':start'=>$today, ':now'=>$now));
	$today_flag4=$today_flag4?$today_flag4:0;

	//昨天的成交量、成交额、订单平均消费、待发货订单数量、待核销订单数量、维权订单数量
	$yes = strtotime(date("Y-m-d 00:00:00", strtotime("$tod -1 day")));
	$yes_end = strtotime(date("Y-m-d 23:59:59", strtotime("$tod -1 day")));
	$yes_num = pdo_fetchcolumn("SELECT count(*) FROM ".tablename('sudu8_page_duo_products_order')." WHERE sid = 0 and uniacid = :uniacid and flag in (1,2,4,7,9) and creattime >= :start and creattime <= :now",
		array(':uniacid'=>$uniacid, ':start'=>$yes, ':now'=>$yes_end));
	$yes_num=$yes_num?$yes_num:0;
	$yes_money = pdo_fetchcolumn("SELECT sum(`price`) FROM ".tablename('sudu8_page_duo_products_order')." WHERE sid = 0 and uniacid = :uniacid and flag in (1,2,4,7,9) and creattime >= :start and creattime <= :now",
		array(':uniacid'=>$uniacid, ':start'=>$yes, ':now'=>$yes_end));
	$yes_money = sprintf("%.2f", $yes_money);
	if(empty($yes_money) || $yes_money == '0.00') $yes_money = 0;
	$yes_avg = pdo_fetchcolumn("SELECT avg(`price`) FROM ".tablename('sudu8_page_duo_products_order')." WHERE sid = 0 and uniacid = :uniacid and flag in (1,2,4,7,9) and creattime >= :start and creattime <= :now",
		array(':uniacid'=>$uniacid, ':start'=>$yes, ':now'=>$yes_end));
	$yes_avg = sprintf("%.2f", $yes_avg);
	if(empty($yes_avg) || $yes_avg == '0.00') $yes_avg = 0;
	$yes_flag0 = pdo_fetchcolumn("SELECT count(*) FROM ".tablename('sudu8_page_duo_products_order')." WHERE sid = 0 and uniacid = :uniacid and flag = 0 and creattime >= :start and creattime <= :now",
		array(':uniacid'=>$uniacid, ':start'=>$yes, ':now'=>$yes_end));
	$yes_flag0=$yes_flag0?$yes_flag0:0;
	$yes_flag1 = pdo_fetchcolumn("SELECT count(*) FROM ".tablename('sudu8_page_duo_products_order')." WHERE sid = 0 and uniacid = :uniacid and flag = 1 and creattime >= :start and creattime <= :now",
		array(':uniacid'=>$uniacid, ':start'=>$yes, ':now'=>$yes_end));
	$yes_flag1=$yes_flag1?$yes_flag1:0;
	$yes_flag4 = pdo_fetchcolumn("SELECT count(*) FROM ".tablename('sudu8_page_duo_products_order')." WHERE sid = 0 and uniacid = :uniacid and flag = 5 and creattime >= :start and creattime <= :now",
		array(':uniacid'=>$uniacid, ':start'=>$yes, ':now'=>$yes_end));
	$yes_flag4=$yes_flag4?$yes_flag4:0;

	//近7天的成交量、成交额、订单平均消费、待发货订单数量、待核销订单数量、维权订单数量
	$week = strtotime(date("Y-m-d 00:00:00", strtotime("$tod -7 days")));
	$week_num = pdo_fetchcolumn("SELECT count(*) FROM ".tablename('sudu8_page_duo_products_order')." WHERE sid = 0 and uniacid = :uniacid and flag in (1,2,4,7,9) and creattime >= :start and creattime <= :now",
		array(':uniacid'=>$uniacid, ':start'=>$week, ':now'=>$now));
	$week_num=$week_num?$week_num:0;
	$week_money = pdo_fetchcolumn("SELECT sum(`price`) FROM ".tablename('sudu8_page_duo_products_order')." WHERE sid = 0 and uniacid = :uniacid and flag in (1,2,4,7,9) and creattime >= :start and creattime <= :now",
		array(':uniacid'=>$uniacid, ':start'=>$week, ':now'=>$now));
	$week_money = sprintf("%.2f", $week_money);
	if(empty($week_money) || $week_money == '0.00') $week_money = 0;
	$week_avg = pdo_fetchcolumn("SELECT avg(`price`) FROM ".tablename('sudu8_page_duo_products_order')." WHERE sid = 0 and uniacid = :uniacid and flag in (1,2,4,7,9) and creattime >= :start and creattime <= :now",
		array(':uniacid'=>$uniacid, ':start'=>$week, ':now'=>$now));
	$week_avg = sprintf("%.2f", $week_avg);
	if(empty($week_avg) || $week_avg == '0.00') $week_avg = 0;
	$week_flag0 = pdo_fetchcolumn("SELECT count(*) FROM ".tablename('sudu8_page_duo_products_order')." WHERE sid = 0 and uniacid = :uniacid and flag = 0 and creattime >= :start and creattime <= :now",
		array(':uniacid'=>$uniacid, ':start'=>$week, ':now'=>$now));
	$week_flag0=$week_flag0?$week_flag0:0;
	$week_flag1 = pdo_fetchcolumn("SELECT count(*) FROM ".tablename('sudu8_page_duo_products_order')." WHERE sid = 0 and uniacid = :uniacid and flag = 1 and creattime >= :start and creattime <= :now",
		array(':uniacid'=>$uniacid, ':start'=>$week, ':now'=>$now));
	$week_flag1=$week_flag1?$week_flag1:0;
	$week_flag4 = pdo_fetchcolumn("SELECT count(*) FROM ".tablename('sudu8_page_duo_products_order')." WHERE sid = 0 and uniacid = :uniacid and flag = 5 and creattime >= :start and creattime <= :now",
		array(':uniacid'=>$uniacid, ':start'=>$week, ':now'=>$now));
	$week_flag4=$week_flag4?$week_flag4:0;

	//近30天的成交量、成交额、订单平均消费、待发货订单数量、待核销订单数量、维权订单数量
	$month = strtotime(date("Y-m-d 00:00:00", strtotime("$tod -30 days")));
	$month_num = pdo_fetchcolumn("SELECT count(*) FROM ".tablename('sudu8_page_duo_products_order')." WHERE sid = 0 and uniacid = :uniacid and flag in (1,2,4,7,9) and creattime >= :start and creattime <= :now",
		array(':uniacid'=>$uniacid, ':start'=>$month, ':now'=>$now));
	$month_num=$month_num?$month_num:0;
	$month_money = pdo_fetchcolumn("SELECT sum(`price`) FROM ".tablename('sudu8_page_duo_products_order')." WHERE sid = 0 and uniacid = :uniacid and flag in (1,2,4,7,9) and creattime >= :start and creattime <= :now",
		array(':uniacid'=>$uniacid, ':start'=>$month, ':now'=>$now));
	$month_money = sprintf("%.2f", $month_money);
	if(empty($month_money) || $month_money == '0.00') $month_money = 0;
	$month_avg = pdo_fetchcolumn("SELECT avg(`price`) FROM ".tablename('sudu8_page_duo_products_order')." WHERE sid = 0 and uniacid = :uniacid and flag in (1,2,4,7,9) and creattime >= :start and creattime <= :now",
		array(':uniacid'=>$uniacid, ':start'=>$month, ':now'=>$now));
	$month_avg = sprintf("%.2f", $month_avg);
	if(empty($month_avg) || $month_avg == '0.00') $month_avg = 0;
	$month_flag0 = pdo_fetchcolumn("SELECT count(*) FROM ".tablename('sudu8_page_duo_products_order')." WHERE sid = 0 and uniacid = :uniacid and flag = 0 and creattime >= :start and creattime <= :now",
		array(':uniacid'=>$uniacid, ':start'=>$month, ':now'=>$now));
	$month_flag0=$month_flag0?$month_flag0:0;
	$month_flag1 = pdo_fetchcolumn("SELECT count(*) FROM ".tablename('sudu8_page_duo_products_order')." WHERE sid = 0 and uniacid = :uniacid and flag = 1 and creattime >= :start and creattime <= :now",
		array(':uniacid'=>$uniacid, ':start'=>$month, ':now'=>$now));
	$month_flag1=$month_flag1?$month_flag1:0;
	$month_flag4 = pdo_fetchcolumn("SELECT count(*) FROM ".tablename('sudu8_page_duo_products_order')." WHERE sid = 0 and uniacid = :uniacid and flag = 5 and creattime >= :start and creattime <= :now",
		array(':uniacid'=>$uniacid, ':start'=>$month, ':now'=>$now));
	$month_flag4=$month_flag4?$month_flag4:0;


	//多规格-总平台最新订单
	$duo_platform_orders = pdo_fetchall("SELECT id,creattime,order_id,jsondata,uid,flag,nav FROM ".tablename('sudu8_page_duo_products_order')." WHERE sid = 0 and uniacid = :uniacid order by creattime desc LIMIT 5",array(":uniacid"=>$uniacid));
	foreach ($duo_platform_orders as $key => &$value) {
		$value['creattime'] = date('Y-m-d H:i:s', $value['creattime']);
		$jsondata = unserialize($value['jsondata']);
		unset($value['jsondata']);
		//多商户订单，与其他订单商品表不一样
		$pname = '';
		if($jsondata[0]['is_from_shops'] == 1 && pdo_tableexists('sudu8_page_shops_goods')){
			foreach ($jsondata as $k => $v) {
				$pname .= pdo_fetchcolumn("SELECT title FROM ".tablename('sudu8_page_shops_goods')." WHERE uniacid = :uniacid and id = :id", array(':uniacid'=>$uniacid, ':id'=>$v['pid'])) . ';'; 
			}
		}else{
			foreach ($jsondata as $k => $v) {
				$pname .= $v['proinfo']['title'] . '：' . chop($v['proinfo']['ggz'],',') . '×' . $v['num'] . ';';
			}
		}
		$pname = chop($pname, ';');
		
		$value['pname'] = $pname;
		$value['nickname'] = pdo_fetchcolumn("SELECT nickname FROM ".tablename('sudu8_page_user')." WHERE uniacid = :uniacid and id = :id", array(':uniacid'=>$uniacid, ':id'=>$value['uid']));
		unset($value['uid']);
	}

	//多规格-商户最新订单
	if(pdo_tableexists('sudu8_page_shops_goods')){
		$duo_shop_orders = pdo_fetchall("SELECT id,creattime,order_id,jsondata,uid,flag,nav FROM ".tablename('sudu8_page_duo_products_order')." WHERE sid != 0 and uniacid = :uniacid order by creattime desc LIMIT 5",array(":uniacid"=>$uniacid));
		// var_dump($duo_shop_orders);exit;
		foreach ($duo_shop_orders as $key => &$value) {
			$value['creattime'] = date('Y-m-d H:i:s', $value['creattime']);
			$jsondata = unserialize($value['jsondata']);
			unset($value['jsondata']);
			//多商户订单，与其他订单商品表不一样
			$pname = '';
			if($jsondata[0]['is_from_shops'] == 1){
				foreach ($jsondata as $k => $v) {
					$pname .= pdo_fetchcolumn("SELECT title FROM ".tablename('sudu8_page_shops_goods')." WHERE uniacid = :uniacid and id = :id", array(':uniacid'=>$uniacid, ':id'=>$v['pid'])) . ';'; 
				}
			}else{
				foreach ($jsondata as $k => $v) {
					$pname .= pdo_fetchcolumn("SELECT title FROM ".tablename('sudu8_page_products')." WHERE uniacid = :uniacid and id = :id", array(':uniacid'=>$uniacid, ':id'=>$v['proinfo']['id'])) . ';';
				}
			}
			$pname = chop($pname, ';');
			
			$value['pname'] = $pname;
			$value['nickname'] = pdo_fetchcolumn("SELECT nickname FROM ".tablename('sudu8_page_user')." WHERE uniacid = :uniacid and id = :id", array(':uniacid'=>$uniacid, ':id'=>$value['uid']));
			unset($value['uid']);
		}
	}

	$yuyue_orders = pdo_fetchall("SELECT id,creattime,order_id,pid,uid,flag FROM ".tablename('sudu8_page_order')." WHERE is_more = 1 and uniacid = :uniacid order by creattime desc LIMIT 5",array(":uniacid"=>$uniacid));
	foreach ($yuyue_orders as $key => &$value) {
		$value['creattime'] = date('Y-m-d H:i:s', $value['creattime']);	
		$value['pname'] = pdo_fetchcolumn("SELECT title FROM ".tablename('sudu8_page_products')." WHERE uniacid = :uniacid and id = :id",array(":uniacid"=>$uniacid, ":id"=>$value['pid']));
		unset($value['pid']);
		$value['nickname'] = pdo_fetchcolumn("SELECT nickname FROM ".tablename('sudu8_page_user')." WHERE uniacid = :uniacid and id = :id", array(':uniacid'=>$uniacid, ':id'=>$value['uid']));
		unset($value['uid']);
	}

	$miaosha_orders = pdo_fetchall("SELECT id,creattime,order_id,pid,uid,flag,nav FROM ".tablename('sudu8_page_order')." WHERE is_more = 0 and uniacid = :uniacid order by creattime desc LIMIT 5",array(":uniacid"=>$uniacid));
	foreach ($miaosha_orders as $key => &$value) {
		$value['creattime'] = date('Y-m-d H:i:s', $value['creattime']);	
		$value['pname'] = pdo_fetchcolumn("SELECT title FROM ".tablename('sudu8_page_products')." WHERE uniacid = :uniacid and id = :id",array(":uniacid"=>$uniacid, ":id"=>$value['pid']));
		unset($value['pid']);
		$value['nickname'] = pdo_fetchcolumn("SELECT nickname FROM ".tablename('sudu8_page_user')." WHERE uniacid = :uniacid and id = :id", array(':uniacid'=>$uniacid, ':id'=>$value['uid']));
		unset($value['uid']);
	}
	if(pdo_tableexists('sudu8_page_pt_order')){
		$pintuan_orders = pdo_fetchall("SELECT id,creattime,order_id,jsondata,uid,flag FROM ".tablename('sudu8_page_pt_order')." WHERE uniacid=:uniacid order by creattime desc LIMIT 5",array(":uniacid"=>$uniacid));
		foreach ($pintuan_orders as $key => &$value) {
			$value['creattime'] = date('Y-m-d H:i:s', $value['creattime']);
			$jsondata = unserialize($value['jsondata']);
			unset($value['jsondata']);
			//多商户订单，与其他订单商品表不一样
			$pname = '';
			
			foreach ($jsondata as $k => $v) {
				$pname .= pdo_fetchcolumn("SELECT title FROM ".tablename('sudu8_page_pt_pro')." WHERE uniacid = :uniacid and id = :id", array(':uniacid'=>$uniacid, ':id'=>$v['baseinfo'])) . ';';
			}
			
			$pname = chop($pname, ';');
			
			$value['pname'] = $pname;
			$value['nickname'] = pdo_fetchcolumn("SELECT nickname FROM ".tablename('sudu8_page_user')." WHERE uniacid = :uniacid and id = :id", array(':uniacid'=>$uniacid, ':id'=>$value['uid']));
			unset($value['uid']);
		}
	}
	$video_orders = pdo_fetchall("SELECT * FROM ".tablename('sudu8_page_video_pay')." WHERE uniacid = :uniacid order by creattime desc LIMIT 5",array(':uniacid'=>$uniacid));
	foreach ($video_orders as $key => &$value) {
		$value['creattime'] = date('Y-m-d H:i:s', $value['creattime']);	
		$value['pname'] = pdo_fetchcolumn("SELECT title FROM ".tablename('sudu8_page_products')." WHERE uniacid = :uniacid and id = :id",array(":uniacid"=>$uniacid, ":id"=>$value['pid']));
		unset($value['pid']);
		$value['nickname'] = pdo_fetchcolumn("SELECT nickname FROM ".tablename('sudu8_page_user')." WHERE uniacid = :uniacid and openid = :openid", array(':uniacid'=>$uniacid, ':openid'=>$value['openid']));
		unset($value['openid']);
	}


	//最新文章评论
	$acticle_comments = pdo_fetchall("SELECT id,openid,text,createtime FROM ".tablename('sudu8_page_comment')." WHERE uniacid = :uniacid and types = 0 order by createtime desc LIMIT 5",array(':uniacid'=>$uniacid));
	foreach ($acticle_comments as $key => &$value) {
		$value['createtime'] = date('Y-m-d H:i:s', $value['createtime']);		
		$value['nickname'] = pdo_fetchcolumn("SELECT nickname FROM ".tablename('sudu8_page_user')." WHERE uniacid = :uniacid and openid = :openid", array(':uniacid'=>$uniacid, ':openid'=>$value['openid']));
		unset($value['openid']);
	}


	//收藏榜
	//SELECT type,cid,COUNT(*) as num FROM `ims_sudu8_page_collect` GROUP BY cid,type ORDER BY num desc;
	$collect_max = pdo_fetchcolumn("SELECT count(*) as num FROM ".tablename('sudu8_page_collect')." WHERE uniacid = :uniacid group by cid,type order by num desc LIMIT 1", array(':uniacid'=>$uniacid));
	if(!$collect_max)  $collect_max = 0;
	$collects = pdo_fetchall("SELECT id,type,cid,count(*) as num FROM".tablename('sudu8_page_collect')." WHERE uniacid = :uniacid and type in ('showPro','showProMore','showPro_lv','shopsPro') group by cid,type order by num desc LIMIT 5", array(':uniacid'=>$uniacid));
	foreach ($collects as $key => &$value) {
		if($value['type'] == 'shopsPro'){
			if(pdo_tableexists('sudu8_page_shops_goods')){
				$value['title'] = pdo_fetchcolumn("SELECT title FROM ".tablename('sudu8_page_shops_goods')." WHERE uniacid = :uniacid and id = :id",array(':uniacid'=>$uniacid, ':id'=>$value['cid']));
			}
		}else{
			$value['title'] = pdo_fetchcolumn("SELECT title FROM ".tablename('sudu8_page_products')." WHERE uniacid = :uniacid and id = :id",array(':uniacid'=>$uniacid, ':id'=>$value['cid']));
		}
		unset($value['cid']);
		unset($value['type']);
	}

	//销售榜
	$sale_max_1 = pdo_fetchcolumn("SELECT max(`sale_tnum`) FROM ".tablename('sudu8_page_products')." WHERE uniacid = :uniacid and type in ('showPro','showProMore','showPro_lv')", array(":uniacid"=>$uniacid));
	if(pdo_tableexists('sudu8_page_shops_goods')){
		$sale_max_2 = pdo_fetchcolumn("SELECT max(`rsales`) FROM ".tablename('sudu8_page_shops_goods')." WHERE uniacid = :uniacid", array(":uniacid"=>$uniacid));
	}
	$sale_max = max($sale_max_1, $sale_max_2);
	if(!$sale_max) $sale_max = 0;
	$sales_1 = pdo_fetchall("SELECT id,title,sale_tnum as rsales FROM ".tablename('sudu8_page_products')." WHERE uniacid = :uniacid and type in ('showPro','showProMore','showPro_lv') order by sale_tnum desc LIMIT 5",array(":uniacid"=>$uniacid));
	if(pdo_tableexists('sudu8_page_shops_goods')){
		$sales_2 = pdo_fetchall("SELECT id,title,rsales FROM ".tablename('sudu8_page_shops_goods')." WHERE uniacid = :uniacid order by rsales desc LIMIT 5",array(":uniacid"=>$uniacid));
	}else{
		$sales_2 = array();
	}
	$sales = array_merge($sales_1, $sales_2);

	$key_value = $new_array = array();
	foreach($sales as $k => $v){
		$key_value[$k] = $v['rsales'];
	}
	arsort($key_value);
	// reset($key_value);
	foreach ($key_value as $k => $v) {
		$new_array[] = $sales[$k];
	}
	$sales = $new_array;
	for($i = 5; $i < 10; $i++){
		unset($sales[$i]);
	}

	//积分榜
	$credit_max = pdo_fetchcolumn("SELECT max(`score`) FROM ".tablename('sudu8_page_user')." WHERE uniacid = :uniacid",array(":uniacid" => $uniacid));
	if(!$credit_max) $credit_max = 0;
	$credits = pdo_fetchall("SELECT id,nickname,score FROM".tablename('sudu8_page_user')." WHERE uniacid = :uniacid order by score desc LIMIT 5",array(":uniacid"=>$uniacid));
}
return include self::template('web/Datashow/display');