<?php 

class WeixinPay
{
	
	//退款
	public function refund($arr) {
		global $_W;
		$setting = uni_setting($_W['uniacid'], array('payment'));
		
		$data['appid'] = $_W['account']['key'];
		$data['mch_id'] = $setting['payment']['wechat']['mchid'];
		
		$data['transaction_id'] = $arr['transid'];
		$data['out_refund_no'] = $arr['transid']. rand(1000,9999);
		
		$data['total_fee'] = $arr['totalmoney']*100;
		$data['refund_fee'] = $arr['refundmoney']*100;
		$data['op_user_id'] = $setting['payment']['wechat']['mchid'];
		if($arr['refund_account']==2) $data['refund_account'] = 'REFUND_SOURCE_RECHARGE_FUNDS';
		$data['nonce_str'] = $this->createNoncestr();
		
		$data['sign'] = $this->getSign($data);		
		
		if(empty($data['appid']) || empty($data['mch_id'])){
			$rearr['return_msg']='请先在微擎的功能选项-支付参数内设置微信商户号和秘钥';
			return $rearr;
		}
		if($data['total_fee'] > $data['refund_fee']){
			$rearr['return_msg']='退款金额不能大于实际支付金额';
			return $rearr;			
		}		
		$xml = $this->arrayToXml($data);
		$url ="https://api.mch.weixin.qq.com/secapi/pay/refund";
		$re = $this->wxHttpsRequestPem($xml,$url);
		$rearr = $this->xmlToArray($re);

		return $rearr;
	}
//查询退款
	public function checkRefund($transid) {
		global $_W;
		$setting = uni_setting($_W['uniacid'], array('payment'));
		
		$data['appid'] = $_W['account']['key'];
		$data['mch_id'] = $setting['payment']['wechat']['mchid'];
		$data['transaction_id'] = $transid;
		$data['nonce_str'] = $this->createNoncestr();
		$data['sign'] = $this->getSign($data);		
		
		if(empty($data['appid']) || empty($data['mch_id'])){
			$rearr['return_msg']='请先在微擎的功能选项-支付参数内设置微信商户号和秘钥';
			return $rearr;
		}
		$xml = $this->arrayToXml($data);
		$url ="https://api.mch.weixin.qq.com/pay/refundquery";
		$re = $this->wxHttpsRequestPem($xml,$url);
		$rearr = $this->xmlToArray($re);

		return $rearr;
	}
	
	public function createNoncestr( $length = 32 ) {
		$chars = "abcdefghijklmnopqrstuvwxyz0123456789";
		$str ="";
		for ( $i = 0; $i < $length; $i++ ) 
		{
			$str.= substr($chars, mt_rand(0, strlen($chars)-1), 1);
		}
		return $str;
	}
	
	function formatBizQueryParaMap($paraMap, $urlencode) {
		$buff = "";
		ksort($paraMap);
		foreach ($paraMap as $k => $v) 
		{
			if($urlencode) 
			{
				$v = urlencode($v);
			}
			$buff .= $k . "=" . $v . "&";
		}
		$reqPar;
		if (strlen($buff) > 0) 
		{
			$reqPar = substr($buff, 0, strlen($buff)-1);
		}
		return $reqPar;
	}
	
	public function getSign($Obj) {
		global $_W;		
		$setting = uni_setting($_W['uniacid'], array('payment'));
		foreach ($Obj as $k => $v) 
		{
			$Parameters[$k] = $v;
		}
		ksort($Parameters);
		$String = $this->formatBizQueryParaMap($Parameters, false);
		$String = $String."&key=".$setting['payment']['wechat']['apikey'];
		$String = md5($String);
		$result_ = strtoupper($String);
		return $result_;
	}
	
	public function arrayToXml($arr) {
		$xml = "<xml>";
		foreach ($arr as $key=>$val) 
		{
			if (is_numeric($val)) 
			{
				$xml.="<".$key.">".$val."</".$key.">";
			}
			else $xml.="<".$key."><![CDATA[".$val."]]></".$key.">";
		}
		$xml.="</xml>";
		return $xml;
	}
	public function xmlToArray($xml) {
		$array_data = json_decode(json_encode(simplexml_load_string($xml, 'SimpleXMLElement', LIBXML_NOCDATA)), true);
		return $array_data;
	}
	
	public function wxHttpsRequestPem($vars,$url, $second=30,$aHeader=array()) {
		global $_W;
		$ch = curl_init();
		curl_setopt($ch,CURLOPT_TIMEOUT,$second);
		curl_setopt($ch,CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch,CURLOPT_URL,$url);
		curl_setopt($ch,CURLOPT_SSL_VERIFYPEER,false);
		curl_setopt($ch,CURLOPT_SSL_VERIFYHOST,false);
		curl_setopt($ch,CURLOPT_SSLCERTTYPE,'PEM');
		curl_setopt($ch,CURLOPT_SSLCERT,IA_ROOT . '/attachment/feng_fightgroups/cert/' . $_W['uniacid'] . '/apiclient_cert.pem');
		curl_setopt($ch,CURLOPT_SSLKEYTYPE,'PEM');
		curl_setopt($ch,CURLOPT_SSLKEY,IA_ROOT . '/attachment/feng_fightgroups/cert/' . $_W['uniacid'] . '/apiclient_key.pem');
		curl_setopt($ch,CURLOPT_CAINFO,'PEM');
		curl_setopt($ch,CURLOPT_CAINFO,IA_ROOT . '/attachment/feng_fightgroups/cert/' . $_W['uniacid'] . '/rootca.pem');
		if( count($aHeader) >= 1 )
		{
			curl_setopt($ch, CURLOPT_HTTPHEADER, $aHeader);
		}
		curl_setopt($ch,CURLOPT_POST, 1);
		curl_setopt($ch,CURLOPT_POSTFIELDS,$vars);
		$data = curl_exec($ch);
		if($data)
		{
			curl_close($ch);
			return $data;
		}
		else 
		{
			$error = curl_errno($ch);
			echo "call faild, errorCode:$error\n";
			curl_close($ch);
			return false;
		}
	}
	
	
}

?>