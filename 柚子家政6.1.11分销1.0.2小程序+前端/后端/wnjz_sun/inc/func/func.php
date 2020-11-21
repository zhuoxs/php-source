<?php
defined('IN_IA') or exit ('Access Denied');
global $_W, $_GPC;

function GetPositon(){
    $typearr = array(
        "1"=>"首页",
        "2"=>"文章列表",
        "3"=>"预约服务列表",
        "4"=>"砍价列表",
        "5"=>"我的",
        "6"=>"买单",
        "7"=>"分店",
        "8"=>"联系客服",
        "9"=>"卡券中心",
        "10"=>"关于我们",
        "11"=>"分销中心",
        "12"=>"充值",
//        "50"=>"砍价详情",
//        "51"=>"服务介绍",
//        "52"=>"文章详情",
//        "99"=>"其他小程序"
    );
    return $typearr;
}

function GetShowinput(){
    $typearr["js"] = "[50,51,52]";
    $typearr["php"] = array(50,51,52);
    return $typearr;
}

//前端地址
function all_url($which=0,$id=0){
    $url_list = array(
        "1"=>"wnjz_sun/pages/index/index",//首页 0
        "2"=>"wnjz_sun/pages/index/article/article",//文章列表 1
        "3"=>"wnjz_sun/pages/index/classify/classify",//预约服务列表 2
        "4"=>"wnjz_sun/pages/bargain/bargain",//砍价列表 3
        "5"=>"wnjz_sun/pages/user/user",//我的 4
        "6"=>"wnjz_sun/pages/index/pay/pay",//买单 5
        "7"=>"wnjz_sun/pages/branch/branch",//分店 6
        "8"=>"wnjz_sun/pages/user/dialogue/dialogue",//联系客服 7
        "9"=>"wnjz_sun/pages/index/card/card",//卡券中心 8
        "10"=>"wnjz_sun/pages/index/about/about",//关于我们 9
        "11"=>"wnjz_sun/plugin/distribution/fxCenter/fxCenter",//分销中心 10
        "12"=>"wnjz_sun/pages/user/recharge/recharge",//充值 11
        //详情
//        "50"=>"wnjz_sun/pages/bargain/detail/detail?id=",//砍价详情 12
//        "51"=>"wnjz_sun/pages/index/serdesc/serdesc?id=",//服务介绍 13
//        "52"=>"wnjz_sun/pages/index/hotser/hotser?id=",//文章详情 14
//        "wnjz_sun/pages/branch/shopdet/shopdet?id=",//门店详情 15

//        "wnjz_sun/pages/user/mybill/mybill",//我的账单
//        "wnjz_sun/pages/backstage/set3/set3",//管理订单
//        "wnjz_sun/pages/backstage/index3/index3",//管理首页
//        "wnjz_sun/pages/backstage/index/index",//管理首页
//        "wnjz_sun/pages/backstage/writeoff/writeoff",//订单核销
//        "wnjz_sun/pages/user/orderdet/orderdet",//订单详情
//        "wnjz_sun/pages/index/cforder/cforder",//确认订单
//        "wnjz_sun/pages/index/order/order",//预约下单
//        "wnjz_sun/pages/backstage/index2/index2",//店铺首页
//        "wnjz_sun/pages/user/cards/cards",//我的卡券
//        "wnjz_sun/pages/backstage/current/current",//待服务订单
//        "wnjz_sun/pages/backstage/finish/finish",//已完成订单
//        "wnjz_sun/pages/index/book/book",//预约服务
//        "wnjz_sun/pages/bargain/help/help",//帮砍页面
//        "wnjz_sun/pages/bargain/cforder/cforder",//订单提交
//        "wnjz_sun/pages/user/service/service",//服务订单
//        "wnjz_sun/pages/user/address/address",//地址列表
//        "wnjz_sun/pages/user/bargain/bargain",//砍价记录
//        "wnjz_sun/pages/backstage/backstage",//管理登陆
//        "wnjz_sun/pages/backstage/message/message",//消息
//        "wnjz_sun/pages/backstage/set/set",//管理订单
//        "wnjz_sun/pages/user/bgorder/bgorder",//我的订单
//        "wnjz_sun/pages/index/paysuc/paysuc",//支付成功
//        "wnjz_sun/pages/user/comment/comment",//评价晒单
//        "wnjz_sun/pages/user/editaddr/editaddr",//编辑地址
    );
    $url = $url_list[$which];
    if($id>0){
        $url .= $id;
    }
    return $url;
}

//搜索id
function SearchProductLikename($keyword="",$tid=0){
    global $_W;
    $tid=$tid;
    $name=$keyword;
    $where=" WHERE uniacid=".$_W['uniacid'];
    if($tid==50){//砍价
        $sql="select id,gname from " . tablename("wnjz_sun_new_bargain") ." ".$where." and gname like'%".$name."%' ";
    }elseif($tid==51){//服务
        $sql="select gid,gname from " . tablename("wnjz_sun_goods") ." ".$where." and gname like'%".$name."%' ";
    }elseif($tid==52){//文章
        $sql="select seid as gid,sele_name as gname from " . tablename("wnjz_sun_selected") ." ".$where." and sele_name like'%".$name."%' ";
    }
    $list=pdo_fetchall($sql);
    return $list;
}

//退款公用方法
function wxserverrefund($order,$sys){
    //获取appid和appkey
    $appid=$sys['appid'];
    $wxkey=$sys['wxkey'];
    $mchid=$sys['mchid'];
    $path_cert = IA_ROOT . "/addons/wnjz_sun/cert/".$sys['apiclient_cert'];
    $path_key = IA_ROOT . "/addons/wnjz_sun/cert/".$sys['apiclient_key'];
    $out_trade_no=$order['out_trade_no'];
    $fee = $order['money'] * 100;
    $out_refund_no = $order['out_refund_no']?$order['out_refund_no']:$mchid.rand(100,999).time().rand(1000,9999);
    
	//普通商户退款操作
	include_once IA_ROOT . '/addons/wnjz_sun/cert/WxPay.Api.php';
	$WxPayApi = new WxPayApi();
	$input = new WxPayRefund();
	$input->SetAppid($appid);
	$input->SetMch_id($mchid);
	$input->SetOp_user_id($mchid);
	$input->SetRefund_fee($fee);
	$input->SetTotal_fee($fee);
	$input->SetOut_refund_no($out_refund_no);
	$input->SetOut_trade_no($out_trade_no);
	$result = $WxPayApi->refund($input, 6, $path_cert, $path_key, $wxkey);
    
	return $result;
}