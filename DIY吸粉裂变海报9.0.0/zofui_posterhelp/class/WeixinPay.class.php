<?php 

class WeixinPay
{
		
	
	//企业付款
	public function sendMoneyToUser($arr,$module) {
		global $_W;
		$key = $module->module['config']['apikey'];
		$mchid = $module->module['config']['mchid'];
		$appid = $module->module['config']['appid'];

		$data['mch_appid'] = $appid;
		$data['mchid'] = $mchid;
		//设备号
		$data['nonce_str'] = $this->createNoncestr();
		$data['partner_trade_no'] = $data['mchid'].date("Ymd",time()).date("His",time()).rand(1111,9999);		
		$data['openid'] = $arr['openid'];		
		$data['check_name'] = 'NO_CHECK';
		$data['amount'] = $arr['fee']*100;		
		$data['desc'] = '活动红包';
		$data['spbill_create_ip'] = getIp();
		$data['sign'] = $this->getSign($data,$key);
		if(empty($data['mch_appid']) || empty($data['mchid'])){
			$rearr['err_code_des']='请先设置微信商户号和秘钥';
			return $rearr;
		}		
		if(!$data['openid']){
			$rearr['err_code_des']='缺少用户openid';
			return $rearr;
		}
		$xml = $this->arrayToXml($data);
		$url ="https://api.mch.weixin.qq.com/mmpaymkttransfers/promotion/transfers";
		$re = $this->wxHttpsRequestPem($xml,$url);
		if( !is_array( $re ) ){
			$re = $this->xmlToArray($re);
		}
		return $re;
	}



	//发红包 openid AND hbname AND fee AND body IN $arr
	public function sendhongbaoto($arr,$module) {

		$key = $module->module['config']['apikey'];
		$mchid = $module->module['config']['mchid'];
		
		$data['mch_id'] = $mchid;
		$data['mch_billno'] = $data['mch_id'].date("Ymd",time()).date("His",time()).rand(1111,9999);
		$data['nonce_str'] = $this->createNoncestr();
		$data['re_openid'] = $arr['openid'];
		$data['wxappid'] = $module->module['config']['appid'];
		$data['nick_name'] = $arr['hbname'];
		$data['send_name'] = $arr['hbname'];
		$data['total_amount'] = $arr['fee']*100;
		$data['min_value'] = $arr['fee']*100;
		$data['max_value'] = $arr['fee']*100;
		$data['total_num'] = 1;
		$data['client_ip'] = getIp();
		$data['act_name'] = '活动红包';
		$data['remark'] = '活动红包';
		$data['wishing'] = $arr['body'];

		if(empty($data['wxappid']) || empty($data['mch_id'])){
			$rearr['err_code_des']='请先设置微信商户号和秘钥';
			return $rearr;
		}		
		if(!$data['re_openid']){
			$rearr['err_code_des']='缺少用户openid';
			return $rearr;
		}

		$data['sign'] = $this->getSign($data,$key);
		$xml = $this->arrayToXml($data);
		$url ="https://api.mch.weixin.qq.com/mmpaymkttransfers/sendredpack";
		$re = $this->wxHttpsRequestPem($xml,$url);
		if( !is_array( $re ) ){
			$re = $this->xmlToArray($re);
		}
		return $re;
	}	


	
	//退款方法
	public function commonRefund($data){
		$xml = $this->arrayToXml($data);
		$url ="https://api.mch.weixin.qq.com/secapi/pay/refund";
		$re = $this->wxHttpsRequestPem($xml,$url);
		if( !is_array( $re ) ){
			$re = $this->xmlToArray($re);
		}
		return $re;
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
	
	public function getSign($Obj,$key) {
		global $_W;		
		foreach ($Obj as $k => $v) 
		{
			$Parameters[$k] = $v;
		}
		ksort($Parameters);
		$String = $this->formatBizQueryParaMap($Parameters, false);
		$String = $String."&key=".$key;
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
	
	public function wxHttpsRequestPem( $vars,$url, $second=30,$aHeader=array()) {
		global $_W;
		$ch = curl_init();
		curl_setopt($ch,CURLOPT_TIMEOUT,$second);
		curl_setopt($ch,CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch,CURLOPT_URL,$url);
		curl_setopt($ch,CURLOPT_SSL_VERIFYPEER,false);
		curl_setopt($ch,CURLOPT_SSL_VERIFYHOST,false);
		curl_setopt($ch,CURLOPT_SSLCERTTYPE,'PEM');
		curl_setopt($ch,CURLOPT_SSLCERT,IA_ROOT.'/addons/zofui_posterhelp/cert/'.$_W['uniacid'].'/apiclient_cert.pem');
		curl_setopt($ch,CURLOPT_SSLKEYTYPE,'PEM');
		curl_setopt($ch,CURLOPT_SSLKEY,IA_ROOT.'/addons/zofui_posterhelp/cert/'.$_W['uniacid'].'/apiclient_key.pem');
		curl_setopt($ch,CURLOPT_CAINFO,'PEM');
		curl_setopt($ch,CURLOPT_CAINFO,IA_ROOT.'/addons/zofui_posterhelp/cert/'.$_W['uniacid'].'/rootca.pem');
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
			//echo "call faild, errorCode:$error\n";
			curl_close($ch);
			return array('result_code'=>'FAIL','err_code_des'=>'检查是否设置了正确的支付证书');
		}
	}
	
	
}

?>