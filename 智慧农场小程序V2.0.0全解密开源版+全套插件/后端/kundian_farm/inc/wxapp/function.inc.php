<?php
defined('IN_IA') or exit('Access Denied');

/**
 * 向用户发送设备信息
 * @param $formId       //formid
 * @param $web_did      //设备号
 * @param $info         //提示信息
 * @param $touser       //用户openid
 * @param $page         //链接页面
 * @param $uniacid      //小程序唯一标识
 */
function sendDeviceInfoToUser($formId,$web_did,$info,$touser,$page,$uniacid){
    $wxData=pdo_get('cqkundian_farm_wx_set',array('uniacid'=>$uniacid));
    $setting = uni_setting($uniacid, array('payment'));
    $wechat = $setting['payment']['wechat'];
    $sql = 'SELECT `key`,`secret` FROM ' . tablename('account_wxapp') . ' WHERE `acid`=:acid';
    $row = pdo_fetch($sql, array(':acid' => $wechat['account']));

    $access_token = get_accessToken($row['key'],$row['secret'],$uniacid);
    $value = array(
        "keyword1"=>array(
            "value"=>$web_did,
            "color"=>"#4a4a4a"
        ),
        "keyword2"=>array(
            "value"=>$info,
            "color"=>"#9b9b9b"
        ),
        "keyword3"=>array(
            "value"=>date("Y-m-d H:i:s",time()),
            "color"=>"#9b9b9b"
        ),
    );
    $url = 'https://api.weixin.qq.com/cgi-bin/message/wxopen/template/send?access_token='.$access_token;
    $dd = array();
    $dd['touser']=$touser;
    $dd['template_id']=$wxData['mini_device_template_id'];
    $dd['page']=$page;
    $dd['form_id']=$formId;
    $dd['data']=$value;
    $dd['color']='';
    $dd['emphasis_keyword']='';    //模板需要放大的关键词，不填则默认无放大
    $result = https_curl_json($url,$dd,'json');
    return $result;
}

function sendServiceInfoToUser($uniacid,$title,$info,$touser,$page,$formId){
    $wxData=pdo_get('cqkundian_farm_wx_set',array('uniacid'=>$uniacid));
    $setting = uni_setting($uniacid, array('payment'));
    $wechat = $setting['payment']['wechat'];
    $sql = 'SELECT `key`,`secret` FROM ' . tablename('account_wxapp') . ' WHERE `acid`=:acid';
    $row = pdo_fetch($sql, array(':acid' => $wechat['account']));

    $access_token = get_accessToken($row['key'],$row['secret'],$uniacid);
    $value = array(
        "keyword1"=>array(
            "value"=>$title,
            "color"=>"#4a4a4a"
        ),
        "keyword2"=>array(
            "value"=>$info,
            "color"=>"#9b9b9b"
        ),
        "keyword3"=>array(
            "value"=>date("Y-m-d H:i:s",time()),
            "color"=>"#9b9b9b"
        ),
    );
    $url = 'https://api.weixin.qq.com/cgi-bin/message/wxopen/template/send?access_token='.$access_token;
    $dd = array();
    $dd['touser']=$touser;
    $dd['template_id']=$wxData['mini_services_template_id'];
    $dd['page']=$page;
    $dd['form_id']=$formId;
    $dd['data']=$value;
    $dd['color']='';
    $dd['emphasis_keyword']='';    //模板需要放大的关键词，不填则默认无放大
    $result = https_curl_json($url,$dd,'json');
    return $result;
}


/**
 * 获取小程序access_token
 * @param $appid        //小程序appid
 * @param $secret       //小程序密钥
 * @param $uniacid      //小程序唯一标识
 * @return array|bool|Memcache|mixed|Redis|string
 */
function get_accessToken($appid,$secret,$uniacid){
    if(cache_load('kundian_farm_access_token_time'.$uniacid) > time()){
        return cache_load('kundian_farm_access_token'.$uniacid);
    }else{
        $url = 'https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid='.$appid.'&secret='.$secret;
        $result = http_request($url);
        $res = json_decode($result,true);
        if($res){
            cache_write('kundian_farm_access_token_time'.$uniacid,time()+7000);
            cache_write('kundian_farm_access_token'.$uniacid,$res['access_token']);
            return $res['access_token'];
        }else{
            return 'api return error';
        }
    }
}

/* 发送json格式的数据，到api接口 -xzz0704  */
function https_curl_json($url,$data,$type){
    if($type=='json'){//json $_POST=json_decode(file_get_contents('php://input'), TRUE);
        $headers = array("Content-type: application/json;charset=UTF-8","Accept: application/json","Cache-Control: no-cache", "Pragma: no-cache");
        $data=json_encode($data);
    }
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_POST, 1); // 发送一个常规的Post请求
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE);
    if (!empty($data)){
        curl_setopt($curl, CURLOPT_POST, 1);
        curl_setopt($curl, CURLOPT_POSTFIELDS,$data);
    }
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($curl, CURLOPT_HTTPHEADER, $headers );
    $output = curl_exec($curl);
    if (curl_errno($curl)) {
        echo 'Errno'.curl_error($curl);//捕抓异常
    }
    curl_close($curl);
    return $output;
}
function http_request($url,$data=array()){
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
    // POST数据
    curl_setopt($ch, CURLOPT_POST, 1);
    // 把post的变量加上
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    $output = curl_exec($ch);
    curl_close($ch);
    return $output;
}


function createPoster($config=array(),$filename=""){
      //如果要看报什么错，可以先注释调这个header
      if(empty($filename)) header("content-type: image/png");
      $imageDefault = array(
          'left'=>0,
          'top'=>0,
          'right'=>0,
          'bottom'=>0,
          'width'=>100,
          'height'=>100,
          'opacity'=>100
      );
      $textDefault = array(
          'text'=>'',
          'left'=>0,
          'top'=>0,
          'fontSize'=>32,       //字号
          'fontColor'=>'99,99,99', //字体颜色
          'angle'=>0,
      );
      $background = $config['background'];//海报最底层得背景
      //背景方法
      $backgroundInfo = getimagesize($background);
      $backgroundFun = 'imagecreatefrom'.image_type_to_extension($backgroundInfo[2], false);
      $background = $backgroundFun($background);
      $backgroundWidth = imagesx($background);  //背景宽度
      $backgroundHeight = imagesy($background);  //背景高度
      $imageRes = imageCreatetruecolor($backgroundWidth,$backgroundHeight);
      $color = imagecolorallocate($imageRes, 0, 0, 0);
      imagefill($imageRes, 0, 0, $color);
      // imageColorTransparent($imageRes, $color);  //颜色透明
      imagecopyresampled($imageRes,$background,0,0,0,0,imagesx($background),imagesy($background),imagesx($background),imagesy($background));
      //处理了图片
      if(!empty($config['image'])){
          foreach ($config['image'] as $key => $val) {
              $val = array_merge($imageDefault,$val);
              $info = getimagesize($val['url']);
              $function = 'imagecreatefrom'.image_type_to_extension($info[2], false);
              if($val['stream']){   //如果传的是字符串图像流
                  $info = getimagesizefromstring($val['url']);
                  $function = 'imagecreatefromstring';
              }
              $res = $function($val['url']);
              $resWidth = $info[0];
              $resHeight = $info[1];
              //建立画板 ，缩放图片至指定尺寸
              $canvas=imagecreatetruecolor($val['width'], $val['height']);
              imagefill($canvas, 0, 0, $color);
              //关键函数，参数（目标资源，源，目标资源的开始坐标x,y, 源资源的开始坐标x,y,目标资源的宽高w,h,源资源的宽高w,h）
              imagecopyresampled($canvas, $res, 0, 0, 0, 0, $val['width'], $val['height'],$resWidth,$resHeight);
                  $val['left'] = $val['left']<0?$backgroundWidth- abs($val['left']) - $val['width']:$val['left'];
                  $val['top'] = $val['top']<0?$backgroundHeight- abs($val['top']) - $val['height']:$val['top'];
                  //放置图像
              imagecopymerge($imageRes,$canvas, $val['left'],$val['top'],$val['right'],$val['bottom'],$val['width'],$val['height'],$val['opacity']);//左，上，右，下，宽度，高度，透明度
          }
      }
  //处理文字
  if(!empty($config['text'])){
    foreach ($config['text'] as $key => $val) {
        $val = array_merge($textDefault,$val);
        list($R,$G,$B) = explode(',', $val['fontColor']);
        $fontColor = imagecolorallocate($imageRes, $R, $G, $B);
        $val['left'] = $val['left']<0?$backgroundWidth- abs($val['left']):$val['left'];
        $val['top'] = $val['top']<0?$backgroundHeight- abs($val['top']):$val['top'];
        $content=autowrap($val['fontSize'],0,$val['fontPath'],$val['text'],'335');
        imagettftext($imageRes,$val['fontSize'],$val['angle'],$val['left'],$val['top'],$fontColor,$val['fontPath'],$content);
    }
      $lineColor=imagecolorallocate($imageRes, '232','232','232');
      imageline($imageRes, 20, 480, 355, 480, $lineColor);
  }
  //生成图片
  if(!empty($filename)){
    $res = imagejpeg ($imageRes,$filename,90); //保存到本地
    imagedestroy($imageRes);
    if(!$res) return false;
    return $filename;
  }else{
    imagejpeg ($imageRes);     //在浏览器上显示
    imagedestroy($imageRes);
  }
}

/**
 * 文字自动换行
 * @param  [type] $fontsize [字体大小]
 * @param  [type] $angle    [角度]
 * @param  [type] $fontface [字体文件]
 * @param  [type] $string   [字符串]
 * @param  [type] $width    [宽度]
 * @return [type]           [返回值]
 */
function autowrap($fontsize, $angle, $fontface, $string, $width) {
    // 参数分别是 字体大小, 角度, 字体名称, 字符串, 预设宽度
    $content = "";
    // 将字符串拆分成一个个单字 保存到数组 letter 中
    preg_match_all("/./u", $string, $arr); 
    $letter = $arr[0];
    foreach($letter as $l) {
        $teststr = $content.$l;
        $testbox = imagettfbbox($fontsize, $angle, $fontface, $teststr);
        if (($testbox[2] > $width) && ($content !== "")) {
            $content .= PHP_EOL;
        }
        $content .= $l;
    }
    return $content;
}

/**
 * 对象转数组
 * @param $obj  对象
 * @return array|void
 */
function object_to_array($obj) {
    $obj = (array)$obj;
    foreach ($obj as $k => $v) {
        if (gettype($v) == 'resource') {
            return;
        }
        if (gettype($v) == 'object' || gettype($v) == 'array') {
            $obj[$k] = (array)object_to_array($v);
        }
    }
    return $obj;
}
