<?php
defined('IN_IA') or exit('Access Denied');
/**
 * 给用户发送支付成功推送信息
 * @param $orderData    //订单信息
 * @param $prepay_id    //支付成功formid
 * @param $touser       //用户openid
 * @param $uniacid      //小程序唯一标志
 * @param $page         //链接地址
 */
function send_msg_to_user($orderData,$prepay_id,$touser,$uniacid,$page){
    $wxData=pdo_get('cqkundian_farm_wx_set',array('uniacid'=>$uniacid));

    $account_api = WeAccount::create();
    $access_token=$account_api->getAccessToken();
    $value = array(
        "keyword1"=>array(
            "value"=>$orderData['body'],
            "color"=>"#4a4a4a"
        ),
        "keyword2"=>array(
            "value"=>date("Y-m-d H:i:s",$orderData['create_time']),
            "color"=>"#9b9b9b"
        ),
        "keyword3"=>array(
            "value"=>$orderData['total_price'],
            "color"=>"#9b9b9b"
        ),
    );
    $url = 'https://api.weixin.qq.com/cgi-bin/message/wxopen/template/send?access_token='.$access_token;
    $dd = array();
    $dd['touser']=$touser;
    $dd['template_id']=$wxData['wx_small_template_id'];
    $dd['page']=$page;
    $dd['form_id']=$prepay_id;
    $dd['data']=$value;
    $dd['color']='';
    $dd['emphasis_keyword']='';    //模板需要放大的关键词，不填则默认无放大
    $result = https_curl_json($url,$dd,'json');
    return $result;
}

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

function sendMerchantInfo($touser,$orderData,$uniacid,$type,$order_type){
    global $_W;
    $setting = uni_setting($_W['uniacid'], array('payment'));
    $wechat = $setting['payment']['wechat'];
    $sql = 'SELECT `key`,`secret` FROM ' . tablename('account_wxapp') . ' WHERE `acid`=:acid';
    $row = pdo_fetch($sql, array(':acid' => $wechat['account']));
    $wxData=pdo_get('cqkundian_farm_wx_set',array('uniacid'=>$uniacid));
    $access_token = get_Wx_accessToken($wxData['wx_appid'],$wxData['wx_secret'],$uniacid);
    if($order_type==1){
        $data=array(
            'first'=>array('value'=>'您有新的订单',"color"=>"#436EEE"),
            'keyword1'=>array("value"=>$type),
            'keyword2'=>array("value"=>date("Y-m-d H:i:s",$orderData['create_time'])),
            'remark'=>array('value'=>'请尽快处理!点击进入查看详情','color'=>'#436EEE'),
        );
    }elseif ($order_type==2){
        $data=array(
            'first'=>array('value'=>'订单取消通知',"color"=>"#436EEE"),
            'keyword1'=>array("value"=>$type),
            'keyword2'=>array("value"=>date("Y-m-d H:i:s",time())),
            'remark'=>array('value'=>'请尽快处理!点击进入查看详情','color'=>'#436EEE'),
        );
    }

    $template = array(
        'touser' => $touser,
        'template_id' => $wxData['wx_shop_template_id'],
        'data' => $data,
        "miniprogram"=>array(
            "appid"=>$row['key'],
            "pagepath"=>"kundian_farm/pages/user/userCenter/index"
        )
    );
    $json_template = json_encode($template);
    $url = "https://api.weixin.qq.com/cgi-bin/message/template/send?access_token=" . $access_token;
    $dataRes = http_request($url, urldecode($json_template));
    if ($dataRes->errcode == 0) {
        return true;
    } else {
        return false;
    }
}

/**
 * 订单取消通知
 * @param $touser       //通知用户
 * @param $orderData    //订单编号
 * @param $uniacid      //小程序唯一标识
 * @return bool         //返回值
 */
function cancelOrderSendTemplate($touser,$orderData,$uniacid){
    global $_W;
    $setting = uni_setting($_W['uniacid'], array('payment'));
    $wechat = $setting['payment']['wechat'];
    $sql = 'SELECT `key`,`secret` FROM ' . tablename('account_wxapp') . ' WHERE `acid`=:acid';
    $row = pdo_fetch($sql, array(':acid' => $wechat['account']));
    

    $wxData=pdo_get('cqkundian_farm_wx_set',array('uniacid'=>$uniacid));
    $access_token = get_Wx_accessToken($wxData['wx_appid'],$wxData['wx_secret'],$uniacid);
    $data=array(
        'first'=>array('value'=>'订单取消通知'),
        'keyword1'=>array("value"=>$orderData['order_number']),
        'keyword2'=>array("value"=>$orderData['total_price']),
        'keyword3'=>array("value"=>date("Y-m-d H:i:s",time())),
    );
    $template = array(
        'touser' => $touser,
        'template_id' => $wxData['wx_cancel_template_id'],
        'data' => $data,
        "miniprogram"=>array(
            "appid"=>$row['key'],
            "pagepath"=>"kundian_farm/pages/user/userCenter/index"
        )
    );
    $json_template = json_encode($template);
    $url = "https://api.weixin.qq.com/cgi-bin/message/template/send?access_token=" . $access_token;
    $dataRes = http_request($url, urldecode($json_template));
    if ($dataRes->errcode == 0) {
        return true;
    } else {
        return false;
    }
}


/**
 * 获取微信公众号access_token
 * @param $appid        //微信公众号appid
 * @param $secret       //微信公众号密钥
 * @param $uniacid      //小程序唯一标志
 * @return array|bool|Memcache|mixed|Redis|string
 */
function get_Wx_accessToken($appid,$secret,$uniacid){
    if(cache_load('kundian_farm_access_token_wx_time'.$uniacid)>time()){
        return cache_load('kundian_farm_access_token_wx'.$uniacid);
    }else{
        $url = 'https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid='.$appid.'&secret='.$secret;
        $result = http_request($url);
        $res = json_decode($result,true);
        if($res){
            cache_write('kundian_farm_access_token_wx_time'.$uniacid,time()+7000);
            cache_write('kundian_farm_access_token_wx'.$uniacid,$res['access_token']);
            return $res['access_token'];
        }else{
            return 'api return error';
        }
    }
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
 * 计算商品运费
 * @param  [array] $goodsData  商品信息
 * @param  [float] $totalPrice 总价
 * @param  [int] $count        数量
 * @param  [int] $uniacid      小程序唯一标识
 * @return [type]              返回值
 */
function calculationShipping($goodsData,$totalPrice,$count,$uniacid){
    $send_price =0;
    $freight=pdo_get('cqkundian_farm_freight_rule',array('uniacid'=>$uniacid,'id'=>$goodsData['freight']));
    if(!empty($freight)){
        if($goodsData['piece_free_shipping'] || $goodsData['quota_free_shipping']){
            if($goodsData['piece_free_shipping']){
                if($count<$goodsData['piece_free_shipping']){   //如果当前购买数量小于单品满件包邮
                    if($goodsData['quota_free_shipping']){
                        if($goodsData['quota_free_shipping']>$totalPrice){
                             $send_price=getSendPirce($goodsData,$totalPrice,$count,$send_price,$freight);
                        }
                    }else{
                         $send_price=getSendPirce($goodsData,$totalPrice,$count,$send_price,$freight);
                    }
                }
            }else{
                if($goodsData['quota_free_shipping']){
                    if($goodsData['quota_free_shipping']>$totalPrice){
                         $send_price=getSendPirce($goodsData,$totalPrice,$count,$send_price,$freight);
                    }
                }else{
                     $send_price=getSendPirce($goodsData,$totalPrice,$count,$send_price,$freight);
                }
            }
        }else{
            $send_price=getSendPirce($goodsData,$totalPrice,$count,$send_price,$freight);
        }
    }
    return $send_price;
}

function getSendPirce($goodsData,$totalPrice,$count,$send_price,$freight){
    if($freight['charge_type']==1){     //按重量计算
        if($goodsData['weight']>$freight['first_piece']){
            $send_price+=$freight['first_price'];
            $send_price+=ceil((($goodsData['weight']*$count-$freight['first_piece'])/$freight['second_piece']))*$freight['second_price'];
        }else{
            $send_price=$freight['first_price'];
        }
    }else{
        if($count>$freight['first_piece']){
            $send_price+=$freight['first_price'];
            $send_price+=ceil((($count-$freight['first_piece'])/$freight['second_piece']))*$freight['second_price'];
        }else{
            $send_price=$freight['first_price'];
        }
    }
    return $send_price;
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

function getGoodsQrcode($goods_id,$uniacid,$uid=''){
    $account_api = WeAccount::create();
    $access_token=$account_api->getAccessToken();
    if($uid&&$goods_id){
        $params = array(
            'path' => "kundian_farm/pages/shop/prodeteils/index?goodsid=".$goods_id."&user_uid=".$uid
        );
    }elseif($goods_id) {
        $params = array(
            'path' => "kundian_farm/pages/shop/prodeteils/index?goodsid=" . $goods_id
        );
    }elseif ($uid){
        $params = array(
            'path' => "kundian_farm/pages/HomePage/index/index?&user_uid=" . $uid
        );
    }
    ob_start();
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "https://api.weixin.qq.com/wxa/getwxacode?access_token={$access_token}");
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, false);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($params));
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE); // https请求 不验证证书和hosts
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);

    $response = curl_exec($ch);
    $filename = md5(uniqid()).'.png';
    $tmp_file =IA_ROOT."/addons/kundian_farm/resource/img/temp/{$filename}";
    $result = file_put_contents($tmp_file, ob_get_contents());
    $check_result = json_decode(ob_get_contents(), true);
    curl_close($ch);
    ob_end_clean();
    if ($check_result['errcode']) {
        return false;
    }
    $filepath="kundian_farm/resource/img/temp/";
    $file['savepath'] =$filepath;
    $file['savename'] = $filename;
    $file['tmp_name'] = $tmp_file;
    $file['type'] = 'image/png';
    $file['size'] = filesize($tmp_file);
    $img_url = upload_local_file($filepath.$filename);
    if($img_url) {
        @unlink($tmp_file);
        if ($img_url) {
            return $img_url;
        } else {
            return false;
        }
    }else{
        global $_W;
        $local_img=$_W['siteroot']."/addons/kundian_farm/resource/img/temp/{$filename}";
        return $local_img;
    }
}

function upload_local_file($filename,$auto_delete_local='true'){
    global $_W;
    error_reporting(0);
    load()->library('qiniu');
    $auth = new Qiniu\Auth($_W['setting']['remote']['qiniu']['accesskey'], $_W['setting']['remote']['qiniu']['secretkey']);
    $config = new Qiniu\Config();
    $uploadmgr = new Qiniu\Storage\UploadManager($config);
    $putpolicy = Qiniu\base64_urlSafeEncode(json_encode(array(
        'scope' => $_W['setting']['remote']['qiniu']['bucket'] . ':' . $filename,
    )));
    $uploadtoken = $auth->uploadToken($_W['setting']['remote']['qiniu']['bucket'], $filename, 3600, $putpolicy);
    list($ret, $err) = $uploadmgr->putFile($uploadtoken, $filename, IA_ROOT . '/addons/' .$filename);
    if ($auto_delete_local) {
//        file_delete(IA_ROOT . '/addons/' .$filename);
    }
    $url=tomedia($filename);
    if ($err !== null) {
//        return error(1, '远程附件上传失败，请检查配置并重新上传');
        return false;
    } else {
        return $url;
    }
}


/**
 * 整理普通商城订单信息
 * @param $list
 * @param $uniacid
 * @param $order_type 1普通商城 2组团商城
 */
function neatenOrderData($list,$uniacid,$order_type){
    if($order_type==1){
        for ($i=0;$i<count($list);$i++){
            $order_detail=pdo_getall('cqkundian_farm_shop_order_detail',array('order_id'=>$list[$i]['id'],'uniacid'=>$uniacid));
            $list[$i]['orderDetail']=$order_detail;
            $user=pdo_get('cqkundian_farm_user',array('uniacid'=>$uniacid,'uid'=>$list[$i]['uid']),array('nickname'));
            $list[$i]['nickname']=$user['nickname'];

            //兼容老版本订单信息
            if($list[$i]['status']>1){
                $update_order_status=array();
                if($list[$i]['status']==2){
                    $update_order_status['is_send']=1;
                    $update_order_status['status']=1;
                }elseif ($list[$i]['status']==3){
                    $update_order_status['is_send']=1;
                    $update_order_status['status']=1;
                    $update_order_status['is_confirm']=1;
                }elseif ($list[$i]['status']==4){
                    $update_order_status['apply_delete']=1;
                    $update_order_status['status']=1;
                }elseif ($list[$i]['status']==5){

                    $update_order_status['apply_delete']=2;
                    if($list[$i]['pra_price'] && $list[$i]['pay_time']){
                        $update_order_status['status']=1;
                    }else{
                        $update_order_status['status']=0;
                    }
                }
                pdo_update('cqkundian_farm_shop_order',$update_order_status,array('uniacid'=>$uniacid,'id'=>$list[$i]['id']));

            }
        }
    }elseif($order_type==2){
        for ($i=0; $i < count($list); $i++) { 
            $order_detail=pdo_getall('cqkundian_farm_group_order_detail',array('uniacid'=>$uniacid,'order_id'=>$list[$i]['id']));
            $list[$i]['orderDetail']=$order_detail;
            $user=pdo_get('cqkundian_farm_user',array('uniacid'=>$uniacid,'uid'=>$list[$i]['uid']),array('nickname'));
            $list[$i]['nickname']=$user['nickname'];

            //兼容老版本订单信息
            if($list[$i]['status']>1){
                $update_order_status=array();
                if($list[$i]['status']==2){
                    $update_order_status['is_send']=1;
                    $update_order_status['status']=1;
                }elseif ($list[$i]['status']==3){
                    $update_order_status['is_send']=1;
                    $update_order_status['status']=1;
                    $update_order_status['is_confirm']=1;
                }elseif ($list[$i]['status']==4){
                    $update_order_status['apply_delete']=1;
                    $update_order_status['status']=1;
                }elseif ($list[$i]['status']==5){
                    $update_order_status['apply_delete']=2;
                    if($list[$i]['pra_price'] && $list[$i]['pay_time']){
                        $update_order_status['status']=1;
                    }else{
                        $update_order_status['status']=0;
                    }
                }
                if(!empty($update_order_status)){
                    pdo_update('cqkundian_farm_group_order',$update_order_status,array('uniacid'=>$uniacid,'id'=>$list[$i]['id'])); 
                }
            }
        }
    }elseif($order_type==3){
        for ($i=0; $i < count($list); $i++) { 
            $order_detail=pdo_getall('cqkundian_farm_integral_order_detail',array('uniacid'=>$uniacid,'order_id'=>$list[$i]['id']));
            $list[$i]['orderDetail']=$order_detail;
            $user=pdo_get('cqkundian_farm_user',array('uniacid'=>$uniacid,'uid'=>$list[$i]['uid']),array('nickname'));
            $list[$i]['nickname']=$user['nickname'];

            //兼容老版本订单信息
            if($list[$i]['status']>1){
                $update_order_status=array();
                if($list[$i]['status']==2){
                    $update_order_status['is_send']=1;
                    $update_order_status['status']=1;
                }elseif ($list[$i]['status']==3){
                    $update_order_status['is_send']=1;
                    $update_order_status['status']=1;
                    $update_order_status['is_confirm']=1;
                }elseif ($list[$i]['status']==4){
                    $update_order_status['apply_delete']=1;
                    $update_order_status['status']=1;
                }elseif ($list[$i]['status']==5){
                    $update_order_status['apply_delete']=2;
                    if($list[$i]['pra_price'] && $list[$i]['pay_time']){
                        $update_order_status['status']=1;
                    }else{
                        $update_order_status['status']=0;
                    }
                }
                if(!empty($update_order_status)){
                    pdo_update('cqkundian_farm_integral_order',$update_order_status,array('uniacid'=>$uniacid,'id'=>$list[$i]['id'])); 
                }
            }
        }
    }
    return $list;
}

/**
 * 整理订单状态信息
 * @param $orderData
 * @param $uniacid
 */
function neatenOrderStatus($orderData){
    if($orderData['apply_delete']==0) {
        if ($orderData['status'] == 0) {
            $orderData['status_txt'] = '未支付';
            $orderData['status_code']=0;
        } elseif ($orderData['status'] == 1 && $orderData['is_send'] == 0) {
            $orderData['status_txt'] = '已支付';
            $orderData['status_code']=1;
        } elseif ($orderData['status'] == 1 && $orderData['is_send'] == 1 && $orderData['is_confirm'] == 0) {
            $orderData['status_txt'] = '已发货';
            $orderData['status_code']=2;
        } elseif ($orderData['status'] == 1 && $orderData['is_send'] == 1 && $orderData['is_confirm'] == 1) {
            $orderData['status_txt'] = '已收货';
            $orderData['status_code']=3;
        }elseif ($orderData['status']==6) {
            $orderData['status_txt'] = '组团中';
            $orderData['status_code']=6;
        }
    }elseif($orderData['apply_delete']==1){
        $orderData['status_txt'] = '申请退款';
        $orderData['status_code']=4;
    }elseif ($orderData['apply_delete']==2){
        $orderData['status_txt'] = '已取消';
        $orderData['status_code']=5;
    }
    return $orderData;
}