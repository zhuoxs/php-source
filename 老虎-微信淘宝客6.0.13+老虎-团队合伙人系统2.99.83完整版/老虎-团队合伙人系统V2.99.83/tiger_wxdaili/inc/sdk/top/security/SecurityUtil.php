<?php

	include './SecretContext.php';
	include './MagicCrypt.php';

	class SecurityUtil
	{

		private $BASE64_ARRAY = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/=';
		private $SEPARATOR_CHAR_MAP;

		function __construct()
		{
			if(!defined("PHONE_SEPARATOR_CHAR"))
			{
				define('PHONE_SEPARATOR_CHAR','$');
			}
			if(!defined("NICK_SEPARATOR_CHAR"))
			{
				define('NICK_SEPARATOR_CHAR','~');
			}
			if(!defined("NORMAL_SEPARATOR_CHAR"))
			{
				define('NORMAL_SEPARATOR_CHAR',chr(1));
			}

			$this->SEPARATOR_CHAR_MAP['nick'] = NICK_SEPARATOR_CHAR;
			$this->SEPARATOR_CHAR_MAP['simple'] = NICK_SEPARATOR_CHAR;
			$this->SEPARATOR_CHAR_MAP['receiver_name'] = NICK_SEPARATOR_CHAR;
			$this->SEPARATOR_CHAR_MAP['normal'] = NORMAL_SEPARATOR_CHAR;
			$this->SEPARATOR_CHAR_MAP['phone'] = PHONE_SEPARATOR_CHAR;

		}

		/*
		* 判断是否是base64格式的数据
		*/
		function isBase64Str($str)
		{
			$strLen = strlen($str);
			for($i = 0; $i < $strLen ; $i++)
			{
				if(!$this->isBase64Char($str[$i]))
				{
					return false;
				}
			}
			return true;
		}

		/*
		* 判断是否是base64格式的字符
		*/
		function isBase64Char($char)
		{
			return strpos($this->BASE64_ARRAY,$char) !== false;
		}

		/*
		* 使用sep字符进行trim
		*/
		function trimBySep($str,$sep)
		{
			$start = 0;
			$end = strlen($str);
			for($i = 0; $i < $end; $i++)
			{
				if($str[$i] == $sep)
				{
					$start = $i + 1;
				}
				else
				{
					break;
				}
			}
			for($i = $end -1 ; $i >= 0; $i--)
			{
				if($str[$i] == $sep)
				{
					$end = $i - 1;
				}
				else
				{
					break;
				}
			}
			return substr($str,$start,$end);
		}

		function checkEncryptData($dataArray)
		{
			return  $this->isBase64Str($dataArray[0]) && $this->isBase64Str($dataArray[1]);
		}

		/*
		* 判断是否是加密数据
		*/
		function isEncryptDataArray($array,$type)
		{
			foreach ($array as $value) {
				if(!$this->isEncryptData($value,$type)){
					return false;
				}
			}
			return true;
		}

		/*
		* 判断是否是加密数据
		*/
		function isEncryptData($data,$type)
		{
			if(!is_string($data) || strlen($data) < 4)
			{
				return false;
			}

			$separator = $this->SEPARATOR_CHAR_MAP[$type];
			$strlen = strlen($data);
			if($data[0] != $separator || $data[$strlen -1] != $separator)
			{
				return false;
			}

			$dataArray = explode($separator,$this->trimBySep($data,$separator));
			$arrayLength = count($dataArray);

			if($separator == PHONE_SEPARATOR_CHAR)
			{
				if($arrayLength != 3)
				{
					return false;
				}
				if($data[$strlen - 2] == $separator)
				{
					return $this->checkEncryptData($dataArray);
				} 
				else
				{
					$version = $dataArray[$arrayLength -1];
					if(is_numeric($version) && intval($version) > 0)
					{
						$base64Val = $dataArray[$arrayLength -2];
						return $this->isBase64Str($base64Val);
					}
				}
			}else{
				if($data[strlen($data) - 2] == $separator && $arrayLength == 3)
				{
					return $this->checkEncryptData($dataArray);
				}
				else if($arrayLength == 2)
				{
					return $this->checkEncryptData($dataArray);
				}
				else
				{
					return false;
				}
			}
		}

		/*
		* 加密逻辑
		*/
		function encrypt($data,$type,$secretContext)
		{
			if(!is_string($data))
			{
				return false;
			}

			$separator = $this->SEPARATOR_CHAR_MAP[$type];

			if('phone' == $type)
			{
				return $this->encryptPhone($data,$separator,$secretContext);
			}
			else
			{
				return $this->encryptNormal($data,$separator,$secretContext);
			}
		}

		/*
		* 加密逻辑,手机号码格式
		*/
		function encryptPhone($data,$separator,$secretContext)
		{
			$len = strlen($data);
			if($len < 11)
			{
				return $data;
			}
			$prefixNumber = substr($data,0,$len -8);
			$last8Number =  substr($data,$len -8,$len);

			return $separator.$prefixNumber.$separator.Security::encrypt($last8Number,$secretContext->secret)
				  .$separator.$secretContext->secretVersion.$separator ;
		}

		/*
		* 加密逻辑,非手机号码格式
		*/
		function encryptNormal($data,$separator,$secretContext)
		{
			return $separator.Security::encrypt($data,$secretContext->secret).$separator.$secretContext->secretVersion.$separator;
		}

		/*
		* 解密逻辑
		*/
		function decrypt($data,$type,$secretContext)
		{			
			if(!$this->isEncryptData($data,$type))
			{
				return $data;
			}

			$separator = $this->SEPARATOR_CHAR_MAP[$type];
			$secretData = $this->getSecretData($data,$separator);
			$result = Security::decrypt($secretData->originalBase64Value,$secretContext->secret);

			if($separator == PHONE_SEPARATOR_CHAR)
			{
				return $secretData->originalValue.$result;
			}
			return $result;
		}

		/*
		* 分解密文
		*/
		function getSecretData($data,$separator)
		{
			$secretData = new SecretData;
			$dataArray = explode($separator,$this->trimBySep($data,$separator));
			$arrayLength = count($dataArray);

			if($separator == PHONE_SEPARATOR_CHAR)
			{
				if($arrayLength != 3){
					return null;
				}else{
					$version = $dataArray[2];
					if(is_numeric($version) && intval($version) > 0)
					{
						$secretData->originalValue = $dataArray[0];
						$secretData->originalBase64Value = $dataArray[1];
						$secretData->secretVersion = $version;
					}
				}
			}
			else
			{
				if($arrayLength != 2){
					return null;
				}else{
					$version = $dataArray[1];
					if(is_numeric($version) && intval($version) > 0)
					{
						$secretData->originalBase64Value = $dataArray[0];
						$secretData->secretVersion = $version;
					}
				}
			}
			return $secretData;
		}
	}	
?>