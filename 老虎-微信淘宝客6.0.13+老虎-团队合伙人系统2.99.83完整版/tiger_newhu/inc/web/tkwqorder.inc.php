<?php
        global $_W, $_GPC;
        $op=$_GPC['op'];
        $page=intval($_GPC['page']);
        if(empty($page)){
        	$page=1;
        }        

        
        include IA_ROOT . "/addons/tiger_newhu/inc/sdk/tbk/tb.php"; 
        $ck = pdo_fetch("SELECT * FROM ".tablename('tiger_newhu_ck')." WHERE weid = :weid", array(':weid' => $_W['uniacid']));
        $cookie=$ck['data'];
$sjcstartime=strtotime($_GPC['starttime']);
$startTime=date("Y-m-d",$sjcstartime);//开始时间
$sjcendtime=strtotime($_GPC['endtime']);
$endTime=date("Y-m-d",$sjcendtime);//结束时间

$json=tkwqdd($cookie,$page,$startTime,$endTime);
$arr=@json_decode($json,true);
$good=$arr['data']['pagelist'];

//echo "<pre>";
//print_r($good);
//exit;
if(empty($good)){
	message('暂无维权订单', referer(), 'error');
}
foreach($good as $v){
	$orderid=$v['tbTradeParentId'];
	$ord=pdo_fetch ( 'select orderid from ' . tablename ( $this->modulename . "_tkorder" ) . " where weid='{$_W['uniacid']}' and orderid='{$orderid}'" );
	if(!empty($ord)){
		$b=pdo_update($this->modulename . "_tkorder",array('orderzt'=>'订单失效','wq'=>1), array ('orderid' =>$orderid,'weid'=>$_W['uniacid']));
	}	
}

if (!$good) {
	message('温馨提示：请不要关闭页面，维权订单更新中！第' . $page . '页', $this->createWebUrl('tkwqorder', array('op' => 'wqdd','page' => $page + 1)), 'success');
}else {
    //已结束
    //pdo_update('healer_tplmsg_bulk', array('status' => 2), array('uniacid' => $_W['uniacid'], 'id' => $bulk['id']));
    message('温馨提示：维权订单更新已完成！', $this->createWebUrl('tkorder'), 'success');
}

message('维权订单已修改', referer(), 'success');





//[earningTime] => 2017-12-02 09:26:00
//[tbAuctionTitle] => 秋冬款男士中年男装外套皮夹克皮毛一体加绒加厚爸爸装PU皮衣冬装
//[tbSellerShopTitle] => vgf旗舰店
//[tbTradeParentId] => 92308632265908123
//[tbAuctionNum] => 1
//[tbTradeId] => 92308632265908123
//[refundFee] => 218
//[tkCommissionFee] => 
//[tkSubsidyFee] => 
//[showReturnFee] => 
//[tbTradeFinishPrice] => 218
//[showRefundStatus] => 维权创建
//[showRefundReason] => 买家正常维权退款
//[refundCreateTime] => 2017-12-07 14:34:08
//[refundFinishTime] => 




