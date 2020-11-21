<?php
global $_GPC, $_W;
$uniacid = $_W['uniacid'];
$opt = $_GPC['opt'];
$ops = array('display','getdays');
$opt = in_array($opt, $ops) ? $opt : 'display';

$proType = $_GPC['proType'];
$proTypes = array('duo', 'miaosha', 'yuyue');
$proType = in_array($proType, $proTypes) ? $proType : 'duo';

if($opt == "display"){

		$year_now = $_GPC['year_now'] ? $_GPC['year_now'] : date('Y');
		$month = $_GPC['month'] ? $_GPC['month'] : 0;
		$montharr = array(1,2,3,4,5,6,7,8,9,10,11,12);
		$day = $_GPC['day'] ? $_GPC['day'] : 0;

		$type = $_GPC['type'] ? $_GPC['type'] : 0; //0交易额 1交易量
		if($type == 0){ // 交易额
			if($proType == "duo"){
				$where = "round(sum(`price`),2)";
	        }else{
	            $where = "round(sum(`true_price`),2)";
	        }
		}else{//交易量
			$where = "count(*)";
		}
		$max = array();
		$alldata = array();

    
		if($day > 0){
 
			$start = strtotime($year_now."-".$month."-".$day." 0:0:0");
			$end = strtotime($year_now."-".$month."-".$day." 23:59:59");
			if($proType == "duo"){
				$all = pdo_fetchcolumn("SELECT {$where} FROM ".tablename('sudu8_page_duo_products_order')." WHERE sid = 0 and uniacid = :uniacid and flag in (1,2,4,7,9) and creattime >= :start and creattime <= :now",
				array(':uniacid'=>$uniacid, ':start'=>$start, ':now'=>$end));
			}else if($proType == "yuyue"){
				$all = pdo_fetchcolumn("SELECT {$where} FROM ".tablename('sudu8_page_order')." WHERE is_more = 1 and uniacid = :uniacid and flag in (1,2,4,7,9) and creattime >= :start and creattime <= :now",
				array(':uniacid'=>$uniacid, ':start'=>$start, ':now'=>$end));
			}else if($proType == "miaosha"){
				$all = pdo_fetchcolumn("SELECT {$where} FROM ".tablename('sudu8_page_order')." WHERE is_more = 0 and uniacid = :uniacid and flag in (1,2,4,7,9) and creattime >= :start and creattime <= :now",
				array(':uniacid'=>$uniacid, ':start'=>$start, ':now'=>$end));
			}
			$alls = $all?$all:0;
			for($i=1; $i<=24; $i++){
				$first = strtotime($year_now."-".$month."-".$day." ".$i.":0:0");
				$last = strtotime($year_now."-".$month."-".$day." ".$i.":59:59");
				//每日的总销售额
				if($proType == "duo"){
					$all_son = pdo_fetchcolumn("SELECT {$where} FROM ".tablename('sudu8_page_duo_products_order')." WHERE sid = 0 and uniacid = :uniacid and flag in (1,2,4,7,9) and creattime >= :start and creattime <= :now",
					array(':uniacid'=>$uniacid, ':start'=>$first, ':now'=>$last));
				}else if($proType == "yuyue"){
					$all_son = pdo_fetchcolumn("SELECT {$where} FROM ".tablename('sudu8_page_order')." WHERE is_more = 1 and uniacid = :uniacid and flag in (1,2,4,7,9) and creattime >= :start and creattime <= :now",
					array(':uniacid'=>$uniacid, ':start'=>$first, ':now'=>$last));
				}else if($proType == "miaosha"){
					$all_son = pdo_fetchcolumn("SELECT {$where} FROM ".tablename('sudu8_page_order')." WHERE is_more = 0 and uniacid = :uniacid and flag in (1,2,4,7,9) and creattime >= :start and creattime <= :now",
					array(':uniacid'=>$uniacid, ':start'=>$first, ':now'=>$last));
				}
				array_push($max,$all_son);
				$alldata[$i]['all'] = $all_son?$all_son:0;
				$alldata[$i]['per'] = $all_son?round(($all_son / $alls)*100, 2):0;
			}
		}else if($month > 0){
		    $nextMonth = (($month+1)>12) ? 1 : ($month+1);
		    $year_now = ($nextMonth>12) ? ($year_now+1) : $year_now;
		    $days = date('d',mktime(0,0,0,$nextMonth,0,$year_now));
			$start = strtotime($year_now."-".$month."-1 0:0:0");
			$end = strtotime(($year_now)."-".$month."-".$days." 23:59:59");
			

          	if($proType == "duo"){
				$all = pdo_fetchcolumn("SELECT {$where} FROM ".tablename('sudu8_page_duo_products_order')." WHERE sid = 0 and uniacid = :uniacid and flag in (1,2,4,7,9) and creattime >= :start and creattime <= :now",
				array(':uniacid'=>$uniacid, ':start'=>$start, ':now'=>$end));
			}else if($proType == "yuyue"){
				$all = pdo_fetchcolumn("SELECT {$where} FROM ".tablename('sudu8_page_order')." WHERE is_more = 1 and uniacid = :uniacid and flag in (1,2,4,7,9) and creattime >= :start and creattime <= :now",
				array(':uniacid'=>$uniacid, ':start'=>$start, ':now'=>$end));
			}else if($proType == "miaosha"){
				$all = pdo_fetchcolumn("SELECT {$where} FROM ".tablename('sudu8_page_order')." WHERE is_more = 0 and uniacid = :uniacid and flag in (1,2,4,7,9) and creattime >= :start and creattime <= :now",
				array(':uniacid'=>$uniacid, ':start'=>$start, ':now'=>$end));
			}
            
			// $all = pdo_fetchcolumn("SELECT {$where} FROM ".tablename('sudu8_page_duo_products_order')." WHERE sid = 0 and uniacid = :uniacid and flag in (1,2,4,7,9) and creattime >= :start and creattime <= :now",
			// array(':uniacid'=>$uniacid, ':start'=>$start, ':now'=>$end));
          
			$alls = $all?$all:0;
			// $daysarr = array();
			for($i=1; $i<=$days; $i++){
				$first = strtotime($year_now."-".$month."-".$i." 0:0:0");
				$last = strtotime($year_now."-".$month."-".$i." 23:59:59");
				//每日的总销售额
				if($proType == "duo"){
					$all_son = pdo_fetchcolumn("SELECT {$where} FROM ".tablename('sudu8_page_duo_products_order')." WHERE sid = 0 and uniacid = :uniacid and flag in (1,2,4,7,9) and creattime >= :start and creattime <= :now",
					array(':uniacid'=>$uniacid, ':start'=>$first, ':now'=>$last));
				}else if($proType == "yuyue"){
					$all_son = pdo_fetchcolumn("SELECT {$where} FROM ".tablename('sudu8_page_order')." WHERE is_more = 1 and uniacid = :uniacid and flag in (1,2,4,7,9) and creattime >= :start and creattime <= :now",
					array(':uniacid'=>$uniacid, ':start'=>$first, ':now'=>$last));
				}else if($proType == "miaosha"){
					$all_son = pdo_fetchcolumn("SELECT {$where} FROM ".tablename('sudu8_page_order')." WHERE is_more = 0 and uniacid = :uniacid and flag in (1,2,4,7,9) and creattime >= :start and creattime <= :now",
					array(':uniacid'=>$uniacid, ':start'=>$first, ':now'=>$last));
				}
				array_push($max,$all_son);
				$alldata[$i]['all'] = $all_son?$all_son:0;
				$alldata[$i]['per'] = $all_son?round(($all_son / $alls)*100, 2):0;
				// array_push($daysarr,$i);
			}

		}else{//年 
			$start = strtotime($year_now."-1-1 0:0:0");
			$end = strtotime(($year_now)."-12-31 23:59:59");
           
			// $all = pdo_fetchcolumn("SELECT {$where} FROM ".tablename('sudu8_page_duo_products_order')." WHERE sid = 0 and uniacid = :uniacid and flag in (1,2,4,7,9) and creattime >= :start and creattime <= :now",
			// array(':uniacid'=>$uniacid, ':start'=>$start, ':now'=>$end));

			if($proType == "duo"){
				$all = pdo_fetchcolumn("SELECT {$where} FROM ".tablename('sudu8_page_duo_products_order')." WHERE sid = 0 and uniacid = :uniacid and flag in (1,2,4,7,9) and creattime >= :start and creattime <= :now",
				array(':uniacid'=>$uniacid, ':start'=>$start, ':now'=>$end));
			}else if($proType == "yuyue"){
				$all = pdo_fetchcolumn("SELECT {$where} FROM ".tablename('sudu8_page_order')." WHERE is_more = 1 and uniacid = :uniacid and flag in (1,2,4,7,9) and creattime >= :start and creattime <= :now",
				array(':uniacid'=>$uniacid, ':start'=>$start, ':now'=>$end));
			}else if($proType == "miaosha"){
				$all = pdo_fetchcolumn("SELECT {$where} FROM ".tablename('sudu8_page_order')." WHERE is_more = 0 and uniacid = :uniacid and flag in (1,2,4,7,9) and creattime >= :start and creattime <= :now",
				array(':uniacid'=>$uniacid, ':start'=>$start, ':now'=>$end));
			}
			$alls = $all?$all:0;

		
			for($i=1; $i<=12; $i++){
				$first = strtotime($year_now."-".$i."-1");
				if($i<12){
					$j = $i + 1;
					$last = strtotime($year_now."-".$j."-1") - 1;
				}else{
					$last = strtotime($year_now."-12-31 23:59:59");
				}
				//每月的总额
				if($proType == "duo"){
					$all_son = pdo_fetchcolumn("SELECT {$where} FROM ".tablename('sudu8_page_duo_products_order')." WHERE sid = 0 and uniacid = :uniacid and flag in (1,2,4,7,9) and creattime >= :start and creattime <= :now",
					array(':uniacid'=>$uniacid, ':start'=>$first, ':now'=>$last));
				}else if($proType == "yuyue"){
					$all_son = pdo_fetchcolumn("SELECT {$where} FROM ".tablename('sudu8_page_order')." WHERE is_more = 1 and uniacid = :uniacid and flag in (1,2,4,7,9) and creattime >= :start and creattime <= :now",
					array(':uniacid'=>$uniacid, ':start'=>$first, ':now'=>$last));
				}else if($proType == "miaosha"){
                 
					$all_son = pdo_fetchcolumn("SELECT {$where} FROM ".tablename('sudu8_page_order')." WHERE is_more = 0 and uniacid = :uniacid and flag in (1,2,4,7,9) and creattime >= :start and creattime <= :now",
					array(':uniacid'=>$uniacid, ':start'=>$first, ':now'=>$last));
				}
              

                
              
				array_push($max,$all_son);
				$alldata[$i]['all'] = $all_son?$all_son:0;
				$alldata[$i]['per'] = $all_son?round(($all_son / $alls)*100, 2):0;
			}
		}
  
		$maxs = max($max)?max($max):0;
  
		//搜索条件年start
		$years = array();
		$currentYear = date('Y');
		for ($i=0; $i< 10; $i++)
		{
			$years[$i] = $currentYear - $i;
		}
		$years = array_reverse($years);
		$years = array();
		$currentYear = date('Y');
		for ($i=0; $i< 10; $i++)
		{
			$years[$i] = $currentYear - $i;
		}
		$years = array_reverse($years);
		//搜索条件年end
	return include self::template('web/Datashow/statistics');
}else if($opt == 'getdays'){
	$year = $_GPC['year'];
	$month = $_GPC['month'];
    $nextMonth = (($month+1)>12) ? 1 : ($month+1);
    $year = ($nextMonth>12) ? ($year+1) : $year;
    $days = date('d',mktime(0,0,0,$nextMonth,0,$year));
    echo $days;
}