<?php

load()->func('tpl');
function _requestGetcurl($url){
    //curl完成  
    $curl = curl_init();  
    //设置curl选项  
    $header = array(  
        "authorization: Basic YS1sNjI5dmwtZ3Nocmt1eGI2Njp1TlQhQVFnISlWNlkySkBxWlQ=",
        "content-type: application/json",
        "cache-control: no-cache",
        "postman-token: cd81259b-e5f8-d64b-a408-1270184387ca" 
    );
    curl_setopt($curl, CURLOPT_HEADER, 1);
    curl_setopt($curl, CURLOPT_HTTPHEADER  , $header); 
    curl_setopt($curl, CURLOPT_URL, $url);//URL  
    curl_setopt($curl, CURLOPT_HEADER, 0);             // 0：不返回头信息
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);   
    curl_setopt($curl, CURLOPT_TIMEOUT, 30);//设置超时时间  
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false); 
    // 发出请求  
    $response = curl_exec($curl);
    if (false === $response) {  
        echo '<br>', curl_error($curl), '<br>';  
        return false;  
    }  
    curl_close($curl);  
    $forms = stripslashes(html_entity_decode($response));
    $forms = json_decode($forms,TRUE);
    return $forms;  
}
//不带报头的curl
function _requestPost($url, $data, $ssl=true) {
    //curl完成
    $curl = curl_init();
    //设置curl选项
    curl_setopt($curl, CURLOPT_URL, $url);//URL
    $user_agent = isset($_SERVER['HTTP_USER_AGENT']) ? $_SERVER['HTTP_USER_AGENT'] : 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:38.0) Gecko/20100101 Firefox/38.0 FirePHP/0.7.4';
    curl_setopt($curl, CURLOPT_USERAGENT, $user_agent);//user_agent，请求代理信息
    curl_setopt($curl, CURLOPT_AUTOREFERER, true);//referer头，请求来源
    curl_setopt($curl, CURLOPT_TIMEOUT, 30);//设置超时时间
    //SSL相关
    if ($ssl) {
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);//禁用后cURL将终止从服务端进行验证
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 2);//检查服务器SSL证书中是否存在一个公用名(common name)。
    }
    // 处理post相关选项
    curl_setopt($curl, CURLOPT_POST, true);// 是否为POST请求
    curl_setopt($curl, CURLOPT_POSTFIELDS, $data);// 处理请求数据
    // 处理响应结果
    curl_setopt($curl, CURLOPT_HEADER, false);//是否处理响应头
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);//curl_exec()是否返回响应结果
    // 发出请求
    $response = curl_exec($curl);
    if (false === $response) {
        echo '<br>', curl_error($curl), '<br>';
        return false;
    }
    curl_close($curl);
    return $response;
}

global $_GPC, $_W;  
$uniacid = $_W['uniacid'];
if (checksubmit('submit')) {
    $url = "https://openapi.baidu.com/oauth/2.0/token";
    $app = pdo_fetch("SELECT * FROM ".tablename('sudu8_page_bd_applet')." WHERE uniacid = :uniacid" , array(':uniacid' => $_W['uniacid']));
    $appkey = $app['appkey'];
    $appsecret = $app['appsecret'];
    $data = array(
        'grant_type' => 'client_credentials',
        'client_id' => $appkey,
        'client_secret' => $appsecret,
        'scope' => 'smartapp_snsapi_base'
        );
    $res = _requestPost($url,$data);
    $res = stripslashes(html_entity_decode($res));
    $res = json_decode($res,TRUE);
    if(isset($res['access_token'])){
    	$url1 = 'https://openapi.baidu.com/rest/2.0/smartapp/tp/createpreauthcode?access_token='.$res['access_token'];
    	$res1 = _requestGetcurl($url1);
    }else{
    	message($res['error_message'],'error');
    	exit;
    }
    // https://openapi.baidu.com/rest/2.0/smartapp/tp/createpreauthcode?access_token=42.89210dcaa616b575cdca56f978cefbc2.2592000.1535617875.Wf0l2sXgdy5SabS_wP00-34gJWz93WxN4e9rQhN

    var_dump($res);exit;
}

return include self::template('web/Bdapp/release');