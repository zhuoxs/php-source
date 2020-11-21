<?php

defined('IN_IA') or exit('Access Denied');

global $_GPC, $_W;

$weid = $_W['uniacid'];

$type = $_GPC['type'];



$basic = json_decode(pdo_getcolumn('hcdoudou_setting',array('only'=>'basic'.$weid),array('value')),'true');

if(empty($basic['tastefont'])){

    $basic['tastefont'] = '马上赢口红';

}

if(empty($basic['passfont'])){

    $basic['passfont'] ='点击我的口红领取';

}

$game = json_decode(pdo_getcolumn('hcdoudou_setting',array('only'=>'game'.$weid),array('value')),'true');



$game['number'][0] = empty($game['number'][0])?6:$game['number'][0];

$game['number'][1] = empty($game['number'][1])?8:$game['number'][1];

$game['number'][2] = empty($game['number'][2])?12:$game['number'][2];



$game['speed'][0] = empty($game['speed'][0])?'0.02':$game['speed'][0];

$game['speed'][1] = empty($game['speed'][1])?'0.03':$game['speed'][1];

$game['speed'][2] = empty($game['speed'][2])?'0.09':$game['speed'][2];



$game['usetime'][0] = empty($game['usetime'][0])?20:$game['usetime'][0];

$game['usetime'][1] = empty($game['usetime'][1])?30:$game['usetime'][1];

$game['usetime'][2] = empty($game['usetime'][2])?40:$game['usetime'][2];





if(empty($game['bgm'])){

    $game['bgm'] = $_W['siteroot'].'addons/hc_pdd/public/audio/bg_audio.mp3';

}

if(empty($game['insert'])){

    $game['insert'] = $_W['siteroot'].'addons/hc_pdd/public/audio/insert_audio.mp3';

}

if(empty($game['collision'])){

    $game['collision'] = $_W['siteroot'].'addons/hc_pdd/public/audio/collision_audio.mp3';

}

if(empty($game['passbgm'])){

    $game['passbgm'] = $_W['siteroot'].'addons/hc_pdd/public/audio/success_audio.mp3';

}

if(empty($game['succbgm'])){

    $game['succbgm'] = $_W['siteroot'].'addons/hc_pdd/public/audio/gameSuccess_audio.mp3';

}

if(empty($game['times'])){

    $game['times'] = $_W['siteroot'].'addons/hc_pdd/public/audio/Countdown_10s_audio.mp3';

}

if(empty($game['failbgm'])){

    $game['failbgm'] = $_W['siteroot'].'addons/hc_pdd/public/audio/gameFail_audio.mp3';

}

if(empty($game['split'])){

    $game['split'] = $_W['siteroot'].'addons/hc_pdd/public/audio/split_audio.mp3';

}

if(empty($game['gamebg'])){

    $game['gamebg'] = $_W['siteroot'].'addons/hc_pdd/public/img/bg.jpg';

}

if(empty($game['timesbg'])){

    $game['timesbg'] = $_W['siteroot'].'addons/hc_pdd/public/img/timebox_bg.png';

}

if(empty($game['customspass'])){

    $game['customspass'][0] = $_W['siteroot'].'addons/hc_pdd/public/img/level_1_main.jpg';

    $game['customspass'][1] = $_W['siteroot'].'addons/hc_pdd/public/img/level_2_mains.jpg';

    $game['customspass'][2] = $_W['siteroot'].'addons/hc_pdd/public/img/level_3_mains.jpg';

}

if(empty($game['passicon'])){

    $game['passicon'][0] = $_W['siteroot'].'addons/hc_pdd/public/img/level_icon_1_active.png';

    $game['passicon'][1] = $_W['siteroot'].'addons/hc_pdd/public/img/level_icon_2.png';

    $game['passicon'][2] = $_W['siteroot'].'addons/hc_pdd/public/img/level_icon_2_active.png';

    $game['passicon'][3] = $_W['siteroot'].'addons/hc_pdd/public/img/level_icon_3.png';

    $game['passicon'][4] = $_W['siteroot'].'addons/hc_pdd/public/img/level_icon_3_active.png';

    $game['passicon'][5] = $_W['siteroot'].'addons/hc_pdd/public/img/level_3.png';

}

if(empty($game['first'])){

    $game['first'][0] = $_W['siteroot'].'addons/hc_pdd/public/img/Sword_small_1_gray.png';

    $game['first'][1] = $_W['siteroot'].'addons/hc_pdd/public/img/Sword_small_1.png';

    $game['first'][2] = $_W['siteroot'].'addons/hc_pdd/public/img/Lipstick_1.png';

}

if(empty($game['first_dial'])){

    $game['first_dial'][0] = $_W['siteroot'].'addons/hc_pdd/public/img/CircleCenter_1.png';

    $game['first_dial'][1] = $_W['siteroot'].'addons/hc_pdd/public/img/CircleCenter_1_split_left.png';

    $game['first_dial'][2] = $_W['siteroot'].'addons/hc_pdd/public/img/CircleCenter_1_split_right.png';

}



if(empty($game['second'])){

    $game['second'][0] = $_W['siteroot'].'addons/hc_pdd/public/img/Sword_small_2_gray.png';

    $game['second'][1] = $_W['siteroot'].'addons/hc_pdd/public/img/Sword_small_2.png';

    $game['second'][2] = $_W['siteroot'].'addons/hc_pdd/public/img/Lipstick_2.png';

}

if(empty($game['second_dial'])){

    $game['second_dial'][0] = $_W['siteroot'].'addons/hc_pdd/public/img/CircleCenter_2.png';

    $game['second_dial'][1] = $_W['siteroot'].'addons/hc_pdd/public/img/CircleCenter_2_split_right.png';

    $game['second_dial'][2] = $_W['siteroot'].'addons/hc_pdd/public/img/CircleCenter_2_split_left.png';

}



if(empty($game['third'])){

    $game['third'][0] = $_W['siteroot'].'addons/hc_pdd/public/img/Sword_small_3_gray.png';

    $game['third'][1] = $_W['siteroot'].'addons/hc_pdd/public/img/Sword_small_3.png';

    $game['third'][2] = $_W['siteroot'].'addons/hc_pdd/public/img/Lipstick_3.png';

}

if(empty($game['third_dial'])){

    $game['third_dial'][0] = $_W['siteroot'].'addons/hc_pdd/public/img/CircleCenter_3.png';

    $game['third_dial'][1] = $_W['siteroot'].'addons/hc_pdd/public/img/CircleCenter_3_split_left.png';

    $game['third_dial'][2] = $_W['siteroot'].'addons/hc_pdd/public/img/CircleCenter_3_split_right.png';

}

foreach ($game as $key => $val) {

    if(is_array($val)){

        foreach ($val as $k => $v) {

            if(strpos($v,'images') !== false || strpos($v,'audios') !== false || strpos($v,'videos') !== false){

                $game[$key][$k] = tomedia($v);

            }

        } 

    }else{

        if(strpos($val,'images') !== false || strpos($val,'audios') !== false || strpos($val,'videos') !== false){

            $game[$key] = tomedia($val);

        }

    }

}

if($type==1){

	$gid  = $_GPC['gid'];

    $uid  = $_COOKIE['uid'];



    $goods = pdo_get('hcdoudou_goods',array('id'=>$gid));

    $users = pdo_get('hcdoudou_users',array('uid'=>$uid));

    if($users['money']<$goods['price']){

        exit('<script>alert("余额不足！");location.href="'.$_W['siteroot'].'/app/index.php?i='.$weid.'&c=entry&do=index&m=hc_pdd"</script>');

    }

    $trade_no = date('YmdHis').rand(100000,999999);

    $params = array(

        'weid'     => $weid,

        'gid'      => $gid,

        'uid'      => $uid,

        'openid'   => $users['openid'],

        'title'    => $goods['title'],

        'trade_no' => $trade_no,

        'price'    => $goods['price'],

        'createtime'=>time(),

    );

    $res = pdo_insert('hcdoudou_order',$params);



    setcookie('orderId',$trade_no);

    setcookie('ajaxurl',$this->createMobileUrl('result'));



    pdo_update('hcdoudou_users',array('money'=>$users['money']-$goods['price']),array('uid'=>$uid));



    include $this->template('play');

}else{

	include $this->template('taste');

}

