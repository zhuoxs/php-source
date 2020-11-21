<?php

include 'lib/KdtApiClient.php';

function he_youzan_addcredic($appId,$appSecret,$openid,$credicnum) {

    $client = new KdtApiClient($appId, $appSecret);

    $method = 'kdt.shop.basic.get';

    $params = array(

        'weixin_openid' => $openid,

    );

    $res = $client->post($method);

    $sid = $res['response']['sid'];

    $method = 'kdt.users.weixin.follower.get';

    $user = $client->post($method, $params);

    $user_id = $user['response']['user']['user_id'];

    $params = array(

        'points' => $credicnum,

        'kdt_id' => $sid,

        'fans_id' => $user_id,

    );

    $method = 'kdt.crm.fans.points.payin.get';

    $ret = $client->post($method, $params);

    return $ret;

}

function he_youzan_addtags($appId,$appSecret,$openid,$tags) {

    $client = new KdtApiClient($appId, $appSecret);

    $method = 'kdt.users.weixin.follower.tags.add';

    $params = array(

        'weixin_openid' => $openid,

        'tags' => $tags,

    );

    $rets = $client->post($method, $params);

    return $rets;

}

function trimPx($data) {

    $data['left'] = intval(str_replace('px', '', $data['left'])) * 2;

    $data['top'] = intval(str_replace('px', '', $data['top'])) * 2;

    $data['width'] = intval(str_replace('px', '', $data['width'])) * 2;

    $data['height'] = intval(str_replace('px', '', $data['height'])) * 2;

    $data['size'] = intval(str_replace('px', '', $data['size'])) * 2;

    $data['src'] = tomedia($data['src']);

    return $data;

}



function mergeImage($target, $imgurl , $data) {

    $img = imagecreates($imgurl);

    $w = imagesx($img);

    $h = imagesy($img);

    imagecopyresized($target, $img, $data['left'], $data['top'], 0, 0, $data['width'], $data['height'], $w, $h);

    imagedestroy($img);

    return $target;

}

function mergeText($m,$target ,$text , $data,$reply) {

    $font = IA_ROOT . "/attachment/font/msyhbd.ttf";//字体文件
    $colors = hex2rgb($data['color']);
    $color = imagecolorallocate($target, $colors['red'], $colors['green'], $colors['blue']);
    imagettftext($target, $data['size'], 0, $data['left'], $data['top'] + $data['size'], $color, $font, $text);
    return $target;
}



function hex2rgb($colour) {

    if ($colour[0] == '#') {

        $colour = substr($colour, 1);

    }

    if (strlen($colour) == 6) {

        list($r, $g, $b) = array($colour[0] . $colour[1], $colour[2] . $colour[3], $colour[4] . $colour[5]);

    } elseif (strlen($colour) == 3) {

        list($r, $g, $b) = array($colour[0] . $colour[0], $colour[1] . $colour[1], $colour[2] . $colour[2]);

    } else {

        return false;

    }

    $r = hexdec($r);

    $g = hexdec($g);

    $b = hexdec($b);

    return array('red' => $r, 'green' => $g, 'blue' => $b);

}



/**合并图片

 * @param  $bg 背景图

 * @param  $qr 其他图

 * @param  $out 存放路径

 * @param $param 大小参数

 */

function mergeImage1($bgImg, $qr, $out, $param) {

    list($qrWidth, $qrHeight) = getimagesize($qr);

    $qrImg = imagecreates($qr);

    imagecopyresized($bgImg, $qrImg, $param['left'], $param['top'], 0, 0, $param['width'], $param['height'], $qrWidth, $qrHeight);

    ob_start();

    imagejpeg($bgImg, NULL, 100);

    $contents = ob_get_contents();

    ob_end_clean();

    imagedestroy($bgImg);

    imagedestroy($qrImg);

    $fh = fopen($out, "w+");

    fwrite($fh, $contents);

    fclose($fh);

}





/**创建图片

 * @param $bg 图片路径

 * @return

 */

function imagecreates($bg) {

    $bgImg = @imagecreatefromjpeg($bg);

    if (FALSE == $bgImg) {

        $bgImg = @imagecreatefrompng($bg);

    }

    if (FALSE == $bgImg) {

        $bgImg = @imagecreatefromgif($bg);

    }

    return $bgImg;

}



function saveImage($url) {

    $ch = curl_init ();

    curl_setopt ( $ch, CURLOPT_CUSTOMREQUEST, 'GET' );

    curl_setopt ( $ch, CURLOPT_SSL_VERIFYPEER, false );

    if(defined('CURLOPT_IPRESOLVE') && defined('CURL_IPRESOLVE_V4')){
        curl_setopt($ch, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4);
    }

    curl_setopt ( $ch, CURLOPT_URL, $url );

    ob_start ();

    curl_exec ( $ch );

    $return_content = ob_get_contents ();

    ob_end_clean ();

    $return_code = curl_getinfo ( $ch, CURLINFO_HTTP_CODE );

    $filename = IA_ROOT.'/attachment/images/temp'.time().rand(1000,9999).'.jpg';

    $fp= @fopen($filename,"a"); //将文件绑定到流 

    fwrite($fp,$return_content); //写入文件
    return $filename;
}



