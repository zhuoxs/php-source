<?php

	include './SecurityUtil.php';
	include './SecretGetRequest.php';
	include './iCache.php';
	include '../../TopSdk.php';

	class SecurityClient
	{
		private $topClient ;
		private $randomNum ;
		private $securityUtil;
		private $cacheClient = null;

		function __construct($client, $random)
		{
			$this->topClient = $client;
			$this->randomNum = $random;
			$this->securityUtil = new SecurityUtil();
		}

		/**
		* 设置缓存处理器
		*/
		function setCacheClient($cache)
		{
			$this->cacheClient = $cache;
		}

		/**
		* 单条数据解密
		*/
		function decrypt($data,$type,$session)
		{
			$secretContext = $this->callSecretApiWithCache($session,null);
			return $this->securityUtil->decrypt($data,$type,$secretContext);
		}

		/**
		* 多条数据解密，必须是同一个type和用户,返回结果是 KV结果
		*/
		function decryptBatch($array,$type,$session)
		{
			$secretContext = $this->callSecretApiWithCache($session,null);
			$result = array();
			foreach ($array as $value) {
				$result[$value] = $this->securityUtil->decrypt($value,$type,$secretContext);
			}
			return $result;
		}

		/**
		* 使用上一版本秘钥解密，一般只用于更新秘钥
		*/
		function decryptPrevious($data,$type,$session)
		{
			$secretContext = $this->callSecretApiWithCache($session,-1);
			return $this->securityUtil->decrypt($data,$type,$secretContext);
		}		

		/**
		* 加密单条数据
		*/
		function encrypt($data,$type,$session)
		{
			$secretContext = $this->callSecretApiWithCache($session,null);
			return $this->securityUtil->encrypt($data,$type,$secretContext);
		}

		/**
		* 加密多条数据，必须是同一个type和用户,返回结果是 KV结果
		*/
		function encryptBatch($array,$type,$session)
		{
			$secretContext = $this->callSecretApiWithCache($session,null);
			$result = array();
			foreach ($array as $value) {
				$result[$value] = $this->securityUtil->encrypt($value,$type,$secretContext);
			}
			return $result;
		}

		/**
		* 使用上一版本秘钥加密，一般只用于更新秘钥
		*/
		function encryptPrevious($data,$type,$session)
		{
			$secretContext = $this->callSecretApiWithCache($session,-1);
			return $this->securityUtil->encrypt($data,$type,$secretContext);
		}

		/**
		* 根据session生成秘钥
		*/
		function initSecret($session)
		{
			return $this->callSecretApiWithCache($session,null);
		}

		function buildCacheKey($session,$secretVersion)
		{
			if($secretVersion == null){
				return $session;
			}
			return $session.'_'.$secretVersion;
		}

		/**
		* 判断是否是已加密的数据
		*/
		function isEncryptData($data,$type)
		{
			return $this->securityUtil->isEncryptData($data,$type);
		}

		/**
		* 判断是否是已加密的数据，数据必须是同一个类型
		*/
		function isEncryptDataArray($array,$type)
		{
			return $this->securityUtil->isEncryptDataArray($array,$type);
		}

		/**
		* 获取秘钥，使用缓存
		*/
		function callSecretApiWithCache($session,$secretVersion)
		{
			if($this->cacheClient)
			{
				$time = time();
				$cacheKey = $this->buildCacheKey($session,$secretVersion);
				$response = $this->cacheClient->getCache($cacheKey);
				if($response && $response->invalidTime > $time)
				{
					return $response;
				}
			}
			$response = $this->callSecretApi($session,$secretVersion);

			if($this->cacheClient)
			{
				$this->cacheClient->setCache($cacheKey,$response);
			}
			return $response;
		}

		/**
		* 获取秘钥，不使用缓存
		*/
		function callSecretApi($session,$secretVersion)
		{
			$request = new TopSecretGetRequest;
			$request->setRandomNum($this->randomNum);
			if($secretVersion)
			{
				$request->setSecretVersion($secretVersion);
			}
			
			if($session != null && $session[0] == '_')
			{
				$request->setCustomerUserId(substr(session,1));
			}

			$response = $this->topClient->execute($request,$session);
			if($response->code != 0){
				throw new Exception($response->msg);
			}

			$time = time();
			$secretContext = new SecretContext();
			$secretContext->maxInvalidTime = $time + intval($response->max_interval);
			$secretContext->invalidTime = $time + intval($response->interval);
			$secretContext->secret = strval($response->secret);
			$secretContext->secretVersion = intval($response->secret_version);

			return $secretContext;
		}
	}    
?>