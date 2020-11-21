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
	$type = $_GPC['type'] ? $_GPC['type'] : 0; //0销售额 1销售量
    if(!empty($_GPC['starts'])){
        $starts= $_GPC['starts'];
        $end =$_GPC['end'];
    }


//	if(!empty($_GPC['datetime'])){
//		$datetime = $_GPC['datetime'];
//	}else{
//		$datetime = array(
//			'start' => "",
//			'end' => "",
//			);
//	}
//	$starts = 0;
//	if(!empty($datetime)){
//		$starts = strtotime($datetime['start']);
//		$end = strtotime($datetime['end']);
//	}
	if($type == 0){
		$where = "allprices";
	}else{
		$where = "allnums";
	}
	if($proType == "yuyue"){
		$where1 = "a.is_more = 1";
	}else{
		$where1 = "a.is_more = 0";
	}
	$pageindex = max(1, intval($_GPC['page']));

    $pagesize = 10;  
    $start = ($pageindex-1) * $pagesize;

	if($proType == "duo"){
		$list = pdo_fetchAll("SELECT id,title FROM ".tablename('sudu8_page_products')." WHERE type = 'showProMore' and uniacid = :uniacid",array(':uniacid'=>$uniacid));

		if($list){
			if($starts > 0){
				$order = pdo_fetchAll("SELECT * FROM ".tablename('sudu8_page_duo_products_order')." WHERE sid = 0 and uniacid = :uniacid and flag in (1,2,4,7,9) and creattime >= :start and creattime <= :now",array(':uniacid'=>$uniacid, ':start'=>strtotime($starts), ':now'=>strtotime($end)));
			}else{
				$order = pdo_fetchAll("SELECT * FROM ".tablename('sudu8_page_duo_products_order')." WHERE sid = 0 and uniacid = :uniacid and flag in (1,2,4,7,9)",array(':uniacid'=>$uniacid));
			}
			foreach ($order as $key => $value) {
				if(!empty($value['jsondata'])){
					$jsondata = unserialize($value['jsondata']);
					foreach($list as $k => $v){
						if(!isset($v['allprices'])){
							$list[$k]['allprices'] = 0;
							$list[$k]['allnums'] = 0;
						}
						if(isset($jsondata[0]['pvid']) && $jsondata[0]['pvid'] == $v['id']){
							$list[$k]['allprices'] = $list[$k]['allprices'] + $jsondata[0]['proinfo']['price'];
							$list[$k]['allnums'] = $list[$k]['allnums'] + $jsondata[0]['num'];
							break;
						}
					}
				}
			}
			if($type == 0){
				$column = array_column($list, 'allprices');
			}else{
				$column = array_column($list, 'allnums');
			}
			array_multisort($column,SORT_DESC,$list);
			$total = count($list);
			$pager = pagination($total, $pageindex, $pagesize);
			$list1 = array();
			$j = 0;
			foreach($list as $kk => $vv){
				if($kk >= $start && $kk < ($start + 10)){
					$list1[$j] = $vv;
					$j++;
				}
			}
			$list = $list1;
		}
	}else if($proType == "yuyue" || $proType == "miaosha"){
		if($starts > 0){
			$list = pdo_fetchAll("SELECT a.title,round(sum(b.true_price),2) as allprices,sum(b.num) as allnums FROM ".tablename('sudu8_page_products')." as a LEFT JOIN ".tablename('sudu8_page_order')." as b on a.id = b.pid WHERE {$where1} and a.type = 'showPro' and a.uniacid = :uniacid and b.flag in (1,2,4,7,9) and creattime >= :start and creattime <= :now group by a.id order by {$where} desc limit ".$start.",".$pagesize,array(':uniacid'=>$uniacid, ':start'=>strtotime($starts), ':now'=>strtotime($end)));
		}else{
			$list = pdo_fetchAll("SELECT a.title,round(sum(b.true_price),2) as allprices,sum(b.num) as allnums FROM ".tablename('sudu8_page_products')." as a LEFT JOIN ".tablename('sudu8_page_order')." as b on a.id = b.pid WHERE {$where1} and a.type = 'showPro' and a.uniacid = :uniacid and b.flag in (1,2,4,7,9) group by a.id order by {$where} desc limit ".$start.",".$pagesize,array(':uniacid'=>$uniacid));
		}
		$total = count($list);
		$pager = pagination($total, $pageindex, $pagesize);
	}
	return include self::template('web/Datashow/ranking');
}