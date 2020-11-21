<?php
global $_GPC, $_W;
$GLOBALS['frames'] = $this->getMainMenu();
 function tixian($withdraw){
    global $_W;
    if($withdraw['is_state']!=1||$withdraw['state']!=1||$withdraw['status']!=0){
        return false;
        exit;
    }
    $url='https://api.mch.weixin.qq.com/mmpaymkttransfers/promotion/transfers';
    $system = pdo_get('yzcyk_sun_system', array('uniacid' => $_W['uniacid']));
    $data['mch_appid']=$system['appid'];
    $data['mchid'] =$system['mchid'];
    $data['nonce_str']=createNoncestr();
    $data['partner_trade_no']=date("YmdHis") .rand(11111, 99999);
    $data['openid']=$withdraw['openid'];
    $data['check_name']='NO_CHECK';
    $data['amount']=$withdraw['realmoney']*100;
    $data['desc']='提现';
    $data['spbill_create_ip']=$_SERVER['REMOTE_ADDR'];
    $data['sign']=getSign($data,$system['wxkey']);
    $xml=postXmlCurl($data,$url);
    //保存报文信息
    pdo_update('yzcyk_sun_withdraw',array('baowen'=>$xml),array('uniacid'=>$_W['uniacid'],'id'=>$withdraw['id']));
    //添加报文记录
    $baowen=array(
        'uniacid'=>$_W['uniacid'],
        'openid'=>$withdraw['openid'],
        'store_id'=>$withdraw['store_id'],
        'money'=>$withdraw['realmoney'],
        'baowen'=>$xml,
        'wd_id'=>$withdraw['id'],
        'add_time'=>time(),
        'request_data'=>json_encode($data),
    );
    pdo_insert('yzcyk_sun_withdraw_baowen',$baowen);
    //更改提现状态 商家明显提现状态
    $arr=xml2array($xml);
    if($arr['return_code']=='SUCCESS'&&$arr['result_code']=='SUCCESS'){
        pdo_update('yzcyk_sun_withdraw',array('status'=>1,'tx_time'=>time(),'request_time'=>time()),array('uniacid'=>$_W['uniacid'],'id'=>$withdraw['id']));
        pdo_update('yzcyk_sun_mercapdetails',array('status'=>1),array('uniacid'=>$_W['uniacid'],'wd_id'=>$withdraw['id']));
    }else{
        pdo_update('yzcyk_sun_withdraw',array('status'=>2,'request_time'=>time(),'err_code'=>$arr['err_code'],'err_code_des'=>$arr['err_code_des']),array('uniacid'=>$_W['uniacid'],'id'=>$withdraw['id']));
        pdo_update('yzcyk_sun_mercapdetails',array('status'=>2),array('uniacid'=>$_W['uniacid'],'wd_id'=>$withdraw['id']));
    }
    return $arr;

}
function createNoncestr($length = 32) {
    $chars = "abcdefghijklmnopqrstuvwxyz0123456789";
    $str = "";
    for ($i = 0; $i < $length; $i++) {
        $str .= substr($chars, mt_rand(0, strlen($chars) - 1), 1);
    }
    return $str;
}
function getSign($Obj,$key) {
    foreach ($Obj as $k => $v) {
        $Parameters[$k] = $v;
    }
    //签名步骤一：按字典序排序参数
    ksort($Parameters);
    $String = formatBizQueryParaMap($Parameters, false);
    //签名步骤二：在string后加入KEY
    $String = $String . "&key=" . $key;
    //签名步骤三：MD5加密
    $String = md5($String);
    //签名步骤四：所有字符转为大写
    $result_ = strtoupper($String);
    return $result_;
}
function formatBizQueryParaMap($paraMap, $urlencode) {
    $buff = "";
    ksort($paraMap);
    foreach ($paraMap as $k => $v) {
        if ($urlencode) {
            $v = urlencode($v);
        }
        $buff .= $k . "=" . $v . "&";
    }
    $reqPar;
    if (strlen($buff) > 0) {
        $reqPar = substr($buff, 0, strlen($buff) - 1);
    }
    return $reqPar;
}
function postXmlCurl($xml, $url, $second = 30)
{
    global $_W;
    if(!$url){
        $url = "https://api.mch.weixin.qq.com/secapi/pay/refund";//微信退款地址，post请求
    }
    $xml = arrayToXmls($xml);
    $refund_xml='';
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 1);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
    curl_setopt($ch, CURLOPT_SSLCERTTYPE, 'PEM');
    curl_setopt($ch, CURLOPT_SSLCERT, IA_ROOT . '/addons/yzcyk_sun/cert/apiclient_cert_'.$_W['uniacid'].'.pem');
    curl_setopt($ch, CURLOPT_SSLKEYTYPE, 'PEM');
    curl_setopt($ch, CURLOPT_SSLKEY, IA_ROOT . '/addons/yzcyk_sun/cert/apiclient_key_'.$_W['uniacid'].'.pem');
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $xml);
    $refund_xml = curl_exec($ch);
    $errono = curl_errno($ch);
    curl_close($ch);
    return $refund_xml;
}
function arrayToXmls($arr)
{
    $xml = "<root>";
    foreach ($arr as $key => $val) {
        if (is_array($val)) {
            $xml .= "<" . $key . ">" . arrayToXml($val) . "</" . $key . ">";
        } else {
            $xml .= "<" . $key . ">" . $val . "</" . $key . ">";
        }
    }
    $xml .= "</root>";
    return $xml;
}

if($_GPC['op']=='delete'){
    $res=pdo_update('yzcyk_sun_withdraw',array('del_status'=>1),array('id'=>$_GPC['id'],'uniacid'=>$_W['uniacid']));
    if($res){
        message('删除成功！', $this->createWebUrl('withdraw'), 'success');
    }else{
        message('删除失败！','','error');
    }
}elseif($_GPC['op']=='pass'){
    $id = intval($_GPC['id']);
    $uniacid = $_W['uniacid'];
    $withdraw = pdo_get('yzcyk_sun_withdraw',array('uniacid'=>$uniacid,'id'=>$id));
    if($withdraw['is_state']==1&&$withdraw['state']==0){
        $res=pdo_update('yzcyk_sun_withdraw',array('state'=>1,'review_time'=>time()),array('id'=>$id,'uniacid'=>$uniacid));
        $withdraw=pdo_get('yzcyk_sun_withdraw',array('uniacid'=>$_W['uniacid'],'id'=>$withdraw['id']));
        $arr=tixian($withdraw);
        if($arr['return_code']=='SUCCESS'&&$arr['result_code']=='SUCCESS'){
            $msg='提现成功请在微信钱包查看。';
        }else{
            $msg='提现失败，原因'.$arr['err_code_des'].'请联系平台管理人员';
        }
        message($msg,$this->createWebUrl('withdraw'), 'success');
    }else{
        message('系统错误！','','error');
    }
}elseif($_GPC['op']=='nopass'){
    $id = intval($_GPC['id']);
    $uniacid = $_W['uniacid'];
    $withdraw = pdo_get('yzcyk_sun_withdraw',array('uniacid'=>$uniacid,'id'=>$id));
    if($withdraw['is_state']==1&&$withdraw['state']==0){
        $res=pdo_update('yzcyk_sun_withdraw',array('state'=>2,'review_time'=>time()),array('id'=>$id,'uniacid'=>$uniacid));
        //拒绝增加商户金额
        pdo_update('yzcyk_sun_store',array('money +='=>$withdraw['money']),array('uniacid'=>$_W['uniacid'],'id'=>$withdraw['store_id']));
        //增加商家资金明细记录
        $mcd_memo="商家提现-审核拒绝总金额:￥".$withdraw['money'];
        $mercapdetails=array(
            'uniacid'=>$_W['uniacid'],
            'store_id'=>$withdraw['store_id'],
            'store_name'=>$withdraw['store_name'],
            'mcd_type'=>3,
            'sign'=>1,
            'mcd_memo'=>$mcd_memo,
            'money'=>$withdraw['money'],
            'realmoney'=>$withdraw['realmoney'],
            'paycommission'=>$withdraw['paycommission'],
            'ratesmoney'=>$withdraw['ratesmoney'],
            'wd_id'=>$withdraw['id'],
            'add_time'=>time(),
        );
        pdo_insert('yzcyk_sun_mercapdetails',$mercapdetails);
        //拒绝扣除平台累计金额
        pdo_update('yzcyk_sun_platform',array('total_money -='=>$withdraw['money'],'total_realmoney -='=>$withdraw['realmoney'],'total_paycommission -='=>$withdraw['paycommission'],'total_ratesmoney -='=>$withdraw['ratesmoney']),array('uniacid'=>$_W['uniacid']));

        if($res){
            message('拒绝成功！', $this->createWebUrl('withdraw'), 'success');
        }else{
            message('拒绝失败！','','error');
        }
    }else{
        message('系统错误！','','error');
    }
}else if($_GPC['op']=='refundbalance'){
    $id = intval($_GPC['id']);
    $uniacid = $_W['uniacid'];
    $withdraw = pdo_get('yzcyk_sun_withdraw',array('uniacid'=>$uniacid,'id'=>$id));
    if($withdraw['status']!=2||$withdraw['return_status']!=0){
        message('已退款不要重复退款！','','error');
    }
    //更新提现状态
    $res=pdo_update('yzcyk_sun_withdraw',array('return_status'=>1,'return_time'=>time()),array('uniacid'=>$_W['uniacid'],'id'=>$id));
    //增加商户金额
    pdo_update('yzcyk_sun_store',array('money +='=>$withdraw['money']),array('uniacid'=>$_W['uniacid'],'id'=>$withdraw['store_id']));
    //增加商户金额明细
    $mcd_memo="商家提现失败返还-提现总金额:￥{$withdraw['money']};支付佣金:￥{$withdraw['paycommission']};支付手续费:￥{$withdraw['ratesmoney']};实际提现金额:￥{$withdraw['realmoney']}";
    $store=pdo_get('yzcyk_sun_store',array('id'=>$withdraw['store_id']));
    $mercapdetails=array(
        'uniacid'=>$_W['uniacid'],
        'store_id'=>$withdraw['store_id'],
        'store_name'=>$store['store_name'],
        'mcd_type'=>5,
        'sign'=>1,
        'mcd_memo'=>$mcd_memo,
        'money'=>$withdraw['money'],
        'realmoney'=>$withdraw['realmoney'],
        'paycommission'=>$withdraw['paycommission'],
        'ratesmoney'=>$withdraw['ratesmoney'],
        'wd_id'=>$withdraw['id'],
        'add_time'=>time(),
    );
    pdo_insert('yzcyk_sun_mercapdetails',$mercapdetails);
    if($res){
        message('退款成功！', $this->createWebUrl('withdraw'), 'success');
    }else{
        message('拒绝失败！','','error');
    }
}else{
    $where=" WHERE uniacid=:uniacid ";
    $keyword = $_GPC['keyword'];
    if($_GPC['keyword']){
        $op=$_GPC['keyword'];
        $where.=" and store_name LIKE '%$op%'";
    }
    $data[':uniacid']=$_W['uniacid'];
    $where .= " and del_status=0 ";
    if($_GPC["type"]=='s'){
        $status = intval($_GPC['tx_status']);
        if($status!=999){
            if($status==0){
                $where .= " and is_state=1 and state=0 ";
            }else if($status==2){
                $where .= " and is_state=1 and state=2 ";
            }else if($status==1){
                $where .= " and status=1 ";
            }else if($status==3){
                $where .= " and status=2 ";
            }
        }
    }else{
        $status = 999;
    }
    $pageindex = max(1, intval($_GPC['page']));
    $pagesize=10;
    $sql="select * from " . tablename("yzcyk_sun_withdraw") ." ".$where." order by id desc ";
    $total=pdo_fetchcolumn("select count(*) as wname from " . tablename("yzcyk_sun_withdraw") . " " .$where." ",$data);
    $select_sql =$sql." LIMIT " .($pageindex - 1) * $pagesize.",".$pagesize;
    $list=pdo_fetchall($select_sql,$data);
    $pager = pagination($total, $pageindex, $pagesize);
}
include $this->template('web/withdraw');