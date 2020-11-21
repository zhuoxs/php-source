<?php
/**
 * ��̨Ӧ����
 * ============================================================================
 * api˵����
 * getKey()/setKey(),��ȡ/������Կ
 * getContent() / setContent(), ��ȡ/����ԭʼ����
 * getParameter()/setParameter(),��ȡ/���ò���ֵ
 * getAllParameters(),��ȡ���в���
 * isTenpaySign(),�Ƿ�Ƹ�ͨǩ��,true:�� false:��
 * getDebugInfo(),��ȡdebug��Ϣ
 * 
 * ============================================================================
 *
 */

class ClientResponseHandlerClass  {
	
	/** ��Կ */
	var $key;
	
	/** Ӧ��Ĳ��� */
	var $parameters;
	
	/** debug��Ϣ */
	var $debugInfo;
	
	//ԭʼ����
	var $content;
	
	function __construct() {
		$this->ClientResponseHandler();
	}
	
	function ClientResponseHandler() {
		$this->key = "";
		$this->parameters = array();
		$this->debugInfo = "";
		$this->content = "";
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
	
	//����ԭʼ���ݣ�ȷ��PHP����֧��simplexml_load_string�Լ�iconv����������ſ���
	//һ��PHP5������û���⣬PHP4��Ҫ���һ�»����Ƿ�װ��iconv�Լ�simplexmlģ��
	function setContent($content) {
		$this->content = $content;
		
		$xml = simplexml_load_string($this->content);
		$encode = $this->getXmlEncode($this->content);
		
		if($xml && $xml->children()) {
			foreach ($xml->children() as $node){
				//���ӽڵ�
				if($node->children()) {
					$k = $node->getName();
					$nodeXml = $node->asXML();
					$v = substr($nodeXml, strlen($k)+2, strlen($nodeXml)-2*strlen($k)-5);
					
				} else {
					$k = $node->getName();
					$v = (string)$node;
				}
				
				if($encode!="" && $encode != "UTF-8") {
					$k = iconv("UTF-8", $encode, $k);
					$v = iconv("UTF-8", $encode, $v);
				}
				
				$this->setParameter($k, $v);			
			}
		}	
	}
	
	//����ԭʼ����
	//���PHP4�ϻ����²�֧��simplexml�Լ�iconv���ܵĺ���
	function setContent_backup($content) {
		$this->content = $content;
		$encode = $this->getXmlEncode($this->content);
		$xml = new SofeeXmlParser(); 
		$xml->parseFile($this->content); 
		$tree = $xml->getTree(); 
		unset($xml); 
		foreach ($tree['root'] as $key => $value) {
			if($encode!="" && $encode != "UTF-8") {
				$k = mb_convert_encoding($key, $encode, "UTF-8");
				$v = mb_convert_encoding($value[value], $encode, "UTF-8");								
			}
			else 
			{
				$k = $key;
				$v = $value[value];
			}
			$this->setParameter($k, $v);
		}
	}
	
	
	
	//��ȡԭʼ����
	function getContent() {
		return $this->content;
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
	*�Ƿ�Ƹ�ͨǩ��,������:���������a-z����,������ֵ�Ĳ���μ�ǩ��
	*true:��
	*false:��
	*/	
	function isTenpaySign() {
		$signPars = "";
		ksort($this->parameters);
		foreach($this->parameters as $k => $v) {
			if("sign" != $k && "" != $v) {
				$signPars .= $k . "=" . $v . "&";
			}
		}
		$signPars .= "key=" . $this->getKey();
		
		$sign = strtolower(md5($signPars));
		
		$tenpaySign = strtolower($this->getParameter("sign"));
				
		//debug��Ϣ
		$this->_setDebugInfo($signPars . " => sign:" . $sign .
				" tenpaySign:" . $this->getParameter("sign"));
		
		return $sign == $tenpaySign;
		
	}
	
	/**
	*��ȡdebug��Ϣ
	*/	
	function getDebugInfo() {
		return $this->debugInfo;
	}
	
	//��ȡxml����
	function getXmlEncode($xml) {
		$ret = preg_match ("/<?xml[^>]* encoding=\"(.*)\"[^>]* ?>/i", $xml, $arr);
		if($ret) {
			return strtoupper ( $arr[1] );
		} else {
			return "";
		}
	}
	
	/**
	*����debug��Ϣ
	*/	
	function _setDebugInfo($debugInfo) {
		$this->debugInfo = $debugInfo;
	}
	
	/**
	 * �Ƿ�Ƹ�ͨǩ��
	 * @param signParameterArray ǩ��Ĳ�������
	 * @return boolean
	 */	
	function _isTenpaySign($signParameterArray) {
	
		$signPars = "";
		foreach($signParameterArray as $k) {
			$v = $this->getParameter($k);
			if("sign" != $k && "" != $v) {
				$signPars .= $k . "=" . $v . "&";
			}			
		}
		$signPars .= "key=" . $this->getKey();
		
		$sign = strtolower(md5($signPars));
		
		$tenpaySign = strtolower($this->getParameter("sign"));
				
		//debug��Ϣ
		$this->_setDebugInfo($signPars . " => sign:" . $sign .
				" tenpaySign:" . $this->getParameter("sign"));
		
		return $sign == $tenpaySign;		
		
	
	}
	
}


?>