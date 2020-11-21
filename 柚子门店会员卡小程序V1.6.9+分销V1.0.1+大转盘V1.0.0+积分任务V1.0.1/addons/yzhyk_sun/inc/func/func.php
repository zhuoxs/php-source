<?php
/**
 * Created by PhpStorm.
 * User: lts
 * Date: 2018/8/2
 * Time: 9:35
 */


/*
 * 获取微信 token
 * $opt[
 *      'appid'=>'',
 *      'appsecret'=>'',
 * ]
 * */
function getAccessToken($appid, $appsecret)
{
    $url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=" . $appid . "&secret=" . $appsecret . "";
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
    $data = curl_exec($ch);
    curl_close($ch);
    $data = json_decode($data, true);
    return $data['access_token'];
}

//发送模板消息
function sendTemplate($appid, $appsecret, $openid, $template_id, $page, $form_id, $opt){
    $formwork = array(
        'touser'=>$openid,
        'template_id'=>$template_id,
        'page'=>$page,
        'form_id'=>$form_id,
    );
    $data = array();
    foreach ($opt as $key => $value) {
        $data['keyword'.($key+1)] = array(
            'value'=>$value,
            'color'=>'#173177',
        ) ;
    }
    $formwork['data'] = $data;

    $access_token = getAccessToken($appid,$appsecret);

    $url = "https://api.weixin.qq.com/cgi-bin/message/wxopen/template/send?access_token=" . $access_token . "";
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($formwork));
    $data = curl_exec($ch);
    curl_close($ch);
    return $data;
}

//发送钉钉消息
function sendDingTalk($token,$content){
    $url = 'https://oapi.dingtalk.com/robot/send?access_token='.$token;
    if (!function_exists('request_by_curl')){
        function request_by_curl($remote_server, $post_string) {
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $remote_server);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array ('Content-Type: application/json;charset=utf-8'));
            curl_setopt($ch, CURLOPT_POSTFIELDS, $post_string);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            // 线下环境不用开启curl证书验证, 未调通情况可尝试添加该代码
            curl_setopt ($ch, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt ($ch, CURLOPT_SSL_VERIFYPEER, 0);
            $data = curl_exec($ch);
            curl_close($ch);
            return $data;
        }
    }

    $data = [];

    if (is_string($content)){
        $data['msgtype'] = 'text';
        $data['text'] = ['content'=>$content];
    }else if (isset($content['title'])){
        $data['msgtype'] = 'markdown';
        $data['markdown'] = [
            'title' => $content['title'],
            'text' => $content['text'],
        ];
    }

    $data['at']=[
        'atMobiles'=>[],
        'isAtAll'=>false,
    ];
    return request_by_curl($url,json_encode($data));
}

class ZhyException extends Exception{
    public $data = null;
    function __construct($message = "", $code = 1, $data = null)
    {
        $this->data = $data;
        parent::__construct($message, $code, null);
    }

    function __toString()
    {
        echo json_encode(array(
            'code'=>$this->getCode(),
            'msg'=>$this->getMessage(),
        ));
        exit;
    }
}

//任务相关=======================================
//启动自动任务
function startTask(){
    global $_W;
    $config_model = new config();
    $config_list = $config_model->query2(["`key`='autotask'"])['data'];
    if (!count($config_list)){
        $config_data = [];
        $config_data['key']='autotask';
        $config_data['value']=time();
        $config_model->insert($config_data);
    }else{
        $config_data = $config_list[0];
        //    30 秒之内执行过任务，退出 todo 如果一次执行的时间超过该设定值，有可能再次开启一个线程。这边以后要控制下
        if (time() - $config_data['value'] < 30){
            return;
        }

        //    标识任务启动时间
        $config_model->update_by_id(['value'=>time()],$config_data['id']);
    }
    runTask(1);
}
//启动任务
function runTask($newthread = 0){
    global $_W;
    $url = $_W['sitescheme'].$_SERVER['SERVER_NAME']."/app/index.php?i=".$_W['uniacid']."&t=0&v=1.0&from=wxapp&c=entry&a=wxapp&do=runTask&m=yzhyk_sun&newthread={$newthread}";
    sockAsynchronous($url);
}
//发起异步请求
function sockAsynchronous($url){
    $info = parse_url($url);
    $scheme = $info["scheme"];
    $host = $info["host"];
    $path = $info['path'];
    $poststring = $info['query'];

    if ($scheme == 'https'){
        $port = 443;
        $fp = ihttp_socketopen("ssl://" .$host, $port, $errno, $errstr, $timeout = 30);
    }else{
        $port = 80;
        $fp = ihttp_socketopen($host, $port, $errno, $errstr, $timeout = 30);
    }

    // if (in_array($host,['localhost','127.0.0.1'])){
    //     $port = 80;
    //     $fp = fsockopen($host, $port, $errno, $errstr, $timeout = 30);
    // }else{
    //     $port = 443;
    //     $fp = fsockopen("ssl://" .$host, $port, $errno, $errstr, $timeout = 30);
    // }
    if ($fp) {
        $head = "POST $path HTTP/1.1\r\n";
        $head .= "Host: $host\r\n";
        $head .= "Content-type: application/x-www-form-urlencoded\r\n";
        $head .= "Content-length: " . strlen($poststring) . "\r\n";
        $head .= "Connection: close\r\n\r\n";
        $head .= $poststring . "\r\n\r\n";
        fputs($fp, $head);
//        while(!feof($fp)){
//            echo fgets($fp,512);
//        }
        usleep(300000); //等待300ms
        fclose($fp);
    }
}
















