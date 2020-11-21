<?php
defined('IN_IA') or exit ('Access Denied');
global $_W, $_GPC;

function GetPositon(){
    $typearr = array(
        "1"=>"首页",
        "2"=>"分类",
        "3"=>"砍价",
        "4"=>"我的",
        "5"=>"预约列表",
        "6"=>"买单",
        "7"=>"卡券",
        "8"=>"分店",
        "9"=>"会员中心",
        "10"=>"充值",
        "11"=>"商家入口",
        "12"=>"分销",
//        "50"=>"详情",
//        "99"=>"其他小程序"
    );
    return $typearr;
}

function GetShowinput(){
    $typearr["js"] = "[50]";
    $typearr["php"] = array(50);
    return $typearr;
}

//前端地址
function all_url($which=0,$id=0){
    $url_list = array(
        "1"=>"ymmf_sun/pages/index/index",//首页
        "2"=>"ymmf_sun/pages/category/category",//分类
        "3"=>"ymmf_sun/pages/bargain/bargain",//砍价
        "4"=>"ymmf_sun/pages/user/user",//我的
        "5"=>"ymmf_sun/pages/index/hairs/hairs",//预约列表
        "6"=>"ymmf_sun/pages/index/pay/pay",//买单
        "7"=>"ymmf_sun/pages/index/card/card",//卡券
        "8"=>"ymmf_sun/pages/index/shop/shop",//分店
        "9"=>"ymmf_sun/pages/user/ucenter/ucenter",//会员中心
        "10"=>"ymmf_sun/pages/user/recharge/recharge",//充值
        "11"=>"ymmf_sun/pages/backstage/backstage",//商家入口
        "12"=>"ymmf_sun/plugin/distribution/fxCenter/fxCenter",//分销

//        "50"=>"",//详情
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
    if($tid==50){//服务
        $sql="select gid,gname from " . tablename("ymktv_sun_goods") ." ".$where." and gname like'%".$name."%' ";
    }
    $list=pdo_fetchall($sql);
    return $list;
}

//门店增加提现金额
function ChangeStoreMoney($order=array(),$type=1){
    global $_W;
    $res_b = pdo_update('ymmf_sun_branch',array('money +='=>$order["money"],'amount +='=>$order["money"]),array('uniacid'=>$_W['uniacid'],'id'=>$order["build_id"]));
    if($res_b){
        if($type==2){
            $meno = "砍价订单-用户确认收货-订单id：".$order["id"].";订单号：".$order["order_num"]."；";
        }elseif($type==3){
            $meno = $order["meno"];
        }else{
            $meno = "预约订单-用户确认收货-订单id：".$order["id"].";订单号：".$order["order_num"]."；";
        }
        //插入商家流水记录
        $branch = pdo_get('ymmf_sun_branch',array('uniacid'=>$_W['uniacid'],'id'=>$order["build_id"]));
        $data = array();
        $data["bid"] = $order["build_id"];
        $data["branchname"] = $branch['name'];
        $data["mcd_type"] = $type;
        $data["mcd_memo"] = $meno;//备注
        $data["addtime"] = time();
        $data["money"] = $order["money"];
        $data["order_id"] = $order["id"];
        $data["uniacid"] = $_W['uniacid'];
        $data["status"] = 1;
        pdo_insert('ymmf_sun_mercapdetails', $data);
    }
}