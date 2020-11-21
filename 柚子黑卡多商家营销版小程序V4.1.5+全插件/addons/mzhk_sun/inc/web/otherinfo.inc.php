<?php

global $_GPC, $_W;
$GLOBALS['frames'] = $this->getMainMenu();

//是否安装红包插件
if(pdo_tableexists("mzhk_sun_redpacket_set")){
	$redpacket = 1;
}

if($_GPC['op']=='sendgoods'){
    $id = intval($_GPC['id']);
    $uniacid = $_W['uniacid'];
    $sincetype = intval($_GPC['sincetype']);
    if($sincetype==3){
        $shipname = $_GPC['shipname'];
        $shipnum = $_GPC['shipnum'];
        if(empty($shipname) || empty($shipnum)){
            message('快递名称或者快递单号不能为空！','','error');
        }
        $sg_data["shipname"] = $shipname;
        $sg_data["shipnum"] = $shipnum;
    }
    $sg_data["status"] = 4;
    $sg_data["shiptime"] = time();

    $res=pdo_update('mzhk_sun_order',$sg_data,array('oid'=>$id));
    if($res){
        message('发货成功！', $this->createWebUrl('otherinfo'), 'success');
    }else{
        message('发货失败！','','error');
    }
}

if($_GPC['op']=='send'){
    $id = intval($_GPC['id']);
    $uniacid = $_W['uniacid'];
    //获取订单信息
    $order = pdo_get('mzhk_sun_order',array('uniacid'=>$uniacid,'oid'=>$id));
    if($order["status"]==5){
        message('该订单已经是完成状态，不需要在完成订单！','','error');
    }
    $res=pdo_update('mzhk_sun_order',array('status'=>5,"finishtime"=>time()),array('oid'=>$id));
    if($res){
        //判断是否有联盟返利
		if($order['fbid']>0 && $order['rmoney']>0 && $order['rid']>0){
			//获取对应红包id
			$umoneytype = pdo_get('mzhk_sun_redpacket_user',array('uniacid'=>$_W['uniacid'],'id'=>$order['rid']),array("umoneytype","unionmoney"));
			//计算联盟返利金额
			//$umoneytype = pdo_get('mzhk_sun_redpacket_goods',array('uniacid'=>$_W['uniacid'],'id'=>$redpacketid['rid']),array("umoneytype","unionmoney"));
			if($umoneytype['umoneytype']==1){//百分比
				//返利金额
				$fmoney = $order['money']*($umoneytype['unionmoney']/100);
				$fmoney = sprintf("%.2f",$fmoney);
			}else{//固定金额
				$fmoney = sprintf("%.2f",$umoneytype['unionmoney']);
			}

			//$order['money'] = $order['money'] - $fmoney;

			/*if($order['money']<0){
				$order['money'] = 0;
			}*/
		}

		//判断分销佣金来源
		if(pdo_tableexists("mzhk_sun_distribution_set")){
			$dset = pdo_get('mzhk_sun_distribution_set',array('uniacid'=>$_W['uniacid']),array("dsource","commission_type"));
			if($dset['dsource']==1 && $dset['commission_type']!=1){//商家出佣金
				$dmoney = pdo_get('mzhk_sun_distribution_order',array('uniacid'=>$_W['uniacid'],'order_id'=>$id,'ordertype'=>1),array("first_price","second_price","third_price"));
				$dmoneys = $dmoney['first_price']+$dmoney['second_price']+$dmoney['third_price'];
				$dmoneys = sprintf("%.2f",$dmoneys);
				$dexplain = "-商家出分销佣金:".$dmoneys."元";
			}else{//平台出佣金
				$dmoneys = 0;
			}
		}

		if($fmoney){
			$money = $order["money"] - $fmoney - $dmoneys;
			if($money<0){
				$money = 0;
			}
			$redexplain = "联盟返利,返利金额:".$fmoney."元,获得返利商家id:".$order['fbid']." ";
		}else{
			$money = $order["money"] - $dmoneys;
			if($money<0){
				$money = 0;
			}
		}

		if($order['fxmoney']>0){
			$fxexplain = "-分销佣金:".$order['fxmoney']."元";
		}
		if($order['csmoney']>0){
			$clexplain = "-云店佣金:".$order['csmoney']."元";
		}


		$bid = intval($order['bid']);
        if($bid==0){
            $goods = pdo_get('mzhk_sun_goods',array('uniacid'=>$uniacid,'gid'=>$order['gid']),array("bid"));
            $bid = intval($goods['bid']);
        }
        //获取商家金额
        $brand = pdo_get('mzhk_sun_brand',array('uniacid'=>$uniacid,'bid'=>$bid),array("totalamount","frozenamount","bname"));
        //p($brand);exit;

        //@20190305 区分默认子商户号和商家子商户号
        $is_store_submac = $order["is_store_submac"];
        $sub_mch_id = $order["sub_mch_id"];
        $mcd_memo_server = '';
        if($is_store_submac==2){
            $mcd_memo_server = "-商家子商户号".$sub_mch_id;
        }else{
            if($is_store_submac==1){
                $mcd_memo_server = "-默认子商户号".$sub_mch_id;
            }
            //更新商家总金额
            $branddata = array();
            $branddata["totalamount"] = $brand["totalamount"]+$money;
            pdo_update('mzhk_sun_brand', $branddata, array('bid' => $bid));
        }

		/*if($fmoney){
			$redexplain = "联盟返利,返利金额:".$fmoney."元,获得返利商家id:".$order['fbid']." ";
		}*/

        //更新商家总金额
        $data = array();
        $data["bid"] = $bid;
        $data["bname"] = $brand['bname'];
        $data["mcd_type"] = 1;
        $data["mcd_memo"] = "普通订单".$mcd_memo_server."-订单id：".$id.";订单号：".$order["orderNum"]."-".$redexplain." ".$dexplain." ".$fxexplain." ".$clexplain." ";//备注
        $data["addtime"] = time();
        $data["money"] = $money;
        $data["order_id"] = $id;
        $data["uniacid"] = $uniacid;
        $data["status"] = 1;
        pdo_insert('mzhk_sun_mercapdetails', $data);

		//记录核销记录
		$goodsnum = intval($order["num"]) - intval($order["haswrittenoffnum"]);
		$recordsdata = array();
		$recordsdata["uniacid"] = $_W['uniacid'];
		$recordsdata["gid"] = $order["gid"];
		$recordsdata["goodsnum"] = $goodsnum;
		$recordsdata["oid"] = $order["oid"];
		$recordsdata["addtime"] = time();
		$recordsdata["lid"] = 1;
		$recordsdata["bid"] = $bid;
		$recordsdata["type"] = 0;
		$recordsdata["gname"] = $order["gname"];
		$recordsdata["bname"] = $brand['bname'];
		pdo_insert('mzhk_sun_writewoffrecords', $recordsdata);

        //更新分销
        /*======分销使用====== */
        include_once IA_ROOT . '/addons/mzhk_sun/inc/func/distribution.php';
        $distribution = new Distribution();
        $distribution->order_id = $id;
        ////1普通，2砍价，3拼团，4抢购，5预约
        $distribution->ordertype = 1;
        $distribution->settlecommission();
        /*======分销使用======*/

		//云店结算
		include_once IA_ROOT . '/addons/mzhk_sun/inc/func/cloudshop.php';
		$cloudshop = new Cloudshop();
		$cloudshop->order_id = $id;
		$cloudshop->ordertype = 1;
		$cloudshop->setcloudcommission();


		//判断是否开启商家返利
		$system = pdo_get('mzhk_sun_system',array('uniacid'=>$_W['uniacid']),array("rebate_open"));
		if($system['rebate_open']==1){

			$ordername = '普通订单';
			$result = pdo_update('mzhk_sun_rebate',array('isdelete'=>1),array('uniacid'=>$_W['uniacid'],'oid'=>$id,'type'=>1));
			
			if($result){
				$rebates = pdo_get('mzhk_sun_rebate',array('uniacid'=>$_W['uniacid'],'oid'=>$id,'type'=>1));
				//修改商家金额
				pdo_update('mzhk_sun_brand', array('totalamount +=' => $rebates['rebatemoney']), array('uniacid'=>$_W['uniacid'],'bid'=>$rebates['bid']));
					
				$brand = pdo_get('mzhk_sun_brand',array('uniacid'=>$_W['uniacid'],'bid'=>$rebates['bid']));

				//更新商家资金明细
				$datas = array();
				$datas["bid"] = $brand['bid'];
				$datas["bname"] = $brand['bname'];
				$datas["mcd_type"] = 6;
				$datas["mcd_memo"] = "商家返利,".$ordername."-订单id:".$id;//备注
				$datas["addtime"] = time();
				$datas["money"] = $rebates['rebatemoney'];
				$datas["uniacid"] = $_W['uniacid'];
				$datas["status"] = 1;
				$mres = pdo_insert('mzhk_sun_mercapdetails', $datas);
			}
		}

		//判断是否有联盟红包
		if($order['fbid']>0 && $order['rmoney']>0){
			$ordername = '联盟红包';
			
			//修改商家金额
			pdo_update('mzhk_sun_brand', array('totalamount +=' => $fmoney), array('uniacid'=>$_W['uniacid'],'bid'=>$order['fbid']));
				
			$brand = pdo_get('mzhk_sun_brand',array('uniacid'=>$_W['uniacid'],'bid'=>$order['fbid']));

			//更新商家资金明细
			$datas = array();
			$datas["bid"] = $brand['bid'];
			$datas["bname"] = $brand['bname'];
			$datas["mcd_type"] = 7;
			$datas["mcd_memo"] = "商家返利,".$ordername."-订单id:".$id."返利商家id:".$bid." ";//备注
			$datas["addtime"] = time();
			$datas["money"] = $fmoney;
			$datas["uniacid"] = $_W['uniacid'];
			$datas["status"] = 1;
			$mres = pdo_insert('mzhk_sun_mercapdetails', $datas);
		}
        
        message('发货成功！', $this->createWebUrl('otherinfo'), 'success');
    }else{
        message('发货失败！','','error');
    }
}

if($_GPC['op']=='refund'){
    $id = intval($_GPC['id']);
    $uniacid = $_W['uniacid'];
    $isrefund = intval($_GPC['isrefund']);
    if($isrefund==3){
        $ress = pdo_update('mzhk_sun_order',array("isrefund ="=>3),array('oid'=>$id,'uniacid'=>$uniacid));
        if($ress){
            message('拒绝成功！', $this->createWebUrl('otherinfo'), 'success');
        }else{
            message('拒绝失败！','','error');
        }
    }
    //获取订单信息
    $order = pdo_get('mzhk_sun_order',array('uniacid'=>$uniacid,'oid'=>$id));
	$order['money'] = $order['money'] + $order['totalcommission'];
    //判断红包金额来源
	if($order['source']==2){//平台出钱
		$order['money']=sprintf("%.2f",($order['money'] - $order['rmoney'] - $order['firstmoney']));
	}
	
	//判断是微信支付还是余额支付
    if($order["paytype"]==2){//余额支付
		$money = $order['money'];
        //更新用户剩余金额
        $res_user = pdo_update('mzhk_sun_user', array('money +=' => $money), array('openid' => $order['openid']));
        if($res_user){
            $memo = "普通订单退款，订单id：".$id;
            //插入记录
            $data = array();
            $data["openid"] = $order['openid'];
            $data["order_id"] = $id;
            $data["money"] = $money;
            $data["addtime"] = time();
            $data["rtype"] = 4;
            $data["memo"] = $memo;
            $data["uniacid"] = $uniacid;
            $res=pdo_insert('mzhk_sun_rechargelogo',$data);
            $result['result_code'] = 'SUCCESS';
        }else{
            $result['result_code'] = 'ERROR';
        }
    }else{
    
        //退款操作
        load()->model('account');
        load()->func('communication');
        $res=pdo_get('mzhk_sun_system',array('uniacid'=>$uniacid));
        $result = wxserverrefund($order,$res);
        
    }
    
    if ($result['result_code'] == 'SUCCESS') {//退款成功
        if($order['spec']>0){
            pdo_update('mzhk_sun_goodsattr_valuedetail',array("num +="=>$order['num']),array('id'=>$order['spec'],'uniacid'=>$uniacid));
            pdo_update('mzhk_sun_goods',array("num +="=>$order['num']),array('gid'=>$order['gid'],'uniacid'=>$uniacid));

        }else{
            pdo_update('mzhk_sun_goods',array("num +="=>$order['num']),array('gid'=>$order['gid'],'uniacid'=>$uniacid));

        }
        pdo_update('mzhk_sun_order',array("isrefund ="=>2,"out_refund_no ="=>$out_refund_no),array('oid'=>$id,'uniacid'=>$uniacid));
        message('退款成功！', $this->createWebUrl('otherinfo'), 'success');
    }else{
        pdo_update('mzhk_sun_order',array("out_refund_no ="=>$out_refund_no),array('oid'=>$id,'uniacid'=>$uniacid));
        if($order["paytype"]==2){//余额支付
            message('退款失败！','error');
        }else{
            message('退款失败！微信'.$result["err_code_des"],'','error');
        }
    }
}

$where = " WHERE  o.uniacid=".$_W['uniacid']." and o.ispackage = 0";
if(!empty($_GPC['keywords'])){
    $keywords=$_GPC['keywords'];
    $where.=" and o.orderNum LIKE  '%$keywords%'";
}
if(!empty($_GPC['telphone'])){
    $telphone=$_GPC['telphone'];
    $where.=" and o.telNumber LIKE '%$telphone%'";
}
if(!empty($_GPC['nametype'])){
    $nametype = $_GPC['nametype'];
    $key_name=$_GPC['key_name'];
    if($nametype=='key_goods'){
        $where.=" and o.gname LIKE '%$key_name%'";
    }elseif($nametype=='key_bname'){
        $where.=" and o.bname LIKE '%$key_name%'";        
    }elseif($nametype=='key_uname'){
        $where.=" and u.name LIKE '%$key_name%'";        
    }
}
if(!empty($_GPC['shiptype'])){
    $shiptype=$_GPC['shiptype'];
    if($shiptype=="到店消费"){
        $where.=" and (o.sincetype LIKE '%$shiptype%' or o.sincetype LIKE '%上门自提%')";
    }else{
        $where.=" and o.sincetype LIKE '%$shiptype%'";
    }
}

if(!empty($_GPC['statustype'])){
    $statustype = intval($_GPC['statustype']);
    if($statustype==91){
        $where.=" and o.isrefund = 1  ";
    }elseif($statustype==92){
        $where.=" and o.isrefund = 2 ";
    }elseif($statustype==93){
        $where.=" and o.isrefund = 3 ";
    }else{
        $where.=" and o.status = $statustype and (o.isrefund=0 or o.isrefund=3)";
    }
}

if(!empty($_GPC['timetype'])){
    $timetype = $_GPC["timetype"];
    $time_start_end = $_GPC["time_start_end"];
    if($time_start_end){
        $time_start_end_arr = explode(" - ",$time_start_end);
        if($time_start_end_arr){
            $starttime = strtotime($time_start_end_arr[0]);
            $endtime = strtotime($time_start_end_arr[1]);
            if($timetype=="key_addtime"){
                $where.=" and o.addtime >= {$starttime} and o.addtime <= {$endtime} ";
            }elseif($timetype=="key_paytime"){
                $where.=" and o.paytime >= {$starttime} and o.paytime <= {$endtime} ";
            }elseif($timetype=="key_finishtime"){
                $where.=" and o.finishtime >= {$starttime} and o.finishtime <= {$endtime} ";
            }
        }
    }
}

$status=$_GPC['status'];
$pageindex = max(1, intval($_GPC['page']));
$pagesize=10;
$type=isset($_GPC['type'])?$_GPC['type']:'all';
// $data[':uniacid']=$_W['uniacid'];
if($type=='all'){
}else{
    $where.= " and o.status =$status";
}
$sql = "select o.*,(select u.name from ".tablename('mzhk_sun_user')." as u where u.openid=o.openid limit 1) as uname from ".tablename('mzhk_sun_order')." as o ".$where;

//看看是否导出
if($_GPC['op']=='exportorder'){
    $select_sql =$sql." order by o.oid asc ";
    $orderlist=pdo_fetchall($select_sql,$data);
    $export_title_str = "id,订单号,地址,电话,名字,金额(元),运费(元),状态,是否退款,配送方式,下单时间,付款时间,发货时间,完成时间,商家名称,商品名称,数量,快递名称,快递单号,备注";
    $export_title = explode(',',$export_title_str);
    $export_list = array(); 
    $status = array("","取消订单","待支付","已支付","已成团","已完成","待收货");
    $refund = array("否","退款申请中","已退款","拒绝退款");
    $i=1;
    foreach ($orderlist as $k => $v){
        $export_list[$k]["k"] = $v["oid"];
        $export_list[$k]["ordernum"] = $v["orderNum"]."\t";
        $export_list[$k]["provincename"] = $v["provinceName"].$v["cityName"].$v["countyName"].$v["detailInfo"];
        $export_list[$k]["telnumber"] = $v["telNumber"]."\t";
        $export_list[$k]["name"] = $v["name"];
        $export_list[$k]["money"] = $v["money"];
        $export_list[$k]["deliveryfee"] = $v["deliveryfee"];
        $export_list[$k]["status"] = $status[$v["status"]];
        $export_list[$k]["isrefund"] = $refund[$v["isrefund"]];
        $export_list[$k]["sincetype"] = $v["sincetype"];
        $export_list[$k]["addtime"] = $v["addtime"]?date("Y-m-d H:i:s",$v["addtime"])."\t":" ";
        $export_list[$k]["paytime"] = $v["paytime"]?date("Y-m-d H:i:s",$v["paytime"])."\t":" ";
        $export_list[$k]["shiptime"] = $v["shiptime"]?date("Y-m-d H:i:s",$v["shiptime"])."\t":" ";
        $export_list[$k]["finishtime"] = $v["finishtime"]?date("Y-m-d H:i:s",$v["finishtime"])."\t":" ";
        $export_list[$k]["bname"] = $v["bname"];
        $export_list[$k]["gname"] = $v["gname"];
        $export_list[$k]["num"] = $v["num"];
        $export_list[$k]["shipname"] = $v["shipname"];
        $export_list[$k]["shipnum"] = $v["shipnum"]."\t";
        $export_list[$k]["uremark"] = " ".$v["uremark"];
        $i++;
    } 
    $exporttitle = "普通订单";

    exportToExcel($exporttitle.'_'.date("YmdHis").'.csv',$export_title,$export_list);
    exit;
}

$total=pdo_fetchcolumn("select count(*) as wname from ".tablename('mzhk_sun_order')." as o ".$where,$data);
$select_sql =$sql." order by o.oid desc LIMIT " .($pageindex - 1) * $pagesize.",".$pagesize;
$lits=pdo_fetchall($select_sql,$data);

foreach ($lits as $key => $value) {
    if($value["bname"]=='' || $value["bname"]==0){
        $brand = pdo_fetch("select b.bname from ".tablename('mzhk_sun_brand')." as b left join ".tablename('mzhk_sun_goods')." as g on g.bid=b.bid where g.gid=".intval($value["gid"]));
        $lits[$key]["bname"] = $brand["bname"];
    }
	$lits[$key]['money'] = floatval($value['money']) + floatval($value['totalcommission']);
}

$pager = pagination($total, $pageindex, $pagesize);
if($_GPC['op']=='delete'){
    $res=pdo_delete('mzhk_sun_order',array('oid'=>$_GPC['id']));
    if($res){
        message('删除成功！', $this->createWebUrl('otherinfo'), 'success');
    }else{
        message('删除失败！','','error');
    }
}



include $this->template('web/otherinfo');