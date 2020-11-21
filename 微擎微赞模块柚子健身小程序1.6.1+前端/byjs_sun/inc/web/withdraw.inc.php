<?php
global $_GPC, $_W;
$GLOBALS['frames'] = $this->getMainMenu();

if($_GPC['op']=='delete'){
    $res=pdo_delete('byjs_sun_userwithdraw',array('id'=>$_GPC['id'],'uniacid'=>$_W['uniacid']));
    if($res){
        message('删除成功！', $this->createWebUrl('withdraw'), 'success');
    }else{
        message('删除失败！','','error');
    }
}elseif($_GPC['op']=='pass'){
    // 通过要判断是否是微信支付
    $id = intval($_GPC['id']);
    $uniacid = $_W['uniacid'];
    $userwithdraw = pdo_get('byjs_sun_userwithdraw',array('uniacid'=>$uniacid,'id'=>$id));
    //获取商家
    // $brand = pdo_get('byjs_sun_brand',array('uniacid'=>$uniacid,'bid'=>$userwithdraw["bid"]),array("commission","totalamount","frozenamount","bname"));
    $user = pdo_get('byjs_sun_user',array('uniacid'=>$uniacid,'openid'=>$userwithdraw["openid"]));
    if($userwithdraw["wd_type"]==1){//微信直接打款
        include IA_ROOT . '/addons/byjs_sun/wxfirmpay.php';
        $appData = pdo_get('byjs_sun_system', array('uniacid' => $uniacid));
        $mch_appid = $appData['appid'];
        $mchid = $appData['mchid'];
        $key = $appData['wxkey'];
        $openid = $userwithdraw["openid"];
        $partner_trade_no = $mchid.time().rand(100000,999999);
        $re_user_name = $userwithdraw["wd_name"];
        $desc = "提现自动打款";
        $amount = $userwithdraw["realmoney"]*100;
        $apiclient_cert = IA_ROOT . "/addons/byjs_sun/cert/".$appData['apiclient_cert'];
        $apiclient_key = IA_ROOT . "/addons/byjs_sun/cert/".$appData['apiclient_key'];
        $weixinfirmpay = new WeixinfirmPay($mch_appid, $mchid, $key, $openid,$partner_trade_no,$re_user_name,$desc,$amount,$apiclient_cert,$apiclient_key);
        $return = $weixinfirmpay->pay();
        if($return['result_code']=='SUCCESS'){
            
            //打款成功直接扣除商家的钱
            // $data_brand_up["money"] = $user["money"] - $userwithdraw["money"];
            // $data_brand_up["frozenamount"] = $brand["frozenamount"] - $userwithdraw["money"];
            // pdo_update('byjs_sun_user', $data_brand_up, array('openid' => $userwithdraw["openid"]));
            //更新提现状态
            pdo_update('byjs_sun_userwithdraw', array("status"=>1), array('id' => $id,'uniacid'=>$_W['uniacid']));
            //插入商家资金明细
            // $data = array();
            // $data["bid"] = $userwithdraw["bid"];
            // $data["bname"] = $brand['bname'];
            // $data["mcd_type"] = 2;
            // $data["mcd_memo"] = "商家提现-提现总金额:".$userwithdraw["money"]."元；支付佣金:".$userwithdraw["paycommission"]."元；支付手续费:".$userwithdraw["ratesmoney"]."元；实际提现金额:".$userwithdraw["realmoney"]."元";//备注
            // $data["addtime"] = time();
            // $data["money"] = $userwithdraw["money"];
            // $data["paycommission"] = $userwithdraw["paycommission"];
            // $data["ratesmoney"] = $userwithdraw["ratesmoney"];
            // $data["wd_id"] = $id;

            // $res1=pdo_insert('byjs_sun_activitydetail',$data);
            // $data["uniacid"] = $uniacid;
            // $res = pdo_insert('byjs_sun_activitydetail', $data);
        }else{
            message('付款失败，平台绑定的微信商户号余额不足！','','error');
        }
    }else{//非微信，更新状态
        //打款成功直接扣除商家的钱
        $data_brand_up["totalamount"] = $brand["totalamount"] - $userwithdraw["money"];
        $data_brand_up["frozenamount"] = $brand["frozenamount"] - $userwithdraw["money"];
        pdo_update('byjs_sun_brand', $data_brand_up, array('bid' => $userwithdraw["bid"]));

        //更新提现状态
        pdo_update('byjs_sun_userwithdraw', array("status"=>1), array('id' => $id,'uniacid'=>$_W['uniacid']));
        //插入商家资金明细
        $data = array();
        $data["bid"] = $userwithdraw["bid"];
        $data["bname"] = $userwithdraw['bname'];
        $data["mcd_type"] = 2;
        $data["mcd_memo"] = "商家提现-提现总金额:".$userwithdraw["money"]."元；支付佣金:".$userwithdraw["paycommission"]."元；支付手续费:".$userwithdraw["ratesmoney"]."元；实际提现金额:".$userwithdraw["realmoney"]."元";//备注
        $data["addtime"] = time();
        $data["money"] = $userwithdraw["money"];
        $data["paycommission"] = $userwithdraw["paycommission"];
        $data["ratesmoney"] = $userwithdraw["ratesmoney"];
        $data["wd_id"] = $id;
        $data["uniacid"] = $uniacid;
        $data["status"] = 1;
        $res = pdo_insert('byjs_sun_mercapdetails', $data);
    }

    if($res){
        message('成功！', $this->createWebUrl('withdraw'), 'success');
    }else{
        message('失败！','','error');
    }
}elseif($_GPC['op']=='nopass'){
    $id = intval($_GPC['id']);
    $uniacid = $_W['uniacid'];
    $userwithdraw = pdo_get('byjs_sun_userwithdraw',array('uniacid'=>$uniacid,'id'=>$id));
    $user = pdo_get('byjs_sun_user',array('uniacid'=>$uniacid,'openid'=>$userwithdraw["openid"]));
    
    //拒绝之后要扣除冻结资金
    $data_brand_up["money"] = $user["money"] + $userwithdraw["money"];
    pdo_update('byjs_sun_user', $data_brand_up, array('openid' => $userwithdraw["openid"],'uniacid'=>$uniacid));

    $data2['uniacid']=$_W['uniacid'];
    $data2['uid']=$user["id"];
    // $data2['uid']=$_GPC['uid'];
    $data2['money']=$userwithdraw["money"];
    $data2['type']=1;//活动
    $data2['status']=4;//提现失败
    $data2['time']=time();
    $res2=pdo_insert('byjs_sun_activitydetail',$data2);

    $res=pdo_update('byjs_sun_userwithdraw',array('status'=>2),array('id'=>$id,'uniacid'=>$uniacid));
    if($res){
        message('拒绝成功！', $this->createWebUrl('withdraw'), 'success');
    }else{
        message('拒绝失败！','','error');
    }
}else{
    $where=" WHERE uniacid=:uniacid ";
    $keyword = $_GPC['keyword'];
    if($_GPC['keyword']){
        $op=$_GPC['keyword'];
        $where.=" and wd_name LIKE '%$op%'";
    }
    $data[':uniacid']=$_W['uniacid'];
    if($_GPC["type"]=='s'){
        $status = intval($_GPC['status']);
        if($status!=999){
            $where .= " and status=:status ";
            $data[':status']=$status;
        }
    }else{
        $status = 999;
    }
    $pageindex = max(1, intval($_GPC['page']));
    $pagesize=10;
    $sql="select * from " . tablename("byjs_sun_userwithdraw") ." ".$where." order by id desc ";
    $total=pdo_fetchcolumn("select count(*) as wname from " . tablename("byjs_sun_userwithdraw") . " " .$where." ",$data);
    $select_sql =$sql." LIMIT " .($pageindex - 1) * $pagesize.",".$pagesize;
    $list=pdo_fetchall($select_sql,$data);
    $pager = pagination($total, $pageindex, $pagesize);

    //提现方式
    $widthdraw = array("","微信","支付宝","银行卡");
}
include $this->template('web/withdraw');