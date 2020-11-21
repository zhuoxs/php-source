<?
date_default_timezone_set('Asia/Shanghai');
header("Cache-Control: no-cache, must-revalidate");
header("Content-Type: text/html; charset=utf-8");
define('SYS_ROOT', dirname(dirname(dirname(__FILE__))).'/framework');
include(SYS_ROOT . '/runtime.php');
$key = $setting['china_key'];							//登陆后在上面的导航栏里可能找到“B2C”，在二级导航栏里有“MD5密钥设置”
$v_oid     =trim($_POST['v_oid']);       // 商户发送的v_oid定单编号   
$v_pmode   =trim($_POST['v_pmode']);    // 支付方式（字符串）   
$v_pstatus =trim($_POST['v_pstatus']);   //  支付状态 ：20（支付成功）；30（支付失败）
$v_pstring =trim($_POST['v_pstring']);   // 支付结果信息 ： 支付完成（当v_pstatus=20时）；失败原因（当v_pstatus=30时,字符串）； 
$v_amount  =trim($_POST['v_amount']);     // 订单实际支付金额
$v_moneytype  =trim($_POST['v_moneytype']); //订单实际支付币种    
$remark1   =trim($_POST['remark1' ]);      //备注字段1
$remark2   =trim($_POST['remark2' ]);     //备注字段2
$v_md5str  =trim($_POST['v_md5str' ]);   //拼凑后的MD5校验值  

/**
 * 重新计算md5的值
 */
$md5string=strtoupper(md5($v_oid.$v_pstatus.$v_amount.$v_moneytype.$key));

/**
 * 判断返回信息，如果支付成功，并且支付结果可信，则做进一步的处理
 */
if ($v_md5str==$md5string) {
	if ($v_pstatus == "20") {
		//商户系统的逻辑处理（例如判断金额，判断支付状态，更新订单状态等等）......
		if (!apicall('money','payReturn',array($remark1,$v_amount*100,'网银在线支付'))) {
			echo "支付失败，请联系管理员对账";
		}else {
			echo "成功支付 ".$v_amount." 元";
		}
	}else{
		echo "status=".$v_pstatus."<br>";
		echo "支付失败";
	}
}else{
	echo "<br>校验失败,数据可疑";
}
?>
