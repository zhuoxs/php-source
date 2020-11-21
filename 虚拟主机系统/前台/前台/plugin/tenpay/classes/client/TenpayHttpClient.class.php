<?php

/**
 * http��httpsͨ����
 * ============================================================================
 * api˵����
 * setReqContent($reqContent),�����������ݣ�����post��get������get��ʽ�ṩ
 * getResContent(), ��ȡӦ������
 * setMethod($method),�������󷽷�,post����get
 * getErrInfo(),��ȡ������Ϣ
 * setCertInfo($certFile, $certPasswd, $certType="PEM"),����֤�飬˫��httpsʱ��Ҫʹ��
 * setCaInfo($caFile), ����CA����ʽδpem���������򲻼��
 * setTimeOut($timeOut)�� ���ó�ʱʱ�䣬��λ��
 * getResponseCode(), ȡ���ص�http״̬��
 * call(),������ýӿ�
 * 
 * ============================================================================
 *
 */

class TenpayHttpClientClass {
	//�������ݣ�����post��get������get��ʽ�ṩ
	var $reqContent;
	//Ӧ������
	var $resContent;
	//���󷽷�
	var $method;
	
	//֤���ļ�
	var $certFile;
	//֤������
	var $certPasswd;
	//֤������PEM
	var	$certType;
	
	//CA�ļ�
	var $caFile;
	
	//������Ϣ
	var $errInfo;
	
	//��ʱʱ��
	var $timeOut;
	
	//http״̬��
	var $responseCode;
	
	function __construct() {
		$this->TenpayHttpClient();
	}
	
	
	function TenpayHttpClient() {
		$this->reqContent = "";
		$this->resContent = "";
		$this->method = "post";

		$this->certFile = "";
		$this->certPasswd = "";
		$this->certType = "PEM";
		
		$this->caFile = "";
		
		$this->errInfo = "";
		
		$this->timeOut = 120;
		
		$this->responseCode = 0;
		
	}
	
	
	//������������
	function setReqContent($reqContent) {
		$this->reqContent = $reqContent;
	}
	
	//��ȡ�������
	function getResContent() {
		return $this->resContent;
	}
	
	//�������󷽷�post����get	
	function setMethod($method) {
		$this->method = $method;
	}
	
	//��ȡ������Ϣ
	function getErrInfo() {
		return $this->errInfo;
	}
	
	//����֤����Ϣ
	function setCertInfo($certFile, $certPasswd, $certType="PEM") {
		$this->certFile = $certFile;
		$this->certPasswd = $certPasswd;
		$this->certType = $certType;
	}
	
	//����Ca
	function setCaInfo($caFile) {
		$this->caFile = $caFile;
	}
	
	//���ó�ʱʱ��,��λ��
	function setTimeOut($timeOut) {
		$this->timeOut = $timeOut;
	}
	
	//ִ��http����
	function call() {
		//����һ��CURL�Ự
		$ch = curl_init();

		// ����curl����ִ�е������
		curl_setopt($ch, CURLOPT_TIMEOUT, $this->timeOut);

		// ��ȡ����Ϣ���ļ�������ʽ���أ�����ֱ�������
		curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);

		// ��֤���м��SSL�����㷨�Ƿ����
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 1);
				
		
		$arr = explode("?", $this->reqContent);
		if(count($arr) >= 2 && $this->method == "post") {
			//����һ�������POST��������Ϊ��application/x-www-form-urlencoded������?�ύ��һ��
			curl_setopt($ch, CURLOPT_POST, 1);
			curl_setopt($ch, CURLOPT_URL, $arr[0]);
			//Ҫ���͵��������
			curl_setopt($ch, CURLOPT_POSTFIELDS, $arr[1]);
		
		}else{
			curl_setopt($ch, CURLOPT_URL, $this->reqContent);
		}
		
		//����֤����Ϣ
		if($this->certFile != "") {
			curl_setopt($ch, CURLOPT_SSLCERT, $this->certFile);
			curl_setopt($ch, CURLOPT_SSLCERTPASSWD, $this->certPasswd);
			curl_setopt($ch, CURLOPT_SSLCERTTYPE, $this->certType);
		}
		
		//����CA
		if($this->caFile != "") {
			// ����֤֤����Դ�ļ�飬0��ʾ��ֹ��֤��ĺϷ��Եļ�顣1��Ҫ����CURLOPT_CAINFO
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 1);
			curl_setopt($ch, CURLOPT_CAINFO, $this->caFile);
		} else {
			// ����֤֤����Դ�ļ�飬0��ʾ��ֹ��֤��ĺϷ��Եļ�顣1��Ҫ����CURLOPT_CAINFO
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
		}
		
		// ִ�в���
		$res = curl_exec($ch);
		$this->responseCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
		
		if ($res == NULL) { 
		   $this->errInfo = "call http err :" . curl_errno($ch) . " - " . curl_error($ch) ;
		   curl_close($ch);
		   return false;
		} else if($this->responseCode  != "200") {
			$this->errInfo = "call http err httpcode=" . $this->responseCode  ;
			curl_close($ch);
			return false;
		}
		
		curl_close($ch);
		$this->resContent = $res;

		
		return true;
	}
	
	function getResponseCode() {
		return $this->responseCode;
	}
	
}
?>