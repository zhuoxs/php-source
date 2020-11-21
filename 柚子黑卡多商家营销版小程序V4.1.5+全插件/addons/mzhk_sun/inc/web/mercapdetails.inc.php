<?php
global $_GPC, $_W;
$GLOBALS['frames'] = $this->getMainMenu();
$uniacid = $_W['uniacid'];

$where=" WHERE uniacid=:uniacid ";
$keyword = $_GPC['keyword'];
if($_GPC['keyword']){
    $op=$_GPC['keyword'];
    $where.=" and bname LIKE  '%$op%'";
}

if(!empty($_GPC['time_start_end'])){
    $time_start_end = $_GPC["time_start_end"];
    if($time_start_end){
        $time_start_end_arr = explode(" - ",$time_start_end);
        if($time_start_end_arr){
            $starttime = strtotime($time_start_end_arr[0]);
            $endtime = strtotime($time_start_end_arr[1]);
            $where.=" and addtime >= {$starttime} and addtime <= {$endtime} ";
        }
    }
}


$type=isset($_GPC['type'])?$_GPC['type']:'all';

if($_GPC["type"]=='s'){
    $status = intval($_GPC['status']);
    if($status!=999){
        $where .= " and mcd_type=:status ";
        $data[':status']=$status;
    }
}else{
    $status = 999;
}

$data[':uniacid']=$_W['uniacid'];

$pageindex = max(1, intval($_GPC['page']));
$pagesize=10;
$sql="select * from " . tablename("mzhk_sun_mercapdetails") ." ".$where." order by id desc ";
$total=pdo_fetchcolumn("select count(*) as wname from " . tablename("mzhk_sun_mercapdetails") . " " .$where." ",$data);

//导出
if($_GPC['op']=='exportorder'){
    $select_sql =$sql." ";
    $orderlist=pdo_fetchall($select_sql,$data);
    $export_title_str = "id,月份,商家名称,类型,金额(元),佣金(元),状态,完成时间,备注信息";
    $export_title = explode(',',$export_title_str);
    $export_list = array(); 
	$widthdraw = array("","订单收入","提现","线下付款","优惠券收入","线下支付-余额支付","商家返利","联盟红包返利");
    $status = array("","成功","不成功");
    $i=1;
    foreach ($orderlist as $k => $v){
        $export_list[$k]["k"] = $v["id"];
        $export_list[$k]["month"] = $v["addtime"]?date("Y/m",$v["addtime"])."\t":" ";
        $export_list[$k]["bname"] = $v["bname"];
		$export_list[$k]["widthdraw"] = $widthdraw[$v["mcd_type"]];
		$export_list[$k]["money"] = $v["money"];
		$export_list[$k]["paycommission"] = $v["paycommission"];
		$export_list[$k]["status"] = $status[$v["status"]];
		$export_list[$k]["addtime"] = $v["addtime"]?date("Y-m-d H:i:s",$v["addtime"])."\t":" ";
		$export_list[$k]["mcd_memo"] = $v["mcd_memo"]."\t";
        $i++;
    } 
    $exporttitle = "商家资金明细";

    exportToExcel($exporttitle.'_'.date("YmdHis").'.csv',$export_title,$export_list);
    exit;
}

$select_sql =$sql." LIMIT " .($pageindex - 1) * $pagesize.",".$pagesize;
$list=pdo_fetchall($select_sql,$data);
$pager = pagination($total, $pageindex, $pagesize);

//提现方式
$widthdraw = array("","订单收入","提现","线下付款","优惠券收入","线下支付-余额支付","商家返利","联盟红包返利");

if($_GPC['op']=='delete'){

    $res=pdo_delete('mzhk_sun_mercapdetails',array('id'=>$_GPC['id'],'uniacid'=>$_W['uniacid']));

    if($res){
        message('删除成功！', $this->createWebUrl('mercapdetails'), 'success');
    }else{
        message('删除失败！','','error');
    }
}
if($_GPC['op']=='paytomch'){
    $id = intval($_GPC['id']);

    $mercapdetails = pdo_get('mzhk_sun_mercapdetails', array('id' => $id,'uniacid' => $uniacid,'status' => 2));
    if($mercapdetails){
        $bid = $mercapdetails["bid"];
        $price = $mercapdetails["money"];
        $mer_id = $mercapdetails["id"];

        //获取商家
        $brand = pdo_get('mzhk_sun_brand',array('uniacid'=>$uniacid,'bid'=>$bid),array("memdiscount","bname","bind_openid"));

        include IA_ROOT . '/addons/mzhk_sun/wxfirmpay.php';
        $appData = pdo_get('mzhk_sun_system', array('uniacid' => $uniacid));
        $mch_appid = $appData['appid'];
        $mchid = $appData['mchid'];
        $key = $appData['wxkey'];
        $openid = $brand["bind_openid"];
        $partner_trade_no = $mchid.time().rand(100000,999999);
        $re_user_name = $brand["bname"];
        $desc = "线下付款-自动打款";
        $offlinefee = 0;
        //计算手续费
        if($appData["offlinefee"]>0){
            $offlinefee = $price*$appData["offlinefee"]/100;
            $amount = sprintf("%.2f", ($price - $offlinefee));
            $amount = $amount*100;
        }else{
            $amount = $price*100;
        }

        $apiclient_cert = IA_ROOT . "/addons/mzhk_sun/cert/".$appData['apiclient_cert'];
        $apiclient_key = IA_ROOT . "/addons/mzhk_sun/cert/".$appData['apiclient_key'];

        $weixinfirmpay = new WeixinfirmPay($mch_appid, $mchid, $key, $openid,$partner_trade_no,$re_user_name,$desc,$amount,$apiclient_cert,$apiclient_key);
        $return = $weixinfirmpay->pay();

        if($return['result_code']=='SUCCESS'){
            //更新商家资金明细
            $data = array();
            $data["status"] = 1;
            $data["mcd_memo"] = "线下付款-直接打款给商家-支付金额:".$price."元,商家实收".($amount/100)."元，收取手续费".$offlinefee."元";//备注
            $res = pdo_update('mzhk_sun_mercapdetails', $data, array('id' => $mer_id));
			/*======分销使用====== */
			include_once IA_ROOT . '/addons/mzhk_sun/inc/func/distribution.php';
			$distribution = new Distribution();
			$distribution->order_id = $mer_id;
			$distribution->ordertype = 10;
			$distribution->settlecommission();
			/*======分销使用======*/
            message('付款成功！','','error');
        }else{
            $data = array();
            $data["status"] = 2;
            $data["mcd_memo"] = "线下付款-直接打款给商家-支付金额:".$price."元,用户付款到平台微信商户号成功，由于绑定微信商户号问题导致无法付款给商家；错误代码".$return['result_code']."-错误信息:".$return['return_msg'].";（".$return['err_code_des']."）";//备注
            pdo_update('mzhk_sun_mercapdetails', $data, array('id' => $mer_id));
            message("失败，错误代码".$return['result_code']."-错误信息:".$return['return_msg'].";（".$return['err_code_des']."）",'','error');
        }
    } else{
        message('付款失败！','','error');
    }
}

include $this->template('web/mercapdetails');