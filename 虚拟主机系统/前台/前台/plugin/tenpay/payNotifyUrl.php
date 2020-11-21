<META http-equiv=Content-Type content="text/html; charset=utf-8">
<?php
define ( 'APPLICATON_ROOT', dirname ( __FILE__ ) );
define ( 'SYS_ROOT',  dirname ( dirname ( dirname ( __FILE__ ) ) )  . '/framework' );
define ( 'DEFAULT_CONTROL', 'index' );
include (SYS_ROOT . '/runtime.php');
require_once ("./classes/ResponseHandler.class.php");
$setting = getSetting ();
$key = $setting['tenpay_key'];
require ("classes/ResponseHandler.class.php");
require ("classes/RequestHandler.class.php");
require ("classes/client/ClientResponseHandler.class.php");
require ("classes/client/TenpayHttpClient.class.php");
		/* 创建支付应答对象 */
		$resHandler = new ResponseHandlerClass();
		$resHandler->setKey($key);
		//判断签名
		if($resHandler->isTenpaySign()) {
			//通知id
			$notify_id = $resHandler->getParameter("notify_id");
			//通过通知ID查询，确保通知来至财付通
			//创建查询请求
			$queryReq = new RequestHandlerClass();
			$queryReq->init();
			$queryReq->setKey($key);
			$queryReq->setGateUrl("https://gw.tenpay.com/gateway/simpleverifynotifyid.xml");
			$queryReq->setParameter("partner", $partner);
			$queryReq->setParameter("notify_id", $notify_id);
			//通信对象
			$httpClient = new TenpayHttpClientClass();
			$httpClient->setTimeOut(5);
			$httpClient->setReqContent($queryReq->getRequestURL());
			if($httpClient->call()) {
			//设置结果参数
				$queryRes = new ClientResponseHandlerClass();
				$queryRes->setContent($httpClient->getResContent());
				$queryRes->setKey($key);
			
				if($resHandler->getParameter("trade_mode") == "1"){
					if($queryRes->isTenpaySign() && $queryRes->getParameter("retcode") == "0" && $resHandler->getParameter("trade_state") == "0") {
						$out_trade_no = $resHandler->getParameter("out_trade_no");
						//财付通订单号
						$transaction_id = $resHandler->getParameter("transaction_id");
						//金额,以分为单位
						$total_fee = $resHandler->getParameter("total_fee");
						//如果有使用折扣券，discount有值，total_fee+discount=原请求的total_fee
						$discount = $resHandler->getParameter("discount");
						$option = explode ( '-', $out_trade_no );
						$id = intval($option [0]);
						$ret = apicall ( 'money', 'payReturn', array ($id,$total_fee/100,"财付通订单号:{$transaction_id},通知ID{$notify_id}" ) );
						if ($ret) {
							die("success");
						} 
					}
					die("fail"); 
				}elseif ($resHandler->getParameter("trade_mode") == "2") {
		    		//判断签名及结果（中介担保）
					//只有签名正确,retcode为0，trade_state为0才是支付成功
					if($queryRes->isTenpaySign() && $queryRes->getParameter("retcode") == "0" ) {
						//取结果参数做业务处理
						$out_trade_no = $resHandler->getParameter("out_trade_no");
						//财付通订单号
						$transaction_id = $resHandler->getParameter("transaction_id");
						$total_fee = $resHandler->getParameter("total_fee");
						switch ($resHandler->getParameter("trade_state")) {
								case "0":	//付款成功
									break;
								case "1":	//交易创建
									break;
								case "2":	//收获地址填写完毕
									break;
								case "4":	//卖家发货成功
									break;
								case "5":	//买家收货确认，交易成功
									$option = explode ( '-', $out_trade_no );
									$id = intval($option [0]);
									$ret = apicall ( 'money', 'payReturn', array ($id,$total_fee/100,"财付通订单号:{$transaction_id},通知ID{$notify_id}" ) );
									if ($ret) {
										echo "success";
									} else {
										echo "fail";
									}
									break;
								case "6":	//交易关闭，未完成超时关闭
									break;
								case "7":	//修改交易价格成功
									break;
								case "8":	//买家发起退款
									break;
								case "9":	//退款成功
									break;
								case "10":	//退款关闭			
									break;
								default:
									break;
						}
						die("success");
					} 
					die("fail");
			  }
	}
	die("fail");
}
?>