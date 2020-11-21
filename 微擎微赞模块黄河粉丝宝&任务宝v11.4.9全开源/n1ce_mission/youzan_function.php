<?php
//
include 'lib/YZTokenClient.php';

function he_youzan_addtags($access_token,$openid,$tags){
	$client = new YZTokenClient($access_token);
	$method = 'youzan.users.weixin.follower.tags.add';//要调用的api名称
	$api_version = '3.0.0';//要调用的api版本号
	$params = array(
			'weixin_openid' => $openid,
			'tags' => $tags,
		 );
	$rets = $client->post($method, $api_version, $params);
	return $rets;
}
function he_youzan_shopget($access_token){
	$client = new YZTokenClient($access_token);
	$method = 'youzan.shop.get';//要调用的api名称
	$api_version = '3.0.0';//要调用的api版本号
	$params = array();
	$rets = $client->post($method, $api_version, $params);
	return $rets;
}