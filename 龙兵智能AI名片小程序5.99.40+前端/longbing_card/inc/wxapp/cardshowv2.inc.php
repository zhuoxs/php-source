<?php
//  直接展示名片信息


define( 'ROOT_PATH', IA_ROOT . '/addons/longbing_card/' );
is_file( ROOT_PATH . '/inc/we7.php' ) or exit( 'Access Denied Longbing' );
require_once ROOT_PATH . '/inc/we7.php';

global $_GPC, $_W;

$time = time();

$to_uid  = $_GPC[ 'to_uid' ];
$user_id = $_GPC[ 'user_id' ];
$uniacid = $_W[ 'uniacid' ];


$data      = [
    'user_id' => $user_id,
    'to_uid'  => $to_uid,
    //    'type'    => 2,
    //    'uniacid' => $_W[ 'uniacid' ],
    //    'target'  => '',
    //    'sign'    => 'praise',
    //    'scene'   => $_GPC[ 'scene' ],
];
$redis_key = 'longbing_cardshowv2' . $to_uid . '_' . $_W[ 'uniacid' ];
$cacheData = cache_load( $redis_key );

//  缓存里面有数据从缓存里面取
if ( $cacheData && false ) {

    if ( $data2 ) {
        $data2 = json_decode( $data2, true );

        foreach ( $data as $k => $v ) {
            $cacheData[ $k ] = $v;
        }
        $cacheData[ 'from_redis' ] = 2;
        $data                      = $cacheData;
        return $this->result( 0, 'redis', $data );
    }
}


//  当前员工的名片信息
$cardInfo = pdo_get( 'longbing_card_user_info', [
        'fans_id'  => $to_uid,
        'uniacid'  => $_W[ 'uniacid' ],
        'is_staff' => 1
    ]
);
if ( !$cardInfo || empty( $cardInfo ) ) {
    return $this->result( -2, 'card not found', [] );
}


//  员工所属公司信息
$cardInfo[ 'myCompany' ] = [];
//  选择了公司的情况下
if ( $cardInfo[ 'company_id' ] ) {
    $com = pdo_get( 'longbing_card_company', [
            'uniacid' => $uniacid,
            'id'      => $cardInfo[ 'company_id' ],
            'status'  => 1
        ]
    );
    if ( !$com ) {
        $com = pdo_get( 'longbing_card_company', [
                'uniacid' => $_W[ 'uniacid' ],
                'status'  => 1
            ]
        );
    }
    if ( $com ) {
        $com[ 'logo' ] = $this->transImage( $com[ 'logo' ] );
        $com[ 'logo' ] = str_replace( 'ttp://', 'ttps://', $com[ 'logo' ] );
        if ( !strstr( $com[ 'logo' ], 'ttps://' ) ) {
            $com[ 'logo' ] = 'https://' . $com[ 'logo' ];
        }
        $cardInfo[ 'myCompany' ] = $com;
    }
}
//  员工未选择公司时使用第一个公司
else {
    $com = pdo_get( 'longbing_card_company', [
            'uniacid' => $_W[ 'uniacid' ],
            'status'  => 1
        ]
    );
    if ( $com ) {
        $com[ 'logo' ] = $this->transImage( $com[ 'logo' ] );
        $com[ 'logo' ] = str_replace( 'ttp://', 'ttps://', $com[ 'logo' ] );
        if ( !strstr( $com[ 'logo' ], 'ttps://' ) ) {
            $com[ 'logo' ] = 'https://' . $com[ 'logo' ];
        }
        $cardInfo[ 'myCompany' ] = $com;
    }
}

//  处理公司地址
if ( !empty( $cardInfo[ 'myCompany' ] ) ) {
    if ( mb_strlen( $cardInfo[ 'myCompany' ][ 'addr' ], 'utf8' ) > 18 ) {
        $cardInfo[ 'myCompany' ][ 'addrMore' ] = mb_substr( $cardInfo[ 'myCompany' ][ 'addr' ], 0, 43, "UTF-8" ) . '...';
    }
    else {
        $cardInfo[ 'myCompany' ][ 'addrMore' ] = $cardInfo[ 'myCompany' ][ 'addr' ];
    }
}


//  处理多媒体文件
if ( $cardInfo[ 'avatar' ] ) {

    $tmp                    = $cardInfo[ 'avatar' ];
    $cardInfo[ 'avatar' ]   = tomedia( $tmp );
    $cardInfo[ 'vr_cover' ] = tomedia( $cardInfo[ 'vr_cover' ] );

    //    $cardInfo[ 'avatar' ] = str_replace( 'ttp://', 'ttps://', $cardInfo[ 'avatar' ] );
    //    if ( !strstr( $cardInfo[ 'avatar' ], 'ttps://' ) ) {
    //        $cardInfo[ 'avatar' ] = 'https://' . $cardInfo[ 'avatar' ];
    //    }
}
if ( $cardInfo[ 'my_video' ] ) {
    $cardInfo[ 'my_video' ]     = tomedia( $cardInfo[ 'my_video' ] );
    $cardInfo[ 'my_video_vid' ] = lbSingleGetTencentVideo( $cardInfo[ 'my_video' ]  );
}
if ( $cardInfo[ 'my_video_cover' ] ) {
    $cardInfo[ 'my_video_cover' ] = tomedia( $cardInfo[ 'my_video_cover' ] );
}
if ( $cardInfo[ 'bg' ] ) {
    $cardInfo[ 'bg' ] = tomedia( $cardInfo[ 'bg' ] );
}


$cardInfo[ 'voice' ] = tomedia( $cardInfo[ 'voice' ] );
$images              = $cardInfo[ 'images' ];
$images              = trim( $images, ',' );
$images              = explode( ',', $images );
$tmp                 = [];
foreach ( $images as $k2 => $v2 ) {
    $tmpUrl = tomedia( $v2 );
    array_push( $tmp, $tmpUrl );
}
$cardInfo[ 'images' ]   = $tmp;
$job                    = pdo_get( 'longbing_card_job', [
        'id'      => $cardInfo[ 'job_id' ],
        'uniacid' => $_W[ 'uniacid' ],
        'status'  => 1
    ]
);
$cardInfo[ 'job_name' ] = $job ? $job[ 'name' ] : '暂无职称';

//  分享文案
$short_name_tmp = $cardInfo[ 'myCompany' ][ 'short_name' ] ? $cardInfo[ 'myCompany' ][ 'short_name' ] : $cardInfo[ 'myCompany' ][ 'name' ];
if ( $cardInfo[ 'share_text' ] ) {
    $cardInfo[ 'share_text' ] = str_replace( '$company', $short_name_tmp, $cardInfo[ 'share_text' ] );
    $cardInfo[ 'share_text' ] = str_replace( '#公司#', $short_name_tmp, $cardInfo[ 'share_text' ] );
    $cardInfo[ 'share_text' ] = str_replace( '$job', $cardInfo[ 'job_name' ], $cardInfo[ 'share_text' ] );
    $cardInfo[ 'share_text' ] = str_replace( '#职务#', $cardInfo[ 'job_name' ], $cardInfo[ 'share_text' ] );
    $cardInfo[ 'share_text' ] = str_replace( '$name', $cardInfo[ 'name' ], $cardInfo[ 'share_text' ] );
    $cardInfo[ 'share_text' ] = str_replace( '#我的名字#', $cardInfo[ 'name' ], $cardInfo[ 'share_text' ] );
}
else {
    $cardInfo[ 'share_text' ] = "您好，我是{$short_name_tmp}的{$cardInfo['job_name']}{$cardInfo['name']}，请惠存。";
}


$data[ 'info' ] = $cardInfo;


//  主推商品
$extension = pdo_getall( 'longbing_card_extension', [ 'user_id' => $to_uid ], [ 'goods_id' ] );
//if ($to_uid == 55275)
//{
//    echo '<pre>';
//    var_dump($extension);
//    die;
//}
if ( !$extension ) {
    $data[ 'goods' ] = [];
}
else {
    $ids = [];
    foreach ( $extension as $k => $v ) {
        array_push( $ids, $v[ 'goods_id' ] );
    }
    $ids = implode( ',', $ids );
    if ( count( $extension ) > 1 ) {
        $ids = '(' . $ids . ')';

        $sql = "SELECT id,`name`,cover,price,status,unit FROM " . tablename( 'longbing_card_goods' ) . " WHERE id IN {$ids} && status = 1 ORDER BY top DESC";
    }
    else {
        $sql = "SELECT id,`name`,cover,price,status,unit FROM " . tablename( 'longbing_card_goods' ) . " WHERE id = {$ids} && status = 1 ORDER BY top DESC";
    }

    $goods = pdo_fetchall( $sql );

    foreach ( $goods as $k => $v ) {
        $goods[ $k ][ 'cover' ] = tomedia( $v[ 'cover' ] );
    }

    $data[ 'goods' ] = $goods;
}


//  判断主推商品是否显示
if ( !empty( $data[ 'goods' ] ) || $data[ 'goods' ] ) {
    $tabbar_info = pdo_get( 'longbing_card_tabbar', [ 'uniacid' => $_W[ 'uniacid' ] ] );

    if ( $tabbar_info ) {
        if ( $tabbar_info[ 'menu2_is_hide' ] ) {
            $auth_info = false;
            //  管理端版权
            $checkExists = pdo_tableexists( 'longbing_cardauth2_config' );
            if ( $checkExists ) {
                $auth_info = pdo_get( 'longbing_cardauth2_config', [ 'modular_id' => $_W[ 'uniacid' ] ] );
                if ( $auth_info && isset( $auth_info[ 'shop_switch' ] ) && $auth_info[ 'shop_switch' ] == 0 ) {
                    $data[ 'goods' ] = [];
                }
            }

        }
        else {
            $data[ 'goods' ] = [];
        }
    }
}


$info = pdo_get( 'longbing_card_user', [
        'id'      => $to_uid,
        'uniacid' => $uniacid
    ]
);

//  员工名片码
if ( $info[ 'qr_path' ] ) {
    @$size = filesize( ATTACHMENT_ROOT . '/' . $info[ 'qr_path' ] );

    if ( $size > 51220 )  // 大于5k, 用户判断图片是否正确
    {
        $imageUrl     = tomedia( $info[ 'qr_path' ] );
        $data[ 'qr' ] = $imageUrl;
    }
    else {
        //                @require_once(IA_ROOT . '/framework/function/file.func.php');
        load()->func( 'file' );

        if ( !is_dir( ATTACHMENT_ROOT . '/' . "images" ) ) {
            mkdir( ATTACHMENT_ROOT . '/' . "images" );
        }
        if ( !is_dir( ATTACHMENT_ROOT . '/' . "images/card_qr" ) ) {
            mkdir( ATTACHMENT_ROOT . '/' . "images/card_qr" );
        }
        if ( !is_dir( ATTACHMENT_ROOT . '/' . "images/card_qr/$uniacid" ) ) {
            mkdir( ATTACHMENT_ROOT . '/' . "images/card_qr/$uniacid" );
        }

        $destination_folder = ATTACHMENT_ROOT . '/images' . "/card_qr/$uniacid";

        $imageName = $user_id . '_' . $to_uid . '_' . $uniacid . '.png';
        $image     = $destination_folder . '/' . $imageName;
        $path      = "longbing_card/pages/index/index";

        $imageUrl = $_W[ 'siteroot' ] . $_W[ 'config' ][ 'upload' ][ 'attachdir' ] . '/images' . "/card_qr/$uniacid/" . $imageName;

        $scene    = "$to_uid&$user_id&0&1&toCard";
        $mkResult = lbSingleMkQr( $imageName, $image, $uniacid, $scene, $path );

    }
}
else {
    load()->func( 'file' );

    if ( !is_dir( ATTACHMENT_ROOT . '/' . "images" ) ) {
        mkdir( ATTACHMENT_ROOT . '/' . "images" );
    }
    if ( !is_dir( ATTACHMENT_ROOT . '/' . "images/card_qr" ) ) {
        mkdir( ATTACHMENT_ROOT . '/' . "images/card_qr" );
    }
    if ( !is_dir( ATTACHMENT_ROOT . '/' . "images/card_qr/$uniacid" ) ) {
        mkdir( ATTACHMENT_ROOT . '/' . "images/card_qr/$uniacid" );
    }

    $destination_folder = ATTACHMENT_ROOT . '/images' . "/card_qr/$uniacid";

    $imageName = $user_id . '_' . $to_uid . '_' . $uniacid . '.png';
    $image     = $destination_folder . '/' . $imageName;
    $path      = "longbing_card/pages/index/index";

    $imageUrl = $_W[ 'siteroot' ] . $_W[ 'config' ][ 'upload' ][ 'attachdir' ] . '/images' . "/card_qr/$uniacid/" . $imageName;

    $scene    = "$to_uid&$user_id&0&1&toCard";
    $mkResult = lbSingleMkQr( $imageName, $image, $uniacid, $scene, $path );
}

$imageUrl = str_replace( 'ttp://', 'ttps://', $imageUrl );
if ( !strstr( $imageUrl, 'ttps://' ) ) {
    $imageUrl = 'https://' . $imageUrl;
}
$data[ 'qr' ] = $imageUrl;


$data[ 'share_img' ] = '';
if ( file_exists( ATTACHMENT_ROOT . '/' . "images/share_img/{$_W['uniacid']}/share-{$to_uid}.png" ) ) {
    @$size = filesize( ATTACHMENT_ROOT . '/' . "images/share_img/{$_W['uniacid']}/share-{$to_uid}.png" );

    if ( $size > 51220 )  // 大于5k, 用户判断图片是否正确
    {
        $fileName            = "images/share_img/{$_W['uniacid']}/share-{$to_uid}.png";
        $data[ 'share_img' ] = $_W[ 'siteroot' ] . $_W[ 'config' ][ 'upload' ][ 'attachdir' ] . '/' . $fileName;
    }
    else {
        @unlink( ATTACHMENT_ROOT . '/' . "images/share_img/{$_W['uniacid']}/share-{$to_uid}.png" );
    }

}


$res = cache_write( $redis_key, $data );

$data[ 'info' ][ 'avatar_2' ] = $data[ 'info' ][ 'avatar' ];

$imageName   = $user_id . '_' . $to_uid . '_' . $uniacid . '_avatar_qr_v2.png';
$qrAvatarUrl = $_W[ 'siteroot' ] . $_W[ 'config' ][ 'upload' ][ 'attachdir' ] . '/images' . "/avatar_qr/$uniacid/$to_uid/" . $imageName;

$qrAvatarUrl = str_replace( 'ttp://', 'ttps://', $qrAvatarUrl );
if ( !strstr( $qrAvatarUrl, 'ttps://' ) ) {
    $qrAvatarUrl = 'https://' . $qrAvatarUrl;
}
$data[ 'avatar_qr' ] = $qrAvatarUrl;


//  先返回给前端数据, 在执行生成分享图片等操作
//echo json_encode( array(
//    'errno'   => 0,
//    'message' => '请求成功',
//    'data'    => $data
//), JSON_UNESCAPED_UNICODE
//);

//直接输出
//if ( function_exists( 'fastcgi_finish_request' ) ) {
//    @fastcgi_finish_request();
//}


//  画名片头像小程序码
if ( !is_dir( ATTACHMENT_ROOT . '/' . "images" ) ) {
    mkdir( ATTACHMENT_ROOT . '/' . "images" );
}
if ( !is_dir( ATTACHMENT_ROOT . '/' . "images/avatar_qr" ) ) {
    mkdir( ATTACHMENT_ROOT . '/' . "images/avatar_qr" );
}
if ( !is_dir( ATTACHMENT_ROOT . '/' . "images/avatar_qr/$uniacid" ) ) {
    mkdir( ATTACHMENT_ROOT . '/' . "images/avatar_qr/$uniacid" );
}
if ( !is_dir( ATTACHMENT_ROOT . '/' . "images/avatar_qr/$uniacid/$to_uid" ) ) {
    mkdir( ATTACHMENT_ROOT . '/' . "images/avatar_qr/$uniacid/$to_uid" );
}

$imageName     = $user_id . '_' . $to_uid . '_' . $uniacid . '_avatar_qr_v2.png';
$localAvatarQr = ATTACHMENT_ROOT . '/' . "images/avatar_qr/$uniacid/$to_uid/" . $imageName;
$qrAvatarUrl   = $_W[ 'siteroot' ] . $_W[ 'config' ][ 'upload' ][ 'attachdir' ] . '/images' . "/card_qr/$uniacid/" . $imageName;

$avatar  = $data[ 'info' ][ 'avatar' ];
$qrImage = $data[ 'qr' ];


function img_exits($url){
    $ch = curl_init();
    curl_setopt($ch, curlopt_url,$url);
    curl_setopt($ch, curlopt_nobody, 1); // 不下载
    curl_setopt($ch, curlopt_failonerror, 1);
    curl_setopt($ch, curlopt_returntransfer, 1);
    if(curl_exec($ch)!==false)
        return true;
    else
        return false;
}


if ( !file_exists($image) || !img_exits($avatar) || !img_exits($qrImage )  ) {
    $data[ 'avatar_qr' ] = $data[ 'qr' ];
    return $this->result( 0, '请求成功', $data );
}

if ( !$avatar || !$qrImage ) {
    $data[ 'avatar_qr' ] = $data[ 'qr' ];
    return $this->result( 0, '请求成功', $data );
}

//  检查图片是否可用
$checkAvatarEx = file_get_contents( $avatar );
$checkQrEx     = file_get_contents( $qrImage );

if (!$checkAvatarEx || !$checkQrEx)
{
    $data[ 'avatar_qr' ] = $data[ 'qr' ];
    return $this->result( 0, '请求成功', $data );
}


$config = pdo_get( 'longbing_card_config', [ 'uniacid' => $uniacid ] );

if ( !$config || !isset( $config[ 'qr_avatar_switch' ] ) || $config[ 'qr_avatar_switch' ] == 0 ) {
    $data[ 'avatar_qr' ] = $data[ 'qr' ];
    return $this->result( 0, '请求成功', $data );
}



//  先返回给前端数据, 在执行生成分享图片等操作
echo json_encode( array(
    'errno'   => 0,
    'message' => '请求成功',
    'data'    => $data
), JSON_UNESCAPED_UNICODE
);

//直接输出
if ( function_exists( 'fastcgi_finish_request' ) ) {
    @fastcgi_finish_request();
}




$img = lbSingleYuanImg( $avatar );

$extAvatar = lbSingleGetImageExt( $avatar );
$local     = ROOT_PATH . '/inc/test' . rand( 10000, 99999 ) . '.' . $extAvatar;
imagepng( $img, $local );


$im = imagecreatetruecolor( 430, 430 );

//填充画布背景色
$color = imagecolorallocate( $im, 255, 255, 255 );
imagefill( $im, 0, 0, $color );


// 画背景二维码
$result = getimagesize( $qrImage );
$l_w1   = $result[ 0 ];
$l_h1   = $result[ 1 ];
$mime   = $result[ 'mime' ];
if ( $mime == 'image/png' ) {
    $qr = imagecreatefrompng( $qrImage );
}
else if ( $mime == 'image/jpeg' ) {
    $qr = imagecreatefromjpeg( $qrImage );
}
else {
    die;
}

imagecopyresized( $im, $qr, 0, 0, 0, 0, 430, 430, $l_w1, $l_h1 );


// 画中间头像
$result = getimagesize( $local );
$l_w1   = $result[ 0 ];
$l_h1   = $result[ 1 ];
$mime   = $result[ 'mime' ];
if ( $mime == 'image/png' ) {
    $avatar = imagecreatefrompng( $local );
}
else if ( $mime == 'image/jpeg' ) {
    $avatar = imagecreatefromjpeg( $local );
}
else {
    die;
}

imagecopyresized( $im, $avatar, 120, 120, 0, 0, 190, 190, $l_w1, $l_h1 );

//Header( "Content-Type: image/png" );

imagepng( $im, $localAvatarQr );
imagedestroy( $im );

@unlink( $local );

return $this->result( 0, '请求成功', $data );
