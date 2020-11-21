<?php

	include './SecurityClient.php';
	include './YacCache.php';


	$c = new TopClient;
    $c->appkey = '576216';
    $c->secretKey = 'd1e44cec2f6c8a2c73342595b711decc';
    $c->gatewayUrl = 'https://10.218.128.111/router/rest';

    $session = '70000100430d0f167dca6ad5d157958a490932f41519bf0506287b61e000ee2b1d263af2050695162';

    $client = new SecurityClient($c,'S7/xdg4AD7WooWY7+g11qoBpaVsEkonULDJPEiMcXPE=');
    $cacheClient = new YacCache;
    $client->setCacheClient($cacheClient);

    $type = 'phone';
    $val = '13834566786';

    echo "原文：13834566786".PHP_EOL;
    $encryptValue = $client->encrypt($val,$type,$session);
    echo "加密后:".$encryptValue.PHP_EOL;

    if($client->isEncryptData($encryptValue,$type))
    {
    	$originalValue = $client->decrypt($encryptValue,$type,$session);
    	echo "解密后:".$originalValue.PHP_EOL;
    }

	$typeArray = array('normal','nick','receiver_name');

	$val2 = '啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊看哦【啊啊啊的';

	foreach ($typeArray as $type2) {
		echo "==============================TOP================================".PHP_EOL;
		$encty2 = $client->encrypt($val2,$type2,$session);
		echo $type2."|明文：".$val2." ---->密文：".$encty2.PHP_EOL;
		if($client->isEncryptData($encty2,$type2))
		{
			$originalValue = $client->decrypt($encty2,$type2,$session);
    		echo "解密后:".$originalValue.PHP_EOL;
		}else{
			echo "不是加密数据".PHP_EOL;
		}
	}
?>