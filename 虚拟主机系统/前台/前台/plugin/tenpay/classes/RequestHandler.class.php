<?php
/**
 * ������
 * ============================================================================
 * api˵����
 * init(),��ʼ������Ĭ�ϸ�һЩ����ֵ����cmdno,date�ȡ�
 * getGateURL()/setGateURL(),��ȡ/������ڵ�ַ,�������ֵ
 * getKey()/setKey(),��ȡ/������Կ
 * getParameter()/setParameter(),��ȡ/���ò���ֵ
 * getAllParameters(),��ȡ���в���
 * getRequestURL(),��ȡ����������URL
 * doSend(),�ض��򵽲Ƹ�֧ͨ��
 * getDebugInfo(),��ȡdebug��Ϣ
 * 
 * ============================================================================
 *
 */
class RequestHandlerClass {
	
	/** ���url��ַ */
	var $gateUrl;
	
	/** ��Կ */
	var $key;
	
	/** ����Ĳ��� */
	var $parameters;
	
	/** debug��Ϣ */
	var $debugInfo;
	
	function __construct() {
		$this->RequestHandler();
	}
	
	function RequestHandler() {
		$this->gateUrl = "https://www.tenpay.com/cgi-bin/v1.0/service_gate.cgi";
		$this->key = "";
		$this->parameters = array();
		$this->debugInfo = "";
	}
	
	/**
	*��ʼ������
	*/
	function init() {
		//nothing to do
	}
	
	/**
	*��ȡ��ڵ�ַ,�������ֵ
	*/
	function getGateURL() {
		return $this->gateUrl;
	}
	
	/**
	*������ڵ�ַ,�������ֵ
	*/
	function setGateURL($gateUrl) {
		$this->gateUrl = $gateUrl;
	}
	
	/**
	*��ȡ��Կ
	*/
	function getKey() {
		return $this->key;
	}
	
	/**
	*������Կ
	*/
	function setKey($key) {
		$this->key = $key;
	}
	
	/**
	*��ȡ����ֵ
	*/
	function getParameter($parameter) {
		return $this->parameters[$parameter];
	}
	
	/**
	*���ò���ֵ
	*/
	function setParameter($parameter, $parameterValue) {
		$this->parameters[$parameter] = $parameterValue;
	}
	
	/**
	*��ȡ��������Ĳ���
	*@return array
	*/
	function getAllParameters() {
		return $this->parameters;
	}
	
	/**
	*��ȡ����������URL
	*/
	function getRequestURL() {
	
		$this->createSign();
		
		$reqPar = "";
		ksort($this->parameters);
		foreach($this->parameters as $k => $v) {
			$reqPar .= $k . "=" . urlencode($v) . "&";
		}
		
		//ȥ�����һ��&
		$reqPar = substr($reqPar, 0, strlen($reqPar)-1);
		
		$requestURL = $this->getGateURL() . "?" . $reqPar;
		
		return $requestURL;
		
	}
		
	/**
	*��ȡdebug��Ϣ
	*/
	function getDebugInfo() {
		return $this->debugInfo;
	}
	
	/**
	*�ض��򵽲Ƹ�֧ͨ��
	*/
	function doSend() {
		header("Location:" . $this->getRequestURL());
		exit;
	}
	
	/**
	*����md5ժҪ,������:���������a-z����,������ֵ�Ĳ���μ�ǩ��
	*/
	function createSign() {
		$signPars = "";
		ksort($this->parameters);
		foreach($this->parameters as $k => $v) {
			if("" != $v && "sign" != $k) {
				$signPars .= $k . "=" . $v . "&";
			}
		}
		$signPars .= "key=" . $this->getKey();
		$sign = strtolower(md5($signPars));
		$this->setParameter("sign", $sign);
		
		//debug��Ϣ
		$this->_setDebugInfo($signPars . " => sign:" . $sign);
		
	}	
	
	/**
	*����debug��Ϣ
	*/
	function _setDebugInfo($debugInfo) {
		$this->debugInfo = $debugInfo;
	}

}

?>