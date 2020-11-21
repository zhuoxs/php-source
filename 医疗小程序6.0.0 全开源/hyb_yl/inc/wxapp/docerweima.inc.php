<?php
defined('IN_IA') or exit('Access Denied');
global $_GPC, $_W;
$uniacid =$_W['uniacid'];
$zid = intval($_GPC['zid']);
$Dmoney = pdo_fetch("SELECT * FROM ".tablename("hyb_yl_zhuanjia")."WHERE zid = '{$zid}' and uniacid='{$uniacid}'");   
//生成二维码
if(empty($Dmoney['weweima'])){
  $result = pdo_fetch('SELECT * FROM ' . tablename('hyb_yl_parameter') . " where `uniacid`='{$uniacid}' ", array(":uniacid" => $uniacid));
  $APPID = $result['appid'];
  $SECRET = $result['appsecret'];
  $tokenUrl="https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid={$APPID}&secret={$SECRET}";
    $getArr=array();
	  $tokenArr=json_decode(send_post($tokenUrl,$getArr,"GET"));
	  $access_token=$tokenArr->access_token;
    $data = array();
    $data['scene'] = "id=" . $zid;
    $data['page'] = "hyb_yl/zhuanjiasubpages/pages/zhuanjiazhuye/zhuanjiazhuye";
    $data = json_encode($data);
	  $url="https://api.weixin.qq.com/wxa/getwxacodeunlimit?access_token=".$access_token;
	  $result=api_notice_increment($url,$data); 
	  $image_name = md5(uniqid(rand())).".jpg";
	  $filepath ="../attachment/{$image_name}";   
	  $file_put = file_put_contents($filepath, $result);
   if($file_put){
	   $siteroot = $_W['siteroot'];
	   $filepathsss= "{$siteroot}".'attachment/'."{$image_name}";
	   $phone = pdo_getcolumn('hyb_yl_zhuanjia', array('zid' => $zid), 'weweima');
	   $datas = array('weweima' => $filepathsss);
	   $getupdate = pdo_update("hyb_yl_zhuanjia", $datas,array('zid' => $zid,'uniacid' => $uniacid)); 
	   $overerwei = pdo_fetch("SELECT * FROM ".tablename("hyb_yl_zhuanjia")."WHERE zid = '{$zid}' and uniacid='{$uniacid}'"); 
	   $overerwei['z_thumbs'] =$_W['attachurl'].$overerwei['z_thumbs'];
    }
 } else{
     $siteroot = $_W['siteroot'];
     $overerwei = pdo_fetch("SELECT * FROM ".tablename("hyb_yl_zhuanjia")."WHERE zid = '{$zid}' and uniacid='{$uniacid}'"); 
     $overerwei['z_thumbs'] =$_W['attachurl'].$overerwei['z_thumbs'];
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