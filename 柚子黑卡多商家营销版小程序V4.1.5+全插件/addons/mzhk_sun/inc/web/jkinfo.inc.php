<?php

global $_GPC, $_W;
$GLOBALS['frames'] = $this->getMainMenu();

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
    $sg_data["status"] = 1;
    $sg_data["shiptime"] = time();

    $res=pdo_update('mzhk_sun_cardorder',$sg_data,array('id'=>$id));
    if($res){
        message('发货成功！', $this->createWebUrl('jkinfo'), 'success');
    }else{
        message('发货失败！','','error');
    }
}

$where = " WHERE  o.uniacid=".$_W['uniacid'];
if(!empty($_GPC['keywords'])){
    $keywords=$_GPC['keywords'];
    $where.=" and o.ordernum LIKE  '%$keywords%'";
}
if(!empty($_GPC['telphone'])){
    $telphone=$_GPC['telphone'];
    $where.=" and o.telnumber LIKE '%$telphone%'";
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
    if($statustype==9){
        $where.=" and o.status = 0  ";
    }else{
        $where.=" and o.status = $statustype";
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
$sql = "select o.*,u.name as uname from ".tablename('mzhk_sun_cardorder')." as o left join ".tablename('mzhk_sun_user')." as u on u.openid=o.openid".$where;

//看看是否导出
if($_GPC['op']=='exportorder'){
    $select_sql =$sql." order by o.id asc ";
    $orderlist=pdo_fetchall($select_sql,$data);
    $export_title_str = "id,订单号,地址,电话,名字,金额(元),运费(元),状态,是否退款,配送方式,下单时间,付款时间,发货时间,完成时间,商家名称,商品名称,数量,快递名称,快递单号,备注";
    $export_title = explode(',',$export_title_str);
    $export_list = array(); 
    $status = array("","取消订单","待支付","已支付","已成团","已完成","待收货");
    $refund = array("否","退款申请中","已退款","拒绝退款");
    $i=1;
    foreach ($orderlist as $k => $v){
        $export_list[$k]["k"] = $v["id"];
        $export_list[$k]["ordernum"] = $v["ordernum"]."\t";
        $export_list[$k]["provincename"] = $v["provincename"].$v["cityname"].$v["countyname"].$v["detailinfo"];
        $export_list[$k]["telnumber"] = $v["telnumber"]."\t";
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
    $exporttitle = "集卡订单";

    exportToExcel($exporttitle.'_'.date("YmdHis").'.csv',$export_title,$export_list);
    exit;
}

$select_sql =$sql." order by o.id desc LIMIT " .($pageindex - 1) * $pagesize.",".$pagesize;
$lits=pdo_fetchall($select_sql);
foreach ($lits as $key => $value) {
    if($value["bname"]=='' || $value["bname"]==0){
        $brand = pdo_fetch("select b.bname from ".tablename('mzhk_sun_brand')." as b left join ".tablename('mzhk_sun_goods')." as g on g.bid=b.bid where g.gid=".intval($value["gid"]));
        $lits[$key]["bname"] = $brand["bname"];
    }
}
$total=pdo_fetchcolumn("select count(*) as wname from ".tablename('mzhk_sun_cardorder')." as o left join ".tablename('mzhk_sun_user')." as u on u.openid=o.openid".$where,$data);
$pager = pagination($total, $pageindex, $pagesize);
if($_GPC['op']=='delete'){
    $res=pdo_delete('mzhk_sun_cardorder',array('id'=>$_GPC['id']));
    if($res){
        message('删除成功！', $this->createWebUrl('jkinfo'), 'success');
    }else{
        message('删除失败！','','error');
    }
}
if($_GPC['op']=='change'){
    $id = intval($_GPC['id']);
    $uniacid = $_W['uniacid'];
    $status = intval($_GPC["status"]);
    //获取订单信息
    $order = pdo_get('mzhk_sun_cardorder',array('uniacid'=>$uniacid,'id'=>$id),array("money","bid","gid","ordernum","status","id","gname"));
    if($status==2){
        if($order["status"]==2){
            message('该订单已经是完成状态，不需要在完成订单！','','error');
        }
        $res=pdo_update('mzhk_sun_cardorder',array('status'=>$status,"finishtime"=>time()),array('id'=>$id));
    }else{
        $res=pdo_update('mzhk_sun_cardorder',array('status'=>$status),array('id'=>$id));
    }

    if($res){
        if($status==2){
            
            $bid = intval($order['bid']);
            if($bid==0){
                $goods = pdo_get('mzhk_sun_goods',array('uniacid'=>$uniacid,'gid'=>$order['gid']),array("bid"));
                $bid = intval($goods['bid']);
            }
            //获取商家金额
            $brand = pdo_get('mzhk_sun_brand',array('uniacid'=>$uniacid,'bid'=>$bid),array("totalamount","frozenamount","bname"));

            //更新商家总金额
            $branddata = array();
            $branddata["totalamount"] = $brand["totalamount"]+$order["money"];
            pdo_update('mzhk_sun_brand', $branddata, array('bid' => $bid));
            //更新商家总金额
            $data = array();
            $data["bid"] = $bid;
            $data["bname"] = $brand['bname'];
            $data["mcd_type"] = 1;
            $data["mcd_memo"] = "集卡订单-订单id：".$id.";订单号：".$order["ordernum"]."；";//备注
            $data["addtime"] = time();
            $data["money"] = $order["money"];
            $data["order_id"] = $id;
            $data["uniacid"] = $uniacid;
            $data["status"] = 1;
            pdo_insert('mzhk_sun_mercapdetails', $data);

			//记录核销记录
			$recordsdata = array();
			$recordsdata["uniacid"] = $_W['uniacid'];
			$recordsdata["gid"] = $order["gid"];
			$recordsdata["goodsnum"] = 1;
			$recordsdata["oid"] = $order["id"];
			$recordsdata["addtime"] = time();
			$recordsdata["lid"] = 4;
			$recordsdata["bid"] = $bid;
			$recordsdata["type"] = 0;
			$recordsdata["gname"] = $order["gname"];
			$recordsdata["bname"] = $brand['bname'];
			pdo_insert('mzhk_sun_writewoffrecords', $recordsdata);
        }
        message('成功！', $this->createWebUrl('jkinfo'), 'success');
    }else{
        message('失败！','','error');
    }
}



include $this->template('web/jkinfo');