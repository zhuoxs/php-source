<?php

/* 负责处理关键词回复 */
include 'huanghe_function.php';
//你这傻逼，你爸爸的代码好看吗，日你妈，MMB
class Responser {
  
  // 微信服务器保留图片3天，保险起见减去1个小时的提前量
  private static $WECHAT_MEDIA_EXPIRE_SEC = 255600; //(3 * 24 * 60 * 60 - 1 * 60 * 60) seconds; 3 days
  private static $Qrcode = "/addons/n1ce_mission/qrcode/mposter#sid#.jpg";
  private static $t_spread = "n1ce_mission_allnumber";
  function __construct() {
  }

  public function respondText($uniacid, $from_user, $rid, $rule ,$expire) {
    /* 用户请求传单算法
     * 1. 获得用户uid
     * 2. 立即通知用户正在生成二维码
     * 3. 查询qr表，如果
     *   3.1 uid在qr表中不存在，则立即创建二维码，并插入qr表，然后返回信息
     *   3.2 uid在qr表中存在，则直接返回信息(第二期需要判断二维码有效时间，如果超过3天，则需要重新上传，更新media_id到qr表
     * 4. 将qr信息推送给用户
     * 5. 结束本次请求
     */
    WeUtility::logging('step1', '');
    yload()->classs('n1ce_mission', 'wechatapi');
    yload()->classs('n1ce_mission', 'fans');
    yload()->classs('n1ce_mission', 'scene');
    $weapi = new WechatAPI();
    $_scene = new Scene();
    $_fans = new Fans();
    
    $fans = $_fans->refresh($from_user);
    $qr = $_scene->getQR($uniacid, $from_user, $rid);

    // 没有缓存， 或者缓存过期,二维码过期
    // TODO
    if(empty($qr)  or ($qr['createtime'] + self::$WECHAT_MEDIA_EXPIRE_SEC  < time()) or ($qr['createtime'] + $expire  < time()))
        // do: 3天后又来生成，应该重用老scene_id，再生再传 */
    {
      // 3.1 uid在qr表中不存在，则立即创建二维码，并插入qr表，然后返回信息
      //$scene_id =  $_scene->getNextAvaliableSceneID($weid) . 'china';
      if(empty($qr)){
        $scene_id =  $_scene->getNextAvaliableSceneID($uniacid);
      }else{
        $scene_id = $qr['scene_id'];
      }
      WeUtility::logging('getsuccess', array($scene_id));
      $media_id = $this->genImage($uniacid, $from_user,$weapi, $scene_id, $rid,$fans,$expire);
      if (empty($media_id)) {
        $ret = $weapi->sendText($from_user, '生成二维码传单失败, 请联系我们解决. ScID:' . $scene_id);
      } else if (!empty($scene_id)) {
        WeUtility::logging('begin setQR', array($scene_id));
        if(empty($qr)){
          $_scene->newQR($uniacid, $from_user, $scene_id,'', $media_id, $rid, $rule);
        }else{
          $_scene->updateQR($uniacid, $from_user, $scene_id, $media_id, $rid);
        }
        WeUtility::logging('end setQR', '');
      }
    } else {
      // 3.2 uid在qr表中存在，则直接返回信息
      $media_id = $qr['media_id'];
      WeUtility::logging("直接生成",$media_id);
    }
    // 4. 将qr信息推送给用户
    if (!empty($media_id)) {
      $ret = $weapi->sendImage($from_user, $media_id);
      $this->newSpreadUser($uniacid,$rid,$from_user);
    }
    WeUtility::logging('step4', array($media_id, $ret));
    // 5. 结束本次请求
    exit(0);
  }

  private function genImage($uniacid , $from_user, $weapi,$scene_id, $rid,$fans,$expire) {
    global $_W;
    yload()->classs('n1ce_mission', 'poster');
    yload()->classs('n1ce_mission','wechatutil');
    $_poster = new Poster();
    $ch = $_poster->get($rid);
    WeUtility::logging("开始生成图片",$ch);
    $qr_url = $weapi->getLimitQR($scene_id,$ch['posttype'],$from_user,$rid,$expire); 
    WeUtility::logging("结束生成图片",$qr_url);
    // 基础模式
    if (empty($ch['bg'])) {
      $ret = $weapi->sendText($from_user,'管理员未设置好海报,请联系公众号管理员设置海报背景！');
      exit(0);
    } else{
      //远程附件兼容
      if(iunserializer($ch['more_bg'])){
        $more_bg = iunserializer($ch['more_bg']);
        $cnt = count($more_bg);
        $ridx = rand(0, $cnt - 1);
        $ch['bg'] = $more_bg[$ridx];
      }
      $size = getimagesize(WechatUtil::tomedia($ch['bg']));
      $target = imagecreatetruecolor($size[0], $size[1]);
      $bg = imagecreates(WechatUtil::tomedia($ch['bg']));
      WeUtility::logging("大背景",array($size,$bg));
      imagecopy($target, $bg, 0, 0, 0, 0, $size[0], $size[1]);
      imagedestroy($bg);
      WeUtility::logging("step1",'bg write');
    }
    $data = json_decode(str_replace('&quot;', "'", $ch['data']), true);
    $qrcode = str_replace('#sid#', $from_user.$rid, IA_ROOT . self::$Qrcode);
    WeUtility::logging('生成前路径',$qrcode);
    // 扩展功能：昵称、头像、二维码
    foreach ($data as $value) {
      $value = trimPx($value);
      if ($value['type'] == 'qr') {
        if($ch['posttype'] == 2){
          
          if (!empty($qr_url)) {
            $img = IA_ROOT . "/addons/n1ce_mission/temp_qrcode".$from_user.".png";
            @fopen($img,"a");
            include IA_ROOT . "/addons/n1ce_mission/phpqrcode.php";
            $errorCorrectionLevel = "L";
            $matrixPointSize = "4";
            QRcode::png($qr_url, $img, $errorCorrectionLevel, $matrixPointSize, 2);
            WeUtility::logging('png',$img);
            mergeImage($target, $img, array('left' => $value['left'], 'top' => $value['top'], 'width' => $value['width'], 'height' => $value['height']));
            
            @unlink($img);
            WeUtility::logging("step2","borrow qr_url");
          }
        }else{
          mergeImage($target, saveImage($qr_url), array('left' => $value['left'], 'top' => $value['top'], 'width' => $value['width'], 'height' => $value['height']));
          WeUtility::logging("step2","not borrow qr_url");
        }
      } elseif ($value['type'] == 'img') {
        if($ch['img_type'] == 1){
          $img = save_yuan(yuan_img($fans['avatar'],'132'));
        }else{
          $img = saveImage($fans['avatar']);
        }
        mergeImage($target, $img, array('left' => $value['left'], 'top' => $value['top'], 'width' => $value['width'], 'height' => $value['height']));
        @unlink($img);
        WeUtility::logging("step3","write avatar");
      } elseif ($value['type'] == 'name') {
        $font = IA_ROOT . "/attachment/font/msyhbd.ttf";//字体文件
        mergeText($target, $fans['nickname'], array('size' => $value['size'], 'color' => $value['color'], 'left' => $value['left'], 'top' => $value['top']),$font);
        WeUtility::logging("step4",$font);
      }
    }
    imagejpeg($target, $qrcode, $ch['quality']);
    imagedestroy($target);
    WeUtility::logging('生成后路径',$qrcode);
    //上传素材
    $media_id = $weapi->uploadImage($qrcode);
    WeUtility::logging("media_id",array($media_id));
    @unlink($qrcode);
    return $media_id;
  }
  private function newSpreadUser($uniacid,$rid,$from_user){
    $spread = pdo_get(self::$t_spread,array('uniacid'=>$uniacid,'rid'=>$rid,'from_user'=>$from_user),array('id'));
    if(empty($spread['id'])){
      pdo_insert(self::$t_spread,array('uniacid'=>$uniacid,'from_user'=>$from_user,'rid'=>$rid,'createtime'=>time()));
    }
    return true;
  }
}
