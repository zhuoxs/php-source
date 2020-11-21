<?php
/**
 * APP接口
 */
global $_W, $_GPC;
$weid=$_W['uniacid'];
$cid = intval($_GPC['cid']);
$keyword = $_GPC['s'];

$appid="posesg";
$appsecret="kN83v57QGnQGkuhyqlBjCOOYubHo6d";

if($_W['ispost']){	
$param=$_POST; 
$gettoken=$param['sign'];
$param['appsecret']=$appsecret;
}else{
	header('Content-type:text/json'); 
	$json='{"msg":"非法提交!","status":"0"}'; 
	echo $json;
	exit();
} 

$status=getSignVeryfy($param, $gettoken);
if($status){
	//改写订单号为已经制作
	$data = array(
    'is_make' => $param['status'], 
	);
	 
	$result = pdo_update('ewei_shop_order_goods', $data, array('orderid' =>$param['ordersn'],'goodsid'=>$param['goodsid']));
	if (!empty($result)){
	header('Content-type:text/json'); 
	$json='{"msg":"更新成功","status":"1"}'; 
	echo $json;
	exit();
	}else{
	header('Content-type:text/json'); 
	$json='{"msg":"更新失败","status":"0"}'; 
	echo $json;
	exit();	
	}

}else{
	header('Content-type:text/json'); 
	$json='{"msg":"权限错误","status":"0"}'; 
	echo $json;
	exit();	
}



	
function getSignVeryfy($param, $sign){
        //除去待签名参数数组中的空值和签名参数
        $param_filter = array();
        while (list ($key, $val) = each($param)) {
            if ($key == "sign") {
                continue;
            } else {
                $param_filter[$key] = $param[$key];
            }
        }

         $mysgin =createSign($param_filter);

        if ($mysgin == $sign) {
            return true;
        } else {
            return false;
        }
}


    /**
     * 创建签名
     * @param type $params
     */
function createSign($params){
        ksort($params);
        reset($params);

        $arg = "";
        foreach ($params as $key => $value) {
            $arg .= "&{$key}={$value}";
        }
		 $arg=trim(substr($arg,1));

        return md5($arg);
}

?>