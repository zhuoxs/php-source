<?php
header('Content-type:text/json');
// traceHttp();
$stime=microtime(true);
ini_set("display_errors", "off");
$wechatObj = new wechatCallbackapiTest();
if (isset($_GET['echostr'])) {   //判断是不是首次验证
    $wechatObj->valid();
}else{
    $wechatObj->responseMsg();
}
class wechatCallbackapiTest
{
    public function valid()
    {
        $echoStr = $_GET["echostr"];
        if($this->checkSignature()){
            echo $echoStr;
            exit;
        }
    }
    private function checkSignature()
    {
        $signature = $_GET["signature"];
        $timestamp = $_GET["timestamp"];
        $nonce = $_GET["nonce"];
        $token = 'kefu';
        $tmpArr = array($token, $timestamp, $nonce);
        sort($tmpArr);
        $tmpStr = implode( $tmpArr );
        $tmpStr = sha1( $tmpStr );

        if( $tmpStr == $signature ){
            return true;
        }else{
            return false;
        }
    }
    function http_post_data($url, $xml,$second = 30)
    {  

        $ch = curl_init();  

        //设置超时  

        curl_setopt($ch, CURLOPT_TIMEOUT, $second);  

        curl_setopt($ch, CURLOPT_URL, $url);  

        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);  

        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE); //严格校验  

        //设置header  

        curl_setopt($ch, CURLOPT_HEADER, FALSE);  

        //要求结果为字符串且输出到屏幕上  

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);  

        //post提交方式  

        curl_setopt($ch, CURLOPT_POST, TRUE);  

        curl_setopt($ch, CURLOPT_POSTFIELDS, $xml);  

        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 20);  

        curl_setopt($ch, CURLOPT_TIMEOUT, 40);  

        set_time_limit(0);  

        //运行curl  

        $data = curl_exec($ch);  

        //返回结果  

        if ($data) {  

            curl_close($ch);  

            return $data;  

        } else {  

            $error = curl_errno($ch);  

            curl_close($ch);  

            throw new WxPayException("curl出错，错误码:$error");  

        }  

    }  
    public function responseMsg() {
        

        $postStr = $GLOBALS["HTTP_RAW_POST_DATA"]; //获取数据


        $postObj = json_decode($postStr);
        $xcxId = $postObj->ToUserName; //小程序原始id

        $link=mysql_connect("{{URL}}","{{DBUSER}}","{{DBPWD}}");
        if(!$link) echo "没有连接成功!";
        mysql_select_db("{{DBNAME}}", $link); //选择数据库
        $sql = "SELECT * FROM {{TABLEPRE}}sudu8_page_p_s_base where xcxId ='".$xcxId."'"; //SQL查询语句
        mysql_query("SET NAMES utf8");
        $res = mysql_query($sql);
        $result_s = mysql_fetch_assoc($res);
        $flag_is = $result_s['flag']; //是否启用昵称 0不启用 1启用
        if($flag_is ==1){
            $datasheet = $result_s['datasheet'];  //用户表
            $openid_field = $result_s['openid_field']; //openid字段
            $id_field = $result_s['id_field']; //数据表键值
            $nickname_field = $result_s['nickname_field']; //nickname字段
        }
        $appID = $result_s['appId'];
        $appSecret = $result_s['appSecret'];
        $uniacid = $result_s['uniacid'];

        define("OPENID",$result_s['openid']); //客服openid
        $access_token_url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=".$appID."&secret=".$appSecret;
        $access_token_get = $this->http_post_data($access_token_url,'');
        $access_token = json_decode($access_token_get)->access_token;
        if (!empty($postStr)) {
            $fromUsername = $postObj->FromUserName; //openid
            $toUsername = $postObj->ToUserName;  //小程序原始id
            $MsgType = $postObj->MsgType;

            if($fromUsername == OPENID){
                if($MsgType == "text"){
                    $content = trim($postObj->Content);
                    $id = intval(substr($content,0,strpos($content, ':')));
                    if($id){
                        if($flag_is == 1){
                            $sql = "SELECT * FROM ".$datasheet." where ".$id_field."=".$id;
                            mysql_query("SET NAMES utf8");
                            $res = mysql_query($sql);
                            $user = mysql_fetch_assoc($res);
                        }else{
                            $sql = "SELECT * FROM {{TABLEPRE}}sudu8_page_p_s_user where id =".$id;
                            mysql_query("SET NAMES utf8");
                            $res = mysql_query($sql);
                            $user = mysql_fetch_assoc($res);
                        }
                        $openid = $user['openid'];
                        $content = substr($content,strpos($content, ':')+1);
                    }
                    if($content == "发送图片"){
                        $sql = "INSERT INTO {{TABLEPRE}}sudu8_page_p_s_pic (openid, uniacid,flag) VALUES ('".$openid."','".$uniacid."',1)";
                        mysql_query("SET NAMES utf8");
                        $res = mysql_query($sql);
                        $user = mysql_fetch_assoc($res);
                        exit;
                    }else if($content == "获取图片id"){
                        $sql = "INSERT INTO {{TABLEPRE}}sudu8_page_p_s_pic (openid, uniacid,flag) VALUES ('".OPENID."','".$uniacid."',3)";
                        mysql_query("SET NAMES utf8");
                        $res = mysql_query($sql);
                        $user = mysql_fetch_assoc($res);
                        exit;
                    }else{
                        $url  = "https://api.weixin.qq.com/cgi-bin/message/custom/send?access_token=".$access_token;
                        $data = '{"touser":"'.$openid.'","msgtype":"text","text":{"content":"'.$content.'"}}';
                        $this->http_post_data($url,$data);
                    }
                }else if($MsgType == "image"){
                    $sql = "SELECT * FROM {{TABLEPRE}}sudu8_page_p_s_pic where uniacid ='".$uniacid."' and flag = 1 ORDER BY id DESC";
                    mysql_query("SET NAMES utf8");
                    $res = mysql_query($sql);
                    $flag = mysql_fetch_assoc($res);
                    $url  = "https://api.weixin.qq.com/cgi-bin/message/custom/send?access_token=".$access_token;
                    if($flag){
                        $openid = $flag['openid'];
                        $data = '{"touser":"'.$openid.'","msgtype":"image","image":{"media_id":"'.trim($postObj->MediaId).'"}}';
                        $result = $this->http_post_data($url,$data);
                        if(json_decode($result)->errmsg == "ok"){
                            $sql = "UPDATE {{TABLEPRE}}sudu8_page_p_s_pic SET flag = 2 WHERE uniacid = '".$uniacid."' and flag = 1 ORDER BY id DESC";
                            mysql_query("SET NAMES utf8");
                            $res = mysql_query($sql);
                            $flag = mysql_fetch_assoc($res);
                        }
                    }else{
                        $sql = "SELECT * FROM {{TABLEPRE}}sudu8_page_p_s_pic where uniacid ='".$uniacid."' and flag = 3 ORDER BY id DESC";
                        mysql_query("SET NAMES utf8");
                        $res = mysql_query($sql);
                        $flags = mysql_fetch_array($res);
                        if($flags){
                        $data = '{"touser":"'.OPENID.'","msgtype":"text","text":{"content":"'.$postObj->MediaId.'"}}';
                        $result = $this->http_post_data($url,$data);
                        if(json_decode($result)->errmsg == "ok"){
                            $sql = "UPDATE {{TABLEPRE}}sudu8_page_p_s_pic SET flag = 2 WHERE uniacid = '".$uniacid."' and flag = 3 ORDER BY id DESC";
                            mysql_query("SET NAMES utf8");
                            $res = mysql_query($sql);
                            $flag = mysql_fetch_assoc($res);
                        }
                       } 
                    }
                }else{

                }  
            }else{
                if(isset($postObj->SessionFrom)){  //如果存在表示刚接入客服会话，自动回复
                    $url  = "https://api.weixin.qq.com/cgi-bin/message/custom/send?access_token=".$access_token;
                    if($flag_is == 0){
                        $sql_u = "SELECT * FROM {{TABLEPRE}}sudu8_page_p_s_user where openid ='".$fromUsername."'";
                        $res_u = mysql_query($sql_u);
                        $reply_u = mysql_fetch_assoc($res_u);
                        if(!$reply_u){
                            $sql_s = "INSERT INTO {{TABLEPRE}}sudu8_page_p_s_user (openid) VALUES ('".$fromUsername."')";
                            $res_s = mysql_query($sql_s);
                            $user_s = mysql_fetch_assoc($res_s);
                        }
                    }
                    $sql = "SELECT * FROM {{TABLEPRE}}sudu8_page_p_s_reply where uniacid ='".$uniacid."' and flag = 1";
                    mysql_query("SET NAMES utf8");
                    $res = mysql_query($sql);
                    $task = array();
                    while($reply = mysql_fetch_assoc($res)){
                                if($reply['type']==1){
                                    $content = $reply['content'];
                                    $data = '{"touser":"'.$fromUsername.'","msgtype":"text","text":{"content":"'.$content.'"}}';  
                                    array_push($task, $data);
                                    #$this->http_post_data($url,$data);
                                }
                                if($reply['type'] == 2){
                                    $media_id = $reply['content'];
                                    $data = '{"touser":"'.$fromUsername.'","msgtype":"image","image":{"media_id":"'.$media_id.'"}}';
                                    array_push($task, $data);
                                    #$this->http_post_data($url,$data);
                                } 
                                if($reply['type'] == 3){
                                    $content = unserialize($reply['content']);
                                    $title = $content['title'];
                                    $pagepath = $content['pagepath'];
                                    $thumb_media_id = $content['picurl'];
                                    $data = '{"touser":"'.$fromUsername.'","msgtype":"miniprogrampage","miniprogrampage":{"title":"'.$title.'","pagepath":"'.$pagepath.'","thumb_media_id":"'.$thumb_media_id.'"}}';
                                    array_push($task, $data);
                                    #$this->http_post_data($url,$data);
                                } 
                                if($reply['type'] == 4){
                                    $content = unserialize($reply['content']);
                                    $title = $content['title'];
                                    $description = $content['desc'];
                                    $urls = $content['url'];
                                    $thumb_url = $content['thumb_url'];
                                    $data = '{"touser":"'.$fromUsername.'","msgtype":"link","link":{"title":"'.$title.'","description":"'.$description.'","url":"'.$urls.'","thumb_url":"'.$thumb_url.'"}}';
                                    array_push($task, $data);
                                    #$result = $this->http_post_data($url,$data);
                                } 
                        }

                        //执行发送任务
                        // ksort($task);
                        $result = true;
                        $path = dirname(__DIR__).'/test.txt';
                        $myfile = fopen($path, "w");
                        while ($result) {
                            $data = array_pop($task);
                            if(empty($data)){
                                $result = false;
                            }else{
                                $result = $this->http_post_data($url,$data);
                                fwrite($myfile, (String)$result);
                            }
                        }

                        fclose($myfile);

                 
                }else if($MsgType == "text"){
                        $content = trim($postObj->Content);
                        if($content == "openid"){
                            $url  = "https://api.weixin.qq.com/cgi-bin/message/custom/send?access_token=".$access_token;
                            $data = '{"touser":"'.$fromUsername.'","msgtype":"text","text":{"content":"'.$fromUsername.'"}';
                            $result = $this->http_post_data($url,$data);
                        }else{
                            $url  = "https://api.weixin.qq.com/cgi-bin/message/custom/send?access_token=".$access_token;
                            if($flag_is == 1){
                                $sql = "SELECT * FROM ".$datasheet." where ".$openid_field."='".$fromUsername."'";
                                mysql_query("SET NAMES utf8");
                                $res = mysql_query($sql);
                                $user = mysql_fetch_assoc($res);
                                $id = $user['id'];
                                $nickname = $user['nickname'];
                                $data = '{"touser":"'.OPENID.'","msgtype":"text","text":{"content":"['.$id.']'.$nickname.'：'.$content.'"}}';
                            }else{
                                $sql_u = "SELECT * FROM {{TABLEPRE}}sudu8_page_p_s_user where openid ='".$fromUsername."'";
                                mysql_query("SET NAMES utf8");
                                $res_u = mysql_query($sql_u);
                                $reply_u = mysql_fetch_assoc($res_u);
                                $id = $reply_u['id'];
                                 $data = '{"touser":"'.OPENID.'","msgtype":"text","text":{"content":"['.$id.']：'.$content.'"}}';
                            }
                            $this->http_post_data($url,$data);  
                        }
                }else if($MsgType == "image"){
                    $url  = "https://api.weixin.qq.com/cgi-bin/message/custom/send?access_token=".$access_token;
                    if($flag_is == 1){
                        $sql = "SELECT * FROM ".$datasheet." where ".$openid_field."='".$fromUsername."'";
                        mysql_query("SET NAMES utf8");
                        $res = mysql_query($sql);
                        $user = mysql_fetch_assoc($res);
                        $id = $user['id'];
                        $nickname = $user['nickname'];
                        $data1 = '{"touser":"'.OPENID.'","msgtype":"text","text":{"content":"['.$id.']'.$nickname.'：用户图片如下"}}';
                    }else{
                        $sql_u = "SELECT * FROM {{TABLEPRE}}sudu8_page_p_s_user where openid ='".$fromUsername."'";
                        mysql_query("SET NAMES utf8");
                        $res_u = mysql_query($sql_u);
                        $reply_u = mysql_fetch_assoc($res_u);
                        $id = $reply_u['id']; 
                        $data1 = '{"touser":"'.OPENID.'","msgtype":"text","text":{"content":"['.$id.']：用户图片如下"}}';
                    }
                    $data2 = '{"touser":"'.OPENID.'","msgtype":"image","image":{"media_id":"'.trim($postObj->MediaId).'"}}';
                    $this->http_post_data($url,$data1);
                    $this->http_post_data($url,$data2);
                }else{

                }  
            }
        }
    }
}