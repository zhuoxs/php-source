<?php
defined('IN_IA') or exit('Access Denied');
global $_GPC, $_W;
$uniacid =$_W['uniacid'];
$t_id = intval($_GPC['t_id']);
$Dmoney = pdo_fetch("SELECT * FROM ".tablename("hyb_yl_zhuanjteam")."WHERE t_id = '{$t_id}' and uniacid='{$uniacid}'");   
//生成二维码
if(empty($Dmoney['tderweima'])){
  $result = pdo_fetch('SELECT * FROM ' . tablename('hyb_yl_parameter') . " where `uniacid`='{$uniacid}' ", array(":uniacid" => $uniacid));
  $APPID = $result['appid'];
  $SECRET = $result['appsecret'];
  $tokenUrl="https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid={$APPID}&secret={$SECRET}";
  $getArr=array();
	  $tokenArr=json_decode(send_post($tokenUrl,$getArr,"GET"));
	  $access_token=$tokenArr->access_token;
	  $noncestr = 'hyb_yl/userCommunicate/pages/intro/intro?t_id='.$t_id;
	  $width=430;
	  $post_data='{"path":"'.$noncestr.'","width":'.$width.'}';
	  $url="https://api.weixin.qq.com/cgi-bin/wxaapp/createwxaqrcode?access_token=".$access_token;
	  $result=api_notice_increment($url,$post_data); 
	  $image_name = md5(uniqid(rand())).".jpg";
	  $filepath ="../attachment/{$image_name}";   
	  $file_put = file_put_contents($filepath, $result);
   if($file_put){
	   $siteroot = $_W['siteroot'];
	   $filepathsss= "{$siteroot}".'attachment/'."{$image_name}";
	   $phone = pdo_getcolumn('hyb_yl_zhuanjteam', array('t_id' => $t_id), 'tderweima');
	   $datas = array('tderweima' => $filepathsss);
	   $getupdate = pdo_update("hyb_yl_zhuanjteam", $datas,array('t_id' => $t_id,'uniacid' => $uniacid)); 
	   $overerwei = pdo_fetch("SELECT * FROM ".tablename("hyb_yl_zhuanjteam")."WHERE t_id = '{$t_id}' and uniacid='{$uniacid}'"); 
	   $overerwei['teampic'] =$_W['attachurl'].$overerwei['teampic'];
    }
 } else{
     $siteroot = $_W['siteroot'];
     $overerwei = pdo_fetch("SELECT * FROM ".tablename("hyb_yl_zhuanjteam")."WHERE t_id = '{$t_id}' and uniacid='{$uniacid}'"); 
     $overerwei['teampic'] =$_W['attachurl'].$overerwei['teampic'];
    } 
return $this->result(0, 'success', $overerwei);
function api_notice_increment($url, $data){
        $ch = curl_init();
       // $header = "Accept-Charset: utf-8";
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
        //curl_setopt($curl, CURLOPT_HTTPHEADER, $header);
        curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (compatible; MSIE 5.01; Windows NT 5.0)');
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_AUTOREFERER, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $tmpInfo = curl_exec($ch);
        if (curl_errno($ch)) {
          return false;
        }else{
      return $tmpInfo;
  }
}
 function send_post($url, $post_data,$method='POST') {
    $postdata = http_build_query($post_data);
    $options = array(
      'http' => array(
        'method' => $method, //or GET
        'header' => 'Content-type:application/x-www-form-urlencoded',
        'content' => $postdata,
        'timeout' => 15 * 60 // 超时时间（单位:s）
      )
    );
    $context = stream_context_create($options);
    $result = file_get_contents($url, false, $context);
    return $result;
  }